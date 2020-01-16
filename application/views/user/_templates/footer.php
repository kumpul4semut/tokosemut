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
<!--   Core JS Files   -->
  <script src="<?php echo base_url() ?>assets/dashboard/js/core/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/dashboard/js/core/popper.min.js"></script>
  <script src="<?php echo base_url() ?>assets/dashboard/js/core/bootstrap.min.js"></script>
  <script src="<?php echo base_url() ?>assets/dashboard/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Chart JS -->
  <script src="<?php echo base_url() ?>assets/dashboard/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url() ?>assets/dashboard/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url() ?>assets/dashboard/js/black-dashboard.min.js?v=1.0.0"></script><!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?php echo base_url() ?>assets/dashboard/demo/demo.js"></script>
  <!-- Load countdown -->
  <script src="<?php echo base_url() ?>assets/js/countdown.js"></script>
  <script type="text/javascript">
    var expired = $('#exp').attr('data-expired')
    if (expired == '') {
      $('#cek').html('')
    }else{
      $('#cek').countdown(expired, function(event) {
        $(this).html(event.strftime('sebelum %H:%M:%S'));
      });
    }

    function myFunction() {
      /* Get the text field */
      var copyText = document.getElementById("myInput");

      /* Select the text field */
      copyText.select();
      copyText.setSelectionRange(0, 99999); /*For mobile devices*/

      /* Copy the text inside the text field */
      document.execCommand("copy");

      /* Alert the copied text */
      demo.showNotification('success',1000, "Copied the text: " + copyText.value)
    }
  </script>
</body>

</html>