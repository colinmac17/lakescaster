$(document).ready(function(){
    helpers.backToTop();
});

//Create Helpers Object
const helpers = {};

// HELPER METHODS //

/*
  Functionality for Homepage back to top button
 */
helpers.backToTop = () => {
    $('#backToTop').click(function(){
        $('html,body').animate({scrollTop: 0}, 500);
        return false;
    });
}