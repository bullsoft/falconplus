$(function(){
    if($("#market-type-bar").length>0){
        $("#market-type-bar").children("li").click(function(){
            $(this).addClass("active").siblings("li").removeClass("active");
            var index = $(this).index();
            $(".tab-pane").hide();
            $(".tab-pane").eq(index).show();
        })
    }
    if($("#loginAccountTabs").length>0){
        $("#loginAccountTabs").children("li").click(function(){
            $(this).addClass("active").siblings("li").removeClass("active");
            var index = $(this).index();
           if(index == 0){
               $(".third-party-login-platform").show();
           }else{
               $(".third-party-login-platform").hide();
           }
        })
    }
    if($("#createAccountTabs").length>0){
        $("#createAccountTabs").children("li").click(function(){
            $(this).addClass("active").siblings("li").removeClass("active");
            var index = $(this).index();
           var index = $(this).index();
            $(".tab-pane").hide();
            $(".tab-pane").eq(index).show();
        })
    }
})

