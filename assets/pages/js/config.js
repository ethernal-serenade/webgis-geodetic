/*--- API URL---*/
// var apiURL = 'http://localhost:5000/'
var apiURL = 'http://210.245.96.134:5000/'
var config_language_datatables = {
    pagingType: "full_numbers",
    search: '<span>Tìm kiếm:</span> _INPUT_',
    searchPlaceholder: "Nhập tại đây ...",
    paginate: {
        'first': 'First',
        'last': 'Last',
        'next': $('html').attr('dir') == 'rtl' ? '<span style="font-size:13px;">Trước</span>' : '<span style="font-size:13px;">Sau</span>',
        'previous': $('html').attr('dir') == 'rtl' ? '<span style="font-size:13px;">Sau</span>' : '<span style="font-size:13px;">Trước</span>'
    },
    sLengthMenu: "<span>Hiển thị&nbsp;</span> _MENU_<span> kết quả</span>",
    sZeroRecords: "<span class='text-danger' style='font-weight: bold'>Không tìm thấy kết quả</span>",
    sInfo: "Hiển thị _START_ đến _END_ trên _TOTAL_ dòng",
    sInfoFiltered: "(tất cả _MAX_ dòng)",
    sInfoEmpty: "Hiển thị 0 đến _END_ trên _TOTAL_ dòng",
};

/*--- General Function ---*/
function select_1_option(id, placeholder, url, opt) {
    $(id).empty()
    $.getJSON(url, function (data) {
        $(id).append($("<option selected disabled></option>").attr('value', '').text(placeholder));
        $.each(data, function (key, value) {
            $(id).append($("<option></option>").attr('value', value[opt]).text(value[opt]));
        });
    })
}
$('body').on('click', 'li.nav-item a', async function (event) {
    var href = $(this).attr('href');

    if (href.startsWith("#iframe_")) {
        var iframeId = href.replace("#iframe_", "");

        if (window.location.href.indexOf("index.php") === -1) {
            event.preventDefault();
            /*window.location.href = "index.php";*/
            window.location.replace("index.php#iframe_" + iframeId)
        }

        setTimeout(function() {
            checkAndReloadPageIframe()
        }, 250);
    }
});

function checkAndReloadPageIframe() {
    var url = window.location.href;
    var splitUrl = url.split("#iframe_")[1]

    $.ajax({
        url: 'services/iframe-crud/read.php?id=' + splitUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            response.forEach(data => {
                if (data.id === splitUrl) {
                    var iframeHtml = '<iframe src="' + data.iframe_url + '" title="" ' +
                        'style="overflow:hidden; height:calc(100vh - 71px); ' +
                        'width:100%" height="100%" width="100%"></iframe>';
                    $('#map').html(iframeHtml);
                }
            })
        },
        error: function () {
            console.log('Error occurred while fetching iframe URL.');
        }
    });
}

checkAndReloadPageIframe()
