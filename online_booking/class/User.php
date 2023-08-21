<?php

// require 'vendor/autoload.php';
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

class User
{
    private $db;
    private $id;
    private $name;
    private $email;
    private $password;
    private $departmentId;

    private $createdDate;
    private $profileImage;
    private $userType;

    private $tel;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setUserType($userType)
    {
        $this->userType = $userType;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setDepartmentId($departmentId)
    {
        $this->departmentId = $departmentId;
    }

    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;
    }

    public function addUser()
    {
        $currentDateTime = date('Y-m-d H:i:s'); // Get the current system date and time

        // Validate password
        $passwordValidation = $this->validatePassword($this->password);
        if (!$passwordValidation['success']) {
            return ['success' => false, 'message' => 'Invalid password.', 'errors' => $passwordValidation['errors']];
        }

        // Prepare and execute the SQL statement
        $stmt = $this->db->getConnection()->prepare("INSERT INTO users (name, email, password, department_id, createddate, profile_image, user_type,tel) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $defaultProfileImage = 'assets/img/avatars.png'; // Default profile image file name

        $stmt->bind_param("ssssssss", $this->name, $this->email, $hashedPassword, $this->departmentId, $currentDateTime, $defaultProfileImage, $this->userType, $this->tel);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // User stored successfully
            // Send email to the user
            $this->sendEmail();
            $_SESSION['success_message'] = 'User added successfully.';
            return ['success' => true, 'message' => 'User has been added successfully.'];
        } else {
            $_SESSION['error_message'] = 'Error adding user';
            return ['success' => false, 'message' => 'Error adding user.'];
        }
    }
    // get user info abd department

    public function getDepartments()
    {
        $query = "SELECT * FROM departments";
        $result = $this->db->getConnection()->query($query);

        if ($result && $result->num_rows > 0) {
            $departments = array();

            while ($row = $result->fetch_assoc()) {
                $departments[] = $row;
            }

            return $departments;
        }

        return false; // No departments found
    }

    public function countUsers()
    {
        $stmt = $this->db->getConnection()->prepare("SELECT COUNT(*) AS total_users FROM users");
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $totalUsers = $data['total_users'];
    
            // Store the result in the session
            $_SESSION['total_users'] = $totalUsers;
    
            return $totalUsers;
        }
    
        return 0;
    }
    
    public function getDepartmentById($departmentId)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM departments WHERE id = ?");
        $stmt->bind_param("i", $departmentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $department = $result->fetch_assoc();
            return $department;
        }

        return null; // No department found
    }


    public function updateUserById()
    {
        // Prepare and execute the SQL statement
        $stmt = $this->db->getConnection()->prepare("UPDATE users SET name = ?, email = ?, department_id = ?, user_type = ? WHERE id = ?");
        $stmt->bind_param("ssisi", $this->name, $this->email, $this->departmentId, $this->userType, $this->id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success_message'] = 'User details has been updated successfully.';
            return ['success' => true, 'message' => 'User has been added successfully.'];
        } else {
            $_SESSION['error_message'] = 'Error updating user';
            return ['success' => false, 'message' => 'Error adding user.'];
        }
    }

    // Update profile details.
    public function updateUserProfile($name, $email, $profileImage, $tel)
    {
        // Prepare and execute the SQL statement
        $stmt = $this->db->getConnection()->prepare("UPDATE users SET name = ?, email = ?, profile_image = ?, tel = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $email, $profileImage, $tel, $this->id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {


            // Update the session variables with the new values
            $_SESSION['user_details']['name'] = $name;
            $_SESSION['user_details']['email'] = $email;
            $_SESSION['user_details']['profile_image'] = $profileImage;
            $_SESSION['user_details']['tel'] = $tel;

            $_SESSION['success_message'] = 'User details has been updated successfully.';
            return ['success' => true, 'message' => 'User has been added successfully.'];
        } else {
            $_SESSION['error_message'] = 'Error updating user';
            return ['success' => false, 'message' => 'Error adding user.'];
        }
    }


    public function deleteUserById($userId)
    {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success_message'] = 'One record successfully deleted';
            return ['success' => true, 'message' => 'User has been added successfully.'];
        } else {
            $_SESSION['error_message'] = 'Error deleting user';
            return ['success' => false, 'message' => 'Error deteting user.'];
        }
    }


//     public function toggleUserStatus($userId, $isActive)
// {
//     $stmt = $this->db->getConnection()->prepare("UPDATE users SET is_active = ? WHERE id = ?");
//     $stmt->bind_param("ii", $isActive, $userId);
//     $stmt->execute();

