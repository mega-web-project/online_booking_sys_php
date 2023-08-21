<!-- delete modal -->
<!-- Modal -->
<div class="modal fade" id="exampleDeleteModal<?php $request['id'] ?>" tabindex="-1"
  aria-labelledby="exampleDeleteModalLabel<?php $request['id'] ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h6 class="text-danger">Are You done?</h6>
        <hr>
        <p class="lead text-secondary">The action will remove the request, since you are done.</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="whilelist_action.php">
          <input type="hidden" name="id" value="<?php echo $request['id'] ?>" />
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="update">Done</button>
        </form>
      </div>
    </div>
  </div>
</div>