<?php
require_once MAX_PATH . '/lib/xajax/xajax.inc.php';

class XajaxResponseTest extends UnitTestCase
{
    public function testCommandAttributesCannotInjectXmlElements()
    {
        $payloads = [
            '" p="probe"></cmd><script xmlns="http://www.w3.org/1999/xhtml">XAJAX_PROBE</script><cmd t="',
            '\"><svg xmlns="http://www.w3.org/2000/svg" onload="alert(1)"/>',
            "quotes'\" & < >",
            '&#34;&#x22;&quot;&apos;',
            'café_東京',
            "backslash\\\" attr=\"value",
        ];
        foreach ($payloads as $payload) {
            foreach (['t', 'p', 'c'] as $attribute) {
                foreach (['current', 'legacy'] as $method) {
                    $attributes = ['n' => 'as', 't' => 'cell_123', 'p' => 'innerHTML', 'c' => 'extra'];
                    $attributes[$attribute] = $payload;
                    $response = new xajaxResponse();
                    $xml = $method === 'current'
                        ? '<?xml version="1.0"?><xjx>' . $response->_getXMLForCommand($attributes, 'normal data') . '</xjx>'
                        : '<?xml version="1.0"?><xjx>' . $response->_cmdXML($attributes, 'normal data') . '</xjx>';
                    $document = $this->parse($xml);
                    if (!$document) continue;
                    $this->assertEqual($document->getElementsByTagName('cmd')->length, 1, $method);
                    $this->assertEqual($document->getElementsByTagNameNS('http://www.w3.org/1999/xhtml', 'script')->length, 0, $method);
                    $this->assertEqual($document->getElementsByTagNameNS('http://www.w3.org/2000/svg', 'svg')->length, 0, $method);
                    $this->assertIdentical($document->getElementsByTagName('cmd')->item(0)->getAttribute($attribute), $payload, $method);
                }
            }
        }
    }

    public function testInvalidAttributeCharactersProduceValidXml()
    {
        foreach (["bad\xC0\xAF", "bad\xFF", "bad\0\x01"] as $value) {
            foreach (['current', 'legacy'] as $method) {
                $response = new xajaxResponse();
                $attributes = ['n' => 'as', 't' => $value, 'p' => 'innerHTML'];
                $command = $method === 'current'
                    ? $response->_getXMLForCommand($attributes, '')
                    : $response->_cmdXML($attributes, '');
                $document = $this->parse('<xjx>' . $command . '</xjx>');
                if (!$document) continue;
                $target = $document->getElementsByTagName('cmd')->item(0)->getAttribute('t');
                $this->assertTrue(str_starts_with($target, 'bad'));
                $this->assertTrue(str_contains($target, "\u{FFFD}"));
                $this->assertEqual($document->getElementsByTagName('cmd')->length, 1);
            }
        }
    }

    public function testResponseRetainsNormalCommandTargetsAndHtmlData()
    {
        $response = new xajaxResponse();
        $html = '<table><tr><td>Normal & content</td></tr></table>';
        $response->addAssign('cell_123', 'style.display', 'block');
        $response->addAssign('cell_123', 'innerHTML', $html);
        $response->addAssign('img_expand_123', 'style.display', 'none');
        $response->addAssign('img_collapse_123', 'style.display', 'inline');
        $document = $this->parse($response->getOutput());
        if (!$document) return;
        $commands = $document->getElementsByTagName('cmd');
        $this->assertEqual($commands->length, 4);
        $this->assertIdentical($commands->item(0)->getAttribute('t'), 'cell_123');
        $this->assertIdentical($commands->item(0)->getAttribute('p'), 'style.display');
        $this->assertIdentical($commands->item(0)->textContent, 'block');
        $this->assertIdentical($commands->item(1)->textContent, $html);
        $this->assertIdentical($commands->item(2)->getAttribute('t'), 'img_expand_123');
        $this->assertIdentical($commands->item(3)->textContent, 'inline');
    }

    public function testGetOutputAndArrayCommandsUseSafeAttributes()
    {
        $payload = '"><script xmlns="http://www.w3.org/1999/xhtml">XAJAX_PROBE</script>';
        $response = new xajaxResponse();
        $response->addAssign($payload, 'innerHTML', 'Value ]]> after <![CDATA[ marker');
        $response->addCommand(['n' => 'as', 't' => $payload, 'p' => 'value'], ['key' => 'normal value']);
        $document = $this->parse($response->getOutput());
        if (!$document) return;
        $commands = $document->getElementsByTagName('cmd');
        $this->assertEqual($commands->length, 2);
        $this->assertIdentical($commands->item(0)->getAttribute('t'), $payload);
        $this->assertIdentical($commands->item(0)->textContent, 'Value ]]> after <![CDATA[ marker');
        $this->assertEqual($document->getElementsByTagNameNS('http://www.w3.org/1999/xhtml', 'script')->length, 0);
        $this->assertEqual($commands->item(1)->getElementsByTagName('xjxobj')->length, 1);
    }

    public function testResponseUsesItsDeclaredCharacterEncoding()
    {
        foreach (['UTF-8', 'ISO-8859-1', ''] as $encoding) {
            $target = $encoding === 'ISO-8859-1' ? "cell_caf\xE9&\"" : 'cell_café&"';
            $response = new xajaxResponse($encoding);
            $response->addAssign($target, 'value', 'normal');
            $document = $this->parse($response->getOutput());
            if (!$document) continue;
            $this->assertIdentical($document->getElementsByTagName('cmd')->item(0)->getAttribute('t'), 'cell_café&"');
        }
    }

    private function parse(string $xml): ?DOMDocument
    {
        $document = new DOMDocument();
        $previous = libxml_use_internal_errors(true);
        try {
            $parsed = $document->loadXML($xml, LIBXML_NONET);
            $this->assertTrue($parsed, 'Response must remain valid XML');
            return $parsed ? $document : null;
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }
    }
}
