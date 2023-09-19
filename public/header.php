<?php header('Content-Type: text/html; charset=UTF-8') ?>

<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> <?php echo (isset($title) and !empty($title)) ? $title : 'MiWiki' ?> </title>
    <link rel="icon" type="image/x-icon" href="/public/assets/logo.png">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

    <link rel="stylesheet" type="text/css" href="/public/styles/styles.css">
  
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Showdown CDN -->
    <script src="https://cdn.jsdelivr.net/npm/showdown@1.9.1/dist/showdown.min.js"></script>
</head>

<body>

    <header class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="/">
        <img src="/public/assets/logo.png" alt="logo" width="30" height="30" class="d-inline-block align-top">
        MiWiki
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?php if($title === "Home") echo "active" ?>" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($title === "Search") echo "active" ?>" href="/search">Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($title === "New page") echo "active" ?>" href="/new">New page</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($title === "Random page") echo "active" ?>" href="/random">Random page</a>
            </li>
            <li class="show-if-admin nav-item" style="display: none">
                <a class="nav-link <?php if($title === "Admin panel") echo "active" ?>" href="/admin">Admin panel</a>
            </li>
        </ul>
        <div class="nav ml-auto show-if-not-logged" style="display:none">
          <a class="btn btn-success nav-btn mr-2" href="/login">Log in</a>
          <a class="btn btn-outline-secondary nav-btn" href="/signup">Sign up</a>
        </div>
        <div class="nav ml-auto show-if-logged" style="display:none">
          <span class="navbar-text">Logged as </span>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <b class="session-username"></b>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/my_account">My account</a>
                <div class="dropdown-divider"></div>
              <button class="dropdown-item" onclick="logout(event)">Log out</button>
            </div>
          </li>
        </div>
      </div>
    </header>