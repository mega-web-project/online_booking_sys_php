<?php


include 'init.php';

// Create a new Employee instance
$employee = new Employee($database);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['upload'])) {
        // Check if an Excel file is uploaded
        if ($_FILES['excel_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'ExcelFile/'; // Directory to save uploaded files
            $filename = $_FILES['excel_file']['name'];
            $tmpFilename = $_FILES['excel_file']['tmp_name'];

            // Move the uploaded file to the upload directory
            $uploaded = move_uploaded_file($tmpFilename, $uploadDir . $filename);

            if ($uploaded) {
                // Add employees from the uploaded Excel file
                $result = $employee->addEmployeesFromExcel($uploadDir . $filename);

                if ($result['success'] > 0) {
                    // Redirect to the page where the data will be displayed with success alert
                    header('Location: people.php?alert=success');
                    exit();
                } else {
                    // Redirect to the page where the data will be displayed with warning alert
                    header('Location: people.php?alert=warning');
                    exit();
                }
            } else {
                // Redirect to the page where the data will be displayed with warning alert
                header('Location: people.php?alert=warning');
                exit();
            }
        } else {
            // Redirect to the page where the data will be displayed with warning alert
            header('Location: people.php?alert=warning');
            exit();
        }
    } elseif (isset($_POST['save'])) {
        // Retrieve employee details from the form
        $empCode = $_POST["emp_code"];
        $empName = $_POST["emp_name"];

        // Set employee details
        $employee->setEmpCode($empCode);
        $employee->setEmpName($empName);

        // Save the employee to the database
        $result = $employee->addEmployee();

        if ($result['success']) {
            // Redirect to the page where the data will be displayed with success alert
            header('Location: people.php?alert=success');
            exit();
        } else {
            // Redirect to the page where the data will be displayed with warning alert
            header('Location: people.php?alert=warning');
            exit();
        }
    }elseif (isset($_POST['delete'])) {
        // Retrieve the employee ID from the form
        $employeeId = $_POST['employee_id'];

        // Delete the employee
        $result = $employee->deleteEmployee($employeeId);

        if ($result['success']) {
            // Redirect to the page where the data will be displayed with success alert
            header('Location: people.php?alert=success');
            exit();
        } else {
            // Redirect to the page where the data will be displayed with warning alert
            header('Location: people.php?alert=warning');
            exit();
        }
    }
    elseif (isset($_POST['update'])) {
        // Retrieve employee details from the form
        $employeeId = $_POST['employee_id'];
        $empCode = $_POST['emp_code'];
        $empName = $_POST['emp_name'];

        // Edit the employee
        $result = $employee->editEmployee($employeeId, $empCode, $empName);

        if ($result['success']) {
            // Redirect to the page where the data will be displayed with success alert
            header('Location: people.php?alert=success');
            exit();
        } else {
            // Redirect to the page where the data will be displayed with warning alert
            header('Location: people.php?alert=warning');
            exit();
        }
    }
}

// Close the connection
$database->closeConnection();

?>