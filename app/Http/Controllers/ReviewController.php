<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    protected $fillable = ['spotId', 'userId', 'rating', 'review'];

    public function submitReview($sLake, $sSpotName, $iId, Request $request)
    {
        if(empty($request->review)){
            $review = NULL;
        } else {
            $review = $request->review;
        }

        $oReview = new Review;
        $oReview->spotId = $iId;
        $oReview->userId = Auth::user()->id;
        $oReview->rating = $request->rating;
        $oReview->review = $review;

        $oReview->save();

    }

    public static function getReviewsBySpot($iSpotId)
    {
        return Review::where('spotId', $iSpotId)->get();
    }
}
