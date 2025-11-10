<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
<section id="custom-packages" class="py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <h2 class="text-center mb-5">Plan Your Wedding at Our Hotel</h2>
        
        <div class="card shadow">
          <div class="card-header bg-white">
            <h4 class="mb-0">Event Planning</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- Selection Column -->
              <div class="col-md-6">
                <div class="sticky-top pt-3" style="top: 20px;">
                  <h5 class="mb-4">Select Event Details</h5>


<form method="POST" action="custompacksbackend.php" id="venue-form" onsubmit="return validateVenueForm(event)">
<input type="hidden" name="form_type" value="venue-form">

                  <!-- Package Name -->
                  <div class="card mb-3">
                    <div class="card-header"><h6 class="mb-0">**********</h6></div>
                    <div class="card-body">
                      <input type="text" class="form-control" name="Package_Name" id="package-name" placeholder="Enter package name" value="Custom Package" hidden required>
                    </div>
                  </div>




                  
<!-- 1. Venue Selection -->
<div class="card mb-3">
  <div class="card-header">
    <h6 class="mb-0">1. Wedding Venue</h6>
  </div>
  <div class="card-body">
    <div id="venue-alert" class="alert alert-danger d-none mb-3">
      ඔයා මේ හෝල් 3න් අවම එකක් වත් තෝරාගත යුතුයි
    </div>
    <div class="form-check">
      <input class="form-check-input venue-checkbox" type="radio" name="venues[]" value="grand-ballroom" id="venue-grand-hall" data-price="<?= $Grandballroomprice ?>" checked>
      <label class="form-check-label" for="venue-grand-hall">
        Grand Ballroom (Rs. <?= $Grandballroomprice ?>) Capacity 500 guests
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input venue-checkbox" type="radio" name="venues[]" value="royal-garden" id="venue-garden" data-price="<?= $Royalgardenprice ?>">
      <label class="form-check-label" for="venue-garden">
        Royal Garden (Rs. <?= $Royalgardenprice ?>) Capacity 300 guests
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input venue-checkbox" type="radio" name="venues[]" value="ocean-view-terrace" id="venue-poolside" data-price="<?= $Oceanviewterraceprice ?>">
      <label class="form-check-label" for="venue-poolside">
        Ocean View Terrace (Rs. <?= $Oceanviewterraceprice ?>) Capacity 200 guests
      </label>
    </div>
    <small class="text-muted">Select at least one hall. but You can select multiple halls.</small>
  </div>
</div>



                  <!-- 2. Date and Time -->
                  <div class="card mb-3">
                    <div class="card-header"><h6 class="mb-0">2. Wedding Date</h6></div>
                    <div class="card-body">
                      <div class="mb-3">
                        <label class="form-label">Wedding Date</label>
                        <input type="date" name="Booking_Date" class="form-control" id="wedding-date" required min="">
                      </div>
                    </div>
                  </div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById("wedding-date").setAttribute('min', today);
  });
