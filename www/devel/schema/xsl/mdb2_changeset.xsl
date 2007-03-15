<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <!--  -->
    <html><head><title>Openads Schema Changeset</title>

    <link rel="stylesheet" type="text/css" href="css/mdb2_xsl.css"/>

    <script type="text/javascript" src="schema.js"/>
    <script type="text/javascript" src="../lib/xajax/xajax_js/xajax.js"></script>
    <script type="text/javascript">
        window.setTimeout(function () { if (!xajaxLoaded) { alert('Error: the xajax Javascript file could not be included. Perhaps the URL is incorrect?\nURL: ../lib/xajax/xajax_js/xajax.js'); } }, 6000);
    </script>

    </head>
    <body onload="xajax_loadChangeset();">
    <!-- -->

    <div>
        <table class="tablemain">
            <tr>
                <td class="tableheader" style="text-align:left;">
                    <form name="frm_select" method="POST" action="archive.php">
                        <xsl:text>archive :: </xsl:text>
                        <select id="select_changesets" name="select_changesets" onchange="frm_select.submit()">
                            <option value=""></option>
                        </select>
                    </form>
                </td>
                <td class="tableheader" style="text-align:right;">
                    <form name="frm_admin" method="POST" action="index.php">
                        <button name="btn_changeset_cancel" type="submit">go back to the schema page</button>
                    </form>
                </td>
            </tr>
        </table>
    </div>
    <form name="frm_admin" method="POST" action="index.php">
    </form>

    <xsl:choose>
        <xsl:when test="//instructionset">
            <xsl:call-template name="showchangesetcomments">
                <xsl:with-param name="comments" select="//instructionset/comments"/>
            </xsl:call-template>
            <xsl:if test="//instructionset/constructive/changeset">
                <xsl:for-each select="//instructionset/constructive/changeset">
                    <xsl:call-template name="showchangeset">
                        <xsl:with-param name="showdestructive" select="'no'"/>
                    </xsl:call-template>
                </xsl:for-each>
            </xsl:if>
            <xsl:if test="//instructionset/destructive/changeset">
                <xsl:for-each select="//instructionset/destructive/changeset">
                    <xsl:call-template name="showchangeset">
                        <xsl:with-param name="showconstructive" select="'no'"/>
                    </xsl:call-template>
                </xsl:for-each>
            </xsl:if>
        </xsl:when>
        <xsl:when test="//changeset">
            <xsl:for-each select="//changeset">
                <xsl:call-template name="showchangeset"/>
            </xsl:for-each>
        </xsl:when>
    </xsl:choose>

    </body></html>
    <!-- -->

</xsl:template>

<xsl:template name="showchangeset">
    <xsl:param name="showconstructive">yes</xsl:param>
    <xsl:param name="showdestructive">yes</xsl:param>

    <span class="titlemini">
        <xsl:value-of select="comments"/>
    </span>
    <br/><br/>

    <xsl:if test="$showconstructive='yes'">
        <span class="titlemini">
            <xsl:value-of select="name"/>
            <xsl:text> :: version :: </xsl:text>
            <xsl:value-of select="version"/>
            <xsl:text> :: constructive changes</xsl:text>
        </span>
        <TABLE class="tablemain">
            <tr><th class="tableheader" style="text-align:left;"> <span class="titlemini">tables added to schema </span> </th></tr>
            <xsl:for-each select="add">
                <tr><td class="tablebody"><xsl:value-of select="table"/></td></tr>
            </xsl:for-each>
        </TABLE>
        <TABLE class="tablemain">
            <xsl:for-each select="change/table">
                <xsl:call-template name="showtableadd"/>
            </xsl:for-each>
        </TABLE>
    </xsl:if>
    <xsl:if test="$showdestructive='yes'">
        <span class="titlemini">
            <xsl:value-of select="name"/>
            <xsl:text> :: version :: </xsl:text>
            <xsl:value-of select="version"/>
            <xsl:text> :: destructive changes</xsl:text>
        </span>
        <TABLE class="tablemain">
            <tr>
                <th class="tableheader" style="text-align:left;">
                    <span class="titlemini">
                        <xsl:text>tables removed from schema</xsl:text>
                    </span>
                </th>
            </tr>
            <xsl:for-each select="remove">
                <tr>
                    <td class="tablebody">
                        <xsl:value-of select="table"/>
                    </td>
                </tr>
            </xsl:for-each>
        </TABLE>
        <TABLE class="tablemain">
            <xsl:for-each select="change/table">
                <xsl:call-template name="showtableremove"/>
            </xsl:for-each>
        </TABLE>
    </xsl:if>
    <!-- -->

</xsl:template>

