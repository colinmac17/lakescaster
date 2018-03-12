<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \GuzzleHttp\Client;

class APIController extends Controller
{

    public function getSpotById($sLake, $sSpot, $iId)
    {
        $oSpotController = new SpotController();
        $aSpot = SpotController::$aaSpotsByLatandLon[$iId - 1];
        $iLong = $aSpot['long']; //Longitdue of spot
        $iLat = $aSpot['lat']; //Latitude of spot
        $iZip = $aSpot['zip'];
        $sTimeZone = $aSpot['tz'];

        $sStart = $oSpotController->getStartTime($sTimeZone); //now
        $sEnd = $oSpotController->getEndTime($sTimeZone); //5 days in future

        $sTZOffset = $oSpotController->getTimeZoneOffset($sTimeZone);

       $aWaveData = $this->getWaveData($sLake, $iLat, $iLong, $sStart, $sEnd, $sTZOffset);
       $aWeatherForecastData = $this->getWeatherForecast($iZip);
       $aWeatherNowData = $this->getCurrentWeather($iZip);

       return ['surfData' => $aWaveData, 'weatherForecast' => $aWeatherForecastData, 'currentWeather' => $aWeatherNowData];
    }

    /**
     * Gets Weather Forecast Data for provided Zip Code in increments of 3 hours for next 5 days
     *
     * @param $iZip
     * @return array
     */
    public function getWeatherForecast($iZip)
    {
        $sWeatherForecastEndpoint = 'api.openweathermap.org/data/2.5/forecast?zip=' . $iZip . '&units=imperial&appid=' . env('OPEN_WEATHER_API_KEY');

        $client = new \GuzzleHttp\Client();
        $weatherRes = $client->request('GET', $sWeatherForecastEndpoint);
        $sWeatherData = $weatherRes->getBody();
        return json_decode($sWeatherData);
    }

    /**
     * Gets Current Weather data for provided Zip
     *
     * @param $iZip
     * @return array
     */
    public function getCurrentWeather($iZip)
    {
        $sWeatherNowEndpoint = 'api.openweathermap.org/data/2.5/weather?zip=' . $iZip . '&units=imperial&appid=' . env('OPEN_WEATHER_API_KEY');

        $client = new \GuzzleHttp\Client();
        $weatherRes = $client->request('GET', $sWeatherNowEndpoint);
        $sWeatherData = $weatherRes->getBody();
        return json_decode($sWeatherData);
    }

    /**
     * Gets Wave Data from GLERL for determined latitude and longitude for the next 5 days
     *
     * @param string $sLake
     * @param integer $iLat
     * @param integer $iLong
     * @param string $sStart
     * @param string $sEnd
     * @param string $sTZOffset
     * @return array
     */
    public function getWaveData($sLake, $iLat, $iLong, $sStart, $sEnd, $sTZOffset)
    {
        $oSpotController = new SpotController();
        $sWaveEndpoint = $oSpotController->GLERL_ENDPOINT . 'lake=' . $sLake . '&i=' . $iLong . '&j=' . $iLat . '&v=wvh,wvd,wvp&t=forecast&st=' . $sStart . '&et=' . $sEnd . '&u=e' . '&order=asc&pv=1&tzf=' . $sTZOffset .'&f=csv';

        $wave_txt_file = file_get_contents($sWaveEndpoint);
        $waveRows = explode("\n", $wave_txt_file);
        $aWaveFormattedRows = [];
        foreach($waveRows as $row){
            $data = explode(',',$row);
            $aWaveFormattedRows[] = $data;
        }
        return $aWaveFormattedRows;
    }

    public function getSpotsByLake($lake)
    {

    }

    public function getAllSpots()
    {

    }

    /**
     * turn WeatherAPI Timezone into Timezone of Spot
     */
    public function convertUTCToTZ()
    {

    }
}
