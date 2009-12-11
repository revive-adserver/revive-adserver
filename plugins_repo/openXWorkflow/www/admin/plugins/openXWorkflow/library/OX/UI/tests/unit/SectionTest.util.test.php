<?php

class OX_UI_Menu_SectionTest extends UnitTestCase
{


    public function setUp()
    {
        $this->menuNoCheckers = $this->buildMenuWithoutCheckers();
        $this->menuWithCheckers = $this->buildMenuWithCheckers();
    }


    public function testImmediateParent()
    {
        $this->checkExistingParent($this->menuNoCheckers, 'main1/left11/content111', OX_UI_Menu_Section::LEVEL_LEFT_MAIN, 'left11');
        $this->checkExistingParent($this->menuWithCheckers, 'main1/left11/content111', OX_UI_Menu_Section::LEVEL_LEFT_MAIN, 'left11');
    }


    public function testNonimmediateParent()
    {
        $this->checkExistingParent($this->menuNoCheckers, 'main1/left11/content111', OX_UI_Menu_Section::LEVEL_TAB_MAIN, 'main1');
        $this->checkExistingParent($this->menuWithCheckers, 'main1/left11/content111', OX_UI_Menu_Section::LEVEL_TAB_MAIN, 'main1');
    }


    public function testNoParentAtLevelExists()
    {
        $this->checkNonexistingParent($this->menuNoCheckers, 'content14', OX_UI_Menu_Section::LEVEL_LEFT_MAIN);
        $this->checkNonexistingParent($this->menuWithCheckers, 'content14', OX_UI_Menu_Section::LEVEL_LEFT_MAIN);
    }


    public function testParentNonexistingLevel()
    {
        $this->checkNonexistingParent($this->menuNoCheckers, 'main1/left11/content111', 1234);
        $this->checkNonexistingParent($this->menuWithCheckers, 'main1/left11/content111', 1234);
    }


    public function testSiblingsNoCheckers()
    {
        $this->checkSiblings($this->menuNoCheckers, 'main1/left11', OX_UI_Menu_Section::LEVEL_LEFT_MAIN, array (
                'left11', 'left12'));
        $this->checkSiblings($this->menuNoCheckers, 'main1', OX_UI_Menu_Section::LEVEL_TAB_MAIN, array (
                'main1', 'main2'));
    }


    public function testSiblingsWithChekers()
    {
        $this->checkSiblings($this->menuWithCheckers, 'main1/left11', OX_UI_Menu_Section::LEVEL_LEFT_MAIN, array (
                'left11'));
        $this->checkSiblings($this->menuWithCheckers, 'main1', OX_UI_Menu_Section::LEVEL_TAB_MAIN, array (
                'main1'));
    }

    public function testAccessWithoutCheckers()
    {
        $this->checkAccess($this->menuNoCheckers, 'root', true);
        $this->checkAccess($this->menuNoCheckers, 'main1', true);
        $this->checkAccess($this->menuNoCheckers, 'main1/left11', true);
        $this->checkAccess($this->menuNoCheckers, 'main1/left11/content111', true);
        $this->checkAccess($this->menuNoCheckers, 'content14', true);
    }

    public function testAccessWithCheckers()
    {
        $this->checkAccess($this->menuWithCheckers, 'root', true);
        $this->checkAccess($this->menuWithCheckers, 'main1', true);
        $this->checkAccess($this->menuWithCheckers, 'main1/left11', true);
        $this->checkAccess($this->menuWithCheckers, 'main1/left11/content111', true);
        $this->checkAccess($this->menuWithCheckers, 'content14', true);
        
        $this->checkAccess($this->menuWithCheckers, 'main1/left11/content112', false, 'content112-redirect');
        $this->checkAccess($this->menuWithCheckers, 'main1/left12', false, 'left12-redirect');
        $this->checkAccess($this->menuWithCheckers, 'main1/left12/content121', false, 'left12-redirect');
        $this->checkAccess($this->menuWithCheckers, 'main2', false, 'main2-redirect');
        $this->checkAccess($this->menuWithCheckers, 'main2/left21', false, 'main2-redirect');
        $this->checkAccess($this->menuWithCheckers, 'main2/left21/content212', false, 'main2-redirect');
        
    }

    private function checkNonexistingParent($menu, $sectionId, $level)
    {
        $section = $menu->getSection($sectionId);
        $this->assertNotNull($section);
        $parent = $section->parentOrSelf($level);
        $this->assertNull($parent);
    }


