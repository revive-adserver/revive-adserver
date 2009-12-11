<?php

class OX_Common_Comparator_CreativeSizeOptionComparator
    implements OX_Common_Comparator
{
    public function compare($oCreativeSizeOption1, $oCreativeSizeOption2)
    {
        $comarator = OX_Common_NaturalComparator::$INSTANCE;
        
        list($width1, $height1) = $this->getDimensions($oCreativeSizeOption1);
        list($width2, $height2) = $this->getDimensions($oCreativeSizeOption2);
        
        $result = $comarator->compare($width1, $width2);
        if ($result == 0) {
            return $comarator->compare($height1, $height2);
        }
        
        return $result;
    }
    
    
    private function getDimensions($label)
    { 
        return split('x', preg_replace('/[^\dx]/', '', $label));
    }
}

?>