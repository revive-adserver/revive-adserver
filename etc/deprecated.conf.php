;<?php exit; ?>
;*** DO NOT REMOVE THE LINE ABOVE ***
;------------------------------------------------------------------------------------------;
; WARNING! This file contains configuration file settings that have been deprecated.       ;
; WARNING! On upgrade, the configuration file settings found in this file WILL BE REMOVED  ;
; WARNING! from the user's configuration file. This makes it possible to remove settings   ;
; WARNING! that are no longer used, but should be used with great caution.                 ;
;------------------------------------------------------------------------------------------;

;------------------------------------------------------------------------------------------;
; Installer Settings                                                                       ;
;------------------------------------------------------------------------------------------;

[install]
marketPcHost          = https://pc.openx.com
marketPcApiHost       = https://api.pc.openx.com
fallbackPcApiHost     = http://api.pc.openx.com
marketPublicApiUrl    = api/public/v2
marketCaptchaUrl      = https://pc.openx.com/api/captcha
publisherSupportEmail = publisher-support@openx.org

;------------------------------------------------------------------------------------------;
; Revive Aderver Sync Settings                                                             ;
;------------------------------------------------------------------------------------------;

[sync]
shareData             = true

[oacXmlRpc]
protocol              = https
host                  = oxc.openx.org
httpPort              = 80
httpsPort             = 443
path                  = /oxc/xmlrpc
captcha               = /oxc/captcha
signUpUrl             = /oxc/advertiser/signup
publihserUrl          = /oxc/advertiser/defzone

[oacDashboard]
protocol              = https
host                  = oxc.openx.org
port                  = 443
path                  = /oxc/dashboard/home
ssoCheck              = /oxc/ssoCheck