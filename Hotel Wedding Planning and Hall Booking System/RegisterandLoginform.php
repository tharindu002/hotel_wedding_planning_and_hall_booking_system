<!-- Register Modal -->
<div class="modal fade" id="RegisterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="registrationForm" method="POST">
                <div id="registerForm">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-person-lines-fill fs-3 me-2"></i>
                            User Registration
                        </h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="registrationErrorMessages" class="alert alert-danger" style="display: none;"></div>
                        <span class="badge bg-light text-dark mb-3 text-wrap lh-base">
                            Note: Your details must match with your ID (National ID, passport, driving license, etc.)
                            that will be required during check-in.
                        </span>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="fullname" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 p-0 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 p-0 mb-3">
                                    <label class="form-label">NIC/Passport Number</label>
                                    <input type="text" name="nic" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-12 p-0 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control shadow-none" rows="2" required></textarea>
                                </div>
                                <!-- <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control shadow-none" required>
                                </div> -->
                                <div class="col-md-6 p-0 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-12 p-0 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control shadow-none" required>
                                </div>
                            </div>
                            <div class="text-center my-1">
                                <button type="submit" class="btn btn-dark shadow-none">REGISTER</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="LoginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Login Error Messages -->
                <div id="loginErrorMessages" class="alert alert-danger" style="display: none;"></div>
                
                <form id="loginForm" method="POST">
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="loginEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="loginPassword" name="password" required>
                    </div>
                    <div class="mb-3 form-check" style="display: none;">
    <input type="checkbox" class="form-check-input" id="rememberMe" name="remember" checked>
    <label class="form-check-label" for="rememberMe">Remember me</label>
</div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark">Login</button>
                        <button type="button" class="btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#RegisterModal" data-bs-dismiss="modal">
                            Don't have an account? Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Form Handling -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Registration form handling
    const registrationForm = document.getElementById('registrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('includes/registrationfunctions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    const registerModal = bootstrap.Modal.getInstance(document.getElementById('RegisterModal'));
                    registerModal.hide();
                    window.location.href = 'index.php';
                } else {
                    const errorMessages = document.getElementById('registrationErrorMessages');
                    errorMessages.style.display = 'block';
                    errorMessages.innerHTML = data.errors.join('<br>');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during registration. Please try again.');
            });
        });
    }
    
    // Login form handling
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData();
            formData.append('email', document.getElementById('loginEmail').value);
            formData.append('password', document.getElementById('loginPassword').value);
            formData.append('remember', document.getElementById('rememberMe').checked ? 'true' : 'false');
            
            fetch('includes/loginfunctions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    const loginModal = bootstrap.Modal.getInstance(document.getElementById('LoginModal'));
                    loginModal.hide();
                    window.location.href = 'index.php';
                } else {
                    const errorMessages = document.getElementById('loginErrorMessages');
                    errorMessages.style.display = 'block';
                    errorMessages.innerHTML = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during login. Please try again.');
            });
        });
    }
});
</script>