<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <!--  -->
    <html><head><title>OpenX Schema Changeset</title>

    <link rel="stylesheet" type="text/css" href="assets/css/mdb2_xsl.css"/>

    <script type="text/javascript" src="schema.js"/>
    <script type="text/javascript" src="lib/xajax/xajax_js/xajax.js"></script>
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
                <!--td class="tableheader" style="text-align:right;">
                    <form name="frm_test" method="POST" action="archive.php">
                        <button id="btn_migration_create" name="btn_migration_create" type="submit" style="display:none;">create a migration class</button>
                    </form>
                </td>
                <td class="tableheader" style="text-align:right;">
                    <form name="frm_admin" method="POST" action="schema.php">
                        <button name="btn_changeset_cancel" type="submit">go back to the schema page</button>
                    </form>
                </td-->
            </tr>
            <tr id="trans_changeset" style="display:block;">
                <td class="tableheader" colspan="10">
                    <form name="frm_admin" method="POST" action="schema.php">
                        <span class="titlemini">
                            <xsl:text>comments</xsl:text>
                            <br />
                            <textarea name="comments" cols="100" rows="1" ></textarea>
                            <br />
                            <xsl:text>version</xsl:text>
                            <br />
                            <input type="text" id="version" name="version" value="" size="10" />
                        </span>
                        <span class="titlemini" style="text-align:right;vertical-align:top;">
                            <input name="btn_commit_final" type="submit" value="finalise this changeset"/>
                        </span>
                    </form>
                </td>
            </tr>
        </table>
    </div>
    <form name="frm_admin" method="POST" action="schema.php">
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
        <xsl:if test="add">
            <TABLE class="tablemain">
                <tr>
                    <th class="tableheader" style="text-align:left;">
                        <span class="titlemini">
                            <xsl:text>tables added to schema</xsl:text>
                        </span>
                    </th>
                    <th class="tableheader" style="text-align:left;">was called</th>
                </tr>
                <xsl:for-each select="add/table">
                    <tr>
                        <td class="tablebody">
                            <xsl:value-of select="name"/>
                        </td>
                        <td class="tablebody">
                            <span id="was_edit_table" style="display:inline;">
                                <xsl:call-template name="showwastable">
                                    <xsl:with-param name="table">
                                        <xsl:value-of select="name"/>
                                    </xsl:with-param>
                                </xsl:call-template>
                            </span>
                            <span id="was_show_table" style="display:none;">
                                <xsl:value-of select="was"/>
                            </span>
                        </td>
                    </tr>
                </xsl:for-each>
            </TABLE>
        </xsl:if>
        <xsl:if test="rename">
            <TABLE class="tablemain">
                <tr>
                    <th class="tableheader" style="text-align:left;">
                        <span class="titlemini">
                            <xsl:text>tables renamed in schema</xsl:text>
                        </span>
                    </th>
                    <th class="tableheader" style="text-align:left;">was called</th>
                </tr>
                <xsl:for-each select="rename/table">
                    <tr>
                        <td class="tablebody">
                            <xsl:value-of select="name"/>
                        </td>
                        <td class="tablebody">
                            <xsl:value-of select="was"/>
                        </td>
                    </tr>
                </xsl:for-each>
            </TABLE>
        </xsl:if>
        <xsl:if test="change/table">
            <TABLE class="tablemain">
                <xsl:for-each select="change/table">
                    <xsl:variable name="tablename" select="name"/>
                    <xsl:if test="add/field">
                        <xsl:call-template name="showfieldheader">
                            <xsl:with-param name="method" select="'add'"/>
                        </xsl:call-template>
                        <xsl:for-each select="add/field">
                            <xsl:call-template name="showfield">
                                <xsl:with-param name="table"><xsl:value-of select="$tablename"/></xsl:with-param>
                                <xsl:with-param name="method"><xsl:value-of select="'add'"/></xsl:with-param>
                            </xsl:call-template>
                        </xsl:for-each>
                    </xsl:if>
                    <xsl:if test="rename/field">
                        <xsl:call-template name="showfieldheader">
                            <xsl:with-param name="method" select="'rename'"/>
                        </xsl:call-template>
                        <xsl:for-each select="rename/field">
                            <xsl:call-template name="showfield">
                                <xsl:with-param name="table"><xsl:value-of select="$tablename"/></xsl:with-param>
                                <xsl:with-param name="method"><xsl:value-of select="'rename'"/></xsl:with-param>
                            </xsl:call-template>
                        </xsl:for-each>
                    </xsl:if>
                    <xsl:if test="change/field">
                        <xsl:call-template name="showfieldheader">
                            <xsl:with-param name="method" select="'change'"/>
                        </xsl:call-template>
                        <xsl:for-each select="change/field">
                            <xsl:call-template name="showfield">
                                <xsl:with-param name="table"><xsl:value-of select="$tablename"/></xsl:with-param>
                                <xsl:with-param name="method"><xsl:value-of select="'change'"/></xsl:with-param>
                            </xsl:call-template>
                        </xsl:for-each>
                    </xsl:if>
                    <xsl:if test="index/add">
                        <xsl:call-template name="showindexheader">
                            <xsl:with-param name="method" select="'add'"/>
                        </xsl:call-template>
                        <xsl:for-each select="index/add">
                            <xsl:call-template name="showindex">
                                <xsl:with-param name="table"><xsl:value-of select="$tablename"/></xsl:with-param>
                                <xsl:with-param name="method"><xsl:value-of select="'add'"/></xsl:with-param>
                            </xsl:call-template>
                        </xsl:for-each>
                    </xsl:if>
                </xsl:for-each>
            </TABLE>
        </xsl:if>
    </xsl:if>

    <xsl:if test="$showdestructive='yes'">
        <span class="titlemini">
            <xsl:value-of select="name"/>
            <xsl:text> :: version :: </xsl:text>
            <xsl:value-of select="version"/>
            <xsl:text> :: destructive changes</xsl:text>
        </span>
         <xsl:if test="remove">
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
        </xsl:if>
        <xsl:if test="change/table">
            <TABLE class="tablemain">
                <xsl:for-each select="change/table">
                    <xsl:variable name="tablename" select="name"/>
                    <xsl:if test="remove/field">
                        <xsl:call-template name="showfieldheader">
                            <xsl:with-param name="method" select="'remove'"/>
                        </xsl:call-template>
                        <xsl:for-each select="remove/field">
                            <xsl:call-template name="showfield">
                                <xsl:with-param name="table"><xsl:value-of select="$tablename"/></xsl:with-param>
                                <xsl:with-param name="method"><xsl:value-of select="'remove'"/></xsl:with-param>
                            </xsl:call-template>
                        </xsl:for-each>
                    </xsl:if>
                    <xsl:if test="index/remove">
                        <xsl:call-template name="showindexheader">
                            <xsl:with-param name="method" select="'remove'"/>
                        </xsl:call-template>
                        <xsl:for-each select="index/remove">
                            <xsl:call-template name="showindex">
                                <xsl:with-param name="table"><xsl:value-of select="$tablename"/></xsl:with-param>
                                <xsl:with-param name="method"><xsl:value-of select="'remove'"/></xsl:with-param>
                            </xsl:call-template>
                        </xsl:for-each>
                    </xsl:if>
                </xsl:for-each>
            </TABLE>
        </xsl:if>
    </xsl:if>
    <!-- -->
