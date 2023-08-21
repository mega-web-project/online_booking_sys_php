<?php

require_once 'vendor/autoload.php'; // Include the autoloader

use PhpOffice\PhpSpreadsheet\IOFactory;

class Employee
{
    private $db;
    private $id;
    private $empCode;
    private $empName;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    // Setters for employee properties

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEmpCode($empCode)
    {
        $this->empCode = $empCode;
    }

    public function setEmpName($empName)
    {
        $this->empName = $empName;
    }

    // Method to add a new employee
    public function addEmployee()
    {
        // Check if emp_code already exists in the database
        $stmt = $this->db->getConnection()->prepare("SELECT COUNT(*) FROM employee WHERE emp_code = ?");
        $stmt->bind_param("s", $this->empCode);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $_SESSION['error_message'] = 'Employee with emp_code already exists.';
            return ['success' => false, 'message' => 'Employee with emp_code already exists.'];
        }

        // Prepare and execute the SQL statement
        $stmt = $this->db->getConnection()->prepare("INSERT INTO employee (emp_code, emp_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $this->empCode, $this->empName);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success_message'] = 'Employee added successfully.';
            return ['success' => true, 'message' => 'Employee added successfully.'];
        } else {
            $_SESSION['error_message'] = 'Error adding employee.';
            return ['success' => false, 'message' => 'Error adding employee.'];
        }
    }

    // Method to add employees from an Excel file
    public function addEmployeesFromExcel($filename)
    {
        $successCount = 0;
        $errorCount = 0;

        // Load the Excel file
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename);

        // Select the first worksheet
        $worksheet = $spreadsheet->getActiveSheet();

        // Get the highest row with data
        $highestRow = $worksheet->getHighestRow();

        // Iterate through each row of the worksheet
        for ($row = 2; $row <= $highestRow; $row++) {
            $empCode = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
            $empName = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

            // Check if emp_code already exists in the database
            $stmt = $this->db->getConnection()->prepare("SELECT COUNT(*) FROM employee WHERE emp_code = ?");
            $stmt->bind_param("s", $empCode);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count > 0) {
                $errorCount++;
                $_SESSION['error_message'] = 'Employee with emp_code '.$empCode.' already exists.';
                continue; // Skip adding employee and move to the next row
            }

            // Set employee details
            $this->setEmpCode($empCode);
            $this->setEmpName($empName);

            // Add the employee
            $result = $this->addEmployee();

            if ($result['success']) {
                $successCount++;
            } else {
                $errorCount++;
            }
        }

        return ['success' => $successCount, 'error' => $errorCount];
    }


    public function getEmployees()
{
    $query = "SELECT * FROM employee ORDER BY id DESC";
    $result = $this->db->getConnection()->query($query);

    if ($result && $result->num_rows > 0) {
        $employees = array();

        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }

        return $employees;
    }

    return false; // No employees found
}


public function deleteEmployee($employeeId)
{
    // Prepare and execute the SQL statement
    $stmt = $this->db->getConnection()->prepare("DELETE FROM employee WHERE id = ?");
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_message'] = 'Employee deleted successfully.';
        return ['success' => true, 'message' => 'Employee deleted successfully.'];
    } else {
        $_SESSION['error_message'] = 'Error deleting employee.';
        return ['success' => false, 'message' => 'Error deleting employee.'];
    }
}



// Method to edit an existing employee
public function editEmployee($employeeId, $empCode, $empName)
{
    // Check if emp_code already exists for another employee
    $stmt = $this->db->getConnection()->prepare("SELECT COUNT(*) FROM employee WHERE emp_code = ? AND id != ?");
    $stmt->bind_param("si", $empCode, $employeeId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $_SESSION['error_message'] = 'Employee with emp_code already exists.';
        return ['success' => false, 'message' => 'Employee with emp_code already exists.'];
    }

    // Prepare and execute the SQL statement to update the employee
    $stmt = $this->db->getConnection()->prepare("UPDATE employee SET emp_code = ?, emp_name = ? WHERE id = ?");
    $stmt->bind_param("ssi", $empCode, $empName, $employeeId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success_message'] = 'Employee updated successfully.';
        return ['success' => true, 'message' => 'Employee updated successfully.'];
    } else {
        $_SESSION['error_message'] = 'Error updating employee.';
        return ['success' => false, 'message' => 'Error updating employee.'];
    }
}

    // Other methods...

}