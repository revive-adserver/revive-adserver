<?php

require_once LIB_PATH.'/Plugin/Component.php';

class Plugins_testExtension1_testGroup2_testComponent1 extends OX_Component
{

    function staticMethod()
    {
        return 'staticMethodResult2';
    }

    function staticMethodWithParams($result)
    {
        return 'staticMethodWithParams2='.$result;
    }


    function hookHandler()
    {
        return 'testGroup2:testComponent1 hook handled';
    }
}

?>