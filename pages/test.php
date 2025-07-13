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
    $num = $departementactuel[0]['dept_no'];
    $listeDepartements = get_Departements();
    ?>