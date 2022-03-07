<?php
namespace App\Entity;
 class Mymap{


private static $apikey = 'AIzaSyBJb6HVcCz5PwSJZdPSbvlI9PKIr_owITw';   

public static function geocodeAddress($address) {
    //valeurs vide par défaut
    $data = array('address' => '', 'lat' => '', 'lng' => '', 'city' => '', 'department' => '', 'region' => '', 'country' => '', 'postal_code' => '');
    //on formate l'adresse
    $address = str_replace(" ", "+", $address);
    //on fait l'appel à l'API google map pour géocoder cette adresse
    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=".self::$apikey."&address=$address&sensor=false");
    $json = json_decode($json);
    echo($address);
    //on enregistre les résultats recherchés
    if ($json->status == 'OK' && count($json->results) > 0) {
       
        $res = $json->results[0];
        //adresse complète et latitude/longitude
        $data['address'] = $res->formatted_address;
      
        $data['lat'] = $res->geometry->location->lat;
     
        $data['lng'] = $res->geometry->location->lng;
        foreach ($res->address_components as $component) {
            //ville
            if ($component->types[0] == 'locality') {
                $data['city'] = $component->long_name;
            }
            //départment
            if ($component->types[0] == 'administrative_area_level_2') {
                $data['department'] = $component->long_name;
            }
            //région
            if ($component->types[0] == 'administrative_area_level_1') {
                $data['region'] = $component->long_name;
            }
            //pays
            if ($component->types[0] == 'country') {
                $data['country'] = $component->long_name;
            }
            //code postal
            if ($component->types[0] == 'postal_code') {
                $data['postal_code'] = $component->long_name;
            }
        }
    }
    return $data;
}
}