</xsl:template>

<xsl:template name="showfieldheader">
    <xsl:param name="method">unknown</xsl:param>
    <xsl:variable name="tablename" select="name"/>

    <tr>
        <td colspan="11" class="tableheader">
            <span class="titlemini">
                <xsl:if test="$method='add'">
                    <xsl:text>fields added to table : </xsl:text>
                </xsl:if>
                <xsl:if test="$method='change'">
                    <xsl:text>fields changed in table : </xsl:text>
                </xsl:if>
                <xsl:if test="$method='rename'">
                    <xsl:text>fields renamed in table : </xsl:text>
                </xsl:if>
                <xsl:if test="$method='remove'">
                    <xsl:text>fields removed from table : </xsl:text>
                </xsl:if>
                <xsl:value-of select="name"/>
            </span>
        </td>
    </tr>
    <tr>
        <th class="tableheader" style="text-align:left;">name</th>
        <xsl:if test="$method!='remove'">
            <xsl:if test="$method!='change'">
                <th class="tableheader">was called</th>
            </xsl:if>
            <th class="tableheader">type</th>
            <th class="tableheader">length</th>
            <th class="tableheader">default</th>
            <th class="tableheader">autoincrement</th>
            <th class="tableheader">unsigned</th>
            <th class="tableheader">notnull</th>
            <th class="tableheader">timing</th>
            <!--th class="tableheader">comments</th-->
        </xsl:if>
    </tr>
