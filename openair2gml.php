<?php

/**
 * (c) AIR Avionics
 *
 * For full copyright and license information, please review the LICENSE
 * file that was distributed with this source code.
 */

require_once "includes/AirspaceConverter.php";
require_once 'includes/Utils.php';

const IN_PATH = "./openair_in";
const OUT_PATH = "./gml_out";

// recreate the output dir..
Utils::rrmdir(OUT_PATH);
mkdir(OUT_PATH);

$aspConverter = new AirspaceConverter();

if ($handle = opendir('./openair_in')) {

    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && strpos($file, '.') !== 0) {

            echo "Processing $file..\n";

            if (!$aspConverter->loadFile(IN_PATH."/".$file, "OPENAIR")) {
                echo $aspConverter->warnings;
                echo $aspConverter->errors;
                echo "FAILED\n";
                continue;
            }

            $revFile = strrev($file);
            $outFile = strrev(substr($revFile, (strpos($revFile, '.') + 1))).'.gml';
            $outFile = OUT_PATH."/".$outFile;

            if ($aspConverter->writeToFile($outFile, "GML", "23")) {
                echo $aspConverter->warnings;
                echo "OK\n";
            } else {
                echo $aspConverter->warnings;
                echo $aspConverter->errors;

                echo "FAILED\n";
            }
        }
    }

    closedir($handle);
}

echo "Finished\n";
