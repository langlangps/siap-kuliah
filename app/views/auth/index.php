<div class="container bg-gradient-royal">
    <div class="row">
        <div class="col-3 offset-6 text-white">
            <h1 class="text-center display-4 text-gold">Login</h1>
            <p><?= $data['flash-message']['auth']; ?></p>
            <form method="POST" action="<?= BASE_URL; ?>/Auth/index">
                <div class="form-group">
                    <input class="form-control" type="text" name="username" id="username"
                        placeholder="Masukkan Username Anda">
                    <p><?= $data['flash-message']['username'] ?></p>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password" id="password"
                        placeholder="Masukkan Password Anda">
                    <p><?= $data['flash-message']['password'] ?></p>
                </div>
                <button class="btn btn-royal auth-button" type="submit" name="login">Login</button>
            </form>
            <p>Belum punya akun? <a href="<?= BASE_URL; ?>/Auth/signup">Sign Up</a></p>
        </div>
    </div>
</div>