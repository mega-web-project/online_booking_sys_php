<?php
include 'init.php';

// Create a new Request instance
$request = new Request($database);

// Get the request ID from the URL or any other method (e.g., $_GET or $_POST)
$requestId = $_POST['id'];

// Validate and process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the updated data from the form
    $requestData = [
        'guest_name' => $_POST['guest_name'],
        'guest_address' => $_POST['guest_address'],
        'check_in_date' => $_POST['check_in_date'],
        'check_out_date' => $_POST['check_out_date'],
        'purpose_of_visit' => $_POST['purpose_of_visit'],
        'breakfast' => $_POST['breakfast'],
        'dinner' => $_POST['dinner'],
        'lunch' => $_POST['lunch'],
        'num_of_people_for_menu' => $_POST['num_of_people_for_menu'],
        'num_of_people_for_acco' => $_POST['num_of_people_for_acco'],
        'visitors_names' => $_POST['visitors_names'],
    ];

    // Check if the 'employeeNames' field exists in the $_POST array
    if (isset($_POST['employeeNames'])) {
        $requestData['employeeNames'] = $_POST['employeeNames'];
    } else {
        // If not, set it as an empty array
        $requestData['employeeNames'] = [];
    }

    try {
        // Update the request details using the updateRequestById function
        if ($request->updateRequestById($requestId, $requestData)) {
            header('Location:post.php?id='.$requestId.'');
            exit();
        } else {
            echo "Error updating the request.";
        }
    } catch (Exception $e) {
        // Display a detailed error message for debugging
        echo "An error occurred: " . $e->getMessage();
        // Log the error message to a file for further investigation
        error_log("Error updating the request: " . $e->getMessage(), 3, "error_log.txt");
    }
}
?>
