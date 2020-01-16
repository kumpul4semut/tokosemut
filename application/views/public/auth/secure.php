<div class="wrapper">
    <?= $this->session->flashdata('message'); ?>
    
    <main class="main">

        <h1 class="font-bold text-md">secure</h1>
        <form action="<?= base_url('auth/secure_admin'); ?>" method="post">
            <label for="email">
                <i class="far fa-envelope fa"></i>
                <input type="key" placeholder="key" name="key"/>
            </label>
                        
            <button type="submit" class="button">
                go
            </button>
        </form>
        
    </main>
</div>
