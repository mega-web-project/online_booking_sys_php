

<!-- Edit department Modal -->
<div class="modal fade" id="editdepartmentModal<?php echo $dept['id']?>" tabindex="-1" aria-labelledby="editdepartmentModal<?php echo $dept['id']?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="department_action.php">
        <input type="hidden" name="id" value="<?php echo $dept['id']?>"/>
          <div class="form-outline">
            <label class="form-label" for="form6Example1">Department</label>
            <input type="text" id="form6Example2" class="form-control shadow-none"
               name="name" value="<?php echo $dept['name']?>"/>

          </div>
          <div class="form-outline">
            <label class="form-label" for="form6Example1">Status</label>
            <select class="form-select shadow-none" aria-label="Default select example" name="status" value="<?php echo $dept['status']?>">
              <option value="1">Active</option>
              <option value="0">Disable</option>
            </select>

          </div>
          <div class="form-outline d-grid gap-2 py-2">
            <input type="submit" name="update" id="update" class="btn btn-primary" value="Save" />
          </div>

        </form>
      </div>

    </div>
  </div>
</div>

