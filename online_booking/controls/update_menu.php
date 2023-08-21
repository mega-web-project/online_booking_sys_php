<div class="modal fade" id="exampleMenuUpdateModal<?= $menu['id'] ?>" tabindex="-1" aria-labelledby="exampleMenuUpdateModalLabel<?= $menu['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="menu_action.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $menu['id'] ?>" />
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Enter Food</label>
                        <input type="text" id="form6Example2" class="form-control shadow-none" value="<?php echo $menu['name'] ?>" name="name" />
                    </div>

                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Category</label>
                        <select class="form-select shadow-none" aria-label="Default select example" name="category_id">
                            <option selected>Select Category</option>
                            <option value="1" <?php if ($menu['category_id'] == 1) echo 'selected'; ?>>Breakfast</option>
                            <option value="2" <?php if ($menu['category_id'] == 2) echo 'selected'; ?>>Lunch</option>
                            <option value="3" <?php if ($menu['category_id'] == 3) echo 'selected'; ?>>Dinner</option>
                        </select>
                    </div>

                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Upload photo</label>
                        <input type="file" id="form6Example2" class="form-control shadow-none" name="image" value="<?php echo $menu['image'] ?>" required/>
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="form6Example7">Description</label>
                        <textarea class="form-control shadow-none" id="form6Example7" rows="4" placeholder="Add Description to the food" name="description"><?php echo $menu['description'] ?></textarea>
                    </div>

                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Price</label>
                        <input type="number" id="form6Example2" class="form-control shadow-none" name="price" value="<?php echo $menu['price'] ?>" />
                    </div>

                    <div class="form-outline d-grid gap-2 py-2">
                        <input type="submit" name="update" id="update" class="btn btn-primary" value="Update Menu" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
