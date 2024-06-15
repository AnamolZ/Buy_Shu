<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../styles/checkout.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/footer_section.css">
</head>
<body>
    <?php include '../navbar/navbar.php'; ?>
    <div class="container">
        <div class="panel">
            <section class="shipping">
                <h2>Shipping Information</h2>
                <p id="shipping-name">Shipping Name</p>
                <p id="shipping-address">Shipping Address</p>
                <p>Standard Shipping: $2.00</p>
                <button id="edit-shipping" class="edit_button_class">Edit</button>

                <div class="form" id="shipping-form" style="display: none;">
                    <label for="shipping-name-input">Name</label>
                    <input type="text" id="shipping-name-input" value="" placeholder="Name">

                    <label for="shipping-address-input">Address</label>
                    <input type="text" id="shipping-address-input" value="" placeholder="Address">

                    <button id="submit-shipping">Save Changes</button>
                </div>
            </section>
            
            <section class="payment">
                <h2>Payment Section</h2>
                <button id="buy-button" class="paypal-button">Pay with PayPal</button>
            </section>
        </div>
        
        <div class="panel">
            <section class="cart">
                <h2>Shopping Cart</h2>
                <table id="cart-items">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="product-list"></tbody>
                </table>
                <div class="summary">
                    <p id="subtotal">Subtotal: $0.00</p>
                    <p>Shipping Fee: $2.00</p>
                    <p id="tax">Tax: $0.00</p>
                    <h3 id="order-total">Order Total: $0.00</h3>
                </div>
            </section>
        </div>
    </div>

    <script src="../scripts/checkout.js"></script>
    <footer>
        <?php include '../footer/footer_section.php';?>
    </footer>
</body>
</html>
