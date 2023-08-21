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
    <h1 class="request-title text-bold">TODO Requests</h1>
    <hr class="">

    <table id="all_request" class="table table-striped dt-responsive nowrap" style="width:100%">
        <thead class="table-dark">
            <tr>
                <th>Request ID</th>
                <th>Dept/section</th>
                <th>Guest Name</th>
                <th>Created By</th>
                <th>Date Created</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $whitelistRequests = $request->getAllWhilelistRequests();
            if ($whitelistRequests) {
                foreach ($whitelistRequests as $request) {
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
                        <td><span class="badge <?= $statusClass ?>"><?= $request['status'] ?></span></td>
                        <td>
                            <a href="post.php?id=<?= $request['request_id'] ?>" class="text-success">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                            <a href="whilelist_action.php?id=<?= $request['id'] ?>" data-bs-toggle="modal"
                                data-bs-target="#exampleDeleteModal<?php $request['id'] ?>">
                                <i class="fa fa-toggle-on text-danger" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    <?php

                    include 'controls/setwhilelstStatus.php';
                }
            } else {

            }
            ?>
        </tbody>

        <tfoot>
            <tr>
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