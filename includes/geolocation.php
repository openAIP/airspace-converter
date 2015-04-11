<?php

/**
 * @file openAIP Airspace converter
 *
 * For full copyright and license information, please review the LICENSE
 * file that was distributed with this source code.
 *
 */

/**
 * Class GeoLocation
 */
class GeoLocation
{
    // in nm
    const MEAN_EARTH_RADIUS = 3440.069;
    /**
     * @var float
     */
    public $lat = 0.0;
    /**
     * @var float
     */
    public $lon = 0.0;

    /**
     * distance in nm
     *
     * @param $dest
     *
     * @return float
     */
    public function distanceTo($dest)
    {
        $lat1 = deg2rad($this->lat);
        $lon1 = deg2rad($this->lon);
        $lat2 = deg2rad($dest->lat);
        $lon2 = deg2rad($dest->lon);

        return acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lon2 - $lon1)) * static::MEAN_EARTH_RADIUS;
    }

    /**
     * @param $dest
     *
     * @return float
     */
    public function bearingTo($dest)
    {
        $lat1 = deg2rad($this->lat);
        $lat2 = deg2rad($dest->lat);
        $dlon = deg2rad($dest->lon - $this->lon);

        $y = sin($dlon) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dlon);

        $result = atan2($y, $x);

        // normalize to 0 - 2*PI
        if ($result > (2.0 * M_PI)) {
            $result -= (2.0 * M_PI);
        } elseif ($result < 0.0) {
            $result += (2.0 * M_PI);
        }

        return $result;
    }

    /**
     * distance in nm
     *
     * @param $brgRad
     * @param $distance
     *
     * @return AipPoint
     */
    public function pointInDirectionAndDistance($brgRad, $distance)
    {
        $result = new AipPoint();

        $lat1 = deg2rad($this->lat);
        $lat2 = asin(sin($lat1) * cos($distance / static::MEAN_EARTH_RADIUS) + cos($lat1) * sin($distance / static::MEAN_EARTH_RADIUS) * cos($brgRad));

        $lon1 = deg2rad($this->lon);
        $lon2 = $lon1 + atan2(sin($brgRad) * sin($distance / static::MEAN_EARTH_RADIUS) * cos($lat1),
                cos($distance / static::MEAN_EARTH_RADIUS) - sin($lat1) * sin($lat2));

        // normalise to -PI...+PI
        $lon2 += M_PI;
        if ($lon2 > (2.0 * M_PI)) {
            $lon2 -= (2.0 * M_PI);
        }
        $lon2 -= M_PI;

        $result->lon = rad2deg($lon2);
        $result->lat = rad2deg($lat2);

        return $result;
    }
}
