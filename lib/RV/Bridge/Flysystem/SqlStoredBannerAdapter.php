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

namespace RV\Bridge\Flysystem;

use League\Flysystem\Adapter\CanOverwriteFiles;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Config;
use League\Flysystem\NotSupportedException;

require_once MAX_PATH.'/lib/OA/Dal.php';
require_once 'DB/DataObject/Cast.php';

class SqlStoredBannerAdapter implements AdapterInterface, CanOverwriteFiles
{
    /**
     * Returns a filename suitable for duplication or to avoid overwriting an existing file.
     *
     * @param string $path
     *
     * @return string
     */
    public static function getUniqueNameForDuplication($path)
    {
        /** @var \DataObjects_Images $doImages */
        $doImages = \OA_Dal::factoryDO('images');
        $doImages->filename = $path;

        return $doImages->getUniqueNameForDuplication('filename');
    }

    /**
     * {@inheritdoc}
     */
    public function has($path)
    {
        /** @var \DataObjects_Images $doImages */
        $doImages = \OA_Dal::staticGetDO('images', $path);

        return (bool)$doImages;
    }

    /**
     * {@inheritdoc}
     */
    public function read($path)
    {
        /** @var \DataObjects_Images $doImages */
        $doImages = \OA_Dal::staticGetDO('images', $path);

        if ($doImages) {
            return $doImages->contents;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function write($path, $contents, Config $config)
    {
        /** @var \DataObjects_Images $doImages */
        $doImages = \OA_Dal::staticGetDO('images', $path);

        if ($doImages) {
            $method = 'update';
        } else {
            $method = 'insert';
            $doImages = \OA_Dal::factoryDO('images');
            $doImages->filename = $path;
        }

        $doImages->contents = \DB_DataObject_Cast::blob($contents);

        return $doImages->$method();
    }

    /**
     * {@inheritdoc}
     */
    public function delete($path)
    {
        /** @var \DataObjects_Images $doImages */
        $doImages = \OA_Dal::staticGetDO('images', $path);

        if ($doImages) {
            return $doImages->delete();
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize($path)
    {
        /** @var \DataObjects_Images $doImages */
        $doImages = \OA_Dal::staticGetDO('images', $path);

        if ($doImages) {
            return [
                'size'=>strlen($doImages->contents)
            ];
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function update($path, $contents, Config $config)
    {
        return $this->write($path, $contents, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function rename($path, $newpath)
    {
        /** @var \DataObjects_Images $doImages */
        $doImages = \OA_Dal::staticGetDO('images', $path);

        if ($doImages) {
            $doImages->filename = $newpath;

            return $doImages->update();
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function copy($path, $newpath)
    {
        return $this->write($newpath, $this->read($path), new Config());
    }

    /**
     * {@inheritdoc}
     */
    public function writeStream($path, $resource, Config $config)
    {
        throw new NotSupportedException(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function updateStream($path, $resource, Config $config)
    {
        throw new NotSupportedException(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteDir($dirname)
    {
        throw new NotSupportedException(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function createDir($dirname, Config $config)
    {
        throw new NotSupportedException(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function setVisibility($path, $visibility)
    {
        throw new NotSupportedException(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function readStream($path)
    {
        throw new NotSupportedException(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function listContents($directory = '', $recursive = false)
    {
        throw new NotSupportedException(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata($path)
    {
        throw new NotSupportedException(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function getMimetype($path)
    {
        throw new NotSupportedException(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function getTimestamp($path)
    {
        throw new NotSupportedException(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function getVisibility($path)
    {
        throw new NotSupportedException(__METHOD__);
    }
}