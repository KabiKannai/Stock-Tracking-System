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

// Function to fetch data from resources table based on academic year
function fetchResourcesData($conn, $academicYear) {
  $sql = "SELECT * FROM resources WHERE academicYear = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $academicYear);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    echo "<h2>Resources Data for Academic Year: $academicYear</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Academic Year</th><th>Slip Reference No</th><th>Date</th><th>Department</th><th>HOD</th><th>Head of Account</th><th>Total Amount</th><th>Reference No</th><th>Allotment Date</th><th>Expenditure</th><th>Amount Claimed</th><th>Balance</th><th>Remarks</th><th>Payment Details</th><th>Invoice No</th><th>Total</th><th>File No</th><th>Invoice No 2</th><th>Invoice Date</th><th>TIN No</th><th>Area Code</th><th>GSTN/UIN</th><th>Product Descriptions</th><th>Quantities</th><th>Unit Rates</th><th>Amounts</th><th>CGSTs</th><th>SGSTs</th><th>Bank Details</th><th>Details Entered In</th><th>Stock Register Page No</th><th>Grand Total</th><th>Action</th></tr>";

    while($row = $result->fetch_assoc()) {
      // Decode JSON data
      $productDescriptions = json_decode($row["productDescriptions"], true);
      $quantities = json_decode($row["quantities"], true);
      $unitRates = json_decode($row["unitRates"], true);
      $amounts = json_decode($row["amounts"], true);
      $CGSTs = json_decode($row["CGSTs"], true);
      $SGSTs = json_decode($row["SGSTs"], true);

      echo "<tr>";
      echo "<td>".$row["id"]."</td>";
      echo "<td>".$row["academicYear"]."</td>";
      echo "<td>".$row["slipreferenceNo"]."</td>";
      echo "<td>".$row["date"]."</td>";
      echo "<td>".$row["department"]."</td>";
      echo "<td>".$row["hod"]."</td>";
      echo "<td>".$row["headOfAccount"]."</td>";
      echo "<td>".$row["totalAmount"]."</td>";
      echo "<td>".$row["referenceNo"]."</td>";
      echo "<td>".$row["allotmentdate"]."</td>";
      echo "<td>".$row["expenditure"]."</td>";
      echo "<td>".$row["amountClaimed"]."</td>";
      echo "<td>".$row["balance"]."</td>";
      echo "<td>".$row["remarks"]."</td>";
      echo "<td>".$row["paymentDetails"]."</td>";
      echo "<td>".$row["invoiceNo"]."</td>";
      echo "<td>".$row["total"]."</td>";
      echo "<td>".$row["fileNo"]."</td>";
      echo "<td>".$row["invoiceNo2"]."</td>";
      echo "<td>".$row["invoiceDate"]."</td>";
      echo "<td>".$row["tinNo"]."</td>";
      echo "<td>".$row["areaCode"]."</td>";
      echo "<td>".$row["gstn"]."</td>";

      // Display product details
      $productCount = count($productDescriptions);
      echo "<td>";
      for ($i = 0; $i < $productCount; $i++) {
        echo $productDescriptions[$i] . "<br>";
      }
      echo "</td>";

      echo "<td>";
      for ($i = 0; $i < $productCount; $i++) {
        echo $quantities[$i] . "<br>";
      }
      echo "</td>";

      echo "<td>";
      for ($i = 0; $i < $productCount; $i++) {
        echo $unitRates[$i] . "<br>";
      }
      echo "</td>";

      echo "<td>";
      for ($i = 0; $i < $productCount; $i++) {
        echo $amounts[$i] . "<br>";
      }
      echo "</td>";

      echo "<td>";
      for ($i = 0; $i < $productCount; $i++) {
        echo $CGSTs[$i] . "<br>";
      }
      echo "</td>";

      echo "<td>";
      for ($i = 0; $i < $productCount; $i++) {
        echo $SGSTs[$i] . "<br>";
      }
      echo "</td>";

      echo "<td>".$row["bankDetails"]."</td>";
      echo "<td>".$row["detailsEnteredIn"]."</td>";
      echo "<td>".$row["stockRegisterPageNo"]."</td>";
      echo "<td>".$row["grandTotal"]."</td>";
      echo "
      <style>
            .Edit {
          background : blue;
          color: #fff;
          border: none;
          cursor: pointer;
          transition: background-color 0.3s;
        }
          .Delete {
          background : Red;
          color: #fff;
          border: none;
          cursor: pointer;
          transition: background-color 0.3s;
        button:hover {
          background-color: #218838;
        }
      </style>
          <td><a href='edit.php?id=".$row["id"]."'><button type='button' class='Edit'>Edit</button></a> / <a href='delete.php?id=".$row["id"]."'><button type='button' class='Delete'>Delete</button></a></td>";
      echo "</tr>";
    }

    echo "</table>";
    echo "<form method='post' action='PDF.php'>";
    echo "<input type='hidden' name='academicYear' value='$academicYear'>";
    echo "
    <style>
          .PDF {
          background : Green;
          color: #fff;
          border: none;
          cursor: pointer;
          transition: background-color 0.3s;
        button:hover {
          background-color: #218838;
        }
      </style>
      <input type='submit' value='Generate PDF' class='PDF'>";
    echo "</form>";
  } else {
    echo "No results found for Academic Year: $academicYear";
  }
  $stmt->close();
}

// Check if academicYear is set in $_POST
if (isset($_POST['academicYear'])) {
  $academicYear = $_POST['academicYear'];
  fetchResourcesData($conn, $academicYear);
}

$conn->close();
?>




