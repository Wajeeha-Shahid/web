<!-- navbar.php -->
<nav class="nav1">
    <div class="left">
        <?php if (isset($_SESSION['username'])): ?>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="/e_commerce/pages/user/logout.php">Logout</a>
        <?php else: ?>
            <a href="/e_commerce/pages/user/register.php">Register</a> OR
            <a href="/e_commerce/pages/user/login.php">Login</a>
            <a href="/e_commerce/pages/admin/admin_panel.php">Admin</a>
        <?php endif; ?>
    </div>
    <div class="right">
        <i class="fab fa-facebook"></i>
        <i class="fab fa-whatsapp"></i>
        <i class="fab fa-twitter"></i>
        <i class="fab fa-instagram"></i>
        <a href="checkout.php"><i class="fas fa-shopping-cart"></i></a>
    </div>
</nav>

<!-- Toggle Button for Mobile -->
<div id="menuToggle">
    <span></span>
    <span></span>
    <span></span>
</div>

<!-- nav 2 start -->
<nav class="nav2">
    <div class="nav2left"> 
        <i class="fa fa-phone"></i>+9237383848
        <i class="fa fa-envelope"></i>anas@gmail.com
    </div>
    <div class="nav2center">
        <h1>Pes<span>Ticides</span></h1>
        <p>Everything for adult world</p>
    </div>
    <div class="nav2right">
        <i class="fa fa-map"></i>Contact us
    </div>
</nav>
<!-- nav 2 end -->

<!-- nav 3 start -->
<nav class="nav3">
    <ul>
        <li><a href="/e_commerce/index.php"><i class="fa fa-home"></i>Home</a></li>
        <li><a href="#"><i class="fa fa-user"></i>Blogs</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="/e_commerce/pages/user/pending_order.php"><i class="fa fa-users"></i>Pending Order</a></li>
            <li><a href="/e_commerce/pages/user/completed_order.php"><i class="fas fa-calendar-check"></i>Completed</a></li>
        <?php endif; ?>
        <li><a href="#"><i class="fab fa-product-hunt"></i>Products<i class="fa fa-caret-down"></i></a>
            <ul>
                <li><a href="/e_commerce/pages/user/products.php?prod_type=pesticides"><i class="fa-solid fa-wine-bottle"></i>Pesticides</a></li>
                <li><a href="/e_commerce/pages/user/products.php?prod_type=fertilizers"><i class="fa-solid fa-bag-shopping"></i>Fertilizers</a></li>
                <li><a href="/e_commerce/pages/user/products.php?prod_type=seeds"><i class="fa-solid fa-seedling"></i>Seeds</a></li>
            </ul>
        </li>
        
    </ul>
</nav>
<!-- nav 3 end -->
