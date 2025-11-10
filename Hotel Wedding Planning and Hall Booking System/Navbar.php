<?php

require_once 'includes/session_helper.php';
checkRememberMe($conn);

$fullName = getCurrentUserName();
$nameParts = explode(" ", $fullName);
$firstTwoNames = implode(" ", array_slice($nameParts, 0, 2));
?>

<body>
   
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-flower1 text-gold me-2"></i>Avenra Weddings
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active me-2" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link me-2" href="#halls">Halls</a></li>
                    <li class="nav-item"><a class="nav-link me-2" href="#packages">Packages</a></li>
                    <li class="nav-item"><a class="nav-link me-2" href="#vendors">Vendors</a></li>
                    <!-- <li class="nav-item"><a class="nav-link me-2" href="#planning-tools">Planning Tools</a></li> -->
                    <li class="nav-item"><a class="nav-link me-2" href="#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link me-2" href="#feedback">Feedback</a></li>
                    <li class="nav-item"><a class="nav-link me-2" href="#contact">Contact</a></li>
                </ul>


<div class="d-flex">
    <?php if (isLoggedIn()): ?>
        <span class="me-3 align-self-center">Welcome, <?php echo htmlspecialchars($firstTwoNames); ?>!</span>
        <div class="dropdown">
    <button class="btn btn-outline-success shadow-none dropdown-toggle" type="button" id="accownconBtn" data-bs-toggle="dropdown" aria-expanded="false">
        Account Ownership Control
    </button>

    <!-- Dropdown Menu -->
    <ul class="dropdown-menu" aria-labelledby="accownconBtn">
        <li>
            <button class="dropdown-item text-success fw-semibold"  data-bs-toggle="modal" data-bs-target="#updateAccountModal">
                <i class="bi bi-pencil-square me-2"></i>Update Profile
            </button>
        </li>
        <li>
            <button class="dropdown-item text-danger fw-semibold" id="logoutBtn">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </button>
        </li>
        <li>
            <button class="dropdown-item text-danger fw-semibold" id="deleteaccbut" data-bs-toggle="modal" data-bs-target="#removeAccountModal">
                <i class="bi bi-trash me-2"></i>Delete Account
            </button>
        </li>
    </ul>
</div>

        

    <?php else: ?>
        <button type="button" class="btn btn-outline-dark shadow-none me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#LoginModal">Login</button>
        <button type="button" class="btn btn-dark shadow-none" data-bs-toggle="modal" data-bs-target="#RegisterModal">Register</button>
    <?php endif; ?>
</div>

            </div>
        </div>
    </nav>
<style>

  /* Scoped Logout Modal Styles */
  .logout-modal-overlay {
    display: none;
    position: fixed;
    z-index: 1050; /* below sticky nav, above rest */
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
  }

  .logout-modal-content {
    background: #fff;
    padding: 2rem;
    border-radius: 10px;
    max-width: 400px;
    text-align: center;
    margin: 10% auto;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  }

  .logout-modal-actions {
    margin-top: 1.5rem;
    display: flex;
    justify-content: space-between;
    gap: 10px;
  }

  </style>

  <!-- Logout Confirmation Modal -->
<div id="logoutModal" class="logout-modal-overlay">
    <div class="logout-modal-content">
        <p class="fs-5 mb-4"><i class="bi bi-question-circle text-warning me-2"></i>Are you sure you want to log out?</p>
        <div class="logout-modal-actions">
            <button id="confirmLogout" class="btn btn-danger">
                <i class="bi bi-box-arrow-right me-2"></i>Yes, Log Out
            </button>
            <button id="cancelLogout" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
</div>

