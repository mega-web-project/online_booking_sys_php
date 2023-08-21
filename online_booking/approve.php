<?php
include 'init.php';

// Create a new instance of the Request class
$request = new Request($database);

// Check if the form is submitted and the approval or reject button is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $approverId = $_SESSION['user_id']; // Assuming the current user is the approver
    $requestId = isset($_POST['request_id']) ? intval($_POST['request_id']) : null;
    $rejectionMessage = isset($_POST['rejectionMessage']) ? $_POST['rejectionMessage'] : '';
 // Get the rejection message

    // Validate the approver ID
    if (!$request->validateApproverId($approverId)) {
        // Invalid approver ID
        echo "Invalid approver ID.";
    } else {
        // Check if the approval button is clicked
        if (isset($_POST['approve_button'])) {
            // Process the approval
            if ($request->processApproval($approverId, $requestId)) {
                // Approval successful
                echo "Request approved successfully!";
                // Construct the URL with the request_id parameter
                $redirectURL = "post.php?id=" . $requestId;
                // Redirect the user to the URL
                header('Location: ' . $redirectURL);
                exit(); // Make sure to exit after redirection
            } else {
                // Approval failed
                echo "Failed to approve the request.";
            }
        } elseif (isset($_POST['reject_button'])) {
            // Process the rejection
            if ($request->rejectRequest($requestId, $approverId, $rejectionMessage)) {
                // Rejection successful
                echo "Request rejected successfully!";
                // Construct the URL with the request_id parameter
                $redirectURL = "post.php?id=" . $requestId;
                // Redirect the user to the URL
                header('Location: ' . $redirectURL);
                exit(); // Make sure to exit after redirection
            } else {
                // Rejection failed
                echo "Failed to reject the request.";
            }
        } else {
            // No action specified (neither approve nor reject)
            echo "No action specified.";
        }
    }
}

?>
