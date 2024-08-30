<header class="header">
    <div class="header_body">
        <a href="index.php" class="logo">TechnoBling</a>
        <nav class="navbar">
            <a href="index.php">Add Products</a>
            <a href="view_products.php">View Products</a>
            <a href="shopit.php">Shop it</a>
        </nav>
        <!-- Shopping cart icon -->
        <a href="" class="cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <?php if (!empty($_SESSION['cart'])): ?>
                <span><sup><?php echo array_sum(array_column($_SESSION['cart'], 'quantity')); ?></sup></span>
            <?php endif; ?> 
 
        <!-- <div id="menu-btn" class="fas fa-bars"></div> -->
    </div>
</header>
