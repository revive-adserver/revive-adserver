<?php

require 'XML/RSS.php';

class OA_Dashboard_BlogFeed
{
    function start()
    {
        $oRss =& new XML_RSS("http://feeds.feedburner.com/OpenadsBlog?format=xml");
        $oRss->parse();

        $oTpl = new OA_Admin_Template('dashboard-feed.html');

        $oTpl->assign('title', 'Last 5 blog posts');
        $oTpl->assign('feed', array_slice($oRss->getItems(), 0, 5));

        $oTpl->display();
    }
}

?>