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
<div class="row m-0 p-0 justify-content-center">

        <!-- LEFT COLUMN -->
        <div class="col-12 col-md-10 m-0 p-0 my-5">
            <div class="card m-0 p-0">
                <div class="card-header text-center bg-primary text-white p-2">
                    Document List
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle m-0">
                            <thead class="bg-success text-white">
                                <tr style="font-size:14px;">
                                    <th width="10%">Sl. No.</th>
                                    <th width="55%">Document Name</th>
                                    <th width="15%">Date</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody style="font-size:14px;">
                                <tr>
                                    <td>1</td>
                                    <td>Order for registration</td>
                                    <td>31-12-2021</td>
                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <a href="pdf/order_registration.pdf" target="_blank"
                                               class="btn btn-sm btn-primary">View</a>
                                            <a href="pdf/order_registration.pdf"
                                               class="btn btn-sm btn-danger" download>Download</a>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>Government of India Ministry of Corporate Affairs Registrar of Companies Office</td>
                                    <td>23-09-2021</td>
                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <a href="pdf/Corporate_Affairs_Registrar.pdf" target="_blank"
                                               class="btn btn-sm btn-primary">View</a>
                                            <a href="pdf/Corporate_Affairs_Registrar.pdf"
                                               class="btn btn-sm btn-danger" download>Download</a>
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