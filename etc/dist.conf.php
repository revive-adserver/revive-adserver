;<?php exit; ?>
;*** DO NOT REMOVE THE LINE ABOVE ***
;------------------------------------------------------------------------------------------;
; General Installation Settings                                                            ;
;------------------------------------------------------------------------------------------;

[openads]
installed                           = false
requireSSL                          = false
sslPort                             = 443

[ui]
enabled                             = true
applicationName                     =
headerFilePath                      =
footerFilePath                      =
logoFilePath                        =
headerForegroundColor               =
headerBackgroundColor               =
headerActiveTabColor                =
headerTextColor                     =
gzipCompression                     = true
supportLink                         =
combineAssets                       = true
dashboardEnabled                    = true
hideNavigator                       = false
zoneLinkingStatistics               = true
disableDirectSelection              = true

;------------------------------------------------------------------------------------------;
; Database Settings                                                                        ;
;------------------------------------------------------------------------------------------;

[database]
type                                =
host                                =
socket                              =
port                                =
username                            =
password                            =
name                                =
persistent                          = false
protocol			                = tcp

compress                            = false
ssl                                 = false
capath                              =
ca                                  =

[databaseCharset]
checkComplete                       = false
clientCharset                       =

[databaseMysql]
statisticsSortBufferSize            =

[databasePgsql]
schema                              =

;------------------------------------------------------------------------------------------;
; Delivery Path and File Name Settings                                                     ;
;------------------------------------------------------------------------------------------;

[webpath]
admin                               =
delivery                            =
deliverySSL                         =
images                              =
imagesSSL                           =

[file]
asyncjs                             = asyncjs.php
asyncjsjs                           = async.js
asyncspc                            = asyncspc.php
click                               = ck.php
signedClick                         = cl.php
conversionvars                      = tv.php
content                             = ac.php
conversion                          = ti.php
conversionjs                        = tjs.php
frame                               = afr.php
image                               = ai.php
js                                  = ajs.php
layer                               = al.php
log                                 = lg.php
popup                               = apu.php
view                                = avw.php
xmlrpc                              = axmlrpc.php
local                               = alocal.php
frontcontroller                     = fc.php
singlepagecall                      = spc.php
spcjs                               = spcjs.php
xmlrest                             = ax.php

[store]
mode                                =
webDir                              =
ftpHost                             =
ftpPath                             =
ftpUsername                         =
ftpPassword                         =
ftpPassive                          =

;------------------------------------------------------------------------------------------;
; Delivery Details                                                                         ;
;------------------------------------------------------------------------------------------;

[allowedBanners]
sql                                 = true
web                                 = true
url                                 = true
html                                = true
text                                = true
video                               = false

[delivery]
cacheExpire                         = 1200
cacheStorePlugin               	    = deliveryCacheStore:oxCacheFile:oxCacheFile
cachePath                           =
acls                                = true
aclsDirectSelection                 = true
obfuscate                           = false
ctDelimiter                         = __
chDelimiter                         = ","
keywords                            = false
cgiForceStatusHeader                = false ; Set this to true if using a CGI sapi which
                                            ; does not correctly deal with HTTP headers
                                            ; and leaves the description empty
                                            ; (i.e. "HTTP/1.1 302" insead that 302 Found)
clicktracking                       = "No"
ecpmSelectionRate                   = 0.9
enableControlOnPureCPM              = true
assetClientCacheExpire              = 3600  ; Used to create the browser caching directive
                                            ; of semi-static delivery files, e.g. asyncjs.php
secret                              =
clickUrlValidity                    = 0;    ; Click URL open redirect validity in seconds
relAttribute                        = noopener nofollow

[defaultBanner]
invalidZoneHtmlBanner               =       ; If zone does not exist, show this HTML snipper
suspendedAccountHtmlBanner          =       ; If account is suspended, show this HTML snippet
inactiveAccountHtmlBanner           =       ; If account is inactive, show this HTML snippet

[p3p]
policies                            = true
compactPolicy                       = CUR ADM OUR NOR STA NID
policyLocation                      =

[privacy]
disableViewerId                     = true
anonymiseIp                         = true

;------------------------------------------------------------------------------------------;
; User Interface Settings                                                                  ;
;------------------------------------------------------------------------------------------;

[graphs]
ttfDirectory                        =   ; The directory where True Type Fonts are stored
ttfName                             =   ; Name of the True Type Font to use in graphs, only
                                        ; supported in the test suite at present

;------------------------------------------------------------------------------------------;
; Statistics Logging & Maintenance Details                                                 ;
;------------------------------------------------------------------------------------------;

[logging]
adRequests                          = false
adImpressions                       = true
adClicks                            = true
trackerImpressions                  = true
reverseLookup                       = false
proxyLookup                         = true
defaultImpressionConnectionWindow   =
defaultClickConnectionWindow        =
ignoreHosts                         =         ; Comma separated list of hosts
ignoreUserAgents                    =         ; Pipe separated list of user-agents to ignore
enforceUserAgents                   =         ; Pipe separated list of user-agents to enforce
blockAdClicksWindow                 = 0       ; Window for block clicks logging in seconds
blockInactiveBanners                = 1       ; Should recording of impressions, clicks & re-direction be blocked if the banner is inactive?