</xsl:template>

<xsl:template name="showfield">

    <xsl:param name="table">unkown</xsl:param>
    <xsl:param name="method">unkown</xsl:param>
    <xsl:variable name="fieldprefix">changeset-<xsl:value-of select="$table"/>-<xsl:value-of select="$method"/>-<xsl:value-of select="name"/></xsl:variable>

    <tr>
        <td class="tablebody">
            <xsl:value-of select="name"/>
        </td>
        <xsl:if test="$method!='remove'">
            <xsl:if test="$method!='change'">
                <td class="tablebody">
                    <xsl:call-template name="showwasfield">
                        <xsl:with-param name="table">
                            <xsl:value-of select="$table"/>
                        </xsl:with-param>
                        <!--xsl:with-param name="method">
                            <xsl:value-of select="$method"/>
                        </xsl:with-param-->
                    </xsl:call-template>
                </td>
            </xsl:if>
            <td class="tablebody"><xsl:value-of select="type"/></td>
            <td class="tablebody"><xsl:value-of select="length"/></td>
            <td class="tablebody"><xsl:value-of select="default"/></td>
            <td class="tablebody"><xsl:value-of select="autoincrement"/></td>
            <td class="tablebody"><xsl:value-of select="unsigned"/></td>
            <td class="tablebody"><xsl:value-of select="notnull"/></td>
            <td class="tablebody">
                <xsl:call-template name="showtiming">
                    <!--xsl:with-param name="fieldname"><xsl:value-of select="$fieldprefix"/>-timing-<xsl:value-of select="'constructive'"/></xsl:with-param-->
                    <xsl:with-param name="value">constructive</xsl:with-param>
                </xsl:call-template>
            </td>
        </xsl:if>
    </tr>
</xsl:template>

<xsl:template name="showindexheader">
    <xsl:param name="method">unknown</xsl:param>
    <xsl:variable name="tablename" select="name"/>

    <tr>
        <td colspan="11" class="tableheader">
            <span class="titlemini">
                <xsl:if test="$method='add'">
                    <xsl:text>indexes added to table : </xsl:text>
                </xsl:if>
                <xsl:if test="$method='remove'">
                    <xsl:text>indexes removed from table : </xsl:text>
                </xsl:if>
                <xsl:value-of select="name"/>
            </span>
        </td>
    </tr>
    <tr>
        <th class="tableheader" style="text-align:left;">name</th>
        <xsl:if test="$method!='remove'">
            <th class="tableheader">primary</th>
            <th class="tableheader">unique</th>
            <th class="tableheader">fields</th>
            <th class="tableheader">timing</th>
        </xsl:if>
    </tr>
</xsl:template>

<xsl:template name="showindex">

    <xsl:param name="table">unkown</xsl:param>
    <xsl:param name="method">unkown</xsl:param>

    <tr>
        <td class="tablebody">
            <xsl:value-of select="name"/>
        </td>
        <xsl:if test="$method!='remove'">
            <td class="tablebody"><xsl:value-of select="primary"/></td>
            <td class="tablebody"><xsl:value-of select="unique"/></td>
            <td class="tablebody">
                <table>
                <xsl:for-each select="descendant::indexfield">
                    <tr>
                        <td>
                            <xsl:value-of select="name"/>
                            <xsl:text>(</xsl:text><xsl:value-of select="sorting"/><xsl:text>)</xsl:text>
                        </td>
                    </tr>
                </xsl:for-each>
                </table>
            </td>
            <td class="tablebody">
                <xsl:call-template name="showtiming">
                    <!--xsl:with-param name="fieldname"><xsl:value-of select="$fieldprefix"/>-timing-<xsl:value-of select="'constructive'"/></xsl:with-param-->
                    <xsl:with-param name="value">constructive</xsl:with-param>
                </xsl:call-template>
            </td>
        </xsl:if>
    </tr>
