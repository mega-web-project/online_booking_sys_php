<?php

// export_requests.php

// Include necessary files and initialize the database connection (similar to other pages)
// ...

include 'init.php';
require('fpdf/fpdf.php');

class MyPDF extends FPDF
{
    function Header()
    {
        // Logo or header content
        $this->Image('assets/img/twiftopp_logo.png', 10, 10, 30); // Adjust the image path and position as needed
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Club House Requisition Report', 0, 1, 'C');
        $this->Ln(5);
    }

    // Footer
    function Footer()
    {
        // Footer content
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }
    public function generatePDF($requests)
    {
        $this->AliasNbPages();
        $this->AddPage();

        // Loop through the requests data and print the details in the PDF
        foreach ($requests as $requestDetails) {
             // Set font and cell sizes
             
             $this->SetFont('Arial', 'B', 14);
             $this->Cell(0, 10, 'Request Report', 0, 1, 'C');
             $this->Ln(3);
             $this->SetFont('Arial', 'i', 14);
             $this->Cell(0, 10, 'For '.$requestDetails['request_date'], 0, 1, 'C');
             $this->Ln(5);
 
             // Create a table-like structure
             $this->SetFillColor(230, 230, 230); 
             $this->SetFont('Arial', 'B', 12);
             $this->Cell(40, 8, 'Request ID:', 1, 0, 'L', true);
             $this->SetFont('Arial', '', 12);
             $this->Cell(40, 8, $requestDetails['uniqid'], 1, 1, true);
             $this->Cell(40, 8, 'Request Status:', 1, 0, 'L', true);
             $this->SetFont('Arial', '', 12);
             $this->Cell(40, 8, $requestDetails['status'], 1, 1,true);
 
 

             $this->SetFillColor(230, 230, 230); 
             $this->SetFont('Arial', 'B', 12);
 
             // Requester details
             $this->Cell(40, 8, 'Requester:', 1, 0, 'L', true);
             $this->SetFont('Arial', '', 12);
             $this->Cell(40, 8, $requestDetails['requester_name'], 1, 1,true);
             $this->SetFont('Arial', 'B', 12);
             $this->Cell(40, 8, 'Department:', 1, 0, 'L',true);
             $this->SetFont('Arial', '', 12);
             $this->Cell(40, 8, $requestDetails['requester_department'], 1, 1,true);
 
 
             // Guest details
             $this->SetFillColor(230, 230, 230); 
             $this->SetFont('Arial', 'B', 12);
             $this->Cell(40, 8, 'Guest Name:', 1, 0, 'L',true);
             $this->SetFont('Arial', '', 12);
             $this->Cell(40, 8, $requestDetails['guest_name'], 1, 1,true);
             $this->SetFont('Arial', 'B', 12);
             $this->Cell(40, 8, 'Guest Address:', 1, 0, 'L',true);
             $this->SetFont('Arial', '', 12);
             $this->Cell(40, 8, $requestDetails['guest_address'], 1, 1,true);
 
 
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
         }
        }
    }


if (isset($_POST['export_pdf']) && isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Create a new instance of the Request class
    $request = new Request($database);

    // Get requests within the specified date range
    $requests = $request->getRequestsByDateRange($startDate, $endDate);

    // Create a new PDF instance
    $pdf = new MyPDF('P', 'mm', 'A4');

    // Generate the PDF with the retrieved requests data
    $pdf->generatePDF($requests);

    // Output the PDF to the browser
    $pdf->Output('requests_export.pdf', 'I'); // Use 'D' to force download the file
} 


?>

<?php

if (isset($_POST['export_csv'])) {
    if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        // Create a new instance of the Request class
        $request = new Request($database);

        // Get requests within the specified date range
        $requests = $request->getRequestsByDateRange($startDate, $endDate);

        // Generate the CSV with the retrieved requests data
        $csvData = $request->generateCSV($requests);

        // Download the CSV file
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="requests_export.csv"');
        echo $csvData;
        exit();
    } else {
        // Handle error when date range is not provided
        echo "Error: Date range not provided.";
    }
}



?>