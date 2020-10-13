$().ready(function () {
    updateStatus();

    let interval = setInterval(function () {updateStatus();}, 5000);
})

function updateStatus() {
    $.ajax({
        url: "https://" + window.location.hostname + "/php/getStatus.php",
        method: "POST",
        data: {
            "mowerID": $("#mower-select").val()
        },
        success: function (data) {
            $("#status-body").html(data);
        },
        error: function () {
            $("#status-body").html('<div class="card bg-danger text-white mb-4">\n' +
                '                                    <div class="card-body">Der Status konnte nicht abgefragt werden.</div>\n' +
                '                                </div>')
        }
    })
}