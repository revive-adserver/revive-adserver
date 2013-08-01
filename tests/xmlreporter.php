<?php

require_once MAX_PATH . '/lib/simpletest/xml.php';

class ReviveXmlReporter extends XmlReporter
{
    private $methodStart;

    private function t()
    {
        return microtime(true);
    }

    function paintMethodStart($test_name)
    {
        $this->methodStart = $this->t();
        parent::paintMethodStart($test_name);
    }

    function paintMethodEnd($test_name)
    {
        print $this->_getIndent(1);
        print "<" . $this->_namespace . "time>" .
                $this->toParsedXml($this->t() - $this->methodStart) .
                "</" . $this->_namespace . "time>\n";
        parent::paintMethodEnd($test_name);
    }
}
