<?php
/**
 * @file  openAIP Airspace converter
 *
 */
include 'open_aip_airspace.converter.point.inc';

class AipPath {

    public $pathElements = array();

    public function appendPoint($point) {
        $this->pathElements[] = $point;
    }

    /*
     * 	$indentation is a string, containing whitespaces, which is
     * 	put in front of each line.
     *
     * 	<PATH>
     * 		<POINT>
     * 			<LAT>52.1222</LAT>
     * 			<LON>8.31111</LON>
     * 		</POINT>
     * 		...
     *
     * 	</PATH>
     *
     */

    public function closePath() {
        // check if path is already closed
        if (($this->pathElements[0]->lon == end($this->pathElements)->lon) && ($this->pathElements[0]->lat == end($this->pathElements)->lat))
        {
          // path already closed
          return;
        }
        else
        {
          $this->appendPoint($this->pathElements[0]);
        }
    }
    
    public function toXml($indent) {
        $result = $indent . "<PATH>\n";
        $numElements = count($this->pathElements);

        for ($idx = 0; $idx < $numElements; $idx++) {
            $result .= $this->pathElements[$idx]->toXml($indent . "  ");
        }

        $result .= $indent . "</PATH>\n";

        return $result;
    }
    
    public function toOpenAir()
    {
      $result = "";
      $numElements = count($this->pathElements);
      for ($idx = 0; $idx < $numElements; $idx++)
      {
        // DP 36:47:40 N 115:07:00 W
        $absLat = abs($this->pathElements[$idx]->lat);
        $latDeg = floor($absLat);
        $tempSecs = floor(($absLat - $latDeg) * 3600.0);
        $latMin = $tempSecs / 60;
        $latSec = $tempSecs % 60;
        $latSign = "N";
        if ($this->pathElements[$idx]->lat < 0.0)
        {
          $latSign = "S";
        }
        
        $absLon = abs($this->pathElements[$idx]->lon);
        $lonDeg = floor($absLon);
        $tempSecs = floor(($absLon - $lonDeg) * 3600.0);
        $lonMin = $tempSecs / 60;
        $lonSec = $tempSecs % 60;
        $lonSign = "E";
        if ($this->pathElements[$idx]->lon < 0.0)
        {
          $lonSign = "W";
        }
        
        $dp = sprintf("DP %02d:%02d:%02d %s %03d:%02d:%02d %s\n", $latDeg, $latMin, $latSec, $latSign, $lonDeg, $lonMin, $lonSec, $lonSign);
        
        $result .= $dp;
      }

      return $result;
    }
    
    public function toWkt()
    {
      $result = "";
      $numElements = count($this->pathElements);
      for ($idx = 0; $idx < $numElements; $idx++)
      {
        $result .= $this->pathElements[$idx]->lon." ".$this->pathElements[$idx]->lat;
        if ($idx < ($numElements - 1))
        {
          $result .= ", ";
        }
      }

      return $result;
    }
    
    public function toGml()
    {
      $result = "";
      $numElements = count($this->pathElements);
      for ($idx = 0; $idx < $numElements; $idx++)
      {
        $result .= $this->pathElements[$idx]->lon.",".$this->pathElements[$idx]->lat;
        if ($idx < ($numElements - 1))
        {
          $result .= " ";
        }
      }

      return $result;
    }

}



