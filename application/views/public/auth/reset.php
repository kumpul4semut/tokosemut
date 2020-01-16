<div class="wrapper">
    
    <main class="main">

        <h1 class="font-bold text-md"><?php echo $title; ?></h1>
        
        <label for="password" class="mb-6">
            <i class="fas fa-lock fa"></i>
            <input type="password" placeholder="New Password" name="password"/>
        </label>

        <label for="password" class="mb-6">
            <i class="fas fa-lock fa"></i>
            <input type="password" placeholder="New Konfirmasi Password" name="confirm"/>
        </label>
                    
        <button type="button" class="button" id="btn-change-pass">
            Change Password
        </button>

         <div class="text-center mt-1 mb-4">
            <a href="<?php echo base_url('auth') ?>" class="link text-gray-500">
                Back to Login
            </a>            
        </div>
        
    </main>
</div>