<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link rel="alternate" href="<?php echo ($_SERVER['HTTP_HOST']) ?>" hreflang="en-US">
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
  <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
  <meta HTTP-EQUIV="Expires" CONTENT="-1">
  <?php  
  echo '<link rel="canonical" href="' . site_url( $this->uri->uri_string() ) . '" />';
  ?>

	<link rel="stylesheet" href="<?php echo base_url('assets/'); ?>bootstrap/css/bootstrap.min.css">
	<link href="<?php echo base_url('assets/'); ?>font/fontawesome/css/all.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/'); ?>css/newauth.css">

  
  
</head>
<body>
