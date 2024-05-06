<?php
	$pageTitle = "Contact Us";
	require_once 'header.php';

	$isSent = False;
			
	// Check if the send button was pressed
	if(isset($_POST['Send'])) {
		// Gather email contents from form
		$email = "conadcwu@gmail.com";
		$title = "Message from: " . $_POST['name'];
		$body = $_POST['emailBody'];
		$from = "From: " . $_POST['contactEmail'];
				
		// Use mail() to send email to support email, track is sent for success message
		mail($email, $title, $body, $from);
		$isSent = True;
	}
?>

<!--Main-->
<div class="container">
  <h1>Contact Us</h1>
  <p>
    If you have any questions or feedback, feel free to reach out to us.
  </p>
  <form>
    <div class="mb-3">
      <label for="name" class="form-label">Your Name</label>
      <input type="text" class="form-control" name="name" id="name" required />
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email Address</label>
      <input type="email" class="form-control" name="contactEmail" id="email" required />
    </div>
    <div class="mb-3">
      <label for="message" class="form-label">Message</label>
      <textarea class="form-control" id="message" name="emailBody" rows="5" required></textarea>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
      <!-- Submit button (Add back end code to save contact info) -->
      <input type="submit" class="btn btn-bd-red btn-lg px-4 me-md-2" value="Send">
    </div>
  </form>
</div>
<!--End of Main-->

<?php
// Include footer.
require_once 'footer.php';
?>