<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<!--
     @(#) $Id: MDB.xsl,v 1.3 2006/04/16 10:20:35 toggg Exp $
  -->
<xsl:template match="/">
    <!--  -->
    <html><head><title>Metabase DB Documentation</title>
    <STYLE>
    .titlemini { font-family: Arial, Helvetica, sans-serif; font-size: 15px; font-weight: normal; color: rgb(133, 133, 133); text-decoration: none; letter-spacing: 1px; line-height: 95%; }
    .textmini { font-family: Arial, Helvetica, sans-serif; font-size: 10px; font-weight: normal; color: rgb(133, 133, 133); text-decoration: none; }
    .tablemain { border: solid 0px; margin: solid 0px; }
    .tableheader { padding: 3px; border: solid 0px; margin: 0px; background-color: rgb(235, 235, 235); font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(133, 133, 133); font-weight: bold; text-decoration: none; }
    .tablebody { padding: 3px; border-top: solid 1px; border-left: solid 1px; border-bottom: solid 1px; border-right: solid 1px; border-color: rgb(210, 210, 210); margin: solid 0px; font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: rgb(133, 133, 133); text-decoration: none; }
    </STYLE>
    </head>
    <body>

    <!-- -->
    <br/><span class="titlemini">database
    <xsl:value-of select="database/name"/></span><br/><br/>
    <TABLE class="tablemain">
    <xsl:for-each select="database/table">
        <xsl:call-template name="showtable"/>
    </xsl:for-each>
    </TABLE>
    <!-- -->

    </body></html>
    <!-- -->
</xsl:template>

<xsl:template name="showtable">
    <tr><td colspan="9" class="tableheader"> <span class="titlemini">table
        <xsl:value-of select="name"/></span> </td></tr>
    <tr><td colspan="9"><span class="textmini">
        <xsl:value-of select="comments"/></span></td></tr>

    <tr><td class="tableheader">field</td>
    <td class="tableheader">type</td>
    <td class="tableheader">length</td>
    <td class="tableheader">default</td>
    <td class="tableheader">autoincrement</td>
    <td class="tableheader">unsigned</td>
    <td class="tableheader">notnull</td>
    <td class="tableheader">comments</td>
    <td class="tableheader">indexes</td>
    </tr>

    <xsl:for-each select="descendant::declaration/field">

        <xsl:call-template name="showfield"/>
    </xsl:for-each>

    <tr><td colspan="2" height="18">  </td> </tr>
</xsl:template>

<xsl:template name="showfield">
    <tr>

    <td class="tablebody"><span class="textmini">
    <xsl:value-of select="name"/></span></td>

    <td class="tablebody"><span class="textmini">
    <xsl:value-of select="type"/></span></td>

    <td class="tablebody"><span class="textmini">
    <xsl:value-of select="length"/></span></td>

    <td class="tablebody"><span class="textmini">
    <xsl:value-of select="default"/></span></td>

    <td class="tablebody"><span class="textmini">
    <xsl:value-of select="autoincrement"/></span></td>

    <td class="tablebody"><span class="textmini">
    <xsl:value-of select="unsigned"/></span></td>

    <td class="tablebody"><span class="textmini">
    <xsl:value-of select="notnull"/></span></td>

    <td class="tablebody"><span class="textmini">
    <xsl:value-of select="comments"/></span></td>

    <xsl:variable name="curfield" select="current()/name"/>

    <td class="tablebody"><span class="textmini">
    <xsl:for-each select="following-sibling::index">
         <xsl:if test="$curfield=field/name">
         <br/>index <xsl:value-of select="name"/>
            <xsl:if test="unique"> unique</xsl:if>
            <xsl:if test="primary"> primary</xsl:if>

         </xsl:if>

    </xsl:for-each>
    </span></td>

    </tr>
</xsl:template>

<xsl:template name="showlength">
    <xsl:value-of select="//length"/>
</xsl:template>

<xsl:template name="showdefault">
    <xsl:value-of select="//default"/>
</xsl:template>

<xsl:template name="showautoincrement">
    <xsl:if test="//autoincrement = 1">
        true
    </xsl:if>
    <xsl:if test="//autoincrement = 0">
        false
    </xsl:if>
</xsl:template>

<xsl:template name="showunsigned">
    <xsl:value-of select="//unsigned"/>
</xsl:template>

<xsl:template name="shownotnull">
    <xsl:value-of select="//notnull"/>
</xsl:template>

</xsl:stylesheet>
