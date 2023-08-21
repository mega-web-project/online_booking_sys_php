<?php
include 'init.php';
$pageTitle = "Request | View";
include('inc/header.php');

if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or any other desired page
    header('Location: login.php');
    exit();
}

include('inc/nav.php');





// Check if success message exists in session and display it
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success alert-dismissible fade show p-4 m-3" role="alert">
    <strong>Success!</strong> ' . $_SESSION['success_message'] . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    unset($_SESSION['success_message']); // Remove the success message from session
}

// Check if error message exists in session and display it
if (isset($_SESSION['error_message'])) {


    echo '<div class="alert alert-danger alert-dismissible fade show p-4 m-3" role="alert">
  <strong>Rejected!</strong> ' . $_SESSION['error_message'] . '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    unset($_SESSION['error_message']); // Remove the error message from session
}

?>







<div class="container pt-4">
    <h1 class="msg-title">Request Details</h1>
    <hr>

    <section style="background-color: #f7f6f6;">
        <div class="container my-1 py-1 text-dark">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12 col-lg-10 col-xl-8">
                    <?php
                    // Check if the request ID is provided in the URL query parameters
                    if (isset($_GET['id'])) {
                        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

                        // Decode the URL-encoded request_id
                    
                        // Retrieve the request details using the Request class
                        $requestDetails = $request->getRequestDetailsById($id);


                        // Check if the request exists
                        if ($requestDetails) {

                            $statusClass = '';
                            if ($requestDetails['status'] === 'Pending') {
                                $statusClass = 'bg-warning text-dark';
                            } elseif ($requestDetails['status'] === 'Rejected') {
                                $statusClass = 'bg-danger text-white';
                            } elseif ($requestDetails['status'] === 'Approved') {
                                $statusClass = 'bg-success text-white';
                            } elseif ($requestDetails['status'] === 'Processing') {
                                $statusClass = 'bg-secondary text-white';
                            }
                            ?>
                            <div class="card mb-3 post" id="myPost">
                                <div class="card-body">
                                    <div class="d-flex flex-start">
                                        <img class="rounded-circle shadow-1-strong me-3"
                                            src="<?php echo $requestDetails['requester_image']; ?>" alt="avatar" width="40"
                                            height="40" />
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="text-primary fw-bold mb-0">
                                                    <?php echo $requestDetails['requester_name']; ?>
                                                    <span class="text-dark ms-2">
                                                        <i class="fa fa-users" aria-hidden="true"></i>
                                                        <span class="department">
                                                            <?php echo $requestDetails['requester_department']; ?>
                                                        </span>
                                                    </span>
                                                </h6>
                                                <p class="mb-0">
                                                    <?php echo $requestDetails['elapsed_time']; ?>
                                                </p>
                                            </div>
                                            <div class="details" id="details">
                                                <table class="table table-striped">
                                                    <tr>
                                                        <th>Guest name</th>
                                                        <td>
                                                            <?php echo $requestDetails['guest_name']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td>
                                                            <?php echo $requestDetails['guest_address']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Expected Date and Time of Arrival</th>
                                                        <td>
                                                            <?php echo $requestDetails['check_in_date']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Expected Date and Time of Departure</th>
                                                        <td>
                                                            <?php echo $requestDetails['check_out_date']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Purpose of Visit</th>
                                                        <td>
                                                            <?php echo $requestDetails['purpose_of_visit']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Names of Visitors</th>
                                                        <td>
                                                            <?php echo $requestDetails['visitors_names']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Employees Names</th>
                                                        <td>
                                                            <?php echo $requestDetails['employee_names']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Accommodation</th>
                                                        <td>
                                                            <?php echo $requestDetails['num_of_people_for_acco']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Number of People</th>
                                                        <td>
                                                            <?php echo $requestDetails['num_of_people_for_menu']; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Breakfast</th>
                                                        <td>
                                                            <?php echo $requestDetails['breakfast']; ?>
                                                           <span class="p-3">&#x20B5; <?php echo $requestDetails['breakfast_price']; ?></span>
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Lunch</th>
                                                        <td>
                                                            <?php echo $requestDetails['lunch']; ?>
                                                            <span class="p-3">&#x20B5; <?php echo $requestDetails['lunch_price']; ?></span>
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Dinner</th>
                                                        <td>
                                                            <?php echo $requestDetails['dinner']; ?>
                                                            <span class="p-3">&#x20B5; <?php echo $requestDetails['dinner_price']; ?></span>
                                                       
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Number of Days to spend</th>
                                                        <td>
                                                            <?php echo $requestDetails['num_of_days_to_spend']; ?> day (s)
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Total Price</th>
                                                        <td>
                                                        &#x20B5; <?php echo number_format($requestDetails['total_price'], 2); ?>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <?php if ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'approver'): ?>
                                                            <th>Actions</th>
                                                            <td>
                                                                <form method="POST" action="approve.php">
                                                                    <!-- Other request details here -->

                                                                    <input type="hidden" name="request_id"
                                                                        value="<?php echo $requestDetails['id']; ?>">

                                                                   
                                                                        <button type="submit" name="approve_button"
                                                                            class="btn btn-success"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Approve</button>
                                                                            <a href="" class="btn btn-danger" data-bs-toggle="modal"
                                                                            data-bs-target="#rejectexampleModal">
                                                                            <i class="fa fa-thumbs-down" aria-hidden="true"></i> Reject
                                                                        </a>
                                                                  
                                                                </form>
                                                                <!-- <button class="btn btn-primary mx-2">Approve</button>
                                                        <button class="btn btn-danger">Reject</button> -->

                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>

                                                    <tr>
                                                        <th>Status</th>
                                                        <td>
                                                            <span class="status badge  <?= $statusClass ?> text-white p-2 fs-6">
                                                                
                                                                <?php echo $requestDetails['status']; ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="small mb-0 fs-6">
                                                
                                                    <a href="edit_request.php?id=<?= $requestDetails['id'];?>" class="link-success mx-2">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="print_request.php?id=<?php echo $requestDetails['id']; ?>"
                                                        class="link-secondary mx-2">
                                                        <i class="fa fa-print" aria-hidden="true"></i>
                                                    </a>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="rejectexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="approve.php">
                                            <div class="modal-body">
                                                <h6 class="text-danger">Want to Reject?</h6>
                                                <hr>
                                                <textarea class="form-control shadow-none" name="rejectionMessage"
                                                    id="form6Example7" rows="4"
                                                    placeholder="Kindly state the reason for rejecting the request"
                                                    required></textarea>
                                            </div>
                                            <div class="modal-footer">

                                                <!-- Other request details here -->

                                                <input type="hidden" name="request_id"
                                                    value="<?php echo $requestDetails['id']; ?>">

                                                <button type="submit" name="reject_button"
                                                    class="btn btn-danger">Confirm</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            echo '<p>Invalid request ID.</p>';
                        }
                    } else {
                        echo '<p>Request ID not provided.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="rejectexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="approve.php">
                    <div class="modal-body">
                        <h6 class="text-danger">Want to Reject?</h6>
                        <hr>
                        <textarea class="form-control shadow-none" name="purpose_of_visit" id="form6Example7" rows="4"
                            placeholder="Kindly state the reason for rejecting the request" required></textarea>
                    </div>
                    <div class="modal-footer">

                        <!-- Other request details here -->

                        <input type="hidden" name="request_id" value="<?php echo $requestDetails['id']; ?>">

                        <button type="submit" name="reject_button" class="btn btn-danger">Confirm</button>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php include('inc/footer.php'); ?>