<div class="jumbotron">
    <h1>Org : <?= $data['org']['org_name'] ?></h1>
    <p>Established : <?= $data['org']['estab_date'] ?></p>
    <h4>Email : <?= $data['org']['org_email'] ?></h4>
</div>
<div class="container">
    <div class="text-center"><?= $this->util->get_flash_data('org_message'); ?></div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Cari Anggota" id="member-search">
            </div>
            <hr>
            <div class="flex flex-wrap" id="org-member">
                <?php foreach ($data['member'] as $member) : ?>
                <a href="#">
                    <div class="card member-card">
                        <h5><?= $member['username'] ?></h5>
                        <p><?= $member['name'] ?></p>
                        <p><?= $member['email'] ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-3">
            <h1>Cari Anggota</h1>
            <p>Anda dapat mencari anggota organisasi anda sesuai dengan username yang anda ketikkan</p>
        </div>
    </div>
    <hr>
    <div class="container bg-gradient-royal">
        <?php if ($data['admin_role'] == 'leader') : ?>
        <div class="row">
            <div class="col-6 form-org">
                <form action="<?= BASE_URL; ?>/Admin/insertNewAdmin/" method="post">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Masukkan nama" name="name" id="name">
                        <div class="text-center text-danger"><?= $this->util->get_flash_data('name'); ?></div>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Masukkan username" name="username"
                            id="username">
                        <div class="text-center text-danger"><?= $this->util->get_flash_data('username'); ?></div>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="Masukkan password" name="password"
                            id="password">
                        <div class="text-center text-danger"><?= $this->util->get_flash_data('password'); ?></div>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="conformPassword" id="conformPassword"
                            placeholder="Konfirmasi Password">
                        <div class="text-center text-danger"><?= $this->util->get_flash_data('conformPassword'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" id="email" placeholder="email">
                        <div class="text-center text-danger"><?= $this->util->get_flash_data('email'); ?></div>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="role" id="role">
                            <option value="leader">Leader</option>
                            <option value="manager">Manager</option>
                        </select>
                        <div class="text-center text-danger"><?= $this->util->get_flash_data('role'); ?></div>
                    </div>
                    <button type="submit" class="ml-auto btn btn-royal" name="insert-new-admin">Tambah
                        Pengelola</button>
                </form>
            </div>
            <div class="col-4 text-white">
                <h1>Tambah Pengelola Organisasi</h1>
                <p>
                    Dengan menambah pengelola, akan memudahkan anda dalam menyelenggarakan try out di dalam organisasi
                    anda
                    Pengelola yang anda daftarkan secara otomatis akan menjadi bagian dari organisasi anda, dan dapat
                    mengedit,
                    mengubah, menambahkan, dan menghapus data di dalam organisasi ini, namun tidak dengan informasi
                    organisasi ini
                </p>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-4 text-white">
                <h3>Ubah Informasi Organisasi (Leader)</h3>
            </div>
            <div class="col-6 form-org">
                <form action="<?= BASE_URL; ?>/Admin/updateOrg/" method="POST">
                    <div class="form-group">
                        <input class="form-control" type="text" name="org_name" id="org_name"
                            value="<?= $data['org']['org_name'] ?>" placeholder="Nama Organisasi">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" name="org_email" id="org_email"
                            value="<?= $data['org']['org_email'] ?>" placeholder="Email Organisasi">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="date" name="estab_date" id="estab_date"
                            value="<?= $data['org']['estab_date'] ?>" placeholder="Tanggal Dibentuk/Diperbarui">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" id="password"
                            placeholder="Masukkan Password Organisasi untuk mengubah data">
                    </div>
                    <button class="btn btn-royal" type="submit" name="org_change">Ubah Data Organisasi</button>
                </form>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-5">
                <h3 class="text-white">Ubah Password Organisasi (Hanya Leader)</h3>
                <div class="form-org">
                    <form action="<?= BASE_URL; ?>/Admin/updateOrg/" method="POST">
                        <div class="form-group">
                            <input class="form-control" type="password" name="old-password" id="old-password"
                                placeholder="Masukkan Password Lama">
                            <?= $this->util->get_flash_data('old-password'); ?>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="new-password" id="new-password"
                                placeholder="Masukkan Password Baru">
                            <?= $this->util->get_flash_data('new-password'); ?>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="confirm-password" id="confirm-password"
                                placeholder="Konfirmasi Password Baru">
                            <?= $this->util->get_flash_data('confirm-password'); ?>
                        </div>
                        <button class="btn btn-royal" type="submit" name="org-password-change">Ubah Password
                            Organisasi</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <a class="btn btn-reverse-danger" id="delete-org" href="<?= BASE_URL ?>/Admin/deleteOrg">HAPUS
                ORGANISASI</a>
            <p class="text-white">Jika anda menghapus organisasi ini, maka semua PENGELOLA, TRY OUT, dan hal hal lain
                yang berkaitan dengan organisasi ini, akan dihapus dari database</p>
        </div>
        <?php endif; ?>
        <?php if ($data['admin_role'] == 'manager') : ?>
        <div class="row text-white">
            <h1 class="display-4 text-center">Anda tidak memiliki akses mengubah detail organisasi</h1>
            <p class="text-center">Hanya leader yang dapat mengubah detail organisasi. Sementara ini, jika ingin
                mengubah role admin, minta
                leader untuk membuat kembali akun baru dengan role leader, kemudian hapus akun yang sebelumnya. Terima
                kasih (Masih dalam tahap pengembangan)</p>
        </div>
        <?php endif; ?>
    </div>
</div>