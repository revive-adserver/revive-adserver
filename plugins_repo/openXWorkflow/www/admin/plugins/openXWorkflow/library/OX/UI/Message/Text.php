<?php

/**
 * A simple text message
 */
class OX_UI_Message_Text extends OX_UI_Message_Abstract
{
    private $text;


    public function __construct($options = array())
    {
        parent::__construct($options);
    }


    /**
     * @return string Message text to be shown
     */
    public function getText()
    {
        return $this->text;
    }


    /**
     * Set text of the message to be shown.
     * 
     * @param string $text Please note that the provided message text needs to be 
     * escaped as appropriate
     */
    public function setText($text)
    {
        $this->text = $text;
    }


    /**
     * Returns this message rendering as string.
     */
    public function render()
    {
        return $this->getText();
    }

}
