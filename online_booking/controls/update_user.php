<!-- edit user account -->
<div class="modal fade" id="edituserModal<?php echo $user['id'] ?>" tabindex="-1"
  aria-labelledby="edituserModal<?php echo $user['id'] ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="user_action.php" method="post">
          <input type="hidden" name="id" value="<?php echo $user['id'] ?>" />
          <div class="form-outline">
            <label class="form-label" for="form6Example1">Enter Fullname</label>
            <input type="text" id="form6Example2" class="form-control shadow-none" value="<?php echo $user['name'] ?>"
              name="username" />

          </div>
          <div class="form-outline">
            <label class="form-label" for="form6Example1">Email</label>
            <input type="email" id="form6Example2" class="form-control shadow-none" value="<?php echo $user['email'] ?>"
              name="email" />

          </div>
          <div class="form-outline">
            <label class="form-label" for="form6Example1">Department</label>
            <select class="form-select shadow-none" aria-label="Default select example" name="department">
              <?php
              $department = new Department($database); // Create an instance of the Department class
              $departments = $department->getDepartments(); // Fetch the departments
              
              if ($departments) {
                foreach ($departments as $dept) {
                  $selected = ($dept['id'] == $user['department_id']) ? 'selected' : ''; // Check if the department is selected
                  echo '<option value="' . $dept['id'] . '" ' . $selected . '>' . $dept['name'] . '</option>';
                }
              } else {
                echo '<option value="0">No departments found</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-outline">
            <label class="form-label" for="form6Example1">Status</label>
            <select class="form-select shadow-none" aria-label="Default select example" name="user_type">
              <option value="admin" <?php if ($user['user_type'] == 'admin') echo 'selected'; ?>>Admin</option>
              <option value="approver" <?php if ($user['user_type'] == 'approver') echo 'selected'; ?>>Approver</option>
              <option value="user" <?php if ($user['user_type'] == 'user') echo 'selected'; ?>>User</option>
            </select>

          </div>
          <div class="form-outline d-grid gap-2 py-2">
            <input type="submit" name="update" id="update" class="btn btn-primary" value="update" />
          </div>

        </form>
      </div>

    </div>
  </div>
</div>