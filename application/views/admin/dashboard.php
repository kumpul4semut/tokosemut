      <div class="content">
        <div class="row">
          <div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Total User</h5>
                <h3 class="card-title"><i class="tim-icons icon-single-02 text-primary"></i> <?php echo $totalUser; ?></h3>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Product Error</h5>
                <h3 class="card-title"><i class="tim-icons icon-alert-circle-exc text-info"></i> <?php echo $produk_err; ?></h3>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">All Saldo</h5>
                <h3 class="card-title"><i class="tim-icons icon-coins text-success"></i> <?php echo "Rp".number_format($saldo_user->saldo,0,',','.'); ?></h3>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Profit</h5>
                <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> <?php echo "Rp".number_format($profit,0,',','.'); ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <ul class="nav">
            <li class="nav-item">
              <a href="javascript:void(0)" class="nav-link">
                Blog
              </a>
            </li>
          </ul>
          <div class="copyright">
            ©
            <script>
              document.write(new Date().getFullYear())
            </script> made with <i class="tim-icons icon-heart-2"></i> by
            <a href="https://www.kumpul4semut.com" target="_blank">kumpul4semut</a> use Creative tim.
          </div>
        </div>
      </footer>
    </div>
  </div>
  