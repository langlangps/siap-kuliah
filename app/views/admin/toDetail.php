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
        <?php if ($data['to']['published']) : ?>
        <a href="<?= BASE_URL ?>/Admin/unpublish/<?= $data['to']['to_id']; ?>"
            class="btn btn-reverse-gold mx-auto">UnPublish Try Out</a>
        <?php else : ?>
        <a href="<?= BASE_URL ?>/Admin/publish/<?= $data['to']['to_id']; ?>"
            class="btn btn-reverse-royal mx-auto">Publish Try Out</a>
        <?php endif; ?>
    </div>

    <p class="text-center text-danger"><?= $this->util->get_flash_data('to_detail_message'); ?></p>

    <div class="container mt-1">
        <?php if ($data['to']['published']) : ?>
        <p class="text-center text-danger display-4">Anda sudah publish Try Out ini. Klik Unpublish untuk kembali
            mengubah detail try out</p>
        <?php else : ?>
        <button class="btn btn-reverse-royal ml-auto" id="toChange">Ubah Data Try Out</button>

        <div class="row p-2 bg-royal" id="form-to-change">
            <form class="mx-auto" action="<?= BASE_URL; ?>/Admin/updateTryOut/<?= $data["to"]["to_id"] ?>"
                method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Ubah Nama Try Out" name="to-name"
                        value="<?= $data['to']['name'] ?>">
                </div>
                <div class="form-group">
                    <textarea name="description" id="description" cols="30" rows="6"
                        class="form-control"><?= $data['to']['description'] ?></textarea>
                </div>
                <div class="text-gold form-group" id="to-period">
                    <div class="form-inline">
                        <label for="to-date-start">Dari</label>
                        <input class="form-control" type="date" name="to-date-start" id="to-date-start"
                            value="<?= $data['to']['date_start'] ?>">
                        <label for="to-date-end">Sampai</label>
                        <input class="form-control" type="date" name="to-date-end" id="to-date-end"
                            value="<?= $data['to']['date_end'] ?>">
                    </div>
                </div>
                <button class="btn btn-reverse-roy" name="to-change">Ubah</button>
            </form>
        </div>
        <h1 class="text-center">Kelola Soal</h1>
        <div class="row" id="q_container">
            <div id="q_input">
                <form action="<?= BASE_URL ?>/Admin/createQuestion/<?= $data['to']['to_id'] ?>" method="post">
                    <div class="form-group">
                        <input type="number" name="q_number" id="q_number" class="form-control" placeholder="Nomor">
                        <p class="text-danger text-center"><?= $this->util->get_flash_data('q_number') ?></p>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="q_body" id="q_body" cols="30" rows="6">Isi Soal</textarea>
                        <p class="text-danger text-center"><?= $this->util->get_flash_data('q_body') ?></p>
                    </div>
                    <div class="form-group">
                        <label for="a">A. </label>
                        <input type="text" class="q_options" name="a" id="a" placeholder="Opsi A">
                        <input type="radio" name="answer" value="a" checked id="a_radio">
                        <label for="a_radio">Check jika jawabannya A</label>
                        <p class="text-danger text-center"><?= $this->util->get_flash_data('a') ?></p>
                        <br>
                        <label for="b">B. </label>
                        <input type="text" class="q_options" name="b" id="b" placeholder="Opsi B">
                        <input type="radio" name="answer" value="b" id="b_radio">
                        <label for="b_radio">Check jika jawabannya B</label>
                        <p class="text-danger text-center"><?= $this->util->get_flash_data('b') ?></p>
                        <br>
                        <label for="c">C. </label>
                        <input type="text" class="q_options" name="c" id="c" placeholder="Opsi C">
                        <input type="radio" name="answer" value="c" id="c_radio">
                        <label for="c_radio">Check jika jawabannya C</label>
                        <p class="text-danger text-center"><?= $this->util->get_flash_data('c') ?></p>
                        <br>
                        <label for="d">D. </label>
                        <input type="text" class="q_options" name="d" id="d" placeholder="Opsi D">
                        <input type="radio" name="answer" value="d" id="d_radio">
                        <label for="d_radio">Check jika jawabannya D</label>
                        <p class="text-danger text-center"><?= $this->util->get_flash_data('d') ?></p>
                        <br>
                        <label for="e">E. </label>
                        <input type="text" class="q_options" name="e" id="e" placeholder="Opsi E">
                        <input type="radio" name="answer" value="e" id="e_radio">
                        <label for="e_radio">Check jika jawabannya E</label>
                        <p class="text-danger text-center"><?= $this->util->get_flash_data('e') ?></p>
                        <p class="text-danger text-center"><?= $this->util->get_flash_data('answer') ?></p>
                        <br>
                    </div>
                    <button class="btn btn-royal" type="submit" name="q_add">Buat Soal Baru</button>
                </form>
            </div>
            <div id="q_output">
                <div class="q_number" id="q_number_output"></div>
                <div class="q_body" id="q_body_output" style="border:1px black solid;"></div>
                <div class="q_options">
                    <select name="q_option" id="q_option_output">
                        <option value="">Pilih Jawaban</option>
                        <option id="a_output" >-</option>
                        <option id="b_output" >-</option>
                        <option id="c_output" >-</option>
                        <option id="d_output" >-</option>
                        <option id="e_output" >-</option>
                    </select>
                </div>
            </div>
            <div id="q_show">
                <?php foreach ($data['all-question'] as $question) : ?>
                <?php
                        $question['question_choices'] = rtrim($question['question_choices'], ";");
                        $question['question_choices'] = explode(";", $question['question_choices']); ?>
                <div class="q_item" style="border: 1px black solid;">
                    <div class="q_item_number"><?= $question['question_number']; ?></div>
                    <div class="q_item_body"><?= $question['question_body']; ?></div>
                    <?php $values = ['a', 'b', 'c', 'd', 'e']; ?>
                    <?php foreach ($question['question_choices'] as $index => $choice) : ?>
                    <div class="q_choice_<?= $values[$index] ?>">
                        <?= $choice; ?>
                    </div>
                    <?php endforeach; ?>

                    <div class="q_item_answer">
                        <select class="form-control">
                            <?php $values = ['a', 'b', 'c', 'd', 'e']; ?>
                            <?php foreach ($question['question_choices'] as $index => $choice) : ?>
                            <option value="<?= $values[$index]; ?>"><?= $values[$index]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <a
                        href="<?= BASE_URL; ?>/Admin/questionDetail/<?= $question['to_id'] . '/' . $question['question_number']; ?>">Ubah
                        Soal</a>
                </div>

                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script>
document.getElementById('q_number').addEventListener('input', function() {
    document.getElementById('q_number_output').innerHTML = this.value;
})
document.getElementById('q_body').addEventListener('input', function() {
    document.getElementById('q_body_output').innerHTML = this.value;
})
var options = document.getElementsByClassName('q_options');
for (let option of options) {
    option.addEventListener('input', function() {
        let output_id = this.id + "_output";
        document.getElementById(output_id).value = this.value;
        document.getElementById(output_id).innerHTML = this.value;
    })
}

document.getElementById("toChange").addEventListener('click', function() {
    document.getElementById('form-to-change').classList.toggle("fadeIn");
});
    </script>