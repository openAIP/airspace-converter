<?php
/**
 * @file openAIP Airspace converter
 *
 */
include 'open_aip_airspace.converter.point.inc';

class AipPath {

  public $pathElements = array();

  public function appendPoint($point) {
    $this->pathElements[] = $point;
  }

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

  /*
  * $indent is a string, containing whitespaces, which is
  * prepended to each line.
  *
  * <PATH>
  *  <POINT><LAT>52.1222</LAT><LON>8.31111</LON></POINT>
  *  ...
  * </PATH>
  *
  */
  public function toXml($indent) {
    $result = $indent . "<PATH>\n";
    $numElements = count($this->pathElements);

    for ($idx = 0; $idx < $numElements; $idx++) {
      $result .= $this->pathElements[$idx]->toXml($indent . " ");
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
     $result .= $this->pathElements[$idx]->toOpenAir();
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