    private function checkExistingParent($menu, $sectionId, $level, 
            $expectedParentLabel)
    {
        $section = $menu->getSection($sectionId);
        $this->assertNotNull($section);
        $parent = $section->parentOrSelf($level);
        $this->assertNotNull($parent);
        $this->assertEqual($expectedParentLabel, $parent->getLabel());
    }


    private function checkSiblings($menu, $parentSectionId, $level, 
            array $siblingLabels)
    {
        $parent = $menu->getSection($parentSectionId);
        $this->assertNotNull($parent);
        
        $siblings = $parent->siblings($level);
        $this->assertNotNull($siblings);
        $this->assertEqual(count($siblingLabels), count($siblings));
        for ($i = 0; $i < count($siblings); $i++) {
            $this->assertNotNull($siblings[$i]);
            $this->assertEqual($siblingLabels[$i], $siblings[$i]->getLabel());
        }
    }


    private function checkAccess($menu, $sectionId, $expectedAccess, $expectedRedirectAction = null)
    {
        $section = $menu->getSection($sectionId);
        $this->assertEqual($expectedAccess, $section->canAccess());
        if (isset($expectedRedirectAction)) {
            $redirect = $section->getForwardingTarget();
            $this->assertTrue(isset($redirect['action']));
            $this->assertEqual($expectedRedirectAction, $redirect['action']);
        }
    }


    private function buildMenuWithoutCheckers()
    {
        $menu = new OX_UI_Menu('root');
        
        $menu->appendMainTabTo('root', 'main1', 'main1');
        $menu->appendLeftMenuTo('main1', 'main1/left11', 'left11');
        $menu->appendContentTo('main1/left11', 'main1/left11/content111', 'content111');
        $menu->appendContentTo('main1/left11', 'main1/left11/content112', 'content112');
        $menu->appendLeftMenuTo('main1', 'main1/left12', 'left12');
        $menu->appendContentTo('main1/left12', 'main1/left12/content121', 'content121');
        $menu->appendContentTo('main1/left12', 'main1/left12/content122', 'content122');
        $menu->appendContentTo('main1', 'main1/left12/content13', 'content13');
        
        $menu->appendMainTabTo('root', 'main2', 'main2');
        
        $menu->appendContentTo('root', 'content14', 'content14');
        
        return $menu;
    }


    private function buildMenuWithCheckers()
    {
        $menu = new OX_UI_Menu('root');
        
        $alwaysDeny = new OX_UI_Menu_Predicate_AlwaysDeny();
        
        $menu->appendMainTabTo('root', 'main1', 'main1');
        $menu->appendLeftMenuTo('main1', 'main1/left11', 'left11');
        $menu->appendContentTo('main1/left11', 'main1/left11/content111', 'content111');
        $menu->appendContentTo('main1/left11', 'main1/left11/content112', 'content112', array (
                'predicate' => new OX_UI_Menu_Predicate_ForwardingTargetWrapper($alwaysDeny, 
                    new OX_UI_Controller_SimpleForwardingTarget('content112-redirect'))));
        $menu->appendLeftMenuTo('main1', 'main1/left12', 'left12', array (
                'predicate' => new OX_UI_Menu_Predicate_ForwardingTargetWrapper($alwaysDeny, 
                    new OX_UI_Controller_SimpleForwardingTarget('left12-redirect'))));
        $menu->appendContentTo('main1/left12', 'main1/left12/content121', 'content121');
        $menu->appendContentTo('main1/left12', 'main1/left12/content122', 'content122');
        $menu->appendContentTo('main1', 'main1/left12/content13', 'content13');
        
        $menu->appendMainTabTo('root', 'main2', 'main2', array (
                'predicate' => new OX_UI_Menu_Predicate_ForwardingTargetWrapper($alwaysDeny, 
                    new OX_UI_Controller_SimpleForwardingTarget('main2-redirect'))));
        $menu->appendLeftMenuTo('main2', 'main2/left21', 'left21');
        $menu->appendContentTo('main2/left21', 'main2/left21/content211', 'content211');
        $menu->appendContentTo('main2/left21', 'main2/left21/content212', 'content212');
        
        $menu->appendContentTo('root', 'content14', 'content14');
        
        return $menu;
    }
}
