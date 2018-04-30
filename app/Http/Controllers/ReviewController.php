<?php

namespace App\Http\Controllers;

use App\Review;
use App\User;
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
        switch($request->action){
            case 'post':
                $oReview = new Review;
                $oReview->spotId = $iId;
                $oReview->userId = Auth::user()->id;
                $oReview->rating = $request->rating;
                $oReview->review = $review;

                $oReview->save();
                break;

            case 'edit':
                $oReview = Review::find($request->reviewId);
                $oReview->rating = $request->rating;
                $oReview->review = $review;

                $oReview->save();
                break;

            case 'delete':
                $oReview = Review::find($request->reviewId);
                $oReview->status = -1;
                $oReview->save();
                break;
        }

    }

    public static function getReviewsBySpot($iSpotId)
    {
        $aaReviews = [];
        $aoReviews = Review::where(['spotId' => $iSpotId, 'status' => 1])->orderBy('created_at', 'desc')->get();
        if(count($aoReviews) > 0) {
            foreach ($aoReviews as $oReview) {
                $oUser = \App\User::where('id', $oReview->userId)->first();
                $aaReviews[] = [
                    'id' => $oReview->id,
                    'reviewer' => $oUser->name,
                    'userId' => $oUser->id,
                    'rating' => $oReview->rating,
                    'review' => $oReview->review,
                    'reviewed_at' => date('m/d/Y', strtotime($oReview->created_at))
                ];
            }
        }
        return json_encode($aaReviews);
    }
}
