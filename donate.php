<?php
include "header.php";
include "config.php";

$slug = $_GET['campaign'] ?? '';

$stmt = $conn->prepare("SELECT * FROM donation_categories WHERE slug=? LIMIT 1");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();
$campaign = $result->fetch_assoc();

if (!$campaign) {
    echo "Invalid Campaign";
    exit;
}
?>

<!-- Banner -->
<div class="container-fluid position-relative text-white d-flex align-items-center justify-content-center"
    style="background:url('image/banner/banner2.jpg') center/cover;height:400px">

    <div class="text-center">
        <h1 class="display-4 fw-bold text-white mb-2"><?= htmlspecialchars($campaign['title']) ?></h1>
    </div>

</div>


<div class="container-fluid donate py-5">
    <div class="container">
        <div class="row g-0">

            <div class="col-lg-7 donate-text bg-light py-5">
                <div class="p-5">

                    <h2 class="display-6 mb-4"><?= htmlspecialchars($campaign['title']) ?></h2>

                    <p><?= htmlspecialchars($campaign['description']) ?></p>

                    <!-- donation Image -->
                    <img class="img-fluid w-100 mt-4"
                        src="admin/uploads/donation-categories/<?= htmlspecialchars($campaign['image']) ?>"
                        alt="<?= htmlspecialchars($campaign['title']) ?>">

                </div>
            </div>
            <div class="col-lg-5 donate-form bg-primary py-5 text-center">
                <div class="h-100 p-5">

                    <form method="POST" action="donate-process.php">

                        <input type="hidden" name="category_id" value="<?= $campaign['id'] ?>">
                        <input type="hidden" name="campaign_title" value="<?= $campaign['title'] ?>">
                        <input type="hidden" name="website_url" value="<?= $_SERVER['HTTP_HOST'] ?>">

                        <div class="row g-3">

                            <div class="col-12">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>

                            <div class="col-12">
                                <input type="email" name="email" class="form-control" placeholder="Your Email">
                            </div>

                            <div class="col-12">
                                <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
                            </div>

                            <div class="col-6"><input type="text" name="city" class="form-control" placeholder="City" required></div>
                            <div class="col-6"><input type="text" name="state" class="form-control" placeholder="State" required></div>

                            <div class="col-12">
                                <input type="text" name="country" class="form-control" placeholder="Country" value="India" required>
                            </div>


                            <div class="col-12">
                                <textarea name="address" class="form-control" placeholder="Address" required></textarea>
                            </div>

                            <!-- select amount type -->
                            <div class="col-12 mb-2">
                                <select id="amountType" class="form-select">
                                    <option value="preset">Preset Amount</option>
                                    <option value="custom">Custom Amount</option>
                                </select>
                            </div>

                            <!-- preset radio amounts -->
                            <div class="col-12" id="presetBox">

                                <div class="btn-group w-100">

                                    <input type="radio" class="btn-check" name="preset" value="1000" id="a1">
                                    <label class="btn btn-light" for="a1">₹1000</label>

                                    <input type="radio" class="btn-check" name="preset" value="5000" id="a2">
                                    <label class="btn btn-light" for="a2">₹5000</label>

                                    <input type="radio" class="btn-check" name="preset" value="10000" id="a3">
                                    <label class="btn btn-light" for="a3">₹10000</label>

                                    <input type="radio" class="btn-check" name="preset" value="25000" id="a4">
                                    <label class="btn btn-light" for="a4">₹25000</label>

                                </div>

                            </div>

                            <!-- custom amount -->
                            <div class="col-12 mt-2" id="customBox" style="display:none;">
                                <input type="number" name="amount" class="form-control" placeholder="Custom Amount (₹)">
                            </div>

                            <div class="col-12">
                                <textarea name="message" class="form-control" placeholder="Message (Optional)"></textarea>
                            </div>


                            <div class="col-12">
                                <button type="submit" id="payBtn" class="btn btn-secondary py-3 w-100">
                                    <span id="btnText">Pay Now</span>
                                    <span id="btnLoader" style="display:none;">
                                        <span class="spinner-border spinner-border-sm"></span> Processing...
                                    </span>
                                </button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.querySelector("form").addEventListener("submit", function () {

    const btn = document.getElementById("payBtn");
    const text = document.getElementById("btnText");
    const loader = document.getElementById("btnLoader");

    btn.disabled = true;
    text.style.display = "none";
    loader.style.display = "inline-block";

});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const amountType = document.getElementById("amountType");
        const presetBox = document.getElementById("presetBox");
        const customBox = document.getElementById("customBox");
        const radios = document.querySelectorAll('input[name="preset"]');
        const customInput = document.querySelector('input[name="amount"]');

        amountType.addEventListener("change", function() {

            if (this.value === "custom") {
                presetBox.style.display = "none";
                customBox.style.display = "block";

                radios.forEach(r => r.checked = false);
            }

            if (this.value === "preset") {
                presetBox.style.display = "block";
                customBox.style.display = "none";

                customInput.value = "";
            }

            if (this.value === "") {
                presetBox.style.display = "block";
                customBox.style.display = "none";
            }

        });

    });
</script>
<?php include "footer.php"; ?>