<?php

namespace Tests\Feature;

use App\Http\Controllers\SpotController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoutingTest extends TestCase
{
    /**
     * Asserts that home page renders correctly.
     *
     * @return void
     */
    public function testHomePageRenders()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Asserts that Developers page renders correctly.
     *
     * @return void
     */
    public function testDevPageRenders()
    {
        $response = $this->get('/developers');

        $response->assertStatus(200);
    }

    /**
     * Asserts that login page renders correctly.
     *
     * @return void
     */
    public function testLoginPageRenders()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Asserts that register page renders correctly.
     *
     * @return void
     */
    public function testRegisterPageRenders()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * Asserts that each spot page renders correctly.
     *
     * @return void
     */
    public function testSpotPagesRender()
    {
        $aaSpots = SpotController::$aaSpotsByLatandLon;

        foreach($aaSpots as $aSpot){
            $response = $this->get('/spots/' . $aSpot['lake'] . '/' . $aSpot['short'] . '/' . $aSpot['id']);
            $response->assertStatus(200);
        }
    }
}
