<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <!--  -->
    <html><head><title>Openads Upgrade Package</title>

    <link rel="stylesheet" type="text/css" href="/upgrade_dev/xsl/mdb2_xsl.css"/>

    <script type="text/javascript">
var xajaxRequestUri="http://www.trunk.0x.monique.m3.net/upgrade_dev/index.php";
var xajaxDebug=false;
var xajaxStatusMessages=false;
var xajaxWaitCursor=true;
var xajaxDefinedGet=0;
var xajaxDefinedPost=1;
var xajaxLoaded=false;
function xajax_editFieldProperty(){return xajax.call("editFieldProperty", arguments, 1);}
	</script>
	<script type="text/javascript" src="./lib/xajax/xajax_js/xajax.js"></script>
	<script type="text/javascript">
window.setTimeout(function () { if (!xajaxLoaded) { alert('Error: the xajax Javascript file could not be included. Perhaps the URL is incorrect?\nURL: ./xajax_js/xajax.js'); } }, 6000);
	</script>

    </head>
    <body>

    <TABLE class="tablemain">
        <tr><td class="tableheader">Name</td><td class="tablebody"><xsl:value-of select="//install/name"/></td></tr>
        <tr><td class="tableheader">Version</td><td class="tablebody"><xsl:value-of select="//install/version"/></td></tr>
        <tr><td class="tableheader">Package</td><td class="tablebody"><xsl:value-of select="//install/package"/></td></tr>
        <tr><td class="tableheader">Description</td><td class="tablebody"><xsl:value-of select="//install/description"/></td></tr>
        <tr><td class="tableheader">Creation Date</td><td class="tablebody"><xsl:value-of select="//install/creationDate"/></td></tr>
        <tr><td class="tableheader">Author</td><td class="tablebody"><xsl:value-of select="//install/author"/></td></tr>
        <tr><td class="tableheader">Email</td><td class="tablebody"><xsl:value-of select="//install/authorEmail"/></td></tr>
        <tr><td class="tableheader">URL</td><td class="tablebody"><xsl:value-of select="//install/authorUrl"/></td></tr>
        <tr><td class="tableheader">Copyright</td><td class="tablebody"><xsl:value-of select="//install/copyright"/></td></tr>
        <tr><td class="tableheader">License</td><td class="tablebody"><xsl:value-of select="//install/license"/></td></tr>
    </TABLE>
    <br/>

    <TABLE class="tablemain">
    <xsl:for-each select="//install/database/package">
        <xsl:call-template name="showdatabasepackage">
            <xsl:with-param name="version" select="@version"/>
        </xsl:call-template>
    </xsl:for-each>
    </TABLE>
    <br/>
    <!-- -->

    <TABLE class="tablemain">
    <tr><th class="tableheader">exclude folders</th></tr>
    <xsl:for-each select="//install/files/exclude">
        <!--xsl:for-each select="descendant::exclude"-->
            <xsl:call-template name="showfoldersexclude"/>
        <!--/xsl:for-each-->
    </xsl:for-each>
    </TABLE>
    <br/>
    <!-- -->

    <TABLE class="tablemain">
    <xsl:for-each select="//install/configuration/add/section">
        <xsl:call-template name="showconfigaddsection"/>
    </xsl:for-each>
    </TABLE>
    <br/>
    <!-- -->

    </body></html>
    <!-- -->
</xsl:template>

<xsl:template name="showdatabasepackage">

    <xsl:param name="version" select="unkown"/>
    <tr><th class="tableheader" colspan="2">database package <xsl:value-of select="$version"/></th></tr>

    <tr>
    <th class="tableheader">instruction set</th>
    <th class="tableheader">event handlers</th>
    </tr>

    <tr>
    <td class="tablebody"><xsl:value-of select="file_xml"/></td>
    <td class="tablebody"><xsl:value-of select="file_php"/></td>
    </tr>

</xsl:template>

<xsl:template name="showfoldersexclude">

    <tr><td class="tablebody"><xsl:value-of select="folder"/></td></tr>

</xsl:template>

<xsl:template name="showconfigaddsection">

    <tr><th class="tableheader" colspan="3">add to configuration section [<xsl:value-of select="../@destination"/><xsl:value-of select="@destination"/>]</th></tr>

    <xsl:for-each select="descendant::option">
        <xsl:call-template name="showconfigoptions"/>
    </xsl:for-each>

</xsl:template>

<xsl:template name="showconfigoptions">

    <tr>
    <td class="tablebody"><xsl:value-of select="@name"/></td>
    <td class="tablebody"><xsl:value-of select="@type"/></td>
    <td class="tablebody"><xsl:value-of select="@default"/></td>
    </tr>

</xsl:template>

</xsl:stylesheet>
