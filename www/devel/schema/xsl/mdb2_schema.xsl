<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <!--  -->
    <html><head><title>Openads Schema</title>

    <link rel="stylesheet" type="text/css" href="css/mdb2_xsl.css"/>

    <script type="text/javascript" src="schema.js"/>
    <script type="text/javascript" src="../lib/xajax/xajax_js/xajax.js"></script>
    <script type="text/javascript">
        window.setTimeout(function () { if (!xajaxLoaded) { alert('Error: the xajax Javascript file could not be included. Perhaps the URL is incorrect?\nURL: ../lib/xajax/xajax_js/xajax.js'); } }, 6000);
    </script>

    </head>
    <body>
    <!--body onload="xajax_getSchemas();">
    <div id="schemas" style="display:block;"></div-->

    <xsl:variable name="filename"><xsl:value-of select="//database/name"/></xsl:variable>

    <div id="save" style="display:block;">
        <form id="frmFilename" method="POST" action="index.php">
            <table>
                <tr>
                    <td><span class="titlemini"><button name="viewraw" value="{$filename}" width="130px">View Raw Data</button></span></td>
                    <td><span class="titlemini"><xsl:text>See the unformatted data</xsl:text></span></td>
                </tr>
                <tr>
                    <td><span class="titlemini"><button name="viewdd" value="" width="130px">Data Dictionary</button></span></td>
                    <td><span class="titlemini"><xsl:text>All datatypes are defined in the dictionary</xsl:text></span></td>
                </tr>
                <tr>
                    <td><span class="titlemini"><button name="saveschema" value="{$filename}" width="130px">Save Schema</button></span></td>
                    <td><span class="titlemini"><xsl:text>The new schema will be saved to /var/mdbs_core.xml with a status of 'transitional'</xsl:text></span></td>
                </tr>
                <tr>
                    <td><span class="titlemini"><button name="revertschema" value="{$filename}" width="130px">Revert Schema</button></span></td>
                    <td><span class="titlemini"><xsl:text>Reload /etc/mdbs_core.xml 'final' schema</xsl:text></span></td>
                </tr>
                <tr>
                    <td><span class="titlemini"><button name="compare" value="{$filename}" width="130px">Compare Schemas</button></span></td>
                    <td><span class="titlemini"><xsl:text>/etc/mdbs_core.xml will be compared to /var/mdbs_core.xml and output to /var/mdbc_core.xml</xsl:text></span></td>
                </tr>
            </table>
        </form>
    </div>
    <!-- -->
    <br/>
    <span class="titlemini">
        <xsl:text>Schema: </xsl:text><xsl:value-of select="//database/name"/>
        <xsl:text> :: Version: </xsl:text><xsl:value-of select="//database/version"/>
        <xsl:text> :: Status: </xsl:text>
        <xsl:choose>
            <xsl:when test="//database/status='final'">
                <span style="font-weight:bold;color:black;"><xsl:value-of select="//database/status"/></span>
            </xsl:when>
            <xsl:otherwise>
                <span style="font-weight:bold;color:red;"><xsl:value-of select="//database/status"/></span>
            </xsl:otherwise>
        </xsl:choose>
    </span>
    <br/>
    <span class="titlemini"><xsl:value-of select="//database/comments"/></span>

    <div>
        <table class="tablemainnotes">
        <tr><th colspan="2">Notes about this tool</th></tr>
        <tr>
            <td>Data types from the data dictionary are readonly</td>
            <td>Custom data types should not be allowed</td>
        </tr>
        <tr>
            <td>Key fields need to be identified</td>
            <td>Referential integrity should be forced</td>
        </tr>
        </table>
    </div>
    <br/>
    <TABLE class="tablemain">
    <tr>
        <td class="tableheader"><xsl:call-template name="showtableadd"/></td>
    </tr>
    </TABLE>
    <br/>
    <xsl:for-each select="//database/table">
        <xsl:call-template name="showtable">
            <xsl:with-param name="tablename"><xsl:value-of select="name"/></xsl:with-param>
        </xsl:call-template>
        <xsl:call-template name="showtableindexes">
            <xsl:with-param name="tablename"><xsl:value-of select="name"/></xsl:with-param>
        </xsl:call-template>
        <xsl:call-template name="showtableforeignkeys">
            <xsl:with-param name="tablename"><xsl:value-of select="name"/></xsl:with-param>
        </xsl:call-template>
        <br/><br/>
    </xsl:for-each>
    <!-- -->

    </body></html>
    <!-- -->
