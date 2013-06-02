<?php

/**
 * #GovHack 2013 - Gold Coast
 *
 * @author Inclusive/Illusive Team
 *
 * @author Andre Bocati @abocati
 *
 */

class Miggy {

    /*
     * How many countries display on map.
     */
    const topCountries = 10;

    /*
     * Google API for Google Places
     */
    const googleKey = "AIzaSyBXLj23TcjplKNZv1XDLWyxLbcy3kVnKiM";

    /*
     * An array with Latitude and Longitude from cities.
     */
    private static $cities = array(
        "QLD"  => "-28.01726,153.425699",  // Gold Coast
        "QLD"  => "-27.471011,153.023449", // Brisbane
        "NSW"  => "-33.867487,151.20699",  // Sydney
        "ACT"  => "-35.282,149.128684",    // Canberra
        "WA"   => "-31.953004,115.857469", // Perth
        "VIC"  => "-37.814107,144.96328",  // Melbourne
        "SA"   => "-34.928621,138.599959", // Adelaide
        "TAS"  => "-42.881903,147.323815", // Hobart
     );

    public static function getCityLocation($key){
        return self::$cities[$key];
    }

    /*
     * An array with icons by State
     */
    private static $icons = array(
        "QLD"  => "img/icons/restaurantIcon-aqua.png",
        "NSW"  => "img/icons/restaurantIcon-blue.png",
        "ACT"  => "img/icons/restaurantIcon-cyan.png",
        "WA"   => "img/icons/restaurantIcon-green.png",
        "VIC"  => "img/icons/restaurantIcon-orange.png",
        "SA"   => "img/icons/restaurantIcon-purple.png",
        "TAS"  => "img/icons/restaurantIcon-red.png",
     );

    public static function getIcon($key){
        return self::$icons[$key];
    }

    // 50KM radius from the City.
    const RADIUS = "1000";

    /**
     * Get the Mysql details
     */
    public function connect() {
        $link = mysql_pconnect("123host.com.au","mysites_govhack","govhack") or die(mysql_error());
        mysql_select_db("mysites_govhack", $link) or die(mysql_error());
    }

    /**
     * Retun min and max year from the data
     */
    public function getDropDownDataByYear($year) {

        $sql = "select year from SOURCE_OLAP group by year";
        $result = mysql_query($sql);

        echo "<option ='#'>Year</option>";
        while ($data = mysql_fetch_assoc($result)) {
            $select = "";
            if($data['year'] == $year) {$select = " selected ";}
            echo "<option value=". $data['year'] ." ". $select .">". $data['year'] . "</option>";
        }

    }


    /**
     *
     * Show the total of the top countries migrating to Australia.
     *
     */
    public function showGoogleChart($year) {

        if($year=="") return;

            $sql = "SELECT co.name as NAME, co.foodTags as tags, SUM(info.value) as total, so.`year` as year
                    FROM `COUNTRY_OLAP` co, `INFO_OLAP` info, `SOURCE_OLAP` so
                    where `so`.`year` = ". $year ."
                    and `info`.country_id = co.id
                    and info.source_id = so.id
                    and `co`.`id` <> 30
                    group by `co`.name, `so`.`year`
                    ORDER BY total DESC
                    LIMIT 0, 10";

        $result = mysql_query($sql);

        $countries = "";

        while ($data = mysql_fetch_assoc($result)) {
            $countries .= "['". $data["NAME"] . ' ('. number_format($data['total']) . ')' . "', ". $data['total']."],";
        }

        echo rtrim($countries, ",");

    }


    /**
     *
     * Show the total of the top countries migrating to Australia.
     *
     */
    public function showLabelMap($year) {

        if($year=="") return;

            $sql = "SELECT co.name as NAME, co.foodTags as tags, SUM(info.value) as total, so.`year` as year
                    FROM `COUNTRY_OLAP` co, `INFO_OLAP` info, `SOURCE_OLAP` so
                    where `so`.`year` = ". $year ."
                    and `info`.country_id = co.id
                    and info.source_id = so.id
                    and `co`.`id` <> 30
                    group by `co`.name, `so`.`year`
                    ORDER BY total DESC
                    LIMIT 0, 10";
        $result = mysql_query($sql);
        while ($data = mysql_fetch_assoc($result)) {
            echo '<a href="?year='. $_REQUEST['year'].'&keyword='. trim($data['tags']) .'#map"><span class="label label-info">'. $data["NAME"] .'</span></a>&nbsp;';
        }

    }


    /**
     *
     * Call Google Places API to be able to return the places.
     *
     * @param type $city
     *
     */
    public function getGooglePlaces($year) {

        if($year=="") return;

        // For the first time load the TOP 1 country.
        if(empty($_REQUEST['keyword'])) {
            $sql = "SELECT co.name as NAME, co.foodTags as tags, SUM(info.value) as total, so.`year` as year
                    FROM `COUNTRY_OLAP` co, `INFO_OLAP` info, `SOURCE_OLAP` so
                    where `so`.`year` = ". $year ."
                    and `info`.country_id = co.id
                    and info.source_id = so.id
                    and `co`.`id` <> 30
                    group by `co`.name, `so`.`year`
                    ORDER BY total DESC
                    LIMIT 0, 1";
                $result = mysql_query($sql);
                $data = mysql_fetch_array($result);
                $_REQUEST['keyword'] = $data['tags'];
        }

        $markers = "";
        $heated  = "";

        // Lets build an array of places by State :)
        foreach (self::$cities as $key => $value) {

            $geocode = $this->getCityLocation($key);

            $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=". $geocode ."&radius=". self::RADIUS ."&sensor=false&key=". self::googleKey ."&types=restaurant&keyword=". $_REQUEST['keyword'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $places = curl_exec($ch);

            $json = json_decode($places);

            $zindex = 1;

            foreach ( $json->results as $place) {

                    echo '<div class="media">';
                    echo '<div class="pull-left">';

                    // Return State icon.
                    $icon = $this->getIcon($key);

                    echo '<a><img  src="'. $icon .'" height="32" width="32"></a>';
                    echo '</div>';

                    echo '<div class="media-body">';
                    echo '<h5 class="media-heading">'. $place->name .'</h5>';
                    echo '<p>'. $place->vicinity .'</p>';

                    if(!empty($place->types)) {
                        echo "<p>";
                        foreach ($place->types as $type) {
                            echo '<span class="label label-info">'. $type .'</span>&nbsp;';
                        }
                        echo "<p>";
                    }

                    echo '</div>';
                    echo '</div>';

                    // Build an array of Markers for the Google Maps.
                    $markers .= "['". addslashes($place->name) ."', ". $place->geometry->location->lat .", ". $place->geometry->location->lng .", ". $zindex .", '". addslashes($place->name) . "<br>" . addslashes($place->vicinity)  ."', '". $icon ."'],";
                    $heated  .= "new google.maps.LatLng(". $place->geometry->location->lat .", ". $place->geometry->location->lng ."),";

                    $zindex++;
            }
        }

        // Spit the marks for the Map.
        echo "<script>";
        echo "var items = [";
        echo rtrim($markers, ",");
        echo "];";
        echo "\n";
        echo "var heated = [";
        echo rtrim($heated, ",");
        echo "]";
        echo "</script>";

    }

}