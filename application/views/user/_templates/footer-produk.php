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

  <!-- test pulsa validasi -->
  <script type="text/javascript">
    $(document).ready(function() {
      getsaldo()
      getInvoice()
      $('#beli-pulsa').prop('disabled', 'disabled')
      $('.nomor').on("input",function(){
        var idGroup = $('.btn-group .active').attr('data-id-group')
        var nomor = $(this).val()
        var show = ` <label>Pilih</label>
                          <select class="form-control text-primary" id="show-type-pulsa" name="beli-pulsa">
                          <option selected></option>
                            
                          </select>
                          <small class="text-primary" id="info-harga-pulsa">

                          </small>`
        if (nomor == '') {
          $('#show').html('')
          $('#beli-pulsa').prop('disabled', 'disabled')
        }else{
          $('#show').html(show)
          $('#beli-pulsa').prop('disabled', false)
        }

        $.ajax({
          type:'post',
          url:'<?php echo base_url('/user/produk/valid'); ?>',
          data:{nomor:nomor, idGroup:idGroup},
          dataType:'json',
          success:function(data){
            $('#info-nomor').html(data[0].brand)

            if (data[0].code == 0) {
              $('#show-type-pulsa').html('')
            }else{
              var html = ''
              var i

              for (i=0;  i<data.length; i++) {
                var html = html + `<option class="bg-primary" value="${data[i].id}" data-harga="${data[i].price}" data-status="${data[i].status}">${data[i].name}</option>`
                }

                if (data[0].status == 'true') {
                  var color_status = 'badge-success';
                  var text_status = 'NORMAL';
                }else{
                  var color_status = 'badge-danger';
                  var text_status = 'GANGGUAN';
                }

                if (data[0].price == 0) {
                  var harga = `Silahkan Check`
                  $('#beli-pulsa').html(`Check <i class="fa"></i>`)
                }else{
                  var harga = `Rp.${data[0].price}`
                }
                $('#show-type-pulsa').html(html)
                $('#info-harga-pulsa').html(`<h4>Harga ${harga} <span class="badge ${color_status}">${text_status}</span></h4>`)//show spesifik harga

                $('#show-type-pulsa').change(function(){

                  var option = $(this).find('option:selected')
                   if (option.attr('data-status') == 'true') {
                      var color_status = 'badge-success';
                      var text_status = 'NORMAL';
                    }else{
                      var color_status = 'badge-danger';
                      var text_status = 'GANGGUAN';
                    }

                   $('#info-harga-pulsa').html(`<h4>Harga Rp.${option.attr('data-harga')} <span class="badge ${color_status}">${text_status}</span> </h4>`)
                })
              }

            }

        })
      })//validasi on change input
    })
  </script>

  <!-- for function -->
  <script type="text/javascript">
      //function get saldo
      function getsaldo(){
        $.ajax({
          type:'GET',
          url:'<?php echo base_url('user/dashboard/getSaldoUser') ?>',
          success:function(r){
            $('#saldo').html(r)
          }
        })
      }

      //function get log trx
      function getInvoice() {
        var idGroup = $('.btn-group .active').attr('data-id-group')

        $.ajax({
          type  :'GET',
          url   :'<?php echo base_url('user/produk/getStatusTrx'); ?>',
          dataType :'json',
          data:{idGroup:idGroup},
          beforesend: function() {
            $('#show-log-invoice').html("loading..")
          },
          success :function(data) {
            if (data.code == 0) {
              // console.log(data.message
              $('#show-log-invoice').html(`<h3>${data.message}</h3>`)
            }else{
              //simmer loading
              var load='';
              for(i=0; i<data.length; i++){
                  load += `<tr>
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

              //load data
              setTimeout(function(){
                      var html = '';
                      var i;
                      var d = new Date();
                      for(i=0; i<data.length; i++){
                          if (data[i].pasca == true) {
                            var btn_pay = `<p><button id="pay" class="btn btn-primary" data-pay="${data[i].id}">Bayar <i class="fa"></i></button></p>`;
                          }else{
                            var btn_pay = '';
                          }
                          
                          if (data[i].customer_name == '') {
                            var nama = '';
                          }else{
                            var nama = `<p>
                                          <span class="title">Nama:</span>
                                          ${data[i].customer_name}
                                        </p>`
                          }
                          html += `<tr>
                                  ${data[i].status}
                                  <td>
                                    <h3 class="title">
                                     ${data[i].group_name}
                                    </h3>
                                    <p>
                                      <span class="title">Nomor:</span>
                                      ${data[i].nomor}
                                    </p>
                                    ${nama}
                                    <p>
                                      <span class="title">Produk:</span>
                                      ${data[i].name}
                                    </p>
                                    <p>
                                      <span class="title">SN:</span>
                                      ${data[i].sn}
                                    </p>
                                    <p>
                                      <span class="title">Harga:</span>
                                      Rp.${data[i].price}
                                    </p>
                                    <p>
                                      <span class="title">Time:</span>
                                      ${data[i].created_on}
                                    </p>
                                    ${btn_pay}
                                   </td>
                                  </tr>`
                      }
                      $('#show-log-invoice').html(html);
                      },1000)
                }
                }


              })
            }

     //refresh invoice
      $('#invoice-refresh').on('click', function(){
        getInvoice()
      })
  </script>

  <!-- purchase -->
  <script type="text/javascript">
    $(document).ready(function(){
      //pay prepadi produk
      $('#beli-pulsa').click(function(){
         $('.fa').addClass('fa-cog fa-spin')
        var idGroup = $('.btn-group .active').attr('data-id-group')
        var datas = $('select[name="beli-pulsa"]').val()
        var nomor = $('input[name="nomor"]').val() 

        $.ajax({
          type: 'POST',
          url: '<?php echo base_url('user/produk/purchase') ?>',
          data:{datas :datas, nomor:nomor, idGroup:idGroup},
          dataType: 'json',
          beforesend:function(){
            $('.fa').addClass('fa-cog fa-spin')
          },
          success:function(respon){
            if (respon.code == 0) {
              demo.showNotification('danger',1000, respon.message)
              $('.fa').removeClass('fa-cog fa-spin')
            }else{
              demo.showNotification('success',1000, respon.message)
              $('.fa').removeClass('fa-cog fa-spin')
              $('#beli-pulsa').prop('disabled', 'disabled')
              setTimeout(function(){
                location.reload();
              },5000)
              getsaldo()
              getInvoice()
            }
          }
        })
      });
      //pay pasca bayar
      $('#show-log-invoice').on('click','#pay', function(){
        var id = $(this).attr('data-pay')
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url('user/produk/payPasca') ?>',
          data:{id_trx_produk:id},
          dataType: 'json',
          beforesend:function(){
            $('.fa').addClass('fa-cog fa-spin')
          },
          success:function(data){
            if (data.code == 0) {
              demo.showNotification('danger',1000, data.message)
              $('.fa').removeClass('fa-cog fa-spin')
            }else{
              demo.showNotification('success',1000, data.message)
              $('.fa').removeClass('fa-cog fa-spin')
              $('#beli-pulsa').prop('disabled', 'disabled')
              setTimeout(function(){
                location.reload();
              },5000)
              getsaldo()
              getInvoice()
            }
          }
        });
      });
    })
  </script>

</body>

</html>