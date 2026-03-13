<?php include "header.php"; ?>
<!-- Page Header Start -->
<div class="container-fluid position-relative text-white d-flex align-items-center justify-content-center"
    style="background: url('image/banner/banner2.jpg') center center / cover no-repeat; height:400px;">

    <!-- Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100  opacity-50"></div>

    <!-- Content -->
    <div class="position-relative text-center">
        <ol class="breadcrumb justify-content-center mb-0">
            <h1 class="display-4 fw-bold text-white mb-2">Videos Gallery</h1>
        </ol>
    </div>

</div>

<!-- Page Header End -->

<section class="py-5 bg-light">
    <div class="container">

        <h2 class="text-center mb-5 fw-bold">Videos Gallery</h2>

        <div class="row g-4">
            <?php
            $sql = "SELECT * FROM galleries WHERE gallery_type = 'video' ORDER BY created_at DESC";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()):
            ?>
                <!-- Video 1 -->
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card border-0 shadow h-100">
                        <div class="ratio ratio-16x9">
                            <iframe src="/admin/uploads/gallery/<?php echo $row['image_path']; ?>" allowfullscreen></iframe>
                        </div>
                        <div class="card-body text-center">
                            <h6 class="fw-bold text-success"><?php echo $row['title']; ?></h6>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <!-- Comming Soon if $video not found -->
            <?php if ($result->num_rows == 0): ?>
                <div class="col-12">
                    <div class="card border-0 h-100">
                        <div class="card-body text-center">
                            <h3 class="fw-bold text-secondary">No Videos Found</h3>
                            <p class="text-muted">Please check back later for updates.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include "footer.php"; ?>