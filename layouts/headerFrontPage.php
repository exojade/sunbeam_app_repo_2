<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HDMS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css2/stylesheet.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <!-- Custom Favicon -->
    <link rel="icon" href="public/static_system/uploads/logocityvet.png">
    <!-- Custom CSS for About Us section -->
    <style>
        /* CSS for the About Us section */
        .about-section {
            padding: 300px 0;
            background-color: #f8f9fa;
        }

        .section-heading {
            font-size: 3rem;
            margin-bottom: 30px;
        }

        .text-muted {
            font-size: 1.1rem;
            line-height: 1.8;
        }

        /* CSS for the footer */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #343a40; /* Change this color to match your footer */
            color: #ffffff; /* Change this color to match your footer text */
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-dark" id="nav">
        <div class="container">
            <!-- Navbar Brand -->
            <span>
                <img src="public/static_system/uploads/LGUlogo.png" height="80" class="navbar-brand d-inline-block align-text-top">
                <img src="public/static_system/uploads/logocityvet.png" height="80" class="navbar-brand d-inline-block align-text-top">
            </span>
               <a id="cwadms" class="navbar-brand text-white" href="index.php"> HDMS &nbsp; &nbsp; &nbsp; &nbsp; | </a> &nbsp; &nbsp; &nbsp; &nbsp; 
            <!-- Navbar Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="newAppointment">Appointment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="ourServices">Our Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="aboutUs">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="contactUs">Contact Us</a>
                    </li>
                </ul>
                <!-- Admin and staff dropdown -->
                <div class="dropdown">
                    <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Personnel Login
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="login">Staff Login</a></li>
                        <li><a class="dropdown-item" href="login">Admin Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
  
