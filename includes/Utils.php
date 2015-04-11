<?php

/**
 * (c) AIR Avionics
 *
 * For full copyright and license information, please review the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class Utils
 */
class Utils
{
    /**
     * @param $fileHandle
     * @param $stringData
     */
    public static function utf8_fileWrite($fileHandle, $stringData)
    {
        fwrite($fileHandle, utf8_encode($stringData));
    }

    /**
     * @param $dir
     */
    public static function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") {
                        static::rrmdir($dir."/".$object);
                    } else {
                        unlink($dir."/".$object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}
