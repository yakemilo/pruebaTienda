$(document).ready(function(){
    $('.btn-delete').click(function(e){
        e.preventDefault();

        var row = $(this).parents('tr');
        var id = row.data('id');
        var form = $('#form-delete');
        var url = form.attr('action').replace(':ALMACEN_ID', id);

        var data = form.serialize();

        bootbox.confirm(message, function(res){
            if (res  == true) {
                $.post(url, data, function(result){
                    if(result.removed == 1){
                        row.fadeOut();
                        $('#message').removeClass('hidden');

                        $('#user-message').text(result.message);
                    }
                    else{
                        $('#message-danger').removeClass('hidden');
                        
                        $('#user-message-danger').text(result.message);
                    }
                }).fail(function(){
                    alert('ERROR');
                    row.show();
                });
            }
        });
    });
});