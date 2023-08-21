<?php
include 'init.php';
$pageTitle = "Menu |Page";
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


<!-- top nav ends -->

<div class="container px-3 pt-4">
    <h1 class="request-title text-bold">Manage Menu</h1>
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
                <th>Food ID</th>
                <th>Category</th>
                <th>Food Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            function getCategoryName($categoryId)
            {
                switch ($categoryId) {
                    case 1:
                        return 'Breakfast';
                    case 2:
                        return 'Lunch';
                    case 3:
                        return 'Dinner';
                    default:
                        return 'Unknown';
                }
            }
            
            $menus = $menu->getAllMenuItems();
            if ($menus) {

                foreach ($menus as $menu) {
                    ?>
                    <tr>
                        <td> <?= $menu['id'] ?></td>
                        <td><?= getCategoryName($menu['category_id']) ?></td>
                        <td><?= $menu['name'] ?></td>
                        <td><?= $menu['description'] ?></td>
                        <td>&#x20B5; <?= $menu['price'] ?></td>
                        <td class="text-decoration-none actions">

                            <a href="menu_action.php<?= $menu['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleMenuUpdateModal<?= $menu['id'] ?>">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a href="menu_action.php<?= $menu['id'] ?>" data-bs-toggle="modal" data-bs-target="#exampleMenuDeleteModal<?= $menu['id'] ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                    include 'controls/update_menu.php';
                    include 'controls/delete_menu.php';
                }

            } else {

            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Food ID</th>
                <th>Category</th>
                <th>Food Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
</div>




<!-- create user account -->

<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="menu_action.php" method="post" enctype="multipart/form-data">
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Enter Food</label>
                        <input type="text" id="form6Example2" class="form-control shadow-none" placeholder="Enter Food"
                            name="name" />

                    </div>

                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Category</label>
                        <select class="form-select shadow-none" aria-label="Default select example" name="category_id">
                            <option selected>Select Category</option>
                            <?php
                            $menu = new Menu($database); // Instantiate the Menu class
                            $categories = $menu->getCategories(); // Retrieve categories
                            foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Upload photo</label>
                        <input type="file" id="form6Example2" class="form-control shadow-none" name="image" />
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form6Example7">Description</label>
                        <textarea class="form-control shadow-none" id="form6Example7" rows="4"
                            placeholder="Add Description to the food" name="description"></textarea>

                    </div>
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Price</label>
                        <input type="number" id="form6Example2" class="form-control shadow-none" name="price"
                            placeholder="price" />
                    </div>


                    <div class="form-outline d-grid gap-2 py-2">
                        <input type="submit" name="save" id="save" class="btn btn-primary" value="Add Menu" />
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