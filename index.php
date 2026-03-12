<?php 
// Include the global header (This already contains your working Logo and Nav!)
include "includes/header.php"; 
?>

<div class="px-4 py-5 my-5 text-center bg-light rounded-3 shadow-sm">
    <h1 class="display-4 fw-bold text-dark">Cook Without Limits</h1>
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">KitchenHop connects talented chefs with professional, fully-equipped kitchen spaces. Rent by the hour and scale your food business.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a class="btn btn-primary btn-lg px-4 gap-3" href="/register.php">Get Started Now</a>
            <a class="btn btn-outline-secondary btn-lg px-4" href="/kitchens.php">Browse Kitchens</a>
        </div>
    </div>
</div>

<hr class="my-5">

<div class="row g-4 py-4 row-cols-1 row-cols-md-2">
    <div class="col d-flex align-items-start">
        <div class="card border-0 shadow-sm w-100 h-100 p-4">
            <h3 class="fw-bold mb-3 fs-4 text-primary">For Chefs</h3>
            <p>Find verified, professional kitchens and book them hourly. Focus on your menu while we handle the space. No long-term leases required.</p>
            <div class="mt-auto">
                <a href="/register.php" class="btn btn-outline-primary">Join as Chef</a>
            </div>
        </div>
    </div>
    
    <div class="col d-flex align-items-start">
        <div class="card border-0 shadow-sm w-100 h-100 p-4">
            <h3 class="fw-bold mb-3 fs-4 text-success">For Kitchen Owners</h3>
            <p>Monetize your unused kitchen downtime. List your commercial kitchen, set your own hourly rate, and easily approve or reject booking requests.</p>
            <div class="mt-auto">
                <a href="/register.php" class="btn btn-outline-success">List Your Kitchen</a>
            </div>
        </div>
    </div>
</div>

<?php 
// Include the global footer (Pushes copyright to the bottom)
include "includes/footer.php"; 
?>