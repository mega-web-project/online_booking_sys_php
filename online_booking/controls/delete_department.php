<!-- delete modal -->
<!-- Modal -->
<div class="modal fade" id="exampleDeleteModal<?php echo $dept['id'] ?>" tabindex="-1"
  aria-labelledby="exampleDeleteModalLabel<?php echo $dept['id'] ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h6 class="text-danger">Want to Disable?</h6>
        <hr>
        <p class="lead text-secondary">The action will disable the department</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="department_action.php">
          <input type="hidden" name="id" value="<?php echo $dept['id'] ?>" />
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger" name="toggle">Disable</button>
        </form>
      </div>
    </div>
  </div>
</div>