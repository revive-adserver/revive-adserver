<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Dal.php';

/**
 * Store an image file.
 *
 * @deprecated
 *
 * @param string $type
 * @param string $name
 * @param string $buffer
 * @param bool $overwrite
 *
 * @return string|false
 */
function phpAds_ImageStore($type, $name, $buffer, $overwrite = false)
{
    // Strip existing path
    $name = basename($name);

    if ('web' === $type) {
        $extension = substr($name, strrpos($name, "."));
        $name = phpAds_LocalUniqueName($buffer, $extension);

        /** @var \League\Flysystem\Filesystem $filesystem */
        $filesystem = RV_getContainer()->get('filesystem');
    } else {
        // Make name web friendly
        $name = strtolower($name);
        $name = str_replace([" ", "'"], ["_", ""], $name);

        $filesystem = new \League\Flysystem\Filesystem(new \RV\Bridge\Flysystem\SqlStoredBannerAdapter());

        if (!$overwrite && $filesystem->has($name)) {
            $name = \RV\Bridge\Flysystem\SqlStoredBannerAdapter::getUniqueNameForDuplication($name);
        }
    }

    try {
        if ($filesystem->put($name, $buffer)) {
            return $name;
        }
    } catch (\Exception $e) {
        // The previous behaviour was to ignore errors, so that's what we do here too
    }

    return false;
}

/**
 * Duplicate an image file.
 *
 * @deprecated
 *
 * @param string $type
 * @param string $name
 *
 * @return string|false
 */
function phpAds_ImageDuplicate($type, $name)
{
    // Strip existing path
    $name = basename($name);

    if ('web' === $type) {
        // Local/FTP mode, do nothing. The previous behaviour was to duplicate FTP images, but I believe the behaviour
        // should match, especially given that the filenames are md5 checksums of the content.
        return $name;
    }

    $filesystem = new \League\Flysystem\Filesystem(new \RV\Bridge\Flysystem\SqlStoredBannerAdapter());

    $destName = \RV\Bridge\Flysystem\SqlStoredBannerAdapter::getUniqueNameForDuplication($name);

    try {
        if ($filesystem->copy($name, $destName)) {
            return $destName;
        }
    } catch (\Exception $e) {
        // The previous behaviour was to ignore errors, so that's what we do here too
    }

    return false;
}

/*-------------------------------------------------------*/
/* Retrieve a file on the webserver                      */
/*-------------------------------------------------------*/

/**
 * Retrieve an image file.
 *
 * @deprecated
 *
 * @param string $type
 * @param string $name
 *
 * @return string|false
 */
function phpAds_ImageRetrieve($type, $name)
{
    // Strip existing path
    $name = basename($name);

    if ('web' === $type) {
        /** @var \League\Flysystem\Filesystem $filesystem */
        $filesystem = RV_getContainer()->get('filesystem');
    } else {
        $filesystem = new \League\Flysystem\Filesystem(new \RV\Bridge\Flysystem\SqlStoredBannerAdapter());
    }


    try {
        return $filesystem->read($name);
    } catch (\Exception $e) {
        // The previous behaviour was to ignore errors, so that's what we do here too
    }

    return false;
}

/**
 * Delete an image file.
 *
 * @deprecated
 *
 * @param string $type
 * @param string $name
 *
 * @return bool
 */
function phpAds_ImageDelete($type, $name)
{
    if ('web' === $type) {
        /** @var \League\Flysystem\Filesystem $filesystem */
        $filesystem = RV_getContainer()->get('filesystem');
    } else {
        $filesystem = new \League\Flysystem\Filesystem(new \RV\Bridge\Flysystem\SqlStoredBannerAdapter());
    }

    try {
        return $filesystem->delete($name);
    } catch (\Exception $e) {
        // The previous behaviour was to ignore errors, so that's what we do here too
    }

    return false;
}

/**
 * Get the size of an image file.
 *
 * @deprecated
 *
 * @param string $type
 * @param string $name
 *
 * @return int|false
 */
function phpAds_ImageSize($type, $name)
{
    // Strip existing path
    $name = basename($name);

    if ('web' === $type) {
        /** @var \League\Flysystem\Filesystem $filesystem */
        $filesystem = RV_getContainer()->get('filesystem');
    } else {
        $filesystem = new \League\Flysystem\Filesystem(new \RV\Bridge\Flysystem\SqlStoredBannerAdapter());
    }

    try {
        return $filesystem->getSize($name);
    } catch (\Exception $e) {
        // The previous behaviour was to ignore errors, so that's what we do here too
    }

    return false;
}


/*-------------------------------------------------------*/
/* Local storage functions                               */
/*-------------------------------------------------------*/

/**
 * A function to get the unique filename that will be used
 * for storing creative files when using the local disk for
 * web-based creative storage.
 *
 * @param string $buffer The contents of the file.
 * @param string $extension The extension of the file, e.g. ".jpg".
 *
 * @return string The filename, eg. "d41d8cd98f00b204e9800998ecf8427e.jpg"
 */
function phpAds_LocalUniqueName($buffer, $extension)
{
    $filename = md5($buffer) . $extension;
    return $filename;
}
