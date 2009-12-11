<?php

/**
 * A base class for confirmation/error message containers.
 */
interface OX_UI_Message
{
    /**
     * Returns this message rendering as string.
     */
    public function render();
    
    /**
     * Returns message type.
     */
    public function getType();
    
    /**
     * Returns message scope.
     */
    public function getScope();
}
