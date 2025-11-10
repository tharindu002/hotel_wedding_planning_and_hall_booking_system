<section class="hero-section">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
               
                <div class="swiper-slide" style="background-image: url('<?= $Hallpic01 ?>')">
                    <div class="swiper-slide-content" data-aos="fade-up">
                        <h2 class="display-4 fw-bold mb-3">Grand Ballroom</h2>
                        <p class="lead mb-4">Elegant space for up to 500 guests with crystal chandeliers</p>
                        <a href="#packages" class="btn btn-light btn-lg px-4">Explore Now</a>
                    </div>
                </div>
           
                <div class="swiper-slide" style="background-image: url('<?= $Hallpic02 ?>')">
                    <div class="swiper-slide-content" data-aos="fade-up">
                        <h2 class="display-4 fw-bold mb-3">Royal Garden</h2>
                        <p class="lead mb-4">Outdoor venue with beautiful floral arrangements</p>
                        <a href="#packages" class="btn btn-light btn-lg px-4">Explore Now</a>
                    </div>
                </div>
              
                <div class="swiper-slide" style="background-image: url('<?= $Hallpic03 ?>')">
                    <div class="swiper-slide-content" data-aos="fade-up">
                        <h2 class="display-4 fw-bold mb-3">Ocean View Terrace</h2>
                        <p class="lead mb-4">Stunning seaside location with sunset views</p>
                        <a href="#packages" class="btn btn-light btn-lg px-4">Explore Now</a>
                    </div>
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- Halls  -->
    <section id="halls" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2>Our Wedding Halls</h2>
                <p class="lead">Choose from our exquisite venues for your perfect day</p>
            </div>
            <div class="row">
                <!-- Hall 1 -->
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card hall-card h-100">
                        <span class="hall-badge badge bg-success">Available</span>
                        <img src='<?= $Hallpic01 ?>' class="card-img-top" alt="Grand Ballroom">
                        <div class="card-body">
                            <h5 class="card-title">Grand Ballroom</h5>
                            <p class="card-text">Spacious hall with elegant decor, perfect for large weddings.</p>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item"><i class="bi bi-people-fill"></i> Capacity: 500 guests</li>
                                <li class="list-group-item"><i class="bi bi-currency-rupee"></i> Price: LKR <?= $Grandballroomprice ?>/day</li>
                                <!-- <li class="list-group-item"><i class="bi bi-star-fill text-warning"></i> 4.8 (120 reviews)</li> -->
                            </ul>
                            <div class="d-grid gap-2">
                                <!-- <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#bookingModal" onclick="setHallId(1)">Book This Hall</button> -->
                                <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#virtualTourModal" data-hall="grand-ballroom">Virtual Tour</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hall 2 -->
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card hall-card h-100">
                        <span class="hall-badge badge bg-success">Available</span>
                        <img src='<?= $Hallpic02 ?>' class="card-img-top" alt="Royal Garden">
                        <div class="card-body">
                            <h5 class="card-title">Royal Garden</h5>
                            <p class="card-text">Beautiful outdoor venue with floral arrangements and gazebo.</p>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item"><i class="bi bi-people-fill"></i> Capacity: 300 guests</li>
                                <li class="list-group-item"><i class="bi bi-currency-rupee"></i> Price: LKR <?= $Royalgardenprice ?>/day</li>
                                <!-- <li class="list-group-item"><i class="bi bi-star-fill text-warning"></i> 4.9 (95 reviews)</li> -->
                            </ul>
                            <div class="d-grid gap-2">
                                <!-- <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#bookingModal" onclick="setHallId(2)">Book This Hall</button> -->
                                <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#virtualTourModal" data-hall="royal-garden">Virtual Tour</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hall 3 -->
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card hall-card h-100">
                        <span class="hall-badge badge bg-warning text-dark">Available but Limited Availability</span>
                        <img src='<?= $Hallpic03 ?>' class="card-img-top" alt="Ocean View Terrace">
                        <div class="card-body">
                            <h5 class="card-title">Ocean View Terrace</h5>
                            <p class="card-text">Stunning seaside location with panoramic ocean views.</p>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item"><i class="bi bi-people-fill"></i> Capacity: 200 guests</li>
                                <li class="list-group-item"><i class="bi bi-currency-rupee"></i> Price: LKR <?= $Oceanviewterraceprice ?>/day</li>
                                <!-- <li class="list-group-item"><i class="bi bi-star-fill text-warning"></i> 5.0 (68 reviews)</li> -->
                            </ul>
                            <div class="d-grid gap-2">
                                <!-- <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#bookingModal" onclick="setHallId(3)">Book This Hall</button> -->
                                <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#virtualTourModal" data-hall="ocean-view">Virtual Tour</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   
    <!-- Virtual Tour Modal -->
    <div class="modal fade" id="virtualTourModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="virtualTourModalLabel">Virtual Tour</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="virtual-tour-container">
                        <iframe id="virtualTourFrame" src="" allowfullscreen></iframe>
                    </div>
                    <div class="mt-3">
                        <h6>Hall Features</h6>
                        <ul id="hall-features-list">
                            <!-- Features will be loaded by JavaScript -->
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                   <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#bookingModal">Book This Hall</button> -->
                </div>
            </div>
        </div>
    </div>

    <script>
    
    const virtualTourFrame = document.getElementById('virtualTourFrame');

    virtualTourModal.addEventListener('hidden.bs.modal', function () {
        // Stop the video by resetting the src
        virtualTourFrame.src = virtualTourFrame.src;
    });
</script>
