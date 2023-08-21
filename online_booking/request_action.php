<?php
include 'init.php';

// Create a new instance of the Request class
$request = new Request($database);

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    // Generate a unique ID for the request
    $uniqid = uniqid();

    // Retrieve the logged-in user's ID
    $requesterId = $_SESSION['user_id'];

    // Retrieve the form data and sanitize them
    $guestName = htmlspecialchars($_POST['guest_name'], ENT_QUOTES, 'UTF-8');
    $guestAddress = htmlspecialchars($_POST['guest_address'], ENT_QUOTES, 'UTF-8');
    $checkInDate = htmlspecialchars($_POST['check_in_date'], ENT_QUOTES, 'UTF-8');
    $checkOutDate = htmlspecialchars($_POST['check_out_date'], ENT_QUOTES, 'UTF-8');
    $purposeOfVisit = htmlspecialchars($_POST['purpose_of_visit'], ENT_QUOTES, 'UTF-8');
    $breakfast = htmlspecialchars($_POST['breakfast'], ENT_QUOTES, 'UTF-8');
    $lunch = htmlspecialchars($_POST['lunch'], ENT_QUOTES, 'UTF-8');
    $dinner = htmlspecialchars($_POST['dinner'], ENT_QUOTES, 'UTF-8');
    $approver1 = htmlspecialchars($_POST['approver1'], ENT_QUOTES, 'UTF-8');
    $approver2 = htmlspecialchars($_POST['approver2'], ENT_QUOTES, 'UTF-8');
    $approver3 = htmlspecialchars($_POST['approver3'], ENT_QUOTES, 'UTF-8');
    $approver4 = htmlspecialchars($_POST['approver4'], ENT_QUOTES, 'UTF-8');
    $status = 'Pending'; // Set the initial status to 'Pending'
    $employeeNames = isset($_POST['employeeNames']) && is_array($_POST['employeeNames']) ? implode(', ', $_POST['employeeNames']) : '';
    $visitorNames = htmlspecialchars($_POST['visitors'], ENT_QUOTES, 'UTF-8');
    $numOfPeopleForMenu = htmlspecialchars($_POST['num_of_people_for_menu'], ENT_QUOTES, 'UTF-8');
    $numOfPeopleForAcco = htmlspecialchars($_POST['num_of_people_for_acco'], ENT_QUOTES, 'UTF-8');

    // Set the values in the Request object
    $request->setUniqid($uniqid);
    $request->setGuestName($guestName);
    $request->setGuestAddress($guestAddress);
    $request->setCheckInDate($checkInDate);
    $request->setCheckOutDate($checkOutDate);
    $request->setPurposeOfVisit($purposeOfVisit);
    $request->setBreakfast($breakfast);
    $request->setLunch($lunch);
    $request->setDinner($dinner);
    $request->setRequesterId($requesterId);
    $request->setApprover1($approver1);
    $request->setApprover2($approver2);
    $request->setApprover3($approver3);
    $request->setApprover4($approver4);
    $request->setStatus($status);
    $request->setEmployeeNames($employeeNames);
    $request->setVisitorsNames($visitorNames);
    $request->setNumOfPeopleForMenu($numOfPeopleForMenu);
    $request->setNumOfPeopleForAcco($numOfPeopleForAcco);

    // Add the request to the database
    if ($request->addRequest()) {
        header('Location: view_request.php?alert=success');
    } else {
        header('Location: view_request.php?alert=danger');
    }
}
