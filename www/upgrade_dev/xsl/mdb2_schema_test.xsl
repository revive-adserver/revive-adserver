<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<!--xsl:stylesheet version="2.0"
 	 xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
 	 xmlns:mdb="http:://www.openads.org"
 	 exclude-result-prefixes="mdb"
-->

<!--xsl:function name="mdb:getNodeName" as="xs:string">

  <xsl:param name="param" as="xs:string"/>
  <xsl:sequence select="'sequence'"/>

</xsl:function-->

<!--xsl:template match="/"-->
<xsl:template match="name">
<!--xsl:template match="*[*]"-->


    <html><head><title>XSL Test</title>

    <link rel="stylesheet" type="text/css" href="/upgrade_dev/xsl/mdb2_xsl.css"/>

    </head>
    <body>

    <xsl:call-template name="getFieldName"/>
    <!--xsl:call-template name="fields"/-->
    <!--xsl:call-template name="iterate"/-->
    <!--xsl:call-template name="myfunction"/-->

    <!--xsl:apply-templates/-->

    </body>
    </html>

</xsl:template>

<!--xsl:template name="myfunction">

    <xsl:choose>
        <xsl:when test="function-available('mdb:getNodeName')">
          <xsl:text>function available</xsl:text>
          <xsl:value-of select="mdb:getNodeName('param')"/>
        </xsl:when>
        <xsl:otherwise>
          <xsl:text>function not available</xsl:text>
        </xsl:otherwise>
    </xsl:choose>

</xsl:template-->

<xsl:template name="iterate">

  [<xsl:value-of select="name(.)"/>]

  <xsl:variable name="childnodes" select="*"/>
  <xsl:for-each select="$childnodes">
    [<xsl:value-of select="name(.)"/>]
    <xsl:choose>
        <xsl:when test="name">
            [<xsl:value-of select="name"/>]
        </xsl:when>
        <xsl:when test="text()">
            [<xsl:value-of select="text()"/>]
        </xsl:when>
    </xsl:choose>
  </xsl:for-each>

</xsl:template>

<xsl:template name="fields">

    <xsl:for-each select="ancestor-or-self::*">

        [<xsl:value-of select="name()"/>]
        <xsl:if test="name">
            [<xsl:value-of select="name"/>]
        </xsl:if>

    </xsl:for-each>

</xsl:template>

<xsl:template name="getFieldName">

    <xsl:for-each select="ancestor-or-self::*">
        <xsl:choose>
            <xsl:when test="name()='database'">
                [<xsl:value-of select="name()"/>][<xsl:value-of select="name"/>]
            </xsl:when>
            <xsl:when test="name()='table'">
                [<xsl:value-of select="name()"/>][<xsl:value-of select="name"/>]
            </xsl:when>
            <xsl:when test="name()='index'">
                [<xsl:value-of select="name()"/>][<xsl:value-of select="name"/>]
            </xsl:when>
            <xsl:when test="name()='foreignkey'">
                [<xsl:value-of select="name()"/>][<xsl:value-of select="name"/>]
            </xsl:when>
            <xsl:when test="name()='field'">
                [<xsl:value-of select="name()"/>][<xsl:value-of select="name"/>]
            </xsl:when>
        </xsl:choose>
    </xsl:for-each>

</xsl:template>

</xsl:stylesheet>

