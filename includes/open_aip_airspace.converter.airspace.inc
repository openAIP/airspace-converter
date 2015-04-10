<?php

/**
 * @file openAIP Airspace converter
 *
 */
include 'open_aip_airspace.converter.geometry.inc';
include 'open_aip_airspace.converter.vertical_limit.inc';

class Airspace {

  public $category;
  public $name;
  public $topLimit;
  public $bottomLimit;
  public $geometry;
  
  function __construct() {
    $this->geometry = new AipGeometry();
    $this->topLimit = new AipVerticalLimit("TOP");
    $this->bottomLimit = new AipVerticalLimit("BOTTOM");
  }

  public function setPath($path) {
    $this->geometry->appendElement($path);
  }

  /*
   * $indent is a string, containing whitespaces, which is
   * prepended to each line.
   *
   * <ASP CATEGORY="RESTRICTED">
   *   <NAME>ED-R203</NAME>
   *   <ALTLIMIT_TOP REFERENCE="STD">
   *     <ALT UNIT="FL">150</ALT>
   *   </ALTLIMIT_TOP>
   *   <ALTLIMIT_BOTTOM REFERENCE="STD">
   *     <ALT UNIT="FL">80</ALT>
   *   </ALTLIMIT_BOTTOM>
   *   <GEOMETRY>
   *     <PATH>
   *       <POINT><LAT>52.1222</LAT><LON>8.31111</LON></POINT>
   *       ...
   *     </PATH>
   *   </GEOMETRY>
   * </ASP>
   *
   */
  public function toXml($indent) {
    $result = $indent . "<ASP CATEGORY=\"" . $this->category . "\">\n";
    $result .= $indent . " <NAME>" . $this->name . "</NAME>\n";
    $result .= $this->bottomLimit->toXml($indent . " ");
    $result .= $this->topLimit->toXml($indent . " ");
    $result .= $this->geometry->toXml($indent . " ");
    $result .= $indent . "</ASP>\n";

    return $result;
  }
  
  public function toOpenAir()
  {
    $result = "AC ";
   
    if (!strcmp($this->category, "CTR"))
    {
      $result .= "CTR";
    }
    else if (!strcmp($this->category, "FIR"))
    {
      $result .= "FIR";
    }
    else if (!strcmp($this->category, "UIR"))
    {
      $result .= "UIR";
    }
    else if (!strcmp($this->category, "RESTRICTED"))
    {
      $result .= "R";
    }
    else if (!strcmp($this->category, "PROHIBITED"))
    {
      $result .= "P";
    }
    else if(!strcmp($this->category, "A"))
    {
      $result .= "A";
    }
    else if(!strcmp($this->category, "B"))
    {
      $result .= "B";
    }
    else if(!strcmp($this->category, "C"))
    {
      $result .= "C";
    }
    else if(!strcmp($this->category, "D"))
    {
      $result .= "D";
    }
    else if(!strcmp($this->category, "E"))
    {
      $result .= "E";
    }
    else if(!strcmp($this->category, "F"))
    {
      $result .= "F";
    }
    else if(!strcmp($this->category, "DANGER"))
    {
      $result .= "Q";
    }
    else if(!strcmp($this->category, "WAVE"))
    {
      $result .= "W";
    }
    else if(!strcmp($this->category, "TMZ"))
    {
      $result .= "TMZ";
    }
    else if(!strcmp($this->category, "RMZ"))
    {
      $result .= "RMZ";
    }
    else if(!strcmp($this->category, "GLIDING"))
    {
      // use Wave type for gliding, as G is a bit ambiguous
      // due to airspace class G
      $result .= "W";
    }
    else if(!strcmp($this->category, "DROPZONE"))
    {
      $result .= "S";
    }
    else
    {
      $result .= "X";
    }
   
    $result .= "\n";
   
    $result .= "AN " . $this->name . "\n";
      
    $result .= $this->topLimit->toOpenAir();
    $result .= $this->bottomLimit->toOpenAir();

    $result .= $this->geometry->toOpenAir();

    return $result;
  }

  public function toGml($indent, $fid) {
    $result = $indent . "<gml:featureMember>\n";
    $result .= $indent . " <OPENAIP:aspc fid=\"$fid\">\n";
    $result .= $this->geometry->toGml($indent . " ");
    $result .= $indent . " <OPENAIP:CLASS>$this->category</OPENAIP:CLASS>\n";
    $result .= $indent . " <OPENAIP:NAME>$this->name</OPENAIP:NAME>\n";
    $result .= $this->bottomLimit->toGml($indent . " ");
    $result .= $this->topLimit->toGml($indent . " ");

    $result .= $indent . " </OPENAIP:aspc>\n";
    $result .= $indent . "</gml:featureMember>\n";
    return $result;
  }
  
  public function toWKT() {
    // TODO: implement
  }

}
