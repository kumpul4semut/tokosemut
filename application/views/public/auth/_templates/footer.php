	<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
	 <!--   Core JS Files   -->
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
	<script type="text/javascript">
		//form 
		$(".group-form input").on("focus", function(){
			$(this).addClass("focus");
		});
		$(".group-form input").on("blur", function(){
			if ($(this).val() == "")
			$(this).removeClass("focus");
		});
		//register
		$(document).ready(function(){

			//function post
			function _grepPost(data_input,url){
				$.ajax({
		    		type:'POST',
		    		url:url,
		    		data:data_input,
		    		dataType : "JSON",
		    		success:function(data){
		    			var respon = (data.response.code)
		    			setTimeout(function() {
			    			$('.fa').removeClass('fa-cog fa-spin')
			    			if (respon) {
			    				if (data.response.login_is == 'admin') {
			    					// demo.showNotification('success',1000, data.response.message)
			    					// setTimeout(function(){
			    					// 	window.location = "<?php echo base_url('admin/dashboard'); ?>";
			    					// },2000)
			    					$('#secure_admin').modal('show')
			    				}else if(data.response.login_is == 'user'){
			    					demo.showNotification('success',1000, data.response.message)
			    					setTimeout(function(){
			    						window.location = "<?php echo base_url('user/dashboard'); ?>";
			    					},2000)
			    				}else{
				    				demo.showNotification('success',1000, data.response.message)
				    			}
			    			}else{
			    				demo.showNotification('danger',1000, data.response.message)
			    			}
						}, 2000);                
		    		},
		    		beforeSend:function(){
		    			$('.fa').addClass('fa-cog fa-spin')
		    		},
		    		error:function(data){
		    			console.log(data)
		    		}
		    	})

			}
		    // register
		    $('#btn-reg').on('click', function(e){
		    	e.preventDefault();
		    	var name= $('input[name=reg-name]').val()
		    	var email= $('input[name=reg-email]').val()
		    	var password= $('input[name=reg-password]').val()
		    	var confirm= $('input[name=reg-confirm]').val()
		    	var url = '<?php echo base_url('auth/reg') ?>'
		    	var data_input = {'name':name,'email':email,'password':password,'confirm':confirm}
		    	_grepPost(data_input,url)
		    	
		    });

		    //login
		    $('#reg-log').on('click', function(e){
		    	e.preventDefault()
		    	var email= $('input[name=email]').val()
		    	var password= $('input[name=password]').val()

		    	if ($('#remember').is(':checked')) {
			    	var remember = $('input[name=remember]').val()
		    	}else{
		    		var remember = 0
		    	}
		    	var url = '<?php echo base_url('auth/login') ?>'
		    	var data_input = {'email':email,'password':password, 'remember':remember}
		    	_grepPost(data_input,url)

		    });

		    //forgot
		    $('#btn-forgot').on('click', function(e){
		    	e.preventDefault()
		    	var email= $('input[name=email]').val()
		    	var url = '<?php echo base_url('auth/forgotPassword') ?>'
		    	var data_input = {'email':email}
		    	_grepPost(data_input,url)

		    });

		    //changepassword
		    $('#btn-change-pass').on('click', function(e){
		    	e.preventDefault()
		    	var password= $('input[name=password]').val()
		    	var confirm= $('input[name=confirm]').val()
		    	var url = '<?php echo base_url('auth/changePassword') ?>'
		    	var data_input = {'password':password,'confirm':confirm}
		    	_grepPost(data_input,url)

		    });

		});
	</script>
</body>
</html>