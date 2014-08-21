define(['jquery', 'basepath'], function ($, basepath) {
    
    return function(id, path){
        $.ajax({
            type: "POST",
            url: basepath + "gtw_users/users/update_avatar",
            data: { 
                id: $('#user-id').val(),
                file_id: id,
            },
            success: function(response, status) {
                $('#contact-alert').html(
                    '<div class="alert alert-dismissable alert-success">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
                        'success'+
                    '</div>'
                );
                if (!response.success){
                    $('#contact-alert').html(
                        '<div class="alert alert-dismissable alert-danger">'+
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
                            '<strong>Error:</strong> unable to send message.'+
                        '</div>'
                    );
                }
            },
            error: function(response, status) {
                $('#contact-alert').html(
                    '<div class="alert alert-dismissable alert-danger">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
                        '<strong>Error:</strong> unable to send message'+
                    '</div>'
                );
            }
        });
    };
   
});
