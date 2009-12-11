<?php

class IndexController 
    extends OX_UI_Controller_Index
{
    public function indexAction()
    {
         $this->forward("index", "zone", "workflow");
    }
} 
