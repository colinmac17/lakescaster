<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \GuzzleHttp\Client;

class SpotController extends Controller
{

    public function __construct()
    {
        $this->aSimpleSpots = self::getSimpleSpots();
    }

    public $GLERL_ENDPOINT = 'http://data.glos.us/glcfs/glcfsps.glos?';

    public static $aaTimeZones = ['America/Chicago', 'America/New_York'];

    public static $aLakes = ['Michigan', 'Erie', 'Huron', 'Ontario', 'Superior'];

    public static $aaSpotsByLatandLon = [
        //Montrose
        ['id' => 1, 'name' => 'Montrose Beach', 'short' => 'montrose', 'lake' => 'michigan', 'lat' => 41.9674 , 'long' => -87.6341, 'tz' => 'America/Chicago', 'city' => 'Chicago', 'zip' => 60640, 'sPhoto' => '', 'sDescription' => 'Montrose Beach is located at 4400 N. Lake Shore Drive (Montrose Ave. at Lake Michigan) near the Uptown neighborhood.  This popular beach offers patrons amenities that include food concessions, kayak and volleyball rentals, showers and restrooms.  There is a non-motorized boat launch. An ADA accessible beach walk is available.  Patrons can park at pay and display lots or street parking.  Distance swimming is available from Tower 4 (north of boathouse) and parallel to shore. A dog friendly beach is located at north end of Montrose Beach.'],
        //57th Street
        ['id' => 2, 'name' => '57th Street', 'short' => '57thstreet', 'lake' => 'michigan', 'lat' => 41.7930, 'long' => -87.5765, 'tz' => 'America/Chicago', 'city' => 'Chicago', 'zip' => 60637, 'sPhoto' => '', 'sDescription' => '57th Street Beach is located at 5700 S. Lake Shore Drive (57th St. @ Lake Michigan) in Jackson Park.  This beach features an ADA accessible beach walk and restrooms.  Beach goers can stop by the Tasty Grill offering a Mexican menu along with hot dogs and refreshing beverages.  The distance swimming area is located parallel to shore from 55th Street south to pier.  Limited street parking is available nearby, west of Lake Shore Drive.'],
        ['id' => 3, 'name' => 'Grand Haven Pier', 'short' => 'grandhaven', 'lake' => 'michigan', 'lat' => 43.0532, 'long' =>  -86.2679, 'tz' => 'America/New_York','city' => 'Grand Haven', 'zip' => 49417, 'sPhoto' => '', 'sDescription' => 'Sandy swimming beach located on Lake Michigan. The city beach is nestled between The Bil-Mar, a beachfront restaurant, and Grand Haven State Park beach on Harbor Drive. Limited free parking is available. Restrooms available. No fees or passes required. Surfers usually surf anywhere on the southside of the pier.'],
        ['id' => 4, 'name' => 'Hamburg Beach', 'short' => 'hamburg', 'lake' => 'erie', 'lat' => 42.7651, 'long' =>  -78.8797, 'tz' => 'America/New_York','city' => 'Hamburg', 'zip' => 14075, 'sPhoto' => '', 'sDescription' => 'The Hamburg Town Park & Beach is located on a sloping shore of eastern Lake Erie, just west of the hamlet of Athol Springs. The park centers around a large white building overlooking its golden sandy beach. Within is the fitness center, changing rooms, park office, and a snack bar. There is also a concrete boat launch and an area set aside for windsurfing. Although it is a nice setting, with ample parking, a clean and guarded swimming area, and excellent views of Lake Erie and Buffalo on the horizon, access is limited to Hamburg Town residents (and their guests) only, and so we recommend passing it by and heading either west to Wendt Beach Park, or north to Woodlawn Beach State Park.'],
        ['id' => 5, 'name' => 'Ashbridges Bay', 'short' => 'ashbridgesbay', 'lake' => 'ontario', 'lat' => 43.6609, 'long' =>  -79.3049, 'tz' => 'America/New_York','city' => 'Toronto', 'zip' => '', 'sPhoto' => '', 'sDescription' => 'Ashbridges Bay Park is located in a beautiful area on the waterfront in the east end of Toronto. Ashbridges Bay was once part of the large sand dune chain spanning the majority of the Toronto Harbour. These dunes were the result of sediment from the Scarborough Bluffs being deposited by the currents from Lake Ontario.'],
        ['id' => 6, 'name' => 'Port Crescent State Park', 'short' => 'portcrescent', 'lake' => 'huron', 'lat' => 44.0024, 'long' =>  -83.0899, 'tz' => 'America/New_York','city' => 'Port Austin', 'zip' => 48467, 'sPhoto' => '', 'sDescription' => 'Located at the tip of Michigan\'s "thumb" along three miles of sandy shoreline of the Saginaw Bay. 565 acres of woods, offer excellent hunting opportunities, wet lands and the best sand dunes and beaches on the eastern side of the state. An accessible fishing deck, and seven miles of trails through various areas of the park for cross-country skiing. Some of the 137 modern campsites offer a waterfront view, either of Lake Huron or the Pinnebog River. A 900-foot boardwalk and five picnic decks offer scenic vistas from the top of sand dunes in the day-use area. One camper cabin available. Rustic organization camp for youth. Recreation Passport required for entry. Pet friendly shoreline.'],
        ['id' => 7, 'name' => 'Picnic Rocks Beach', 'short' => 'picnic rocks', 'lake' => 'superior', 'lat' => 46.5547, 'long' =>  -87.3813, 'tz' => 'America/New_York','city' => 'Marquette', 'zip' => 49855, 'sPhoto' => '', 'sDescription' => 'Picnic Rocks are known by many locals and visitors a like as the perfect play for a pit-stop on your way to Presque Isle. On either side of the rocks there are white sand beaches. Not to mention, the reason most people go there- for the stunning lake views. If you need a place to stretch your legs, this is definitely the spot!']
    ];

