<div class="wrapper">
    <?= $this->session->flashdata('message'); ?>
    
    <main class="main">

        <h1 class="font-bold text-md"><?php echo $title; ?></h1>
        
        <label for="email">
            <i class="far fa-envelope fa"></i>
            <input type="text" name="email" placeholder="Email" name="email"/>
        </label>
        
        <label for="password" class="mb-6">
            <i class="fas fa-lock fa"></i>
            <input type="password" name="password" placeholder="Password" name="password"/>
        </label>

        <label for="remember" class="float-left">
          <input type="checkbox" name="remember" value="1"  id="remember" />
            <span class="ml-3">Ingat Saya</span>
        </label>
                    
        <button type="button" class="button" id="reg-log">
            Sign In
        </button>
        
        <div class="text-center mt-1 mb-4">
            <a href="<?php echo base_url('auth/forgot') ?>" class="link text-gray-500">
                Forgot Password?
            </a>            
        </div>

        <a href="<?php echo base_url('auth/register'); ?>" class="button button-outlined text-center">
            Create Account
        </a>
    </main>
</div>

<!-- Modal -->
<div class="modal fade" id="secure_admin" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Go to admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('auth/secure_admin'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                    	<label>Key</label>
                        <input type="text" class="form-control text-dark" name="key" placeholder="key">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Go</button>
                </div>
            </form>
        </div>
    </div>
</div> 