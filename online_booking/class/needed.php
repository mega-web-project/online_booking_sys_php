<?php

class Request
{
    private $db;
    private $uniqid;
    private $guestName;
    private $guestAddress;
    private $checkInDate;
    private $checkOutDate;
    private $purposeOfVisit;
    private $breakfast;
    private $dinner;
    private $lunch;
    private $numOfPeopleForMenu;
    private $numOfPeopleForAcco;
    private $employeeNames;
    private $visitorsNames;
    private $status;
    private $rejectionMessage;
    private $requesterId;
    private $approverId;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    // Setters for request properties

    public function setUniqid($uniqid)
    {
        $this->uniqid = $uniqid;
    }

    public function setGuestName($guestName)
    {
        $this->guestName = $guestName;
    }

    public function setGuestAddress($guestAddress)
    {
        $this->guestAddress = $guestAddress;
    }

    public function setCheckInDate($checkInDate)
    {
        $this->checkInDate = $checkInDate;
    }

    public function setCheckOutDate($checkOutDate)
    {
        $this->checkOutDate = $checkOutDate;
    }

    public function setPurposeOfVisit($purposeOfVisit)
    {
        $this->purposeOfVisit = $purposeOfVisit;
    }

    public function setBreakfast($breakfast)
    {
        $this->breakfast = $breakfast;
    }

    public function setDinner($dinner)
    {
        $this->dinner = $dinner;
    }

    public function setLunch($lunch)
    {
        $this->lunch = $lunch;
    }

    public function setNumOfPeopleForMenu($numOfPeopleForMenu)
    {
        $this->numOfPeopleForMenu = $numOfPeopleForMenu;
    }

    public function setNumOfPeopleForAcco($numOfPeopleForAcco)
    {
        $this->numOfPeopleForAcco = $numOfPeopleForAcco;
    }

    public function setEmployeeNames($employeeNames)
    {
        $this->employeeNames = $employeeNames;
    }

    public function setVisitorsNames($visitorsNames)
    {

        $this->visitorsNames = $visitorsNames;

    }


    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setRejectionMessage($rejectionMessage)
    {
        $this->rejectionMessage = $rejectionMessage;
    }

    public function setRequesterId($requesterId)
    {
        $this->requesterId = $requesterId;
    }

    public function setApproverId($approverId)
    {
        $this->approverId = $approverId;
    }

    public function createRequest()
    {
        $createdAt = date('Y-m-d H:i:s'); // Get the current datetime
    
        $stmt = $this->db->getConnection()->prepare("INSERT INTO requests (uniqid, guest_name, guest_address, check_in_date, check_out_date, purpose_of_visit, breakfast, dinner, lunch, num_of_people_for_menu, num_of_people_for_acco, employee_names, visitors_names, status, rejection_message, requester_id, approver_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        // Bind the parameters
        $stmt->bind_param("sssssssssssssissss", $this->uniqid, $this->guestName, $this->guestAddress, $this->checkInDate, $this->checkOutDate, $this->purposeOfVisit, $this->breakfast, $this->dinner, $this->lunch, $this->numOfPeopleForMenu, $this->numOfPeopleForAcco, $this->employeeNames, $this->visitorsNames, $this->status, $this->rejectionMessage, $this->requesterId, $this->approverId, $createdAt);
    
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            $stmt->close();
    
            // Retrieve the email addresses of the selected approvers
            $selectedApprovers = explode(',', $this->approverId);
            $selectedApprovers = array_map('trim', $selectedApprovers);
            $approverEmails = array();
    
            $approvers = $this->getApprovers();
    
            foreach ($approvers as $approver) {
                if (in_array($approver['id'], $selectedApprovers) && $approver['email'] !== null) {
                    $approverEmails[] = $approver['email'];
                }
            }
    
            $requestLink = "http://localhost/dashboard/online_booking/post.php?request_id=" . $this->uniqid;
    
            // Send email notifications to the selected approvers
            foreach ($approverEmails as $approverEmail) {
                $message = "Dear Approvers,\n\nYou have a request (ID: " . $this->uniqid . ") pending for approval. Please click the following link to approve the request:\n\n" . $requestLink;
                mail($approverEmail, "Approval Request", $message);
            }
    
            // Update the request status in the database
            $this->updateRequestStatus();
    
            return ['success' => true, 'message' => 'Request created successfully.'];
        } else {
            $stmt->close();
            return ['success' => false, 'message' => 'Error creating request.'];
        }
    }
    

    public function validateApproverId($approverId)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->bind_param("i", $approverId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    
        return $result->num_rows === 1;
    }

























