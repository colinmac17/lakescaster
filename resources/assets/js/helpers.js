$(document).ready(function(){
    helpers.backToTop();
    helpers.ScrollTo('#marketing', '.learn-more-btn');
    helpers.ScrollTo('#feedbackFeature', '#feedbackBtn');
    helpers.ScrollTo('#communityFeature', '#communityBtn');
    helpers.ScrollTo('#forecastFeature', '#forecastingBtn');
    helpers.closeFlashMessage();
    helpers.handleAccountDeletion();
    helpers.toggleEmailRegistrationForm();
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

helpers.closeFlashMessage = () => {
    $('#close-flash').on('click', function(e){
        e.preventDefault();
        $('#flash-message').remove();
    });
}

helpers.handleAccountDeletion = () => {
    $('#delete-account').click((e) => {
        e.preventDefault();
        if(confirm('Are you sure you want to delete your account? All of your data will be lost.')){
            $('#delete-form').submit();
        } else return false;
    });
}

helpers.toggleEmailRegistrationForm = () => {
    $('#registerEmailBtn').click(e => {
       e.preventDefault();
       $('.google-button').hide();
       $('.facebook-button').hide();
       $('.email-form-field').fadeIn(500);
    });
}
