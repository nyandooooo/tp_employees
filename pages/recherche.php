<?php

require("../inc/fonction.php");
$search = $_GET['search'];
$by = $_GET['by'];

$nom = '';
$departement = '';
$age_min = '';
$age_max = '';

if ($by === 'departement') {
    $departement = $search;
} elseif ($by === 'nom') {
    $nom = $search;
} elseif ($by === 'age_min') {
    $age_min = $search;
} elseif ($by === 'age_max') {
    $age_max = $search;
}

$page_size = 20;
$count = count_rechercherEmployes($departement, $nom, $age_min, $age_max);
$pagination = getPagination($page_size, $count, 'get');

$numact = $pagination['offset'];
$current_page = $pagination['current_page'];
$total_pages = $pagination['total_pages'];
$from = $pagination['from'];
$to = $pagination['to'];
$employee = rechercherEmployes($departement, $nom, $age_min, $age_max, $numact);






?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employés - <?= htmlspecialchars($employee[0]["dept_name"] ?? ''); ?></title>
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table td a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>

<body>
    <?php
    include '../assets/include/header.php';
    displayHeader('#232526', '#414345', 'Salut', 'employee');
    ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employee as $huhu) { ?>
                <tr>
                    <td>
                        <a href="fiche_employees.php?emp_no=<?= $huhu["emp_no"]; ?>" class="text-decoration-none d-block w-100 h-100">
                            <?= $huhu["emp_no"]; ?>
                        </a>
                    </td>
                    <td>
                        <a href="fiche_employees.php?emp_no=<?= $huhu["emp_no"]; ?>" class="text-decoration-none d-block w-100 h-100">
                            <?= $huhu["first_name"] . " " . $huhu["last_name"]; ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="container text-center">
        <div>
            <?= $from . " à " . $to . " sur " . $count . " employés"; ?>
            (page <?= $current_page . " / " . $total_pages; ?>)
        </div>
        <form action="" method="get" style="display: inline;">
            <input type="hidden" name="search" value="<?= ($search); ?>">
            <input type="hidden" name="by" value="<?= ($by); ?>">
            <input type="hidden" name="numero" value="<?= $numact; ?>">
            <?php
            if ($numact <= 0) {
                echo '<button type="submit" name="action" value="back" class="btn btn-dark me-2" disabled>Retour</button>';
            } else {
                echo '<button type="submit" name="action" value="back" class="btn btn-dark me-2">Retour</button>';
            }
            if (($numact + $page_size) >= $count) {
                echo '<button type="submit" name="action" value="next" class="btn btn-dark" disabled>Suivant</button>';
            } else {
                echo '<button type="submit" name="action" value="next" class="btn btn-dark">Suivant</button>';
            }
            ?>
        </form>
    </div>


</body>

</html>