</script>


                  <!-- 3. Food and Beverages -->
                  <div class="card mb-3">
                    <div class="card-header"><h6 class="mb-0">3. Food Selection</h6></div>
                    <div class="card-body">
                      <div class="mb-3">
                        <label class="form-label">Number of Guests</label>
                        <input type="number" name="Number_of_g" class="form-control" id="guest-count" min="50" value="1000">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Meal Type</label>
                        <select class="form-select" id="meal-type" name="Mealtype">
                          <option value="" disabled selected>Select Meal Type</option>
                          <option value="none" data-price="0" selected>None</option>
                          <option value="buffet" data-price="<?= $Buffetprice ?>">Buffet (Rs. <?= $Buffetprice ?> per person)</option>
                          <option value="Plated-Service" data-price="<?= $Platedserviceprice ?>">Plated Service (Rs. <?= $Platedserviceprice ?> per person)</option>
                        </select>
                      </div> 
                    </div>
                  </div>

                  <!-- 4. Food Menu -->
                  <div class="card mb-3">
                    <div class="card-header"><h6 class="mb-0">4. Menu Selection</h6></div>
                    <div class="card-body">
                      <div class="mb-3">
                        <h6>Menu Type</h6>
                        <div class="form-check mb-2">
                          <input class="form-check-input" type="radio" name="menu-type" id="menu-none" value="None" checked>
                          <label class="form-check-label" for="menu-none">None</label>
                        </div>
                        <div class="form-check mb-2">
                          <input class="form-check-input" type="radio" name="menu-type" id="menu-local" value="Sri Lankan Cuisine">
                          <label class="form-check-label" for="menu-local">Sri Lankan Cuisine</label>
                        </div>
                        <div class="form-check mb-2">
                          <input class="form-check-input" type="radio" name="menu-type" id="menu-western" value="Western Cuisine">
                          <label class="form-check-label" for="menu-western">Western Cuisine</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="menu-type" id="menu-mixed" value="Mixed Cuisine">
                          <label class="form-check-label" for="menu-mixed">Mixed Cuisine</label>
                        </div>
                      </div>


                      
                      <div class="mt-3">
                        <h6>Additional Food</h6>
                        <div class="form-check mb-2">
                          <input class="form-check-input" type="checkbox" name="additional_food[]" value="none" id="none" data-price="500" checked>
                          <label class="form-check-label" for="none">None</label>
                        </div>
                        <div class="form-check mb-2">
                          <input class="form-check-input" type="checkbox" name="additional_food[]" value="dessert" id="food-dessert" data-price="<?= $Dessertprice ?>">
                          <label class="form-check-label" for="food-dessert">Desserts (Rs. <?= $Dessertprice ?> per person)</label>
                        </div>
                        <div class="form-check mb-2">
                          <input class="form-check-input" type="checkbox" name="additional_food[]" value="welcome-drink" id="food-welcome" data-price="300">
                          <label class="form-check-label" for="food-welcome">Welcome Drinks (It's Free of Charges)</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="additional_food[]" value="food-cake" id="food-cake" data-price="<?= $Weddingcakeprice ?>">
                          <label class="form-check-label" for="food-cake">Wedding Cake (Rs. <?= $Weddingcakeprice ?>)</label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const noneCheckbox = document.getElementById('none');
    const otherCheckboxes = Array.from(document.querySelectorAll('input[name="additional_food[]"]:not(#none)'));

    // When any of the other checkboxes is changed
    otherCheckboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function () {
        if (otherCheckboxes.some(cb => cb.checked)) {
          noneCheckbox.checked = false;
        } else {
          noneCheckbox.checked = true;
        }
      });
    });

    // If 'None' is clicked, uncheck all others
    noneCheckbox.addEventListener('change', function () {
      if (noneCheckbox.checked) {
        otherCheckboxes.forEach(cb => cb.checked = false);
      }
    });
  });
</script>


