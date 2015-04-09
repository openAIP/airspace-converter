<?php
/**
 * @file  openAIP Airspace converter
 *
 */
class GeoLocation {

    public $lat = 0.0;
    public $lon = 0.0;
    // in nm
    private $MEAN_EARTH_RADIUS = 3440.069;

    // distance in nm
    public function distanceTo($dest) {
        $lat1 = deg2rad($this->lat);
        $lon1 = deg2rad($this->lon);
        $lat2 = deg2rad($dest->lat);
        $lon2 = deg2rad($dest->lon);

        return acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lon2 - $lon1)) * $this->MEAN_EARTH_RADIUS;
    }

    public function bearingTo($dest) {
        $lat1 = deg2rad($this->lat);
        $lat2 = deg2rad($dest->lat);
        $dlon = deg2rad($dest->lon - $this->lon);

        $y = sin($dlon) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dlon);

        $result = atan2($y, $x);

        // normalize to 0 - 2*PI
        if ($result > (2.0 * M_PI)) {
            $result -= (2.0 * M_PI);
        }
        elseif ($result < 0.0) {
            $result += (2.0 * M_PI);
        }

        return $result;
    }

    // distance in nm
    public function pointInDirectionAndDistance($brgRad, $distance) {
        $result = new AipPoint();

        $lat1 = deg2rad($this->lat);
        $lat2 = asin(sin($lat1) * cos($distance / $this->MEAN_EARTH_RADIUS) + cos($lat1) * sin($distance / $this->MEAN_EARTH_RADIUS) * cos($brgRad));

        $lon1 = deg2rad($this->lon);
        $lon2 = $lon1 + atan2(sin($brgRad) * sin($distance / $this->MEAN_EARTH_RADIUS) * cos($lat1), cos($distance / $this->MEAN_EARTH_RADIUS) - sin($lat1) * sin($lat2));

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



