$(document).ready(function() {
    var panels = $('.user-infos');
    var panelsButton = $('.dropdown-user');
    panels.hide();

    //Click dropdown
    panelsButton.click(function() {
        //get data-for attribute
        var dataFor = $(this).attr('data-for');
        var idFor = $(dataFor);

        //current button
        var currentButton = $(this);
        idFor.slideToggle(400, function() {
            //Completed slidetoggle
            if(idFor.is(':visible'))
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
            }
            else
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
            }
        })
    });


    $('[data-toggle="tooltip"]').tooltip();

    $('button.btn-success').click(function(e) {
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "/apis/cart/checkout",
            dataType: "json",
            data: {}
        }).done(function( data ) {
            if(data.errorCode == 0) {
                $(location).attr('href', '/order/checkout?id='+data.data.id);
            } else {
            }
        });
        return false;
    });
});
