<div class="jumbotron mt-4">
    <div class="container">
        <div class="row flex-column justify-content-center align-items-center">
            <h1 class="display-4 text-right text-gold"><?= $data['participant']['name'] ?></h1>
            <img class="thumbnail"
                src="<?= BASE_URL; ?>/img/participant/<?= $data['participant']['username'] ?>/profile.jpg" alt="">
        </div>
    </div>
</div>
<div class="container">
    <p class="text-center text-danger"><?= $this->util->get_flash_data('participant_message'); ?></p>
    <?php if (!empty($data['participant_tos'])) : ?>
    <div class="display-4 text-center">Try Out Ku</div>
    <div class="row justify-content-evenly my-4">
        <?php foreach ($data['participant_tos'] as $to) :; ?>
        <a href="<?= BASE_URL ?>/Participant/publicTryOut/<?= $to['to_id']; ?>">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center"><?= $to['name'] ?></h2>
                </div>
                <div class="card-body">
                    <p class="text-center"><?= $to['description'] ?></p>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="row bg-royal">
        <div class="col-6 offset-2 to-search text-gold">
            <h1 class="display-4 text-center">Cari Try Out</h1>
            <p class="text-center">Cari berbagai macam Try Out yang diadakan di seluruh penjuru Indonesia</p>
            <div class="form-group">
                <input type="text" class="form-control" id="to-key" name="to-key" placeholder="Cari Try Out">
            </div>
            <div class="form-group form-inline justify-content-between">
                <label for="to-name">Nama Try Out</label>
                <input class="category" type="checkbox" name="to-name" id="to-name">
                <input class="category" type="checkbox" name="to-org" id="to-org">
                <label for="to-org">Nama Organisasi Penyelenggara</label>
            </div>
        </div>
    </div>
    <div class="row bg-royal">
        <div class="col-8 offset-1" id="result-search">
            <!-- Live-Search -->
        </div>
    </div>

</div>
<script>

</script>