</xsl:template>

<xsl:template name="showtable">

    <xsl:param name="tablename"><xsl:value-of select="name"/></xsl:param>

    <TABLE class="tablemain">

    <tr>
        <td class="tableheader">
            <span class="titlemini"><xsl:value-of select="name"/></span>
        </td>
        <td class="tableheader">
            <span class="titlemini"><xsl:value-of select="type"/></span>
        </td>
        <td class="tableheader">
            <xsl:call-template name="showtablerename"/>
        </td>
        <td class="tableheader">
            <xsl:call-template name="showtabledelete"/>
        </td>
        <td class="tableheader" colspan="7">
            <xsl:call-template name="showfieldadd">
                <xsl:with-param name="fieldname">[<xsl:value-of select="$tablename"/>][add]</xsl:with-param>
            </xsl:call-template>
        </td>
    </tr>
    <tr><td colspan="11"><span class="textmini">
        <xsl:value-of select="comments"/></span></td></tr>

    <tr>
    <td class="tableheader">name</td>
    <td class="tableheader">type</td>
    <td class="tableheader">length</td>
    <td class="tableheader">default</td>
    <td class="tableheader">autoincrement</td>
    <td class="tableheader">unsigned</td>
    <td class="tableheader">notnull</td>
    <td class="tableheader">comments</td>
    <td class="tableheader" colspan="2"></td>

    </tr>

    <xsl:for-each select="descendant::declaration/field">

        <xsl:call-template name="showfield">
        <xsl:with-param name="tablename">[database][table][<xsl:value-of select="$tablename"/>][declaration][field][<xsl:value-of select="name"/>]</xsl:with-param>
        </xsl:call-template>

    </xsl:for-each>

    </TABLE>
</xsl:template>


<xsl:template name="showtableindexes">

    <xsl:param name="tablename"><xsl:value-of select="name"/></xsl:param>

    <TABLE class="tablemain">

    <tr><td colspan="10" class="tableheader"> <span class="titlemini">indexes for
        <xsl:value-of select="$tablename"/></span> </td></tr>

    <xsl:for-each select="descendant::declaration/index">

        <xsl:call-template name="showindex">
        <xsl:with-param name="tablename">[database][table][<xsl:value-of select="$tablename"/>][declaration][index][<xsl:value-of select="name"/>]</xsl:with-param>
        </xsl:call-template>

    </xsl:for-each>
    </TABLE>
</xsl:template>

<xsl:template name="showtableforeignkeys">

    <xsl:param name="tablename"><xsl:value-of select="'unknown'"/></xsl:param>

    <TABLE class="tablemain">

    <tr><td colspan="10" class="tableheader"> <span class="titlemini">foreign key constraints for
        <xsl:value-of select="$tablename"/></span> </td></tr>

    <xsl:for-each select="descendant::declaration/foreignkey">

        <xsl:call-template name="showforeignkey">
            <xsl:with-param name="tablename">[database][table][<xsl:value-of select="$tablename"/>][declaration][foreignkey][<xsl:value-of select="name"/>]</xsl:with-param>
        </xsl:call-template>

    </xsl:for-each>
    </TABLE>
</xsl:template>

<xsl:template name="showfield">

    <xsl:param name="tablename">unkown</xsl:param>

    <tr>

    <td class="tablebody"><xsl:call-template name="showname">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[name]</xsl:with-param></xsl:call-template></td>

    <td class="tablebody"><xsl:call-template name="showtype">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[type]</xsl:with-param></xsl:call-template></td>

    <td class="tablebody"><xsl:call-template name="showlength">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[length]</xsl:with-param></xsl:call-template></td>

    <td class="tablebody"><xsl:call-template name="showdefault">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[default]</xsl:with-param></xsl:call-template></td>

    <td class="tablebody"><xsl:call-template name="showautoincrement">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[autoincrement]</xsl:with-param></xsl:call-template></td>

    <td class="tablebody"><xsl:call-template name="showunsigned">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[unsigned]</xsl:with-param></xsl:call-template></td>

    <td class="tablebody"><xsl:call-template name="shownotnull">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[notnull]</xsl:with-param></xsl:call-template></td>

    <td class="tablebody"><xsl:call-template name="showcomments">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[comments]</xsl:with-param></xsl:call-template></td>

    <td class="tablebody">
        <xsl:call-template name="showdelete">
            <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[delete]</xsl:with-param>
        </xsl:call-template>
    </td>
    <td class="tablebody">
        <xsl:call-template name="showchangetype">
            <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[edit]</xsl:with-param>
        </xsl:call-template>
    </td>

    </tr>
