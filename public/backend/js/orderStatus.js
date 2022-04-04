$("select#order-status").change(function() {
    let id = $(this).data("id");
    let status = $(this).val();
    let type = $(this).data("type");
    let url = $(this).data("url");

    
    $.ajax({
        url: url,
        type: "POST",
        data: {
            id: id,
            status: status,
            type: type,
            _token: $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(data) {
        if (data == "success") {
            swal.fire("Thành công!", "Cập nhật trạng thái thành công!", "success");
            window.location.reload();
        } else {
            swal.fire("Thất bại!", "Cập nhật thất bại!", "error");
            window.location.reload();
        }
    });
});
$("select#order-status-payment").change(function() {
    let id = $(this).data("id");
    let status = $(this).val();
    let type = $(this).data("type");
    let url = $(this).data("url");

    
    $.ajax({
        url: url,
        type: "POST",
        data: {
            id: id,
            status: status,
            type: type,
            _token: $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(data) {
        if (data == "success") {
            swal.fire("Thành công!", "Cập nhật trạng thái thành công!", "success");
            window.location.reload();
        } else {
            swal.fire("Thất bại!", "Cập nhật thất bại!", "error");
            window.location.reload();
        }
    });
});



$("button#cancelOrder").click(function() {
    let id = $(this).data("id");
    let status = $(this).data("status");
    let type = 'status';
    let url = $(this).data("url");
  
    swal.fire({
        title: "Xác nhận hủy đơn?",
        text: "Nếu hủy, bạn sẽ không thể hoàn tác",
        icon: "warning",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Hủy đơn",
        cancelButtonText: "Khum",        
    }).then(willDelete => {
        console.log(willDelete);
        if (willDelete.value == true) {
            // swal("Hủy đơn hàng thành công", {
            //     icon: "success"
            // });
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    id: id,
                    status: status,
                    type: type,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(data) {           
                if (data.status == "success") {
                    swal.fire("Thành công!", "Hủy đơn thành công!", "success");
                    window.location.reload();
                } else {
                    swal.fire("Thất bại!", "Hủy đơn thất bại!", "error");
                    window.location.reload();
                }              
            });
        } else {
            willDelete.dismiss
        }
    });
});

$("button#confirmOrder").click(function() {
    let id = $(this).data("id");
    let status = $(this).data("status");
    let type = 'status';
    let url = $(this).data("url");
  
    swal.fire({
        title: "Xác nhận đơn hàng?",
        text: "Xác nhận đơn hàng mới",
        icon: "info",
        type: "info",
        showCancelButton: !0,
        confirmButtonText: "Xác nhận",
        cancelButtonText: "Hủy",        
    }).then(willDelete => {
        console.log(willDelete);
        if (willDelete.value == true) {           
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    id: id,
                    status: status,
                    type: type,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(data) {           
                if (data.status == "success") {
                    swal.fire("Thành công!", "Xác nhận thành công!", "success");
                    window.location.reload();
                } else {
                    swal.fire("Thất bại!", data.message, "error");
                    window.location.reload();
                }              
            });
        } else {
            willDelete.dismiss
        }
    });
});
