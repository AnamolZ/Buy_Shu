<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "buy_shu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

if ($product_id > 0) {
    $sql = "SELECT PRODUCT_ID, PRODUCT_NAME, PRODUCT_PRICE, PRODUCT_STOCK, PRODUCT_DETAIL, ALLERGY_INFORMATION, UPLOAD FROM PRODUCT WHERE PRODUCT_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        $product = null;
    }
    $stmt->close();
} else {
    $product = null;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="../styles/product.css">
    <link rel="stylesheet" href="../styles/checkout.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/footer_section.css">
    <style>
        .rating {
            font-size: 0.6em;
            display: flex;
            align-items: center;
        }
        .rating .fa-star,
        .rating .fa-star-half-alt {
            color: #FFD700;
            margin-right: 2px;
        }
    </style>
</head>
<body>
    <main class="content-wrapper">
        <?php include '../navbar/navbar.php'; ?>
        <div class="card">
            <nav>
                <a href="../">
                <svg class="arrow" viewBox="0 0 512 512" width="30px">
                    <polygon points="352,115.4 331.3,96 160,256 331.3,416 352,396.7 201.5,256" stroke="#727272"/>
                </svg>
                </a>
                    <svg class="heart" viewBox="0 0 512 512" width="30px">
                    </svg>
            </nav>
            <div class="photo">
                <img src="<?php echo $product['UPLOAD'] ? htmlspecialchars($product['UPLOAD']) : 'https://via.placeholder.com/800x400'; ?>" class="product-img" alt="Product Image">
            </div>
            <div class="description">
                <h2 id="product-name"><?php echo htmlspecialchars($product['PRODUCT_NAME']); ?></h2>
                <h1 id="product-price">$<?php echo number_format($product['PRODUCT_PRICE'], 2); ?></h1>
                <div class="rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i> 
                </div>
                <div class="info-row">
                    <p id="product-stock">Stock: <?php echo (int)$product['PRODUCT_STOCK']; ?></p>
                    <p id="allergy-info">Allergy Information: <?php echo htmlspecialchars($product['ALLERGY_INFORMATION']); ?></p>
                </div>
                <p id="product-detail"><?php echo htmlspecialchars($product['PRODUCT_DETAIL']); ?></p>
                <button onclick="addToCart()" class="atc" id="at_cid" data-product-id="<?php echo $product['PRODUCT_ID']; ?>" data-product-name="<?php echo htmlspecialchars($product['PRODUCT_NAME']); ?>" data-product-price="<?php echo number_format($product['PRODUCT_PRICE'], 2); ?>" data-product-stock="<?php echo (int)$product['PRODUCT_STOCK']; ?>">Add to Cart</button>
                <button class="w_lst" id="w_lst" onclick="buy()">Buy</button>
            </div>
        </div>
    </main>

    <?php include '../footer/footer_section.php'; ?>

    <script src="../scripts/product.js"></script>
    <script>
        function addToCart() {
            const button = document.getElementById('at_cid');
            const productId = button.getAttribute('data-product-id');
            const productName = button.getAttribute('data-product-name');
            const productStock = button.getAttribute('data-product-stock');
            const customerId = localStorage.getItem('customer_id');

            if (parseInt(productStock) <= 0) {
                alert('Product is out of stock.');
                return;
            }

            if (!customerId) {
                alert('Customer ID not found. Please log in.');
                return;
            }

            const data = {
                operation: 'AddToCart',
                customer_id: customerId,
                product_id: productId
            };

            fetch('addToCart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`${productName} has been added to your cart!`);
                } else {
                    alert('Product is already in cart.');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Failed to add product to cart. Please try again.');
            });
        }

        function buy() {
            const customer_id = localStorage.getItem('customer_id');
            if (!customer_id) {
                alert('Please login to buy items!');
                return;
            }
            else{
                addToCart();
                window.location.href = '../checkout/checkout.php';
            }
        }
    </script>
</body>
</html>
