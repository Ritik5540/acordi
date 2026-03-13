<?php include "header.php"; ?>
<!-- Page Header Start -->
<div class="container-fluid position-relative text-white d-flex align-items-center justify-content-center"
  style="background: url('image/banner/banner2.jpg') center center / cover no-repeat; height:400px;">

  <!-- Overlay -->
  <div class="position-absolute top-0 start-0 w-100 h-100  opacity-50"></div>

  <!-- Content -->
  <div class="position-relative text-center">
    <ol class="breadcrumb justify-content-center mb-0">
      <h1 class="display-4 fw-bold text-white mb-2">Contact Us</h1>
    </ol>
  </div>

</div>

<!-- Page Header End -->





<!-- Contact Start -->
<div class="container-fluid py-5 pb-0">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <p class="section-title bg-white text-start text-primary pe-3">Contact</p>
        <iframe class="w-100"
          src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d14651.005902220944!2d85.29419134126013!3d23.361016760374174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sH1%20279%2C%20KARTIK%20ORAON%20CHOWK%20HARMU%20COLONY%20RANCHI%2CJHARKHAND%2C834002%2C%20INDIA!5e0!3m2!1sen!2sin!4v1767744910104!5m2!1sen!2sin"
          frameborder="0" style="height: 425px; border:0;" allowfullscreen="" aria-hidden="false"
          tabindex="0"></iframe>
      </div>
      <div class="col-lg-7 wow fadeIn" data-wow-delay="0.3s">

        <h1 class="display-6 mb-4 wow fadeIn" data-wow-delay="0.2s">If You Have Any Query, Please Contact Us
        </h1>
        <?php
        if (isset($_GET['success']) && $_GET['success'] == 'true') {
          echo '<div class="alert alert-success" role="alert">Your message has been sent successfully!</div>';
        } elseif (isset($_GET['success']) && $_GET['success'] == 'false') {
          echo '<div class="alert alert-danger" role="alert">There was an error sending your message. Please try again later.</div>';
        }
        ?>
        <form method="post" action="contact_process.php">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="form-floating">
                <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                <label for="name">Your Name</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                <label for="email">Your Email</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-floating">
                <input type="text" class="form-control only-number" pattern="^\d{10}$" minlength="10" maxlength="10" id="phone" name="phone" placeholder="Phone" required>
                <label for="phone">Phone</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-floating">
                <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                <label for="subject">Subject</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a message here" id="message" name="message"
                  style="height: 250px" required></textarea>
                <label for="message">Message</label>
              </div>
            </div>
            <div class="col-12">
              <button class="btn btn-primary py-3 px-4 send-button" type="submit">Send Message</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Contact End -->
<div class="container my-5 mt-0">
  <div class="bg-white p-4 rounded shadow-sm">

    <h2 class="text-primary fst-italic mb-4">Our Address</h2>

    <!-- Row 1 -->
    <div class="row mb-3">
      <div class="col-md-4 text-danger fw-semibold">
        <i class="bi bi-arrow-right text-primary me-2"></i> NGO Name
      </div>
      <div class="col-md-8 text-secondary">
        Agricultural Consultancy & Rural Development Institute.
      </div>
    </div>

    <!-- Row 2 -->
    <div class="row mb-3">
      <div class="col-md-4 text-danger fw-semibold">
        <i class="bi bi-arrow-right text-primary me-2"></i> Regd. Head Office
      </div>
      <div class="col-md-8 text-secondary">
        H1-279 Near Kartik Oraon Chowk Harmu Bypass Road, Harmu Colony Ranchi - 12, Jharkhand
      </div>
    </div>

    <!-- Row 4 -->
    <div class="row mb-3">
      <div class="col-md-4 text-danger fw-semibold">
        <i class="bi bi-arrow-right text-primary me-2"></i> Regional State Office
      </div>
      <div class="col-md-8 text-secondary">
        1. Jalcher (Orissa) – Mr. Jatin Batya <br>
        2. Patna (Bihar) – Aastha Kumari
      </div>
    </div>

    <!-- Row 5 -->
    <div class="row mb-3">
      <div class="col-md-4 text-danger fw-semibold">
        <i class="bi bi-arrow-right text-primary me-2"></i> Main Leader / Post
      </div>
      <div class="col-md-8 text-secondary">
        General Secretary (Manoj Kumar Jha)<br>
        Contact: +91 7369084701 / +91 9508806494<br>
        Qualification: B.A. LL.B, PGDRD & Management BIT Mesara Ranchi
      </div>
    </div>

    <!-- Row 6 -->
    <div class="row mb-3">
      <div class="col-md-4 text-danger fw-semibold">
        <i class="bi bi-arrow-right text-primary me-2"></i> E-Mail
      </div>
      <div class="col-md-8 text-secondary">
        acordijha87@gmail.com
      </div>
    </div>

    <!-- Row 7 -->
    <div class="row">
      <div class="col-md-4 text-danger fw-semibold">
        <i class="bi bi-arrow-right text-primary me-2"></i> Website
      </div>
      <div class="col-md-8 text-secondary">
        <a href="https://www.acordi.in" target="_blank" class="text-decoration-none">
          www.acordi.in
        </a>
      </div>
    </div>

  </div>
</div>

<script>
  // Restrict input to only numbers for phone field
  document.querySelector('.only-number').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  //In contact.php page so we have to use setTimeout function to hide the alert after 10 seconds
  setTimeout(function() {
    document.querySelector('.alert').style.display = 'none';
  }, 10000);

  // send-button form validation
  document.querySelector('.send-button').addEventListener('click', function(e) {
    var name = document.getElementById('name').value.trim();
    var email = document.getElementById('email').value.trim();
    var phone = document.getElementById('phone').value.trim();
    var subject = document.getElementById('subject').value.trim();
    var message = document.getElementById('message').value.trim();

    if (name === '' || email === '' || phone === '' || subject === '' || message === '') {
      e.preventDefault(); // Prevent form submission
      alert('Please fill in all fields before submitting the form.');
    }
  });
</script>


<?php include "footer.php"; ?>