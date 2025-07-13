<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer de département</title>
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        body {
            background: #232526;
            min-height: 100vh;
            color: #f3f3f3;
            font-family: 'Inter', sans-serif;
        }

        .custom-card {
            background: #414345;
            border-radius: 20px;
            box-shadow: 0 4px 32px #0005;
            margin-top: 54px;
            padding: 38px 28px 32px 28px;
        }

        .list-group-item {
            background: #35363a;
            color: #e6e8ee;
            border: none;
            font-size: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: #bdbdca;
        }

        .form-control,
        .form-select {
            background: #35363a;
            border: 1px solid #414345;
            color: #f3f3f3;
            border-radius: 13px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 2px #667eea44;
            background: #414345;
            color: #fff;
        }

        .btn-primary {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 20px;
            font-weight: 600;
            color: #fff;
            transition: filter .14s;
        }

        .btn-primary:hover {
            filter: brightness(1.10);
        }

        .alert-success {
            background: #243527;
            color: #43e97b;
            border: 1px solid #38f9d7;
        }

        .alert-danger {
            background: #3a2323;
            color: #f5576c;
            border: 1px solid #f093fb;
        }

        .custom-card .fa-building {
            color: #667eea;
            margin-right: 5px;
        }

        @media (max-width:600px) {
            .custom-card {
                padding: 22px 7px 18px 7px;
            }
        }
    </style>
</head>

<body>
    <?php
    require("../inc/fonction.php");
    include '../assets/include/header.php';
    displayHeader('#232526', '#414345', 'Salut', 'employee');
    if (!isset($_POST['emp_no'])) {
        $_POST['emp_no'] = $_GET['emp_no'];
    }


    $departementactuel = get_Departement_Actuel($_POST['emp_no']);
    $dep = isset($departementactuel[0]['dept_name']) ? $departementactuel[0]['dept_name'] : 'Inconnu';
    $date = isset($departementactuel[0]['from_date']) ? $departementactuel[0]['from_date'] : 'Inconnue';
    $num = isset($departementactuel[0]['dept_no']) ? $departementactuel[0]['dept_no'] : null;


    $manager = $num ? get_manager($num) : null;
    $manager_nom = 'Aucun manager';
    if ($manager && isset($manager[0]['first_name'], $manager[0]['last_name'])) {
        $manager_nom = $manager[0]['first_name'] . ' ' . $manager[0]['last_name'];
    }

    $listeDepartements = get_Departements();
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="custom-card shadow">
                    <h3 class="mb-4" style="color:#bdbdf0;">
                        <i class="fa fa-building"></i>
                        Devenir manager
                    </h3>
                    <ul class="list-group mb-4">
                        <li class="list-group-item">
                            Numéro employé : <b><?= $_POST['emp_no'] ?></b>
                        </li>
                        <li class="list-group-item">
                            Département actuel : <b><?= $dep ?></b>
                        </li>
                        <li class="list-group-item">
                            Date de début : <b><?= $date ?></b>
                        </li>
                        <li class="list-group-item">
                            Manager actuel du département : <b><?= $manager_nom ?></b>
                        </li>
                    </ul>
                    <form action="traitement/traitement_custom_manager.php" method="post">
                        <input type="hidden" name="emp_no" value="<?= $_POST['emp_no'] ?>">
                        <input type="hidden" name="dept_no" value="<?= $num ?>">
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de début :</label>
                            <input type="date" name="date_debut" id="date_debut" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fa fa-sync-alt me-2"></i>Changer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if (isset($_GET['mess'])) {
            switch ($_GET['mess']) {
                case '0':
                    echo '<div class="alert alert-danger mt-3">Date de début doit être supérieure ou égale à la date actuelle.</div>';
                    break;
                case '1':
                    echo '<div class="alert alert-success mt-3">Changement de manager réussi.</div>';
                    break;
                case '2':
                    echo '<div class="alert alert-danger mt-3">Erreur lors du changement de manager ou affectation déjà existante.</div>';
                    break;
            }
        } ?>
    </div>

</body>

</html>