    public function getApprovers()
    {
        $approverType = "approver"; // User type value for approvers
        // User type value for admins

        $stmt = $this->db->getConnection()->prepare("SELECT id, name, email FROM users WHERE user_type = ?");
        $stmt->bind_param("s", $approverType);
        $stmt->execute();
        $result = $stmt->get_result();

        $approvers = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $approvers[] = $row;
            }
        }

        return $approvers;
    }


    
    public function getAdmin()
    {
       
        $adminType = "admin"; // User type value for admins

        $stmt = $this->db->getConnection()->prepare("SELECT id, name, email FROM users WHERE user_type = ?");
        $stmt->bind_param("s", $adminType);
        $stmt->execute();
        $result = $stmt->get_result();

        $approvers = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $approvers[] = $row;
            }
        }

        return $approvers;
    }

    // Helper method to fetch email address by user ID
    private function getEmailById($userId)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT email FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['email'];
        }

        return null;
    }

    // Helper method to fetch username by user ID
    private function getUsernameById($userId)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT name FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['name'];
        }

        return null;
    }

    private function updateRequestStatus()
    {
        $stmt = $this->db->getConnection()->prepare("UPDATE requests SET status = ? WHERE uniqid = ?");
        $stmt->bind_param("ss", $this->status, $this->uniqid);
        $stmt->execute();
    }



    public function getEmployees()
    {
        $stmt = $this->db->getConnection()->prepare("SELECT id, emp_name FROM employee");
        $stmt->execute();
        $result = $stmt->get_result();

        $employees = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $employees[] = $row;
            }
        }

        return $employees;
    }




    // Method to retrieve breakfast menu options and store them in a session variable
    public function generateBreakfastMenuOptions()
    {
        $query = "SELECT name FROM menu WHERE category_id = 1"; // Assuming category_id 1 represents breakfast
        $result = $this->db->getConnection()->query($query);

        $options = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $options[] = $row['name'];
            }
        }

        return $options;
    }



    // Method to fetch lunch menu options
    public function fetchLunchOptions()
    {
        $query = "SELECT name FROM menu WHERE category_id = 2"; // Assuming category_id 1 represents breakfast
        $result = $this->db->getConnection()->query($query);

        $options = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $options[] = $row['name'];
            }
        }

        return $options;
    }

    // Method to fetch dinner menu options
    public function fetchDinnerOptions()
    {
        $query = "SELECT name FROM menu WHERE category_id = 3"; // Assuming category_id 1 represents breakfast
        $result = $this->db->getConnection()->query($query);

        $options = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $options[] = $row['name'];
            }
        }

        return $options;
    }
}









?>


<?php
// Include the necessary files
include 'init.php';

// Create a new Request instance
$request = new Request($database);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $uniqid = uniqid(); // Generate a unique ID
    $guestName = $_POST['guest_name'];
    $guestAddress = $_POST['guest_address'];
    $checkInDate = $_POST['check_in_date'];
    $checkOutDate = $_POST['check_out_date'];
    $purposeOfVisit = $_POST['purpose_of_visit'];
    $breakfast = $_POST['breakfast'];
    $dinner = $_POST['dinner'];
    $lunch = $_POST['lunch'];
    $numOfPeopleForMenu = $_POST['num_of_people_for_menu'];
    $numOfPeopleForAcco = $_POST['num_of_people_for_acco'];
    $employeeNames = isset($_POST['employeeNames']) ? $_POST['employeeNames'] : null;
    $visitorsNames = $_POST['visitors'];
    // Convert visitors names to an array
    $visitorsNamesArray = explode(',', $visitorsNames);
    $visitorsNames = array_map('trim', $visitorsNamesArray);
    $status = 'pending'; // Set the initial status as pending
    $rejectionMessage = null; // No rejection message initially
    $approverId = $_POST['approvers'];

    // Get the requester ID from the logged-in user's session
    $requesterId = $_SESSION['user_id'];

    // Serialize the employee names
    $serializedEmployeeNames = serialize($employeeNames);
    $serializedVisitorsNames = serialize($visitorsNames);

    // Set the request properties
    $request->setUniqid($uniqid);
    $request->setGuestName($guestName);
    $request->setGuestAddress($guestAddress);
    $request->setCheckInDate($checkInDate);
    $request->setCheckOutDate($checkOutDate);
    $request->setPurposeOfVisit($purposeOfVisit);
    $request->setBreakfast($breakfast);
    $request->setDinner($dinner);
    $request->setLunch($lunch);
    $request->setNumOfPeopleForMenu($numOfPeopleForMenu);
    $request->setNumOfPeopleForAcco($numOfPeopleForAcco);
    $request->setEmployeeNames($serializedEmployeeNames);
    $request->setVisitorsNames($serializedVisitorsNames);
    $request->setStatus($status);
    $request->setRejectionMessage($rejectionMessage);
    $request->setRequesterId($requesterId);
    $request->setApproverId($approverId);

    // Create the request
    $result = $request->createRequest();

    if ($result['success']) {
        // Redirect to the success page
        header('Location: request.php');
        exit();
    } else {
        // Redirect to the error page
        header('Location: request.php');
        exit();
    }
}

// Other code and HTML content of the page goes here
?>

$employeeNames = implode(", ", $_POST['employeeNames']);
    $visitorNames = $_POST['visitors'];