    /*
     * use GLERL Data
     */
    public function findByLatAndLongitude($sLake, $sSpotName, $iId)
    {
        $aaSpots = self::$aaSpotsByLatandLon;
        $aSpot = $aaSpots[$iId -1];
        $sName = $aSpot['name'];
        $aLakes = self::$aLakes;
        $aSimpleSpots = self::getSimpleSpots();
        $sPath = 'spots/' . $sLake . '/' . $sSpotName . '/' . $iId;
        $sDescription = $aSpot['sDescription'];
        return view('spot', compact('sLake', 'sName', 'iId', 'aaSpots', 'sPath', 'sDescription', 'aLakes', 'aSimpleSpots'));
    }

    public function getAllSpots()
    {
        $aaSpots = self::$aaSpotsByLatandLon;
        $aLakes = self::$aLakes;
        $aSimpleSpots = SpotController::getSimpleSpots();
        return view('allspots', compact('aaSpots', 'aLakes', 'aSimpleSpots'));
    }

    public function getTimeZoneOffset($sTimeZone)
    {
        $bIsDaylightSavingsTime = (date('I') === 1) ? true : false;
        switch($sTimeZone){
            case 'America/Chicago':
                $sTZ = $bIsDaylightSavingsTime ? '-5' : '-6'; //Determine if Daylight Savings Time or Not
                break;
            case 'America/New_York':
                $sTZ = $bIsDaylightSavingsTime ? '-4' : '-5'; //Determine if Daylight Savings Time or Not
                break;
        }

        return $sTZ;
    }

    public function getStartTime($sTimeZone)
    {
        $dStart = new \DateTime();
        $dStart->setTimeZone(new \DateTimeZone($sTimeZone));
        return $dStart->format('Y-m-d:H:i:s'); //Now
    }

    public function getEndTime($sTimeZone)
    {
        $dStart = new \DateTime();
        $dStart->setTimeZone(new \DateTimeZone($sTimeZone));
        $dEnd = $dStart->modify('+5 day');
        return $dEnd->format('Y-m-d:H:i:s'); // 5 days in future
    }

    public function searchSpots()
    {
        if(!isset($_POST['search'])) return false;
        $sSearch = strtolower($_POST['search']);
        $aSimpleSpots = $this->aSimpleSpots;
        $sSearch = preg_quote($sSearch, '~');
        $results = preg_grep('~' . $sSearch . '~', $aSimpleSpots);
        return $results;
    }

    public static function getSimpleSpots()
    {
        $aSimpleSpots = [];
        $aaSpots = SpotController::$aaSpotsByLatandLon;
        foreach($aaSpots as $iK => $aSpot){
            $aSimpleSpots[$iK]['name'] = $aSpot['name'];
            $aSimpleSpots[$iK]['link'] = 'spots/' . $aSpot['lake'] . '/' . $aSpot['short'] . '/' . $aSpot['id'];
        }

        return json_encode($aSimpleSpots);
    }
}

//
///*
// * List of Surfing Spots matched with http://www.surfline.com ID
// */
//public static $aaSurflineSpots = [
//    ['sName' => '57th Street', 'sShort' => '57thstreet', 'iId' => 72800], ['sName' => 'Montrose Ave', 'sShort' => 'montrose', 'iId' => 72803], ['sName' => 'North Ave Beach', 'sShort' => 'northavebeach', 'iId' => 72811], ['sName' => 'Whiting', 'sShort' => 'whiting', 'iId' => 72798]
//];
//
///*
// * List of Surfing Spots matched with http://www.magicseaweed.com ID
// */
//public static $aaMagicSeaweedSpots = [
//    ['sName' => 'North Ave Beach', 'sShort' => 'northavebeach', 'iId' => 960]
//];
//
//public function findBySurflineId($name, $id)
//{
//    $asSurflineSpots = SpotController::$aaSurflineSpots;
//    $spotId = $id;
//    $spotName = $name;
//
//    $client = new \GuzzleHttp\Client();
//
//    //Surfline
//    $surflineRes = $client->request('GET', env('SURFLINE_API_ENDPOINT_START'). $id .'?resources=surf,weather&days=5&getAllSpots=false&units=e&usenearshore=true&interpolate=true&showOptimal=true');
//    $surflineData = $surflineRes->getBody();
//    $aSurflineData = json_decode($surflineData);
//
//    dd($aSurflineData);
//    return view('spot', compact(['aSurflineData', 'asSurflineSpots']));
//}

//public function findByMagicSeaweedId($name, $id)
//{
//    $asSpots = SpotController::$aaMagicSeaweedSpots;
//    $spotId = $id;
//    $spotName = $name;
//    $mswKey = env('MAGICSEAWEED_API_KEY');
//    $client = new \GuzzleHttp\Client();
//
//    //MagicSeaweed
//    $mswRes = $client->request('GET', env('MSW_API_ENDPOINT_START') . $mswKey . '/forecast/?spot_id=' . $id);
//    $mswData = $mswRes->getBody();
//    $aMswData = json_decode($mswData);
//
//    return view('spot', compact(['aMswData', 'asSpots']));
//}
