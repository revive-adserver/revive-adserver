<?php

class OX_UI_Menu_Predicate_AlwaysDeny implements OX_Common_Predicate
{
    public function evaluate()
    {
        return false;
    }
}
