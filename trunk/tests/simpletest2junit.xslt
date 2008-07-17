<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="xml" version="1.0" encoding="UTF-8" indent="yes"/>
	<!-- misc variables -->
	<!--<xsl:variable name="classname" select="test/name" />-->
	<!--<xsl:variable name="total-tests" select="count(//test)"/>-->
	<!--<xsl:variable name="total-failures" select="count(//fail)"/>-->
	<xsl:template match="/">
		<testsuite name="SimpleTest" errors="0" time="0.0">
			<xsl:attribute name="tests">
				<xsl:value-of select="count(//test)" />
			</xsl:attribute>
			<xsl:attribute name="failures">
				<xsl:value-of select="count(//fail)" />
			</xsl:attribute>
			<properties/>
			<xsl:for-each select="//case/test">
				<testcase time="0.0">
					<xsl:attribute name="classname"><xsl:value-of select="name"/></xsl:attribute>
					<xsl:attribute name="name"><xsl:value-of select="name"/></xsl:attribute>
					<xsl:for-each select="fail">
						<!--<xsl:variable name="file" select="" />-->
						<!--<xsl:variable name="line" select="" />-->
						<failure>
							<xsl:attribute name="type">Standard</xsl:attribute>
							<xsl:attribute name="message">null</xsl:attribute>
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

