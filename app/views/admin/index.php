<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-5 flex flex-column">
                <h1 class="text-right">Selamat Datang</h1>
                <h1 class="display-4 text-right"><?= $data['admin']['name'] ?></h1>
            </div>
            <div class="col-5 flex justify-content-center align-items-center">
                <img class="thumbnail" src="<?= BASE_URL; ?>/img/admin/<?= $data['admin']['username'] ?>/profile.jpg"
                    alt="">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Perbarui Profil mu -->

    <p><?= $this->util->get_flash_data('admin_message'); ?></p>
    <div class="row bg-gradient-royal p-3">
        <h1 class="display-4 mx-auto text-gold">Mari Kelola Try Out Anda</h1>
        <div class="col-3 offset-2 pr-1 ml-auto">
            <a href="<?= BASE_URL; ?>/Admin/toManager">
                <button class="display-4 btn btn-royal btn-org">Menuju Pengelola Try Out</button>
            </a>
        </div>
        <div class="col-3 pr-1">
            <p class="text-left text-white">
                Kelola Try Out anda sebagaimana itu adalah sesuatu yanglayak diperjuangkan. Mari berbagi manfaat bagi
                sesama dengan menciptkan try out yang berkualitas bersama SiapKuliah.com
            </p>
        </div>
    </div>

    <!-- Kelola Organixsasi -->
    <div class="row bg-dark p-3" id="orgManager">
        <h1 class="display-4 text-white mx-auto text-gold">Mari Kelola Organisasi Anda</h1>
        <div class="col-3 offset-2 pr-1">
            <p class="text-right text-white">
                Semakin baik anda mengelola organisasi anda, semakin besar kesempatan organisasi anda untuk dilirik oleh
                berbagai orang dari seluruh dunia. Matangkan berbagai try out, video pembelajaran (dalam pengembangan),
                kursus online, dan sebagainya.
            </p>
        </div>
        <div class="col-3 pl-1 text-center">
            <a href="<?= BASE_URL; ?>/Admin/orgManager">
                <button class="display-4 btn btn-royal btn-org">Menuju Pengelolaan Organisasi</button>
            </a>
        </div>
    </div>
</div>