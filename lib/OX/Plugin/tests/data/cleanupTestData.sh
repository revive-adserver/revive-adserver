#!/bin/sh

rm plugins_repo/testPluginPackage.zip

rm -R zipGood/extensions
rm -R zipGood/www

rm -R zipBad_FileExtra/extensions
rm -R zipBad_FileExtra/www

rm -R zipBad_FileIllegal/extensions
rm -R zipBad_FileIllegal/www
rm zipBad_FileIllegal/init.php

rm -R zipBad_FileMisnamed/extensions
rm -R zipBad_FileMisnamed/www

rm -R zipDiagnosticTest/extensions
rm -R zipDiagnosticTest/www

rm -R zipInstallTest/extensions
rm -R zipInstallTest/www

exit 0