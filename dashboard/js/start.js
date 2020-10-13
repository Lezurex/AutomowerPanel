$("input[name=modal-start-type]").on("change", function() {
    if ($("input[name=modal-start-type]:checked").val() === "time") {
        $("#modal-start-time").collapse("show");
        $("#modal-start-time-input").val(3);
        if ($("#modal-start-time-input").val() == "") {
            $("#modal-start-submit").attr("disabled", "disabled");
        } else {
            if (!Start.loading)
                $("#modal-start-submit").removeAttr("disabled");
        }

    } else {
        $("#modal-start-time").collapse("hide");
        if (!Start.loading)
            $("#modal-start-submit").removeAttr("disabled");
    }
});

$("#modal-start-time-input").on("keyup", function () {
    if ($("#modal-start-time-input").val() == "") {
        $("#modal-start-submit").attr("disabled", "disabled");
    } else {
        if (!Start.loading)
            $("#modal-start-submit").removeAttr("disabled");
    }
});

$("#modal-start-submit").on("click", function () {
    Start.query();
    Start.startLoadingAnimation();
});

class Start {

    static loading = false;

    static startLoadingAnimation() {
        this.loading = true;
        $("#modal-start-close").attr("disabled", "disabled");
        $("#modal-start-submit").attr("disabled", "disabled");
        $("#modal-start-submit").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>\n" +
            "  Wird ausgeführt...");
        $("#modal-start-closex").attr("disabled", "disabled");
    }

    static stopLoadingAnimation() {
        this.loading = false;
        $("#modal-start-close").removeAttr("disabled");
        $("#modal-start-closex").removeAttr("disabled");
        $("#modal-start-submit").removeAttr("disabled");
        $("#modal-start-submit").html("Starten");
        $("#modal-start").modal("hide");
    }

    static query() {
        let mode = $("input[name=modal-start-type]:checked").val(); // can be "time" or "main"
        let data;
        let doQuery = false;
        if (mode === "time") {
            doQuery = true;
            let minutes = $("#modal-start-time-input").val() * 60;
            data = {
                "type": mode,
                "duration": minutes,
                "mowerID": $("#mower-select").val()
            };
        } else if (mode === "main") {
            doQuery = true;
            data = {
                "type": mode,
                "mowerID": $("#mower-select").val()
            };
        }

        if (doQuery) {
            $.ajax({
                url: "https://" + window.location.hostname + "/php/start.php",
                method: "POST",
                data: data,
                success: function (data, textStatus, xhr) {
                    Alert.showSuccess();
                    Start.stopLoadingAnimation();
                },

                error: function (xhr) {
                    Alert.showError(xhr.responseText);
                    Start.stopLoadingAnimation();
                }
            })
        }
    }
}