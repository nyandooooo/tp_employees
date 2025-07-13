<?php
require("co.php");

function tab($sql)
{
    $membre_req = mysqli_query(dbconnect(), $sql);
    $result = [];
    while ($membre = mysqli_fetch_assoc($membre_req)) {
        $result[] = $membre;
    }

    return $result;
}
function get_Departements()
{
    $sql = "SELECT * from departments order by dept_no";
    return tab($sql);
}

//////////////////////////////////////////



function get_Departements_Managers()
{
    $sql = "SELECT *
            FROM v_departments_managers
            ORDER BY dept_no ASC";
    return tab($sql);
}
///////////////////////////////////////////


function get_Employees_dep($code, $isa)
{
    $sql = "SELECT *
    FROM v_employees_departments
    WHERE dept_no = '$code'  ORDER BY first_name ASC LIMIT $isa,20;";

    return tab($sql);
}


function count_Employees_dep($code)
{
    $sql = "SELECT COUNT(*) as total FROM v_employees_departments
            WHERE dept_no = '$code'";
    $result = tab($sql);
    return $result[0]['total'] ?? 0;
}


function get_Fiche_Employees($code)
{
    $sql = "SELECT *from employees 
    where emp_no = '$code'";

    return tab($sql);
}

function get_Salaire_Historique($code)
{
    $sql = "SELECT salary, from_date, to_date FROM salaries WHERE emp_no = '$code' ORDER BY from_date DESC";
    return tab($sql);
}


function rechercherEmployes($departement, $nom, $age_min, $age_max, $limit)
{
    $clauses = [];

    if (!empty($departement)) {
        $clauses[] = "(dept_no LIKE '%$departement%' OR dept_name LIKE '%$departement%')";
    }

    if (!empty($nom)) {
        $clauses[] = "(last_name LIKE '%$nom%' OR first_name LIKE '%$nom%')";
    }

    if (!empty($age_min)) {
        $clauses[] = "age >= " . intval($age_min);
    }

    if (!empty($age_max)) {
        $clauses[] = "age <= " . intval($age_max);
    }

    $where = "";
    if (count($clauses) > 0) {
        $where = "WHERE " . implode(" AND ", $clauses);
    }

    $sql = "SELECT * FROM v_employees_departments $where ORDER BY first_name ASC limit $limit,20";
    return tab($sql);
}

function count_rechercherEmployes($departement, $nom, $age_min, $age_max)
{
    $clauses = [];

    if (!empty($departement)) {
        $clauses[] = "(dept_no LIKE '%$departement%' OR dept_name LIKE '%$departement%')";
    }

    if (!empty($nom)) {
        $clauses[] = "(last_name LIKE '%$nom%' OR first_name LIKE '%$nom%')";
    }

    if (!empty($age_min)) {
        $clauses[] = "age >= " . intval($age_min);
    }

    if (!empty($age_max)) {
        $clauses[] = "age <= " . intval($age_max);
    }

    $where = "";
    if (count($clauses) > 0) {
        $where = "WHERE " . implode(" AND ", $clauses);
    }

    $sql = "SELECT COUNT(*) as total FROM v_employees_departments $where";
    $result = tab($sql);
    return $result[0]['total'] ?? 0;
}




function count_Employees_dep_sex($code, $sex = '')
{
    $sql = "SELECT COUNT(*) AS total FROM v_employees_departments";

    if ($code != '' && $sex != '') {

        $sql .= " WHERE dept_no = '" . $code . "' AND gender = '" . $sex . "'";
    } else if ($code != '') {

        $sql .= " WHERE dept_no = '" . $code . "'";
    } else if ($sex != '') {

        $sql .= " WHERE gender = '" . $sex . "'";
    }

    $result = tab($sql);

    if (isset($result[0]['total'])) {
        return $result[0]['total'];
    } else {
        return 0;
    }
}


function get_Salaire_Moyen_Emploi($code)
{
    $sql = "SELECT AVG(salary) as salaire_moyen FROM salaries WHERE emp_no IN (SELECT emp_no FROM v_employees_departments WHERE dept_no = '$code')";
    $result = tab($sql);
    return $result[0]['salaire_moyen'] ?? 0;
}

function getPagination($page_size, $total_count, $method = 'get')
{
    if ($method === 'post') {
        $vars = $_POST;
    } else {
        $vars = $_GET;
    }

    // Offset (numero)
    if (isset($vars['numero'])) {
        $offset = intval($vars['numero']);
    } else {
        $offset = 0;
    }

    // Action
    if (isset($vars['action'])) {
        if ($vars['action'] === 'next') {
            $offset += $page_size;
        } else if ($vars['action'] === 'back') {
            $offset -= $page_size;
            if ($offset < 0) {
                $offset = 0;
            }
        }
    }

    // Nombre de pages total 
    if ($total_count > 0) {
        if ($total_count % $page_size == 0) {
            $total_pages = $total_count / $page_size;
        } else {
            $total_pages = floor($total_count / $page_size) + 1;
        }
    } else {
        $total_pages = 1;
    }

    // Page courante 
    if ($offset == 0) {
        $current_page = 1;
    } else {
        $current_page = floor($offset / $page_size) + 1;
    }

    // Plage d’affichage
    $from = $offset + 1;
    if ($from > $total_count) $from = $total_count;
    $to = $offset + $page_size;
    if ($to > $total_count) $to = $total_count;

    return array(
        'offset' => $offset,
        'current_page' => $current_page,
        'total_pages' => $total_pages,
        'from' => $from,
        'to' => $to
    );
}


function get_Emploi_Employees($code)
{
    $sql = "SELECT * FROM v_employees_departments WHERE emp_no = '$code' ORDER BY dept_no ASC";
    return tab($sql);
}


function changer_dept($emp_no, $dept_no, $date_debut)
{
    $db = dbconnect();


    $sql = "SELECT 1 FROM dept_emp WHERE emp_no = $emp_no AND dept_no = '$dept_no' AND from_date = '$date_debut'";
    $check = mysqli_query($db, $sql);
    if (mysqli_num_rows($check) > 0) {
        return false;
    }


    $sql = "UPDATE dept_emp SET to_date = '$date_debut' WHERE emp_no = $emp_no AND to_date = '9999-01-01'";
    $a = mysqli_query($db, $sql);

    $sql = "INSERT INTO dept_emp (emp_no, dept_no, from_date, to_date) VALUES ($emp_no, '$dept_no', '$date_debut', '9999-01-01')";
    $b = mysqli_query($db, $sql);

    return ($a && $b);
}



function get_Departement_Actuel($emp_no)
{
    $sql = "
        SELECT *
        FROM v_employees_departments
        WHERE emp_no = $emp_no and to_date = '9999-01-01'
      
    ";
    return tab($sql);
}


function get_manager($dept_no)
{
    $sql = "
        SELECT *
        FROM v_departments_managers
        WHERE dept_no = '$dept_no'
    ";
    return tab($sql);
}
function changer_manager($emp_no, $dept_no, $date_debut)
{
    $db = dbconnect();

    // 1. Clôturer le manager actuel de ce département (fin de mandat)
    $sql = "UPDATE dept_manager 
            SET to_date = '$date_debut' 
            WHERE dept_no = '$dept_no' AND to_date = '9999-01-01'";
    $a = mysqli_query($db, $sql);

    // 2. Ajouter le nouvel enregistrement manager
    $sql = "INSERT INTO dept_manager (emp_no, dept_no, from_date, to_date) 
            VALUES ($emp_no, '$dept_no', '$date_debut', '9999-01-01')";
    $b = mysqli_query($db, $sql);

    return ($a && $b);
}

