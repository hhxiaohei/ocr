<?php

namespace Godruoyi\OCR\Support;

use Exception;
use SplFileInfo;
use Psr\Http\Message\StreamInterface;

class FileConverter
{
    /**
     * Converter Image To String
     *
     * @param  string|Object|Resource $image
     *
     * @return string
     */
    public static function toBase64Encode($image)
    {
        if (empty($image)) {
            return '';
        }

        return base64_encode(self::getContent($image));
    }

    /**
     * Get Content
     *
     * @param  string|\SplFileInfo|Resource $image
     *
     * @return string
     */
    public static function getContent($image)
    {
        switch (true) {
            case self::isFile($image):
                return file_get_contents($image);
            case self::isResource($image):
                return stream_get_contents($image);
            case self::isSplFileInfo($image):
                return file_get_contents($image->getRealPath());
            case self::isString($image):
                return $image;
            default:
                throw new Exception('unsupport image type.');
        }
    }

    /**
     * Determine the given file has a file
     *
     * @param  mixed $file
     *
     * @return boolean
     */
    public static function isString($file)
    {
        return is_string($file) && (! self::isUrl($file));
    }

    /**
     * Determine the given file has a active url
     *
     * @param  mixed  $file
     * @return boolean
     */
    public static function isUrl($file)
    {
        return filter_var($file, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Determine the given file has a active url
     *
     * @param  mixed  $file
     * @return boolean
     */
    public static function isFile($file)
    {
        return is_file($file) && file_exists($file);
    }

    /**
     * Determine the given file has Rescouve stream
     *
     * @param  mixed  $resource
     * @return boolean
     */
    public static function isResource($resource)
    {
        return is_resource($resource);
    }

    /**
     * Determine the given file has SplFileInfo instance
     *
     * @param  mixed  $splFile
     * @return boolean
     */
    public static function isSplFileInfo($splFile)
    {
        return $splFile instanceof SplFileInfo;
    }
}