<!-- 5. Decorations -->
<div class="card mb-3">
  <div class="card-header"><h6 class="mb-0">5. Decorations</h6></div>
  <div class="card-body">
    <div class="form-check mb-2">
      <input class="form-check-input" type="checkbox" name="Decorations[]" value="none" id="decor-none" data-price="0" checked>
      <label class="form-check-label" for="decor-none">None</label>
    </div>
    <div class="form-check mb-2">
      <input class="form-check-input" type="checkbox" name="Decorations[]" value="basic" id="decor-basic" data-price="<?= $BasicDecprice ?>">
      <label class="form-check-label" for="decor-basic">Basic Decorations (Rs. <?= $BasicDecprice ?>)</label>
    </div>
    <div class="form-check mb-2">
      <input class="form-check-input" type="checkbox" name="Decorations[]" value="flowers" id="decor-flowers" data-price="<?= $FlowerDecprice ?>">
      <label class="form-check-label" for="decor-flowers">Flower Decorations (Rs. <?= $FlowerDecprice ?>)</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="Decorations[]" value="poruwa" id="decor-poruwa" data-price="<?= $PoruwaDecprice ?>">
      <label class="form-check-label" for="decor-poruwa">Poruwa Decorations (Rs. <?= $PoruwaDecprice ?>)</label>
    </div>
  </div>
      <div id="venue-alert02" class="alert alert-danger d-none mb-3">
      ඔයා මේ හෝල් 3න් අවම එකක් වත් තෝරාගත යුතුයි
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const decorNone = document.getElementById('decor-none');
    const decorOthers = Array.from(document.querySelectorAll('input[name="Decorations[]"]:not(#decor-none)'));

    // When any other decoration checkbox is changed
    decorOthers.forEach(checkbox => {
      checkbox.addEventListener('change', function () {
        if (decorOthers.some(cb => cb.checked)) {
          decorNone.checked = false;
        } else {
          decorNone.checked = true;
        }
      });
    });

    // If 'None' is clicked, uncheck all others
    decorNone.addEventListener('change', function () {
      if (decorNone.checked) {
        decorOthers.forEach(cb => cb.checked = false);
      }
    });
  });
</script>

                  
                </div>
              </div>
              
              <!-- Package Summary -->
              <div class="col-md-6">
                <div class="sticky-top pt-3" style="top: 20px;">
                  <h5 class="mb-4">Your Selections</h5>
                  <div class="card mb-4">
                    <div class="card-header bg-primary text-white"><h6 class="mb-0">Event Summary</h6></div>
                    <div class="card-body">
                      <div id="booking-summary">
                        <p class="text-muted">Please select the details for your event</p>
                      </div>
                      <hr>
                      <div class="d-flex justify-content-between">
                        <h6>Venue Cost:</h6><h6 id="venue-cost">Rs. 0</h6>
                      </div>
                      <div class="d-flex justify-content-between">
                        <h6>Food & Beverage Cost:</h6><h6 id="food-cost">Rs. 0</h6>
                      </div>
                      <div class="d-flex justify-content-between">
                        <h5>Total Amount:</h5><h5 id="total-cost">Rs. 0</h5>
                      </div>
                    </div>
                  </div>

                  <!-- Personal Information -->
                  <?php
                  $userName = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '';
                  $isUserNameDisabled = empty($userName) ? '' : 'disabled';

                  $contact_number = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
                  $isPhoneDisabled = empty($contact_number) ? '' : 'disabled';

                  $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
                  $isEmailDisabled = empty($email) ? '' : 'disabled';
                  ?>

                  <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Personal Information</h6></div>
                    <div class="card-body">
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label class="form-label">Your Name</label>
                          <input type="text" class="form-control" id="groom-name"
                                value="<?php echo htmlspecialchars($userName); ?>"
                                <?php echo $isUserNameDisabled; ?>>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Contact Phone Number</label>
                        <input type="tel" class="form-control" id="contact-phone"
                              value="<?php echo htmlspecialchars($contact_number); ?>"
                              <?php echo $isPhoneDisabled; ?>>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="contact-email"
                              value="<?php echo htmlspecialchars($email); ?>"
                              <?php echo $isEmailDisabled; ?>>
                      </div>
                      <!-- <div class="mb-3">
                        <label class="form-label">Special Requests</label>
                        <textarea class="form-control" id="special-requests" rows="3"></textarea>
                      </div> -->
                    </div>
                  </div>

                  <!-- Buttons -->
                  <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success" id="book-package-btn">
                      <i class="bi bi-calendar-check me-2"></i>Book Now
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" onclick="document.location='customerbookingscrud.php'">
                      <i class="bi bi-folder me-2"></i>View Booked Packages
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </form>
  </div>
