<?php
include 'init.php';
$pageTitle = "Users |Page";
include('inc/header.php');
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or any other desired page
    header('Location: login.php');
    exit();
}

include('inc/nav.php');


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

    <h1 class="request-title text-bold">System Users</h1>
    <hr>
    <div class="add-btn mb-4">
        <button type="submit" class="btn btn-success p-2 float-right shadow-none border-0" data-bs-toggle="modal"
            data-bs-target="#userModal">
            ADD NEW <span><i class="fa fa-plus" aria-hidden="true"></i></span>
        </button>
    </div>
    <table id="users" class="table  table table-striped dt-responsive nowrap" style="width:100%">
        <thead class="table-dark">
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Dept/Section</th>
                <th>User Type</th>
                <th>Joined Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $users = $user->getUsers();
            if ($users) {

                foreach ($users as $user) {
                    ?>
                    <tr>
                        <td>
                            <?= $user['id'] ?>
                        </td>
                        <td>
                            <?= $user['name'] ?>
                        </td>
                        <td>
                            <?= $user['email'] ?>
                        </td>
                        <td>
                            <?= $user['department_name'] ?>
                        </td>
                        <td>
                            <?= $user['user_type'] ?>
                        </td>
                        <td>
                            <?= $user['createddate'] ?>
                        </td>
                        <td class="text-decoration-none actions">

                            <a href="user_action.php?=<?php $user['id'] ?>" data-bs-toggle="modal"
                                data-bs-target="#edituserModal<?php echo $user['id'] ?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a href="user_action.php?=<?php $user['id'] ?>" data-bs-toggle="modal"
                                data-bs-target="#exampleDeleteUserModal<?php echo $user['id'] ?>" >
                                <i class="fa fa-trash" aria-hidden="true" ></i>
                            </a>
                        </td>
                    </tr>
                    <?php

                    include 'controls/update_user.php';


                    include 'controls/delete_user.php';
                }

            } else {

            }
            ?>
        </tbody>



        <tfoot>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Dept/Section</th>
                <th>User Type</th>
                <th>Joined Date</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
</div>

<?php
// Assuming you have a method in your Database class to retrieve departments
$departments = $department->getDepartments()
?>
<!-- create user account -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="user_action.php" method="POST">
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Enter Fullname</label>
                        <input type="text" id="form6Example2" class="form-control shadow-none" placeholder="Fullname"
                            name="username" />

                    </div>
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Email</label>
                        <input type="email" id="form6Example2" class="form-control shadow-none"
                            placeholder="example@gmail.com" name="email" />

                    </div>
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Contact/Tel</label>
                        <input type="text" id="form6Example2" class="form-control shadow-none"
                            placeholder="example@gmail.com" name="tel" />

                    </div>

                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Department</label>
                        <select class="form-select shadow-none" aria-label="Default select example" name="department">
                            <?php foreach ($departments as $department) { ?>
                                <?php if ($department['status'] == 1) { ?>
                                    <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>

                                <?php } ?>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Create Password</label>
                        <input type="password" id="form6Example2" class="form-control shadow-none" name="password"
                            placeholder="password" />
                    </div>
                    <div class="form-outline mb-3">
                        <label class="form-label" for="form6Example1">User Type</label>
                        <select class="form-select shadow-none" aria-label="Default select example" name="user_type">
                            <option value="admin">Admin</option>
                            <option value="approver">Approver</option>
                            <option value="user">user</option>

                        </select>

                    </div>

                    <div class="form-outline d-grid gap-2 py-2">
                        <input type="submit" value="Create User" class="btn btn-primary " name="register">
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>




<!-- datatable -->
<script defer src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script defer src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script defer src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

<?php include('inc/footer.php'); ?>