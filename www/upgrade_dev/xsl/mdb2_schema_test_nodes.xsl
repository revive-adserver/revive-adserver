<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

 <xsl:template match="field">
  <xsl:apply-templates/>
 </xsl:template>
 <xsl:template match="field/*">
  <xsl:element name="field">
   <xsl:attribute name="name"><xsl:value-of select="name()"/></xsl:attribute>
   <xsl:attribute name="content"><xsl:value-of select="text()"/></xsl:attribute>
  </xsl:element>
 </xsl:template>
</xsl:stylesheet>