</section>
<?php else: ?>
  <!-- Styled Login Message -->
  <section id="custom-packages" class="py-5 bg-light">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card shadow text-center">
            <div class="card-body">
              <h3 class="text-danger mb-3">Please Log In First</h3>
              <p class="lead">You need to be logged in to plan your wedding and access this section.</p>
              <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#LoginModal">Log In</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- // Live Cost Update Event -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize the summary area
  updateSummary();
  
  // Get all the input elements that affect the cost
  const venueCheckboxes = document.querySelectorAll('.venue-checkbox');
  const guestCountInput = document.getElementById('guest-count');
  const mealTypeSelect = document.getElementById('meal-type');
  const menuTypeRadios = document.querySelectorAll('input[name="menu-type"]');
  const additionalFoodCheckboxes = document.querySelectorAll('input[name="additional_food[]"]');
  const decorationCheckboxes = document.querySelectorAll('input[name="Decorations[]"]');
  const dateInput = document.getElementById('wedding-date');
  const packageNameInput = document.getElementById('package-name');
  
  // Add event listeners to all inputs
  venueCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      validateVenueSelection();
      updateSummary();
    });
  });
  
  guestCountInput.addEventListener('input', updateSummary);
  mealTypeSelect.addEventListener('change', updateSummary);
  
  menuTypeRadios.forEach(radio => {
    radio.addEventListener('change', updateSummary);
  });
  
  additionalFoodCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      handleExclusiveCheckbox('none', 'additional_food[]');
      updateSummary();
    });
  });
  
  decorationCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      handleExclusiveCheckbox('decor-none', 'Decorations[]');
      updateSummary();
    });
  });
  
  dateInput.addEventListener('change', updateSummary);
  packageNameInput.addEventListener('input', updateSummary);
  
  // Form submission validation and adding total cost to form
  document.getElementById('venue-form').addEventListener('submit', function(e) {
    if (!validateForm()) {
      e.preventDefault();
      return;
    }
    
    // Create a hidden input for the total cost
    const costs = calculateCost();
    const totalCostInput = document.createElement('input');
    totalCostInput.type = 'hidden';
    totalCostInput.name = 'Total_Cost';
    totalCostInput.value = costs.totalCost;
    this.appendChild(totalCostInput);
  });
  
  // Function to handle "None" checkbox being mutually exclusive
  function handleExclusiveCheckbox(noneCheckboxId, checkboxName) {
    const noneCheckbox = document.getElementById(noneCheckboxId);
    const relatedCheckboxes = document.querySelectorAll(`input[name="${checkboxName}"]`);
    
    if (noneCheckbox.checked) {
      // If "None" is checked, uncheck all others
      relatedCheckboxes.forEach(checkbox => {
        if (checkbox.id !== noneCheckboxId) {
          checkbox.checked = false;
        }
      });
    } else {
      // If any other checkbox is checked, uncheck "None"
      const anyOtherChecked = Array.from(relatedCheckboxes).some(checkbox => 
        checkbox.id !== noneCheckboxId && checkbox.checked
      );
      
      if (anyOtherChecked) {
        noneCheckbox.checked = false;
      } else {
        // If no other checkbox is checked, check "None" again
        noneCheckbox.checked = true;
      }
    }
  }
  
  // Function to validate venue selection
  function validateVenueSelection() {
    const venueCheckboxes = document.querySelectorAll('.venue-checkbox');
    const venueAlert = document.getElementById('venue-alert');
    
    let selectedVenues = Array.from(venueCheckboxes).filter(checkbox => checkbox.checked);
    
    if (selectedVenues.length === 0) {
      venueAlert.classList.remove('d-none');
      return false;
    } else {
      venueAlert.classList.add('d-none');
      return true;
    }
  }
  
  // Function to validate the whole form
  function validateForm() {
    return validateVenueSelection();
  }
  
  // Function to calculate the total cost
  function calculateCost() {
    let totalCost = 0;
    let venueCost = 0;
    let foodCost = 0;
    
    // Calculate venue cost
    document.querySelectorAll('.venue-checkbox:checked').forEach(checkbox => {
      venueCost += parseInt(checkbox.dataset.price);
    });
    
    // Calculate food cost
    const guestCount = parseInt(document.getElementById('guest-count').value) || 0;
    const mealType = document.getElementById('meal-type');
    
    if (mealType.value) {
      const mealPrice = parseInt(mealType.options[mealType.selectedIndex].dataset.price);
      foodCost += guestCount * mealPrice;
    }
    
    // Calculate additional food cost
    document.querySelectorAll('input[name="additional_food[]"]:checked').forEach(checkbox => {
      if (checkbox.id !== 'none') {
        if (checkbox.id === 'food-cake') {
          foodCost += parseInt(checkbox.dataset.price);
        } else if (checkbox.id !== 'food-welcome') { // Welcome drinks are free
          foodCost += guestCount * parseInt(checkbox.dataset.price);
        }
      }
    });
    
    // Calculate decoration cost
    document.querySelectorAll('input[name="Decorations[]"]:checked').forEach(checkbox => {
      if (checkbox.id !== 'decor-none') {
        totalCost += parseInt(checkbox.dataset.price);
      }
    });
    
    // Add venue and food costs to total
    totalCost += venueCost + foodCost;
    
    return {
      totalCost: totalCost,
      venueCost: venueCost,
      foodCost: foodCost
    };
  }
  
  // Function to update the booking summary display
  function updateSummary() {
    const costs = calculateCost();
    const summary = document.getElementById('booking-summary');
    const packageName = document.getElementById('package-name').value || 'Custom Package';
    
    // Format the costs with commas for thousands
    const formatCurrency = (amount) => {
      return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };
    
    // Update the cost displays
    document.getElementById('venue-cost').textContent = 'Rs. ' + formatCurrency(costs.venueCost);
    document.getElementById('food-cost').textContent = 'Rs. ' + formatCurrency(costs.foodCost);
    document.getElementById('total-cost').textContent = 'Rs. ' + formatCurrency(costs.totalCost);
    
    // Build the summary HTML
    let summaryHTML = `<h6 class="mb-3">${packageName}</h6>`;
    
    // Add wedding date
    const dateInput = document.getElementById('wedding-date');
    if (dateInput.value) {
      const formattedDate = new Date(dateInput.value).toLocaleDateString('en-US', {
        year: 'numeric', 
        month: 'long', 
        day: 'numeric'
      });
      summaryHTML += `<p><strong>Date:</strong> ${formattedDate}</p>`;
    }
    
    // Add venues
    const selectedVenues = Array.from(document.querySelectorAll('.venue-checkbox:checked'))
      .map(checkbox => checkbox.nextElementSibling.textContent.trim());
    
    if (selectedVenues.length > 0) {
      summaryHTML += `<p><strong>Venue(s):</strong> ${selectedVenues.join(', ')}</p>`;
    }
    
    // Add meal information
    const guestCount = document.getElementById('guest-count').value;
    const mealType = document.getElementById('meal-type');
    let mealText = '';
    
    if (guestCount && mealType.value) {
      const mealTypeText = mealType.options[mealType.selectedIndex].text.split(' (')[0];
      mealText = `${mealTypeText} for ${guestCount} guests`;
    }
    
    // Add menu type
    const selectedMenuType = document.querySelector('input[name="menu-type"]:checked');
    if (selectedMenuType) {
      if (mealText) {
        mealText += ` - ${selectedMenuType.value}`;
      } else {
        mealText = selectedMenuType.value;
      }
    }
    
    if (mealText) {
      summaryHTML += `<p><strong>Food:</strong> ${mealText}</p>`;
    }
    
    // Add additional food items
    const additionalFood = Array.from(document.querySelectorAll('input[name="additional_food[]"]:checked'))
      .filter(checkbox => checkbox.id !== 'none')
      .map(checkbox => checkbox.nextElementSibling.textContent.trim().split(' (')[0]);
    
    if (additionalFood.length > 0) {
      summaryHTML += `<p><strong>Add-ons:</strong> ${additionalFood.join(', ')}</p>`;
    }
    
    // Add decorations
    const decorations = Array.from(document.querySelectorAll('input[name="Decorations[]"]:checked'))
      .filter(checkbox => checkbox.id !== 'decor-none')
      .map(checkbox => checkbox.nextElementSibling.textContent.trim().split(' (')[0]);
    
    if (decorations.length > 0) {
      summaryHTML += `<p><strong>Decorations:</strong> ${decorations.join(', ')}</p>`;
    }
    
    // Update the summary container
    summary.innerHTML = summaryHTML;
  }
});
</script>

