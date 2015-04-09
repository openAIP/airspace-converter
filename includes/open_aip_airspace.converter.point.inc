<?php
/**
 * @file  openAIP Airspace converter
 *
 */
include 'open_aip_airspace.converter.geolocation.inc';

class AipPoint extends GeoLocation {
    /*
     * 	$indentation is a string, containing whitespaces, which is
     * 	put in front of each line.
     *
     * 	<POINT>
     * 		<LAT>52.1222</LAT>
     * 		<LON>8.31111</LON>
     * 	</POINT>
     *
     */

    public function toXml($indent) {
        /*
          return 	$indent."<POINT>\n".
          $indent."  <LAT>".$this->lat."</LAT>\n".
          $indent."  <LON>".$this->lon."</LON>\n".
          $indent."</POINT>\n";
         */

        return $indent . "<POINT><LAT>" . $this->lat . "</LAT><LON>" . $this->lon . "</LON></POINT>\n";
    }
    
    public function toOpenAir()
    {
      return $indent . "<POINT><LAT>" . $this->lat . "</LAT><LON>" . $this->lon . "</LON></POINT>\n";
    }

}



