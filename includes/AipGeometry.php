<?php

/**
 * @file  openAIP Airspace converter
 *
 * For full copyright and license information, please review the LICENSE
 * file that was distributed with this source code.
 *
 */
require_once 'AipPath.php';

/**
 * Class AipGeometry
 */
class AipGeometry
{
    /**
     * @var array
     */
    private $geoElements = [];

    /**
     * @param $element
     */
    public function appendElement($element)
    {
        $this->geoElements[] = $element;
    }

    public function getGeoElementsCount()
    {
        return count($this->geoElements);
    }

    public function hasValidNodeCount()
    {
        return $this->getGeoElementsCount() > 4;
    }

    /**
     * @param $indent
     *
     * @return string
     */
    public function toGml($indent)
    {
        $result = $indent."<OPENAIP:geometry><gml:Polygon><gml:outerBoundaryIs><gml:LinearRing><gml:coordinates>";

        foreach ($this->geoElements as $element) {
            $result .= $element->toGml();
        }

        $result .= "</gml:coordinates></gml:LinearRing></gml:outerBoundaryIs></gml:Polygon></OPENAIP:geometry>\n";

        return $result;
    }

    /**
     * @return string
     */
    public function toOpenAir()
    {
        $result = "";

        foreach ($this->geoElements as $element) {
            $result .= $element->toOpenAir();
        }

        return $result;
    }

    /**
     * @return string
     */
    public function toWkt()
    {
        $result = "POLYGON((";
        foreach ($this->geoElements as $element) {
            $result .= $element->toWkt();
        }
        $result .= "))";

        return $result;
    }

    /**
     * $indent is a string, containing whitespaces, which is
     * prepended to each line.
     *  <GEOMETRY>
     *    <PATH>
     *      <POINT><LAT>52.1222</LAT><LON>8.31111</LON></POINT>
     *      ...
     *    </PATH>
     *  </GEOMETRY>
     *
     * @param $ident
     */
    public function toXml($indent)
    {
        $result = $indent."<GEOMETRY>\n";

        foreach ($this->geoElements as $element) {
            $result .= $element->toXml($indent."  ");
        }

        $result .= $indent."</GEOMETRY>\n";

        return $result;
    }
}
