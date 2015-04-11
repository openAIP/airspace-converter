<?php

/**
 * @file openAIP Airspace converter
 *
 * For full copyright and license information, please review the LICENSE
 * file that was distributed with this source code.
 *
 */

/**
 * Class AipVerticalLimit
 */
class AipVerticalLimit
{
    /**
     * @var string
     */
    public $refString;
    /**
     * @var string
     */
    public $altString;
    /**
     * @var string
     */
    public $unitString;
    /**
     * @var string
     */
    private $positionString;

    /**
     * @param $pos
     */
    function __construct($pos)
    {
        $this->positionString = $pos;
        $this->unitString = "F";
    }

    /**
     * $indent is a string, containing whitespaces, which is
     * prepended to each line.
     *
     * <ALTLIMIT_TOP REFERENCE="STD">
     *   <ALT UNIT="FL">150</ALT>
     * </ALTLIMIT_TOP>
     *
     * @param $ident
     */
    public function toXml($indent)
    {
        $result = $indent."<ALTLIMIT_".$this->positionString." REFERENCE=\"".$this->refString."\">\n";
        $result .= $indent." <ALT UNIT=\"".$this->unitString."\">".$this->altString."</ALT>\n";
        $result .= $indent."</ALTLIMIT_".$this->positionString.">\n";

        return $result;
    }

    /**
     * @return string
     */
    public function toOpenAir()
    {
        $result = "AH ";

        if (!strcmp($this->positionString, "BOTTOM")) {
            $result = "AL ";
        }

        if (!strcmp($this->refString, "GND")) {
            // if the altitude is not 0 above GND
            if (strcmp($this->altString, "0")) {
                $result .= $this->altString.$this->unitString." ";
            }

            $result .= "GND";
        } else {
            if (!strcmp($this->refString, "MSL")) {
                $result .= $this->altString.$this->unitString." MSL";
            } else {
                if (!strcmp($this->refString, "STD")) {
                    if (!strcmp($this->unitString, "FL")) {
                        $result .= "FL ".$this->altString;
                    } else {
                        $result .= $this->altString.$this->unitString." STD";
                    }
                }
            }
        }

        $result .= "\n";

        return $result;
    }

    /**
     * $indent is a string, containing whitespaces, which is
     * prepended to each line.
     *
     * @param $ident
     */
    public function toGml($indent)
    {
        $result = $indent."<OPENAIP:".$this->positionString.">\n";
        $result .= $indent." <OPENAIP:REF>".$this->refString."</OPENAIP:REF>\n";
        $result .= $indent." <OPENAIP:UNIT>".$this->unitString."</OPENAIP:UNIT>\n";
        $result .= $indent." <OPENAIP:ALT>".$this->altString."</OPENAIP:ALT>\n";
        $result .= $indent."</OPENAIP:".$this->positionString.">\n";

        return $result;
    }
}
