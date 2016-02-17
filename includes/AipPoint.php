<?php

/**
 * @file  openAIP Airspace converter
 *
 * For full copyright and license information, please review the LICENSE
 * file that was distributed with this source code.
 *
 */
require_once 'GeoLocation.php';

/**
 * Class AipPoint
 */
class AipPoint extends GeoLocation
{
    /**
     * $indent is a string, containing whitespaces, which is
     * prepended to each line.
     *
     * <POINT><LAT>52.1222</LAT><LON>8.31111</LON></POINT>
     *
     * @param $ident
     */
    public function toXml($indent)
    {
        return $indent."<POINT><LAT>".$this->lat."</LAT><LON>".$this->lon."</LON></POINT>\n";
    }

    /**
     * DP 36:47:40 N 115:07:00 W
     *
     * @return string
     */
    public function toOpenAir()
    {
        $absLat = abs($this->lat);
        $latDeg = floor($absLat);
        $tmpMin = ($absLat - $latDeg) * 60.0;
        $latMin = floor($tmpMin);
        $tmpSec = ($tmpMin - $latMin) * 60.0;
        $latSec = round ($tmpSec);
        $latSign = "N";
        if ($this->lat < 0.0) {
            $latSign = "S";
        }

        $absLon = abs($this->lon);
        $lonDeg = floor($absLon);
        $tmpMin = ($absLon - $lonDeg) * 60.0;
        $lonMin = floor($tmpMin);
        $tmpSec = ($tmpMin - $lonMin) * 60.0;
        $lonSec = round ($tmpSec);
        $lonSign = "E";
        if ($this->lon < 0.0) {
            $lonSign = "W";
        }

        $dp = sprintf("DP %02d:%02d:%02d %s %03d:%02d:%02d %s\n", $latDeg, $latMin, $latSec, $latSign, $lonDeg, $lonMin, $lonSec, $lonSign);
        return $dp;
    }

}
