<?php



include 'init.php';

// Create a new Menu instance
$menu = new Menu($database);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve menu item details from the form
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category_id = $_POST["category_id"];
    $image = $_FILES["image"];

    // Set menu item details
    $menu->setName($name);
    $menu->setDescription($description);
    $menu->setPrice($price);
    $menu->setCategoryId($category_id);
    $menu->setImage($image);

    if (isset($_POST['save'])) {
        // Add the menu item
        $result = $menu->addMenuItem();
    } elseif (isset($_POST['update'])) {
        // Retrieve the menu item ID from the form
        $menuItemId = $_POST['id'];

        $menu->setId($menuItemId);
        $result = $menu->updateMenuItemById();

        if ($result) {
            // Redirect to the page where the data will be displayed with success alert
            header('Location: menu.php');
            exit();
        } else {
            // Redirect to the page where the data will be displayed with warning alert
            header('Location: menu.php');
            exit();
        }
    } elseif (isset($_POST['delete'])) {
        // Retrieve the menu item ID from the form
        $menuItemId = $_POST['id'];

        $result = $menu->deleteMenuItemById($menuItemId);

        if ($result) {
            // Redirect to the page where the data will be displayed with success alert
            header('Location: menu.php');
            exit();
        } else {
            // Redirect to the page where the data will be displayed with warning alert
            header('Location: menu.php');
            exit();
        }
    }

    if ($result['success']) {
        // Redirect to the page where the data will be displayed with success alert
        header('Location: menu.php?alert=success');
        exit();
    } else {
        // Redirect to the page where the data will be displayed with warning alert
        header('Location: menu.php?alert=warning');
        exit();
    }
}

// Close the connection
$database->closeConnection();


?>