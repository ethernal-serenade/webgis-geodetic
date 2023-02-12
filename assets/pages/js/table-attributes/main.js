select_1_option("#selectLayers", "Chọn lớp dữ liệu", "services/listOfLayers.php", "layer_name")

$("#selectLayers").on("change", function () {
    $("#deleteLayer").prop("disabled", false)
    $("#containerTable").show()

    if ($.fn.DataTable.isDataTable('#tableOfLayers')) {
        $("#tableOfLayers").DataTable().clear().destroy();
        $("#tableOfLayers").empty()
    }

    let selected = $("#selectLayers").val()

    let keys_table = []
    let table = []
    $.ajax({
        type: "GET",
        url: "services/getDataFromLayer.php?option=" + selected,
        async: false,
        success: function (data) {
            keys_table = Object.keys(data[0])
            table = data
        }
    })

    /* Table Header */
    let table_header = '<thead><tr>'
    keys_table.forEach(function (key, index) {
        if (index <= 10) {
            table_header += '<th>' + key + '</th>'
        }
    })
    table_header += '</tr></thead>';
    $("#tableOfLayers").append(table_header)

    /* Table Body */
    let table_body = '<tbody>'
    table.forEach(function (record) {
        table_body += '<tr>'
        let objectValues = Object.values(record)
        objectValues.forEach(function(values, index) {
            if (index <= 10) {
                table_body += '<td class="text-wrap">' + values + '</td>'
            }
        })
        table_body += '</tr>'
    })
    table_body += '</tbody>'
    $("#tableOfLayers").append(table_body)


    // let tableOfLayers = $("#tableOfLayers").DataTable()
    let tableOfLayers = $("#tableOfLayers").DataTable({
        // scrollX: true,
        "lengthMenu": [[10, 20, 30], [10, 20, 30]],
        "pageLength": 10,
        "language": config_language_datatables,
    })

    /* Click To Link Map */
    $('#tableOfLayers tbody').on('click', 'tr', function() {
        // console.log(selected)
        // console.log(tableOfLayers.row(this).data())
        let gid = tableOfLayers.row(this).data()[0]
        window.open('index.php?layer=' + selected + '&gid=' + gid, '_blank')
    });
})

$("#confirmDelete").on("click", function () {
    let selected = $("#selectLayers").val()
    $.ajax({
        type: "GET",
        url: "services/dropLayer.php?table_layer=" + selected,
        async: false,
        success: function (data) {
            alert("Đã xoá dữ liệu")
        }
    })

    $("#deleteLayerModal").modal("hide")
    window.location.reload()
})
