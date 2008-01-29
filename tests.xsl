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
        <attribute name="audit.enabled"/>
        <sequential>
          <echo message="fulltest for @{{test.name}} using @{{php}}"/>
          <echo>before config</echo>
          <exec dir="tests" executable="@{{php}}" failonerror="false" resultproperty="test.@{{test.name}}.configure" errorproperty="test.@{{test.name}}.error">
            <arg value="configuretest.php" />
            <arg value="@{{db.type}}" />
            <arg value="@{{db.host}}" />
            <arg value="@{{db.port}}" />
            <arg value="@{{db.username}}" />
            <arg value="@{{db.password}}" />
            <arg value="@{{db.name}}" />
            <arg value="@{{db.table.type}}" />
            <arg value="@{{audit.enabled}}" />
            <arg value="false" /> <!-- loadBalancingEnabled - see OAP-19 -->
            <arg value="@{{db.name}}" /> <!-- loadBalancingName see OAP-19 -->
          </exec>
          <echo>after config</echo>
          <fail message="Can't create configuration file for test: @{{test.name}}! Reason: ${{test.@{test.name}.error}}">
            <condition>
              <not>
                <equals arg1="0" arg2="${{test.@{{test.name}}.configure}}"/>
              </not>
            </condition>
          </fail>
          <echo>before simple tests</echo>
          <exec dir="tests" executable="@{{php}}" failonerror="false"
          		output="build/test-results/@{{test.name}}.simpletest.xml"
          		error="build/test-results/@{{test.name}}.simpletest.error.txt"
          		resultproperty="test.@{{test.name}}.result">
              <arg value="-q" />
              <arg value="cli_test_runner.php" />
              <arg value="@{{php}}"/>
              <arg value="@{{test.name}}"/>
          </exec>
          <echo>after simple tests</echo>
          <echo>before xslt</echo>
          <xslt style="tests/simpletest2junit.xslt" basedir="build/test-results" destdir="build/test-reports">
            <mapper type="glob" from="@{{test.name}}.simpletest.xml" to="@{{test.name}}.junit.xml" />
          </xslt>
          <echo>after xslt</echo>
          <condition property="test.failure" value="@{{test.name}}">
            <not>
              <equals arg1="0" arg2="${{test.@{{test.name}}.result}}"/>
            </not>
          </condition>
          <!--
          
          disabled since they are not failing anyway and their result is not taken into accound since failonerror="false" 
           
          <echo>before MDB2 tests</echo>
          <exec dir="tests" executable="@{{php}}" failonerror="false" output="build/test-results/MDB2-@{{test.name}}.html">
            <arg value="run.php" />
            <arg value=" - - type=phpunit" />
            <arg value=" - - dir=../lib/pear/MDB2/tests/" />
          </exec>
          <echo>after MDB2 tests</echo>
          <echo>before MDB2 schema tests</echo>
          <exec dir="tests" executable="@{{php}}" failonerror="false" output="build/test-results/MDB2_Schema-@{{test.name}}.html">
            <arg value="run.php" />
            <arg value=" - - type=phpunit" />
            <arg value=" - - dir=../lib/pear/MDB2_Schema/tests/" />
          </exec>
          <echo>after MDB2 schema tests</echo>
          
           -->
        </sequential>
      </macrodef>

      <target name="test">
      
      	<xsl:for-each select="/tests/audit/settings">
      
      		<xsl:variable name="auditsettings" select="."/>
      		
	        <xsl:for-each select="/tests/php/version">
	          <xsl:call-template name="fulltest">
	            <xsl:with-param name="php" select="."/>
	            <xsl:with-param name="auditsettings" select="$auditsettings"/>
	          </xsl:call-template>
	        </xsl:for-each>
        
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
    <xsl:param name="auditsettings"/>
    <xsl:for-each select="/tests/database/version">
      <xsl:variable name="db.table.type.trimmed"><xsl:value-of select="normalize-space(@db.table.type)"/></xsl:variable>
      <xsl:variable name="db.name.suffix"><xsl:if test="$db.table.type.trimmed != ''">_<xsl:value-of select="$db.table.type.trimmed"/></xsl:if></xsl:variable>
      <xsl:element name="fulltest">
        <xsl:attribute name="test.name"><xsl:value-of select="$php/@name"/>-<xsl:value-of select="@name"/>-<xsl:value-of select="$db.table.type.trimmed"/></xsl:attribute>
        <xsl:attribute name="php"><xsl:value-of select="$php/@executable"/></xsl:attribute>
        <xsl:attribute name="db.type"><xsl:value-of select="@db.type"/></xsl:attribute>
        <xsl:attribute name="db.host"><xsl:value-of select="@db.host"/></xsl:attribute>
        <xsl:attribute name="db.port"><xsl:value-of select="@db.port"/></xsl:attribute>
        <xsl:attribute name="db.username"><xsl:value-of select="@db.username"/></xsl:attribute>
        <xsl:attribute name="db.password"><xsl:value-of select="@db.password"/></xsl:attribute>
        <xsl:attribute name="db.name">
        	<xsl:choose>
        		<xsl:when test="$auditsettings/@enabled &gt; 0">
        			<xsl:value-of select="@db.name"/>_<xsl:value-of select="$php/@name"/><xsl:value-of select="$db.name.suffix"/>_<xsl:text>audit</xsl:text>
        		</xsl:when>
        		<xsl:otherwise>
        			<xsl:value-of select="@db.name"/>_<xsl:value-of select="$php/@name"/><xsl:value-of select="$db.name.suffix"/>
        		</xsl:otherwise>
        	</xsl:choose>
        </xsl:attribute>
        <xsl:attribute name="db.table.type"><xsl:value-of select="@db.table.type"/></xsl:attribute>
        <xsl:attribute name="audit.enabled"><xsl:value-of select="$auditsettings/@enabled"/></xsl:attribute>
      </xsl:element>
    </xsl:for-each>
  </xsl:template>

</xsl:transform>
