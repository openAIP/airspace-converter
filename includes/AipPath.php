<?php

/**
 * @file openAIP Airspace converter
 *
 * For full copyright and license information, please review the LICENSE
 * file that was distributed with this source code.
 *
 */
require_once 'AipPoint.php';

/**
 * Class AipPath
 */
class AipPath
{
    /**
     * @var array
     */
    public $pathElements = [];

    /**
     * @param $point
     */
    public function appendPoint($point)
    {
        $this->pathElements[] = $point;
    }

    /**
     * Close path.
     */
    public function closePath()
    {
        // check if path is already closed
        if (($this->pathElements[0]->lon == end($this->pathElements)->lon) && ($this->pathElements[0]->lat == end($this->pathElements)->lat)) {
            // path already closed
            return;
        } else {
            $this->appendPoint($this->pathElements[0]);
        }
    }

    public function getElementCount()
    {
        return count($this->pathElements);
    }

    /**
     * @return string
     */
    public function toGml()
    {
        $result = "";
        $numElements = count($this->pathElements);
        for ($idx = 0; $idx < $numElements; $idx++) {
            $result .= $this->pathElements[$idx]->lon.",".$this->pathElements[$idx]->lat;
            if ($idx < ($numElements - 1)) {
                $result .= " ";
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    public function toOpenAir()
    {
        $result = "";
        $numElements = count($this->pathElements);
        for ($idx = 0; $idx < $numElements; $idx++) {
            $result .= $this->pathElements[$idx]->toOpenAir();
        }

        return $result;
    }

    /**
     * @return string
     */
    public function toWkt()
    {
        $result = "";
        $numElements = count($this->pathElements);
        for ($idx = 0; $idx < $numElements; $idx++) {
            $result .= $this->pathElements[$idx]->lon." ".$this->pathElements[$idx]->lat;
            if ($idx < ($numElements - 1)) {
                $result .= ", ";
            }
        }

        return $result;
    }

    /**
     * $indent is a string, containing whitespaces, which is
     * prepended to each line.
     *
     * <PATH>
     *  <POINT><LAT>52.1222</LAT><LON>8.31111</LON></POINT>
     *  ...
     * </PATH>
     *
     * @param $ident
     */
    public function toXml($indent)
    {
        $result = $indent."<PATH>\n";
        $numElements = count($this->pathElements);

        for ($idx = 0; $idx < $numElements; $idx++) {
            $result .= $this->pathElements[$idx]->toXml($indent." ");
        }

        $result .= $indent."</PATH>\n";

        return $result;
    }
}
