function addItem(id) {
    $.ajax({
            type: "POST",
            url: "/shop/cart/add",
            data: {
                "id": id
            }
        })
        .done(function (data) {
            console.log(data);
            if (data.status != 'OK') {
                return;
            }
            updateAllData(id);
        });
}

function updateAllData(id) {
    $.ajax({
            type: "POST",
            url: "/shop/cart/update"
        })
        .done(function (data) {
            if (data.status != 'OK') {
                return;
            }
            if ($('.price_' + id)) {
                $('.price_' + id).html(data['products'][id]['price']);
            }
            if ($('.quantity_' + id)) {
                $('.quantity_' + id).html(data['products'][id]['quantity']);
            }
            if ($('.total_price')) {
                $('.total_price').html(data['total']['price']);
            }
            if ($('.total_items')) {
                $('.total_items').html(data['total']['items']);
            }
        });
}