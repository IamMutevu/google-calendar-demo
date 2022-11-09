<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Google Calendar Demo</title>
  </head>
  <body>
  <?php
    if(isset($_GET['success']) || isset($_GET['error'])){
  ?>
  <div class="row d-flex justify-content-center">
    <div class="col-md-4 mt-5">
    <?php
    if(isset($_GET['error'])){
    ?>
      <div class="alert alert-danger" role="alert">
        <?=$_GET['error']?>
      </div>
    <?php
    }
    else{
    ?>
      <div class="alert alert-success" role="alert">
        <?=$_GET['success']?>
      </div>
    <?php
    }
    ?>
    </div>
  </div>
  <?php
    }
  ?>