<?php
include 'init.php';
$pageTitle = "Club House Booking| Dashboard";
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
  <strong>Error!</strong> ' . $_SESSION['error_message'] . '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    unset($_SESSION['error_message']); // Remove the error message from session
}


$employees = $employee->getEmployees();

?>


<!-- DAtatable -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">


<div class="container px-3 pt-4">
    <h1 class="request-title text-bold">Employees</h1>
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
                <th>#</th>
                <th>EMP CODE</th>
                <th>EMP NAME</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            if ($employees) {

                foreach ($employees as $emp) {
                    ?>
                    <tr>
                        <td><?= $emp['id'] ?></td>
                        <td><?= $emp['emp_code'] ?></td>
                        <td><?= $emp['emp_name'] ?></td>
                        <td class="text-decoration-none actions">

                            <a href="employee_action.php<?= $emp['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleUpdateEmpModal<?= $emp['id'] ?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a href="employee_action.php<?= $emp['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampledeleteEmpModal<?= $emp['id'] ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                    include "controls/delete_emp.php";
                    include "controls/update_emp.php";
                }

            } else {

            }
            ?>
                </tbody>
                <tfoot>
                    <tr>
                        
                <th>#</th>
                <th>EMP CODE</th>
                <th>EMP NAME</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>





<!-- create user account -->
<!-- edit user account -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="employee_action.php" method="post">
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">EMP CODE</label>
                        <input type="number" id="form6Example2" class="form-control shadow-none" placeholder="Emp_code"
                            name="emp_code" required />

                    </div>
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">FULLNAME</label>
                        <input type="text" id="form6Example2" class="form-control shadow-none"
                            placeholder="Employee fulname" name="emp_name" required />
                    </div>
                    <div class="form-outline d-grid gap-2 py-2">
                        <input type="submit" name="save" id="save" class="btn btn-primary" value="Save" />
                    </div>

                </form>
                <div class="form-outline">
                    <p>Or Upload emp details</p>
                </div>
                <form action="employee_action.php" method="post" enctype="multipart/form-data">
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">select file</label>
                        <input type="file" id="form6Example2" class="form-control shadow-none"
                            placeholder="example@gmail.com" name="excel_file" required />
                    </div>


                    <div class="form-outline d-grid gap-2 py-2">
                        <input type="submit" name="upload" id="upload" class="btn btn-primary" value="upload" />
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