$(document).ready(function(){
    helpers.backToTop();
    helpers.ScrollTo('#marketing', '.learn-more-btn');
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

/*
  Functionality to animate scroll to desired div with desired trigger
 */
helpers.ScrollTo = (el, btn) => {
    $(btn).click(function(){
        $('body, html').animate({
            scrollTop: $(el).position().top - 100
        }, 500);
    });
}