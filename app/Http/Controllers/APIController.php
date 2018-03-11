<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{

    public function getSpotById($sLake, $sSpot, $iId)
    {
        $oSpotController = new SpotController();
        $aSpot = SpotController::$aaSpotsByLatandLon[$iId - 1];
        $iLong = $aSpot['long']; //Longitdue of spot
        $iLat = $aSpot['lat']; //Latitude of spot
        $sTimeZone = $aSpot['tz'];

        $sStart = $oSpotController->getStartTime($sTimeZone); //now
        $sEnd = $oSpotController->getEndTime($sTimeZone); //5 days in future

        $sTZOffset = $oSpotController->getTimeZoneOffset($sTimeZone);

        $sEndpoint = $oSpotController->GLERL_ENDPOINT . 'lake=' . $sLake . '&i=' . $iLong . '&j=' . $iLat . '&v=wvh,wvd,wvp&t=forecast&st=' . $sStart . '&et=' . $sEnd . '&u=e' . '&order=asc&pv=1&tzf=' . $sTZOffset .'&f=csv';

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
        return $formattedRows;
    }

    public function getSpotsByLake($lake)
    {

    }

    public function getAllSpots()
    {

    }
}