<xsl:template name="showtableadd">
    <xsl:variable name="tablename" select="name"/>

    <tr>
        <td colspan="11" class="tableheader">
            <span class="titlemini">
                <xsl:text>table</xsl:text>
                <xsl:value-of select="name"/>
            </span>
        </td>
    </tr>
    <tr>
        <td colspan="11">
            <span class="textmini">
                <xsl:value-of select="comments"/>
            </span>
        </td>
    </tr>
    <tr>
        <td colspan="11" class="tableheader">
            <span class="titlemini">
                <xsl:text>fields added to table</xsl:text>
                <xsl:value-of select="name"/>
            </span>
        </td>
    </tr>
    <tr>
        <th class="tableheader">name</th>
        <th class="tableheader">was called</th>
        <th class="tableheader">type</th>
        <th class="tableheader">length</th>
        <th class="tableheader">default</th>
        <th class="tableheader">autoincrement</th>
        <th class="tableheader">unsigned</th>
        <th class="tableheader">notnull</th>
        <th class="tableheader">comments</th>
        <th class="tableheader">timing</th>
    </tr>
    <xsl:for-each select="descendant::add/field">
        <xsl:call-template name="showfieldAdd">
            <xsl:with-param name="table"><xsl:value-of select="$tablename"/></xsl:with-param>
        </xsl:call-template>
    </xsl:for-each>
    <tr>
        <td colspan="11" class="tableheader">
            <span class="titlemini">
                <xsl:text>indexes added to table</xsl:text>
                <xsl:value-of select="name"/>
            </span>
        </td>
    </tr>
    <tr>
        <th class="tableheader">name</th>
        <th class="tableheader">was called</th>
        <th class="tableheader">primary</th>
        <th class="tableheader">unique</th>
        <th class="tableheader">fields</th>
        <th class="tableheader">timing</th>
    </tr>
    <xsl:for-each select="descendant::index/add/*">
        <xsl:call-template name="showindexAdd">
            <xsl:with-param name="table"><xsl:value-of select="$tablename"/></xsl:with-param>
        </xsl:call-template>
    </xsl:for-each>
</xsl:template>

<xsl:template name="showtableremove">
    <xsl:variable name="tablename" select="name"/>

    <tr>
        <td colspan="2" class="tableheader">
            <span class="titlemini">
                <xsl:text>fields removed from table</xsl:text>
                <xsl:value-of select="name"/>
            </span>
        </td>
    </tr>
    <tr>
        <th class="tableheader">name</th>
        <th class="tableheader">timing</th>
    </tr>
    <xsl:for-each select="descendant::remove/field">
        <xsl:call-template name="showfieldRemove">
            <xsl:with-param name="table"><xsl:value-of select="$tablename"/></xsl:with-param>
        </xsl:call-template>
    </xsl:for-each>
    <tr>
        <td colspan="2" class="tableheader">
            <span class="titlemini">
                <xsl:text>indexes removed from table</xsl:text>
                <xsl:value-of select="name"/>
            </span>
        </td>
    </tr>
    <tr>
        <th class="tableheader">name</th>
        <th class="tableheader">timing</th>
    </tr>
    <xsl:for-each select="descendant::index/remove">
        <xsl:call-template name="showindexRemove">
            <xsl:with-param name="table"><xsl:value-of select="$tablename"/></xsl:with-param>
        </xsl:call-template>
    </xsl:for-each>
</xsl:template>

<xsl:template name="showfieldAdd">

    <xsl:param name="table">unkown</xsl:param>
    <xsl:variable name="fieldprefix">changeset-<xsl:value-of select="$table"/>-add-<xsl:value-of select="name"/></xsl:variable>

    <tr>
        <td class="tablebody">
            <xsl:call-template name="showname"/>
        </td>

        <td class="tablebody">
            <xsl:call-template name="showwas">
                <xsl:with-param name="fieldname">
                    <xsl:value-of select="$fieldprefix"/>-was
                </xsl:with-param>
            </xsl:call-template>
        </td>
        <td class="tablebody"><xsl:call-template name="showtype"/></td>
        <td class="tablebody"><xsl:call-template name="showlength"/></td>
        <td class="tablebody"><xsl:call-template name="showdefault"/></td>
        <td class="tablebody"><xsl:call-template name="showautoincrement"/></td>
        <td class="tablebody"><xsl:call-template name="showunsigned"/></td>
        <td class="tablebody"><xsl:call-template name="shownotnull"/></td>
        <td class="tablebody"><xsl:call-template name="showcomments"/></td>
        <td class="tablebody">
            <xsl:call-template name="showtiming">
                <xsl:with-param name="fieldname"><xsl:value-of select="$fieldprefix"/>-timing-<xsl:value-of select="'constructive'"/></xsl:with-param>
                <xsl:with-param name="value">constructive</xsl:with-param>
            </xsl:call-template>
        </td>
    </tr>
</xsl:template>

<xsl:template name="showindexAdd">

    <xsl:param name="table">unkown</xsl:param>
    <xsl:variable name="fieldprefix">changeset-<xsl:value-of select="$table"/>-add-<xsl:value-of select="name"/></xsl:variable>

    <tr>
        <td class="tablebody">
            <xsl:value-of select="name(.)"/>
        </td>
        <td class="tablebody"><xsl:call-template name="showwas">
            <xsl:with-param name="fieldname"><xsl:value-of select="$fieldprefix"/>-was</xsl:with-param></xsl:call-template>
        </td>
        <td class="tablebody"><xsl:call-template name="showprimary"/></td>
        <td class="tablebody"><xsl:call-template name="showunique"/></td>
        <td class="tablebody"><xsl:call-template name="showfields"/></td>
        <td class="tablebody">
            <xsl:call-template name="showtiming">
                <xsl:with-param name="fieldname"><xsl:value-of select="$fieldprefix"/>-timing-<xsl:value-of select="'constructive'"/></xsl:with-param>
                <xsl:with-param name="value">constructive</xsl:with-param>
            </xsl:call-template>
        </td>
    </tr>
