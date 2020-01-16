
<footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="row">
      <div class="col-12 col-md">
        <small class="d-block mb-3 text-muted">&copy; 2017-2019</small>
      </div>
    </div>
  </footer>
</div> <!-- end Container -->
<!-- bootstrap js -->
	<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
	<script src="<?php echo base_url('assets/'); ?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url('assets/toast/toastr.min.js') ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			 // toassett
		    toastr.options = {
		                      "closeButton": true,
		                      "debug": false,
		                      "newestOnTop": false,
		                      "progressBar": true,
		                      "positionClass": "toast-top-right",
		                      "preventDuplicates": false,
		                      "onclick": null,
		                      "showDuration": "300",
		                      "hideDuration": "1000",
		                      "timeOut": "5000",
		                      "extendedTimeOut": "1000",
		                      "showEasing": "swing",
		                      "hideEasing": "linear",
		                      "showMethod": "fadeIn",
		                      "hideMethod": "fadeOut"
		                    }
			// req otp
			$('#req_otp').click(function(){
				var msisdn=$('input[name="msisdn"]').val();
				$('.fa').addClass('fa-cog fa-spin')
				$("input").attr("disabled", true);
           	
	            $.ajax({
	                type:'POST',
	                url:"<?php echo base_url('appxl/req_otp'); ?>",
	                data:{msisdn:msisdn},
	                error:function(xhr,ajaxOptions,thrownError){
	                	$("input").attr("disabled", false)
	            		$('.fa').removeClass('fa-cog fa-spin')
	            		toastr.info('maximum request please refresh page')
	                },
	                cache:false,
	                beforeSend:function(){
	               	$('.fa').addClass('fa-cog fa-spin')
					$("input").attr("disabled", true);
	            },
	            success:function(s){
	            	$("input").attr("disabled", false);
	            	$('.fa').removeClass('fa-cog fa-spin')
	                $('#load').hide();
	                $('#response').html('');
	                if (s != 'nomor kosong') {
	                toastr.success(s)
	                setInterval(function(){
	                window.location = "<?php echo base_url('appxl/login'); ?>";
	                }, 5000)
	                }else{
	                toastr.error(s)
	                }
	            }}
	                );
	                return false;
			})
			// req login
			$('#req_login').click(function(e){
				e.preventDefault();
	            var otpCode=jQuery('input[name="otpCode"]').val();
	            $('.fa').addClass('fa-cog fa-spin')
				$("input").attr("disabled", true);

	            $.ajax({
	                type:'POST',
	                url:"<?php echo base_url('appxl/req_login'); ?>",
	                data:{otpCode:otpCode},
	                error:function(xhr,ajaxOptions,thrownError){
	                	$("input").attr("disabled", false)
	            		$('.fa').removeClass('fa-cog fa-spin')
	            		toastr.info('maximum request please refresh page')
	                },
	                cache:false,
	                beforeSend:function(){
	                   $('.fa').addClass('fa-cog fa-spin')
				       $("input").attr("disabled", true);
	                },
	                success:function(s){
	              //       $("input").attr("disabled", false)
	            		// $('.fa').removeClass('fa-cog fa-spin')
	              //       var cek = (s);
	              //       if (cek == 'INVALID_OTP'){
	              //           toastr.error(cek)
	              //           return false
	              //       }else{
			            //     toastr.success(s)
			            //     setInterval(function(){
			            //     window.location = "<?php echo base_url('appxl/beli'); ?>";
			            //     }, 3000)

	              //   	}
	              		console.log(s);
	                }}
	                );
	                return false;
			})
			// req paket
			$('#req_paket').click(function(e){
				e.preventDefault();
				var reg=jQuery('select[name="reg"]').val();
	            $('.fa').addClass('fa-cog fa-spin')
				$("input").attr("disabled", true);          

	            $.ajax({
	                type:'POST',
	                url:"<?php echo base_url('appxl/req_paket'); ?>",
	                data:{reg:reg},
	                error:function(xhr,ajaxOptions,thrownError){
	                	$("input").attr("disabled", false)
	            		$('.fa').removeClass('fa-cog fa-spin')
	            		toastr.info('maximum request please refresh page')
	                },
	                cache:false,
	                beforeSend:function(){
	                    $('.fa').addClass('fa-cog fa-spin')
						$("input").attr("disabled", true);
	                    
	                },
	                success:function(s){
	                    $("input").attr("disabled", false)
	            		$('.fa').removeClass('fa-cog fa-spin')
	                    if (s != 'Paket Berhasil Dibeli Jangan Lupa Dukung Semut!') {
	                    toastr.error(s)

	                    }else{
	                    toastr.success(s)
	                    }
	                    
	                }}
	                );
	                return false;
			})

		})

	</script>
</body>
</html>