<?php
require_once "includes/dbconnection.php";

$contact_success = false;
$contact_error = "";
$contact_name = $contact_email = $contact_phone = $contact_subject = $contact_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["form_type"]) && $_POST["form_type"] === "contact") {
    // Get and sanitize input
    $contact_name = trim($_POST["contactName"] ?? '');
    $contact_email = trim($_POST["contactEmail"] ?? '');
    $contact_phone = trim($_POST["contactPhone"] ?? '');
    $contact_subject = trim($_POST["contactSubject"] ?? '');
    $contact_message = trim($_POST["contactMessage"] ?? '');

    // Basic validation
    if ($contact_name && $contact_email && $contact_subject && $contact_message) {
        if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
            $contact_error = "Please enter a valid email address.";
        } else {
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $contact_name, $contact_email, $contact_phone, $contact_subject, $contact_message);

            if ($stmt->execute()) {
                $contact_success = true;

                // Clear the form values
                $contact_name = $contact_email = $contact_phone = $contact_subject = $contact_message = "";

                // Success message
                $success_message = "Your message has been sent successfully! We are concerned about your problem and will provide our response via email...";
            } else {
                $contact_error = "Failed to send message. Please try again.";
            }

            $stmt->close();
        }
    } else {
        $contact_error = "Please fill in all required fields.";
    }
}
?>

 
    
    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Contact Us</h2>

                        <!-- Alert Messages -->
                        <?php if ($contact_error): ?>
                            <script>alert("Failed to send message. Please try again.");</script>
                            <div class="alert alert-danger"><?= htmlspecialchars($contact_error) ?></div>
                            <!-- <meta http-equiv="refresh" content="2"> -->
                        <?php elseif ($contact_success): ?>
                            <script>alert("Your message has been sent successfully! We are concerned about your problem and will provide our response via email...");</script>
                            <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
                            <meta http-equiv="refresh" content="4">
                        <?php endif; ?>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Get in Touch</h3>
                            <form id="contactForm" method="POST">
                            <input type="hidden" name="form_type" value="contact">
                            <div class="mb-3">
    <label for="contactName" class="form-label">Your Name</label>
    <input type="text" class="form-control" id="contactName" name="contactName" required>
  </div>
  <div class="mb-3">
    <label for="contactEmail" class="form-label">Email Address</label>
    <input type="email" class="form-control" id="contactEmail" name="contactEmail" required>
  </div>
  <div class="mb-3">
    <label for="contactPhone" class="form-label">Phone Number</label>
    <input type="tel" class="form-control" id="contactPhone" name="contactPhone">
  </div>
  <div class="mb-3">
    <label for="contactSubject" class="form-label">Subject</label>
    <input type="text" class="form-control" id="contactSubject" name="contactSubject" required>
  </div>
  <div class="mb-3">
    <label for="contactMessage" class="form-label">Message</label>
    <textarea class="form-control" id="contactMessage" name="contactMessage" rows="5" required></textarea>
  </div>
                                <button type="submit" class="btn btn-dark">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>