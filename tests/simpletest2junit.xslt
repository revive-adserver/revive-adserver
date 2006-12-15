<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <testsuite name="SimpleTest tests">
        <xsl:apply-templates />
    </testsuite>
</xsl:template>



<xsl:template match="group">
<testsuite>
    <xsl:attribute name="name">
        <xsl:value-of select="name" />
    </xsl:attribute>
    <xsl:apply-templates select="group"/> 
    <xsl:apply-templates select="case"/>
</testsuite>
</xsl:template>



<xsl:template match="case">
    <testcase>
        <xsl:attribute name="name">
            <xsl:value-of select="name" />
        </xsl:attribute>
        <xsl:for-each select="test/fail">
            <failure>
                <xsl:value-of select="." />
            </failure>
        </xsl:for-each>
        <xsl:for-each select="test/exception">
            <error>
                <xsl:value-of select="." />
            </error>
        </xsl:for-each>
    </testcase>
</xsl:template>



</xsl:stylesheet>
