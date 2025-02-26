<?php require("layouts/headerFrontPage.php"); ?>
<div class="container pt-5 pb-3 bg-yellow">
  <h1 class="pt-5" style="font-family: 'Poppins', sans-serif; font-weight: bold;">Welcome to Pet Care</h1>
  <p style="font-family: 'Poppins', sans-serif; ">"Pet grooming straight from the heart. Your pet — our passion, we care."</p>
</div>
<!-- Content ends -->

<!-- Carousel start -->
<div id="carouselExampleCaptions" class="carousel carousel-fade" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
<center>
  <div class="carousel-inner">
    <div class="carousel-item active">
        <img src="public/static_system/uploads/1.png" class="d-block w-100" height="700px" alt="...">
        <div class="carousel-caption d-none d-md-block">
            <h5>First slide label</h5>
            <p>Some representative placeholder content for the first slide.</p>
        </div>
    </div>
    
    <div class="carousel-item">
        <img src="public/static_system/uploads/2.png" class="d-block w-100" height="700px" alt="...">
        <div class="carousel-caption d-none d-md-block">
            <h5>Second slide label</h5>
            <p>Some representative placeholder content for the second slide.</p>
        </div>
    </div>
    
    <div class="carousel-item">
        <img src="public/static_system/uploads/3.png" class="d-block w-100" height="700px" alt="...">
        <div class="carousel-caption d-none d-md-block">
            <h5>Third slide label</h5>
            <p>Some representative placeholder content for the third slide.</p>
      </div>
    </div>
  </div>
</center>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<?php require("layouts/footerFrontPage.php"); ?>