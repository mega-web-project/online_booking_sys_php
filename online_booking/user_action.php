<?php
include 'init.php';

// Create a new User instance
$user = new User($database);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        // Retrieve the form data
        $name = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $departmentId = $_POST['department'];
        $userType = $_POST['user_type'];
        $tel = $_POST['tel'];

        // Set the user properties
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setDepartmentId($departmentId);
        $user->setUserType($userType);
        $user->setTel($tel);

        // Add the user
        $result = $user->addUser();

        if ($result['success']) {
            // Redirect to the page where the data will be displayed with success alert
            header('Location: users.php');
            exit();
        } else {
            // Redirect to the page where the data will be displayed with warning alert
            header('Location: users.php');
            exit();
        }
    } elseif (isset($_POST['update'])) {
        // Retrieve the form data
        $userId = $_POST['id'];
        $name = $_POST['username'];
        $email = $_POST['email'];
        $departmentId = $_POST['department'];
        $userType = $_POST["user_type"];

        // Set the user properties
        $user->setId($userId);
        $user->setName($name);
        $user->setEmail($email);
        $user->setDepartmentId($departmentId);
        $user->setUserType($userType);


        // Update the user
        $result = $user->updateUserById();

        if ($result) {
            // Redirect to the page where the data will be displayed with success alert
            header('Location: users.php');
            exit();
        } else {
            // Redirect to the page where the data will be displayed with warning alert
            header('Location: users.php');
            exit();
        }
    } elseif (isset($_POST['update_profile'])) {
        $userId = $_SESSION['user_details']['id'];
        $name = $_POST['username'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];

        // Set the user properties
        $user->setId($userId);
        $user->setName($name);
        $user->setEmail($email);
        $user->setTel($tel);

        // Handle profile image upload
        if (isset($_FILES['picture'])) {
            $file = $_FILES['picture'];

            // Check if a file is selected
            if ($file['name'] !== '') {
                // Set the target directory to store the uploaded image
                $targetDir = 'profile_images/';

                // Generate a unique file name
                $fileName = uniqid() . '_' . basename($file['name']);
                $targetFile = $targetDir . $fileName;

                // Check if the file is valid and move it to the target directory
                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    // Set the profile image path
                    $profileImage = $targetFile;

                    // Update the profile image in the database
                    $user->setProfileImage($profileImage);
                } else {
                    // Handle the error if the file upload fails
                    $_SESSION['error_update'] = "Error uploading profile image";
                    header('Location: profile.php');
                    exit();
                }
            }
        }

        // Update the user's profile
        $result = $user->updateUserProfile($name, $email, $profileImage, $tel);

        if ($result) {
            $_SESSION['msg_update'] = "Successfully updated profile";
        } else {
            $_SESSION['error_update'] = "Error updating profile";
        }

        // Redirect to the page where the data will be displayed
        header('Location: profile.php');
        exit();
    } elseif (isset($_POST['delete'])) {
        // Retrieve the user ID from the form data
        $userId = $_POST['id'];

        // Delete the user
        $result = $user->deleteUserById($userId);

        if ($result['success']) {
            // Redirect to the page where the data will be displayed with success alert
            header('Location: users.php');
            exit();
        } else {
            // Redirect to the page where the data will be displayed with warning alert
            header('Location: users.php');
            exit();
        }
    } elseif (isset($_POST['login'])) {
        // Retrieve the form data
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Call the login function
        $loginResult = $user->login($email, $password);

        if ($loginResult === true) {
            // Redirect to the dashboard or any other page after successful login
            header('Location:index.php');
            exit();
        } else {
            // Redirect to the login page with an error message
            $errorMessage = $loginResult;
            header('Location: login.php?error=1');

            exit();
        }
    } elseif (isset($_POST['reset_password'])) {
        $email = $_POST['email'];


        // Initiate password reset
        $result = $user->initiatePasswordReset($email);

        if ($result) {
            $message = "Password reset initiated. Check your email for further instructions.";
        } else {
            $message = "Failed to initiate password reset. Please try again later.";
        }
    } elseif (isset($_POST['Reset'])) {
        // Retrieve the form data
        $email = $_POST['email'];
        $newPassword = $_POST['Newpassword'];

        // Call the updatePassword function
        $updateResult = $user->updatePassword($email, $newPassword);

        if ($updateResult) {
            // Password update successful
            header('Location: reset_msg.php');
            $message = "Password updated successfully.";
        } else {
            // Password update failed
            header('Location: reset_msg.php');
            $message = "Failed to update the password.";
        }

    } elseif (isset($_POST['logout'])) {
        // Log out the user
        $user->logout();

        // Redirect to the login page or any other desired page
        header('Location: login.php');
        exit();
    } elseif (isset($_POST['logout'])) {
        // Log out the user
        $user->logout();

        // Redirect to the login page or any other desired page
        header('Location: login.php');
        exit();
    }




    // Call the countUsers() function to get the total number of users

    // Retrieve the user count from the database
    $userCount = $user->countUsers();

    // Store the user count in the session
    $_SESSION['total_users'] = $userCount;


}
?>