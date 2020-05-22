<div class="jumbotron mt-5 text-center">
    <h1 class="display-4 text-center">
        <?= $data['to']['name'] ?>
    </h1>
    <p class="text-center">
        <?= $data['to']['description'] ?>
    </p>
    <p class="text-center">
        Dari :
        <strong>
            <?= $data['to']['date_start'] ?>
        </strong> ||
        Sampai :
        <strong>
            <?= $data['to']['date_end'] ?>
        </strong>
    </p>
    <?php if (!$data['is-joined']) : ?>
    <a href="<?= BASE_URL; ?>/Participant/joinTryOut/<?= $data['to']['to_id']; ?>" class="btn btn-royal">Join Try Out
        Sekarang</a>
    <?php else : ?>
    <a href="<?= BASE_URL; ?>/Participant/unJoinTryOut/<?= $data['to']['to_id']; ?>" class="btn btn-danger">Keluar dari
        Try Out ini</a>
    <a href="<?= BASE_URL; ?>/Participant/startTryOut/<?= $data['to']['to_id']; ?>" class="btn btn-royal">Mulai Try
        Out</a>
    <?php endif; ?>
</div>

<div class="container bg-gradient-royal">
    <p class="text-danger text-center"><?= $this->util->get_flash_data('to_participant_message'); ?></p>
    <h1 class="text-center text-gold">Comentar</h1>
    <div class="comment">
        Maaf, fitur komentar belum tersedia
    </div>
</div>