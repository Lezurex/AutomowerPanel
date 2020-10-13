$("input[name=modal-start-type]").on("change", function() {
    if ($("input[name=modal-start-type]:checked").val() === "time") {
        $("#modal-start-time").collapse("show");
        $("#modal-start-time-input").val(3);
        if ($("#modal-start-time-input").val() == "") {
            $("#modal-start-submit").attr("disabled", "disabled");
        } else {
            $("#modal-start-submit").removeAttr("disabled");
        }

    } else {
        $("#modal-start-time").collapse("hide");
        $("#modal-start-submit").removeAttr("disabled");
    }
});

$("#modal-start-time-input").on("keyup", function () {
    if ($("#modal-start-time-input").val() == "") {
        $("#modal-start-submit").attr("disabled", "disabled");
    } else {
        $("#modal-start-submit").removeAttr("disabled");
    }
})