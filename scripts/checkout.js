function buy() {
    const customerId = localStorage.getItem('customer_id');
    const shippingInfo = JSON.parse(localStorage.getItem('shippingInfo'));
    const orderTotal = parseFloat(localStorage.getItem('orderTotal'));

    if (!customerId || !shippingInfo || !orderTotal) {
        console.error('Missing required information to complete the purchase');
        return;
    }
    
    fetch('process_checkout.php?customer_id=' + customerId)
        .then(response => response.json())
        .then(cartItems => {

            if (cartItems.length === 0) {
                alert('Cart is empty');
                return;
            }

            const orderData = cartItems.map(item => ({
                productId: item.PRODUCT_ID,
                quantity: item.PRODUCT_QUANTITY,
                customerId: customerId
            }));

            const orderDetailData = {
                shippingAddress: shippingInfo.address,
                orderAmount: orderTotal,
                orderStatus: 0 // Assume 0 for pending status
            };

            return fetch('process_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ orderData, orderDetailData })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('Order successfully placed');
                    return fetch('decrease_stock.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ orderData })
                    });
                } else {
                    throw new Error('Error placing order: ' + data.message);
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('Stock successfully decreased');
                    localStorage.removeItem('orderTotal');
                    clearCart(customerId);
                    alert('Order successfully placed');
                } else {
                    throw new Error('Error decreasing stock: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
}

function clearCart(customerId) {
    fetch(`clear_cart.php?customer_id=${customerId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Successfully cleared cart', data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function fetchCartData() {
    const customerId = localStorage.getItem('customer_id');

    fetch(`process_checkout.php?customer_id=${customerId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            displayCartItems(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function displayCartItems(items) {
    const productList = document.getElementById('product-list');
    let subtotal = 0;
    const promises = [];

    items.forEach(item => {
        const fetchPromise = fetch(`process_product.php?PRODUCT_ID=${item.PRODUCT_ID}`)
            .then(response => response.json())
            .then(productData => {
                if(productData[0].PRODUCT_STOCK <= 0){
                    alert('Sorry, some product is out of stock, Remove it from cart and try again.');
                    window.location.href = '../';
                    return;
                }
                if (productData.length > 0) {
                    const product = productData[0];
                    const price = parseFloat(product.PRODUCT_PRICE);
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${product.PRODUCT_NAME}</td>
                        <td>${item.PRODUCT_QUANTITY}</td>
                        <td>$${(price * item.PRODUCT_QUANTITY).toFixed(2)}</td>
                    `;
                    subtotal += price * item.PRODUCT_QUANTITY;
                    return row;
                }
            })
            .catch(error => console.error('Error fetching product data:', error));

        promises.push(fetchPromise);
    });

    Promise.all(promises)
        .then(rows => {
            productList.innerHTML = '';
            rows.forEach(row => {
                if (row) productList.appendChild(row);
            });
            recalculateTotals(subtotal);
        })
        .catch(error => console.error('Error displaying cart items:', error));
}

function recalculateTotals(subtotal) {
    const tax = subtotal * 0.08;
    const orderTotal = subtotal + tax + 2.00;

    localStorage.setItem('orderTotal', orderTotal);

    document.getElementById('subtotal').innerText = `Subtotal: $${subtotal.toFixed(2)}`;
    document.getElementById('tax').innerText = `Tax: $${tax.toFixed(2)}`;
    document.getElementById('order-total').innerText = `Order Total: $${orderTotal.toFixed(2)}`;
}

document.addEventListener('DOMContentLoaded', () => {
    fetchCartData();
    const shippingInfo = JSON.parse(localStorage.getItem('shippingInfo'));
    updateShippingInformation(shippingInfo);
});

function updateShippingInformation(shippingInfo) {
    const defaultShippingInfo = {
        name: 'Default Name',
        address: 'Default Address',
    };

    shippingInfo = shippingInfo || defaultShippingInfo;

    document.getElementById('shipping-name').innerText = shippingInfo.name;
    document.getElementById('shipping-address').innerText = shippingInfo.address;
}

document.getElementById('edit-shipping').addEventListener('click', function() {
    const form = document.getElementById('shipping-form');
    if (form) {
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    }
});

document.getElementById('submit-shipping').addEventListener('click', function() {
    const nameInput = document.getElementById('shipping-name-input');
    const addressInput = document.getElementById('shipping-address-input');

    if (!nameInput || !addressInput) {
        console.error('Shipping input fields missing');
        return;
    }

    document.getElementById('shipping-name').innerText = nameInput.value;
    document.getElementById('shipping-address').innerText = addressInput.value;

    const form = document.getElementById('shipping-form');
    if (form) {
        form.style.display = 'none';
    }
    localStorage.setItem('shippingInfo', JSON.stringify({
        name: nameInput.value,
        address: addressInput.value
    }));
    localStorage.setItem('shippingAddress', addressInput.value);
});

document.getElementById('buy-button').addEventListener('click', buy);
