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

  // Delete record
  $sql = "DELETE FROM resources WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  
  if ($stmt->execute()) {
    echo "Record deleted successfully.";
  } else {
    echo "Error deleting record: " . $stmt->error;
  }
}

$conn->close();
?>
