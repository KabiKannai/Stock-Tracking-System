<?php
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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
  $id = $_GET['id'];

  // Fetch data based on ID
  $sql = "SELECT * FROM resources WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Decode JSON data
    $productDescriptions = isset($row["productDescriptions"]) ? json_decode($row["productDescriptions"], true) : [];
    $quantities = isset($row["quantities"]) ? json_decode($row["quantities"], true) : [];
    $unitRates = isset($row["unitRates"]) ? json_decode($row["unitRates"], true) : [];
    $amounts = isset($row["amounts"]) ? json_decode($row["amounts"], true) : [];
    $CGSTs = isset($row["CGSTs"]) ? json_decode($row["CGSTs"], true) : [];
    $SGSTs = isset($row["SGSTs"]) ? json_decode($row["SGSTs"], true) : [];

    // Display edit form
    echo "
    <html>
    <head>
      <style>
        body {
          font-family: Arial, sans-serif;
          background-color: #f7f9fc;
          margin: 0;
          padding: 0;
        }
        .container {
          max-width: 800px;
          margin: 50px auto;
          padding: 20px;
          background-color: #fff;
          border-radius: 8px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
          color: #333;
          text-align: center;
        }
        label {
          display: block;
          margin-bottom: 8px;
          font-weight: bold;
        }
        input, textarea, button {
          width: 100%;
          padding: 10px;
          margin-bottom: 20px;
          border: 1px solid #ddd;
          border-radius: 4px;
        }
        button {
          background-color: #28a745;
          color: #fff;
          border: none;
          cursor: pointer;
          transition: background-color 0.3s;
        }
        button:hover {
          background-color: #218838;
        }
      </style>
    </head>
    <body>
      <div class='container'>
        <h2>Edit Resource Data</h2>
        <form action='update.php' method='post'>
          <input type='hidden' name='id' value='".$row["id"]."'>
          <label>Academic Year</label>
          <input type='text' name='academicYear' value='".$row["academicYear"]."'>
          
          <label>Slip Reference No</label>
          <input type='text' name='slipreferenceNo' value='".$row["slipreferenceNo"]."'>
          
          <label>Date</label>
          <input type='date' name='date' value='".$row["date"]."'>
          
          <label>Department</label>
          <input type='text' name='department' value='".$row["department"]."'>
          
          <label>HOD</label>
          <input type='text' name='hod' value='".$row["hod"]."'>
          
          <label>Head of Account</label>
          <input type='text' name='headOfAccount' value='".$row["headOfAccount"]."'>
          
          <label>Total Amount</label>
          <input type='text' name='totalAmount' value='".$row["totalAmount"]."'>
          
          <label>Reference No</label>
          <input type='text' name='referenceNo' value='".$row["referenceNo"]."'>
          
          <label>Allotment Date</label>
          <input type='date' name='allotmentdate' value='".$row["allotmentdate"]."'>
          
          <label>Expenditure</label>
          <input type='text' name='expenditure' value='".$row["expenditure"]."'>
          
          <label>Amount Claimed</label>
          <input type='text' name='amountClaimed' value='".$row["amountClaimed"]."'>
          
          <label>Balance</label>
          <input type='text' name='balance' value='".$row["balance"]."'>
          
          <label>Remarks</label>
          <textarea name='remarks'>".$row["remarks"]."</textarea>
          
          <label>Payment Details</label>
          <textarea name='paymentDetails'>".$row["paymentDetails"]."</textarea>
          
          <label>Invoice No</label>
          <input type='text' name='invoiceNo' value='".$row["invoiceNo"]."'>
          
          <label>Total</label>
          <input type='text' name='total' value='".$row["total"]."'>
          
          <label>File No</label>
          <input type='text' name='fileNo' value='".$row["fileNo"]."'>
          
          <label>Invoice No 2</label>
          <input type='text' name='invoiceNo2' value='".$row["invoiceNo2"]."'>
          
          <label>Invoice Date</label>
          <input type='date' name='invoiceDate' value='".$row["invoiceDate"]."'>
          
          <label>TIN No</label>
          <input type='text' name='tinNo' value='".$row["tinNo"]."'>
          
          <label>Area Code</label>
          <input type='text' name='areaCode' value='".$row["areaCode"]."'>
          
          <label>GSTN/UIN</label>
          <input type='text' name='gstn' value='".$row["gstn"]."'>
          
          <label>Product Description</label>
          <textarea name='productDescription'>".implode("\n", $productDescriptions)."</textarea>
          
          <label>Quantity</label>
          <textarea name='quantity'>".implode("\n", $quantities)."</textarea>
          
          <label>Unit Rate</label>
          <textarea name='unitRate'>".implode("\n", $unitRates)."</textarea>
          
          <label>Amount</label>
          <textarea name='amount'>".implode("\n", $amounts)."</textarea>
          
          <label>CGST</label>
          <textarea name='CGST'>".implode("\n", $CGSTs)."</textarea>
          
          <label>SGST</label>
          <textarea name='SGST'>".implode("\n", $SGSTs)."</textarea>
          
          <label>Gross Amount</label>
          <input type='text' name='grossamt' value='".$row["grossamt"]."'>
          
          <label>Bank Details</label>
          <input type='text' name='bankDetails' value='".$row["bankDetails"]."'>
          
          <label>Details Entered In</label>
          <input type='text' name='detailsEnteredIn' value='".$row["detailsEnteredIn"]."'>
          
          <label>Stock Register Page No</label>
          <input type='text' name='stockRegisterPageNo' value='".$row["stockRegisterPageNo"]."'>
          
          <label>Grand Total</label>
          <input type='text' name='grandTotal' value='".$row["grandTotal"]."'>
          
          <button type='submit'>Submit</button>
        </form>
      </div>
    </body>
    </html>
    ";
  } else {
    echo "Record not found.";
    echo "Go back to Home.";
  }
}

$conn->close();
?>