</xsl:template>

<xsl:template name="showindex">

    <xsl:param name="tablename">unkown</xsl:param>
    <tr>
    <td colspan="8">
    <TABLE class="tablemain">

    <tr>
    <td class="tableheader">name</td>
    <td class="tableheader">primary</td>
    <td class="tableheader">unique</td>
    <td class="tableheader" colspan="2">fields</td>
    </tr>

    <tr>

    <td class="tablebody"><xsl:call-template name="showname">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[name]</xsl:with-param></xsl:call-template></td>

    <td class="tablebody"><xsl:call-template name="showprimary">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[primary]</xsl:with-param></xsl:call-template></td>

    <td class="tablebody"><xsl:call-template name="showunique">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[unique]</xsl:with-param></xsl:call-template></td>

    <xsl:for-each select="field">

        <xsl:call-template name="showindexfield">
        <xsl:with-param name="tablename">[database][table][<xsl:value-of select="$tablename"/>][declaration][index][field][<xsl:value-of select="name"/>]</xsl:with-param>
        </xsl:call-template>

    </xsl:for-each>

    </tr>
    </TABLE>

    </td>
    </tr>

</xsl:template>

<xsl:template name="showforeignkey">

    <xsl:param name="tablename">unkown</xsl:param>
    <tr>
    <td colspan="8">
    <TABLE class="tablemain">

    <tr>
    <td class="tableheader">symbol</td>
    <td class="tableheader">id</td>
    <td class="tableheader" colspan="2">fields</td>
    </tr>

    <tr>

    <td class="tablebody"><xsl:call-template name="showsymbol">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[symbol]</xsl:with-param></xsl:call-template></td>

    <td class="tablebody"><xsl:call-template name="showname">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[id]</xsl:with-param></xsl:call-template></td>

    <xsl:for-each select="field">

        <xsl:call-template name="showforeignkeyfield">
        <xsl:with-param name="tablename">[database][table][<xsl:value-of select="$tablename"/>][declaration][foreignkey][field-<xsl:value-of select="name"/>]</xsl:with-param>
        </xsl:call-template>

    </xsl:for-each>

    </tr>
    </TABLE>

    </td>
    </tr>

</xsl:template>

<xsl:template name="showindexfield">

    <xsl:param name="tablename">unkown</xsl:param>
    <tr>
    <td>
    <TABLE class="tablemain">

    <tr>

    <td class="tablebody"><xsl:call-template name="showname">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[name]</xsl:with-param></xsl:call-template></td>

    <td class="tablebody"><xsl:call-template name="showsorting">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[sorting]</xsl:with-param></xsl:call-template></td>

    </tr>
    </TABLE>

    </td>
    </tr>
</xsl:template>

<xsl:template name="showforeignkeyfield">

    <xsl:param name="tablename">unkown</xsl:param>
    <tr>
    <td>
    <TABLE class="tablemain">

    <tr>

    <td class="tablebody"><xsl:call-template name="showname">
        <xsl:with-param name="fieldname"><xsl:value-of select="$tablename"/>[name]</xsl:with-param></xsl:call-template></td>

    </tr>
    </TABLE>

    </td>
    </tr>
</xsl:template>

<xsl:template name="showname">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="name"/></xsl:variable>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="name"/></span>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form>
</xsl:template>

<xsl:template name="showsorting">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="sorting"/></xsl:variable>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="sorting"/></span>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form>
</xsl:template>

<xsl:template name="showprimary">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="primary"/></xsl:variable>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="primary"/></span>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form>
</xsl:template>

