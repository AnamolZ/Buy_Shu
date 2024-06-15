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

if ($customer_id > 0) {
    $stmt_delete = $conn->prepare("DELETE FROM CART WHERE CUSTOMER_ID = ?");
    $stmt_delete->bind_param("i", $customer_id);
    $stmt_delete->execute();
    $stmt_delete->close();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Cart cleared successfully']);
?>
