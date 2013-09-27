/*
    Gintonic Web
    Author:    Philippe Lafrance
    Link:      http://gintonicweb.com
*/
define(function(require) {

    require('../../GtwUi/js/common');
    require('jquery');
    
    $('#signin-submit').click(function(){
        $.ajax({
            type: "POST",
            url: "/gtw_users/users/signinAjax",
            data: { 
                email: $('#signin-email').val(),
                password: $('#signin-password').val(),
                rememberme: $('#signin-rememberme').val(),
            }
        }).done(function ( data ) {
            location.reload();
        });
    });
   
});