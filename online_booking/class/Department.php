<?php

class Department
{

    private $db;
    private $id;
    private $name;
    private $status;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function addDepartment()
    {
        // Prepare and execute the SQL statement
        $stmt = $this->db->getConnection()->prepare("INSERT INTO departments (name, status) VALUES (?, ?)");
        $stmt->bind_param("ss", $this->name, $this->status);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success_message'] = 'Department stored successfully.';
            return ['success' => true, 'message' => 'Department stored successfully.'];
        } else {
            $_SESSION['success_message'] = 'Error storing department.';
            return ['success' => false, 'message' => 'Error storing department.'];
        }
    }

    public function getDepartments()
    {
        $query = "SELECT * FROM departments ORDER BY id DESC";
        $result = $this->db->getConnection()->query($query);

        if ($result && $result->num_rows > 0) {
            $departments = array();

            while ($row = $result->fetch_assoc()) {
                $departments[] = $row;
            }

            return $departments;
        }

        return false; // No departments found
    }

    public function getDepartmentById($departmentId)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM departments WHERE id = ?");
        $stmt->bind_param("i", $departmentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $department = $result->fetch_assoc();
            return $department;
        }

        return null; // No department found
    }

    public function updateDepartmentById()
    {
        // Prepare and execute the SQL statement
        $stmt = $this->db->getConnection()->prepare("UPDATE departments SET name = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssi", $this->name, $this->status, $this->id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteDepartmentById($departmentId)
    {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM departments WHERE id = ?");
        $stmt->bind_param("i", $departmentId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success_message'] = 'Department stored successfully.';
            return ['success' => true, 'message' => 'Department stored successfully.'];
        } else {
            return false;
        }
    }


    public function toggleDepartmentStatus($departmentId, $status)
    {
        $stmt = $this->db->getConnection()->prepare("UPDATE departments SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $departmentId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
           
            return true;
        } else {
            return false;
        }
    }
}

?>
