$("input[name=modal-park-type]").on("change", function() {
    if ($("input[name=modal-park-type]:checked").val() === "time") {
        $("#modal-park-time").collapse("show");
        $("#modal-park-time-input").val(3);
        if ($("#modal-park-time-input").val() == "") {
            $("#modal-park-submit").attr("disabled", "disabled");
        } else {
            if (!Park.loading)
                $("#modal-park-submit").removeAttr("disabled");
        }

    } else {
        $("#modal-park-time").collapse("hide");
        if (!Park.loading)
            $("#modal-park-submit").removeAttr("disabled");
    }
});

$("#modal-park-time-input").on("keyup", function () {
    if ($("#modal-park-time-input").val() == "") {
        $("#modal-park-submit").attr("disabled", "disabled");
    } else {
        if (!Park.loading)
            $("#modal-park-submit").removeAttr("disabled");
    }
});

$("#modal-park-submit").on("click", function () {
    Park.query();
    Park.startLoadingAnimation();
});

class Park {

    static loading = false;

    static startLoadingAnimation() {
        this.loading = true;
        $("#modal-park-close").attr("disabled", "disabled");
        $("#modal-park-submit").attr("disabled", "disabled");
        $("#modal-park-submit").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>\n" +
            "  Wird ausgeführt...");
        $("#modal-park-closex").attr("disabled", "disabled");
    }

    static stopLoadingAnimation() {
        this.loading = false;
        $("#modal-park-close").removeAttr("disabled");
        $("#modal-park-closex").removeAttr("disabled");
        $("#modal-park-submit").removeAttr("disabled");
        $("#modal-park-submit").html("Parken");
        $("#modal-park").modal("hide");
    }

    static query() {
        let mode = $("input[name=modal-park-type]:checked").val();
        let data;
        let doQuery = false;
        if (mode === "time") {
            doQuery = true;
            let minutes = $("#modal-park-time-input").val() * 60;
            data = {
                "type": mode,
                "duration": minutes,
                "mowerID": $("#mower-select").val()
            };
        } else if (mode === "plan") {
            doQuery = true;
            data = {
                "type": mode,
                "mowerID": $("#mower-select").val()
            };
        } else if (mode === "ufn") {
            doQuery = true;
            data = {
                "type": mode,
                "mowerID": $("#mower-select").val()
            }
        }

        if (doQuery) {
            $.ajax({
                url: "https://" + window.location.hostname + "/php/park.php",
                method: "POST",
                data: data,
                success: function (data, textStatus, xhr) {
                    Alert.showSuccess();
                    Park.stopLoadingAnimation();
                },

                error: function (xhr) {
                    Alert.showError(xhr.responseText);
                    Park.stopLoadingAnimation();
                }
            })
        }
    }
}