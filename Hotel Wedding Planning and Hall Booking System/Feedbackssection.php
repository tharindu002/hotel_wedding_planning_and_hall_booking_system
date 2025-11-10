<?php include 'includes/dbconnection.php'; ?>

<!-- Feedback Section -->
<section id="feedback" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <!-- Display Feedback -->
            <div class="col-lg-6">
                <h2 class="mb-4">Customer Feedback</h2>

                <?php
                $query = "SELECT name, rating, message, created_at FROM feedbacks ORDER BY created_at DESC LIMIT 10";
                $result = $conn->query($query);

                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                    <div class="card feedback-card mb-4">
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <div>
                                    <h5 class="mb-0"><?php echo htmlspecialchars($row['name']); ?></h5>
                                    <div class="text-warning">
                                        <?php
                                        $fullStars = floor($row['rating']);
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $fullStars) {
                                                echo '<i class="bi bi-star-fill"></i>';
                                            } else {
                                                echo '<i class="bi bi-star"></i>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <p class="card-text">"<?php echo htmlspecialchars($row['message']); ?>"</p>
                            <small class="text-muted">Posted on <?php echo date("d F Y", strtotime($row['created_at'])); ?></small>
                        </div>
                    </div>
                <?php endwhile; else: ?>
                    <p>No feedback yet. Be the first to leave a comment!</p>
                <?php endif; ?>
            </div>

            <!-- Feedback Form -->
            <div class="col-lg-6">
                <h2 class="mb-4">Leave Your Feedback</h2>
                <p class="text-danger small">Note: You can’t edit or remove the your feedbacks again. please ensure about your feedbacks before submitting those.</p>

                <?php
                // Handle form submission
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['form_type']) && $_POST['form_type'] === "feedback") {

                    $name = $conn->real_escape_string($_POST['name']);
                    $email = $conn->real_escape_string($_POST['email']);
                    $rating = (int) $_POST['rating'];
                    $message = $conn->real_escape_string($_POST['message']);

                    $insert = "INSERT INTO feedbacks (name, email, rating, message) 
                               VALUES ('$name', '$email', $rating, '$message')";

                    if ($conn->query($insert) === TRUE) {
                        echo '<div class="alert alert-success">Thank you for your feedback!</div>';
                        echo '<meta http-equiv="refresh" content="1">';
                    } else {
                        echo '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
                    }
                }
                ?>

                <form method="POST" id="feedbackForm">
                <input type="hidden" name="form_type" value="feedback">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select class="form-select" id="rating" name="rating" required>
                            <option value="">Select your rating</option>
                            <option value="5">5 Stars - Excellent</option>
                            <option value="4">4 Stars - Very Good</option>
                            <option value="3">3 Stars - Good</option>
                            <option value="2">2 Stars - Fair</option>
                            <option value="1">1 Star - Poor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Feedback</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark">Submit Feedback</button>
                </form>
            </div>
        </div>
    </div>
</section>
