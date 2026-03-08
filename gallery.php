<?php include "header.php"; ?>
 <!-- Page Header Start -->
<div class="container-fluid position-relative text-white d-flex align-items-center justify-content-center"
     style="background: url('image/banner/banner2.jpg') center center / cover no-repeat; height:400px;">

    <!-- Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100  opacity-50"></div>

    <!-- Content -->
    <div class="position-relative text-center">
        <ol class="breadcrumb justify-content-center mb-0">
            <h1 class="display-4 fw-bold text-white mb-2">Gallery</h1>
        </ol>
    </div>

</div>

    <!-- Page Header End -->

<section class="py-5 bg-light">
<div class="container">
<div class="text-center mb-4">
<h2>Our Gallery</h2>
</div>

<div class="row g-4">

<!-- Image 1 -->
<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card shadow-sm">
<img src="image/about/g1.jpg"
class="card-img-top gallery-img"
data-bs-toggle="modal" 
data-bs-target="#galleryModal"
onclick="openSlider(0)">
</div>
</div>

<!-- Image 2 -->
<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card shadow-sm">
<img src="image/about/g2.jpg"
class="card-img-top gallery-img"
data-bs-toggle="modal" 
data-bs-target="#galleryModal"
onclick="openSlider(1)">
</div>
</div>

<!-- Image 3 -->
<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card shadow-sm">
<img src="image/about/g3.jpg"
class="card-img-top gallery-img"
data-bs-toggle="modal" 
data-bs-target="#galleryModal"
onclick="openSlider(2)">
</div>
</div>

<!-- Image 4 -->
<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card shadow-sm">
<img src="image/about/g4.jpg"
class="card-img-top gallery-img"
data-bs-toggle="modal" 
data-bs-target="#galleryModal"
onclick="openSlider(3)">
</div>
</div>


</div>
</div>

</section>


<!-- Modal Slider -->
<div class="modal fade" id="galleryModal" tabindex="-1">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Gallery Preview</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-0">

<div id="galleryCarousel" class="carousel slide" data-bs-ride="false">
<div class="carousel-inner">

<div class="carousel-item">
<img src="image/about/g1.jpg" class="d-block w-100">
</div>

<div class="carousel-item">
<img src="image/about/g2.jpg" class="d-block w-100">
</div>

<div class="carousel-item">
<img src="image/about/g3.jpg" class="d-block w-100">
</div>

<div class="carousel-item">
<img src="image/about/g4.jpg" class="d-block w-100">
</div>

</div>

<button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
<span class="carousel-control-prev-icon"></span>
</button>

<button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
<span class="carousel-control-next-icon"></span>
</button>

</div>

</div>
</div>
</div>
</div>

<script>
function openSlider(index){
let items = document.querySelectorAll('#galleryCarousel .carousel-item');
items.forEach((item)=>item.classList.remove('active'));
items[index].classList.add('active');
}
</script>

<?php include "footer.php"; ?>