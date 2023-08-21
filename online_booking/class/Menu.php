<?php

class Menu
{
    private $db;
    private $id;
    private $name;
    private $description;
    private $price;
    private $category_id;
    private $image;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }
    public function addMenuItem()
    {
        // Prepare and execute the SQL statement
        $stmt = $this->db->getConnection()->prepare("INSERT INTO menu (name, description, price, category_id, image) VALUES (?, ?, ?, ?, ?)");
        $imagePath = $this->uploadImage(); // Get the uploaded image path
        $stmt->bind_param("ssdss", $this->name, $this->description, $this->price, $this->category_id, $imagePath);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return ['success' => true, 'message' => 'Menu item added successfully.'];
        } else {
            return ['success' => false, 'message' => 'Error adding menu item.'];
        }
    }
    
    private function uploadImage()
    {
        $targetDirectory = "menuImage/"; // Specify the directory where the image will be uploaded
        $targetFile = $targetDirectory . basename($this->image['name']); // Get the path of the uploaded file
    
        // Check if the file is a valid image
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $allowedExtensions)) {
            return ""; // Return an empty string if the file is not a valid image
        }
    
        // Move the uploaded file to the target directory
        move_uploaded_file($this->image['tmp_name'], $targetFile);
    
        return $targetFile; // Return the file path of the uploaded image
    }
    


    public function getMenuItemById($menuItemId)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM menu WHERE id = ?");
        $stmt->bind_param("i", $menuItemId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $menuItem = $result->fetch_assoc();
            return $menuItem;
        }

        return null; // No menu item found
    }

    public function updateMenuItemById()
    {
        // Prepare and execute the SQL statement
        $stmt = $this->db->getConnection()->prepare("UPDATE menu SET name = ?, description = ?, price = ?, category_id = ?, image = ? WHERE id = ?");
        $imagePath = $this->uploadImage(); // Get the uploaded image path
        $stmt->bind_param("ssdssi", $this->name, $this->description, $this->price, $this->category_id, $imagePath, $this->id);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    

    public function deleteMenuItemById($menuItemId)
    {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM menu WHERE id = ?");
        $stmt->bind_param("i", $menuItemId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllMenuItems()
    {
        $query = "SELECT * FROM menu ORDER BY id DESC";
        $result = $this->db->getConnection()->query($query);

        if ($result && $result->num_rows > 0) {
            $menuItems = array();

            while ($row = $result->fetch_assoc()) {
                $menuItems[] = $row;
            }

            return $menuItems;
        }

        return false; // No menu items found
    }



    
    public function getCategories()
    {
        $query = "SELECT * FROM menu_category";
        $result = $this->db->getConnection()->query($query);

        if ($result && $result->num_rows > 0) {
            $categories = array();

            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }

            return $categories;
        }

        return false; // No categories found
    }
    // Other methods for fetching, updating, and deleting menu items go here


    
    public function getBreakfast()
    {
        $query = "SELECT name FROM menu WHERE category_id = 1"; // Assuming category_id 1 represents breakfast
        $result = $this->db->getConnection()->query($query);

        $options = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $options[] = $row;
            }
        }

        return $options;
    }




    public function generateBreakfastMenuOptions()
    {
        $query = "SELECT * FROM menu WHERE category_id = 1"; // Assuming category_id 1 represents breakfast
        $result = $this->db->getConnection()->query($query);

        $options = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $options[] = $row;
            }
        }

        return $options;
    }
    public function fetchLunchOptions()
    {
        $query = "SELECT * FROM menu WHERE category_id = 2"; // Assuming category_id 1 represents breakfast
        $result = $this->db->getConnection()->query($query);

        $options = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $options[] = $row;
            }
        }

        return $options;
    }

    // Method to fetch dinner menu options
    public function fetchDinnerOptions()
    {
        $query = "SELECT * FROM menu WHERE category_id = 3"; // Assuming category_id 3 represents dinner
        $result = $this->db->getConnection()->query($query);
    
        $options = array();
    
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $options[] = $row;
            }
        }
    
        return $options;
    }
    

}
?>