<xsl:template name="showunique">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="unique"/></xsl:variable>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="unique"/></span>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form>
</xsl:template>

<xsl:template name="showsymbol">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="symbol"/></xsl:variable>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="symbol"/></span>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form>
</xsl:template>

<xsl:template name="showdefault">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="default"/></xsl:variable>
    <!--form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text-->
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="default"/></span>
    <!--input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form-->
</xsl:template>

<xsl:template name="showtype">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="type"/></xsl:variable>
    <!--form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button-->
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="type"/></span>
    <!--select name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none">
        <xsl:choose>
            <xsl:when test="type='integer'">
                <xsl:call-template name="selectInteger"/>
            </xsl:when>
            <xsl:when test="type='date'">
                <xsl:call-template name="selectDate"/>
            </xsl:when>
            <xsl:when test="type='text'">
                <xsl:call-template name="selectText"/>
            </xsl:when>
            <xsl:when test="type='date'">
                <xsl:call-template name="selectDate"/>
            </xsl:when>
            <xsl:when test="type='timestamp'">
                <xsl:call-template name="selectTimestamp"/>
            </xsl:when>
            <xsl:when test="type='float'">
                <xsl:call-template name="selectFloat"/>
            </xsl:when>
            <xsl:when test="type='decimal'">
                <xsl:call-template name="selectDecimal"/>
            </xsl:when>
            <xsl:otherwise>
                <option value="error">error</option>
            </xsl:otherwise>
        </xsl:choose>
    </select>
    </form-->
</xsl:template>

<xsl:template name="showlength">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="length"/></xsl:variable>
    <!--form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text-->
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="length"/></span>
    <!--input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form-->
</xsl:template>

<xsl:template name="showautoincrement">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="autoincrement"/></xsl:variable>
    <!--form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text-->
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="autoincrement"/></span>
    <!--select name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none">
        <xsl:choose>
            <xsl:when test="autoincrement = '0'">
                <xsl:call-template name="selectFalse"/>
            </xsl:when>
            <xsl:when test="autoincrement = '1'">
                <xsl:call-template name="selectTrue"/>
            </xsl:when>
            <xsl:otherwise>
                <xsl:call-template name="selectEmpty"/>
            </xsl:otherwise>
        </xsl:choose>
    </select>
    </form-->
</xsl:template>

<xsl:template name="showunsigned">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="unsigned"/></xsl:variable>
    <!--form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text-->
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="unsigned"/></span>
    <!--select name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none">
        <xsl:choose>
            <xsl:when test="unsigned = 'false'">
                <xsl:call-template name="selectFalse"/>
            </xsl:when>
            <xsl:when test="unsigned = 'true'">
                <xsl:call-template name="selectTrue"/>
            </xsl:when>
            <xsl:otherwise>
                <xsl:call-template name="selectEmpty"/>
            </xsl:otherwise>
        </xsl:choose>
    </select>
    </form-->
</xsl:template>

<xsl:template name="shownotnull">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="notnull"/></xsl:variable>
    <!--form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text-->
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="notnull"/></span>
    <!--select name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none">
        <xsl:choose>
            <xsl:when test="notnull = 'false'">
                <xsl:call-template name="selectFalse"/>
            </xsl:when>
            <xsl:when test="notnull = 'true'">
                <xsl:call-template name="selectTrue"/>
            </xsl:when>
            <xsl:otherwise>
                <xsl:call-template name="selectEmpty"/>
            </xsl:otherwise>
        </xsl:choose>
    </select>
    </form-->
</xsl:template>

<xsl:template name="showcomments">
    <xsl:param name="fieldname">unkown</xsl:param>
    <xsl:variable name="value"><xsl:value-of select="comments"/></xsl:variable>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_editFieldProperty(xajax.getFormValues('frm_{$fieldname}'));">edit</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline"><xsl:value-of select="comments"/></span>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="{$value}" style="display:none"/>
    </form>
</xsl:template>

<xsl:template name="showtableadd">
    <xsl:param name="fieldname">unkown</xsl:param>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button">add table</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline">
    <xsl:text>name: </xsl:text><input type="text" name="{$fieldname}_name" id="{$fieldname}" value="" style="display:inline"/>
    </span>
    </form>
