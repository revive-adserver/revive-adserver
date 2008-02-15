<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <!--  -->
    <html><head><title>OpenX Data Dictionary</title>

    <link rel="stylesheet" type="text/css" href="../schema/css/mdb2_xsl.css"/>

    </head>
    <body>

    <!-- -->
    <TABLE class="tablemain">
    <tr>
    <th class="tableheader" colspan="7">OpenX Data Dictionary</th>
    </tr>
    <tr>
    <th class="tableheader">name</th>
    <th class="tableheader">type</th>
    <th class="tableheader">length</th>
    <th class="tableheader">default</th>
    <th class="tableheader">autoincrement</th>
    <th class="tableheader">unsigned</th>
    <th class="tableheader">notnull</th>
    </tr>

    <xsl:for-each select="descendant::field">
        <xsl:call-template name="showfield"/>
    </xsl:for-each>

    </TABLE>

    </body></html>
    <!-- -->

</xsl:template>


<xsl:template name="showfield">

    <xsl:variable name="fieldprefix">dictionary-field-add-<xsl:value-of select="name"/></xsl:variable>

    <tr>

    <td class="tablebody"><xsl:call-template name="showname"/></td>
    <td class="tablebody"><xsl:call-template name="showtype"/></td>
    <td class="tablebody"><xsl:call-template name="showlength"/></td>
    <td class="tablebody"><xsl:call-template name="showdefault"/></td>
    <td class="tablebody"><xsl:call-template name="showautoincrement"/></td>
    <td class="tablebody"><xsl:call-template name="showunsigned"/></td>
    <td class="tablebody"><xsl:call-template name="shownotnull"/></td>

    </tr>

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

</xsl:stylesheet>
