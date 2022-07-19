<?php

require APP_ROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body big-light mt-5">
            <?php
            flash('register_success') ?>
            <h2>Login</h2>
            <p>Please login into your account</p>
            <form action="<?= URL_ROOT ?>/users/login" method="post">
                <div class="form-group">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="email" name="email"
                           class="form-control form-control-lg <?= (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>"
                           value="<?= $data['email'] ?>">
                    <span class="invalid-feedback"> <?= $data['email_error'] ?><span/>
                </div>
                <div class="form-group">
                    <label for="password">Password: <sup>*</sup></label>
                    <input type="password" name="password"
                           class="form-control form-control-lg <?= (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>"
                           value="<?= $data['password'] ?>">
                    <span class="invalid-feedback"> <?= $data['password_error'] ?><span/>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Login" class="btn btn-success btn-block">
                    </div>
                    <div class="col">
                        <a href="<?= URL_ROOT ?>/users/register" class="btn btn-light btn-block">No account?
                            Register</a>
                    </div>
            </form>
        </div>
    </div>
</div>
<?php
require APP_ROOT . '/views/inc/footer.php'; ?>