</xsl:template>

<xsl:template name="showtablerename">
    <xsl:param name="fieldname">unkown</xsl:param>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button">rename table</button>
    </form>
</xsl:template>

<xsl:template name="showtabledelete">
    <xsl:param name="fieldname">unkown</xsl:param>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button">delete table</button>
    </form>
</xsl:template>

<xsl:template name="showfieldadd">
    <xsl:param name="fieldname">unkown</xsl:param>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_selectDataDictionary(xajax.getFormValues('frm_{$fieldname}'));">add column</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:inline">
    <xsl:text>name: </xsl:text><input type="text" name="{$fieldname}_name" id="{$fieldname}" value="" style="display:inline"/>
    <xsl:text> type: </xsl:text><select name="{$fieldname}" id="{$fieldname}_value" style="display:inline">
        <option value="id_med">id => mediumint notnull default=0 unsigned autoincrement</option>
        <option value="id_med_inc">id_inc => mediumint notnull default=0 unsigned</option>
        <option value="name">name => varchar(255) notnull</option>
        <option value="desc">description => text notnull</option>
    </select>
    </span>
    </form>
</xsl:template>

<xsl:template name="showchangetype">
    <xsl:param name="fieldname">unkown</xsl:param>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button" onclick="xajax_selectDataDictionary(xajax.getFormValues('frm_{$fieldname}'));">change type</button>
    <xsl:text> </xsl:text>
    <span class="textmini" id="span_{$fieldname}" style="display:none">
    <select name="{$fieldname}" id="{$fieldname}_value">
    </select>
    </span>
    </form>
</xsl:template>

<xsl:template name="showdelete">
    <xsl:param name="fieldname">unkown</xsl:param>
    <form id="frm_{$fieldname}" method="POST" action="">
    <button id="btn_{$fieldname}" type="button">delete</button>
    <xsl:text> </xsl:text>
    <input type="text" name="{$fieldname}" id="{$fieldname}" value="" style="display:none"/>
    </form>
</xsl:template>

<xsl:template name="selectInteger">
    <option value="date">date</option>
    <option value="decimal">decimal</option>
    <option value="float">float</option>
    <option value="integer" selected="selected">integer</option>
    <option value="text">text</option>
    <option value="timestamp">timestamp</option>
</xsl:template>
<xsl:template name="selectDecimal">
    <option value="date">date</option>
    <option value="decimal" selected="selected">decimal</option>
    <option value="float">float</option>
    <option value="integer">integer</option>
    <option value="text">text</option>
    <option value="timestamp">timestamp</option>
</xsl:template>
<xsl:template name="selectText">
    <option value="date">date</option>
    <option value="decimal">decimal</option>
    <option value="float">float</option>
    <option value="integer">integer</option>
    <option value="text" selected="selected">text</option>
    <option value="timestamp">timestamp</option>
</xsl:template>
<xsl:template name="selectDate">
    <option value="date" selected="selected">date</option>
    <option value="decimal">decimal</option>
    <option value="float">float</option>
    <option value="integer">integer</option>
    <option value="text">text</option>
    <option value="timestamp">timestamp</option>
</xsl:template>
<xsl:template name="selectTimestamp">
    <option value="date">date</option>
    <option value="decimal">decimal</option>
    <option value="float">float</option>
    <option value="integer">integer</option>
    <option value="text">text</option>
    <option value="timestamp" selected="selected">timestamp</option>
</xsl:template>
<xsl:template name="selectFloat">
    <option value="date">date</option>
    <option value="decimal">decimal</option>
    <option value="float" selected="selected">float</option>
    <option value="integer">integer</option>
    <option value="text">text</option>
    <option value="timestamp">timestamp</option>
</xsl:template>
<xsl:template name="selectTrue">
    <option value=""></option>
    <option value="true" selected="selected">true</option>
    <option value="false">false</option>
</xsl:template>
<xsl:template name="selectFalse">
    <option value=""></option>
    <option value="true">true</option>
    <option value="false" selected="selected">false</option>
</xsl:template>
<xsl:template name="selectEmpty">
    <option value="" selected="selected"></option>
    <option value="true">true</option>
    <option value="false">false</option>
</xsl:template>

</xsl:stylesheet>
