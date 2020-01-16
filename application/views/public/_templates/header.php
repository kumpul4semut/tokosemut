<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link rel="alternate" href="<?php echo ($_SERVER['HTTP_HOST']) ?>" hreflang="en-US">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>assets/dashboard/img/icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/dashboard/img/icon.png">
  <meta content="#" property="og:url">
  <meta content="Fast Premium SSH Account" property="og:site_name">
  <meta content="Server SSH Account" property="og:title">
  <meta content="website" property="og:type">
  <meta property="fb:app_id" content="#">
  <meta property="fb:admins" content="#">
  <meta name="description" content="<?php echo $description; ?>">
  <meta name="keywords" content="<?php echo $keywords; ?>">
  <meta name="author" content="<?php echo ($_SERVER['HTTP_HOST']) ?>">
  <meta name="rating" content="general">
  <meta name="distribution" content="global">
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE"> 
<?php
  echo '<link rel="canonical" href="' . site_url( $this->uri->uri_string() ) . '" />';
  ?>

	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>bootstrap/css/bootstrap.min.css">
	<link href="<?php echo base_url('assets/'); ?>font/fontawesome/css/all.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/'); ?>css/tokosemut/style.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/toast/toastr.min.css') ?>"/>
</head>
<body>
  <!-- nav -->
  <nav class="navbar navbar-expand-lg navbar-light bg-nav">
    <div class="container">
      <a class="navbar-brand" href="<?php echo base_url(); ?>">
        <img class="img-brand" src="<?php echo base_url('assets/'); ?>/img/jnpulsa2.svg">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>">HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('produk'); ?>">PRODUK</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('auth'); ?>">MEMBER</a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('auth/register'); ?>" class="btn-nav nav-link">DAFTAR</a>
        </li>
      </ul>
      </div>
    </div>
  </nav>
  <!-- end nav -->

  <!-- full 2 refresh -->
  <div class="scroll">      
  </div>
