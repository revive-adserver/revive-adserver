<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <!--  -->
<!--html>
<head>
    <title>OpenX Schema</title-->

    <!--link rel="stylesheet" type="text/css" href="assets/css/mdb2_xsl.css"/>

    <script type="text/javascript" src="schema.js"/>
    <script type="text/javascript" src="lib/xajax/xajax_js/xajax.js"></script>
    <script type="text/javascript">
        window.setTimeout(function () { if (!xajaxLoaded) { alert('Error: the xajax Javascript file could not be included. Perhaps the URL is incorrect?\nURL: lib/xajax/xajax_js/xajax.js'); } }, 6000);
    </script-->

<!--/head>
<body onload="xajax_loadSchemaList()"-->

  <div class="bodydiv">
    <div class="heading">
        <xsl:text></xsl:text><xsl:value-of select="//database/name"/>
        <xsl:variable name="status" select="//database/status"></xsl:variable>
        <xsl:text> :: version: </xsl:text><xsl:value-of select="//database/version"/>
        <xsl:text> :: status: </xsl:text>
        <xsl:choose>
            <xsl:when test="$status='final'">
                <span style="font-weight:bold;color:black;"><xsl:value-of select="$status"/></span>
            </xsl:when>
            <xsl:otherwise>
                <span style="font-weight:bold;color:red;"><xsl:value-of select="$status"/></span>
            </xsl:otherwise>
        </xsl:choose>
    </div>
    <!--span class="titlemini"><xsl:value-of select="//database/comments"/></span-->
    <!--form name="frm_admin" method="POST" action="schema.php"-->
        <TABLE class="tablemain">
        <tr>
            <td class="tableheader">
                <xsl:variable name="status" select="//database/status"></xsl:variable>
                <xsl:call-template name="showdropdown"/>
                <form name="frm_admin" method="POST" action="schema.php">
                    <xsl:call-template name="showadminmenu"/>
                    <xsl:if test="$status='final'">
                        <xsl:call-template name="showadminmenufinal"/>
                    </xsl:if>
                    <xsl:if test="$status='transitional'">
                        <xsl:call-template name="showadminmenutrans"/>
                    </xsl:if>
                </form>
            </td>
        </tr>
        <tr>
            <td class="tableheader">
                <xsl:variable name="status" select="//database/status"></xsl:variable>
                <xsl:choose>
                    <xsl:when test="$status='transitional'">
                        <xsl:call-template name="showchangesetcomments"/>
                    </xsl:when>
                </xsl:choose>
            </td>
        </tr>
        </TABLE>
    <!--/form-->
    <TABLE class="tablemain">
    <tr>
        <td class="tableheader" style="text-align:left;">
            <xsl:variable name="status" select="//database/status"></xsl:variable>
            <xsl:choose>
                <xsl:when test="$status='final'">
                    <xsl:text>readonly</xsl:text>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:call-template name="showtableadd"/>
                </xsl:otherwise>
            </xsl:choose>
        </td>
    </tr>
    </TABLE>
    <xsl:for-each select="//database/table">
        <xsl:call-template name="showtableheader">
            <xsl:with-param name="tablename" select="name"></xsl:with-param>
        </xsl:call-template>
        <xsl:call-template name="showtable">
            <xsl:with-param name="tablename" select="name"></xsl:with-param>
        </xsl:call-template>
    </xsl:for-each>
    <!-- -->
</div>
<!--/body>
</html-->
    <!-- -->
</xsl:template>

<xsl:template name="showtableheader">
    <xsl:param name="tablename">unkown</xsl:param>
    <xsl:variable name="status" select="//database/status"></xsl:variable>
    <form id="frm_table_{$tablename}" method="POST" action="schema.php">
        <TABLE class="tablemain">
            <tr>
                <td class="tableheader" style="text-align:left;width:10px;">
                    <xsl:choose>
                        <xsl:when test="$status='final'">
                            <xsl:text>(readonly)</xsl:text>
                        </xsl:when>
                        <xsl:otherwise>
                            <button name="btn_table_edit" type="submit" value="{$tablename}">edit
                            </button>
                        </xsl:otherwise>
                    </xsl:choose>
                </td>
                <td class="tableheader" style="font-size:14px;text-align:left;"><xsl:value-of select="name"/></td>
                <td class="tableheader" style="width:10px;font-size:14px;text-align:center;">
                    <img id="img_expand_{$tablename}" src="assets/images/triangle-d.gif" alt="click to view table" onclick="xajax_expandTable('{$tablename}');"/>
                    <img id="img_collapse_{$tablename}" src="assets/images/triangle-u.gif" style="display:none" alt="click to hide table" onclick="xajax_collapseTable('{$tablename}');"/>
                </td>
            </tr>
        </TABLE>
    </form>
</xsl:template>

<xsl:template name="showtable">
    <xsl:param name="tablename">unkown</xsl:param>
    <div class="tablemain" id="{$tablename}" style="display:none;">
        <xsl:call-template name="showtablefields"/>
        <xsl:call-template name="showtableindexes"/>
        <!--xsl:call-template name="showtableforeignkeys"/-->
    </div>
</xsl:template>

