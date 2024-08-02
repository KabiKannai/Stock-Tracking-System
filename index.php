<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Homestyle.css">
</head>
<body>
    <div class="navbar">
        <nav>
            <h2 class="logo">STOCK <span>TRACKING</span></h2>
            <ul>
                <li><a href="Inventory.html">Inventory</a></li>
                <li><a href="AddResource.html">Add Resources</a></li>
                <li><a href="Report.html">Report</a></li>
            </ul>
            <?php if (isset($user)): ?>
                <a href="logout.php"><button type="button" class="logout-button">Log Out</button></a>
            <?php endif; ?>
        </nav>
    </div>
    <div class="Department">
        <h2 style="color: #fff; text-decoration: underline; text-align: right; margin-right: 20px;">School Of Computer Science, Engineering & Applications</h2>
    </div>
</body>
</html>