</xsl:template>

<xsl:template name="showfieldRemove">

    <xsl:param name="table">unkown</xsl:param>
    <xsl:variable name="fieldprefix">changeset-<xsl:value-of select="$table"/>-remove-<xsl:value-of select="name"/></xsl:variable>

    <tr>
        <td class="tablebody">
            <xsl:call-template name="showname"/>
        </td>
    </tr>
</xsl:template>

<xsl:template name="showindexRemove">

    <xsl:param name="table">unkown</xsl:param>
    <xsl:variable name="fieldprefix">changeset-<xsl:value-of select="$table"/>-remove-<xsl:value-of select="name"/></xsl:variable>

    <tr>
        <td class="tablebody">
            <xsl:call-template name="showname"/>
        </td>
    </tr>
</xsl:template>

<xsl:template name="showprimary">
    <xsl:value-of select="primary"/>
</xsl:template>

<xsl:template name="showunique">
    <xsl:value-of select="unique"/>
</xsl:template>

<xsl:template name="showfields">
    <table>
    <xsl:for-each select="descendant::indexfield">
        <tr>
            <td>
                <xsl:call-template name="showname"/>
                <xsl:text>(</xsl:text>
                <xsl:call-template name="showsorting"/>
                <xsl:text>)</xsl:text>
            </td>
        </tr>
    </xsl:for-each>
    </table>
</xsl:template>

<xsl:template name="showsorting">
    <xsl:value-of select="sorting"/>
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

<xsl:template name="showtiming">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:param name="value"><xsl:value-of select="timing"/></xsl:param>
    <!--form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">change</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="unsigned"/></span>
    <select name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none">
        <xsl:choose>
            <xsl:when test="$value = 'constructive'">
                <xsl:call-template name="selectConstructive"/>
            </xsl:when>
            <xsl:when test="$value = 'destructive'">
                <xsl:call-template name="selectDestructive"/>
            </xsl:when>
            <xsl:when test="$value = 'maintenance_constructive'">
                <xsl:call-template name="selectMConstructive"/>
            </xsl:when>
            <xsl:when test="$value = 'maintenance_destructive'">
                <xsl:call-template name="selectMDestructive"/>
            </xsl:when>
            <xsl:otherwise>
                <xsl:call-template name="selectEmptyTiming"/>
            </xsl:otherwise>
        </xsl:choose>
    </select>
    </form-->
</xsl:template>

<xsl:template name="showwas">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="was"/></xsl:variable>
    <!--form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="was"/></span>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form-->
</xsl:template>

<xsl:template name="showafteraddfield">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:param name="value">unkown</xsl:param>
    <!--form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="$value"/></span>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form-->
</xsl:template>

<xsl:template name="showbeforeremovefield">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:param name="value">unkown</xsl:param>
    <!--form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="$value"/></span>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form-->
</xsl:template>

<xsl:template name="showchangesetcomments">
    <xsl:param name="comments"> </xsl:param>
    <div id="comments_show" style="display:inline;">
        <span class="titlemini">
            <xsl:value-of select="$comments"/>
        </span>
    </div>
</xsl:template>

<xsl:template name="selectConstructive">
    <option value=""></option>
    <option value="constructive" selected="selected">constructive</option>
    <option value="destructive">destructive</option>
    <option value="m_constructive">maintenance_constructive</option>
    <option value="m_destructive">maintenance_destructive</option>
</xsl:template>
<xsl:template name="selectDestructive">
    <option value=""></option>
    <option value="constructive">constructive</option>
    <option value="destructive" selected="selected">destructive</option>
    <option value="m_constructive">maintenance_constructive</option>
    <option value="m_destructive">maintenance_destructive</option>
</xsl:template>
<xsl:template name="selectMConstructive">
    <option value=""></option>
    <option value="constructive">constructive</option>
    <option value="destructive">destructive</option>
    <option value="m_constructive" selected="selected">maintenance_constructive</option>
    <option value="m_destructive">maintenance_destructive</option>
</xsl:template>
<xsl:template name="selectMDestructive">
    <option value=""></option>
    <option value="constructive">constructive</option>
    <option value="destructive">destructive</option>
    <option value="m_constructive">maintenance_constructive</option>
    <option value="m_destructive" selected="selected">maintenance_destructive</option>
</xsl:template>
<xsl:template name="selectEmptyTiming">
    <option value="" selected="selected"></option>
    <option value="constructive">constructive</option>
    <option value="destructive">destructive</option>
    <option value="m_constructive">maintenance_constructive</option>
    <option value="m_destructive">maintenance_destructive</option>
</xsl:template>


</xsl:stylesheet>