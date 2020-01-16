<!--   Core JS Files   -->
  <script src="<?php echo base_url() ?>assets/dashboard/js/core/jquery.min.js"></script>
  

  <script src="<?php echo base_url() ?>assets/dashboard/js/core/popper.min.js"></script>
  <script src="<?php echo base_url() ?>assets/dashboard/js/core/bootstrap.min.js"></script>
  <script src="<?php echo base_url() ?>assets/dashboard/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Table edit -->
  <script src="<?php echo base_url() ?>assets/js/jquery.tabledit.js"></script>
  <script src="<?php echo base_url() ?>assets/js/my.js"''></script>
  <!-- Chart JS -->
  <script src="<?php echo base_url() ?>assets/dashboard/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url() ?>assets/dashboard/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url() ?>assets/dashboard/js/black-dashboard.min.js?v=1.0.0"></script><!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?php echo base_url() ?>assets/dashboard/demo/demo.js"></script>
  <!-- refresh pull -->
  <script src="<?php echo base_url('assets/'); ?>js/jquery-p2r.min.js"></script>
  <script>
    $(document).ready(function() {
      //full 2 refresh
        $(".scroll").pullToRefresh({
                 refresh:200
            })
            .on("refresh.pulltorefresh", function (){
                location.reload();
            });
      $().ready(function() {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



        $('.fixed-plugin a').click(function(event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .background-color span').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data', new_color);
          }

          if ($main_panel.length != 0) {
            $main_panel.attr('data', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data', new_color);
          }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            sidebar_mini_active = false;
            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
          } else {
            $('body').addClass('sidebar-mini');
            sidebar_mini_active = true;
            blackDashboard.showSidebarMessage('Sidebar mini activated...');
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (white_color == true) {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').removeClass('white-content');
            }, 900);
            white_color = false;
          } else {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').addClass('white-content');
            }, 900);

            white_color = true;
          }


        });

        $('.light-badge').click(function() {
          $('body').addClass('white-content');
        });

        $('.dark-badge').click(function() {
          $('body').removeClass('white-content');
        });
      });
    });
  </script>

  <script>

        $('.form-check-input').on('click', function() {
            const menuId = $(this).data('menu');
            const roleId = $(this).data('role');

            $.ajax({
                url: "<?= base_url('admin/role/changeaccess'); ?>",
                type: 'post',
                data: {
                    menuId: menuId,
                    roleId: roleId
                },
                success: function() {
                    document.location.href = "<?= base_url('admin/role/roleaccess/'); ?>" + roleId;
                }
            });

        });
    </script>

    <!-- detail server -->
    <script type="text/javascript">
      $(document).ready(function(){
        $('#add-produk tr td span').click(function(){
          var data = $(this).attr("data-all")
          var data = $.parseJSON(data)
          $('[name="name"]').val(data.product_name);
          $('[name="brand"]').val(data.brand);
          $('[name="trx_code"]').val(data.buyer_sku_code);
          $('[name="price"]').val(data.price);
          $('[name="status"]').val(data.seller_product_status);
        })
      })
    </script>

    <!-- produk admin -->
    <script type="text/javascript">
      $(document).ready(function(){
        
        // cange category produk
        $('#filter-produk').change(function(){
          var group_id = $(this).val()
          $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/produk/filter'); ?>",
            data: {group_id :group_id},
            dataType: 'JSON',
            beforesend: function(){
              console.log('on load')
            },
            success: function(data){
              $('#tbody').html('')

              var url_edit = '<?php echo base_url('admin/produk/edit/') ?>'
              var url_delete = '<?php echo base_url('admin/produk/delete/') ?>'
              var html = '';
              var i;
              var no = 1;
              for( i=0; i<data.length; i++){
                  html += `<tr>
                          <td>${no}</td>
                          <td>${data[i].server}</td>
                          <td>${data[i].category}</td>
                          <td>${data[i].name}</td>
                          <td>${data[i].price}</td>
                          <td>${data[i].status}</td>
                          <td>
                            <a href="${url_edit}${data[i].id}" class="badge badge-success">edit</a>
                            <a href="${url_delete}${data[i].id}" class="badge badge-danger">delete</a>
                          </td>
                          </tr>`
              no++
              }

              $('#tbody').html(html)
            }

          })
        })
      })
    </script>

    <!-- edit use modal method deposit -->
    <script type="text/javascript">
      $(document).ready(function(){
        $('#edit-method').click(function(){
          var id_depo = $('#depo_method').val()

          $.ajax({
            type:'POST',
            url: '<?php echo base_url('admin/deposit/getDepoMethod') ?>',
            dataType:'json',
            data:{id_depo : id_depo},
            success:function(data){
              $('[name = "id"]').val(data.id)
              $('[name = "method_name"]').val(data.method_name)
            }
          })
          $('#Medit').modal('show')
        })
      })
    </script>
</body>

</html>