<?php
include 'init.php';
$pageTitle = "Department";
include('inc/header.php');

if (!isset($_SESSION['user_id'])) {
  // Redirect the user to the login page or any other desired page
  header('Location: login.php');
  exit();
}

include('inc/nav.php');


?>



<!-- DAtatable -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
<?php
$department = new Department($database);


$alert = isset($_GET['alert']) ? $_GET['alert'] : '';



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

<div class="container px-3 pt-3">
  <h1 class="request-title text-bold">Department</h1>
  <hr>
  <div class="add-btn mb-4">
    <button type="submit" class="btn btn-success p-2 float-right shadow-none border-0" data-bs-toggle="modal"
      data-bs-target="#departmentModal">
      ADD NEW <span><i class="fa fa-plus" aria-hidden="true"></i></span>
    </button>
  </div>
  <table id="department" class="table  table table-striped dt-responsive nowrap" style="width:100%">
    <thead class="table-dark">
      <tr>
        <th>Dept ID</th>
        <th>Dept/section</th>
        <th>Status</th>
        <th>Actions</th>

      </tr>
    </thead>
    <?php
    $departments = $department->getDepartments();
    if ($departments) {

      foreach ($departments as $dept) {
        $statusLabel = getStatusLabel($dept['status']);
        $toggleColor = ($dept['status'] == 1) ? 'text-success' : 'text-danger';
        ?>
        <tbody>
          <tr>
            <td>
              <?= $dept['id'] ?>
            </td>
            <td>
              <?= $dept['name'] ?>
            </td>
            <td>
              <?= getStatusLabel($dept['status']) ?>
            </td>
            <td class="text-decoration-none actions">
              <a href="department_action.php?=<?php $dept['id'] ?>" data-bs-toggle="modal"
                data-bs-target="#editdepartmentModal<?php echo $dept['id'] ?>">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </a>

              <a href="department_action.php?=<?php $dept['id'] ?>" data-bs-toggle="modal"
                data-bs-target="#exampleDeleteModal<?php echo $dept['id'] ?>">
                <i class="fa fa-toggle-on <?= $toggleColor ?>" aria-hidden="true"></i>
              </a>
            </td>
          </tr>
        </tbody>


        <?php
        include 'controls/update_department.php';
        include 'controls/delete_department.php';
      }

    } else {

    }

    // Function to get the corresponding status label
    function getStatusLabel($status)
    {
      $statusColors = [
        0 => 'text-danger',
        1 => 'text-success'
      ];

      return isset($statusColors[$status]) ? "<span class='" . $statusColors[$status] . "'>" . getStatusText($status) . "</span>" : 'Unknown';
    }

    // Function to get the corresponding status text
    function getStatusText($status)
    {
      return $status == 1 ? "Active" : "Disabled";
    }
    ?>
    <tfoot>
      <tr>
        <th>Dept ID</th>
        <th>Dept/section</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </tfoot>
  </table>


</div>
</div>



<!-- Add department Modal -->
<div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="department_action.php">
          <div class="form-outline">
            <label class="form-label" for="form6Example1">Department</label>
            <input type="text" id="form6Example2" class="form-control shadow-none" placeholder="Enter Department"
              name="name" required />


          </div>
          <div class="form-outline">
            <label class="form-label" for="form6Example1">Status</label>
            <select class="form-select shadow-none" aria-label="Default select example" id="status" name="status"
              required>
              <option value="1">Active</option>
              <option value="0">Disable</option>
            </select>

          </div>
          <div class="form-outline d-grid gap-2 py-2">
            <input type="submit" name="save" id="save" class="btn btn-primary" value="Save" />
          </div>

        </form>
      </div>

    </div>
  </div>
</div>





<script src="script/department.js"></script>
<!-- datatable -->
<script defer src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script defer src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script defer src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

<?php include('inc/footer.php'); ?>