<div id="participant-signup">
    <p class="text-danger"><?= $this->util->get_flash_data('auth') ?></p>
    <div class="container">
        <div class="row">
            <div class="bg-royal text-gold col-5 flex flex-column justify-content-center align-item-center">
                <h2 class="text-center">Ingin Membuat Try Out???</h2>
                <button class="btn btn-soft" id="admin-change-button">Sign Up Sebagai Penyedia Try Out</button>
            </div>
            <div class="col-5">
                <h3 class="display-4">Sign Up sebagai peserta</h3>
                <form action="<?= BASE_URL; ?>/Auth/signup" method="POST">
                    <input class="form-control" type="text" placeholder="Masukkan nama" name="name">
                    <p><?= $data['flash-message']['name'] ?></p>

                    <input type="radio" name="gender" id="male-gender" value="L">
                    <label for="male-gender">Laki-laki</label>
                    <input type="radio" name="gender" id="female-gender" value="P">
                    <label for="female-gender">Perempuan</label>
                    <p><?= $data['flash-message']['gender'] ?></p>

                    <input class="form-control" type="text" placeholder="Username" name="username">
                    <p><?= $data['flash-message']['username'] ?></p>

                    <input class="form-control" type="password" placeholder="Masukkan password" name="password">
                    <p><?= $data['flash-message']['password'] ?></p>

                    <input class="form-control" type="password" name="conformPassword"
                        placeholder="Konfirmasi Password">
                    <p><?= $data['flash-message']['conformPassword'] ?></p>

                    <input class="form-control" type="email" name="email" placeholder="email">
                    <p><?= $data['flash-message']['email'] ?></p>

                    <button class="btn btn-royal auth-button" type="submit" name="participant">Sign Up</button>
                    <p>Sudah Punya Akun? <a href="<?= BASE_URL ?>/Auth">Login</a></p>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="admin-signup" class="hide">
    <p class="text-danger"><?= $this->util->get_flash_data('auth') ?></p>
    <div class="container">
        <div class="row">
            <div class="col-5">
                <h3 class="display-4">Sign Up sebagai Admin</h3>
                <p>Setelah anda sign up, otomatis akan dibuatkan organisasi dengan nama dan password sama seperti akun
                    anda. Organisasi ini penting ada karena digunakan untuk mengelola tryout baik individu maupun
                    kolaboratif</p>
                <form action="<?= BASE_URL; ?>/Auth/signup" method="POST">
                    <input class="form-control" type="text" placeholder="Masukkan nama" name="name">
                    <p><?= $data['flash-message']['name'] ?></p>

                    <input class="form-control" type="text" placeholder="Username" name="username">
                    <p><?= $data['flash-message']['username'] ?></p>

                    <input class="form-control" type="password" placeholder="Masukkan password" name="password">
                    <p><?= $data['flash-message']['password'] ?></p>

                    <input class="form-control" type="password" name="conformPassword"
                        placeholder="Konfirmasi Password">
                    <p><?= $data['flash-message']['conformPassword'] ?></p>

                    <input class="form-control" type="email" name="email" placeholder="email">
                    <p><?= $data['flash-message']['email'] ?></p>

                    <button class="btn btn-royal auth-button" type="submit" name="admin">Sign Up</button>
                    <p>Sudah Punya Akun? <a href="<?= BASE_URL ?>/Auth">Login</a></p>
                    <br>
                </form>
            </div>
            <div class="col-5 bg-royal text-gold flex flex-column justify-content-center align-items-center">
                <h2>Ingin mengikuti try out???</h2>
                <button class="btn btn-soft" id="participant-change-button">Sign Up Sebagai Peserta Try Out</button>
            </div>
        </div>
    </div>
</div>