<?php include "header.php"; ?>

<!-- Page Header Start -->
<div class="container-fluid position-relative text-white d-flex align-items-center justify-content-center"
    style="background: url('image/banner/banner2.jpg') center center / cover no-repeat; height:400px;">

    <!-- Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100  opacity-50"></div>

    <!-- Content -->
    <div class="position-relative text-center">

        <ol class="breadcrumb justify-content-center mb-0">
            <h1 class="display-4 fw-bold text-white mb-2">Donation</h1>
        </ol>
    </div>

</div>

<!-- Donation Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
            <p class="section-title bg-white text-center text-primary px-3">Donation</p>
            <h1 class="display-6 mb-4">Our Donation Causes Around the World</h1>
        </div>
        <?php

        $sql = "SELECT * FROM donation_categories 
        WHERE status = 1 
        ORDER BY created_at DESC";

        $result = $conn->query($sql);

        ?>
        <div class="row g-4">

            <?php
            if ($result->num_rows > 0):

                while ($row = $result->fetch_assoc()):
            ?>
                    <div class="col-md-6 col-lg-4">

                        <div class="donation-item d-flex h-100 p-4">

                            <div class="donation-detail">

                                <img class="img-fluid w-100 mb-3"
                                    src="admin/uploads/donation-categories/<?= htmlspecialchars($row['image']) ?>"
                                    alt="<?= htmlspecialchars($row['title']) ?>">

                                <a href="donate.php?campaign=<?= urlencode($row['slug']) ?>"
                                    class="h4 d-inline-block">

                                    <?= htmlspecialchars($row['title']) ?>

                                </a>

                                <p>
                                    <?= htmlspecialchars($row['short_description']) ?>
                                </p>

                                <a href="donate.php?campaign=<?= urlencode($row['slug']) ?>"
                                    class="btn btn-primary w-100 py-3">

                                    Donate Now

                                </a>

                            </div>

                        </div>

                    </div>

            <?php endwhile;
            endif; ?>

        </div>
    </div>
</div>
<!-- Donation End -->


<?php include "footer.php"; ?>