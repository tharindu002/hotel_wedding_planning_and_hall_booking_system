<?php
include 'includes/dbconnection.php';

$prices = [];
$sql = "SELECT information, price FROM ru_table";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $prices[$row['information']] = $row['price'];
}

// Example usage (assign variables from DB values):
$Grandballroomprice      = $prices['Grandballroomprice'];
$Royalgardenprice        = $prices['Royalgardenprice'];
$Oceanviewterraceprice   = $prices['Oceanviewterraceprice'];
$Buffetprice             = $prices['Buffetprice'];
$Platedserviceprice      = $prices['Platedserviceprice'];
$Dessertprice            = $prices['Dessertprice'];
$Weddingcakeprice        = $prices['Weddingcakeprice'];
$BasicDecprice           = $prices['BasicDecprice'];
$FlowerDecprice          = $prices['FlowerDecprice'];
$PoruwaDecprice          = $prices['PoruwaDecprice'];
?>

<?php
include 'includes/dbconnection.php'; // Database connection

// Fetch the first row of hotel info (you can adapt if multiple entries are needed)
$sql = "SELECT * FROM hotel_info LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Hoteladdress = $row['address'];
    $Hotelphonenumber = $row['phone_number'];
    $Hotelemail = $row['email'];
    $Hotelopeningtime = $row['opening_time'];
    $Hotellocation = $row['location_url'];
} else {
    // Default values if no data found
    $Hoteladdress = "Not set";
    $Hotelphonenumber = "Not set";
    $Hotelemail = "Not set";
    $Hotelopeningtime = "Not set";
    $Hotellocation = "";
}
?>


<?php
include 'includes/dbconnection.php';


$imageVars = [
    'Hallpic01',
    'Hallpic02',
    'Hallpic03',
    'Packagesectionpic01',
    'Packagesectionpic02',
    'Packagesectionpic03'
];


$images = [];
$sql = "SELECT title, image_path FROM picedit";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $images[$row['title']] = $row['image_path'];
}


$Hallpic01           = $images['Hallpic01'] ?? '';
$Hallpic02           = $images['Hallpic02'] ?? '';
$Hallpic03           = $images['Hallpic03'] ?? '';
$Packagesectionpic01 = $images['Packagesectionpic01'] ?? '';
$Packagesectionpic02 = $images['Packagesectionpic02'] ?? '';
$Packagesectionpic03 = $images['Packagesectionpic03'] ?? '';
?>



<?php 
    if (file_exists('header.php')) include 'header.php'; 
    if (file_exists('RegisterandLoginform.php')) include 'RegisterandLoginform.php'; 
    if (file_exists('Navbar.php')) include 'Navbar.php'; 
?>

    
    <a href="AdminLogin.php" class="btn btn-warning admin-btn rounded-pill shadow">
        <i class="bi bi-shield-lock"></i> Admin
    </a>

    
<?php 
    if (file_exists('Halls_Section.php')) include 'Halls_Section.php'; 
    if (file_exists('Hall_Availability.php')) include 'Hall_Availability.php'; 
?>

    <!-- Packages Section was here. I put it into package_section.php file-->
    
<?php 
    if (file_exists('Packages_Section.php')) include 'Packages_Section.php'; 
    if (file_exists('Custom_Packages_Section.php')) include 'Custom_Packages_Section.php'; 
    if (file_exists('Vendor_Section.php')) include 'Vendor_Section.php'; 
?>
                
                <!-- Other vendor tabs would follow the same pattern -->
            </div>
        </div>
    </section>

<!-- Gallery Section -->
<section id="gallery" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2>Wedding Gallery</h2>
            <p class="lead">Real weddings at our venues for inspiration</p>
        </div>

        <div class="row" id="wedding-gallery">
            <?php
            include('includes/dbconnection.php');
            $result = $conn->query("SELECT * FROM gallery_table ORDER BY ID DESC");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card gallery-item">
                        <img src="<?= htmlspecialchars($row['Image_Preview']) ?>" data-full="<?= htmlspecialchars($row['Image_Preview']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['Pic_Title']) ?>" onclick="showModal(this)">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['Pic_Title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($row['Pic_Description']) ?></p>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo '<p class="text-center">No gallery items found.</p>';
            }
            ?>
        </div>
    </div>
</section>

<?php 
    if (file_exists('Feedbackssection.php')) include 'Feedbackssection.php'; 
    if (file_exists('Contactus.php')) include 'Contactus.php'; 
?>


                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Our Information</h3>
                            <div class="mb-4">
                                <h5><i class="bi bi-geo-alt-fill me-2"></i> Address</h5>
                                <p><?= $Hoteladdress ?></p>
                            </div>
                            <div class="mb-4">
                                <h5><i class="bi bi-telephone-fill me-2"></i> Phone</h5>
                                <p><?= $Hotelphonenumber ?></p>
                            </div>
                            <div class="mb-4">
                                <h5><i class="bi bi-envelope-fill me-2"></i> Email</h5>
                                <p><?= $Hotelemail ?></p>
                            </div>
                            <div class="mb-4">
                                <h5><i class="bi bi-clock-fill me-2"></i> Opening Hours</h5>
                                <p><?= $Hotelopeningtime ?></p>
                            </div>
                            <div class="mt-4">
                                <iframe src="<?= $Hotellocation ?>" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    

