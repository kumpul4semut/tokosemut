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
  <!-- User Deposit -->
  <script type="text/javascript">
    $(document).ready(function(){

      /**
      *======================
      *Area function
      *======================
      */

      //input nominal function
      function nominal(){
        $('#nominal').on('keyup', function(){
          var nominal = $(this).val()
          $.ajax({
          type:'post',
          url:'<?php echo base_url('/user/deposit/valid_nominal'); ?>',
          data:{nominal:nominal},
          dataType:'json',
          success:function(data){
            var resp = data.response.code
            if (resp == 0) {
            $('#info-nominal').html(data.response.message)
            }else{
            $('#info-nominal').html(data.response.message)              
            }
          }
         })
        })
      }

      //load mutasi transaksi function
      function mutasiTransaksi(){
        $.ajax({
          type:'get',
          url:'<?php echo base_url('/user/deposit/getlogTransaksi'); ?>',
          dataType:'json',
          success:function(data){
            var load = ''
            var i
            for (i = 0; i < data.length; i++ ) {
              load += ` <tr>
                          <td style="width: 20%">
                           <div class="profilePic animate float-left mt-2"></div>
                          </td>
                          <td>
                            <div class="comment br w80 animate float-left" style="width: 40%"></div>
                            <div class="comment br animate w80 mx-auto float-left"></div>
                          </td>
                        </tr>`
            }
            $('#show-log-invoice').html(load)

            setTimeout(function(){
              var html = ''
              var expired = ''
              var i
              for (i = 0; i < data.length; i++ ) {
                expired += data[i].expired_on
                html += ` <tr>
                            ${data[i].status}
                             <td>
                              <h3 class="title">
                                ${data[i].type_transaksi}
                              </h3>
                              <p>
                                <span class="title">Transfer:</span>
                                ${data[i].nominal}
                              </p>
                              <p>
                                <span class="title">${data[i].method_name}:</span>
                                ${data[i].name_transfer_to}
                              </p>
                              <p>
                                <span class="title">Nomor:</span>
                                ${data[i].rek_transfer_to}
                              </p>
                              <p>
                                <span class="title">Atas Nama:</span>
                                ${data[i].atas_nama}
                              </p>
                              <p>
                                <a class="btn btn-info btn-sm mt-2" href="${data[i].link}">
                                Konfirmasi <i class="tim-icons icon-pencil"></i>
                                </a>
                              </p>
                             </td>
                          </tr>`
              }   
                  if (expired == '') {
                    $('#cek').html('')
                  }else{
                    $('#cek').countdown(expired, function(event) {
                      $(this).html(event.strftime('%H:%M:%S'));
                    });
                  }
              $('#show-log-invoice').html(html)
            }, 2000)
          }
        })  
      }

      /**
      *======================
      *Area load function
      *======================
      */
      mutasiTransaksi()
      nominal()

      /**
      *======================
      *Area Click
      *======================
      */
      $('#method_deposit').change(function(){
        var id_method=$(this).find('option:selected').attr('methodDepo-id')
        $.ajax({
          type:'post',
          url:'<?php echo base_url('/user/deposit/getDeposit'); ?>',
          data:{id_method:id_method},
          dataType:'json',
          success:function(data){
              var html = '';
              var i;
              for(i=0; i<data.length; i++){
                  html += `<input id="check_id" type="checkbox" value="${data[i].id}" class="ml-3">${data[i].name}</input>`
              }
              $('#show-deposit').html(html);
          }
         })

        $('#show-deposit').click('input[type="checkbox"]',function(){
            $('#load-depo').show();
            var id = $(this).find("input:checked").val()
            var nominal = $('input[name="nominal"]').val()
            setTimeout(function(){
              $.ajax({
              type:'post',
              url:'<?php echo base_url('/user/deposit/goDeposit'); ?>',
              data:{id:id, nominal:nominal},
              dataType:'json',
              success:function(data){
                if (data.response.code == 0) {
                  demo.showNotification('danger',1000, data.response.message)
                }else if(data.response.code == 2){
                  demo.showNotification('primary',1000, data.response.message)
                }else{
                  demo.showNotification('success',1000, data.response.message)
                  mutasiTransaksi()                
                }
              }
             })  
              $('#load-depo').hide();
            }, 3000)
         });
      })
    })//end document ready
  </script>
  <script type="text/javascript">
  //   var expired = '2019/08/15 04:27:04'
  // $('#cek').countdown(expired, function(event) {
  //   $(this).html(event.strftime('%H:%M:%S'));
  // });
</script>
</body>

</html>