<?php

class Request
{
    private $db;

    private $uniqid;
    private $guestName;
    private $guestAddress;
    private $checkInDate;
    private $checkOutDate;
    private $purposeOfVisit;
    private $breakfast;
    private $dinner;
    private $lunch;
    private $numOfPeopleForMenu;
    private $numOfPeopleForAcco;
    private $employeeNames;
    private $visitorsNames;
    private $status;
    private $rejectionMessage;
    private $requesterId;
    private $approver1;
    private $approver2;
    private $approver3;
    private $approver4;
    private $createdAt;

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }


    public function setUniqid($uniqid)
    {
        $this->uniqid = $uniqid;
    }

    public function setGuestName($guestName)
    {
        $this->guestName = $guestName;
    }

    public function setGuestAddress($guestAddress)
    {
        $this->guestAddress = $guestAddress;
    }

    public function setCheckInDate($checkInDate)
    {
        $this->checkInDate = $checkInDate;
    }

    public function setCheckOutDate($checkOutDate)
    {
        $this->checkOutDate = $checkOutDate;
    }

    public function setPurposeOfVisit($purposeOfVisit)
    {
        $this->purposeOfVisit = $purposeOfVisit;
    }

    public function setBreakfast($breakfast)
    {
        $this->breakfast = $breakfast;
    }

    public function setDinner($dinner)
    {
        $this->dinner = $dinner;
    }

    public function setLunch($lunch)
    {
        $this->lunch = $lunch;
    }

    public function setNumOfPeopleForMenu($numOfPeopleForMenu)
    {
        $this->numOfPeopleForMenu = $numOfPeopleForMenu;
    }

    public function setNumOfPeopleForAcco($numOfPeopleForAcco)
    {
        $this->numOfPeopleForAcco = $numOfPeopleForAcco;
    }

    public function setEmployeeNames($employeeNames)
    {
        $this->employeeNames = $employeeNames;
    }

    public function setVisitorsNames($visitorsNames)
    {
        $this->visitorsNames = $visitorsNames;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setRejectionMessage($rejectionMessage)
    {
        $this->rejectionMessage = $rejectionMessage;
    }

    public function setRequesterId($requesterId)
    {
        $this->requesterId = $requesterId;
    }

    public function setApprover1($approver1)
    {
        $this->approver1 = $approver1;
    }

    public function setApprover2($approver2)
    {
        $this->approver2 = $approver2;
    }

    public function setApprover3($approver3)
    {
        $this->approver3 = $approver3;
    }

    public function setApprover4($approver4)
    {
        $this->approver4 = $approver4;
    }
    public function addRequest()
    {
        $createdAt = date('Y-m-d H:i:s'); // Get the current datetime

        $stmt = $this->db->prepare("INSERT INTO requests (uniqid, guest_name, guest_address, check_in_date, check_out_date, purpose_of_visit, breakfast, dinner, lunch, num_of_people_for_menu, num_of_people_for_acco, employee_names, visitors_names, status, rejection_message, requester_id, approver1, approver2, approver3, approver4, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssssssssssssiiiiis", $this->uniqid, $this->guestName, $this->guestAddress, $this->checkInDate, $this->checkOutDate, $this->purposeOfVisit, $this->breakfast, $this->dinner, $this->lunch, $this->numOfPeopleForMenu, $this->numOfPeopleForAcco, $this->employeeNames, $this->visitorsNames, $this->status, $this->rejectionMessage, $this->requesterId, $this->approver1, $this->approver2, $this->approver3, $this->approver4, $createdAt);

        if ($stmt->execute()) {
            $requestId = $stmt->insert_id; // Get the ID of the inserted request
            $stmt->close();

            // Send email notifications to specific approvers
            $this->sendApprovalNotifications($requestId, $this->approver1, $this->approver2, $this->approver3, $this->approver4);

            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    private function sendApprovalNotifications($id, $approver1, $approver2, $approver3, $approver4)
    {
        foreach ([$approver1, $approver2, $approver3, $approver4] as $approverId) {
            // Get the email address of the approver
            $approverEmail = $this->getEmailById($approverId);

            // Get the request details using the request ID
            $requestDetails = $this->getRequestDetailsById($id);

            if ($requestDetails) {
                // Compose the email content
                $subject = "Approval Request for Request ID: " . $requestDetails['uniqid'];
                $message = "Dear Approver,\n\n";
                $message .= "A new request (ID: " . $requestDetails['uniqid'] . ") is awaiting your approval.\n";
                $message .= "Please review the request details and take appropriate action by visiting the following link:\n";
                $message .= "http://localhost/dashboard/online_booking/post.php?id=" . $id . "\n\n";
                $message .= "Thank you,\n";
                $message .= "Club House Requisition system (TOPP)";

                // Send the email
                mail($approverEmail, $subject, $message);
            }
        }
    }

    // Inside a controller method that handles an approved or rejected booking...

    public function processApproval($approverId, $requestId)
    {
        try {
            $requestDetails = $this->getRequestDetailsById($requestId);

            if (!$requestDetails) {
                throw new Exception('Request not found');
            }

            // Validate the approver ID
            if (!$this->validateApproverId($approverId)) {
                throw new Exception('Invalid approver ID');
            }

            // Check if the request is already approved by the current approver
            if ($this->isRequestApprovedByApprover($requestId, $approverId)) {
                return true; // The approver has already approved this request
            }

            // Update the status of the current approver for this request
            $status = 'Approved'; // Or 'Rejected' if you have a rejection mechanism
            $this->updateApproverStatus($requestId, $approverId, $status);

            // Set success message to session variable for the current approver
            $_SESSION['success_message'] = 'Request approved successfully!';

            // Check if all approvers have approved
            if ($this->areAllApproversApproved($requestId)) {
                // If all approvers have approved, update the request status to 'Approved'
                $this->updateRequestStatus($requestId, 'Approved');

                // Send the final approval notification to the requester
                $this->sendFinalApprovalNotification($requestId);
            }

            return true;
        } catch (Exception $e) {
            error_log('Failed to approve the request. Error: ' . $e->getMessage());
            echo 'Failed to approve the request. Error: ' . $e->getMessage();
            return false;
        }
    }


    private function isAnyApproverApproved($requestId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM requests WHERE id = ? AND (approver1_status = 'Approved' OR approver2_status = 'Approved' OR approver3_status = 'Approved' OR approver4_status = 'Approved')");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row()[0];
        $stmt->close();

        return $result > 0;
    }

    private function isRequestApprovedByApprover($requestId, $approverId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM requests WHERE id = ? AND ((approver1 = ? AND approver1 = 'Approved') OR (approver2 = ? AND approver2 = 'Approved') OR (approver3 = ? AND approver3 = 'Approved') OR (approver4 = ? AND approver4 = 'Approved'))");
        $stmt->bind_param("iiiii", $requestId, $approverId, $approverId, $approverId, $approverId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_row()[0];
        $stmt->close();

        return $result > 0;
    }

    private function updateApproverStatus($requestId, $approverId, $status)
    {
        // Validate the approver ID
        if (!$this->validateApproverId($approverId)) {
            throw new Exception('Invalid approver ID');
        }

        // Get the current status of the request
        $currentStatus = $this->getRequestStatusById($requestId, $approverId);

        // Check if the current approver has already approved the request
        if ($this->isRequestApprovedByApprover($requestId, $approverId)) {
            return true; // The current approver has already approved this request
        }

        // Update the status of the current approver for this request
        $approverColumn = $this->getApproverColumnById($requestId, $approverId);


        if ($approverColumn) {
            // Update the specified approver column status
            // Update the specified approver column status
            $stmt = $this->db->prepare("UPDATE requests SET {$approverColumn}_status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $requestId);


            if ($stmt->execute()) {
                $stmt->close();

                // Update the request status if all approvers have approved and the status is still 'Approved'
                $currentStatus = $this->getRequestStatusById($requestId, $approverId);
                if ($this->areAllApproversApproved($requestId) && $currentStatus === 'Approved') {
                    $this->updateRequestStatus($requestId, 'Approved');

                    // Send the final approval notification to the requester
                    $this->sendFinalApprovalNotification($requestId);

                    // Set success message to session variable
                    $_SESSION['success_message'] = 'Request approved successfully!';

                    return ['success' => true, 'message' => 'Request approved successfully!.'];
                }

                return true;
            } else {
                $stmt->close();
                return false;
            }
        } else {
            // Invalid or unauthorized approver
            throw new Exception('Invalid or unauthorized approver ID');
        }
    }



    private function getRequestStatusById($requestId, $approverId)
    {
        $stmt = $this->db->prepare("SELECT 
                                      CASE
                                          WHEN (approver1 = ? AND approver1_status = 'Approved')
                                               OR (approver2 = ? AND approver2_status = 'Approved')
                                               OR (approver3 = ? AND approver3_status = 'Approved')
                                               OR (approver4 = ? AND approver4_status = 'Approved')
                                          THEN 'Approved'
                                          ELSE 'Pending'
                                      END AS status
                                  FROM requests WHERE id = ?");
        $stmt->bind_param("iiiii", $approverId, $approverId, $approverId, $approverId, $requestId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['status'];
        } else {
            $stmt->close();
            return null;
        }
    }

    private function getApproverColumnById($requestId, $approverId)
    {
        $stmt = $this->db->prepare("SELECT approver1, approver2, approver3, approver4 FROM requests WHERE id = ?");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $stmt->close();

            $approverColumns = ['approver1', 'approver2', 'approver3', 'approver4'];
            foreach ($approverColumns as $column) {
                if ($row[$column] === $approverId) {
                    return $column;
                }
            }
        }

        return null;
    }

    public function validateApproverId($approverId)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->bind_param("i", $approverId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows === 1;
    }


    private function areAllApproversApproved($requestId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM requests WHERE id = ? AND approver1_status = 'Approved' AND approver2_status = 'Approved' AND approver3_status = 'Approved' AND approver4_status = 'Approved'");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_row()[0];
        $stmt->close();

        return $count > 0;
    }




    private function sendFinalApprovalNotification($requestId)
    {
        $requestDetails = $this->getRequestDetailsById($requestId);

        if ($requestDetails) {
            // Get the email address of the requester
            $requesterEmail = $this->getEmailById($requestDetails['requester_id']);

            if ($requesterEmail) {
                // Compose the email content
                $subject = "Final Approval for Request ID: " . $requestDetails['uniqid'];
                $message = "Dear Requester,\n\n";
                $message .= "Your request (ID: " . $requestDetails['uniqid'] . ") has been approved.\n";
                $message .= "Thank you for the Request.\n\n";
                $message .= "Sincerely,\n";
                $message .= "Club House Requisition system (TOPP)";

                // Send the email
                mail($requesterEmail, $subject, $message);
            } else {
                // Handle the case when the email address is not retrieved
                throw new Exception('Failed to retrieve the email address of the requester');
            }
        }
    }
    private function updateRequestStatus($requestId, $status, $rejectionMessage = null)
    {
        // Validate the status to be either 'Approved', 'Processing', or 'Rejected'
        if (!in_array($status, ['Approved', 'Processing', 'Rejected'])) {
            throw new Exception('Invalid status for the request');
        }

        // Update the status of the request in the database
        $stmt = $this->db->prepare("UPDATE requests SET status = ?, rejection_message = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $rejectionMessage, $requestId);

        if ($stmt->execute()) {
            $stmt->close();

            // If all approvers have approved and the status was 'Processing', update it to 'Approved'
            if ($this->areAllApproversApproved($requestId) && $status === 'Processing') {
                $this->updateRequestStatus($requestId, 'Approved');
            }

            return true;
        } else {
            $stmt->close();
            return false;
        }
    }


    // count pending request by requester ID


    public function countPendingRequestsByRequesterId($requesterId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM requests WHERE requester_id = ? AND status = 'Pending'");
        $stmt->bind_param("i", $requesterId);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_row()[0];
        $stmt->close();

        return $count;
    }


    // count all request by requester Id

    public function countAllRequestsByRequesterId($requesterId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM requests WHERE requester_id = ?");
        $stmt->bind_param("i", $requesterId);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_row()[0];
        $stmt->close();

        return $count;
    }


    // Count all rejected request by requester Id

    public function countRejectedRequestsByRequesterId($requesterId)
    {
        $status = 'Rejected';
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM requests WHERE requester_id = ? AND status = ?");
        $stmt->bind_param("is", $requesterId, $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_row()[0];
        $stmt->close();

        return $count;
    }

    private function getEmailById($userId)
    {
        $stmt = $this->db->prepare("SELECT email FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $stmt->close();
            return $user['email'];
        } else {
            $stmt->close();
            return null;
        }
    }

    // Other methods for request processing
// ...
    private function sendRejectionNotification($requestId)
    {
        $requestDetails = $this->getRequestDetailsById($requestId);

        if ($requestDetails) {
            // Get the email address of the requester
            $requesterEmail = $this->getEmailById($requestDetails['requester_id']);

            if ($requesterEmail) {
                // Compose the email content
                $subject = "Rejected Approval message for Request ID: " . $requestDetails['uniqid'];
                $message = "Dear Requester,\n\n";
                $message .= "Your request (ID: " . $requestDetails['uniqid'] . ") has been rejected\n";
                $message .= "Reason:  " . $requestDetails['rejection_message'] . "\n";
                $message .= "Thank you for the Request.\n\n";
                $message .= "Sincerely,\n";
                $message .= "Club House Requisition system (TOPP)";

                // Send the email
                mail($requesterEmail, $subject, $message);
            } else {
                // Handle the case when the email address is not retrieved
                throw new Exception('Failed to retrieve the email address of the requester');
            }

        }
    }

    public function rejectRequest($requestId, $approverId, $rejectionMessage)
    {
        try {
            // Update the request status to 'Rejected' and set the rejection message
            $this->updateRequestStatus($requestId, 'Rejected', $rejectionMessage);

            // Send rejection notification to the requester
            $this->sendRejectionNotification($requestId);

            // Set success message to session variable
            $_SESSION['error_message'] = 'The Request has been rejected!';

            return ['success' => true, 'message' => 'The Request has been rejected!.'];
        } catch (Exception $e) {
            error_log('Failed to reject the request. Error: ' . $e->getMessage());
            echo 'Failed to reject the request. Error: ' . $e->getMessage();
            return false;
        }
    }



    // Add other methods as needed

    // ...
    public function ago($time)
    {
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();
        $difference = $now - $time;
        $tense = 'ago';

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j] .= "s";
        }

        return $difference . " " . $periods[$j] . " ago";
    }

    public function getRequestDetailsById($id)
    {
        $stmt = $this->db->prepare("SELECT requests.*, 
            users.name AS requester_name, 
            users.profile_image AS requester_image, 
            departments.name AS requester_department, 
            approver1.name AS approver1_name, 
            approver2.name AS approver2_name, 
            approver3.name AS approver3_name, 
            approver4.name AS approver4_name,
            breakfast_menu.price AS breakfast_price,
            lunch_menu.price AS lunch_price,
            dinner_menu.price AS dinner_price
            FROM requests
            INNER JOIN users ON requests.requester_id = users.id
            INNER JOIN departments ON users.department_id = departments.id
            INNER JOIN users AS approver1 ON requests.approver1 = approver1.id
            INNER JOIN users AS approver2 ON requests.approver2 = approver2.id
            INNER JOIN users AS approver3 ON requests.approver3 = approver3.id
            INNER JOIN users AS approver4 ON requests.approver4 = approver4.id
            LEFT JOIN menu AS breakfast_menu ON requests.breakfast = breakfast_menu.name
            LEFT JOIN menu AS lunch_menu ON requests.lunch = lunch_menu.name
            LEFT JOIN menu AS dinner_menu ON requests.dinner = dinner_menu.name
            WHERE requests.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $request = $result->fetch_assoc();

            // Calculate the number of days the guest will spend
            $checkInDate = strtotime($request['check_in_date']);
            $checkOutDate = strtotime($request['check_out_date']);
            $days = max(1, floor(($checkOutDate - $checkInDate) / (60 * 60 * 24)));
            $request['num_of_days_to_spend'] = $days;

            // Calculate the elapsed time for the request
            $createdAt = strtotime($request['created_at']);
            $elapsedTime = time() - $createdAt;

            $request['elapsed_time'] = $this->ago($createdAt);

            // Calculate the total price
            $breakfastPrice = $request['breakfast_price'] ?? 0;
            $lunchPrice = $request['lunch_price'] ?? 0;
            $dinnerPrice = $request['dinner_price'] ?? 0;
            $numOfPeopleForMenu = $request['num_of_people_for_menu'] ?? 0;

            $totalPrice = ($breakfastPrice + $lunchPrice + $dinnerPrice) * $numOfPeopleForMenu * $days;

            $request['total_price'] = $totalPrice;

            return $request;
        }

        return null; // No request found
    }


    public function getRequestsByRequesterId($requesterId)
    {
        $stmt = $this->db->prepare("SELECT requests.*, 
            users.name AS requester_name, 
            users.profile_image AS requester_image, 
            departments.name AS requester_department, 
            approver1.name AS approver1_name, 
            approver2.name AS approver2_name, 
            approver3.name AS approver3_name, 
            approver4.name AS approver4_name
            FROM requests
            INNER JOIN users ON requests.requester_id = users.id
            INNER JOIN departments ON users.department_id = departments.id
            INNER JOIN users AS approver1 ON requests.approver1 = approver1.id
            INNER JOIN users AS approver2 ON requests.approver2 = approver2.id
            INNER JOIN users AS approver3 ON requests.approver3 = approver3.id
            INNER JOIN users AS approver4 ON requests.approver4 = approver4.id
            WHERE requests.requester_id = ?");
        $stmt->bind_param("i", $requesterId);
        $stmt->execute();
        $result = $stmt->get_result();

        $requests = array();

        if ($result && $result->num_rows > 0) {
            while ($request = $result->fetch_assoc()) {
                // Calculate the number of days the guest will spend
                $checkInDate = strtotime($request['check_in_date']);
                $checkOutDate = strtotime($request['check_out_date']);

                // If the check-in date and check-out date are the same, set the days to 1
                $days = max(1, floor(($checkOutDate - $checkInDate) / (60 * 60 * 24)));
                $request['num_of_days_to_spend'] = $days;

                // Calculate the elapsed time for the request
                $createdAt = strtotime($request['created_at']);
                $request['elapsed_time'] = $this->ago($createdAt);

                $requests[] = $request;
            }
        }

        return $requests;
    }




    public function getRejectedRequest($requesterId)
    {
        $status = 'rejected'; // Assuming 'status' column contains the request status information

        $stmt = $this->db->prepare("SELECT requests.*, 
            users.name AS requester_name, 
            users.profile_image AS requester_image, 
            departments.name AS requester_department,
            CASE 
                WHEN requests.approver1 = ? THEN approver1.id
                WHEN requests.approver2 = ? THEN approver2.id
                WHEN requests.approver3 = ? THEN approver3.id
                WHEN requests.approver4 = ? THEN approver4.id
            END AS approver_id,
            CASE 
                WHEN requests.approver1 = ? THEN approver1.name
                WHEN requests.approver2 = ? THEN approver2.name
                WHEN requests.approver3 = ? THEN approver3.name
                WHEN requests.approver4 = ? THEN approver4.name
            END AS approver_name,
            CASE 
                WHEN requests.approver1 = ? THEN approver1.profile_image
                WHEN requests.approver2 = ? THEN approver2.profile_image
                WHEN requests.approver3 = ? THEN approver3.profile_image
                WHEN requests.approver4 = ? THEN approver4.profile_image
            END AS approver_image,
            CASE 
                WHEN requests.approver1 = ? THEN departments_approver1.name
                WHEN requests.approver2 = ? THEN departments_approver2.name
                WHEN requests.approver3 = ? THEN departments_approver3.name
                WHEN requests.approver4 = ? THEN departments_approver4.name
            END AS approver_department,
            CASE 
                WHEN requests.approver1 = ? THEN requests.rejection_message
                WHEN requests.approver2 = ? THEN requests.rejection_message
                WHEN requests.approver3 = ? THEN requests.rejection_message
                WHEN requests.approver4 = ? THEN requests.rejection_message
            END AS rejection_message
            FROM requests
            INNER JOIN users ON requests.requester_id = users.id
            INNER JOIN departments ON users.department_id = departments.id
            LEFT JOIN users AS approver1 ON requests.approver1 = approver1.id
            LEFT JOIN users AS approver2 ON requests.approver2 = approver2.id
            LEFT JOIN users AS approver3 ON requests.approver3 = approver3.id
            LEFT JOIN users AS approver4 ON requests.approver4 = approver4.id
            LEFT JOIN departments AS departments_approver1 ON approver1.department_id = departments_approver1.id
            LEFT JOIN departments AS departments_approver2 ON approver2.department_id = departments_approver2.id
            LEFT JOIN departments AS departments_approver3 ON approver3.department_id = departments_approver3.id
            LEFT JOIN departments AS departments_approver4 ON approver4.department_id = departments_approver4.id
            WHERE requests.requester_id = ? AND requests.status = ?");
        $stmt->bind_param(
            "iiiiiiiiiiiiiiiiiiiiis",
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $requesterId,
            $status
        );

        $stmt->execute();
        $result = $stmt->get_result();

        $requests = array();

        if ($result && $result->num_rows > 0) {
            while ($request = $result->fetch_assoc()) {
                // Calculate the number of days the guest will spend
                $checkInDate = strtotime($request['check_in_date']);
                $checkOutDate = strtotime($request['check_out_date']);
                $days = floor(($checkOutDate - $checkInDate) / (60 * 60 * 24));
                $request['num_of_days_to_spend'] = $days;

                // Calculate the elapsed time for the request
                $createdAt = strtotime($request['created_at']);
                $request['elapsed_time'] = $this->ago($createdAt);

                $requests[] = $request;
            }
        }

        return $requests;
    }


    // count num of Rejected request

    public function countRejectedRequests($requesterId)
    {
        $status = 'rejected'; // Assuming 'status' column contains the request status information

        $stmt = $this->db->prepare("SELECT COUNT(*) AS num_rejected_requests FROM requests WHERE requester_id = ? AND status = ?");
        $stmt->bind_param("is", $requesterId, $status);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['num_rejected_requests'];
        }

        return 0; // No rejected requests found
    }

    // count all pending for aprproval

    public function countAllPendingRequests()
    {
        $status = 'pending';

        $stmt = $this->db->prepare("SELECT COUNT(*) AS count FROM requests WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return $data['count'];
        }

        return 0;
    }


    // get all pending request
    public function getPendingRequests()
    {
        $status = 'pending';

        $query = "SELECT requests.*, 
                      users.name AS requester_name, 
                      users.profile_image AS requester_image, 
                      departments.name AS requester_department
              FROM requests
              INNER JOIN users ON requests.requester_id = users.id
              INNER JOIN departments ON users.department_id = departments.id
              WHERE requests.status = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();

        $requests = array();

        if ($result && $result->num_rows > 0) {
            while ($request = $result->fetch_assoc()) {
                // Calculate the number of days the guest will spend
                $checkInDate = strtotime($request['check_in_date']);
                $checkOutDate = strtotime($request['check_out_date']);
                $days = floor(($checkOutDate - $checkInDate) / (60 * 60 * 24));
                $request['num_of_days_to_spend'] = $days;

                // Calculate the elapsed time for the request
                $createdAt = strtotime($request['created_at']);
                $request['elapsed_time'] = $this->ago($createdAt);

                $requests[] = $request;
            }
        }

        return $requests;
    }


    // Count all Requests

    public function countAllRequests()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total_requests FROM requests");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['total_requests'];
        }

        return 0;
    }

    // Delete request By Id

    public function deleteRequestById($requestId)
    {
        $stmt = $this->db->prepare("DELETE FROM requests WHERE id = ?");
        $stmt->bind_param("i", $requestId);

        if ($stmt->execute()) {
            // Deletion successful
            $_SESSION['success_message'] = "Request has been deleted successfully!";
            return ['success' => true, 'message' => 'Request has been deleted successfully!'];
        } else {
            // Error occurred during deletion
            return false;
        }
    }




    // update request by id

    public function updateRequestById($requestId, $requestData)
    {
        // Perform necessary data validation and sanitization
        // ...

        // Prepare the SQL query to update the request

    // Prepare the SQL query to update the request
    $sql = "UPDATE requests SET 
                guest_name = ?,
                guest_address = ?,
                check_in_date = ?,
                check_out_date = ?,
                purpose_of_visit = ?,
                breakfast = ?,
                dinner = ?,
                lunch = ?,
                num_of_people_for_menu = ?,
                num_of_people_for_acco = ?,
                visitors_names = ?,
                employee_names = ?
            WHERE id = ?";

    // Prepare the statement
    $stmt = $this->db->prepare($sql);

    // Assign the result of implode to a variable
    $employeeNames = implode(',', $requestData['employeeNames']);

    // Bind parameters using bind_param
    $stmt->bind_param(
        "ssssssssiissi", // s for string, i for integer
        $requestData['guest_name'],
        $requestData['guest_address'],
        $requestData['check_in_date'],
        $requestData['check_out_date'],
        $requestData['purpose_of_visit'],
        $requestData['breakfast'],
        $requestData['dinner'],
        $requestData['lunch'],
        $requestData['num_of_people_for_menu'],
        $requestData['num_of_people_for_acco'],
        $requestData['visitors_names'],
        $employeeNames,
        $requestId // id is an integer, so use "i"
    );

        // Execute the query
        if ($stmt->execute()) {
            // Return true on successful update
            return true;
        } else {
            // Return false on failure
            return false;
        }
    }
    // recent request

    public function getRecentRequests()
    {
        $status = 'pending'; // Change this to 'rejected' if you want to include rejected requests as well

        $stmt = $this->db->prepare("SELECT requests.*, 
        users.name AS requester_name, 
        users.profile_image AS requester_image, 
        departments.name AS requester_department
        FROM requests
        INNER JOIN users ON requests.requester_id = users.id
        INNER JOIN departments ON users.department_id = departments.id
        WHERE requests.status = ?
        ORDER BY requests.created_at DESC
        LIMIT 10"); // Limit the result to 10 records

        $stmt->bind_param("s", $status);

        $stmt->execute();
        $result = $stmt->get_result();

        $requests = array();

        if ($result && $result->num_rows > 0) {
            while ($request = $result->fetch_assoc()) {
                // Calculate the number of days the guest will spend
                $checkInDate = strtotime($request['check_in_date']);
                $checkOutDate = strtotime($request['check_out_date']);
                $days = floor(($checkOutDate - $checkInDate) / (60 * 60 * 24));
                $request['num_of_days_to_spend'] = $days;

                // Calculate the elapsed time for the request
                $createdAt = strtotime($request['created_at']);
                $request['elapsed_time'] = $this->ago($createdAt);

                $requests[] = $request;
            }
        }

        return $requests;
    }


    public function getAllRequests()
    {
        $stmt = $this->db->prepare("SELECT requests.*, users.name AS requester_name, departments.name AS requester_department
            FROM requests
            INNER JOIN users ON requests.requester_id = users.id
            INNER JOIN departments ON users.department_id = departments.id 
            ");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $requests = array();
            while ($row = $result->fetch_assoc()) {
                $requests[] = $row;
            }
            return $requests;
        } else {
            return null;
        }
    }




    public function getRequestById($requestId)
    {
        try {
            // Prepare and execute the SQL query to retrieve the specific columns by ID
            $stmt = $this->db->prepare("SELECT id, guest_name, guest_address, check_in_date, check_out_date, purpose_of_visit, num_of_people_for_menu, num_of_people_for_acco, visitors_names FROM requests WHERE id = ?");
            $stmt->bind_param("i", $requestId);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if the request with the given ID exists
            if ($result->num_rows === 1) {
                $requestDetails = $result->fetch_assoc();
                $stmt->close();

                // Store the request details in session variables
                $_SESSION['request_id'] = $requestDetails['id'];
                $_SESSION['guest_name'] = $requestDetails['guest_name'];
                $_SESSION['guest_address'] = $requestDetails['guest_address'];
                $_SESSION['check_in_date'] = $requestDetails['check_in_date'];
                $_SESSION['check_out_date'] = $requestDetails['check_out_date'];
                $_SESSION['purpose_of_visit'] = $requestDetails['purpose_of_visit'];
                $_SESSION['num_of_people_for_menu'] = $requestDetails['num_of_people_for_menu'];
                $_SESSION['num_of_people_for_acco'] = $requestDetails['num_of_people_for_acco'];
                $_SESSION['visitors_names'] = $requestDetails['visitors_names'];

                return $requestDetails;
            } else {
                // Request with the provided ID was not found
                $_SESSION['error'] = "Request not found.";
                return null;
            }
        } catch (Exception $e) {
            error_log('Failed to retrieve request by ID. Error: ' . $e->getMessage());
            $_SESSION['error'] = "An error occurred while fetching request details.";
            return null;
        }
    }




    public function getApprovers()
    {
        $approverType = "approver"; // User type value for approvers
        // User type value for admins

        $stmt = $this->db->prepare("SELECT id, name, email FROM users WHERE user_type = ?");
        $stmt->bind_param("s", $approverType);
        $stmt->execute();
        $result = $stmt->get_result();

        $approvers = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $approvers[] = $row;
            }
        }

        return $approvers;
    }



    public function getAdmin()
    {

        $adminType = "admin"; // User type value for admins

        $stmt = $this->db->prepare("SELECT id, name, email FROM users WHERE user_type = ?");
        $stmt->bind_param("s", $adminType);
        $stmt->execute();
        $result = $stmt->get_result();

        $approvers = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $approvers[] = $row;
            }
        }

        return $approvers;
    }
    public function getEmployees()
    {
        $stmt = $this->db->prepare("SELECT id, emp_name FROM employee");
        $stmt->execute();
        $result = $stmt->get_result();

        $employees = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $employees[] = $row;
            }
        }

        return $employees;
    }




    // Method to retrieve breakfast menu options and store them in a session variable
    public function generateBreakfastMenuOptions()
    {
        $query = "SELECT name FROM menu WHERE category_id = 1"; // Assuming category_id 1 represents breakfast
        $result = $this->db->query($query);

        $options = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $options[] = $row['name'];
            }
        }

        return $options;
    }





    // Method to fetch lunch menu options
    public function fetchLunchOptions()
    {
        $query = "SELECT name FROM menu WHERE category_id = 2"; // Assuming category_id 1 represents breakfast
        $result = $this->db->query($query);

        $options = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $options[] = $row['name'];
            }
        }

        return $options;
    }

    // Method to fetch dinner menu options
    public function fetchDinnerOptions()
    {
        $query = "SELECT name FROM menu WHERE category_id = 3"; // Assuming category_id 1 represents breakfast
        $result = $this->db->query($query);

        $options = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $options[] = $row['name'];
            }
        }

        return $options;
    }



    //    Creating a while lists


    public function addToWhilelist($requestId, $userId)
    {
        $whitelistedAt = date('Y-m-d H:i:s');

        // Check if the request is already in the whitelist for the specified user
        $existingEntryStmt = $this->db->prepare("SELECT COUNT(*) FROM whilelist_requests WHERE request_id = ? AND user_id = ?");
        $existingEntryStmt->bind_param("ii", $requestId, $userId);
        $existingEntryStmt->execute();
        $existingEntryResult = $existingEntryStmt->get_result();
        $existingEntryCount = $existingEntryResult->fetch_row()[0];

        if ($existingEntryCount > 0) {
            $_SESSION['error_message'] = 'Request ID:' . $requestId . ' already exist in the Todo list';
            return ['error' => true, 'message' => 'Request ID:' . $requestId . '  already exist in the Todo list']; // Return false to indicate that the request is already in the whitelist.
        }

        // If no existing entry found, proceed to add the request to the whitelist
        $stmt = $this->db->prepare("INSERT INTO whilelist_requests (request_id, user_id, whilelisted_at) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $requestId, $userId, $whitelistedAt);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success_message'] = 'Request ID: ' . $requestId . '  has been add to the Todo list';
            return ['success' => true, 'message' => 'Request ID:' . $requestId . ' has been add to the Todo list']; // Return false to indicate that the request is already in the whitelist.
        } else {
            return false; // Failed to add to the whitelist
        }
    }



    // toggle whilelist items


    public function setDepartmentStatusToDone($request_id)
    {
        $stmt = $this->db->prepare("UPDATE `whilelist_requests` SET `status` = 'done' WHERE `id` = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Remove items with status 'done'
            $stmt_remove = $this->db->prepare("DELETE FROM `whilelist_requests` WHERE `status` = 'done'");
            $stmt_remove->execute();

            if ($stmt_remove->affected_rows > 0) {
                $_SESSION['success_message'] = 'Request ID:' . $request_id . ' has been removed successfully';
                return ['success' => true, 'message' => 'Request ID:' . $request_id . ' has been removed successfully'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    // fetch while list

    public function getAllWhilelistRequests()
    {
        $query = "SELECT whilelist_requests.*, requests.status,created_at, requests.uniqid, users.name AS requester_name, requests.guest_name, departments.name AS requester_department
              FROM whilelist_requests
              LEFT JOIN requests ON whilelist_requests.request_id = requests.id
              LEFT JOIN users ON requests.requester_id = users.id
              LEFT JOIN departments ON users.department_id = departments.id
              ORDER BY whilelist_requests.id DESC";

        $result = $this->db->query($query);

        if (!$result) {
            throw new Exception("Error retrieving whitelist requests: " . $this->db->error);
        }

        $whitelistRequests = array();

        while ($row = $result->fetch_assoc()) {
            $whitelistRequests[] = $row;
        }

        return $whitelistRequests;
    }


    // count whilelist
    public function countWhilelistRequests()
    {
        $query = "SELECT COUNT(*) AS total FROM whilelist_requests";

        $result = $this->db->query($query);

        if (!$result) {
            throw new Exception("Error counting whilelist requests: " . $this->db->error);
        }

        $row = $result->fetch_assoc();

        return $row['total'];
    }



    // export all  

    public function getRequestsByDateRange($startDate, $endDate)
    {
        // Prepare the SQL query to fetch requests within the given date range
        $stmt = $this->db->prepare("SELECT requests.*, 
        users.name AS requester_name, 
        users.profile_image AS requester_image, 
        departments.name AS requester_department, 
        approver1.name AS approver1_name, 
        approver2.name AS approver2_name, 
        approver3.name AS approver3_name, 
        approver4.name AS approver4_name,
        breakfast_menu.price AS breakfast_price,
         lunch_menu.price AS lunch_price,
        dinner_menu.price AS dinner_price,
        DATE(requests.created_at) AS request_date -- Extract date from created_at
        
        FROM requests
        INNER JOIN users ON requests.requester_id = users.id
        INNER JOIN departments ON users.department_id = departments.id
        INNER JOIN users AS approver1 ON requests.approver1 = approver1.id
        INNER JOIN users AS approver2 ON requests.approver2 = approver2.id
        INNER JOIN users AS approver3 ON requests.approver3 = approver3.id
        INNER JOIN users AS approver4 ON requests.approver4 = approver4.id
        LEFT JOIN menu AS breakfast_menu ON requests.breakfast = breakfast_menu.name
        LEFT JOIN menu AS lunch_menu ON requests.lunch = lunch_menu.name
        LEFT JOIN menu AS dinner_menu ON requests.dinner = dinner_menu.name
        WHERE DATE(requests.created_at) BETWEEN ? AND ? -- Compare only the date part
        ORDER BY requests.created_at DESC");

        // Bind the parameters to the query
        $stmt->bind_param("ss", $startDate, $endDate);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        $requests = array();

        // Process the query result
        if ($result && $result->num_rows > 0) {
            while ($request = $result->fetch_assoc()) {
                // Calculate the number of days the guest will spend
                $checkInDate = strtotime($request['check_in_date']);
                $checkOutDate = strtotime($request['check_out_date']);
                $days = max(1, floor(($checkOutDate - $checkInDate) / (60 * 60 * 24)));
                $request['num_of_days_to_spend'] = $days;

                // Calculate the elapsed time for the request
                $createdAt = strtotime($request['created_at']);
                $request['elapsed_time'] = $this->ago($createdAt);

                $requests[] = $request;
            }
        }

        return $requests;
    }




    // /export to csv


    public function generateCSV($requests)
    {
        // Start output buffering
        ob_start();

        // Open the output stream as a file for writing
        $file = fopen('php://output', 'w');

        $title = "Requests Export";
        fputcsv($file, [$title]);
        // Add an empty row to separate the title from the headings
        fputcsv($file, array(''));


        // Add the CSV headers
        fputcsv($file, array('Request ID', 'Requester Name', 'Requester Department', 'Guest Name', 'Breakfast', 'Lunch', 'Dinner', 'Arival Date', 'Departure Date', 'Created At', 'Status'));

        // Loop through the requests data and write to the CSV file
        foreach ($requests as $request) {
            // Format the data (e.g., handle date formatting if needed)
            $request['created_at'] = date('Y-m-d H:i:s', strtotime($request['created_at']));

            // Write request details to the CSV file
            fputcsv($file, array(
                $request['uniqid'],
                $request['requester_name'],
                $request['requester_department'],
                $request['guest_name'],
                $request['breakfast'],
                $request['lunch'],
                $request['dinner'],
                $request['check_in_date'],
                $request['check_out_date'],
                $request['created_at'],
                $request['status']
            )
            );
        }

        // Close the file
        fclose($file);

        // Get the output buffer contents and clear the buffer
        $csvData = ob_get_clean();

        return $csvData;
    }



}




?>