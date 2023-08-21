<?php


include 'init.php';

// Assuming $database is your database connection
// Create a new instance of the Request class
$request = new Request($database);

// Create a new instance of the Req
// Check if the form is submitted and the delete button is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    // Include the file with your database connection and Request class
   

    // Get the request ID from the form submission
    $requestIdToDelete = isset($_POST['request_id']) ? intval($_POST['request_id']) : null;

    // Try to delete the request
    try {
        if ($request->deleteRequestById($requestIdToDelete)) {
            // Deletion successful
            $_SESSION['success_message'] = "Request with ID $requestIdToDelete has been deleted successfully!";
        } else {
            // Deletion failed
            $_SESSION['error_message'] = "Failed to delete request with ID $requestIdToDelete.";
        }
    } catch (Exception $e) {
        // Handle any exceptions that might occur during the deletion process
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }

    // Redirect back to the page with the list of requests or any other appropriate page
    header('Location: view_request.php');
    exit(); // Make sure to exit after redirection
}
?>
