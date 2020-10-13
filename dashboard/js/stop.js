$("#btn-stop").on("click", function () {
    Stop.startLoadingAnimation();
    Stop.query();
})

class Stop {

    static query() {
        $.ajax({
            url: "https://" + window.location.hostname + "/php/stop.php",
            method: "POST",
            data: {
                "mowerID": $("#mower-select").val()
            },
            success: function (data, textStatus, xhr) {
                Alert.showSuccess();
                Stop.stopLoadingAnimation();
            },

            error: function (xhr) {
                Alert.showError(xhr.responseText);
                Stop.stopLoadingAnimation();
            }
        })
    }

    static startLoadingAnimation() {
        $("#btn-stop").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>\n" +
            "  Wird ausgeführt...").attr("disabled", "disabled");
    }

    static stopLoadingAnimation() {
        $("#btn-stop").html("Stoppen").removeAttr("disabled");
    }

}