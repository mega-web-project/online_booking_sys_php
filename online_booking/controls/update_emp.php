<!-- edit user account -->
<div class="modal fade" id="exampleUpdateEmpModal<?= $emp['id'] ?>" tabindex="-1" aria-labelledby="exampleUpdateEmpModalLable<?= $emp['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="employee_action.php" method="post">
                <input type="hidden" name="employee_id" value="<?= $emp['id'] ?>" />
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">EMP CODE</label>
                        <input type="number" id="form6Example2" class="form-control shadow-none" value="<?= $emp['emp_code'] ?>"
                            name="emp_code" />

                    </div>
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">FULLNAME</label>
                        <input type="text" id="form6Example2" class="form-control shadow-none"
                           value="<?= $emp['emp_name'] ?>" name="emp_name" />
                    </div>
                    <div class="form-outline d-grid gap-2 py-2">
                         <input type="submit" name="update" id="update" class="btn btn-primary" value="Update Menu" />
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>