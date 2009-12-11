<?php


class OX_Workflow_UI_ZoneAliasBuilder 
{
    
    public function __construct()
    {
    }
    
    
   /**
    * Builds zone alias array in a form of 
    *   array(
    *    zone1Id => array(alias1, alias2),
    *    zone2Id => array(alias1, alias2, alias3)
    * )
    *
    * Takes array of [zone, count] pairs as an input.
    * 
    * @param array $aZoneElements
    * @return array of zone id => array of aliases entries
    */
    public function buildZoneAliases($aZoneElements)
    {
        $aZoneAliases = array();
        foreach($aZoneElements as $aZoneElem) {
            $zoneId = $aZoneElem['zone']['zoneid'];
            $aliasesCount = $aZoneElem['count'];

            $aNames = array();
            for ($i = 1; $i <= $aliasesCount; $i++) {
               $aNames[] = 'zone_'.$zoneId.'_'.$i; 
            }
            $aZoneAliases[$zoneId] = $aNames;
        }
        
        return $aZoneAliases;
    }
    
    
    /**
     * Builds a name for generated alias tag.
     * - if $aliasCount == 1 - zone name is used.
     * - if 1 <= $aliasNo <= 10 english ordinal is used as zone name prefix
     * - if $aliasNo > 10 $aliasNo is used as zone name suffix
     * @param string $zoneName zone name
     * @param int $aliasNo current alias number (starts with 1)
     * @param int $aliasCount all aliases count
     * @return string
     */
    public function buildAliasedTagName($zoneName, $aliasNo, $aliasCount)
    {
        if ($aliasCount == 1) {
            return $zoneName;
        }
        $aHumanReadableNames = array( 
            'first', 'second', 'third', 'fourth', 'fifth', 
            'sixth', 'seventh', 'eighth', 'ninth', 'tenth'    
        );
        
        if ($aliasNo <= 10) {
            $name = $aHumanReadableNames[$aliasNo-1].' '.$zoneName;
        }
        else {
            $name = $zoneName.' #'.$aliasNo;
        }
        
        return $name;
    }    
}

?>