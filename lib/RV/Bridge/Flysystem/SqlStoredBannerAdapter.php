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

use League\Flysystem\Config;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\UnableToCopyFile;
use League\Flysystem\UnableToCreateDirectory;
use League\Flysystem\UnableToDeleteDirectory;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\UnableToListContents;
use League\Flysystem\UnableToMoveFile;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToRetrieveMetadata;
use League\Flysystem\UnableToSetVisibility;
use League\Flysystem\UnableToWriteFile;

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once 'DB/DataObject/Cast.php';

class SqlStoredBannerAdapter implements FilesystemAdapter
{
    /**
     * Returns a filename suitable for duplication or to avoid overwriting an existing file.
     */
    public static function getUniqueNameForDuplication($path)
    {
        /** @var \DataObjects_Images $doImages */
        $doImages = \OA_Dal::factoryDO('images');
        $doImages->filename = $path;

        return $doImages->getUniqueNameForDuplication('filename');
    }

    public function fileExists(string $path): bool
    {
        return (bool) \OA_Dal::staticGetDO('images', $path);
    }

    public function directoryExists(string $path): bool
    {
        return false;
    }

    public function read(string $path): string
    {
        /** @var \DataObjects_Images $doImages */
        $doImages = \OA_Dal::staticGetDO('images', $path);
        if (!$doImages) {
            throw UnableToReadFile::fromLocation($path, 'Image does not exist.');
        }

        return $doImages->contents;
    }

    public function write(string $path, string $contents, Config $config): void
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
        if (false === $doImages->$method()) {
            throw UnableToWriteFile::atLocation($path, 'Unable to save image in the database.');
        }
    }

    public function delete(string $path): void
    {
        /** @var \DataObjects_Images $doImages */
        $doImages = \OA_Dal::staticGetDO('images', $path);
        if ($doImages && false === $doImages->delete()) {
            throw UnableToDeleteFile::atLocation($path, 'Unable to delete image from the database.');
        }
    }

    public function fileSize(string $path): FileAttributes
    {
        try {
            return new FileAttributes($path, strlen($this->read($path)));
        } catch (UnableToReadFile $e) {
            throw UnableToRetrieveMetadata::fileSize($path, $e->getMessage(), $e);
        }
    }

    public function move(string $source, string $destination, Config $config): void
    {
        if ($source === $destination) {
            return;
        }

        try {
            $this->write($destination, $this->read($source), $config);
            $this->delete($source);
        } catch (UnableToReadFile | UnableToWriteFile | UnableToDeleteFile $e) {
            throw UnableToMoveFile::fromLocationTo($source, $destination, $e);
        }
    }

    public function copy(string $source, string $destination, Config $config): void
    {
        try {
            $this->write($destination, $this->read($source), $config);
        } catch (UnableToReadFile | UnableToWriteFile $e) {
            throw UnableToCopyFile::fromLocationTo($source, $destination, $e);
        }
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        throw UnableToWriteFile::atLocation($path, 'Streams are not supported for SQL images.');
    }

    public function readStream(string $path)
    {
        throw UnableToReadFile::fromLocation($path, 'Streams are not supported for SQL images.');
    }

    public function deleteDirectory(string $path): void
    {
        throw UnableToDeleteDirectory::atLocation($path, 'Directories are not supported for SQL images.');
    }

    public function createDirectory(string $path, Config $config): void
    {
        throw UnableToCreateDirectory::atLocation($path, 'Directories are not supported for SQL images.');
    }

    public function setVisibility(string $path, string $visibility): void
    {
        throw UnableToSetVisibility::atLocation($path, 'Visibility is not supported for SQL images.');
    }

    public function listContents(string $path, bool $deep): iterable
    {
        throw UnableToListContents::atLocation($path, $deep, new \LogicException('Listing SQL images is not supported.'));
    }

    public function mimeType(string $path): FileAttributes
    {
        throw UnableToRetrieveMetadata::mimeType($path, 'MIME types are not stored for SQL images.');
    }

    public function lastModified(string $path): FileAttributes
    {
        throw UnableToRetrieveMetadata::lastModified($path, 'Timestamps are not stored for SQL images.');
    }

    public function visibility(string $path): FileAttributes
    {
        throw UnableToRetrieveMetadata::visibility($path, 'Visibility is not stored for SQL images.');
    }
}
