<?php include "header.php"; ?>
 <!-- Page Header Start -->
<div class="container-fluid position-relative text-white d-flex align-items-center justify-content-center"
     style="background: url('image/banner/banner2.jpg') center center / cover no-repeat; height:400px;">

    <!-- Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100  opacity-50"></div>

    <!-- Content -->
    <div class="position-relative text-center">

        <ol class="breadcrumb mb-0">
             <h1 class="display-4 fw-bold text-white mb-2">Certification</h1>
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
                                <th>Document Name</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">

                            <tr>
                                <td>1</td>
                                <td>Registration - Certificate</td>
                                <td>31-12-2021</td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                        <a href="pdf/order_registration.pdf" target="_blank"
                                           class="btn btn-sm btn-primary">
                                           View
                                        </a>

                                        <a href="pdf/order_registration.pdf" download
                                           class="btn btn-sm btn-danger">
                                           Download
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>CSR - CERTIFICATE</td>
                                <td>23-09-2021</td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                        <a href="pdf/Corporate_Affairs_Registrar.pdf" target="_blank"
                                           class="btn btn-sm btn-primary">
                                           View
                                        </a>

                                        <a href="pdf/Corporate_Affairs_Registrar.pdf" download
                                           class="btn btn-sm btn-danger">
                                           Download
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
</div>
<?php include "footer.php"; ?>