//     if ($stmt->affected_rows > 0) {
//         $_SESSION['success_message'] = 'User status updated successfully.';
//         return ['success' => true, 'message' => 'User status updated successfully.'];
//     } else {
//         $_SESSION['error_message'] = 'Error updating user status.';
//         return ['success' => false, 'message' => 'Error updating user status.'];
//     }
// }

    public function validateEmail()
    {
        $errors = array();

        // Check if email is valid
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }

        // Check if email is already in use
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {

            $_SESSION['success_message'] = 'Email Already exist';
            return ['success' => true, 'message' => 'Email Already exist'];
        } else {
            $_SESSION['error_message'] = 'Email Already exist';
            return ['success' => false, 'message' => 'Email Already exist'];
        
        }
    }

    public function validatePassword($password)
    {
        $errors = array();

        // Check password length
        if (strlen($password) < 8) {
            $errors[] = "Password should be at least 8 characters long.";
        }

        // Check if password contains at least one uppercase letter, one lowercase letter, and one digit
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $password)) {
            $errors[] = "Password should contain at least one uppercase letter, one lowercase letter, and one digit.";
        }

        if (empty($errors)) {
            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => $errors];
        }
    }


    // send email

    //Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function




    public function sendEmail()
    {
        // try {
        //     $mail = new PHPMailer(true);
        //     $mail->isSMTP();
        //     $mail->Host = 'smtp.gmail.com';  // Set your SMTP server address
        //     $mail->SMTPAuth = true;
        //     $mail->Username = 'fobilouisstone@gmail.com'; // Set your SMTP username
        //     $mail->Password = 'plagiarism2@'; // Set your SMTP password
        //     $mail->SMTPSecure = 'tls'; // You can also use 'ssl' if needed
        //     $mail->Port = 587; // Set the appropriate SMTP port

        //     $mail->setFrom('fobilouisstone@gmail.com', 'Club House Booking system'); // Set the sender's email address and name
        //     $mail->addAddress($this->email); // Set the recipient's email address

        //     $mail->isHTML(true);
        //     $mail->Subject = "Account Created successfully";
        //     $mail->Body ="Welcom". $this->name. "! Your account has been successfully created. use password ". $this->password. "and Email" . $this->email . "to login";

        //     $mail->send();
        //     // echo 'Message has been sent';
        // } catch (Exception $e) {
        //     // Handle the exception if something goes wrong
        //     return false;
        // }



        $to = $this->email;
        $subject = 'Club house online booking System';
        $message = 'An account has been created for you ' . $this->name . '.  Use ' . $this->email .
            ' as your username and password  [' . $this->password . ' ]. 
         Contact us for any issue, get support from Topp IT Department.';
        $headers = 'From: fobilouisstone@gmail.com ';

        if (mail($to, $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }



    // get user
    public function getUsers()
    {
        $query = "SELECT u.*, d.name AS department_name 
        FROM users u 
        LEFT JOIN departments d ON u.department_id = d.id ORDER BY id DESC";
        $result = $this->db->getConnection()->query($query);

        if ($result && $result->num_rows > 0) {
            $users = array();

            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }

            return $users;
        }

        return false; // No users found
    }

    public function login($email, $password)
    {
        // Retrieve the user record from the database based on the email
        $stmt = $this->db->getConnection()->prepare("SELECT users.*, departments.name AS department_name FROM users INNER JOIN departments ON users.department_id = departments.id WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists and the password is correct
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password'];

            // Verify the provided password against the hashed password
            if (password_verify($password, $hashedPassword)) {
                // Password is correct, set the user information in the session or generate an authentication token
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['profile_image'] = $user['profile_image'];
                $_SESSION['user_tel'] = $user['tel'];
                // Retrieve the user's department
                $departmentName = $user['department_name'];

                // Store all user information in a session variable
                $_SESSION['user_details'] = $user;
                $_SESSION['department_name'] = $departmentName;


                $tel = $user['tel'];
                $_SESSION['user_tel'] = $tel;
                return true; // Login successful
            }
        }
        $_SESSION['error'] = "Invalid email or password.";
        return false; // Login failed
    }




    // Resetting password with email
    public function initiatePasswordReset($email)
    {
        // Generate a unique token for password reset
        $token = bin2hex(random_bytes(32));

        // Store the token in the database for the user
        $stmt = $this->db->getConnection()->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            // Send the password reset email
            $to = $email;
            $subject = "Password Reset";
            $message = "Click the following link to reset your password: http://localhost/dashboard/online_booking/password_reset.php?email=" . urlencode($email) . "&token=" . urlencode($token);
            $headers = "From: Club house online Booking system\r\n";
            $headers .= "Reply-To: noreply@example.com\r\n";
            $headers .= "Content-type: text/html\r\n";

            if (mail($to, $subject, $message, $headers)) {
                header('Location: resetlink.php');
                return true; // Email sent successfully
            } else {
                return false; // Failed to send email
            }
        }

        return false; // Failed to update token in the database
    }



    public function resetPassword($email, $token, $newPassword)
    {
        // Verify the token against the one stored in the database
        $stmt = $this->db->getConnection()->prepare("SELECT id FROM users WHERE email = ? AND reset_token = ? AND reset_token_expires > NOW()");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Token is valid, update the user's password in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->db->getConnection()->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expires = NULL WHERE email = ?");
            $stmt->bind_param("ss", $hashedPassword, $email);
            $stmt->execute();

            if ($stmt->affected_rows === 1) {
                // Password reset successful
                return true;
            } else {
                // Failed to update the password
                return false;
            }
        } else {
            // Token is invalid or expired
            return false;
        }
    }
    // update password
    public function updatePassword($email, $newPassword)
    {
        // Generate a new hashed password for the new password
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $updateStmt = $this->db->getConnection()->prepare("UPDATE users SET password = ? WHERE email = ?");
        $updateStmt->bind_param("ss", $newHashedPassword, $email);
        $updateStmt->execute();

        if ($updateStmt->affected_rows > 0) {
            return true; // Password updated successfully
        }

        return false; // Password update failed
    }






    public function getUserDetails($userId)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        return $user;
    }

    public function getDepartmentName($departmentId)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT name FROM departments WHERE id = ?");
        $stmt->bind_param("i", $departmentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $department = $result->fetch_assoc();
        $stmt->close();

        return $department['name'];
    }
    public function logout()
    {
        // Start the session
        session_start();

        // Unset all session variables
        $_SESSION = [];

        // Destroy the session
        session_destroy();
    }

}



?>