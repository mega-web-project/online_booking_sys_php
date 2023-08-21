<?php
// whitelist_request.php

// Include your necessary files and initialize the database connection (similar to other pages)
// ...

include 'init.php';

// Create a new Request instance
$request = new Request($database);

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $requestId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    // Insert the request ID into the whitelist table
    $result = $request->addToWhilelist($requestId, $userId);

    if ($result) {
        // Whitelisting successful
        echo "Request ID $requestId has been whitelisted!";
        header('Location: todo.php');
        exit; // Make sure to exit after the header redirection
    } else {
        // Whitelisting failed
        echo "Failed to whitelist request ID $requestId.";
    }
}

// Check if the "update" POST parameter is set
if (isset($_POST['update'])) {
    
    // Call the setDepartmentStatusToDone function with the specified request ID
    $request_id = $_POST['id'];
    $result = $request->setDepartmentStatusToDone($request_id);

    if ($result) {
        header('Location: todo.php');
    } else {
        header('Location: todo.php');
    }
}
?>
