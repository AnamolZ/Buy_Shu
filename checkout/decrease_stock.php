<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "buy_shu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$input = json_decode(file_get_contents('php://input'), true);
$orderData = $input['orderData'];

foreach ($orderData as $orderItem) {
    $productId = $orderItem['productId'];
    $quantity = $orderItem['quantity'];

    $stmt_update = $conn->prepare("UPDATE PRODUCT SET PRODUCT_STOCK = PRODUCT_STOCK - ? WHERE PRODUCT_ID = ?");
    $stmt_update->bind_param("ii", $quantity, $productId);
    $stmt_update->execute();
    $stmt_update->close();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Stock decreased successfully']);
?>
