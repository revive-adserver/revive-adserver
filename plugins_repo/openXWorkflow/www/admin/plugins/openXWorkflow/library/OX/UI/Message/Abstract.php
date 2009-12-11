<?php

/**
 * A base class for confirmation/error message containers.
 */
abstract class OX_UI_Message_Abstract implements OX_UI_Message
{
    private $messageType = 'info';
    private $messageScope = 'local';


    public function __construct($options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
        elseif ($options instanceof Zend_Config) {
            $this->setConfig($options);
        }
    }


    /**
     * Sets options of the message.
     * 
     * @param  array $options 
     * @return OX_UI_DefaultMessage
     */
    public function setOptions(array $options)
    {
        OX_Common_ObjectUtils::setOptions($this, $options);
        return $this;
    }


    /**
     * Sets options from config object.
     * 
     * @param  Zend_Config $config 
     * @return OX_UI_DefaultMessage
     */
    public function setConfig(Zend_Config $config)
    {
        return $this->setOptions($config->toArray());
    }


    /**
     * Returns message type, 'info' by default.
     */
    public function getType()
    {
        return $this->messageType;
    }


    public function setType($type)
    {
        $this->messageType = $type;
    }


    /**
     * Returns message scope, 'local' by default.
     */
    public function getScope()
    {
        return $this->messageScope;
    }


    public function setScope($scope)
    {
        $this->messageScope = $scope;
    }
}