<!-- 3 Halls Checkbox Event
<script>
function validateVenueForm(event) {
  const checkboxes = document.querySelectorAll('.venue-checkbox');
  const alertBox = document.getElementById('venue-alert');
  
  // Check if at least one venue checkbox is selected
  let isChecked = false;
  checkboxes.forEach(checkbox => {
    if (checkbox.checked) {
      isChecked = true;
    }
  });
  
  // If none are selected, show error and prevent form submission
  if (!isChecked) {
    event.preventDefault();
    alert("ඔයා මේ හෝල් 3න් අවම එකක් වත් තෝරාගත යුතුයි");
    alertBox.classList.remove('d-none');
    return false;
  } else {
    alertBox.classList.add('d-none');
    return true;
  }
}

// Add event listeners to checkboxes to hide alert when user checks any option
document.addEventListener('DOMContentLoaded', function() {
  const checkboxes = document.querySelectorAll('.venue-checkbox');
  const alertBox = document.getElementById('venue-alert');
  
  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      // If any checkbox is checked, hide the alert
      let anyChecked = false;
      checkboxes.forEach(cb => {
        if (cb.checked) {
          anyChecked = true;
        }
      });
      
      if (anyChecked) {
        alertBox.classList.add('d-none');
      }
    });
  });
});
</script> -->

