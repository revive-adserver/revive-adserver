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
    <body>
    <!-- -->

    <xsl:choose>
        <xsl:when test="//instructionset">
            <!--xsl:call-template name="showform">
                <xsl:with-param name="filename" select="//instructionset/name"/>
            </xsl:call-template-->
            <xsl:if test="//instructionset/constructive/changeset">
                <xsl:text>constructive changes</xsl:text>
                <xsl:for-each select="//instructionset/constructive/changeset">
                    <xsl:call-template name="showchangeset">
                        <xsl:with-param name="showdestructive" select="'no'"/>
                    </xsl:call-template>
                </xsl:for-each>
            </xsl:if>
            <xsl:if test="//instructionset/destructive/changeset">
                <xsl:text>destructive changes</xsl:text>
                <xsl:for-each select="//instructionset/destructive/changeset">
                    <xsl:call-template name="showchangeset">
                        <xsl:with-param name="showconstructive" select="'no'"/>
                    </xsl:call-template>
                </xsl:for-each>
            </xsl:if>
        </xsl:when>
        <xsl:when test="//changeset">
            <!--xsl:call-template name="showform">
                <xsl:with-param name="filename" select="//changeset/name"/>
            </xsl:call-template-->
            <xsl:for-each select="//changeset">
                <xsl:call-template name="showchangeset"/>
            </xsl:for-each>
        </xsl:when>
    </xsl:choose>
    <form name="frm_admin" method="POST" action="index.php">
        <table class="tablemain">
        <tr>
            <td class="tableheader" style="text-align:center;"><button name="btn_changeset_delete" type="submit">delete</button></td>
            <td class="tableheader" style="text-align:center;"><button name="btn_changeset_cancel" type="submit">go back</button></td>
        </tr>
        </table>
    </form>

    <div>
        <table class="tablemainnotes">
        <tr><th>Notes About Creating a Package</th></tr>
        <tr>
            <td>Along with this changeset, a Migration class php file will be generated</td>
        </tr>
        <tr>
            <td>The Migration class will automatically generate before and after event handlers for each of the events listed in the changeset. You can edit these methods to handle any specific data transformation that you require</td>
        </tr>
        </table>
    </div>

    </body></html>
    <!-- -->

</xsl:template>

<xsl:template name="showchangeset">
    <xsl:param name="showconstructive">yes</xsl:param>
    <xsl:param name="showdestructive">yes</xsl:param>

    <br/>
    <span class="titlemini">
        <xsl:value-of select="name"/>version:<xsl:value-of select="version"/>
    </span>
    <br/>

    <span class="titlemini">
        <xsl:value-of select="comments"/>
    </span>
    <br/><br/>

    <xsl:if test="$showconstructive='yes'">
        <TABLE class="tablemain">
        <xsl:for-each select="add">
            <xsl:call-template name="showadd"/>
        </xsl:for-each>
        </TABLE>
        <TABLE class="tablemain">
        <xsl:for-each select="change/table">
            <xsl:call-template name="showtableadd"/>
        </xsl:for-each>
        </TABLE>
    </xsl:if>
    <xsl:if test="$showdestructive='yes'">
        <TABLE class="tablemain">
        <xsl:for-each select="remove">
            <xsl:call-template name="showremove"/>
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

<xsl:template name="showremove">

    <tr><th class="tableheader"> <span class="titlemini">tables removed from schema </span> </th></tr>
    <xsl:for-each select="descendant::table">
        <tr><td><xsl:value-of select="table"/></td></tr>
    </xsl:for-each>

</xsl:template>

<xsl:template name="showtableadd">
    <xsl:variable name="tablename" select="name"/>

    <tr><td colspan="11" class="tableheader"> <span class="titlemini">table
        <xsl:value-of select="name"/></span> </td></tr>
    <tr><td colspan="11"><span class="textmini">
        <xsl:value-of select="comments"/></span></td></tr>

    <tr><td colspan="11" class="tableheader"> <span class="titlemini">fields added to table <xsl:value-of select="name"/></span> </td></tr>
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

    <tr><td colspan="11" class="tableheader"> <span class="titlemini">indexes added to table <xsl:value-of select="name"/></span> </td></tr>
    <tr>
    <th class="tableheader">name</th>
    <th class="tableheader">was called</th>
    <th class="tableheader">primary</th>
    <th class="tableheader">unique</th>
    <th class="tableheader">fields</th>
    <th class="tableheader">timing</th>
    </tr>
    <xsl:for-each select="descendant::index/add">
        <xsl:call-template name="showindexAdd">
            <xsl:with-param name="table"><xsl:value-of select="$tablename"/></xsl:with-param>
        </xsl:call-template>
    </xsl:for-each>

</xsl:template>

<xsl:template name="showtableremove">
    <xsl:variable name="tablename" select="name"/>

    <tr><td colspan="2" class="tableheader"> <span class="titlemini">fields removed from table <xsl:value-of select="name"/></span></td></tr>
    <tr>
    <th class="tableheader">name</th>
    <th class="tableheader">timing</th>
    </tr>
    <xsl:for-each select="descendant::remove/field">
        <xsl:call-template name="showfieldRemove">
            <xsl:with-param name="table"><xsl:value-of select="$tablename"/></xsl:with-param>
        </xsl:call-template>
    </xsl:for-each>

    <tr><td colspan="2" class="tableheader"> <span class="titlemini">indexes removed from table <xsl:value-of select="name"/></span></td></tr>
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

    <td class="tablebody"><xsl:call-template name="showname"/></td>

    <td class="tablebody"><xsl:call-template name="showwas">
        <xsl:with-param name="fieldname"><xsl:value-of select="$fieldprefix"/>-was</xsl:with-param></xsl:call-template></td>

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

    <!--td class="tablebody"><xsl:call-template name="showafteraddfield">
        <xsl:with-param name="fieldname"><xsl:value-of select="$fieldprefix"/>-afterAddField-<xsl:value-of select="name"/></xsl:with-param>
        <xsl:with-param name="value">afterAddField_<xsl:value-of select="$table"/>_<xsl:value-of select="name"/></xsl:with-param>
    </xsl:call-template></td-->

    </tr>
