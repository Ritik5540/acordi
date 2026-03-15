<?php include "header.php"; ?>
<!-- Page Header Start -->
<div class="container-fluid position-relative text-white d-flex align-items-center justify-content-center"
    style="background: url('image/banner/banner3.jpg') center center / cover no-repeat; height:400px;">

    <!-- Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100  opacity-50"></div>

    <!-- Content -->
    <div class="position-relative text-center">

        <ol class="breadcrumb mb-0">
            <h1 class="display-4 fw-bold text-white mb-2">Work Orders from Different Government Agencies</h1>
        </ol>
    </div>

</div>

<!-- Page Header End -->
<div class="container-fluid">
    <div class="row justify-content-center">

        <!-- COLUMN -->
        <div class="col-12 col-md-11 col-lg-10 my-4">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h6 class="mb-0">Document List</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle m-0">
                            <thead class="bg-success text-white">
                                <tr class="text-center">
                                    <th>Sl. No.</th>
                                    <!-- <th>Document Type</th> -->
                                    <th>Document Name</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php

                            $sql = "SELECT * FROM documents WHERE document_type = 'workorder' ORDER BY title ASC";
                            $result = $conn->query($sql);

                            ?>
                            <tbody class="text-center">

                                <?php if ($result->num_rows > 0): ?>

                                    <?php $i = 1;
                                    while ($row = $result->fetch_assoc()): ?>

                                        <tr>

                                            <td><?= $i++ ?></td>


                                            <td><?= htmlspecialchars($row['title']) ?></td>

                                            <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>

                                            <td>

                                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">

                                                    <a href="uploads/documents/<?= urlencode($row['file_path']) ?>"
                                                        target="_blank"
                                                        class="btn btn-sm btn-primary">
                                                        View
                                                    </a>

                                                    <a href="admin/uploads/documents/<?= urlencode($row['file_path']) ?>"
                                                        download
                                                        class="btn btn-sm btn-danger">
                                                        Download
                                                    </a>

                                                </div>

                                            </td>

                                        </tr>

                                    <?php endwhile; ?>

                                <?php else: ?>

                                    <tr>
                                        <td colspan="4">No documents found</td>
                                    </tr>

                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>