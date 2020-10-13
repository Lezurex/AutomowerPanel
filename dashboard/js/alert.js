class Alert {

    static showError(message) {
        $("#alert-error").html('<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 24px;">\n' +
            '                        <strong>Befehl fehlgeschlagen!</strong> Während der Ausführung des Befehles ist ein Fehler aufgetreten!\n' +
            '                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="collapse" data-target="#alert-error-collapse">Details anzeigen</button>\n' +
            '                        <div class="collapse" id="alert-error-collapse">\n' +
            '                            <code>' + message + '</code>\n' +
            '                        </div>\n' +
            '                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
            '                            <span aria-hidden="true">&times;</span>\n' +
            '                        </button>\n' +
            '                    </div>');
        $("#alert-error").removeClass("hidden");
    }

    static showSuccess() {
        $("#alert-success").html('<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 24px;">\n' +
            '                        <strong>Befehl erfolgreich!</strong> Der Befehl wurde erfolgreich in die Warteschlange gesendet und wird gleich ausgeführt!\n' +
            '                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
            '                            <span aria-hidden="true">&times;</span>\n' +
            '                        </button>\n' +
            '                    </div>');
        $("#alert-success").removeClass("hidden");
        setTimeout(function () {
            $("#alert-success").addClass("hidden");
        }, 10000)
    }

}