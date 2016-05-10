jQuery(document).ready(function() {
    $('.invest-form').on('submit', function(e) {
        var q = $(this).find(".quantity:first").val();
        var skuId = $(this).find(".investSkuId:first").val();
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: "/apis/cart/set-item",
            dataType: "json",
            data: {qty: q, skuId: skuId}
        })
            .done(function( data ) {
                if(data.errorCode == 0) {
                    $(location).attr('href', '/cart/index');
                } else {
                }
            });
        return false;
    });
});