<script>
function validateVenueForm(event) {
  // Get all venue checkboxes
  const checkboxes = document.querySelectorAll('.venue-checkbox');
  const alertBox = document.getElementById('venue-alert');
  const alertBox02 = document.getElementById('venue-alert02');
  
  // Get all menu radio buttons
  const menuOptions = document.querySelectorAll('input[name="menu-type"]');
  
  // Check if at least one venue checkbox is selected
  let isChecked = false;
  checkboxes.forEach(checkbox => {
    if (checkbox.checked) {
      isChecked = true;
    }
  });
  
  // Check if at least one menu option is selected
  let menuSelected = false;
  menuOptions.forEach(option => {
    if (option.checked) {
      menuSelected = true;
    }
  });
  
  // Validate venue selection
  if (!isChecked) {
    event.preventDefault();
    
    alert("ඔයා මේ හෝල් 3න් අවම එකක් වත් තෝරාගත යුතුයි");
    alertBox.classList.remove('d-none');
    alertBox02.classList.remove('d-none');
    return false;
  } else {
    alertBox.classList.add('d-none');
    alertBox02.classList.add('d-none');
  }
  
  // Validate menu selection
  if (!menuSelected) {
    event.preventDefault();
    alert("Please select a menu type!");
    return false;
  }
  
  // If everything is valid, form will submit
  return true;
}

// Add event listeners to checkboxes to hide alert when user checks any option
document.addEventListener('DOMContentLoaded', function() {
  const checkboxes = document.querySelectorAll('.venue-checkbox');
  const alertBox = document.getElementById('venue-alert');
  
  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      // If any checkbox is checked, hide the alert
      let anyChecked = false;
      checkboxes.forEach(cb => {
        if (cb.checked) {
          anyChecked = true;
        }
      });
      
      if (anyChecked) {
        alertBox.classList.add('d-none');
      }
    });
  });
});
</script>
