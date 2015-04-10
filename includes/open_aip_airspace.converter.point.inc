<?php
/**
 * @file  openAIP Airspace converter
 *
 */
include 'open_aip_airspace.converter.geolocation.inc';

class AipPoint extends GeoLocation {
  
  /*
   * $indent is a string, containing whitespaces, which is
   * prepended to each line.
   *
   * <POINT><LAT>52.1222</LAT><LON>8.31111</LON></POINT>
   *
   */
  public function toXml($indent) {
    return $indent . "<POINT><LAT>" . $this->lat . "</LAT><LON>" . $this->lon . "</LON></POINT>\n";
  }
    
  // DP 36:47:40 N 115:07:00 W 
  public function toOpenAir()
  {
    $absLat = abs($this->lat);
    $latDeg = floor($absLat);
    $tempSecs = floor(($absLat - $latDeg) * 3600.0);
    $latMin = $tempSecs / 60;
    $latSec = $tempSecs % 60;
    $latSign = "N";
    if ($this->lat < 0.0)
    {
      $latSign = "S";
    }
            
    $absLon = abs($this->lon);
    $lonDeg = floor($absLon);
    $tempSecs = floor(($absLon - $lonDeg) * 3600.0);
    $lonMin = $tempSecs / 60;
    $lonSec = $tempSecs % 60;
    $lonSign = "E";
    if ($this->lon < 0.0)
    {
      $lonSign = "W";
    }
              
    $dp = sprintf("DP %02d:%02d:%02d %s %03d:%02d:%02d %s\n", $latDeg, $latMin, $latSec, $latSign, $lonDeg, $lonMin, $lonSec, $lonSign);
    return $dp;
  }

}



