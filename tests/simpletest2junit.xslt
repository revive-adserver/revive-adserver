<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="xml" version="1.0" encoding="UTF-8" indent="yes"/>
	<xsl:template match="/">
		<testsuite name="SimpleTest" errors="0">
			<xsl:attribute name="tests">
				<xsl:value-of select="count(//test)" />
			</xsl:attribute>
			<xsl:attribute name="failures">
				<xsl:value-of select="count(//fail)" />
			</xsl:attribute>
			<xsl:attribute name="time">
				<xsl:value-of select="sum(//time)" />
			</xsl:attribute>
			<properties/>
			<xsl:for-each select="//case/test">
				<testcase>
					<xsl:attribute name="time"><xsl:value-of select="time"/></xsl:attribute>
					<xsl:attribute name="classname"><xsl:value-of select="name"/></xsl:attribute>
					<xsl:attribute name="name"><xsl:value-of select="name"/></xsl:attribute>
					<xsl:for-each select="fail">
						<failure>
                                                        <xsl:value-of select="."/>
						</failure>
					</xsl:for-each>
				</testcase>
			</xsl:for-each>
			<system-out />
			<system-err />
		</testsuite>
	</xsl:template>
</xsl:stylesheet>

