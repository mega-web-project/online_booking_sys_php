<?php
$user = new User($database);
$userCount = $user->countUsers();
// Check if the user count is stored in the session
if (isset($_SESSION['total_users'])) {
    $userCount = $_SESSION['total_users'];
} else {
    $userCount = 0; // Default value if the user count is not set
}
?>

<div class="row row-cols-1 row-cols-md-3 g-4 mb-4 pb-4">
    <div class="col-md-4 col-sm-12">
        <div class="card bg-info text-white border-3 shadow-1">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title" style="font-size:58px;">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </h5>
                    </div>
                    <div class="col">
                        <p class="card-text display-5">
                            <?php echo $userCount; ?>
                        </p>
                        <span><b>Users <span><a href="users.php"
                                        class="btn btn-secondary text-white btn-sm">view</a></span></b></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card bg-info text-white border-3 shadow-1">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title" style="font-size:58px;">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                        </h5>
                    </div>
                    <div class="col">
                        <p class="card-text display-5">
                            <?php
                            $totalRequests = $request->countAllRequests();
                            ?>
                            <?= $totalRequests ?>
                        </p>
                        <span>Request <span><a href="view_request.php"
                                    class="btn btn-secondary btn-sm text-white">view</a></span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card bg-info text-white border-3 shadow-1">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title" style="font-size:58px;">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </h5>
                    </div>
                    <div class="col">
                        <p class="card-text display-5">
                            <?php
                            $numPendingRequests = $request->countAllPendingRequests();
                            ?>
                            <?= $numPendingRequests ?>
                        </p>
                        <span>Not Approved <span><a href="view_request.php"
                                    class="btn btn-secondary btn-sm text-white">view</a></span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent request -->
<div class="text-head">
    <div class="h-3">
        <h3>Recent Request</h3>
    </div>
</div>

<table id="all_request" class="table table-striped dt-responsive nowrap" style="width:100%">
    <thead class="table-dark">
        <tr>
            <th>User ID</th>
            <th>Dept/section</th>
            <th>Guest Name</th>
            <th>Date Created</th>
            <th>Elapse Time</th>
            <th>Created By</th>
           
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $recents = $request->getRecentRequests();
        if ($recents) {

            foreach ($recents as $recent) {

                $statusClass = '';
                if ($recent['status'] === 'Pending') {
                    $statusClass = 'bg-warning text-dark';
                } elseif ($recent['status'] === 'Rejected') {
                    $statusClass = 'bg-danger text-white';
                } elseif ($recent['status'] === 'Approved') {
                    $statusClass = 'bg-success text-white';
                } elseif ($recent['status'] === 'Processing') {
                    $statusClass = 'bg-secondary text-white';
                }
                ?>
                <tr>
                    <td>
                        <?= $recent['uniqid'] ?>
                    </td>
                    <td>
                        <?= $recent['requester_department'] ?>
                    </td>
                    <td>
                        <?= $recent['guest_name'] ?>
                    </td>
                    <td>
                        <?= $recent['created_at'] ?>
                    </td>

                    <td><?= $recent['elapsed_time'] ?></td>
                    <td>
                        <img src="<?= $recent['requester_image'] ?>" alt="avatar" width="40" height="40"
                            class="rounded-circle shadow-1-strong me-3" />
                        <?= $recent['requester_name'] ?>
                    </td>
                    <td>
                        <span class="badge <?= $statusClass ?>"><?= $recent['status'] ?></span>
                    </td>
                    <td class="text-decoration-none actions">
                   
                        <a href="post.php?id=<?= $recent['id'] ?>">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                   
                    <?php if ($_SESSION['user_type'] == 'admin'): ?>
                            <a href="whilelist_action.php?id=<?= $recent['id'] ?>">
                                    <i class="fa fa-shopping-cart text-success" aria-hidden="true"></i>
                            </a>
                     <?php endif;?>
                    </td>
                </tr>
                <?php
            }
        } else {
            // Handle case when no rejected requests found
            // echo "No pending requests found.";
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th>User ID</th>
            <th>Dept/section</th>
            <th>Guest Name</th>
            <th>Date Created</th>
            <th>Elapse Time</th>
            <th>Created By</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>