<xsl:template name="showtablefields">
    <TABLE class="tablemain">
        <tr>
            <td class="tableheader"><xsl:text>name</xsl:text></td>
            <td class="tableheader"><xsl:text>type</xsl:text></td>
            <td class="tableheader"><xsl:text>length</xsl:text></td>
            <td class="tableheader"><xsl:text>default</xsl:text></td>
            <td class="tableheader"><xsl:text>autoincrement</xsl:text></td>
            <td class="tableheader"><xsl:text>unsigned</xsl:text></td>
            <td class="tableheader"><xsl:text>notnull</xsl:text></td>
            <td class="tableheader"><xsl:text>comments</xsl:text></td>
        </tr>
        <xsl:for-each select="descendant::declaration/field">
            <xsl:call-template name="showfield"/>
        </xsl:for-each>
    </TABLE>
</xsl:template>


<xsl:template name="showtableindexes">

    <TABLE class="tablemain">
        <tr>
            <td colspan="10" class="tableheader">
                <span class="titlemini">indexes for <xsl:value-of select="name"/></span>
            </td>
        </tr>
        <tr>
            <td class="tableheader">name</td>
            <td class="tableheader">primary</td>
            <td class="tableheader">unique</td>
            <td class="tableheader" colspan="10">fields</td>
        </tr>
        <xsl:for-each select="descendant::declaration/index">
            <xsl:call-template name="showindex"/>
        </xsl:for-each>
    </TABLE>
</xsl:template>

<xsl:template name="showtableforeignkeys">

    <TABLE class="tablemain">
        <tr>
            <td colspan="10" class="tableheader">
                <span class="titlemini">foreign key constraints for <xsl:value-of select="name"/></span>
            </td>
        </tr>
        <tr>
            <td class="tableheader">symbol</td>
            <td class="tableheader">id</td>
            <td class="tableheader" colspan="2">fields</td>
        </tr>
        <xsl:for-each select="descendant::declaration/foreignkey">
            <xsl:call-template name="showforeignkey"/>
        </xsl:for-each>
    </TABLE>
</xsl:template>

<xsl:template name="showfield">
    <tr>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="name"/></span></td>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="type"/></span></td>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="length"/></span></td>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="default"/></span></td>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="autoincrement"/></span></td>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="unsigned"/></span></td>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="notnull"/></span></td>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="comments"/></span></td>
    </tr>
</xsl:template>

<xsl:template name="showindex">
    <tr>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="name"/></span></td>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="primary"/></span></td>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="unique"/></span></td>
        <xsl:for-each select="field">
            <td class="tablebody"><span class="textmini"><xsl:value-of select="name"/> (<xsl:value-of select="sorting"/>)</span></td>
        </xsl:for-each>
    </tr>
</xsl:template>

<xsl:template name="showforeignkey">
    <tr>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="symbol"/></span></td>
        <td class="tablebody"><span class="textmini"><xsl:value-of select="name"/></span></td>
        <xsl:for-each select="field">
            <td class="tablebody"><span class="textmini"><xsl:value-of select="name"/></span></td>
        </xsl:for-each>
    </tr>
</xsl:template>

<xsl:template name="showtableedit">
    <xsl:param name="tablename">unkown</xsl:param>
    <form id="frm_schema_{$tablename}" method="POST" action="schema.php">
        <button name="btn_table_edit" type="submit" value="{$tablename}">edit this table</button>
        <!--button name="btn_table_edit" type="button" onclick="xajax_testAjax(xajax.getFormValues('frm_schema'));">edit this table</button-->
    </form>
</xsl:template>

<xsl:template name="showchangesetcomments">
    <!--span class="titlemini">
        <xsl:text>commit changeset comments  </xsl:text>
        <br />
        <textarea name="comments" cols="100" rows="2" ></textarea>
    </span-->
</xsl:template>

<xsl:template name="showtableadd">
    <form id="frm_schema_add" method="POST" action="schema.php">
        <button name="btn_table_new" type="submit">new table</button>
        <xsl:text>   </xsl:text><input type="text" name="new_table_name"/>
    </form>
</xsl:template>

<xsl:template name="showdropdown">
        <form name="frm_admin" method="POST" action="schema.php">
        Currently working on: <select id="xml_file" name="xml_file" onchange="submit()"></select>
        <xsl:text>   </xsl:text>
        <input name="btn_schema_new" type="submit" value="create a new schema"/>
        <input type="text" name="new_schema_name"/>
        </form>
</xsl:template>

<xsl:template name="showadminmenu">
        <input type="submit" name="clear_cookies" value="clear cookies"/>
        <!--input name="btn_changeset_archive" type="submit" value="view changeset archive"/-->
</xsl:template>

<xsl:template name="showadminmenufinal">
        <input name="btn_copy_final" type="submit" value="copy final schema to transitional" />
        <!--input name="btn_generate_dbo_final" type="submit" value="generate dataobjects"/-->
</xsl:template>

<xsl:template name="showadminmenutrans">
        <input name="btn_delete_trans" type="submit" value="delete transitional schema"/>
        <input name="btn_compare_schemas" type="submit" value="inspect the changeset"/>
        <!--input name="btn_generate_dbo_trans" type="submit" value="generate dataobjects"/-->
        <!--input name="btn_commit_final" type="submit" value="commit transitional schema as final"/-->
</xsl:template>

</xsl:stylesheet>
