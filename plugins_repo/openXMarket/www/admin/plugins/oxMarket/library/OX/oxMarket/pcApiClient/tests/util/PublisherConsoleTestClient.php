<?php

/**
 * Class that allow to fully test getDictionaryData 
 * to allow mockup PublisherConsoleClient
 *
 */
class PublisherConsoleTestClient 
{
    var $dictionaryData;

    // Throws exception if dictionaryData is an Exception
    public function testGetDictionaryData()
    {
        if ($this->dictionaryData instanceof Exception) {
            throw $this->dictionaryData;
        }
        return $this->dictionaryData;
    }
    
    // mockup dictionary get* method to throws Exception as in testGetDictionaryData
    public function getCreativeAttributes() { return $this->testGetDictionaryData(); }
    public function getCreativeTypes()      { return $this->testGetDictionaryData(); }
    public function getAdCategories()       { return $this->testGetDictionaryData(); }
    public function getDefaultRestrictions(){ return $this->testGetDictionaryData(); }
    public function getCreativeSizes()      { return $this->testGetDictionaryData(); }
}