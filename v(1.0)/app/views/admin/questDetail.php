<div class="container question mt-5">
    <div class="row">
        <form
            action="<?= BASE_URL; ?>/Admin/updateQuestion/<?= $data['question']['to_id'] . '/' . $data['question']['question_number'] ?>"
            method="POST" id="q_form_change">
            <div class="form-group">
                <label for="q_number">Nomor Soal :</label>
                <br>
                <input class="q form-control" type="number" name="q_number" id="q_number"
                    value="<?= $data['question']['question_number']; ?>">
            </div>
            <div class="form-group">
                <label for="q_body">Isi Soal :</label>
                <br>
                <textarea class="q form-control" name="q_body" id="q_body" cols="30"
                    rows="10"><?= $data['question']['question_body'] ?></textarea>
            </div>
            <?php
            $values = ['a', 'b', 'c', 'd', 'e'];
            $choices = rtrim($data['question']['question_choices'], ';');
            $choices = explode(';', $choices);
            foreach ($choices as $index => $choice) :
            ?>
            <div class="form-group">
                <label for="<?= $values[$index]; ?>"><?= strtoupper($values[$index]); ?>. </label>
                <input class="q form-control" type="text" class="q_options" name="<?= $values[$index] ?>"
                    id="<?= $values[$index] ?>" placeholder="Opsi <?= strtoupper($values[$index]) ?>"
                    value="<?= $choice; ?>">

                <?php if ($values[$index] == $data['question']['answer']) : ?>
                <input type="radio" name="answer" value="<?= $values[$index]; ?>" id="<?= $values[$index]; ?>_radio"
                    checked>
                <label for="<?= $values[$index]; ?>_radio">Check ini jika jawabannya adalah
                    <?= strtoupper($values[$index]); ?></label>
                <?php else : ?>
                <input type="radio" name="answer" value="<?= $values[$index]; ?>" id="<?= $values[$index]; ?>_radio">
                <label for="<?= $values[$index]; ?>_radio">Check ini jika jawabannya adalah
                    <?= strtoupper($values[$index]); ?></label>
                <?php endif; ?>

            </div>
            <?php endforeach; ?>
            <button name="q_change" class="q_change btn btn-royal" id="q_change">Ubah Soal</button>
        </form>
    </div>
    <div class="row">
        <button id="delete" class="btn">Hapus Soal</button>
    </div>
    <a href="<?= BASE_URL; ?>/Admin/toDetail/<?= $data['question']['to_id']; ?>"><button id="back" class="btn">Kembali
            ke TO Manager</button></a>
</div>

<script>
var to_id = '<?php echo json_encode($data["question"]["to_id"]) ?>';
var q_number = '<?php echo json_encode($data["question"]["question_number"]) ?>';
</script>