</xsl:template>

<xsl:template name="showindexAdd">

    <xsl:param name="table">unkown</xsl:param>
    <xsl:variable name="fieldprefix">changeset-<xsl:value-of select="$table"/>-add-<xsl:value-of select="name"/></xsl:variable>

    <tr>

    <td class="tablebody"><xsl:call-template name="showname"/></td>

    <td class="tablebody"><xsl:call-template name="showwas">
        <xsl:with-param name="fieldname"><xsl:value-of select="$fieldprefix"/>-was</xsl:with-param></xsl:call-template></td>

    <td class="tablebody"><xsl:call-template name="showprimary"/></td>
    <td class="tablebody"><xsl:call-template name="showunique"/></td>
    <td class="tablebody"><xsl:call-template name="showfields"/></td>
    <td class="tablebody">
        <xsl:call-template name="showtiming">
            <xsl:with-param name="fieldname"><xsl:value-of select="$fieldprefix"/>-timing-<xsl:value-of select="'constructive'"/></xsl:with-param>
            <xsl:with-param name="value">constructive</xsl:with-param>
        </xsl:call-template>
    </td>

    <!--td class="tablebody"><xsl:call-template name="showafteraddfield">
        <xsl:with-param name="fieldname"><xsl:value-of select="$fieldprefix"/>-afterAddField-<xsl:value-of select="name"/></xsl:with-param>
        <xsl:with-param name="value">afterAddField_<xsl:value-of select="$table"/>_<xsl:value-of select="name"/></xsl:with-param>
    </xsl:call-template></td-->

    </tr>
</xsl:template>

<xsl:template name="showfieldRemove">

    <xsl:param name="table">unkown</xsl:param>
    <xsl:variable name="fieldprefix">changeset-<xsl:value-of select="$table"/>-remove-<xsl:value-of select="name"/></xsl:variable>

    <tr>

    <td class="tablebody"><xsl:call-template name="showname"/></td>
    <!--td class="tablebody"><xsl:call-template name="showtiming"><xsl:with-param select="'destructive'"/></xsl:call-template></td-->
    <!--td class="tablebody"><xsl:call-template name="showbeforeremovefield">
        <xsl:with-param name="fieldname"><xsl:value-of select="$fieldprefix"/>-beforeRemoveField-<xsl:value-of select="name"/></xsl:with-param>
        <xsl:with-param name="value">beforeRemoveField_<xsl:value-of select="$table"/>_<xsl:value-of select="name"/></xsl:with-param>
    </xsl:call-template></td-->

    </tr>
</xsl:template>

<xsl:template name="showindexRemove">

    <xsl:param name="table">unkown</xsl:param>
    <xsl:variable name="fieldprefix">changeset-<xsl:value-of select="$table"/>-remove-<xsl:value-of select="name"/></xsl:variable>

    <tr>

    <td class="tablebody"><xsl:call-template name="showname"/></td>
    <!--td class="tablebody"><xsl:call-template name="showtiming"><xsl:with-param select="'destructive'"/></xsl:call-template></td-->
    <!--td class="tablebody"><xsl:call-template name="showbeforeremovefield">
        <xsl:with-param name="fieldname"><xsl:value-of select="$fieldprefix"/>-beforeRemoveField-<xsl:value-of select="name"/></xsl:with-param>
        <xsl:with-param name="value">beforeRemoveField_<xsl:value-of select="$table"/>_<xsl:value-of select="name"/></xsl:with-param>
    </xsl:call-template></td-->

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
        <tr><td><xsl:call-template name="showname"/> (<xsl:call-template name="showsorting"/>)</td></tr>
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
    <form id="frm_{$fieldname}" method="POST" action="">
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
    </form>
</xsl:template>

<xsl:template name="showwas">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="was"/></xsl:variable>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="was"/></span>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form>
</xsl:template>

<xsl:template name="showafteraddfield">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:param name="value">unkown</xsl:param>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="$value"/></span>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form>
</xsl:template>

<xsl:template name="showbeforeremovefield">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:param name="value">unkown</xsl:param>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="$value"/></span>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form>
</xsl:template>

<xsl:template name="showform">

    <xsl:param name="filename" select="unkown"/>

    <div id="save" style="display:block;">
        <form id="frmFilename" method="POST" action="index.php">
            <table>
            <tr>
            <td><button name="savechangeset" value="{$filename}">Save Changeset</button></td>
            <!--td><button name="createinstructionset" value="{$filename}">Create Instruction Set</button></td-->
            <td><button name="createpackage" value="{$filename}">Create Upgrade Package</button></td>
            <td><span class="titlemini"><button name="viewraw" value="{$filename}" width="130px">View Raw Data</button></span></td>
            </tr>
            </table>
        </form>
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