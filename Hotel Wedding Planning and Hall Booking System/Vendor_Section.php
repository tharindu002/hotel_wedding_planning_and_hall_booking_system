<?php 

$Extraservice01 = "https://images.unsplash.com/photo-1520409364224-63400afe26e5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1583&q=80";
$Extraservice02 = "https://images.unsplash.com/photo-1493863641943-9b68992a8d07?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1583&q=80";
$Extraservice03 = "https://images.unsplash.com/photo-1526047932273-341f2a7631f9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1583&q=80";


?>

<!-- Vendor Integration Section -->
<section id="vendors" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2>Extra Services...</h2>
                <p class="lead">Trusted partners to complete your wedding experience</p>
            </div>
            
            <ul class="nav nav-pills justify-content-center mb-4" id="vendor-tabs" role="tablist" data-aos="fade-up">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="photographers-tab" data-bs-toggle="pill" data-bs-target="#photographers" type="button">Photographers</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="florists-tab" data-bs-toggle="pill" data-bs-target="#florists" type="button">Florists</button>
                </li>
            </ul>
            
            <div class="tab-content" id="vendor-tab-content">
                <div class="tab-pane fade show active" id="photographers" role="tabpanel">
                    <div class="row">
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="card vendor-card h-100">
                                <img src="<?= $Extraservice01 ?>" class="card-img-top" alt="Photographer">
                                <div class="card-body">
                                    <h5 class="card-title">Capture Moments</h5>
                                    <div class="mb-2">
                                        <span class="badge bg-light text-dark me-1">Wedding</span>
                                        <span class="badge bg-light text-dark me-1">Engagement</span>
                                        <span class="badge bg-light text-dark">Portraits</span>
                                    </div>
                                    <p class="card-text">Specializing in candid wedding photography with a natural, romantic style.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <span class="ms-1">4.9 (120 reviews)</span>
                                        </div>
                                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#vendorModal">View Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="card vendor-card h-100">
                                <img src="<?= $Extraservice02 ?>" class="card-img-top" alt="Photographer">
                                <div class="card-body">
                                    <h5 class="card-title">Eternal Frames</h5>
                                    <div class="mb-2">
                                        <span class="badge bg-light text-dark me-1">Wedding</span>
                                        <span class="badge bg-light text-dark me-1">Videography</span>
                                        <span class="badge bg-light text-dark">Cinematic</span>
                                    </div>
                                    <p class="card-text">Cinematic wedding films and photography that tell your unique love story.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <span class="ms-1">5.0 (85 reviews)</span>
                                        </div>
                                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#vendorModal">View Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="card vendor-card h-100">
                                <img src="<?= $Extraservice03 ?>" class="card-img-top" alt="Photographer">
                                <div class="card-body">
                                    <h5 class="card-title">Timeless Images</h5>
                                    <div class="mb-2">
                                        <span class="badge bg-light text-dark me-1">Wedding</span>
                                        <span class="badge bg-light text-dark me-1">Traditional</span>
                                        <span class="badge bg-light text-dark">Portraits</span>
                                    </div>
                                    <p class="card-text">Classic wedding photography with a focus on traditional poses and family portraits.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <span class="ms-1">4.8 (150 reviews)</span>
                                        </div>
                                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#vendorModal">View Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="florists" role="tabpanel">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card vendor-card h-100">
                                <img src="<?= $Extraservice03 ?>" class="card-img-top" alt="Florist">
                                <div class="card-body">
                                    <h5 class="card-title">Blooming Elegance</h5>
                                    <div class="mb-2">
                                        <span class="badge bg-light text-dark me-1">Bridal Bouquets</span>
                                        <span class="badge bg-light text-dark">Centerpieces</span>
                                    </div>
                                    <p class="card-text">Luxury floral designs with fresh, seasonal flowers for your special day.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <span class="ms-1">4.9 (95 reviews)</span>
                                        </div>
                                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#vendorModal">View Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card vendor-card h-100">
                                <img src="https://images.unsplash.com/photo-1459156212016-c812468e2115?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1583&q=80" class="card-img-top" alt="Florist">
                                <div class="card-body">
                                    <h5 class="card-title">Garden of Eden</h5>
                                    <div class="mb-2">
                                        <span class="badge bg-light text-dark me-1">Archways</span>
                                        <span class="badge bg-light text-dark me-1">Aisle Decor</span>
                                        <span class="badge bg-light text-dark">Full Setup</span>
                                    </div>
                                    <p class="card-text">Complete wedding floral arrangements from ceremony to reception.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <span class="ms-1">4.7 (110 reviews)</span>
                                        </div>
                                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#vendorModal">View Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card vendor-card h-100">
                                <img src="https://images.unsplash.com/photo-1526397751294-331021109fbd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1583&q=80" class="card-img-top" alt="Florist">
                                <div class="card-body">
                                    <h5 class="card-title">Petals & Posies</h5>
                                    <div class="mb-2">
                                        <span class="badge bg-light text-dark me-1">Budget-Friendly</span>
                                        <span class="badge bg-light text-dark">Custom Designs</span>
                                    </div>
                                    <p class="card-text">Beautiful floral arrangements that fit your vision and budget.</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <span class="ms-1">4.6 (75 reviews)</span>
                                        </div>
                                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#vendorModal">View Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vendor Details Modal -->
    <div class="modal fade" id="vendorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vendor Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="" id="vendor-modal-image" class="img-fluid rounded mb-3" alt="Vendor">
                            <div class="mb-3">
                                <h6>Services Offered</h6>
                                <div id="vendor-services"></div>
                            </div>
                            <div class="mb-3">
                                <h6>Pricing Range</h6>
                                <p id="vendor-pricing"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 id="vendor-name"></h4>
                            <div class="mb-3">
                                <span class="text-warning" id="vendor-rating"></span>
                                <span class="ms-2" id="vendor-review-count"></span>
                            </div>
                            <p id="vendor-description"></p>
                            <hr>
                            <h6>Contact Information</h6>
                            <p id="vendor-contact"></p>
                            <p id="vendor-website"></p>
                        </div>
                    </div>
                </div>
