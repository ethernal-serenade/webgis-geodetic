/*--- API URL---*/
var apiURL = 'http://localhost:5000/'
// var apiURL = 'https://kong2_sinhthainambo.girs.vn/geodetic-upload/'
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