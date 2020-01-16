<div class="wrapper">
    
    <main class="main">

        <h1 class="font-bold text-md"><?php echo $title; ?></h1>
        <label for="name">
            <i class="far fa-user fa"></i>
            <input type="text" placeholder="Name" name="reg-name"/>
        </label>

        <label for="email">
            <i class="far fa-envelope fa"></i>
            <input type="text" placeholder="Email" name="reg-email"/>
        </label>
        
        <label for="password" class="mb-6">
            <i class="fas fa-lock fa"></i>
            <input type="password" placeholder="Password" name="reg-password"/>
        </label>

        <label for="password" class="mb-6">
            <i class="fas fa-lock fa"></i>
            <input type="password" placeholder="Konfirmasi Password" name="reg-confirm"/>
        </label>
                    
        <button type="button" class="button" id="btn-reg">
            Create Account
        </button>
        
        <div class="text-center mt-1 mb-4">
            <a href="<?php echo base_url('auth/forgot') ?>" class="link text-gray-500">
                Forgot Password?
            </a>            
        </div>

        <a href="<?php echo base_url('auth/'); ?>" class="button button-outlined text-center">
            Login
        </a>
    </main>
</div>