<!-- Improved Logout Modal Styling -->
<style>
    /* Logout Modal Styling */
    .logout-modal-overlay {
        display: none;
        position: fixed;
        z-index: 1050;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(3px);
        transition: all 0.3s;
    }
    
    .logout-modal-content {
        background: #fff;
        padding: 2rem;
        border-radius: 10px;
        max-width: 400px;
        text-align: center;
        margin: 15% auto;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.3s;
    }
    
    .logout-modal-actions {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>


<!-- Remove Account Modal -->
<div class="modal fade" id="removeAccountModal" tabindex="-1" aria-labelledby="removeAccountLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title text-danger fw-bold" id="removeAccountLabel">Remove Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <!-- 🔴 Error Message Area -->
        <div id="removeErrorMsg" class="alert alert-danger d-none"></div>

          <!-- Instruction Text -->
  <div class="mb-3">
    <p class="text-muted small">
      Please enter your email and password to confirm account deletion. This action is <strong>permanent</strong> and cannot be undone.
    </p>
  </div>

        <form id="removeAccountForm">
          <!-- Email -->
          <div class="mb-3">
            <label for="removeEmail" class="form-label">Email address</label>
            <input type="email" class="form-control shadow-none" id="removeEmail" placeholder="you@example.com" required>
          </div>
          <!-- Password -->
          <div class="mb-3">
            <label for="removePassword" class="form-label">Password</label>
            <input type="password" class="form-control shadow-none" id="removePassword" placeholder="Enter your password" required>
          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="submit" form="removeAccountForm" class="btn btn-danger w-100">Delete Account</button>
      </div>

    </div>
  </div>
</div>

<!-- Update Account Modal -->
<div class="modal fade" id="updateAccountModal" tabindex="-1" aria-labelledby="updateAccountLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-primary" id="updateAccountLabel">Update Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <!-- 🔴 Error Message Area -->
        <div id="updateErrorMsg" class="alert alert-danger d-none"></div>

        <!-- ✅ Success Message Area -->
        <div id="updateSuccessMsg" class="alert alert-success d-none"></div>

        <!-- Instruction -->
        <p class="text-muted small mb-3">
          You can update your personal details here. <strong>Password changes are not allowed from this form.</strong>
        </p>

        <form id="updateAccountForm">
          <!-- Full Name -->
          <div class="mb-3">
            <label for="updateFullname" class="form-label">Full Name</label>
            <input type="text" class="form-control shadow-none" id="updateFullname" name="fullname" value="<?= htmlspecialchars($_SESSION['fullname'] ?? '') ?>">
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="updateEmail" class="form-label">Email address</label>
            <input type="email" class="form-control shadow-none" id="updateEmail" name="email" value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" required>
          </div>

          <!-- Phone -->
          <div class="mb-3">
            <label for="updatePhone" class="form-label">Phone Number</label>
            <input type="text" class="form-control shadow-none" id="updatePhone" name="phone" value="<?= htmlspecialchars($_SESSION['phone'] ?? '') ?>" required>
          </div>

          <!-- NIC -->
          <div class="mb-3">
            <label for="updateNIC" class="form-label">NIC Number</label>
            <input type="text" class="form-control shadow-none" id="updateNIC" name="nic" value="<?= htmlspecialchars($_SESSION['nic'] ?? '') ?>" required>
          </div>

          <!-- Address -->
          <div class="mb-3">
            <label for="updateAddress" class="form-label">Address</label>
            <textarea class="form-control shadow-none" id="updateAddress" name="address" rows="2"><?= htmlspecialchars($_SESSION['address'] ?? '') ?></textarea>
          </div>
        </form>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="submit" form="updateAccountForm" class="btn btn-primary w-100">Update Account</button>
      </div>

    </div>
  </div>
</div>




  <script>
    const logoutBtn = document.getElementById('logoutBtn');
    const logoutModal = document.getElementById('logoutModal');
    const confirmLogout = document.getElementById('confirmLogout');
    const cancelLogout = document.getElementById('cancelLogout');

    logoutBtn.addEventListener('click', () => {
      logoutModal.style.display = 'block';
    });

    cancelLogout.addEventListener('click', () => {
      logoutModal.style.display = 'none';
    });

    confirmLogout.addEventListener('click', () => {
      window.location.href = 'includes/logout.php';
    });

  </script>

<script>
document.getElementById('removeAccountForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const email = document.getElementById('removeEmail').value.trim();
    const password = document.getElementById('removePassword').value.trim();

    const msgContainer = document.getElementById('removeErrorMsg');
    if (msgContainer) msgContainer.remove();

    fetch('includes/deleteaccountfunctions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = 'index.php';
        } else {
            const modalBody = document.querySelector('#removeAccountModal .modal-body');
            const errorEl = document.createElement('div');
            errorEl.id = 'removeErrorMsg';
            errorEl.className = 'alert alert-danger mt-2';
            errorEl.innerText = data.message;
            modalBody.appendChild(errorEl);
        }
    })
    .catch(err => {
        console.error('Error:', err);
    });
});
</script>
<script>
document.getElementById('updateAccountForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch('includes/update_account.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      const errorBox = document.getElementById('updateErrorMsg');
      const successBox = document.getElementById('updateSuccessMsg');
      errorBox.classList.add('d-none');
      successBox.classList.add('d-none');

      if (data.success) {
        successBox.textContent = data.message;
        successBox.classList.remove('d-none');
        alert("Account updated successfully!");
      } else if (data.errors) {
        errorBox.innerHTML = data.errors.map(err => `<div>${err}</div>`).join('');
        errorBox.classList.remove('d-none');
        alert("Error - " + data.errors.join(', '));
      }
    })
    .catch(err => {
      console.error('Update failed:', err);
    });
});
</script>

  

