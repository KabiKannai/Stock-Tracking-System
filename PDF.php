<?php
require_once('tcpdf/tcpdf.php');

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "Newresource"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Function to fetch data from resources table based on academic year
function fetchResourcesData($conn, $academicYear) {
  $sql = "SELECT * FROM resources WHERE academicYear = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $academicYear);
  $stmt->execute();
  $result = $stmt->get_result();

  $resourcesData = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $resourcesData[] = $row;
    }
  }
  $stmt->close();

  return $resourcesData;
}

// Check if academicYear is set in $_POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['academicYear'])) {
  $academicYear = $_POST['academicYear'];
  $resourcesData = fetchResourcesData($conn, $academicYear);

  // Create new PDF document
  $pdf = new TCPDF();
  $pdf->AddPage();

  // Set title and metadata
  $pdf->SetTitle('Resources Data for Academic Year: ' . $academicYear);
  $pdf->SetAuthor('Your Name');

  // Add a header with background color
  $pdf->SetFont('helvetica', 'B', 16);
  $pdf->SetFillColor(100, 149, 237); // Cornflower blue background color
  $pdf->Cell(0, 15, 'Resources Data for Academic Year: ' . $academicYear, 0, 1, 'C', 1);

  // Add a line break
  $pdf->Ln(5);

  // Define table header and styles
  $pdf->SetFont('helvetica', 'B', 12);
  $pdf->SetFillColor(224, 235, 255); // Light blue fill color for header
  $pdf->SetTextColor(0, 0, 128); // Dark blue text color

  $headers = [
    'ID' => 'id',
    'Academic Year' => 'academicYear',
    'Slip Reference No' => 'slipreferenceNo',
    'Date' => 'date',
    'Department' => 'department',
    'HOD' => 'hod',
    'Head of Account' => 'headOfAccount',
    'Total Amount' => 'totalAmount',
    'Reference No' => 'referenceNo',
    'Allotment Date' => 'allotmentdate',
    'Expenditure' => 'expenditure',
    'Amount Claimed' => 'amountClaimed',
    'Balance' => 'balance',
    'Remarks' => 'remarks',
    'Payment Details' => 'paymentDetails',
    'Invoice No' => 'invoiceNo',
    'Total' => 'total',
    'File No' => 'fileNo',
    'Invoice No 2' => 'invoiceNo2',
    'Invoice Date' => 'invoiceDate',
    'TIN No' => 'tinNo',
    'Area Code' => 'areaCode',
    'GSTN/UIN' => 'gstn',
    'Product Descriptions' => 'productDescriptions',
    'Quantities' => 'quantities',
    'Unit Rates' => 'unitRates',
    'Amounts' => 'amounts',
    'CGSTs' => 'CGSTs',
    'SGSTs' => 'SGSTs',
    'Bank Details' => 'bankDetails',
    'Details Entered In' => 'detailsEnteredIn',
    'Stock Register Page No' => 'stockRegisterPageNo',
    'Grand Total' => 'grandTotal'
  ];

  // Set background colors for rows
  $rowBackgroundColors = [
    [255, 255, 255], // White
    [240, 240, 240], // Light grey
    [220, 230, 255], // Light blue
    [255, 220, 220], // Light red
    [220, 255, 220]  // Light green
  ];

  // Add table rows in vertical format
  $pdf->SetFont('helvetica', '', 10);
  $pdf->SetTextColor(0); // Reset text color
  $rowIndex = 0;
  foreach ($resourcesData as $row) {
    $pdf->SetFillColorArray($rowBackgroundColors[$rowIndex % count($rowBackgroundColors)]);

    foreach ($headers as $header => $field) {
      $data = in_array($field, ['productDescriptions', 'quantities', 'unitRates', 'amounts', 'CGSTs', 'SGSTs']) ?
        implode(', ', json_decode($row[$field], true)) : $row[$field];
      $pdf->SetFont('helvetica', 'B', 10);
      $pdf->Cell(50, 10, $header . ':', 1, 0, 'L', 1);
      $pdf->SetFont('helvetica', '', 10);
      $pdf->Cell(0, 10, $data, 1, 1, 'L', 1);
    }
    $pdf->Ln(5); // Add a line break between records
    $rowIndex++;
  }

  // Output the PDF
  $pdf->Output('resources_data.pdf', 'I');
}

$conn->close();
?>
