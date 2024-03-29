<?php

    require(__DIR__ . "/../includes/config.php");

    // numerically indexed array of places
    $places = [];

    $places = CS50::query("SELECT * FROM places WHERE MATCH(postal_code, place_name, admin_name1) AGAINST (?)", $_GET["geo"]);
    
    // implements the autocomplete for postal codes and place name
    if (count($places) == 0)
    {
        $places = CS50::query("SELECT * FROM places WHERE place_name LIKE ?", $_GET["geo"] . "%");
        if (count($places) == 0)
        {
            $places = CS50::query("SELECT * FROM places WHERE postal_code LIKE ?", $_GET["geo"] . "%");
        }
    }

    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($places, JSON_PRETTY_PRINT));

?>