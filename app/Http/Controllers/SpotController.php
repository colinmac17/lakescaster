<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \GuzzleHttp\Client;

class SpotController extends Controller
{

    public $GLERL_ENDPOINT = 'http://data.glos.us/glcfs/glcfsps.glos?';

    public static $aaSpotsByLatandLon = [
        ['id' => 1, 'name' => 'Montrose Beach', 'lake' => 'michigan', 'lat' => 41.9674 , 'long' => -87.6341]
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
        $iLong = $aSpot['long'];
        $iLat = $aSpot['lat'];
        $sStart =  date('Y-m-d:H:i:s');
        $sEnd = date('Y-m-d:H:i:s', time() + (86400*4));
        $sEndpoint = $this->GLERL_ENDPOINT . 'lake=' . $sLake . '&i=' . $iLong . '&j=' . $iLat . '&v=wvh,wvd,wvp&st=' . $sStart . '&et=' . $sEnd . '&u=e' . '&order=asc&pv=1&tzf=-6&f=csv';
        $txt_file    = file_get_contents($sEndpoint);
        $rows        = explode("\n", $txt_file);
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
}
