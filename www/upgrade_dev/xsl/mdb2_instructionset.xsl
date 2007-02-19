<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <!--  -->
    <html><head><title>Openads Upgrade Instructionset</title>

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

    <p class="titlemini">An instructionset does not allow you to alter a schema or a changeset.
    </p>

    <xsl:variable name="filename"><xsl:value-of select="instructionset/name"/></xsl:variable>
    <div id="save" style="display:block;">
        <form id="frmFilename" method="POST" action="index.php">
            <table>
            <tr>
            <td><button name="saveinstructionset" disabled="disabled" value="{$filename}">Save Instruction Set</button></td>
            <td><button name="createpackage" value="{$filename}">Create Upgrade Package</button></td>
            <td><button name="viewraw" value="{$filename}" width="130px">View Raw Data</button></td>
            </tr>
            </table>
        </form>
    </div>
    <!-- -->
    <br/><span class="titlemini">Changeset:
    <xsl:value-of select="instructionset/name"/> :: Version:
    <xsl:value-of select="instructionset/version"/></span><br/>
    <span class="titlemini">
    <xsl:value-of select="instructionset/comments"/></span><br/><br/>

    <TABLE class="tablemain">
    <xsl:for-each select="instructionset/constructive">
        <xsl:call-template name="showconstructive"/>
    </xsl:for-each>
    </TABLE>
    <br/><br/>
    <TABLE class="tablemain">
    <xsl:for-each select="instructionset/destructive">
        <xsl:call-template name="showdestructive"/>
    </xsl:for-each>
    </TABLE>
    <!-- -->

    </body></html>
    <!-- -->
</xsl:template>

<xsl:template name="showconstructive">

    <tr><td colspan="11" class="tableheader"> <span class="titlemini">CONSTRUCTIVE CHANGES</span></td></tr>

    <tr><td colspan="11" class="tableheader"> <span class="titlemini">fields added</span> </td></tr>
    <tr>
    <th class="tableheader">table</th>
    <th class="tableheader">name</th>
    <th class="tableheader">was called</th>
    <th class="tableheader">type</th>
    <th class="tableheader">length</th>
    <th class="tableheader">default</th>
    <th class="tableheader">autoincrement</th>
    <th class="tableheader">unsigned</th>
    <th class="tableheader">notnull</th>
    <th class="tableheader">comments</th>
    <th class="tableheader">afterAddField()</th>
    </tr>

   <xsl:for-each select="descendant::add/field">
        <xsl:call-template name="showfieldAdd"/>
    </xsl:for-each>
</xsl:template>

<xsl:template name="showfieldAdd">

    <tr>
    <td class="tablebody"><xsl:call-template name="showtable"/></td>
    <td class="tablebody"><xsl:call-template name="showname"/></td>
    <td class="tablebody"><xsl:call-template name="showwas"/></td>
    <td class="tablebody"><xsl:call-template name="showtype"/></td>
    <td class="tablebody"><xsl:call-template name="showlength"/></td>
    <td class="tablebody"><xsl:call-template name="showdefault"/></td>
    <td class="tablebody"><xsl:call-template name="showautoincrement"/></td>
    <td class="tablebody"><xsl:call-template name="showunsigned"/></td>
    <td class="tablebody"><xsl:call-template name="shownotnull"/></td>
    <td class="tablebody"><xsl:call-template name="showcomments"/></td>
    <td class="tablebody"><xsl:call-template name="showafteraddfield"/></td>
    </tr>

</xsl:template>

<xsl:template name="showdestructive">

    <tr><td colspan="3" class="tableheader"> <span class="titlemini">DESTRUCTIVE CHANGES</span></td></tr>

    <tr><td colspan="3" class="tableheader"> <span class="titlemini">fields removed</span> </td></tr>
    <tr>
    <th class="tableheader">table</th>
    <th class="tableheader">name</th>
    <th class="tableheader">beforeRemoveField()</th>
    </tr>

    <xsl:for-each select="descendant::remove/field">
        <xsl:call-template name="showfieldRemove"/>
    </xsl:for-each>

</xsl:template>

<xsl:template name="showfieldRemove">

    <tr>
    <td class="tablebody"><xsl:call-template name="showtable"/></td>
    <td class="tablebody"><xsl:call-template name="showname"/></td>
    <td class="tablebody"><xsl:call-template name="showbeforeremovefield"/></td>
    </tr>

</xsl:template>

<xsl:template name="showtable">
    <xsl:value-of select="table"/>
</xsl:template>

<xsl:template name="showname">
    <xsl:value-of select="name"/>
</xsl:template>

<xsl:template name="showdefault">
    <xsl:value-of select="default"/>
</xsl:template>

<xsl:template name="showtype">
    <xsl:value-of select="type"/>
</xsl:template>

<xsl:template name="showlength">
    <xsl:value-of select="length"/>
</xsl:template>

<xsl:template name="showautoincrement">
    <xsl:value-of select="autoincrement"/>
</xsl:template>

<xsl:template name="showunsigned">
    <xsl:value-of select="unsigned"/>
</xsl:template>

<xsl:template name="shownotnull">
    <xsl:value-of select="notnull"/>
</xsl:template>

<xsl:template name="showcomments">
    <xsl:value-of select="comments"/>
</xsl:template>

<xsl:template name="showwas">
    <xsl:value-of select="was"/>
</xsl:template>

<xsl:template name="showafteraddfield">
    <xsl:value-of select="afterAddField"/>
</xsl:template>

<xsl:template name="showbeforeremovefield">
    <xsl:value-of select="beforeRemoveField"/>
</xsl:template>

</xsl:stylesheet>
