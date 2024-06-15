<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../styles/shop.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/footer_section.css">
    <script src="../scripts/navbar.js" defer></script>
    <script src="../scripts/shop.js" defer></script>
    <title>Shop</title>
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
    <?php include '../navbar/navbar.php';?>

    <div class="banner">
        <img src="../images/banner.PNG" alt="Banner Image">
    </div>

    <div class="slogan">
        <h2>Discover Fresh and Delicious Products!</h2>
        <p>Handpicked just for you, to enjoy the best quality and taste.</p>
    </div>

    <div class="main-section">
        <div class="sidenav">
            <div class="search-box">
                <input type="text" id="search" placeholder="Search for products...">
            </div>
            <div class="rating">
                <span data-value="1">&#9734;</span>
                <span data-value="2">&#9734;</span>
                <span data-value="3">&#9734;</span>
                <span data-value="4">&#9734;</span>
                <span data-value="5">&#9734;</span>
            </div>
            <button id="clear-filter" class="clear-button" style="font-size: smaller;">Clear</button>
        </div>

        <div class="container" id="products-container"></div>
    </div>

    <footer>
        <?php include '../footer/footer_section.php';?>
    </footer>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    
    fetch('./fetch_products.php')
        .then(response => response.json())
        .then(productList => {
            localStorage.setItem('productList', JSON.stringify(productList));
            const productsContainer = document.getElementById('products-container');
            const isTraderLoggedIn = localStorage.getItem('trader_id');
            const isCustomerLoggedIn = localStorage.getItem('customer_id');

            const filteredProductList = isTraderLoggedIn ? productList.filter(product => parseInt(product.category_id) === parseInt(isTraderLoggedIn)) : productList;
            localStorage.setItem('productList', JSON.stringify(filteredProductList));

            filteredProductList.forEach(product => {
                const productCard = document.createElement('div');
                productCard.classList.add('product-card');
                productCard.setAttribute('data-category', product.category_id);
                productCard.setAttribute('data-productId', product.product_id);
                productCard.setAttribute('data-price', product.product_price);
                productCard.setAttribute('data-stock', product.product_stock);

                const imageSource = product.upload ? product.upload : 'https://via.placeholder.com/800x400';
                let priceDisplay = `$${product.product_price.toFixed(2)}`;

                productCard.innerHTML = `
                    <img src="${imageSource}" alt="${product.product_name}">
                    <div class="info">
                        <h4>${product.product_name}</h4>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i> 
                        </div>
                        <p style="margin-top:2px;">Price: ${priceDisplay}</p>
                        <p>Stock: ${product.product_stock}</p>
                    </div>
                    <div class="buttons">
                        ${isTraderLoggedIn ? '' : `<button class="button add-to-cart" data-productId="${product.product_id}" data-productName="${product.product_name}" data-stock="${product.product_stock}" data-price="${product.product_price.toFixed(2)}">Add to Cart</button>`}
                    </div>
                `;
                productsContainer.appendChild(productCard);
            });

            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', addToCart);
            });
        })
        .catch(error => console.error('Error fetching products:', error));
});

document.addEventListener('click', function (event) {
    if (event.target.tagName === 'H4') {
        const productCard = event.target.closest('.product-card');
        const productId = productCard.getAttribute('data-productId');
        window.location.href = `../product_detail/product_detail.php?product_id=${productId}`;
    }
});


function addToCart(event) {
    const button = event.target;
    const productId = button.getAttribute('data-productId');
    const productName = button.getAttribute('data-productName');
    const customer_id = localStorage.getItem('customer_id');

    if(button.getAttribute('data-stock') <= 0) {
        alert('Product is out of stock.');
        return;
    }

    if (!customer_id) {
        alert('Customer ID not found. Please log in.');
        return;
    }

    const data = {
        operation: 'AddToCart',
        customer_id: customer_id,
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

    </script>
</body>
</html>