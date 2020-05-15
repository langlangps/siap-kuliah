<div class="container mt-5">
    <div class="container">
        <div class="p text-center text-danger">
            <?= $this->util->get_flash_data('org_auth_message'); ?>
        </div>
        <div class="row justify-content-center">
            <h1 class="display-4">Pilih Organisasi</h1>
            <p>Sebagai autentifikasi agar hanya anda (sebagai admin) yang dapat membuka organisasi anda sendiri</p>
        </div>
        <form action="<?= BASE_URL; ?>/Admin/orgAuth/" method="post">
            <div class="form-group">
                <select name="org_id" id="org_id" class="form-control">
                    <option value="-1">---</option>
                    <?php foreach ($data['orgs'] as $org) : ?>
                    <option value="<?= $org['org_id']; ?>" id="<?= "org-" . $org['org_id']; ?>">
                        <?= $org['org_name']; ?>
                        </option>
                        <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Password Organisasi"
                    class="form-control">
            </div>
            <button class="btn btn-royal btn-full" type="submit" name="org_auth">Masuk ke organisasi</button>
        </form>
    </div>
    <hr>
    <div class="row justify-content-center">
        <h1 class="display-4">Buat Organisasimu sendiri</h1>
        <form action="<?= BASE_URL ?>/Admin/orgAuth" method="POST">
            <div class="form-group">
                <input name="org-name" type="text" class="form-control" placeholder="Masukkan nama Organisasi (Unik)">
            </div>
            <div class="form-group">
                <input name="org-email" type="email" class="form-control"
                    placeholder="Masukkan alamant email Organisasi">
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Masukkan Password">
            </div>
            <button class="btn btn-royal" name="org_add" type="submit">Buat Organisasi Anda</button>
        </form>
    </div>
</div>