# Changelog

All notable changes to Revive Adserver will be documented in this file.

## [6.0.2] - 2025-11-05

### Fixes

- Fixed typo preventing Excel exports from working ([#1590](https://github.com/revive-adserver/revive-adserver/issues/1590))
- Fixed UI bug in the *Hostname List* and *Registerable Domain List* delivery rules ([#1589](https://github.com/revive-adserver/revive-adserver/issues/1589))


## [6.0.1] - 2025-10-24

### [Security fixes](https://www.revive-adserver.com/security/revive-sa-2025-002/)

- Fixed SQL injection ([CVE-2025-52664](https://www.cve.org/CVERecord?id=CVE-2025-52664))

### Fixes

- Fixed issue with the search window checkboxes being reset when submitting a new keyword ([#1587](https://github.com/revive-adserver/revive-adserver/issues/1587))


## [6.0.0] - 2025-10-22

### [Security fixes](https://www.revive-adserver.com/security/revive-sa-2025-001/)

- Fixed Reflected XSS vulnerability ([CVE-2025-27208](https://www.cve.org/CVERecord?id=CVE-2025-27208))

### Added

- Added new `addMagicMacros` delivery plugin hook.
- New `displayNameLength` configuration directive to increase the length of campaign and banner names displayed in the zone linking screens.
- Added loading animation when the next screen is taking some time to load and a new UI setting to disable or customise how long to wait before displaying the loader (defaults to 250ms).
- Added new command to delete orphaned images or HTML5 banner folders. The command can be executed using the new script/console entry point, based on Symfony Console Command component.
- Added support for writing to a `fail2ban` compatible log file on unsuccessful login attempts.
- Added new setting to send a `Link` header during delivery when using HTTPS and images are hosted on a different hostname then delivery (e.g. CDN), in order to speed up ad rendering on a page. Based on the setting, browsers will either attempt to pre-connect to the images server, or just perform a DNS lookup.
- Added new _Disable delivery cookies_ setting. For more information see: https://documentation.revive-adserver.com/display/DOCS/Third+party+cookies
- Added `[cookie] adminDomain` advanced setting to allow custom configuration in case the admin console runs behind a reverse proxy and login isn't working.
- Added a warning message in the banner edit screen when non-HTTPS assets are used and banner won't be selected for delivery on HTTPS pages.
- Added missing localization for the date pickers.
- Added optional banner file size limit to the banners storage settings.
- Added zone filtering to the _Linked Zones_ tab for banners.
- Added new Mailer plugin, allowing to use SMTP or a selection of 3rd party providers to send emails. By default, no plugin is configured or selected in the e-mail settings, so the legacy code is in use, granting backwards compatibility.
- Added `Cross-Origin-Resource-Policy` header to the delivery `asyncjs.php` script.

### Changed

- Revive Adserver now requires at least PHP 8.1
- Updated the MaxMind GeoIP2 plugin to support the upcoming changes in the procedures required to download database updates from MaxMind. In order for the automatic updates to continue working, the MaxMind account ID needs to be added in the plugin configuration screen.
- Improved pruning of the `data_summary_ad_zone_assoc` table.
- Optimised some queries used in the statistics screen, leading to faster response times on very large instances.
- Replaced advertiser and website statistics with a new account statistics screen for administrator users.
- The `intl` PHP extension is now required in order to run Revive Adserver.

### Deprecated

- Deprecated `[rawDatabase]` section in the config file is no longer supported.
- Deprecated SQL stored banners: the default setting for new installations is to disallow SQL stored banners.
- Deprecated popups and interstitials: it is no longer possible to create new popup or interstitial zones. Existing tags will continue to work as expected, until the functionality will be fully removed in a future version.

### Removed

- Removed obsolete P3P headers and settings.
- Removed local mode tags, previously deprecated in v5.3.0.
- Removed XML-RPC tags, previously deprecated in v5.3.0.
- Removed option to generate pop-unders, which are not allowed by modern browsers.
- Removed the possibility to configure the Operation Interval setting from the user interface, effectively deprecating non-standard usages. In fact using anything different from 60 minutes is complex, confusing, and fraught with danger.
- Removed the legacy _Client- Browser (Deprecated)_ and _Client- Operating System (Deprecated)_ delivery rules.

### Fixed

- `HEAD` requests to delivery scripts were previously executed and counted as proper requests, even though the ad payload would have been discarded.
- Fixed issue with the search functionality being case-sensitive when using a Postgres database.
- Changed the `OAGEO` cookie from session cookie to permanent, with a 30m expiration time. This should allow refreshing geo information for mobile users on the move.
- Fixed the definition of the `acls` and `acls_channel` tables so that they have a proper primary key.
- Fixed the definition of the `banners_vast_element` table in the IAB VAST Plugin to use a primary key and avoid the creation of an additional "banners_vast_element_seq" table on MySQL without any prefix.
- Fixed an issue preventing contract campaigns from working properly with hour of day limitation in non-UTC timezones or with campaigns having daily targets.
- Fixed improper handling of write errors when downloading GeoLiteCity database files.
- Fixed issue with search settings being reset when typing a new search keyword. Compact view is also the new default in order to keep resource usage low.
- Fixed an issue preventing webp banners from being displayed on Newsletter zones and when using Image Invocation Code.
- Fixed sorting by campaign type in the advertisers campaign screen.
- Improved command line installer by including the field name in form error messages and removing the unused -H option.
- Fixed command line installer not picking up the custom image store path and not setting permissions on .htaccess files.
- Fixed global settings help link.
- Fixed non-working sorting in the websites list inventory screen.
- Fixed avw.php logging an ad impression when requesting a non-existing zone.
- Fixed PHP 8.1+ compatibility issues in the republish maintenance script.
