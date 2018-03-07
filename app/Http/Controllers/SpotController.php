<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \GuzzleHttp\Client;

class SpotController extends Controller
{

    public $GLERL_ENDPOINT = 'http://data.glos.us/glcfs/glcfsps.glos?';

    public static $aaTimeZones = ['America/Chicago', 'America/New_York'];

    public static $aLakes = ['Michigan', 'Erie', 'Huron', 'Ontario', 'Superior'];

    public static $aaSpotsByLatandLon = [
        //Montrose
        ['id' => 1, 'name' => 'Montrose Beach', 'short' => 'montrose', 'lake' => 'michigan', 'city' => 'Chicago', 'lat' => 41.9674 , 'long' => -87.6341, 'tz' => 'America/Chicago'],
        //57th Street
        ['id' => 2, 'name' => '57th Street', 'short' => '57thstreet', 'lake' => 'michigan', 'city' => 'Chicago', 'lat' => 41.7930, 'long' => -87.5765, 'tz' => 'America/Chicago']
    ];

    /*
     * List of Surfing Spots matched with http://www.surfline.com ID
     */
    public static $aaSurflineSpots = [
        ['sName' => '57th Street', 'sShort' => '57thstreet', 'iId' => 72800], ['sName' => 'Montrose Ave', 'sShort' => 'montrose', 'iId' => 72803], ['sName' => 'North Ave Beach', 'sShort' => 'northavebeach', 'iId' => 72811], ['sName' => 'Whiting', 'sShort' => 'whiting', 'iId' => 72798]
    ];

    /*
     * List of Surfing Spots matched with http://www.magicseaweed.com ID
     */
    public static $aaMagicSeaweedSpots = [
        ['sName' => 'North Ave Beach', 'sShort' => 'northavebeach', 'iId' => 960]
    ];

    public function findBySurflineId($name, $id)
    {
        $asSurflineSpots = SpotController::$aaSurflineSpots;
        $spotId = $id;
        $spotName = $name;

        $client = new \GuzzleHttp\Client();

        //Surfline
        $surflineRes = $client->request('GET', env('SURFLINE_API_ENDPOINT_START'). $id .'?resources=surf,weather&days=5&getAllSpots=false&units=e&usenearshore=true&interpolate=true&showOptimal=true');
        $surflineData = $surflineRes->getBody();
        $aSurflineData = json_decode($surflineData);

        dd($aSurflineData);
        return view('spot', compact(['aSurflineData', 'asSurflineSpots']));
    }

    public function findByMagicSeaweedId($name, $id)
    {
        $asSpots = SpotController::$aaMagicSeaweedSpots;
        $spotId = $id;
        $spotName = $name;
        $mswKey = env('MAGICSEAWEED_API_KEY');
        $client = new \GuzzleHttp\Client();

        //MagicSeaweed
        $mswRes = $client->request('GET', env('MSW_API_ENDPOINT_START') . $mswKey . '/forecast/?spot_id=' . $id);
        $mswData = $mswRes->getBody();
        $aMswData = json_decode($mswData);

        return view('spot', compact(['aMswData', 'asSpots']));
    }

    /*
     * use GLERL Data
     */
    public function findByLatAndLongitude($sLake, $sSpotName, $iId)
    {
        $aSpot = SpotController::$aaSpotsByLatandLon[$iId - 1];
        $iLong = $aSpot['long']; //Longitdue of spot
        $iLat = $aSpot['lat']; //Latitude of spot
        $sTimeZone = $aSpot['tz'];

        $sStart = $this->getStartTime($sTimeZone); //now
        $sEnd = $this->getEndTime($sTimeZone); //5 days in future

        $sTZOffset = $this->getTimeZoneOffset($sTimeZone);

        $sEndpoint = $this->GLERL_ENDPOINT . 'lake=' . $sLake . '&i=' . $iLong . '&j=' . $iLat . '&v=wvh,wvd,wvp&t=forecast&st=' . $sStart . '&et=' . $sEnd . '&u=e' . '&order=asc&pv=1&tzf=' . $sTZOffset .'&f=csv';

        $txt_file = file_get_contents($sEndpoint);
        $rows = explode("\n", $txt_file);
        $formattedRows = [];
        foreach($rows as $row){
            $data = explode(',',$row);
            $formattedRows[] = $data;
        }

        $client = new \GuzzleHttp\Client();
        $sRes = $client->request('GET', $sEndpoint);
        $sData = $sRes->getBody();
        dd($formattedRows);
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
}
