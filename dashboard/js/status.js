let statusRefresh;

$().ready(function () {
    updateStatus();
    statusRefresh = $("#status-refresh");

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
            $("#status-refresh").click(function (e) {
                $("#status-body").html("<div class=\"card bg-secondary text-white mb-4\">\n" +
                    "                            <div class=\"card-body\">Status wird abgefragt...</div>\n" +
                    "                        </div>");
                updateStatus();
            })
        },
        error: function (xhr) {
            let reason = "Der Status konnte nicht abgefragt werden."
            if (xhr.status === 429) {
                reason = "Der Status konnte wegen zu vielen Anfragen nicht abgefragt werden. Versuche es in ein paar Sekunden nochmals."
            }
            $("#status-body").html('<div class="card bg-danger text-white mb-4">\n' +
                '                                    <div class="card-body"><button id="status-refresh" class="btn btn-success"><i class="fas fa-sync-alt"></i></button>' + reason + '</div>\n' +
                '                                </div>')
            $("#status-refresh").click(function (e) {
                $("#status-body").html("<div class=\"card bg-secondary text-white mb-4\">\n" +
                    "                            <div class=\"card-body\">Status wird abgefragt...</div>\n" +
                    "                        </div>");
                updateStatus();
            })
        }
    });
}