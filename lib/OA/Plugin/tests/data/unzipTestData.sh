#!/bin/sh

cd zipGood
pwd
unzip testPluginPackage.zip
cd ..

cd zipBad_FileExtra
pwd
unzip testPluginPackage.zip
cd ..

cd zipBad_FileIllegal
pwd
unzip testPluginPackage.zip
cd ..

cd zipBad_FileMisnamed
pwd
unzip testPluginPackage.zip
cd ..

cd zipDiagnosticTest
pwd
unzip testPluginPackage.zip
cd ..

cd zipInstallTest
pwd
unzip testPluginPackage.zip
cd ..

exit 0
