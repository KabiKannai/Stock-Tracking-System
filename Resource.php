<?php
// Database connection parameters
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

// Initialize variables with form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic sanitization and validation function
    function sanitize($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Sanitize and validate each input field
    $academicYear = sanitize($_POST['academicYear']);
    $slipreferenceNo = sanitize($_POST['slipreferenceNo']);
    $date = sanitize($_POST['date']);
    $department = sanitize($_POST['department']);
    $hod = sanitize($_POST['hod']);
    $headOfAccount = sanitize($_POST['headOfAccount']);
    $totalAmount = (float) sanitize($_POST['totalAmount']);
    $referenceNo = sanitize($_POST['referenceNo']);
    $allotmentdate = sanitize($_POST['allotmentdate']);
    $expenditure = (float) sanitize($_POST['expenditure']);
    $amountClaimed = (float) sanitize($_POST['amountClaimed']);
    $balance = (float) sanitize($_POST['balance']);
    $remarks = sanitize($_POST['remarks']);
    $paymentDetails = sanitize($_POST['paymentDetails']);
    $invoiceNo = sanitize($_POST['invoiceNo']);
    $total = (float) sanitize($_POST['total']);
    $fileNo = sanitize($_POST['fileNo']);
    $invoiceNo2 = sanitize($_POST['invoiceNo2']);
    $invoiceDate = sanitize($_POST['invoiceDate']);
    $tinNo = sanitize($_POST['tinNo']);
    $areaCode = sanitize($_POST['areaCode']);
    $gstn = sanitize($_POST['gstn']);
    $grossamt = (float) sanitize($_POST['grossamt']);
    $bankDetails = sanitize($_POST['bankDetails']);
    $detailsEnteredIn = sanitize($_POST['detailsEnteredIn']);
    $stockRegisterPageNo = sanitize($_POST['stockRegisterPageNo']);
    $grandTotal = (float) sanitize($_POST['grandTotal']);

    $productDescriptions = json_encode(array_map('sanitize', $_POST['productDescription']));
    $quantities = json_encode(array_map('sanitize', $_POST['quantity']));
    $unitRates = json_encode(array_map('sanitize', $_POST['unitRate']));
    $amounts = json_encode(array_map('sanitize', $_POST['amount']));
    $CGSTs = json_encode(array_map('sanitize', $_POST['CGST']));
    $SGSTs = json_encode(array_map('sanitize', $_POST['SGST']));
}

// Prepare and bind SQL statement
$stmt = $conn->prepare("INSERT INTO resources (academicYear, slipreferenceNo, date, department, hod, headOfAccount, totalAmount, referenceNo, allotmentdate, expenditure, amountClaimed, balance, remarks, paymentDetails, invoiceNo, total, fileNo, invoiceNo2, invoiceDate, tinNo, areaCode, gstn, productDescriptions, quantities, unitRates, amounts, CGSTs, SGSTs, grossamt, grandTotal, bankDetails, detailsEnteredIn, stockRegisterPageNo) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssssssssssssssssssssssssss", $academicYear, $slipreferenceNo, $date, $department, $hod, $headOfAccount, $totalAmount, $referenceNo, $allotmentdate, $expenditure, $amountClaimed, $balance, $remarks, $paymentDetails, $invoiceNo, $total, $fileNo, $invoiceNo2, $invoiceDate, $tinNo, $areaCode, $gstn, $productDescriptions, $quantities, $unitRates, $amounts, $CGSTs, $SGSTs, $grossamt, $grandTotal, $bankDetails, $detailsEnteredIn, $stockRegisterPageNo);

// Execute statement
if ($stmt->execute()) {
    header("Location: Display.html");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
