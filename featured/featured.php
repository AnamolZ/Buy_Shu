<link rel="stylesheet" href="./styles/featured.css">
<!-- <script src="../scripts/featured.js"></script> -->

<h1 class="title-shop" id="fp">Featured Products</h1>
<main class="main bd-grid">
    <!-- Static Product Card -->
    <article class="card" data-productId="1">
        <div class="card__img" data-productId="1">
            <img src="../uploads/Pineapple.png" alt="">
        </div>
        <div class="card__name" data-productId="1">
            <h4 data-productId="1">Pineapple</h4>
        </div>
        <div class="card__precis">
            
            <div>
                <span class="card__preci card__preci--before">Pineapple</span>
                <span class="card__preci card__preci--now">$3</span>
            </div>
            <a href="#" class="card__icon addToCart" onclick="addToCart()" data-productId="1"><ion-icon name="cart-outline"></ion-icon></a>
        </div>
    </article>

    <article class="card" data-productId="1">
        <div class="card__img" data-productId="1">
            <img src="../uploads/Chicken Wings.png" alt="">
        </div>
        <div class="card__name" data-productId="1">
            <h4 data-productId="1">Chicken Wings</h4>
        </div>
        <div class="card__precis">
            
            <div>
                <span class="card__preci card__preci--before">Chicken Wings</span>
                <span class="card__preci card__preci--now">$5</span>
            </div>
            <a href="#" class="card__icon addToCart" onclick="addToCart()" data-productId="1"><ion-icon name="cart-outline"></ion-icon></a>
        </div>
    </article>


    <article class="card" data-productId="1">
        <div class="card__img" data-productId="1">
            <img src="../uploads/Lemon Tart.png" alt="">
        </div>
        <div class="card__name" data-productId="1">
            <h4 data-productId="1">Lemon Tart</h4>
        </div>
        <div class="card__precis">
            
            <div>
                <span class="card__preci card__preci--before">Lemon Tart</span>
                <span class="card__preci card__preci--now">$3</span>
            </div>
            <a href="#" class="card__icon addToCart" onclick="addToCart()" data-productId="1"><ion-icon name="cart-outline"></ion-icon></a>
        </div>
    </article>

    <article class="card" data-productId="1">
        <div class="card__img" data-productId="1">
            <img src="../uploads/Apple Pie.png" alt="">
        </div>
        <div class="card__name" data-productId="1">
            <h4 data-productId="1">Apple Pie</h4>
        </div>
        <div class="card__precis">
            
            <div>
                <span class="card__preci card__preci--before">Apple Pie</span>
                <span class="card__preci card__preci--now">$6</span>
            </div>
            <a href="#" class="card__icon addToCart" onclick="addToCart()" data-productId="1"><ion-icon name="cart-outline"></ion-icon></a>
        </div>
    </article>





    <article class="card" data-productId="1">
        <div class="card__img" data-productId="1">
            <img src="../uploads/Whole Lobster.png" alt="">
        </div>
        <div class="card__name" data-productId="1">
            <h4 data-productId="1">Whole Lobster</h4>
        </div>
        <div class="card__precis">
            
            <div>
                <span class="card__preci card__preci--before">Whole Lobster</span>
                <span class="card__preci card__preci--now">$25</span>
            </div>
            <a href="#" class="card__icon addToCart" onclick="addToCart()" data-productId="1"><ion-icon name="cart-outline"></ion-icon></a>
        </div>
    </article>


    <article class="card" data-productId="1">
        <div class="card__img" data-productId="1">
            <img src="../uploads/Cabbage.png" alt="">
        </div>
        <div class="card__name" data-productId="1">
            <h4 data-productId="1">Cabbage</h4>
        </div>
        <div class="card__precis">
            
            <div>
                <span class="card__preci card__preci--before">Cabbage</span>
                <span class="card__preci card__preci--now">$3</span>
            </div>
            <a href="#" class="card__icon addToCart" onclick="addToCart()" data-productId="1"><ion-icon name="cart-outline"></ion-icon></a>
        </div>
    </article>


    <article class="card" data-productId="1">
        <div class="card__img" data-productId="1">
            <img src="../uploads/Duck Breasts.png" alt="">
        </div>
        <div class="card__name" data-productId="1">
            <h4 data-productId="1">Duck Breasts</h4>
        </div>
        <div class="card__precis">
            
            <div>
                <span class="card__preci card__preci--before">Duck Breasts</span>
                <span class="card__preci card__preci--now">$15</span>
            </div>
            <a href="#" class="card__icon addToCart" onclick="addToCart()" data-productId="1"><ion-icon name="cart-outline"></ion-icon></a>
        </div>
    </article>


    <article class="card" data-productId="1">
        <div class="card__img" data-productId="1">
            <img src="../uploads/Broccoli.png" alt="">
        </div>
        <div class="card__name" data-productId="1">
            <h4 data-productId="1">Broccoli</h4>
        </div>
        <div class="card__precis">
            
            <div>
                <span class="card__preci card__preci--before">Broccoli</span>
                <span class="card__preci card__preci--now">$2</span>
            </div>
            <a href="#" class="card__icon addToCart" onclick="addToCart()" data-productId="1"><ion-icon name="cart-outline"></ion-icon></a>
        </div>
    </article>
</main>

<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script>
    function addToCart() {
        alert(`Demo Product has been added to your cart!`);
    }
</script>