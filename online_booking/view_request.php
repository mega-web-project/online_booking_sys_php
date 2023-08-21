<?php
include 'init.php';
$pageTitle = "All Requests";
include('inc/header.php');

include('inc/nav.php');
$user_id = $_SESSION['user_id'];


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
  <strong>Error!</strong> ' . $_SESSION['error_message'] . '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    unset($_SESSION['error_message']); // Remove the error message from session
}

?>

<!-- DAtatable -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">

<div class="container px-3 pt-4">
    <h1 class="request-title text-bold">All Requests</h1>
    <hr class="">
    <?php if ($_SESSION['user_type'] == 'admin'):?>
    <div class="filter">
        <div class="container">
            <form action="export.php" method="POST">
                <div class="row mb-4">
                    <div class="col-md-3 mb-1">
                        <div class="form-outline">
                            <label class="form-label" for="start-date">Start Date:</label>
                            <input type="date" id="start_date" class="form-control shadow-none"
                                name="start_date" required />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-outline">
                            <label class="form-label" for="end-date">End Date:</label>
                            <input type="date" id="end-date" class="form-control shadow-none" name="end_date"
                                required />
                        </div>
                    </div>
                    <div class="col-md-3">
                    <label class="form-label pt-1" for="export">Export</label>
                        <div class="form-outline">
                            <input type="submit" class="btn btn-secondary shadow-none" name="export_pdf" value="PDF">
                            <input type="submit" class="btn btn-success shadow-none" name="export_csv" value="csv">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php endif;?>


    <table id="all_request" class="table  table table-striped dt-responsive nowrap" style="width:100%">
        <thead class="table-dark">
            <tr>
                <th>S/N</th>
                <th>Request ID</th>
                <th>Dept/section</th>
                <th>Guest Name</th>
                <th>Created By</th>
                <th>Date Created</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <?php if ($_SESSION['user_type'] == 'admin' || $_SESSION['user_type'] == 'approver'): ?>
            <tbody>
                <?php
                $requests = $request->getAllRequests();
                if ($requests) {
                    foreach ($requests as $request) {
                        $statusClass = '';
                        if ($request['status'] === 'Pending') {
                            $statusClass = 'bg-warning text-dark';
                        } elseif ($request['status'] === 'Rejected') {
                            $statusClass = 'bg-danger text-white';
                        } elseif ($request['status'] === 'Approved') {
                            $statusClass = 'bg-success text-white';
                        } elseif ($request['status'] === 'Processing') {
                            $statusClass = 'bg-secondary text-white';
                        }
                        ?>
                        <tr>
                            <td>
                                <?= $request['id'] ?>
                            </td>
                            <td>
                                <?= $request['uniqid'] ?>
                            </td>
                            <td>
                                <?= $request['requester_department'] ?>
                            </td>
                            <td>
                                <?= $request['guest_name'] ?>
                            </td>
                            <td>
                                <?= $request['requester_name'] ?>
                            </td>
                            <td>
                                <?= $request['created_at'] ?>
                            </td>
                            <td>
                                <span class="badge <?= $statusClass ?>"><?= $request['status'] ?></span>
                            </td>
                            <td class="text-decoration-none actions">
                                <a href="post.php?id=<?= $request['id'] ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a href="edit_request.php?id=<?= $request['id'] ?>">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <?php if ($_SESSION['user_type'] == 'admin'): ?>
                                    <a href="whilelist_action.php?id=<?= $request['id'] ?>" data-toggle="tooltip" data-placement="left"
                                        title="whilelist">
                                        <i class="fa fa-shopping-cart text-success" aria-hidden="true"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $request['id'] ?>" disabled>
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        <?php

                        include 'controls/delete_request.php';
                    }
                } else {
                    ?>

                <?php
                }
                ?>
            </tbody>

        <?php else: ?>
            <tbody>
                <?php
                $requesterId = $_SESSION['user_id']; // Assuming 'user_id' is the key where the requester_id is stored during login
                if ($requesterId) {
                    // Now you have the $requesterId, you can use the getRequestsByRequesterId function
                    $requests = $request->getRequestsByRequesterId($requesterId);
                    // Rest of the code to display the requests
                } else {
                    echo "Invalid requester ID.";
                }

                $requests = $request->getRequestsByRequesterId($requesterId);
                if ($requests) {
                    foreach ($requests as $request) {
                        $statusClass = '';
                        if ($request['status'] === 'Pending') {
                            $statusClass = 'bg-warning text-dark';
                        } elseif ($request['status'] === 'Rejected') {
                            $statusClass = 'bg-danger text-white';
                        } elseif ($request['status'] === 'Approved') {
                            $statusClass = 'bg-success text-white';
                        } elseif ($request['status'] === 'Processing') {
                            $statusClass = 'bg-secondary text-white';
                        }
                        ?>
                        <tr>
                        <td>
                                <?= $request['id'] ?>
                            </td>
                            <td>
                                <?= $request['uniqid'] ?>
                            </td>
                            <td>
                                <?= $request['requester_department'] ?>
                            </td>
                            <td>
                                <?= $request['guest_name'] ?>
                            </td>
                            <td>
                                <?= $request['requester_name'] ?>
                            </td>
                            <td>
                                <?= $request['created_at'] ?>
                            </td>
                            <td>
                                <span class="badge <?= $statusClass ?>"><?= $request['status'] ?></span>
                            </td>
                            <td class="text-decoration-none actions">
                                <a href="post.php?id=<?= $request['id'] ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a href="edit_request.php?id=<?= $request['id'] ?>">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $request['id'] ?>">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        <?php

                        include 'controls/delete_request.php';
                    }


                } else {
                    ?>

                <?php
                }
                ?>
            </tbody>

        <?php endif; ?>
        <tfoot>
            <tr>
                <th>S/N</th>
                <th>Request ID</th>
                <th>Dept/section</th>
                <th>Guest Name</th>
                <th>Date Created</th>
                <th>Created By</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>

</div>

<!-- datatable -->
<script defer src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script defer src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script defer src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

<?php include('inc/footer.php'); ?>