[maintenance]
autoMaintenance                     = 1

timeLimitScripts                    = 1800    ; Should maintenance scripts be limited to run no longer than
                                              ; this many seconds? Set to 0 for no time limit

operationInterval                   = 60

blockAdImpressions                  = 0       ; How many seconds must be between impressions and clicks
blockAdClicks                       = 0       ; from the same viewer ID for them to count? Set to 0 seconds
                                              ; for all to count.

channelForecasting                  = false
pruneCompletedCampaignsSummaryData  = false
pruneDataTables                     = true

;channelForecastingDaysBack          = 30     ; How many days from history should be used for forecasting
;channelForecastingDaysAhead         = 7      ; If campaign expire date is empty forecast for this number of days
;channelForecastingMaxDaysAhead      = 30     ; Even if campaign expire date is biger do not forecast more than
;channelForecastingMaxRunTime        = 40     ; Maximum time allowed for channel forecating maintenance (in minutes)

ecpmCampaignLevels                  = "9|8|7|6" ; Pipe delimited list of campaign priority levels to calculate
                                                ; eCPM values for in ECPMforContract

[priority]
instantUpdate                       = true
intentionalOverdelivery             = 0
defaultClickRatio                   = 0.005
defaultConversionRatio              = 0.0001
randmax                             = 2147483647 ; This should be autogenerated in installation process by mt_getrandmax()

[performanceStatistics]
defaultImpressionsThreshold         = 10000    ; Minimum number of impressions needed to calculate performance statistics (eCPM, CR, CTR)
defaultDaysIntervalThreshold        = 30       ; Minimum period of time (in days) needed to calculate performance statistics (eCPM, CR, CTR)

;------------------------------------------------------------------------------------------;
; Table Details                                                                            ;
;------------------------------------------------------------------------------------------;

[table]
prefix              =
type                = INNODB            ; Either MyISAM, or INNODB, for MySQL ONLY

;------------------------------------------------------------------------------------------;
; Table Names                                                                              ;
;------------------------------------------------------------------------------------------;

account_preference_assoc                 = account_preference_assoc
account_user_assoc                       = account_user_assoc
account_user_permission_assoc            = account_user_permission_assoc
accounts                                 = accounts
acls                                     = acls
acls_channel                             = acls_channel
ad_category_assoc                        = ad_category_assoc
ad_zone_assoc                            = ad_zone_assoc
affiliates                               = affiliates
affiliates_extra                         = affiliates_extra
agency                                   = agency
application_variable                     = application_variable
audit                                    = audit
banners                                  = banners
campaigns                                = campaigns
campaigns_trackers                       = campaigns_trackers
category                                 = category
channel                                  = channel
clients                                  = clients
data_intermediate_ad                     = data_intermediate_ad
data_intermediate_ad_connection          = data_intermediate_ad_connection
data_intermediate_ad_variable_value      = data_intermediate_ad_variable_value
data_raw_ad_click                        = data_raw_ad_click
data_raw_ad_impression                   = data_raw_ad_impression
data_raw_ad_request                      = data_raw_ad_request
data_raw_tracker_impression              = data_raw_tracker_impression
data_raw_tracker_variable_value          = data_raw_tracker_variable_value
data_summary_ad_hourly                   = data_summary_ad_hourly
data_summary_ad_zone_assoc               = data_summary_ad_zone_assoc
data_summary_channel_daily               = data_summary_channel_daily
data_summary_zone_impression_history     = data_summary_zone_impression_history
images                                   = images
log_maintenance_forecasting              = log_maintenance_forecasting
log_maintenance_priority                 = log_maintenance_priority
log_maintenance_statistics               = log_maintenance_statistics
password_recovery                        = password_recovery
placement_zone_assoc                     = placement_zone_assoc
preferences                              = preferences
session                                  = session
targetstats                              = targetstats
trackers                                 = trackers
tracker_append                           = tracker_append
userlog                                  = userlog
users                                    = users
variables                                = variables
variable_publisher                       = variable_publisher
zones                                    = zones

;------------------------------------------------------------------------------------------;
; E-mail                                                                                   ;
;------------------------------------------------------------------------------------------;

[email]
logOutgoing                              = true
headers                                  =
qmailPatch                               = false
fromName                                 =
fromAddress                              =
fromCompany                              =
useManagerDetails                        =

;------------------------------------------------------------------------------------------;
; Debugging/Error Logging Details                                                          ;
;------------------------------------------------------------------------------------------;

[log]
enabled             = true
methodNames         = false
lineNumbers         = false
type                = file
name                = debug.log
priority            = PEAR_LOG_INFO
ident               = OX
paramsUsername      =
paramsPassword      =
fileMode            = 0644

[deliveryLog]
enabled             = false
name                = delivery.log
fileMode            = 0644
priority            = 6

