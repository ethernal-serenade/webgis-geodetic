// Khởi tạo DataTables
var table = $('#iframe-table').DataTable({
    ajax: {
        url: 'services/iframe-crud/read.php',
        dataSrc: ''
    },
    columns: [
        {data: 'id'},
        {data: 'iframe_url'},
        {data: 'name_iframe'},
        {
            data: 'id',
            render: function (data) {
                return '<button class="btn btn-warning" onclick="editIframe(' + data + ')">Sửa</button>' +
                    '<button class="btn btn-danger" onclick="deleteIframe(' + data + ')">Xóa</button>';
            }
        }
    ]
});

// Gửi yêu cầu thêm iframe layer
$('#create-form').submit(function (event) {
    event.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
        type: 'POST',
        url: 'services/iframe-crud/create.php',
        data: formData,
        success: function (response) {
            alert(response);
            // table.ajax.reload();
            location.reload()
            $('#create-form')[0].reset();
        }
    });
});

// Hàm sửa iframe layer
function editIframe(id) {
    var iframeUrl = prompt('Nhập URL mới:');
    var nameIframe = prompt('Nhập tên iframe mới:');

    if (iframeUrl && nameIframe) {
        var formData = {
            id: id,
            iframe_url: iframeUrl,
            name_iframe: nameIframe
        };

        $.ajax({
            type: 'POST',
            url: 'services/iframe-crud/update.php',
            data: formData,
            success: function (response) {
                alert(response);
                table.ajax.reload();
            }
        });
    }
}

// Hàm xóa iframe layer
function deleteIframe(id) {
    if (confirm('Bạn có chắc muốn xóa iframe layer này?')) {
        var formData = {
            id: id
        };

        $.ajax({
            type: 'POST',
            url: 'services/iframe-crud/delete.php',
            data: formData,
            success: function (response) {
                alert(response);
                location.reload()
                // table.ajax.reload();
            }
        });
    }
}