<?php

/**
 * (c) AIR Avionics
 *
 * For full copyright and license information, please review the LICENSE
 * file that was distributed with this source code.
 */

require_once 'includes/AirspaceConverter.php';
require_once 'includes/Utils.php';

$aspConverter = new AirspaceConverter();

// recreate the output dir..
Utils::rrmdir("./openair_out");
mkdir("./openair_out");


if ($handle = opendir('./aip_in')) {

    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            if (substr($file, -3) != "aip") {
                echo "Skip $file..\n";
                continue;
            }

            echo "Processing $file..\n";

            if (!$aspConverter->loadFile("./aip_in/$file", "OPENAIP")) {
                echo $aspConverter->warnings;
                echo $aspConverter->errors;
                echo "LOAD FAILED \n";
                continue;
            }

            $openairFileName = "./openair_out/".str_replace("aip", "txt", $file);

            if ($aspConverter->writeToFile($openairFileName, "OPENAIR", "23")) {
                echo $aspConverter->warnings;
                echo "OK \n";
            } else {
                echo $aspConverter->warnings;
                echo $aspConverter->errors;

                echo "WRITE FAILED \n";
            }
        }
    }

    closedir($handle);
}

echo "Finished \n";
