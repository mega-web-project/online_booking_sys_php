<?php
include 'init.php';

// Create a new Department instance
$department = new Department($database);

// Retrieve departments
$departments = $department->getDepartments();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve department details from the form
    $name = $_POST["name"];
    $status = $_POST["status"];

    if (isset($_POST['save'])) {
        // Set department details
        $department->setName($name);
        $department->setStatus($status);

        // Add the department
        $result = $department->addDepartment();
    } elseif (isset($_POST['update'])) {
        // Retrieve the department ID from the form
        $departmentId = $_POST['id'];

        $department->setId($departmentId);
        $department->setName($name);
        $department->setStatus($status);

        $result = $department->updateDepartmentById();

        if ($result) {
            // Redirect to the page where the data will be displayed with success alert
            header('Location: department.php');
            exit();
        } else {
            // Redirect to the page where the data will be displayed with warning alert
            header('Location: department.php');
            exit();
        }
    } elseif (isset($_POST['toggle'])) {
        // Retrieve the department ID from the form
        $departmentId = $_POST['id'];

        $department->setId($departmentId);

        $result = $department->toggleDepartmentStatus($departmentId, $status);

        if ($result) {
            // Redirect to the page where the data will be displayed with success alert
            header('Location: department.php');
            exit();
        } else {
            // Redirect to the page where the data will be displayed with warning alert
            header('Location: department.php');
            exit();
        }
    }

    if ($result['success']) {
        // Redirect to the page where the data will be displayed with success alert
        header('Location: department.php?alert=success');
        exit();
    } else {
        // Redirect to the page where the data will be displayed with warning alert
        header('Location: department.php?alert=warning');
        exit();
    }
}

// Close the connection
$database->closeConnection();
?>