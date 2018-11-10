<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/_all-skins.min.css">

  <!-- Scripts -->
  <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
  <script src="<?= base_url() ?>assets/js/jquery-ui.min.js"></script>
  <script> $.widget.bridge('uibutton', $.ui.button);</script>
  <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/js/moment.js"></script>
  <script src="<?= base_url() ?>assets/js/fastclick.js"></script>
  <script src="<?= base_url() ?>assets/js/adminlte.min.js"></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <style>
    .preloader
    {
      /*position: fixed;*/
      position: absolute;
      left: 0;
      top: 0;
      z-index: 999;
      width: 100%;
      height: 100%;
      overflow: visible;
      background: rgba(240,241,242,0.95) url('https://loading.io/spinners/curve-bars/index.curved-bar-spinner.svg') no-repeat center center;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <a href="Guest" class="logo">
      <span class="logo-mini"><b>O</b>Lib</span>
      <span class="logo-lg"><b>Online </b>Library</span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url() ?>assets/img/per.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">Guest</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="<?= base_url() ?>assets/img/per.jpg" class="img-circle" alt="User Image">

                <p>
                  Guest
                </p>
              </li>
              <li class="user-footer">
                <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div> -->
                <div class="pull-right">
                  <a class="btn btn-default btn-flat logout">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  
  <aside class="main-sidebar">
    
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= base_url() ?>assets/img/per.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Guest</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>