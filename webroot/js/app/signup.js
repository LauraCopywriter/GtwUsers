/*
    Gintonic Web
    Author:    Philippe Lafrance
    Link:      http://gintonicweb.com

*/
define(function(require) {

    require('../../GtwUi/js/common');
    require('jquery');
    
    $('#signup-submit').click(function(){
        $.ajax({
            type: "POST",
            url: "/gtw_users/users/signup",
            data: { 
                first: $('#signup-first').val(),
                last: $('#signup-last').val(),
                email: $('#signup-email').val(),
                password: $('#signup-password').val()
            }
        }).done(function ( data ) {
            console.log(data);
        });
    });
   
});