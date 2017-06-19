jQuery(document).ready(function() {

    /*
     Fullscreen background
     */
    $.backstretch("/tpls/shopbigbang/images/backgrounds/1.jpg");

    $('#login-form-link').click(function(e) {
        $("#login-form").delay(100).fadeIn(100);
        $("#register-form").fadeOut(100);
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });
    $('#register-form-link').click(function(e) {
        $("#register-form").delay(100).fadeIn(100);
        $("#login-form").fadeOut(100);
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
    });


    /*
     Form validation
     */
    $('#login-form input[type="text"], #login-form input[type="password"]').on('focus', function() {
        $(this).removeClass('input-error');
    });

    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        $(this).find('input[type="text"], input[type="password"]').each(function(){
            if( $(this).val() == "" ) {
                $(this).addClass('input-error');
            }
            else {
                $(this).removeClass('input-error');
                $.ajax({
                    method: "POST",
                    url: "/user/do-login",
                    dataType: "json",
                    data: { mobile: $("#login-mobile").val(), password: $("#login-password").val() }
                })
                .done(function( data ) {
                    if(data.errorCode == 0) {
                        $(location).attr('href', '/');
                    } else {
                        $.each(data.data, function(key, val) {
                           $("#login-" + key).attr("placeHolder", val);
                        });
                        alert(data.errorMsg);
                    }
                });
                return false;
            }
        });



    });


});
