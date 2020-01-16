<div class="content">
    <div class="row">
        <div class="col-md-8">
              <div class="card card-user">
                <div class="card-body">
                  <p class="card-text">
                    </p><div class="author">
                      <div class="block block-one"></div>
                      <div class="block block-two"></div>
                      <div class="block block-three"></div>
                      <div class="block block-four"></div>
                      <a href="javascript:void(0)">
                        <img class="avatar" src="<?php echo base_url('assets/dashboard/img/'.$user->image) ?>">
                        <h5 class="title"><?php echo($user->email) ?> </h5>
                      </a>
                      <p class="description">

                        <h6>
                            <a class="edit-name" href="#" data-name="<?php echo($user->name) ?>"><?php echo($user->name) ?>
                              <i class="tim-icons icon-pencil text-right "></i>
                            </a>
                        </h6>

                        <h6>
                          <a class="change-password" href="">Change Password
                            <i class="tim-icons icon-pencil text-right"></i>
                          </a>
                        </h6>

                      </p>
                    </div>
                  <p></p>
                <div class="card-footer">
                  <div class="button-container">
                    <?php echo ('User since '.date('d-M-Y H:i:s', $user->date_created)); ?>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>

<!-- Modal edit name -->
<div class="modal fade" id="editName" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Name</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url('user/profile/changeName'); ?>">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control nomor text-dark" name="data-name">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="changeName">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Modal edit name -->

<!-- Modal change password -->
<div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="form-group">
          <label>Old Password</label>
          <input type="text" class="form-control nomor text-dark" placeholder="Old Password" name="old-pass">
        </div>
        <div class="form-group">
          <label>New Password</label>
          <input type="text" class="form-control nomor text-dark" placeholder="New Password" name="new-pass">
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="text" class="form-control nomor text-dark" placeholder="Confirm Password" name="confirm-pass">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="change-password">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal change password -->