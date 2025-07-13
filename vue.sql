--departement
CREATE OR REPLACE VIEW v_departments_managers AS
SELECT 
    d.dept_no, 
    e.last_name, 
    e.first_name, 
    d.dept_name,
    e.emp_no,
    m.from_date,
    m.to_date
FROM 
    departments d
    JOIN dept_manager m ON d.dept_no = m.dept_no
    JOIN employees e ON m.emp_no = e.emp_no
WHERE 
    m.to_date = (
        SELECT MAX(to_date) 
        FROM dept_manager m2 
        WHERE m2.dept_no = d.dept_no
    );

--information employees
CREATE OR REPLACE VIEW v_employees_departments AS
SELECT
    employees.emp_no,
    employees.first_name,
    employees.last_name,
    departments.dept_no,
    departments.dept_name,
    employees.gender,
    dept_emp.from_date,
    dept_emp.to_date,

    (YEAR(CURDATE()) - YEAR(employees.birth_date)) AS age
FROM
    employees
    JOIN dept_emp ON employees.emp_no = dept_emp.emp_no
    JOIN departments ON dept_emp.dept_no = departments.dept_no;

 -- 1. Fermer l’ancienne affectation (mettre à jour l'ancien en cours)
