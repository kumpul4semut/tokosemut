<!-- Modal -->
<div class="modal fade" id="info-deposit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Method Deposit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive-sm">
                <h3>Keterangan</h3>
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td class="bg-warning">
                        <h6 class="text-white text-center">Pending</h6>
                      </td>
                      <td class="left">Menunggu Pembayaran Dan Antrian Check</td>
                    </tr>
                    <tr>
                      <td class="bg-success">
                        <h6 class="text-white text-center">Success</h6>
                      </td>
                      <td class="left">Transaksi Berhasil</td>
                    </tr>
                    <tr>
                      <td class="bg-danger">
                        <h6 class="text-white text-center">Failed</h6>
                      </td>
                      <td class="left">Transaksi Gagal</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
  <!-- rupiah mask -->
  <script src="<?php echo base_url() ?>assets/js/jquery.mask.js"></script>
  <!-- User Deposit -->
  <script type="text/javascript">
    $(document).ready(function(){
      /**
      *======================
      *Area function
      *======================
      */
     
       /* number to rupiah */
      function formatRupiah(angka, prefix)
      {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
          split = number_string.split(','),
          sisa  = split[0].length % 3,
          rupiah  = split[0].substr(0, sisa),
          ribuan  = split[0].substr(sisa).match(/\d{3}/gi);
          
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
      }

      //input nominal function
      function nominal(){
        $('#nominal').on('input', function(){
          //nominal to rp format
          $('input[name=nominal]').val(formatRupiah($(this).val()));
          //rupiah to nominal
          var nominal = $(this).val().split(".").join("")
          // alert(formatRupiah(nominal))
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
                                Detail <i class="tim-icons icon-pencil"></i>
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
     
      // on change option 
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
                  html += `
                  <input id="check_id" type="checkbox" value="${data[i].id}" class="ml-3" data-method="${data[i].deposit_method_id}">${data[i].name}
                  </input>
                  `
              }
              $('#show-deposit').html(html);
          }
         });

        // click checkbox
        $('#show-deposit').click('input[type="checkbox"]',function(){
          $('#show-deposit').on('change', '#check_id', function(){
            $('#show-deposit #check_id').prop('checked', false).removeAttr('checked');
            $(this).prop('checked', true).attr('checked', 'checked');
          });
          var id = $(this).find("input:checked").val()
          var methodId = $(this).find("input:checked").attr('data-method')
          var nominal = $('input[name="nominal"]').val().split(".").join("")

          if (methodId == 2) {
            demo.showNotification('primary',2000, `saldo yang akan didapat ${nominal*0.92}`)
            var fromPulsa = `
            <label>Pulsa Dari</label>
            <input class="form-control" name="pulsa-from" placeholder="628xx"/>
            <button class="btn btn-primary btn-sm" id="go-depo">Go Deposit</button>
            `
            $('#show-go-deposit').html(fromPulsa)
          } else {
            $('#show-go-deposit').html(`<button class="btn btn-primary btn-sm" id="go-depo">Go Deposit</button>`)
          }
         });
      })//end on change nominal
      
      //go deposit
      $('#show-go-deposit').on('click', '#go-depo', function(){
        $('#load-depo').show();
        var id = $('#show-deposit').find("input:checked").val()
        var methodId = $('#show-deposit').find("input:checked").attr('data-method')
        var nominal = $('input[name="nominal"]').val().split(".").join("")
        var pulsaFrom = $('#show-go-deposit').find('input[name="pulsa-from"]').val()
        //jika awalnya 08 ubah jadi 62
        if (pulsaFrom) {
          var frontPulsaForm = pulsaFrom.substr(0, 2)
          var backPulsaForm  = pulsaFrom.substr(2)
          if (frontPulsaForm == '08') {
            pulsaFrom = '628'+backPulsaForm
          }
        }
        
        setTimeout(function(){
          $.ajax({
          type:'post',
          url:'<?php echo base_url('/user/deposit/goDeposit'); ?>',
          data:{id:id, nominal:nominal, pulsaFrom:pulsaFrom},
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
      
    })//end document ready
  </script>
  <script type="text/javascript">
  //   var expired = '2019/10/6 14:27:04'
  // $('#cek').countdown(expired, function(event) {
  //   $(this).html(event.strftime('%H:%M:%S'));
  // });
</script>
</body>

</html>