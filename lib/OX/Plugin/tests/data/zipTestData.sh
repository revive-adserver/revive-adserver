#!/bin/sh

cd zipGood
pwd
rm testPluginPackage.zip
zip -r testPluginPackage . -x \*.svn/* \*.sh
cd ..

cd zipBad_FileExtra
pwd
rm testPluginPackage.zip
zip -r testPluginPackage . -x \*.svn/* \*.sh
cd ..

cd zipBad_FileIllegal
pwd
rm testPluginPackage.zip
zip -r testPluginPackage . -x \*.svn/* \*.sh
cd ..

cd zipBad_FileMisnamed
pwd
rm testPluginPackage.zip
zip -r testPluginPackage . -x \*.svn/* \*.sh
cd ..

cd zipDiagnosticTest
pwd
rm testPluginPackage.zip
zip -r testPluginPackage . -x \*.svn/* \*.sh
cd ..

cd zipInstallTest
pwd
rm testPluginPackage.zip
zip -r testPluginPackage . -x \*.svn/* \*.sh
cd ..

exit 0