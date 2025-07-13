<?php

require("../inc/fonction.php");
$numact;
$departement =  get_Departements_Managers(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Départements</title>
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .table td a {
            text-decoration: none !important;
            color: inherit !important;
        }
    </style>
</head>

<body>
    <?php
    include '../assets/include/header.php';
    displayHeader('#232526', '#414345', 'Salut', 'stats');
    ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Department No</th>
                <th>Department Name</th>
                <th>Manager Name</th>
                <th>Nombre Femmes</th>
                <th>Nombre Hommes</th>
                <th>Salaire Moyen</th>
            </tr>
        </thead>

        <?php foreach ($departement as $huhu) { ?>
            <tr>
                <td>
                    <a href="employee.php?dept_no=<?= $huhu["dept_no"]; ?>" class="text-decoration-none d-block w-100 h-100">
                        <?= $huhu["dept_no"]; ?>
                    </a>
                </td>
                <td>
                    <a href="employee.php?dept_no=<?= $huhu["dept_no"]; ?>" class="text-decoration-none d-block w-100 h-100">
                        <?= $huhu["dept_name"]; ?>
                    </a>
                </td>
                <td>
                    <a href="employee.php?dept_no=<?= $huhu["dept_no"]; ?>" class="text-decoration-none d-block w-100 h-100">
                        <?= $huhu["first_name"] . " " . $huhu["last_name"]; ?>
                    </a>
                </td>
                <td>
                    <?= count_Employees_dep_sex($huhu["dept_no"], 'F'); ?>
                </td>
                <td>
                    <?= count_Employees_dep_sex($huhu["dept_no"], 'M'); ?>
                </td>
                <td>
                    <?= get_Salaire_Moyen_Emploi($huhu["dept_no"]); ?>
                </td>
            </tr>
        <?php } ?>

    </table>



</body>

</html>