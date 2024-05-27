<?php
// In the individual PHP files, check if the constant indicating the application is defined.
if (!defined('MY_APP')) {
  // If the constant is not defined, redirect the user to the homepage and terminate the script.
  header('Location: index.php');
  exit;
}
?>

<!--footer-->
<div class="container-fluid py-5">
  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <a href="#" class="col-md-6 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      <img src="img/cwu-logo-full-color-rgb-transparent.png" height="40px" />
    </a>
    <p class="col-md-6 mb-0 text-body-secondary">
      &copy; 2024 Central Washington University
    </p>
  </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>