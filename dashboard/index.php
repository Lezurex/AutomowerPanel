<?php

include "../php/config.php";
include "../php/api.php";

session_start();

if (!isset($_SESSION['ACCESS_TOKEN'])) {
    header("Location: ../");
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Dashboard - Automower</title>
    <link href="css/styles.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/custom.css">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
          crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
            crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Automower Dashboard</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Select-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">Mähroboter</span>
            </div>
            <select class="custom-select" id="mower-select">
                <?php echo listMowers(); ?>
            </select>
        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/php/logout.php">Logout</a>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Eingeloggt</div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <div id="alert-success" class="hidden">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 24px;">
                        <strong>Befehl erfolgreich!</strong> Der Befehl wurde erfolgreich in die Warteschlange gesendet
                        und wird gleich ausgeführt!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div id="alert-error">
                    <div class="alert alert-danger alert-dismissible fade hidden" role="alert"
                         style="margin-top: 24px;">
                        <strong>Befehl fehlgeschlagen!</strong> Während der Ausführung des Befehles ist ein Fehler
                        aufgetreten!
                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="collapse"
                                data-target="#alert-error-collapse">Details anzeigen
                        </button>
                        <div class="collapse" id="alert-error-collapse">
                            <code>Error 404: Resource not found</code>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="row">
                    <div class="col-xl-4 col-md-auto" id="status-body">
                        <div class="card bg-secondary text-white mb-4">
                            <div class="card-body">Status wird abgefragt...</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <button class="btn btn-success" id="btn-start" data-toggle="modal"
                                        data-target="#modal-start">Starten
                                </button>
                            </li>
                            <li class="list-inline-item">
                                <button class="btn btn-danger" id="btn-stop" data-toggle="modal"
                                        data-target="#modal-stop">Stoppen
                                </button>
                            </li>
                            <li class="list-inline-item">
                                <button class="btn btn-primary" id="btn-park" data-toggle="modal"
                                        data-target="#modal-park">Parkieren
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Lezurex 2020</div>
                    <div>
                        <a href="#">Datenschutz</a>
                        &middot;
                        <a href="#">AGB</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<!--MODALS------------------------------------------------------------------------------------------------------------------------------------->

<!--START-->
<div class="modal fade" id="modal-start" tabindex="-1" aria-labelledby="Start" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Automower starten</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Schliessen"
                        id="modal-start-closex">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="custom-control custom-radio">
                    <input type="radio" id="modal-start-type1" name="modal-start-type" class="custom-control-input"
                           value="main" checked>
                    <label class="custom-control-label" for="modal-start-type1">Im Hauptbereich fortsetzen</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="modal-start-type2" name="modal-start-type" class="custom-control-input"
                           value="time">
                    <label class="custom-control-label" for="modal-start-type2">Zeitplan aus für...</label>
                </div>
                <div class="collapse" id="modal-start-time">
                    <br>
                    <div class="input-group">
                        <input type="number" class="form-control" style="max-width: 8ch;" value="3"
                               id="modal-start-time-input">
                        <div class="input-group-append">
                            <span class="input-group-text">Stunden</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modal-start-close" data-dismiss="modal">Schliessen
                </button>
                <button type="button" class="btn btn-success" id="modal-start-submit">Starten</button>
            </div>
        </div>
    </div>
</div>
<!--PARK-->
<div class="modal fade" id="modal-park" tabindex="-1" aria-labelledby="Parken" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Automower parken</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Schliessen" id="modal-park-closex">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="custom-control custom-radio">
                    <input type="radio" id="modal-park-type1" name="modal-park-type" class="custom-control-input"
                           value="plan" checked>
                    <label class="custom-control-label" for="modal-park-type1">Mit Zeitplan starten</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="modal-park-type2" name="modal-park-type" class="custom-control-input"
                           value="time">
                    <label class="custom-control-label" for="modal-park-type2">Zeitplan aus für...</label>
                </div>
                <div class="collapse" id="modal-park-time">
                    <br>
                    <div class="input-group">
                        <input type="number" class="form-control" style="max-width: 8ch;" value="3"
                               id="modal-park-time-input">
                        <div class="input-group-append">
                            <span class="input-group-text">Stunden</span>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="modal-park-type3" name="modal-park-type" class="custom-control-input"
                           value="ufn">
                    <label class="custom-control-label" for="modal-park-type3">Bis auf Weiteres</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modal-park-close" data-dismiss="modal">Schliessen
                </button>
                <button type="button" class="btn btn-primary" id="modal-park-submit">Parken</button>
            </div>
        </div>
    </div>


    <input class="hidden" value="<?php getAppKey() ?>" id="values-appKey">
    <input class="hidden" value="<?php $_SESSION['ACCESS_TOKEN'] ?>" id="values-accessToken">
    <input class="hidden" value="49cad35f-c19f-446e-b93e-4efda46eb341" id="values-mowerID"> <!--TODO Make selectable-->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="js/mowers.js"></script>
    <script src="js/status.js"></script>
    <script src="js/start.js"></script>
    <script src="js/alert.js"></script>
    <script src="js/stop.js"></script>
    <script src="js/park.js"></script>
</body>
</html>
