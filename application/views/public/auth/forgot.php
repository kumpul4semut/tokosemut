<div class="wrapper">
    <?= $this->session->flashdata('message'); ?>
    
    <main class="main">

        <h1 class="font-bold text-md"><?php echo $title; ?></h1>
        
        <label for="email">
            <i class="far fa-envelope fa"></i>
            <input type="text" name="email" placeholder="Email" name="email"/>
        </label>
                    
        <button type="button" class="button" id="btn-forgot">
            forgot Password
        </button>
        

        <div class="text-center mt-1 mb-4">
            <a href="<?php echo base_url('auth') ?>" class="link text-gray-500">
                Back to Login
            </a>            
        </div>
    </main>
</div>
