<?php
/**
 * @file  openAIP Airspace converter
 *
 */
include 'open_aip_airspace.converter.path.inc';

class AipGeometry {

    private $geoElements = array();

    public function appendElement($element) {
        $this->geoElements[] = $element;
    }

    /*
     * 	$indentation is a string, containing whitespaces, which is
     * 	put in front of each line.
     *
     * 		<GEOMETRY>
     * 			<PATH>
     * 				<POINT>
     * 					<LAT>52.1222</LAT>
     * 					<LON>8.31111</LON>
     * 				</POINT>
     * 			...
     *
     * 			</PATH>
     * 		</GEOMETRY>
     *
     */

    public function toXml($indent) {
        $result = $indent . "<GEOMETRY>\n";

        foreach ($this->geoElements as $element) {
            $result .= $element->toXml($indent . "  ");
        }

        $result .= $indent . "</GEOMETRY>\n";

        return $result;
    }
    
    public function toOpenAir()
    {
      $result = "";

      foreach ($this->geoElements as $element)
      {
        $result .= $element->toOpenAir();
      }

      return $result;
    }
    
    public function toGml($indent) {
        $result = $indent . "<OPENAIP:geometry><gml:Polygon><gml:outerBoundaryIs><gml:LinearRing><gml:coordinates>";

        foreach ($this->geoElements as $element) {
           $result .= $element->toGml();
        }

        $result .= "</gml:coordinates></gml:LinearRing></gml:outerBoundaryIs></gml:Polygon></OPENAIP:geometry>\n";

        return $result;
    }
    
    public function toWkt() {
      $result = "POLYGON((";

      foreach ($this->geoElements as $element) {
         $result .= $element->toWkt();
      }

      $result .= "))";

      return $result;
    }


}



