<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <!--  -->
    <html><head><title>OpenX Upgrade Package</title>

    <link rel="stylesheet" type="text/css" href="assets/css/mdb2_xsl.css"/>

    </head>
    <body>

    <div class="bodydiv">

        <table class="tablemain">
            <tr>
                <td class="tableheader"><xsl:text>Name</xsl:text></td>
                <td ><xsl:value-of select="//upgrade/name"/></td>
            </tr>
            <tr>
                <td class="tableheader"><xsl:text>Creation Date</xsl:text></td>
                <td ><xsl:value-of select="//upgrade/creationDate"/></td>
            </tr>
            <tr>
                <td class="tableheader"><xsl:text>Author</xsl:text></td>
                <td ><xsl:value-of select="//upgrade/author"/></td>
            </tr>
            <tr>
                <td class="tableheader"><xsl:text>Email</xsl:text></td>
                <td ><xsl:value-of select="//upgrade/authorEmail"/></td>
            </tr>
            <tr>
                <td class="tableheader"><xsl:text>URL</xsl:text></td>
                <td ><xsl:value-of select="//upgrade/authorUrl"/></td>
            </tr>
            <tr>
                <td class="tableheader"><xsl:text>License</xsl:text></td>
                <td ><xsl:value-of select="//upgrade/license"/></td>
            </tr>
            <tr>
                <td class="tableheader"><xsl:text>Description</xsl:text></td>
                <td ><xsl:value-of select="//upgrade/description"/></td>
            </tr>
            <tr>
                <td class="tableheader"><xsl:text>Version From</xsl:text></td>
                <td ><xsl:value-of select="//upgrade/versionFrom"/></td>
            </tr>
            <tr>
                <td class="tableheader"><xsl:text>Version To</xsl:text></td>
                <td ><xsl:value-of select="//upgrade/versionTo"/></td>
            </tr>
            <tr>
                <td class="tableheader"><xsl:text>Pre Upgrade Script</xsl:text></td>
                <td ><xsl:value-of select="//upgrade/prescript"/></td>
            </tr>
            <tr>
                <td class="tableheader"><xsl:text>Post Upgrade Script</xsl:text></td>
                <td ><xsl:value-of select="//upgrade/postscript"/></td>
            </tr>
        </table>
    </div>

    </body></html>
    <!-- -->

</xsl:template>



</xsl:stylesheet>
