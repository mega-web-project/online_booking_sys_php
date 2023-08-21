
<?php

include 'init.php';
require('fpdf/fpdf.php');

class MyPDF extends FPDF
{
    // Header
    function Header()
    {
        // Logo or header content
        $this->Image('assets/img/twiftopp_logo.png', 10, 10, 30); // Adjust the image path and position as needed
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Club House Requisition Report/ Receipt', 0, 1, 'C');
        $this->Ln(10);
    }

    // Footer
    function Footer()
    {
        // Footer content
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }

// Print Request Details
    function printRequestDetails($id)
    {
        global $request;

        $requestDetails = $request->getRequestDetailsById($id);

        if ($requestDetails) {
            // Set font and cell sizes
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 10, 'Request Details', 0, 1, 'C');
            $this->Ln(5);

            // Create a table-like structure
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(40, 10, 'Request ID:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(40, 10, $requestDetails['uniqid'], 1, 1);
            $this->Cell(40, 10, 'Request Status:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(40, 10, $requestDetails['status'], 1, 1);


            $this->SetFont('Arial', 'B', 12);

            // Requester details
            $this->Cell(40, 10, 'Requester:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(40, 10, $requestDetails['requester_name'], 1, 1);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(40, 10, 'Department:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(40, 10, $requestDetails['requester_department'], 1, 1);


            // Guest details
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(40, 10, 'Guest Name:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(40, 10, $requestDetails['guest_name'], 1, 1);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(40, 10, 'Guest Address:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(40, 10, $requestDetails['guest_address'], 1, 1);


            $this->Ln(5);

            // Other details

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(60, 10, 'Date & Time of Arrival:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $requestDetails['check_in_date'], 1, 1, 'L');

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(60, 10, 'Date & Time of Departure:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $requestDetails['check_out_date'], 1, 1, 'L');
            
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(60, 10, 'Total days spent:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $requestDetails['num_of_days_to_spend'].' days(s)', 1, 1, 'L');

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(60, 10, 'Purpose of Visit:', 1, 0, 'L');

            $this->SetFont('Arial', '', 12);
            $this->MultiCell(0, 10, $requestDetails['purpose_of_visit'], 1, 'L');

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(60, 10, 'Number of People for Menu:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $requestDetails['num_of_people_for_menu'], 1, 1, 'L');

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(60, 10, ' Accommodation:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $requestDetails['num_of_people_for_acco'], 1, 1, 'L');

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(60, 10, 'Employee Names:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $requestDetails['employee_names'], 1, 1, 'L');

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(60, 10, 'Visitor Names:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $requestDetails['visitors_names'], 1, 1, 'L');

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(60, 10, 'Breakfast:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $requestDetails['breakfast'] . ' (GH' . number_format($requestDetails['breakfast_price'], 2) . ')', 1, 1, 'L');

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(60, 10, 'Lunch:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $requestDetails['lunch'] . ' (GH' . number_format($requestDetails['lunch_price'], 2) . ')', 1, 1, 'L');

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(60, 10, 'Dinner:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $requestDetails['dinner'] . ' (GH' . number_format($requestDetails['dinner_price'], 2) . ')', 1, 1, 'L');

            // Calculate total price
            $breakfastPrice = $requestDetails['breakfast_price'] ?? 0;
            $lunchPrice = $requestDetails['lunch_price'] ?? 0;
            $dinnerPrice = $requestDetails['dinner_price'] ?? 0;
            $numOfPeopleForMenu = $requestDetails['num_of_people_for_menu'] ?? 0;
            $numOfDays = $requestDetails['num_of_days_to_spend'] ?? 0;

            $totalPrice = ($breakfastPrice + $lunchPrice + $dinnerPrice) * $numOfPeopleForMenu * $numOfDays;

            // Display total price
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(60, 10, 'Total Price:', 1, 0, 'L');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, 'GH ' . number_format($totalPrice, 2), 1, 1, 'L');


            // Continue with other fields...
            $this->Ln(5);
            $this->SetFont('Arial', 'I', 14);
            $this->Cell(0, 10, 'Approvers', 0, 1, 'L');

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(80, 10, 'Approved and Authorized By:', 0, 0);
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $requestDetails['approver1_name'] . ' | ' . $requestDetails['approver2_name'] . ' | ' . $requestDetails['approver3_name'], 0, 1);


            $this->Ln(5);
            $this->Cell(0, 10, 'End of Request Details', 0, 1, 'C');
        } else {
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 10, 'Request Not Found', 0, 1, 'C');
        }
    }




}

// Create a new instance of the Request class
$request = new Request($database);

$pdf = new MyPDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pdf->printRequestDetails($id);
} else {
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Request ID Not Specified', 0, 1, 'C');
}


















$pdf->Output();

?>

<link rel="icon" type="image/png" href="assets/img/topp.png"/>