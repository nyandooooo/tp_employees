<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer de département</title>
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #b993d6 0%, #8ca6db 100%);
            min-height: 100vh;
        }
        .custom-card {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 8px 32px rgba(50,50,130,0.10);
            margin-top: 48px;
            padding: 40px 32px 32px 32px;
        }
        .form-label {
            font-weight: 600;
        }
        .btn-primary {
            background: linear-gradient(90deg, #7b2ff2 0%, #f357a8 100%);
            border: none;
            border-radius: 24px;
            font-weight: 600;
            transition: box-shadow .15s;
        }
        .btn-primary:hover {
            box-shadow: 0 4px 16px #f357a8a2;
            background: linear-gradient(90deg, #7b2ff2 20%, #f357a8 100%);
        }
        ul.list-group {
            border-radius: 15px;
        }
    </style>
</head>
<body>
    <?php
    require("../inc/fonction.php");
    include '../assets/include/header.php';

 
    displayHeader('#7b2ff2', '#f357a8', 'Salut', 'employee');
    if (!isset($_POST['emp_no'])) {
       $_POST['emp_no'] =$_GET['emp_no'] ;
    }
    
    $departementactuel = get_Departement_Actuel($_POST['emp_no']);
    $dep = isset($departementactuel[0]['dept_name']) ? $departementactuel[0]['dept_name'] : 'Inconnu';
    $date = isset($departementactuel[0]['from_date']) ? $departementactuel[0]['from_date'] : 'Inconnue';
    $num = $departementactuel[0]['dept_no'];
    $listeDepartements = get_Departements();
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="custom-card shadow">
                    <ul class="list-group mb-4">
                        <li class="list-group-item">Numéro employé : <b><?= htmlspecialchars($_POST['emp_no']) ?></b></li>
                        <li class="list-group-item">Département actuel : <b><?= htmlspecialchars($dep) ?></b></li>
                        <li class="list-group-item">Date de début : <b><?= htmlspecialchars($date) ?></b></li>
                    </ul>
                    <form action="traitement/traitement_custom_dep.php" method="post">
                        <input type="hidden" name="emp_no" value="<?= htmlspecialchars($_POST['emp_no']) ?>">
                        <div class="mb-3">
                            <label for="dept_no" class="form-label">Nouveau département :</label>
                            <select name="dept_no" id="dept_no" class="form-select" required>
                                <?php
                                for ($i = 0; $i < count($listeDepartements); $i++) {
                                    $departement = $listeDepartements[$i];
                                    if ($num != $departement["dept_no"]) {
                                        echo '<option value="' . htmlspecialchars($departement["dept_no"]) . '">' . htmlspecialchars($departement["dept_name"]) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de début :</label>
                            <input type="date"
                                   name="date_debut"
                                   id="date_debut"
                                   class="form-control"
                                   required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Changer</button>
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
            echo '<div class="alert alert-success mt-3">Changement de département réussi.</div>';
            break;
        case '2':
            echo '<div class="alert alert-danger mt-3">Erreur lors du changement de département ou affectation déjà existante.</div>';
            break;
    }
}?>
    </div>
</body>
</html>
