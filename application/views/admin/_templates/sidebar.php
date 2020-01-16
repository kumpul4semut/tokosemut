<body class="<?php $now = date('G'); if($now > 0 && $now <24){echo "white-content"; $side=1;}else{$side=0;} ?>">
  <div class="wrapper">
    <?php 
      $data_sidebar=[
        'red',
        'green'
      ];
      
      $sidebar = $data_sidebar[$side];
     ?>
    <div class="sidebar" data="<?php echo ($sidebar); ?>">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->

      <div class="sidebar-wrapper">
      <?php foreach($menu as $m): ?> <!-- looping menu -->
        <div class="logo">
          <a href="javascript:void(0)" class="simple-text logo-normal">
            <?php echo $m->menu ?>
          </a>
        </div>
        <ul class="nav">
          <?php foreach($m->submenu as $sm): ?> <!-- looping submenu/listmenu for access menu -->
            <li class="
            <?php 
            // echo strtoupper($this->uri->segment(2));
            if( strtoupper($this->uri->segment(2)) == strtoupper($sm->title) ){echo "active";
            } 
            ?>">

            <a href="<?php echo base_url($sm->url); ?>">
              <i class="<?php echo ($sm->icon); ?>"></i>
              <p><?php 
                $title=$sm->title;
                $html_invoice='<span class="badge badge-warning ml-2">';
                if ($title == "Invoice") {
                  echo ("Invoice ".$html_invoice.$count_invoice."</span>");
                }elseif($title == "Refund"){
                  echo ("Refund ".$html_invoice.$count_refund."</span>");
                }else{
                  echo $title;
                 } 

              ?></p>
            </a> 
          </li>
          <?php endforeach; ?>
        </ul>
      <?php endforeach; ?>
      </div>

    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="">Saldo Rp <?php echo number_format($user->saldo,2,',','.'); ?></a>

          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
              <li class="dropdown nav-item">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <div class="photo">
                    <img src="<?php echo base_url('assets/dashboard/img/'.$user->image) ?>">
                  </div>
                  <b class="caret d-none d-lg-block d-xl-block"></b>
                  <p class="d-lg-none">
                    <?php echo ($user->name); ?>
                  </p>
                </a>
                <ul class="dropdown-menu dropdown-navbar">
                  <li class="nav-link"><a href="<?php echo base_url(); ?>admin/profile" class="nav-item dropdown-item">Profile</a></li>
                  <li class="dropdown-divider"></li>
                  <li class="nav-link"><a href="<?php echo base_url(); ?>auth/logout" class="nav-item dropdown-item">Log out</a></li>
                </ul>
              </li>
              <li class="separator d-lg-none"></li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Navbar -->