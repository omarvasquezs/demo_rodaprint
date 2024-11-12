<main class="flex-fill container pt-5 mb-5">
    <div class="text-uppercase display-5 mt-5 mb-5 fw-bold"><?php echo $title ?? ''; ?></div>
    <?php if (session()->has('success_message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div>
                <?= session()->getFlashdata('success_message') ?>
            </div>
            <button type="button" class="btn-close me-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php echo $output ?? ''; ?>
</main>