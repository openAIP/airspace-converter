<?php
/**
 * @file  openAIP Airspace converter
 *
 */
class AipVerticalLimit {

    public $refString;
    public $altString;
    public $unitString;
    private $positionString;

    function __construct($pos) {
        $this->positionString = $pos;
        $this->unitString = "F";
    }

    /*
     * 	$indentation is a string, containing whitespaces, which is
     * 	put in front of each line.
     *
     * 		<ALTLIMIT_TOP REFERENCE="STD">
     * 			<ALT UNIT="FL">150</ALT>
     * 		</ALTLIMIT_TOP>
     *
     */

    public function toXml($indent) {
        $result = $indent . "<ALTLIMIT_" . $this->positionString . " REFERENCE=\"" . $this->refString . "\">\n";
        $result .= $indent . "  <ALT UNIT=\"" . $this->unitString . "\">" . $this->altString . "</ALT>\n";
        $result .= $indent . "</ALTLIMIT_" . $this->positionString . ">\n";

        return $result;
    }
    
    public function toOpenAir()
    {
      $result = "AH ";
      
      if (!strcmp($this->positionString, "BOTTOM"))
      {
        $result = "AL ";
      }
      
      if (!strcmp($this->refString, "GND"))
      {
        // if the altitude is not 0 above GND
        if (strcmp($this->altString, "0"))
        {
          $result .= $this->altString . $this->unitString . " ";
        }
        
        $result .= "GND";
      }
      else if (!strcmp($this->refString, "MSL"))
      {
        $result .= $this->altString . $this->unitString . " MSL";
      }
      else if (!strcmp($this->refString, "STD"))
      {
        if (!strcmp($this->unitString, "FL"))
        {
          $result .= "FL " . $this->altString;
        }
        else
        {
          $result .= $this->altString . $this->unitString . " STD";
        }
      }

      $result .= "\n";
      
      return $result;
    }
    
    public function toGml($indent) {
        $result = $indent . "<OPENAIP:" . $this->positionString  . ">\n";
        $result .= $indent . "  <OPENAIP:REF>" . $this->refString  . "</OPENAIP:REF>\n";
        $result .= $indent . "  <OPENAIP:UNIT>" . $this->unitString  . "</OPENAIP:UNIT>\n";
        $result .= $indent . "  <OPENAIP:ALT>" . $this->altString  . "</OPENAIP:ALT>\n";
        $result .= $indent . "</OPENAIP:" . $this->positionString  . ">\n";

        return $result;
    }

}



