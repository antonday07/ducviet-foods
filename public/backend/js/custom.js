
// Function Delete with confirmation
function deleteConfirmation(e) {
    var url = $(this).data("url");
    console.log(url);
   swal.fire({
        title: "Delete?",
        icon: 'warning',
        text: "Bạn có chắc chắc muốn xóa không!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Có, xóa liền",
        cancelButtonText: "Khum",
        reverseButtons: !0
   }).then( function(e) {
        if(e.value === true) {
            var csrf_token =  $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: csrf_token
                },
                success: function(results) {
                    if(results.success === true) {
                        swal.fire("Xóa thành công", results.message, "success");
                        setTimeout(function(){
                            location.reload();
                        },1000);
                    } else {
                        swal.fire("Có lỗi xảy ra!", results.message, "error");
                    }
                }
            });
        } else {
            e.dismiss
        }
   }, function(dismiss) {
       return false;
   })
}
