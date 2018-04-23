@extends('layouts.home')

@section('content')
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                    <img class="first-slide" src="https://res.cloudinary.com/soccerresume/image/upload/v1520714355/lakescaster/shlomo-shalev-576225-unsplash.jpg" alt="First slide">
                <div class="container">
                    <div class="carousel-caption text-center">
                        <h1 class="text-light font-weight-bold">Great Lake Surfing Forecasts</h1>
                        <p class="text-light font-weight-bold">Surfing on the lakes is much different than surfing in an ocean. The Lakescaster platform aims to simplify wave forecasting on the lakes to give you the optimal experience planning your sessions.</p>
                        <p><button class="btn btn-lg btn-primary learn-more-btn">Learn More</button></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="second-slide" src="https://res.cloudinary.com/soccerresume/image/upload/v1520716173/lakescaster/austin-schmid-29637-unsplash.jpg" alt="Second slide">
                <div class="container">
                    <div class="carousel-caption text-center">
                        <h1 class="text-light font-weight-bold">Help Your Surf Community</h1>
                        <p class="text-light font-weight-bold">Rate local surf spots and provide live feedback on current surfing conditions, allowing for a live look at current conditions.</p>
                        <p><button class="btn btn-lg btn-primary learn-more-btn">Learn more</button></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="third-slide" src="https://res.cloudinary.com/soccerresume/image/upload/v1520714517/lakescaster/sam-wheeler-37727-unsplash.jpg" alt="Third slide">
                <div class="container">
                    <div class="carousel-caption text-center">
                        <h1 class="text-light font-weight-bold">Join The Movement</h1>
                        <p class="text-light font-weight-bold">There is a strong and growing Great Lake's surfing community throughout the midwest. Encourage friends to surf and paddle out at your local beach.</p>
                        <p><button class="btn btn-lg btn-primary learn-more-btn">Learn More</button></p>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>


    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div id="marketing" class="container marketing">
        <div id="mobileLoginRegister">
            <h3 class="text-center">Join The Movement</h3>
            @guest
                <p class="text-center">
            <a class="btn btn-success" href="{{url('/register')}}">Register</a>
                </p>
                <p class="text-center"><span>Already have an account?<a class="btn btn-link" href="{{url('/login')}}">Login</a></span></p>
            @else
            <p class="text-center"><button class="btn btn-success" href="{{url('/dashboard')}}">My Profile</button></p>
            @endguest
        </div>
        <h1 class="text-center p-5 font-weight-bold">How It Works</h1>
        <!-- Three columns of text below the carousel -->
        <div class="row">
            <div class="col-lg-4">
                <img class="rounded-circle mb-3" src="https://res.cloudinary.com/soccerresume/image/upload/v1520741542/lakescaster/Screen_Shot_2018-03-10_at_10.11.59_PM.png" alt="Generic placeholder image" width="140" height="140">
                <h2><span class="badge badge-success">Check The Forecast</span></h2>
                <p>Select a spot and check out current conditions and a five-day forecast.</p>
                <p><a id="forecastingBtn" class="btn btn-secondary how-it-works-btn" href="#" role="button">Learn More</a></p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <img class="rounded-circle mb-3" src="https://res.cloudinary.com/soccerresume/image/upload/v1520741716/lakescaster/Screen_Shot_2018-03-10_at_10.14.54_PM.png" alt="Generic placeholder image" width="140" height="140">
                <h2><span class="badge badge-success">Provide Feedback</span></h2>
                <p>Rate surf spots, update users on live conditions, and more.</p>
                <p><a id="feedbackBtn" class="btn btn-secondary how-it-works-btn" href="#" role="button">Learn More</a></p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <img class="rounded-circle mb-3" src="https://res.cloudinary.com/soccerresume/image/upload/v1520741848/lakescaster/Screen_Shot_2018-03-10_at_10.17.06_PM.png" alt="Generic placeholder image" width="140" height="140">
                <h2><span class="badge badge-success">Get Involved</span></h2>
                <p>Submit pull requests, provide feedback, go surfing, repeat.</p>
                <p><a id="communityBtn" class="btn btn-secondary how-it-works-btn" href="#" role="button">Learn More</a></p>
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->

        <p class="text-center mt-5 mb-5">Are you a software developer interested in contributing to this project? <a class="btn btn-link" href="{{url('/developers')}}">Learn more</a></p>


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">
        <h1 class="text-center p-5 font-weight-bold">Features</h1>
        <div class="row featurette">
            <div class="col-md-7" id="forecastFeature">
                <h2 class="featurette-heading">Raw Surf Forecasting. <span class="text-muted">Check your local spot.</span></h2>
                <p class="lead">Our platform utilize buoy data from the Great Lakes Coastal Forecasting System to predict wave height, wave direction, wave period, wind velocity and wind direction.</p>
                <p class="text-center"><a href="{{Auth::guest() ? url('/register') : url('/spots')}}" role="button" class="btn btn-primary btn-lg">{{Auth::guest() ? 'Sign Up' : 'Check The Surf' }}</a></p>
            </div>
            <div class="col-md-5">
                <img class="featurette-image img-fluid mx-auto" src="https://res.cloudinary.com/soccerresume/image/upload/v1520744105/lakescaster/hayden-hunt-269455-unsplash.jpg" alt="Surfer Walking On Beach">
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
            <div class="col-md-7 order-md-2" id="feedbackFeature">
                <h2 class="featurette-heading">Provide User Feedback. <span class="text-muted">Create a better experience.</span></h2>
                <p class="lead">By rating spots and posting live updates on current conditions, you help Great Lake's surfers make the most informed decision on whether they should paddle out. You also help us improve our platform. Yewww!</p>
                <p class="text-center"><a href="{{Auth::guest() ? url('/register') : url('/spots')}}" role="button" class="btn btn-primary btn-lg">{{Auth::guest() ? 'Sign Up' : 'Provide Feedback' }}</a></p>
            </div>
            <div class="col-md-5 order-md-1">
                <img class="featurette-image img-fluid mx-auto" src="https://res.cloudinary.com/soccerresume/image/upload/v1520744374/lakescaster/sebastian-leon-prado-562482-unsplash.jpg" alt="Stoke Sign">
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
            <div class="col-md-7" id="communityFeature">
                <h2 class="featurette-heading">Jump On In. <span class="text-muted">Join the Surf Community.</span></h2>
                <p class="lead">With plenty of beaches and breaks spread accross the five Great Lakes, the Surfing Community on the Greats continues to grow. From Chicago to Toronto, you can find surfers paddling out all year round.</p>
                <p class="text-center"><a href="{{Auth::guest() ? url('/register') : url('/spots')}}" role="button" class="btn btn-primary btn-lg">{{Auth::guest() ? 'Sign Up' : 'Get Involved' }}</a></p>
            </div>
            <div class="col-md-5">
                <img class="featurette-image img-fluid mx-auto" src="https://res.cloudinary.com/soccerresume/image/upload/v1520744354/lakescaster/julie-macey-275889-unsplash.jpg" alt="Surfer Jumping">
            </div>
        </div>

        <hr class="featurette-divider">

        <!-- /END THE FEATURETTES -->

    </div><!-- /.container -->


@endsection
