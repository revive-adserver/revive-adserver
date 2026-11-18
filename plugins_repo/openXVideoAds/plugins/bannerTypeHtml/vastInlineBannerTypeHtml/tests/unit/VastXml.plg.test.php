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

require_once dirname(__DIR__, 2) . '/commonDelivery.php';

class Plugins_TestOfVastXml extends UnitTestCase
{
    private function getOutputParams(): array
    {
        $params = array_fill_keys([
            'trackUrlStart', 'trackUrlMidPoint', 'trackUrlFirstQuartile', 'trackUrlThirdQuartile',
            'trackUrlComplete', 'trackUrlMute', 'trackUrlPause', 'trackReplay',
            'trackUrlFullscreen', 'trackUrlStop', 'trackUrlUnmute', 'trackUrlResume',
        ], 'https://example.test/track');

        return $params + [
            'name' => 'Video ad',
            'impressionUrl' => 'https://example.test/impression',
            'vastVideoDuration' => '00:00:15',
            'vastVideoId' => '1',
            'vastVideoClickThroughUrl' => 'https://example.test/click',
            'vastVideoDelivery' => 'progressive',
            'vastVideoBitrate' => '400',
            'vastVideoWidth' => '640',
            'vastVideoHeight' => '480',
            'vastVideoType' => 'video/mp4',
            'fullPathToVideo' => 'https://example.test/video.mp4',
        ];
    }

    private function render(array $params): DOMDocument
    {
        $document = new DOMDocument();
        $this->assertTrue($document->loadXML('<Root>' . renderVastOutput($params, 'vastInline', 'Inline Video Ad') . '</Root>'));
        return $document;
    }

    public function testVideoAttributeCannotInjectTrackingEvents()
    {
        $params = $this->getOutputParams();
        $params['vastVideoBitrate'] = '400"/></MediaFiles><TrackingEvents><Tracking event="start"><![CDATA[https://attacker.example/start]]></Tracking></TrackingEvents><MediaFiles><MediaFile z="';

        $document = $this->render($params);
        $this->assertEqual($document->getElementsByTagName('TrackingEvents')->length, 1);
        $this->assertEqual($document->getElementsByTagName('MediaFile')->item(0)->getAttribute('bitrate'), $params['vastVideoBitrate']);
    }

    public function testAdTitleCannotTerminateCdata()
    {
        $params = $this->getOutputParams();
        $params['name'] = 'Video]]><Injected/>';

        $document = $this->render($params);
        $this->assertEqual($document->getElementsByTagName('AdTitle')->item(0)->textContent, $params['name']);
        $this->assertEqual($document->getElementsByTagName('Injected')->length, 0);
    }

    public function testCompanionMarkupRetainsCdataTerminatorAsText()
    {
        $params = $this->getOutputParams();
        $params['companionMarkup'] = '<b>Before]]>After</b>';
        $params['companionWidth'] = 300;
        $params['companionHeight'] = 250;
        $params['companionClickUrl'] = 'https://example.test/click';

        $document = $this->render($params);
        $this->assertEqual($document->getElementsByTagName('Code')->item(0)->textContent, $params['companionMarkup']);
    }
}
