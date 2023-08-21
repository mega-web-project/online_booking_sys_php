<!-- Modal -->
<div class="modal fade" id="exampledeleteEmpModal<?= $emp['id'] ?>" tabindex="-1" aria-labelledby="exampledeleteEmpModalLabel<?= $emp['id'] ?>"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h6 class="text-danger">Want to delete?</h6>
                <hr>
                <p class="lead text-secondary">Deleting this Item cannot be restored</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="employee_action.php">
                    <input type="hidden" name="employee_id" value="<?= $emp['id'] ?>" />
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>