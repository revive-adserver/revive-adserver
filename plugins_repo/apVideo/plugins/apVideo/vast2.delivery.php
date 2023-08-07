<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/plugins/apVideo/lib/Dal/Delivery.php';

$_REQUEST['format'] = $_GET['format'] = 'vast';
$_REQUEST['nz'] = $_GET['nz'] = 1;
$_REQUEST['zones'] = $_GET['zones'] = 'pre-roll=' . (int)$zoneid;

$skipOffset = (int) ($_GET['skipoffset'] ?? 0);

ob_start();
require MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/vastInlineHtml.delivery.php';
$old = ob_get_clean();

// Safely deals with CORS
if (!empty($_SERVER['HTTP_ORIGIN']) && preg_match('#^https?://[a-z0-9.-]+(:\d+)?$#Di', $_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
}

// Replace container tag
$old = preg_replace('#^.*<VideoAdServingTemplate.*?>#s', <<<EOF
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<VAST version="2.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="vast.xsd">
EOF
, $old);
$old = str_replace('</VideoAdServingTemplate>', '</VAST>', $old);

// Deal with multiple impression URL tags
if (preg_match('#\s*<Impression.*?>\s*(.*)\s*</Impression>\s*#s', $old, $m)) {
    $old = str_replace($m[0], preg_replace('#(</?)URL#', '$1Impression', $m[1]), $old);
}

// Remove URL and Code tags
$old = preg_replace('#\s*<(URL|Code).*?>\s*(.*?)\s*</\\1>\s*#s', '$2', $old);

// Wrapper change
$old = str_replace('VASTAdTagURL', 'VASTAdTagURI', $old);

// Shuffle various things around
$vast = new DOMDocument();
$vast->loadXML($old);

$video = $vast->getElementsByTagName('Video')->item(0);
$nonlinearads = $vast->getElementsByTagName('NonLinearAds')->item(0);
$companionads = $vast->getElementsByTagName('CompanionAds')->item(0);
$wrapper = $vast->getElementsByTagName('Wrapper')->item(0);

// Gracefully fail if not a VAST zone
if (empty($video) && empty($wrapper) && empty($nonlinearads)) {
    header("Content-Type: text/xml");
    echo $old;
    exit;
}

$creatives = $vast->createElement('Creatives');
$creative = $vast->createElement('Creative');
$creatives->appendChild($creative);

if (!empty($video)) {
    // Regular in-line ad
    $linear = $vast->createElement('Linear');
    $creative->appendChild($linear);
    $video->parentNode->replaceChild($creatives, $video);

    // Skip offset?
    if ($skipOffset > 0) {
        $epoch = new \DateTimeImmutable('@0');
        $diff = $epoch->add(new \DateInterval("PT{$skipOffset}S"))->diff($epoch);

        $linear->setAttribute('skipoffset', $diff->format('%H:%I:%S'));
    }

    $creative->setAttribute('sequence', '1');
    $creative->setAttribute(
        'id',
        $adId = $video->removeChild($video->getElementsByTagName('AdID')->item(0))->nodeValue
    );

    foreach ($video->childNodes as $node) {
        $linear->appendChild($node->cloneNode(true));
    }

    $aDetails = AP_Video_Dal_Delivery::cacheGetAdDetails($adId);
    if ($mediaFile = $creative->getElementsByTagName('MediaFile')->item(0)) {
        if (!empty($aDetails['alt_media'])) {
            $mainType = $mediaFile->getAttribute('type');
            foreach ($aDetails['alt_media'] as $type => $url) {
                if ($type != $mainType) {
                    $newMediaFile = $mediaFile->cloneNode();
                    $newMediaFile->setAttribute('type', $type);
                    $newMediaFile->setAttribute('delivery', 'progressive');
                    $newUrl = new DOMCdataSection($url);
                    $newMediaFile->appendChild($newUrl);
                    $mediaFile->parentNode->appendChild($newMediaFile);
                }
            }
        }

        // Additional trackers
        if (!empty($aDetails['impression_trackers'])) {
            $impression = $vast->getElementsByTagName('Impression')->item(0);

            foreach ($aDetails['impression_trackers'] as $k => $url) {
                $newImpression = $impression->cloneNode();
                $newImpression->setAttribute('id', 'additional-' . $k);
                $newUrl = new DOMCdataSection($url);
                $newImpression->appendChild($newUrl);

                if (!empty($impression->nextSibling)) {
                    $impression->parentNode->insertBefore($newImpression, $impression->nextSibling);
                } else {
                    $impression->parentNode->appendChild($newImpression);
                }
            }
        }
    }
}

if (!empty($nonlinearads)) {
    // Non-linear
    $nonlinearads->parentNode->replaceChild($creatives, $nonlinearads);
    $creative->appendChild($nonlinearads);
}

if (!empty($companionads)) {
    // Companion
    $companionads->parentNode->removeChild($companionads);

    $creative = $vast->createElement('Creative');
    $creative->setAttribute('sequence', '1');
    $creative->appendChild($companionads);
    $creatives->appendChild($creative);
}

foreach (['Companion', 'NonLinear'] as $tag) {
    foreach ($vast->getElementsByTagName($tag) as $el) {
        $resourceType = $el->getAttribute('resourceType');
        $el->removeAttribute('resourceType');

        $creativeType = $el->getAttributeNode('creativeType');
        if ($creativeType) {
            $el->removeAttributeNode($creativeType);
        }

        $content = clone($el->firstChild);

        switch ($resourceType) {
            case 'static':
                $child = $vast->createElement('StaticResource');
                $child->setAttributeNode($creativeType);
                break;
            case 'HTML':
                $child = $vast->createElement('HTMLResource');
                break;
            case 'iframe':
                $child = $vast->createElement('IFrameResource');
                break;
        }

        $child->appendChild($content);
        $el->replaceChild($child, $el->firstChild);
    }
}

if (!empty($wrapper)) {
    // Wrapper ad
    $linear = $vast->createElement('Linear');
    $linear->appendChild($wrapper->removeChild($wrapper->getElementsByTagName('VideoClicks')->item(0)));
    $creative->appendChild($linear);
    $wrapper->appendChild($creatives);
}

// Tracking events
if ($events = $vast->getElementsByTagName('TrackingEvents')->item(0)) {
    $linear->appendChild($events->parentNode->removeChild($events));
}

// Remove Content-Length sent by versions < 3.1
header_remove("Content-Length");

header("Content-Type: text/xml");
$output = $vast->saveXml();

echo $output;
