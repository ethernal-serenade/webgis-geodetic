$('#confirmUpload').on('click', function() {
    $("#statusUpload").empty();
    var file = $('#fileUpload').prop("files")[0];
    var file_upload = new FormData();
    file_upload.append('file', file);
    file_upload.append('name', $('#name').val() !== '' ? $('#name').val() : null)
    file_upload.append('srid', $('#srid').val() !== '' ? $('#srid').val() : null)

    $.ajax({
        type: "POST",
        url: apiURL + "upload",
        data: file_upload,
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        timeout: 600000,
        success: function (data) {
            if (data.status == 200) {
                $("#statusUpload").append('<span class="font-size-15 text-bold text-success">Upload Thành công</span>')
            } else {
                $("#statusUpload").append('<span class="font-size-15 text-bold text-danger">Upload Thất bại</span>')
            }
            console.log(data.message);
        },
        error: function (e) {
            console.log("ERROR: ", e);
            $("#statusUpload").append('<span class="font-size-15 text-bold text-danger">Upload Thất bại</span>')
        }
    });

    setTimeout(function() {
        $("#statusUpload").empty();
    }, 3000)
})