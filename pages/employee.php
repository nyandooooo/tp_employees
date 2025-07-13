<?php

require("../inc/fonction.php");
if(isset($_GET['dept_no'])) {
    $dep_no = $_GET['dept_no'] ;
} else {
   $dep_no="all";
}
$page_size = 20;
$count = count_Employees_dep($dep_no);
$pagination = getPagination($page_size, $count, 'get');

$numact = $pagination['offset'];
$current_page = $pagination['current_page'];
$total_pages = $pagination['total_pages'];
$from = $pagination['from'];
$to = $pagination['to'];




$count = count_Employees_dep($dep_no);

$employee = get_Employees_dep($dep_no, $numact);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employés - <?= $employee[0]["dept_name"] ?? ''; ?></title>
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
            <input type="hidden" name="dept_no" value="<?=  $dep_no; ?>">
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