<?php 
    if (file_exists('footer.php')) include 'footer.php'; 
?>

<!--/////Registera & Login CSS Pop up Models was here/////-->

    <!-- Virtual Tour Modal was here.I put it into hall_section.php file -->

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery (optional, for some plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Initialize AOS animation
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Initialize Swiper
        const swiper = new Swiper('.mySwiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        // Set hall ID for booking
        function setHallId(id) {
            document.getElementById('hall_id').value = id;
            document.getElementById('modal_hall_id').value = id;
        }

        
    const virtualTourModal = document.getElementById('virtualTourModal');

    if (virtualTourModal) {
    virtualTourModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const hall = button.getAttribute('data-hall');
        const modalTitle = virtualTourModal.querySelector('.modal-title');
        const iframe = virtualTourModal.querySelector('#virtualTourFrame');
        const featuresList = virtualTourModal.querySelector('#hall-features-list');

        // Set hall title from key
        const hallTitles = {
            'grand-ballroom': 'Grand Ballroom',
            'royal-garden': 'Royal Garden',
            'ocean-view': 'Ocean View Terrace'
        };

        modalTitle.textContent = `${hallTitles[hall] || 'Virtual Tour'}`;

        // Reset before loading
        iframe.src = "";
        featuresList.innerHTML = "<li>Loading features...</li>";

        // Helper to convert YouTube URLs to embeddable format
        function convertToEmbedUrl(url) {
            try {
                const parsedUrl = new URL(url);
                let videoId = "";

                if (parsedUrl.hostname === "youtu.be") {
                    videoId = parsedUrl.pathname.slice(1);
                } else if (parsedUrl.hostname.includes("youtube.com")) {
                    videoId = parsedUrl.searchParams.get("v");
                }

                if (videoId) {
                    return `https://www.youtube.com/embed/${videoId}`;
                }
            } catch (e) {
                console.error("Invalid YouTube URL", e);
            }

            return "";
        }

        fetch(`get_virtual_tour.php?hall=${encodeURIComponent(hall)}`)
            .then(res => res.json())
            .then(data => {
                if (data.url) {
                    const embedUrl = convertToEmbedUrl(data.url);
                    iframe.src = embedUrl || "";
                } else {
                    iframe.src = "";
                }
            });

        // Static features
        const staticFeatures = {
            'grand-ballroom': `
                <li>Capacity: 500 guests</li>
                <li>Elegant crystal chandeliers</li>
                <li>Built-in stage with lighting</li>
                <li>Adjacent bridal suite</li>
                <li>Dedicated parking area</li>
            `,
            'royal-garden': `
                <li>Capacity: 300 guests</li>
                <li>Beautiful floral archways</li>
                <li>Outdoor gazebo for ceremonies</li>
                <li>Natural landscape backdrop</li>
                <li>Weather contingency plan</li>
            `,
            'ocean-view': `
                <li>Capacity: 200 guests</li>
                <li>Panoramic ocean views</li>
                <li>Sunset ceremony location</li>
                <li>Elegant glass enclosure</li>
                <li>Private beach access</li>
            `
        };

        featuresList.innerHTML = staticFeatures[hall] || "<li>No features found.</li>";
    });
}




        // Vendor Modal
        const vendorModal = document.getElementById('vendorModal');
        if (vendorModal) {
            vendorModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const card = button.closest('.card');
                const vendorName = card.querySelector('.card-title').textContent;
                const vendorImage = card.querySelector('img').src;
                const vendorCategories = Array.from(card.querySelectorAll('.badge')).map(b => b.textContent).join(', ');
                
                // Set modal content
                document.getElementById('vendor-name').textContent = vendorName;
                document.getElementById('vendor-modal-image').src = vendorImage;
                document.getElementById('vendor-services').textContent = vendorCategories;
                
                // Sample data (would normally come from database)
                document.getElementById('vendor-description').textContent = `Professional ${vendorCategories.toLowerCase()} service with 10 years of experience in wedding events. Known for attention to detail and creating memorable experiences.`;
                document.getElementById('vendor-pricing').textContent = 'LKR 50,000 - LKR 200,000 depending on package';
                document.getElementById('vendor-contact').textContent = 'Phone: +94 77 123 4567';
                document.getElementById('vendor-website').innerHTML = 'Website: <a href="#">www.vendorexample.com</a>';
                document.getElementById('vendor-rating').innerHTML = '<i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>';
                document.getElementById('vendor-review-count').textContent = '(45 reviews)';
            });
        }
    </script>
</body>
</html>