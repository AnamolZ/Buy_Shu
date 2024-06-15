function saveChanges() {
    let trader_id = localStorage.getItem('trader_id');
    let name = document.getElementById('trader-name').value;
    let password = document.getElementById('trader-pass').value;
    let email = document.getElementById('email-address').value;

    let formData = new FormData();
    formData.append('action', 'updateTrader');
    formData.append('trader_id', trader_id);
    formData.append('name', name);
    formData.append('password', password);
    formData.append('email', email);

    fetch('trader_profile.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text())
      .then(result => {
          console.log(result);
          alert("Trader information updated successfully!");
      }).catch(error => {
          console.error('Error:', error);
      });
}

function addProduct() {
    let trader_id = localStorage.getItem('trader_id');
    let name = document.getElementById('product-name').value;
    let price = document.getElementById('product-price').value;
    let stock = document.getElementById('product-stock').value;
    let detail = document.getElementById('product-detail').value;
    let allergy = document.getElementById('allergy-information').value;
    let category_id = localStorage.getItem('trader_id');
    let upload = document.getElementById('product-image').files[0];

    let formData = new FormData();
    formData.append('action', 'addProduct');
    formData.append('trader_id', trader_id);
    formData.append('name', name);
    formData.append('price', price);
    formData.append('stock', stock);
    formData.append('detail', detail);
    formData.append('allergy', allergy);
    formData.append('category_id', category_id);
    formData.append('upload', upload);

    fetch('trader_profile.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text())
      .then(result => {
          console.log(result);
          alert("Product added successfully!");
      }).catch(error => {
          console.error('Error:', error);
      });
}

function printOperation() {
    let operation = document.getElementById('operation-select').value;
    let product_id = document.getElementById('product_id_').value;
    let name = document.getElementById('product_name_').value;
    let price = document.getElementById('product_price_').value;
    let stock = document.getElementById('product_stock_').value;
    let detail = document.getElementById('product_detail_').value;
    let allergy = document.getElementById('allergy_info_').value;
    let upload = document.getElementById('product-image_').files[0];

    let formData = new FormData();
    formData.append('action', operation);
    formData.append('product_id', product_id);
    formData.append('name', name);
    formData.append('price', price);
    formData.append('stock', stock);
    formData.append('detail', detail);
    formData.append('allergy', allergy);
    formData.append('upload', upload);

    fetch('trader_profile.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text())
      .then(result => {
          console.log(result);
          alert("Product operation completed successfully!");
      }).catch(error => {
          console.error('Error:', error);
      });
}
