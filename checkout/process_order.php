<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "buy_shu";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

$orderData = $data['orderData'];
$orderDetailData = $data['orderDetailData'];

// Insert payment info and get PAYMENT_ID
$paymentQuery = "INSERT INTO PAYMENT (PAYMENT_AMOUNT) VALUES (?)";
$stmt = $conn->prepare($paymentQuery);
$stmt->bind_param("d", $orderDetailData['orderAmount']);
if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Payment processing failed']);
    exit;
}
$paymentId = $stmt->insert_id;
$stmt->close();

$orderDetailQuery = "INSERT INTO ORDER_DETAIL (SHIPPING_ADDRESS, ORDER_AMOUNT, PAYMENT_ID, ORDER_STATUS) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($orderDetailQuery);
$stmt->bind_param("siii", $orderDetailData['shippingAddress'], $orderDetailData['orderAmount'], $paymentId, $orderDetailData['orderStatus']);
if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Order detail processing failed']);
    exit;
}
$orderDetailId = $stmt->insert_id;
$stmt->close();

foreach ($orderData as $order) {
    $productId = $order['productId'];
    $quantity = $order['quantity'];
    $customerId = $order['customerId'];

    $orderQuery = "INSERT INTO ORDERS (PRODUCT_ID, CUSTOMER_ID, PAYMENT_ID, PRODUCT_QUANTITY) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($orderQuery);
    $stmt->bind_param("iiii", $productId, $customerId, $paymentId, $quantity);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Order processing failed']);
        exit;
    }
    $stmt->close();
}

echo json_encode(['success' => true, 'message' => 'Order placed successfully']);

$conn->close();
?>
