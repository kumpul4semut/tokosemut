
<!-- footer -->
	<div class="footer-copyright">
        <div class="row">
            <div class="col-lg-6 col-md-7">
                <p>© 2019 kumpul4semut | JNpulsa 🇮🇩 | All right reserved.</p>
            </div>
        </div>
    </div>
    <!-- end footer -->
	<!-- end container -->
	</div>
<!-- bootstrap js -->
	<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
	<script src="<?php echo base_url('assets/'); ?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url('assets/'); ?>js/jquery-p2r.min.js"></script>
	<script type="text/javascript">
		var num = 70; //number of pixels before modifying styles

		$(window).bind('scroll', function () {
		    if ($(window).scrollTop() > num) {
		        $('.navbar').addClass('fixed-top');
		    } else {
		        $('.navbar').removeClass('fixed-top');
		    }
		});
	</script>
	<script src="<?php echo base_url('assets/toast/toastr.min.js') ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			 //full 2 refresh
			  $(".scroll").pullToRefresh({
		             refresh:200
		        })
		        .on("refresh.pulltorefresh", function (){
		            location.reload();
		        });
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
	                url:"<?php echo base_url('xl/req_otp'); ?>",
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
					setTimeout(function() {                                   window.location.href = "<?php echo base_url('xl/login'); ?>";       }, 5000)}else{

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
	                url:"<?php echo base_url('xl/req_login'); ?>",
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
	                     $("input").attr("disabled", false)
	            		$('.fa').removeClass('fa-cog fa-spin')
	                     var cek = (s);
	                    if (cek == 'INVALID_OTP'){
	                        toastr.error(cek)
	                        return false
	                    }else{
	                    	console.log(s)
			                toastr.success(s)
			                // setInterval(function(){
			                // window.location = "<?php echo base_url('xl/beli'); ?>";
			                // }, 3000)

	                	}
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
	                url:"<?php echo base_url('xl/req_paket'); ?>",
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
