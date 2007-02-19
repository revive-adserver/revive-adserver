<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="*[*]">

<html><head><title>XSL Test</title>

<link rel="stylesheet" type="text/css" href="/upgrade_dev/xsl/mdb2_xsl.css"/>

</head>
<body>

  [<xsl:value-of select="name(.)"/>]


  <xsl:variable name="childnodes" select="*"/><!--all children-->
  <xsl:for-each select="$childnodes">
    <xsl:if test="generate-id(.)=
                  generate-id($childnodes[name(.)=name(current())])">
      [<xsl:value-of select="name(.)"/>]
    </xsl:if>
  </xsl:for-each>

  <xsl:apply-templates/>

</body>
</html>

</xsl:template>



</xsl:stylesheet>