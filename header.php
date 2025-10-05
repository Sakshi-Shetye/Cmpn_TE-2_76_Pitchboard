<?php
// header.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>PitchBoard — Startup Ideas</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">

  <meta name="theme-color" content="#FFF">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-transparent py-3">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <div class="logo-circle">💡</div>
      <div class="ms-2 brand-text">
        <strong>PitchBoard</strong>
        <div class="tag">Ideas. Love. Launch.</div>
      </div>
    </a>

    <div class="ms-auto">
      <a href="submit_idea.php" class="btn btn-pill btn-primary me-2">+ Pitch Idea</a>
    </div>
  </div>
</nav>

<main class="container py-4">