</xsl:template>

<xsl:template name="showwasfield">
    <xsl:param name="table">unkown</xsl:param>
    <xsl:variable name="field"><xsl:value-of select="name"/></xsl:variable>
    <xsl:variable name="fieldname"><xsl:value-of select="$table"/>_<xsl:value-of select="$field"/></xsl:variable>
    <xsl:variable name="value"><xsl:value-of select="was"/></xsl:variable>
    <xsl:variable name="form_name"><xsl:text>frm_</xsl:text><xsl:value-of select="$value"/></xsl:variable>

    <span id="was_edit_field_{$fieldname}" style="display:inline;">
        <form id="{$form_name}" method="POST" action="archive.php">

            <span class="titlemini" id="fld_old_{$fieldname}" name="fld_old_name" style="cursor: pointer;display:inline;" ondblclick="xajax_editFieldProperty(xajax.getFormValues('{$form_name}'),'{$table}','{$field}');" ><xsl:value-of select="$value"/></span>

            <input type="text" id="fld_new_{$fieldname}" name="fld_new_name" ondblclick="xajax_editFieldProperty(xajax.getFormValues('{$form_name}','{$table}','{$field}')" style="display:none" value="{$value}"/>

            <input type="submit" id="btn_field_save_{$fieldname}" name="btn_field_save" style="display:none" value="save"/>

            <input type="submit" id="btn_exit_{$fieldname}" name="btn_exit_name" onclick="xajax_exitFieldProperty(xajax.getFormValues('{$form_name}'),'{$table}','{$field}');" style="display:none" value="exit"/>

            <input type="hidden" name="fld_old_name" value="{$field}"/>
            <input type="hidden" name="table_name" value="{$table}"/>

        </form>
    </span>
    <span id="was_show_field_{$fieldname}" style="display:none;">
        <xsl:value-of select="was"/>
    </span>
</xsl:template>

<xsl:template name="showwastable">
    <xsl:param name="table">unkown</xsl:param>
    <xsl:variable name="field"><xsl:value-of select="name"/></xsl:variable>
    <xsl:variable name="fieldname"><xsl:value-of select="$table"/></xsl:variable>
    <xsl:variable name="value"><xsl:value-of select="was"/></xsl:variable>
    <xsl:variable name="form_name"><xsl:text>frm_</xsl:text><xsl:value-of select="$value"/></xsl:variable>

    <form id="{$form_name}" method="POST" action="archive.php">

        <span class="titlemini" id="tbl_old_{$fieldname}" name="tbl_old_name" style="cursor: pointer;display:inline;" ondblclick="xajax_editTableProperty(xajax.getFormValues('{$form_name}'),'{$table}');" ><xsl:value-of select="$value"/></span>

        <input type="text" id="tbl_new_{$fieldname}" name="tbl_new_name" ondblclick="xajax_editTableProperty(xajax.getFormValues('{$form_name}'),'{$table}');" style="display:none" value="{$value}"/>

        <input type="submit" id="btn_table_save_{$fieldname}" name="btn_table_save" style="display:none" value="save"/>

        <input type="submit" id="btn_table_exit_{$fieldname}" name="btn_exit_name" onclick="xajax_exitTableProperty(xajax.getFormValues('{$form_name}'),'{$table}');" style="display:none" value="exit"/>

        <input type="hidden" name="tbl_old_name" value="{$field}"/>
        <!--input type="hidden" name="table_name" value="{$table}"/-->

    </form>
</xsl:template>

<xsl:template name="showchangesetcomments">
    <xsl:param name="comments"> </xsl:param>
    <div id="comments_show" style="display:inline;">
        <span class="titlemini">
            <xsl:value-of select="$comments"/>
        </span>
    </div>
</xsl:template>

<xsl:template name="showtiming">
    <!--xsl:param name="fieldname">unkown</xsl:param-->
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

<!--xsl:template name="selectConstructive">
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
</xsl:template-->


</xsl:stylesheet>