;------------------------------------------------------------------------------------------;
; Non-configurable items for the Delivery Engine                                           ;
;------------------------------------------------------------------------------------------;

[cookie]
permCookieSeconds   = 31536000      ; 1 year in seconds
maxCookieSize       = 2048
domain              =
viewerIdDomain      =

[debug]
logfile             =                       ; The delivery engine debugging file
production          = 1                     ; Is it production server? (do not show backtrace and error sourcecontext)
                                            ; If it is delivery do not show any errors
sendErrorEmails     = false                 ; Send emails containing error reports - do not work in delivery
emailSubject        = Error from Revive Adserver ; Error report subject
email               = email@example.com     ; Where to send error reports
emailAdminThreshold = PEAR_LOG_ERR          ; Email the error to admin if threshold reached
errorOverride       = true                  ; If true do not show notices
showBacktrace       = false                 ; If true print backtrace
disableSendEmails   = false                 ; If true, no email will be sent from this instance (useful for debug, testing, staging)

[var]
prefix              = OA_           ; Used to prefix some variables and used in invocation codes
cookieTest          = ct            ; Used for the forced cookie test redirect
cacheBuster         = cb            ; Cache buster
channel             = source        ; Channel of the website
dest                = dest          ; Used to pass in a URL to redirect to after action
signature           = sig           ; Used to sign the destination url
timestamp           = ts            ; Used to stamp the time a click url was generated
logClick            = log           ; Used to indicate if a click should be logged
n                   = n             ; Used to name a cookie containing displayed banner information
params              = oaparams      ; Used to pass in custom delimited key=value pairs into an ad-call
viewerId            = OAID          ; Used for passing viewer ID cookie value
viewerGeo           = OAGEO         ; Used for storing view geo-location information in a session cookie
campaignId          = campaignid    ; Used for passing campaign ID cookie value
adId                = bannerid      ; Used for passing ad ID cookie value
creativeId          = cid           ; Used for passing creative ID cookie value
zoneId              = zoneid        ; Used for passing zone ID cookie value
blockAd             = OABLOCK       ; Used for passing banner blocking cookie value
capAd               = OACAP         ; Used for passing banner capping cookie value
sessionCapAd        = OASCAP        ; Used for passing session banner capping cookie value
blockCampaign       = OACBLOCK      ; Used for passing campaign blocking cookie value
capCampaign         = OACCAP        ; Used for passing campaign capping cookie value
sessionCapCampaign  = OASCCAP       ; Used for passing session campaign capping cookie value
blockZone           = OAZBLOCK      ; Used for passing zone blocking cookie value
capZone             = OAZCAP        ; Used for passing zone capping cookie value
sessionCapZone      = OASZCAP       ; Used for passing session zone capping cookie value
vars                = OAVARS        ; Used for passing variables
trackonly           = trackonly     ; Used to avoid redirecting after a click
openads             = openads       ; Used as identifier for the adsense click tracking comments
lastView            = OXLIA         ; Used to track the last time an ad was viewed
lastClick           = OXLCA         ; Used to track the last time an ad was clicked
blockLoggingClick   = OXBLC         ; Used to log the last time an ad was clicked
fallBack            = oxfb          ; Used to flag if this impression was from a rich-media fallback creative
trace               = OXTR          ; Used to trigger delivery engine tracing code (if enabled)
product             = revive        ; Used in async tags as prefix, etc

;------------------------------------------------------------------------------------------;
; Load Balancing / Distributed Statistics                                                  ;
;------------------------------------------------------------------------------------------;

[lb]
enabled             = false         ; Should distributed stats be enabled
type                = mysql         ; Main database details
host                = localhost
port                = 3306
username            =
password            =
name                =
persistent          = false

;------------------------------------------------------------------------------------------;
; Revive Aderver Sync Settings                                                             ;
;------------------------------------------------------------------------------------------;

[sync]
checkForUpdates = true
shareStack      = true

[oacSync]
protocol    = https
host        = sync.revive-adserver.com
path        = /xmlrpc.php
httpPort    = 80
httpsPort   = 443

;------------------------------------------------------------------------------------------;
; Plugins Settings                                                                         ;
;------------------------------------------------------------------------------------------;

[authentication]
type=internal
deleteUnverifiedUsersAfter = 2419200   ; 28 days (in seconds)

[geotargeting]
type="none"
showUnavailable=false

[pluginPaths]
packages   = /plugins/etc/
plugins    = /plugins/
admin      = /www/admin/plugins/
var        = /var/plugins/

[pluginSettings]
enableOnInstall = true
useMergedFunctions = true

[plugins]

[pluginGroupComponents]

;------------------------------------------------------------------------------------------;
; Audit Settings                                                                           ;
;------------------------------------------------------------------------------------------;

[audit]
enabled=1
enabledForZoneLinking=false

;------------------------------------------------------------------------------------------;
; Security Settings                                                                        ;
;------------------------------------------------------------------------------------------;

[security]
passwordMinLength=12

;------------------------------------------------------------------------------------------;
