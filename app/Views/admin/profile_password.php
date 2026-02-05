<?= $this->extend('layout_admin'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"><?= $title ?></div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <?php if (session()->has('success')) : ?>
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
            <div class="text-white"><?= session('success') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <?php if (session()->has('danger')) : ?>
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
            <div class="text-white"><?= session('danger') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ubah Password Admin</h5>
                    <hr />
                    <form action="<?= base_url('admin/profile/change-password') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="mb-0">Password Lama</h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                                <input type="password" class="form-control <?= (isset(session('errors')['current_password'])) ? 'is-invalid' : '' ?>" id="current_password" name="current_password" placeholder="Masukkan password lama">
                                <div class="invalid-feedback">
                                    <?php if (isset(session('errors')['current_password'])) : ?>
                                        <?= session('errors')['current_password'] ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="mb-0">Password Baru</h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                                <input type="password" class="form-control <?= (isset(session('errors')['new_password'])) ? 'is-invalid' : '' ?>" id="new_password" name="new_password" placeholder="Masukkan password baru (minimal 6 karakter)">
                                <div class="invalid-feedback">
                                    <?php if (isset(session('errors')['new_password'])) : ?>
                                        <?= session('errors')['new_password'] ?>
                                    <?php endif; ?>
                                </div>
                                <small class="form-text text-muted">Password minimal 6 karakter</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <h6 class="mb-0">Konfirmasi Password</h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                                <input type="password" class="form-control <?= (isset(session('errors')['confirm_password'])) ? 'is-invalid' : '' ?>" id="confirm_password" name="confirm_password" placeholder="Masukkan ulang password baru">
                                <div class="invalid-feedback">
                                    <?php if (isset(session('errors')['confirm_password'])) : ?>
                                        <?= session('errors')['confirm_password'] ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8 text-secondary">
                                <button type="submit" class="btn btn-primary px-4">Ubah Password</button>
                                <a href="<?= base_url('admin') ?>" class="btn btn-secondary px-4 ms-2">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Strength Indicator -->
    <script>
        document.getElementById('new_password').addEventListener('input', function() {
            const password = this.value;
            const strengthIndicator = document.getElementById('password-strength');

            // Simple password strength check
            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            if (strengthIndicator) {
                switch (strength) {
                    case 0:
                    case 1:
                        strengthIndicator.className = 'text-danger';
                        strengthIndicator.textContent = 'Lemah';
                        break;
                    case 2:
                    case 3:
                        strengthIndicator.className = 'text-warning';
                        strengthIndicator.textContent = 'Sedang';
                        break;
                    case 4:
                    case 5:
                        strengthIndicator.className = 'text-success';
                        strengthIndicator.textContent = 'Kuat';
                        break;
                }
            }
        });

        // Confirm password validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('new_password').value;
            const confirmPassword = this.value;

            if (confirmPassword && password !== confirmPassword) {
                this.classList.add('is-invalid');
                this.nextElementSibling.textContent = 'Password tidak sama';
            } else {
                this.classList.remove('is-invalid');
            }
        });
    </script>
</div>
<?= $this->endSection(); ?>