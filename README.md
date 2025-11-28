# SWM Changes

## Installation

1. From the repo root `cd plugins_repo`
2. If the plugin is unchanged, let the packager weave a fresh ZIP:
   `./zipkg.sh openXInvocationTags`
3. If you did tweak anything, run the same command to bump the version and rebuild:
   `./zipkg.sh openXInvocationTags -b oxInvocationTags`
4. On your running server, switch to an admin account.
5. Visit Plugins, upload the newly minted ZIP, and install or update it.

## Recommended usage for best responsiveness

* **Async JS Stealth** for image banners (PNG/GIF)
* **iFrame Stealth** for HTML banners

## Markdown Invocation Tag

To exisitng Invocation Tags Plugin we added **Markdown tag**.
Designed for static environments like GitHub READMEs or email newsletters.
Generates a fully static Markdown snippet:

```
[![Ad](https://adserver.example.com/www/images/zone-123.png)](https://adserver.example.com/www/delivery/ck.php?n=9f8a7b)
```

**Usage:**
Inventory → Zones → Invocation Code → Select “Markdown (GitHub)” → Paste into `.md`


### How it works

To enable rotation, cache busting, and GitHub Camo–friendly delivery, the plugin uses a Magic Image URL technique:

* Markdown uses a `.png` URL for compatibility.
* An `.htaccess` rule rewrites the request to `gh.php`.
* `gh.php` responds with a 307 redirect plus no-cache headers.
* The proxy fetches a unique randomized delivery URL each time.

This forces a fresh impression on every page load.

## Stealth Mode - AdBlock Bypass

Stealth Mode reshapes the delivery path and attributes so it slips past filters without raising suspicion
It is implemented for iFrame and Async JS invocation tags.

**Usage:**
Inventory → Zones → Invocation Code → Select “Async JS (Stealth Mode)” → Generate snippet

### How it Works

* Uses neutral-looking endpoints like `/assets/js/lib.js` and `/assets/data/packet`.
* Rewrites every `data-revive-*` attribute to `data-content-*`.
* Publishes the loader under the friendly name `contentAsync` instead of `reviveAsync`.
* Routes all requests through `.htaccess` into internal loader scripts that map the disguised URLs back to Revive’s delivery logic.

---

If you want it even shorter or more technical, I can tune it further.


# Revive Adserver
#### The world's most popular free, open source ad serving system

**Revive Adserver is an open source ad serving tool** that enables publishers to:

* Serve ads on their websites;

* Manage their campaigns from different advertisers and/or ad networks using the simple, easy-to-use interface;

* Track and report on campaign success, including click-through rates;

* Set rules to target the delivery of campaigns, or even ads, to specific users, to help maximise the effectiveness of campaigns.



# Download

**DO NOT DOWNLOAD AS A ZIP FILE FROM GITHUB**

Download the latest version from: https://www.revive-adserver.com/download/

Revive Adserver as available from github as a zip file is not suitable for installation on a server. It contains a number of files that are for development only, and are removed during the release packaging process.

Please ONLY download Revive Adserver as a release package from the Revive Adserver website at https://www.revive-adserver.com/.



# Hosted edition

If you'd like to use the Revive Adserver software without having to download, install, configure, and maintain it yourself, there is also a Hosted edition.

You can find out more about the Hosted edition, and subscribe at https://www.revive-adserver.net/.



# License

Revive Adserver is copyrighted; please see the COPYRIGHT file.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

------------------------------------------------------------------------

This product uses GeoLite2 data created by MaxMind, available from the 
https://www.maxmind.com/ website. See also:
https://www.revive-adserver.com/blog/new-geotargeting-plugin-in-revive-adserver-v5-an-overview/
