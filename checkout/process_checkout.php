<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "buy_shu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;

$stmt = $conn->prepare("SELECT * FROM CART WHERE CUSTOMER_ID = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

$stmt->close();

header('Content-Type: application/json');
echo json_encode($items);

$conn->close();
?>
