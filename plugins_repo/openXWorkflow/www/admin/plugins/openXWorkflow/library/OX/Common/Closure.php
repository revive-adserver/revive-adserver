<?php

class OX_Common_Closure
{
    var $callback;
    var $params;
    
    public static function createClosure($callback, $params)
    {
        return array(new OX_Common_Closure($callback, $params), 'callback');
    }
    
    
    public function __construct($callback, $params)
    {
        $this->params = $params;
        $this->callback = $callback;
    }
    
    
    public function callback()
    {
        $params = func_get_args();
        $merged = array_merge($this->params, $params);
//        echo "CALLBACK \n";
//        echo "CLASS = " . get_class($this->callback) . "<BR>\n";
//        echo "COUNT = " . count($this->callback) . "<BR>\n";
//        echo "ARR[0] = " . get_class($this->callback[0]) . "<BR>\n";
//        echo "ARR[1] = " . $this->callback[1] . "<BR>\n";
        return call_user_func_array($this->callback, $merged);
    }
}

?>
