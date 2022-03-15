
$(".qty").change(function() {
    let qty = $(this).val();
    let _token = $('input[name="_token"]').val();
    let url_update = $(this).data("url");
    let id = $(this).data("id");

    $.ajax({
        url: url_update,
        type: "POST",
        data: {
            quantity: qty,
            id: id,
            _token: _token
        }
    }).done(function(response) {
        let subtotal = numberWithCommas(response.subTotal) + " đ";
        let total = numberWithCommas(response.total) + " đ";
        $("#header_cart").html(response.data);
        $("span.subtotal-" + id).html(subtotal);
        $("span.total").html(total);  
    });
   
});

function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
}

$(".add-cart").click(function() {
    let id = $(this).attr("id");
    let _token = $('input[name="_token"]').val();
    let url_addcart = $(this).data("url_addcart");
    $.ajax({
        url: url_addcart,
        type: "POST",
        data: {
            id: id,
            _token: _token
        }
    }).done(function(response) {
        if (response.status == "success") {
            $("#header_cart").html(response.data);
            swal(response.status, response.message, "success");
        } else if (response.status == "error") {
            swal(response.status, response.message, "error");
        } else {
            swal(response.message, {
                buttons: {
                    cancel: "Không mua nữa :)",
                    catch: {
                        text: "Đăng nhập",
                        value: "catch"
                    }
                }
            }).then(value => {
                switch (value) {
                    case "catch":
                        window.location = "/login";
                        break;
                    default:
                        swal("Hoàn tác thành công");
                }
            });
        }
    });
});

$(".remove-cart").click(function() {
    let id = $(this).attr("id");
    let _token = $('input[name="_token"]').val();
    let url_delete = $(this).data("url_delete");
    var i =this.parentNode.parentNode.rowIndex;
    
            swal({
                title: "Bạn có chắc chắn muốn xóa không?",
                text: "Xóa sản phẩm khỏi giỏ hàng",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url_delete,
                        type: "POST",
                        data: {
                            id: id,
                            _token: _token
                        }
                    }).done(function(response) {                    
                        if (response.status == "success") {
                            let total = numberWithCommas(response.total) + " đ";
                            if(response.total == 0){
                                $("a.checkout").addClass("disabled");
                            }
                            $("#header_cart").html(response.data);
                            $("span.total").html(total);
                            swal(response.status, response.message, "success");                           
                            $('#item-' + id).remove();
                            swal("Xóa thành công !!!", {
                                icon: "success",
                            });
                        } else {
                            swal("Bỏ xóa sản phẩm !");
                        }
                    });
        } 
    });
});
function checkout(item) {
    if (item == 0) {
        swal("Bạn chưa có sản phẩm nào trong giỏ hàng?", {
            buttons: ["Hiểu!", "Hủy bỏ!"]
        });
    } else {
        window.location = "/checkout";
    }
}


