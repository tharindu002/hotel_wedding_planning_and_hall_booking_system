<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVENRA WEDDING HALL BOOKING SYSTEM</title>
    
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Swiper JS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
 
        :root {
            --primary-color: #d4af37;
            --secondary-color: #343a40;
        }
       
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }

        
        /* Swiper Custom Styles */
        .swiper {
            width: 100%;
            height: 500px;
            margin: 40px 0;
        }
        .swiper-slide {
            text-align: center;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }
        .swiper-slide::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
        }
        .swiper-slide-content {
            position: relative;
            z-index: 2;
            color: white;
            padding: 20px;
            max-width: 80%;
        }
        .swiper-button-next, .swiper-button-prev {
            color: white !important;
        }
        .swiper-pagination-bullet-active {
            background: white !important;
        }
        
        /* Hall Cards */
        .hall-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .hall-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        .hall-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 2;
        }
        
        /* Virtual Tour */
        .virtual-tour-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 10px;
        }
        .virtual-tour-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        
        /* Availability Calendar */
        .availability-calendar {
            border-radius: 10px;
            overflow: hidden;
        }
        .calendar-day {
            padding: 10px;
            text-align: center;
            border: 1px solid #eee;
        }
        .calendar-day.available {
            background-color: #e8f5e9;
            cursor: pointer;
        }
        .calendar-day.booked {
            background-color: #ffebee;
            color: #b71c1c;
        }
        .calendar-day.selected {
            background-color: var(--primary-color);
            color: white;
        }
        
        /* Floor Plan Designer */
        .floor-plan {
            background-color: #f5f5f5;
            border: 2px dashed #ccc;
            min-height: 400px;
            position: relative;
        }
        .table-element {
            position: absolute;
            width: 80px;
            height: 80px;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: move;
            user-select: none;
        }
        
        /* Admin  */
        .admin-sidebar {
            min-height: 100vh;
            background-color: var(--secondary-color);
            color: white;
        }
        .admin-nav-link {
            color: rgba(255,255,255,0.8);
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 5px;
            display: block;
            transition: all 0.3s;
        }
        .admin-nav-link:hover, .admin-nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            text-decoration: none;
        }
        
       
        .bg-primary-light {
            background-color: rgba(212, 175, 55, 0.1);
        }
        .btn-gold {
            background-color: var(--primary-color);
            color: white;
        }
        .btn-gold:hover {
            background-color: #c9a227;
            color: white;
        }
        .text-gold {
            color: var(--primary-color);
        }
        .admin-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        .vendor-card {
            transition: all 0.3s;
            border: 1px solid rgba(0,0,0,0.1);
        }
        .vendor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        /* Feedback */
        .feedback-card {
            border-left: 4px solid #d4af37;
        }
        /* Booking History */
        .booking-history {
            background-color: #f8f9fa;
        }
        /* Footer */
        footer {
            background-color: #343a40;
            color: white;
            padding: 40px 0 20px;
        }
        .footer-links a {
            color: #adb5bd;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-links a:hover {
            color: white;
        }
        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
        }
        .copyright {
            border-top: 1px solid #495057;
            padding-top: 20px;
            margin-top: 30px;
        }
        
        /* Custom Menu */
        .menu-builder .card-header {
            background-color: #f8f9fa;
        }
        .course-section {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>