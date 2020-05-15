<div class="container mt-5">
    <div class="px-2 pt-2">
        <h1 class="display-3 text-center" id="welcome-to-manager">try out Manager</h1>
    </div>
    <div class="row justify-content-evenly flex-nowrap my-4">
        <div class="card">
            <div class="card-header">
                <h2 class="text-gold">Perbanyak Try Outmu</h2>
            </div>
            <div class="card-body">
                Semakin banyak try out yang anda kelola, semakin besar peluang orang-orang untuk menemukan tryout anda
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="text-gold">Tingkatkan kualitas soal-soal mu</h2>
            </div>
            <div class="card-body">
                Jadilah penyedia try out yang berkualitas dengan soal-soal yang juga berkualitas
            </div>
        </div>
    </div>

    <!-- Semua Try Out yang ada -->
    <div class="container bg-gradient-royal">
        <?php if (sizeof($data['all-try-out']) > 0) : ?>
        <h1 class="text-white text-center ">Semua Try Out</h1>
        <div class="row flex-row flex-nowrap" id="all-try-out">
            <?php foreach ($data['all-try-out'] as $tryout) : ?>

            <div class="card card-to-manager">
                <a href="<?= BASE_URL; ?>/Admin/toDetail/<?= $tryout['to_id'] ?>">
                    <div class="card-header">
                        <h3><?= $tryout['name'] ?></h3>
                    </div>
                </a>
                <div class="card-body">
                    <?php if (!is_null($tryout['date_end'])) : ?>
                    <p><strong>Until <?= $tryout['date_end'] ?></strong></p>
                    <?php else : ?>
                    <p style="width:100%;"><strong>No Until Date</strong></p>
                    <?php endif; ?>
                </div>
            </div>

            <?php endforeach; ?>
        </div>


        <?php endif; ?>
        <div class="row">
            <div class="col-6 offset-2">
                <h1 class="text-center text-white">Tambah Try Out</h1>
                <div class="form-to">
                    <form action="<?= BASE_URL; ?>/Admin/createTryOut" method="POST">
                        <div class="form-group">
                            <label for="to-name">Nama Try Out :</label>
                            <input class="form-control" type="text" name="to-name" id="to-name"
                                placeholder="Try Out Ku">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi Try Out</label>
                            <textarea class="form-control" name="description" id="description" rows="6">Try Out Ku adalah....
                                                    </textarea>
                        </div>
                        <div class="form-group" id="to-period">
                            <div class="form-inline">
                                <label for="to-date-start">Dari</label>
                                <input class="form-control" type="date" name="to-date-start" id="to-date-start">
                                <label for="to-date-end">Sampai</label>
                                <input class="form-control" type="date" name="to-date-end" id="to-date-end">
                            </div>
                        </div>
                        <button class="btn-reverse-gold btn btn-100" type="submit" name="create-to">Buat Try Out
                            Baru</button>
                    </form>
                </div>


            </div>

        </div>
    </div>
</div>