<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output
    method="xml"
    indent="yes"
  />
    
  <xsl:template match="/">
    <project name="openads" default="test">
      <macrodef name="fulltest">
        <attribute name="test.name"/>
        <attribute name="php"/>
        <attribute name="db.type"/>
        <attribute name="db.host"/>
        <attribute name="db.port"/>
        <attribute name="db.username"/>
        <attribute name="db.password"/>
        <attribute name="db.name"/>
        <attribute name="db.table.type"/>
        <sequential>
          <exec dir="tests" executable="@{{php}}" failonerror="false" resultproperty="test.@{{test.name}}.configure" errorproperty="test.@{{test.name}}.error">
            <arg value="configuretest.php" />
            <arg value="@{{db.type}}" />
            <arg value="@{{db.host}}" />
            <arg value="@{{db.port}}" />
            <arg value="@{{db.username}}" />
            <arg value="@{{db.password}}" />
            <arg value="@{{db.name}}" />
            <arg value="@{{db.table.type}}" />
          </exec>
          <fail message="Can't create configuration file for test: @{{test.name}}! Reason: ${{test.@{test.name}.error}}">
            <condition>
              <not>
                <equals arg1="0" arg2="${{test.@{{test.name}}.configure}}"/>
              </not>
            </condition>
          </fail>
          <exec dir="tests" executable="@{{php}}" failonerror="false" output="build/test-results/@{{test.name}}.simpletest.xml" resultproperty="test.@{{test.name}}.result">
              <arg value="-q" />
              <arg value="cli_test_runner.php" />
              <arg value="@{{php}}"/>
              <arg value="@{{test.name}}"/>
          </exec>
          <xslt style="tests/simpletest2junit.xslt" basedir="build/test-results" destdir="build/test-reports">
            <mapper type="glob" from="@{{test.name}}.simpletest.xml" to="@{{test.name}}.junit.xml" />
          </xslt>
          <condition property="test.failure" value="@{{test.name}}">
            <not>
              <equals arg1="0" arg2="${{test.@{{test.name}}.result}}"/>
            </not>
          </condition>
          <exec dir="tests" executable="@{{php}}" failonerror="false" output="build/test-results/MDB2-@{{test.name}}.html">
            <arg value="run.php" />
            <arg value="--type=phpunit" />
            <arg value="--dir=../lib/pear/MDB2/tests/" />
          </exec>
          <exec dir="tests" executable="@{{php}}" failonerror="false" output="build/test-results/MDB2_Schema-@{{test.name}}.html">
            <arg value="run.php" />
            <arg value="--type=phpunit" />
            <arg value="--dir=../lib/pear/MDB2_Schema/tests/" />
          </exec>
        </sequential>
      </macrodef>

      <target name="test">
        <xsl:for-each select="tests/php/version">
          <xsl:call-template name="fulltest">
            <xsl:with-param name="php" select="."/>
          </xsl:call-template>
        </xsl:for-each>

        <!-- Fail the build if there was test failure -->
        <fail message="Simpletest Suite Failure: ${{test.failure}}">
          <condition>
            <isset property="test.failure"/>
          </condition>
        </fail>
      </target>
    </project>    

  </xsl:template>

  <xsl:template name="fulltest">
    <xsl:param name="php" select="."/>
    <xsl:for-each select="/tests/database/version">
      <xsl:element name="fulltest">
        <xsl:variable name="db.table.type.trimmed"><xsl:value-of select="normalize-space(@db.table.type)"/></xsl:variable>
        <xsl:variable name="db.name.suffix"><xsl:if test="$db.table.type.trimmed != ''">_<xsl:value-of select="$db.table.type.trimmed"/></xsl:if></xsl:variable>
        <xsl:attribute name="test.name"><xsl:value-of select="$php/@name"/>-<xsl:value-of select="@name"/>-<xsl:value-of select="$db.table.type.trimmed"/></xsl:attribute>
        <xsl:attribute name="php"><xsl:value-of select="$php/@executable"/></xsl:attribute>
        <xsl:attribute name="db.type"><xsl:value-of select="@db.type"/></xsl:attribute>
        <xsl:attribute name="db.host"><xsl:value-of select="@db.host"/></xsl:attribute>
        <xsl:attribute name="db.port"><xsl:value-of select="@db.port"/></xsl:attribute>
        <xsl:attribute name="db.username"><xsl:value-of select="@db.username"/></xsl:attribute>
        <xsl:attribute name="db.password"><xsl:value-of select="@db.password"/></xsl:attribute>
        <xsl:attribute name="db.name"><xsl:value-of select="@db.name"/>_<xsl:value-of select="$php/@name"/><xsl:value-of select="$db.name.suffix"/></xsl:attribute>
        <xsl:attribute name="db.table.type"><xsl:value-of select="@db.table.type"/></xsl:attribute>
      </xsl:element>
    </xsl:for-each>
  </xsl:template>

</xsl:transform>
