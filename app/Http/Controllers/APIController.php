<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \GuzzleHttp\Client;

class APIController extends Controller
{

    public static $sWeatherIconUrl = 'http://openweathermap.org/img/w/';

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

       $aaWaveData = $this->cleanWaveData($this->getWaveData($sLake, $iLat, $iLong, $sStart, $sEnd, $sTZOffset));
       $aWeatherForecastData = $this->cleanWeatherForecastData($this->getWeatherForecast($iLat, $iLong), $sTimeZone);
       $aWeatherNowData = $this->cleanWeatherData($this->getCurrentWeather($iLat, $iLong));

       return ['surfData' => $aaWaveData, 'weatherForecast' => $aWeatherForecastData, 'currentWeather' => $aWeatherNowData];
    }

    /**
     * Gets Weather Forecast Data for provided Zip Code in increments of 3 hours for next 5 days
     *
     * @param $iZip
     * @return array
     */
    public function getWeatherForecast($iLat, $iLong)
    {
        $sWeatherForecastEndpoint = 'api.openweathermap.org/data/2.5/forecast?lat=' . $iLat . '&lon=' . $iLong . '&units=imperial&appid=' . env('OPEN_WEATHER_API_KEY');

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
    public function getCurrentWeather($iLat, $iLong)
    {
        $sWeatherNowEndpoint = 'api.openweathermap.org/data/2.5/weather?lat=' . $iLat . '&lon=' . $iLong . '&units=imperial&appid=' . env('OPEN_WEATHER_API_KEY');

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
        //most of the way data
        $sWaveEndpoint = $oSpotController->GLERL_ENDPOINT . 'lake=' . $sLake . '&i=' . $iLong . '&j=' . $iLat . '&v=wvh,wvd,wvp&t=forecast&st=' . $sStart . '&et=' . $sEnd . '&u=e' . '&order=asc&pv=1&tzf=' . $sTZOffset .'&f=csv';
        $wave_txt_file = file_get_contents($sWaveEndpoint);
        $waveRows = explode("\n", $wave_txt_file);
        $aWaveFormattedRows = [];
        foreach($waveRows as $row){
            $data = explode(',',$row);
            $aWaveFormattedRows[] = $data;
        }
        //Water temp data
        $sWaterTempEndpoint = $oSpotController->GLERL_ENDPOINT . 'lake=' . $sLake . '&i=' . $iLong . '&j=' . $iLat . '&v=temp&st=' . $sStart . '&et=' . $sEnd . '&rdepth=0&u=e&order=asc&pv=1&tzf=' . $sTZOffset . '&f=csv';
        $water_temp_file = file_get_contents($sWaterTempEndpoint);
        $waterTempRows = explode("\n", $water_temp_file);
        $aWaterFormattedRows = [];
        foreach($waterTempRows as $row){
            $data = explode(',', $row);
            $aWaterFormattedRows[] = $data;
        }

        return [$aWaveFormattedRows, $aWaterFormattedRows];
    }

    public function cleanWaveData($aaData)
    {
        $aaWaveData = $aaData[0];
        $aaWaterData = $aaData[1];
        $iWaterTemp = NULL;
        $aaCleanWaveData = [];
        foreach($aaWaveData as $key => $aWaveData) {
            if ($key > 4 && !empty($aWaveData[0])) {
                $aData = [
                    'dTime' => $aWaveData[0],
                    'sWaveHeight' => $aWaveData[1],
                    'sWaveDirection' => $aWaveData[2],
                    'sWavePeriod' => $aWaveData[3],
                ];
                $aaCleanWaveData[] = $aData;
            }
        }

        foreach($aaCleanWaveData as $iK => $aData){
            foreach($aaWaterData as $iKey => $aWaterData){
                if($iKey > 5 && !empty($aWaterData[0])){
                    if(!is_null($iWaterTemp)) break;
                    $iWaterTemp = $aWaterData[1];
                }
            }
        }
        $aaCleanWaveData[0]['iCurrentWaterTemp'] = $iWaterTemp;

        return $aaCleanWaveData;
    }

    public function cleanWeatherData($oWeatherData)
    {
        $aWeather = $oWeatherData->weather;
        $oMain = $oWeatherData->main;
        $oWind = $oWeatherData->wind;
        $aaCleanWeatherData = [
            'sDescription' => $aWeather[0]->description,
            'iTemp' => $oMain->temp,
            'iTempMin' => $oMain->temp_min,
            'iTempMax' => $oMain->temp_max,
            'iPressure' => $oMain->pressure,
            'iHumidity' => $oMain->humidity,
            'iWindSpeed' => $oWind->speed,
            'iWindDirection' => $oWind->deg,
            'sIconUrl' => self::$sWeatherIconUrl . $aWeather[0]->icon . '.png'
        ];

        return $aaCleanWeatherData;
    }

    public function cleanWeatherForecastData($oWeatherForecastData, $sTimezone)
    {
        $aoAllData = $oWeatherForecastData->list;
        $aaCleanWeatherForecastData = [];;
        foreach($aoAllData as $oData){
            $oMain = $oData->main;
            $aWeather = $oData->weather;
            $oWind = $oData->wind;
            $oDT = new \DateTime($oData->dt_txt);
            $oTZ = new \DateTimeZone($sTimezone);
            $oDT->setTimezone($oTZ);
            $aaCleanWeatherForecastData[] = [
                'sDescription' => $aWeather[0]->description,
                'iTemp' => $oMain->temp,
                'iTempMin' => $oMain->temp_min,
                'iTempMax' => $oMain->temp_max,
                'iPressure' => $oMain->pressure,
                'iHumidity' => $oMain->humidity,
                'iWindSpeed' => $oWind->speed,
                'iWindDirection' => $oWind->deg,
                'sIconUrl' => self::$sWeatherIconUrl . $aWeather[0]->icon . '.png',
                'sTime' => $oDT->format('Y-m-d H:i:s')
            ];
        }

        return $aaCleanWeatherForecastData;
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
