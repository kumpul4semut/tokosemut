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
  <!-- User Produk -->
  <script type="text/javascript">
    $(document).ready(function(){
      //Update name
      $('.edit-name').on('click', function(e){
         e.preventDefault()
         var name =$(this).attr('data-name')
        $('#editName').modal('show');
        $('input[name="data-name"]').val(name);
      })

      //ajax update name
      $('#changeName').on('click', function(){
        var name = $('input[name="data-name').val()

        $.ajax({
          type:"POST",
          url:"<?php echo base_url('user/profile/changeName'); ?>",
          dataType:"json",
          data:{name:name},
          success:function(data){
            if (data.response.code == 0) {
              demo.showNotification('danger',1000, data.response.message)
            }else{
              demo.showNotification('success',1000, data.response.message)
              setTimeout(function(){
                window.location = "<?php echo base_url('user/profile'); ?>";
              },3000)
            }
            console.log(data.response)
          }
        })

      })

      //Change Password
      $('.change-password').on('click', function(e){
         e.preventDefault()
        $('#changePassword').modal('show');
      })
      
      //Ajax Change password
      $('#change-password').on('click', function(){
        var oldPass = $('input[name="old-pass').val()
        var newPass = $('input[name="new-pass').val()
        var confirmPass = $('input[name="confirm-pass').val()

        $.ajax({
          type:"POST",
          url:"<?php echo base_url('user/profile/changePassword'); ?>",
          dataType:"json",
          data:{oldPass:oldPass, newPass:newPass, confirmPass:confirmPass},
          success:function(data){
            if (data.response.code == 0) {
              demo.showNotification('danger',1000, data.response.message)
            }else{
              demo.showNotification('success',1000, data.response.message)
              setTimeout(function(){
                window.location = "<?php echo base_url('user/profile'); ?>";
              },3000)
            }
          }
        })
      })
    })//end document ready
  </script>
</body>

</html>