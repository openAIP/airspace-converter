<?php

/**
 * (c) AIR Avionics
 *
 * For full copyright and license information, please review the LICENSE
 * file that was distributed with this source code.
 */

require_once "includes/AirspaceConverter.php";
require_once 'includes/Utils.php';

// recreate the output dir..
Utils::rrmdir("./gml_out");
mkdir("./gml_out");

$aspConverter = new AirspaceConverter();

if ($handle = opendir('./openair_in')) {

    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            if (substr($file, 2, 1) != "_") {
                echo "Skip $file..\n";
                continue;
            }

            echo "Processing $file..\n";

            if (!$aspConverter->loadFile("./openair_in/$file", "OPENAIR")) {
                echo $aspConverter->warnings;
                echo $aspConverter->errors;
                echo "FAILED\n";
                continue;
            }

            $inputCountryCode = strtolower(substr($file, 0, 2));
            $aipFileName = "./gml_out/".$inputCountryCode."_asp.gml";

            if ($aspConverter->writeToFile($aipFileName, "GML", "23")) {
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
