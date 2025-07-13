<?php
require("../../inc/fonction.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_no = $_POST['emp_no'];
    $dept_no = $_POST['dept_no'];
    $date_debut = $_POST['date_debut'];

    $now = date('Y-m-d');
    if ($date_debut < $now) {
        header("Location: ../custom_manager.php?dept_no=" . $dept_no."&mess=0"."&emp_no=" . $emp_no);
        exit;
    } else {
        if (changer_manager($emp_no, $dept_no, $date_debut)) {
            header("Location: ../custom_manager.php?dept_no=" . $dept_no."&mess=1"."&emp_no=" . $emp_no);
            exit;
        } else {
            header("Location: ../custom_manager.php?dept_no=" . $dept_no."&mess=2"."&emp_no=" . $emp_no);
            exit;
        }
    }
}

header("Location: ../custom_manager.php?dept_no=" . $dept_no."&mess=3"."&emp_no=" . $emp_no);
exit;
?>