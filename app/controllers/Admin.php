<?php
class Admin extends Controller
{
    private $admin;
    protected $util;
    public function __construct()
    {
        session_start();
        $this->util = new Utility();
        if (!isset($_SESSION['admin'])) {
            echo "<script>window.location.href='" . BASE_URL . "/Auth/';</script>";
            exit;
        }
    }

    public function index()
    {
        // User akan memiliki organisasi otomatis saat ia pertama kali melakukan sign up di aplikasi siapKuliahCom
        if (sizeof($this->getModel(ADMIN_MODEL)->getAdminByAdminUsername($_SESSION['admin']['username'])) < 1) {
            // Jika User ini tidak memiliki organisasi sama sekali, maka ia harus ke halaman orgAuth untuk membuat organisasi
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth';</script>";
            exit;
        } else {
            // Jika ada, maka alihkan ke halaman Admin Index
            $data['title'] = 'Admin | ' . $_SESSION['admin']['username'];
            $data['admin'] = $this->getModel(ADMIN_MODEL)->getByQuery(
                'SELECT username, name, email, role  FROM admin WHERE username = ?;',
                [0 => $_SESSION['admin']['username']]
            )[0];
            $this->view('template/admin/header', $data);
            $this->view('admin/index', $data);
            $this->view('template/admin/footer');
        }
    }

    public function logout()
    {
        unset($_SESSION['admin']);
        echo "<script>window.location.href='" . BASE_URL . "/Home/';</script>";
        exit;
    }


    public function orgAuth()
    {
        if (isset($_POST['org_auth'])) {
            // Jika ada POST, maka lakukan pengecekan
            $org_id = $_POST['org_id'];
            $password = $_POST['password'];

            $org = $this->getModel(ORG_MODEL)->getOrgById($org_id);

            if ($org) {
                if (password_verify($password, $org['password'])) {
                    $_SESSION['admin']['org_id'] = $org['org_id'];

                    $this->util->set_flash_message('admin_message', "Kini anda dapat mengelola " . $org['org_name']);

                    echo "<script>window.location.href='" . BASE_URL . "/Admin/';</script>";
                    exit;
                }
            }
            echo "Gagal untuk autentifikasi";
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth';</script>";
            exit;
        } else if (isset($_POST['org_add'])) {
            $org_name = $_POST['org-name'];
            $org_email = $_POST['org-email'];
            $password = $_POST['password'];
            $estab_date = date('Y-m-d');

            $this->util->formValidation_required('org_name');
            $this->util->formValidation_required('org_email');
            $this->util->formValidation_required('password');

            if ($this->util->formValidate_run()) {
                try {
                    if ($this->getModel(ORG_MODEL)->insertOrg($org_name, $estab_date, $org_email, password_hash($password, PASSWORD_DEFAULT))) {
                        $org_id = $this->getModel(ORG_MODEL)->getOrgByName($org_name)["org_id"];
                        $username = $_SESSION['admin']['username'];

                        $this->getModel(ADMIN_MODEL)->insertAdmin(
                            null,
                            $org_id,
                            $username,
                            "",
                            $username,
                            'leader'
                        );

                        $_SESSION['admin']['org_id'] = $org_id;

                        $this->util->set_flash_message('admin_message', "Kini anda bisa mengelola $org_name");
                        echo "<script>window.location.href='" . BASE_URL . "/Admin/';</script>";
                        exit;
                    }
                } catch (\Throwable $th) {
                    $this->util->set_flash_message('org_auth_message', $th->getMessage());
                }
            }
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth';</script>";
            exit;
        } else {
            // Jika tidak ada post, maka tampilkan halaman autentifikasi organization
            $data['title'] = "Auth For Organization";

            $admin_org_ids = $this->getModel(ADMIN_MODEL)->getByQuery(
                "SELECT org_id FROM admin WHERE username = ?;",
                [0 => $_SESSION['admin']['username']]
            );

            $data['orgs'] = [];

            foreach ($admin_org_ids as $org_id) {
                $org = $this->getModel(ORG_MODEL)->getOrgById($org_id['org_id']);
                array_push($data['orgs'], $org);
            }

            $this->view('template/admin/header', $data);
            $this->view('admin/orgAuth', $data);
            $this->view('template/admin/footer');
        }
    }


    public function orgMember()
    {
        // Pertama, perlu pengecekan apakah yang meminta dta nya adalah admin. Sementara ini tidak memakai token api
        if (isset($_SESSION['admin']['org_id'])) {
            if (isset($_POST['regex'])) {
                $org_id = $_SESSION['admin']['org_id'];
                $regex = $_POST['regex'];

                $resultSet = $this->getModel(ADMIN_MODEL)->getByQuery(
                    "SELECT username, name, email, role FROM admin WHERE username LIKE ? AND  org_id = ?;",
                    [1 => $org_id, 0 => '%' . $regex . '%']
                );
                echo json_encode($resultSet);
            }
        }
    }


    public function toManager()
    {
        $data['title'] = 'Pengelola Try Out';
        $data['org'] = $this->getModel(ADMIN_MODEL)->getByQuery(
            "SELECT org_id FROM admin WHERE username = ?;",
            [0 => $_SESSION['admin']['username']]
        );

        // Apakah ada post yang dikirimkan?
        if (!isset($_SESSION['admin']['org_id'])) {
            // Jika tidak ada sesi, jalankan ini
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth/';</script>";
            exit;
        } else {
            // Jika ada sesi, jalankan ini
            $data['all-try-out'] = $this->getModel('Tryout_model')->getTryOutByOrgId($_SESSION['admin']['org_id']);

            $this->view('template/admin/header', $data);
            $this->view('admin/toManager', $data);
            $this->view('template/admin/footer');
        }

        // Jika ada post, maka jalankan ini
        // $_SESSION['admin']['org_id'] = (int) $_POST['org_id'];

        // $data['all-try-out'] = $this->getModel('Tryout_model')->getTryOutByOrgId($_POST['org_id']);

        // $this->view('template/admin/header', $data);
        // $this->view('admin/toManager', $data);
        // $this->view('template/admin/footer');

    }

    public function toDetail($to_id)
    {
        if (isset($_SESSION['admin']['org_id'])) {
            if (isset($to_id[0])) {
                $data['to'] = $this->getModel('Tryout_model')->getTryOutById($to_id[0]);
                $data['to']['date_start'] = date_format(date_create($data['to']['date_start']), "Y-m-d");
                $data['to']['date_end'] = date_format(date_create($data['to']['date_end']), "Y-m-d");
                // Jika terdapat id to di database, maka alihkan ke halaman toDetail
                if ($data['to']) {
                    $data['title'] = $data['to']['name'];

                    $data['all-question'] = $this->getModel('Question_model')->getQuestionsByToId($to_id[0]);
                    // print_r($data['all-question']);

                    $this->view('template/admin/header', $data);
                    $this->view('admin/toDetail', $data);
                    $this->view('template/admin/footer');
                } else {
                    // Jika tidak terdapat to id di dataabse, maka alihkan ke halaman to manager
                    echo "<script>window.location.href='" . BASE_URL . "/Admin/toManager/';</script>";
                    exit;
                }
            } else {
                echo '<strong>Tidak ada id Try Out yang dikirimkan</strong>';
                echo "<script>window.location.href='" . BASE_URL . "/Admin/toManager/';</script>";
            }
        } else {
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth';</script>";
            exit;
        }
    }

    public function createTryOut()
    {
        if (isset($_SESSION['admin']['org_id'])) {
            if (isset($_POST['create-to'])) {
                // $admin = $this->getModel('User_model')->getUserById($_SESSION['admin']['id']);

                $this->util->formValidation_required('to-name');
                $this->util->formValidation_required('description');

                if ($this->util->formValidate_run()) {
                    $org_id = $_SESSION['admin']['org_id'];
                    $to_name = $_POST['to-name'];
                    $description = $_POST['description'];
                    $date_created = date('Y-m-d');
                    $date_start = null;
                    $date_end = null;
                    if ($_POST['to-date-start'] != "") {
                        $date_start = date('Y-m-d', strtotime($_POST['to-date-start']));
                    }
                    if ($_POST['to-date-end'] != "") {
                        $date_end = date('Y-m-d', strtotime($_POST['to-date-end']));
                    }
                    try {
                        $this->getModel('Tryout_model')->insertTryOut(
                            $to_name,
                            $description,
                            $date_created,
                            $date_start,
                            $date_end,
                            $org_id
                        );
                        $this->util->set_flash_message('to_manager_message', "Try Out Berhasil Ditambahkan");
                        echo "<script>window.location.href='" . BASE_URL . "/Admin/toManager';</script>";
                        exit;
                    } catch (\Throwable $th) {
                        $this->util->set_flash_message('to_manager_message', $th->getMessage());
                    }
                }
            }
            echo "<script>window.location.href='" . BASE_URL . "/Admin/toManager';</script>";
            exit;
        } else {
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth';</script>";
            exit;
        }
    }

    public function publish($data)
    {
        if (isset($_SESSION['admin']['org_id'])) {
            $to_id = $data[0];
            $to = $this->getModel(TRYOUT_MODEL)->getTryOutById($to_id);
            // Jika ada Try out dalam database
            if ($to) {
                // Jika admin yang mengubahnya sesuai dengan admin yang mengelola to
                if ($to['org_id'] == $_SESSION['admin']['org_id']) {
                    $this->getModel(TRYOUT_MODEL)->updateByQuery(
                        "UPDATE tryout SET published = ? WHERE to_id = ?;",
                        [1, $to_id]
                    );
                } else {
                    $this->util->set_flash_message('to_detail_message', "Anda tidak punya otorisasi untuk melakukan publish");
                }
            } else {
                $this->util->set_flash_message('to_detail_message', "Tidak ada Try Out dengan id yang dikirimkan dalam database");
            }
        } else {
            $this->util->set_flash_message('to_detail_message', "Tidak dapat publish TO");
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth';</script>";
            exit;
        }
        echo "<script>window.location.href='" . BASE_URL . "/Admin/toDetail/$to_id';</script>";
        exit;
    }

    public function unpublish($data)
    {
        if (isset($_SESSION['admin']['org_id'])) {
            $to_id = $data[0];
            $to = $this->getModel(TRYOUT_MODEL)->getTryOutById($to_id);
            // Jika ada Try out dalam database
            if ($to) {
                // Jika admin yang mengubahnya sesuai dengan admin yang mengelola to
                if ($to['org_id'] == $_SESSION['admin']['org_id']) {
                    $this->getModel(TRYOUT_MODEL)->updateByQuery(
                        "UPDATE tryout SET published = ? WHERE to_id = ?;",
                        [0, $to_id]
                    );
                } else {
                    $this->util->set_flash_message('to_detail_message', "Anda tidak punya otorisasi untuk melakukan publish");
                }
            } else {
                $this->util->set_flash_message('to_detail_message', "Tidak ada Try Out dengan id yang dikirimkan dalam database");
            }
        } else {
            $this->util->set_flash_message('to_detail_message', "Tidak dapat publish TO");
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth';</script>";
            exit;
        }
        echo "<script>window.location.href='" . BASE_URL . "/Admin/toDetail/$to_id';</script>";
        exit;
    }

    public function updateTryOut($data)
    {
        if (isset($_SESSION['admin']['org_id'])) {

            if (isset($_POST['to-change'])) {

                $to_id = $data[0];
                $to = $this->getModel('Tryout_model')->getTryOutById($to_id);
                if ($to) {
                    if (
                        $this->getModel('Tryout_model')->updateTryOutById(
                            $_POST['to-name'],
                            $_POST['description'],
                            $_POST['to-date-start'],
                            $_POST['to-date-end'],
                            $to_id
                        )
                    ) {
                        echo "<script>window.location.href='" . BASE_URL . "/Admin/toDetail/$to_id';</script>";
                        exit;
                    } else {
                        echo "Gagal Mengupdate Try Out";
                        echo "<script>window.location.href='" . BASE_URL . "/Admin/toDetail/$to_id';</script>";
                        exit;
                    }
                } else {
                    echo "Tidak ada Try out yang dimaksud dalam database";
                    echo "<script>window.location.href='" . BASE_URL . "/Admin/toDetail/$to_id';</script>";
                    exit;
                }
            } else {
                echo "Tidak ada Form yang dikirimkan";
                echo "<script>window.location.href='" . BASE_URL . "/Admin/toDetail/$to_id';</script>";
                exit;
            }
        } else {
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth';</script>";
            exit;
        }
    }


    public function createQuestion($toId)
    {
        // Mengecek apakah ada post yang dikirimkan
        if (isset($_SESSION['admin']['org_id'])) {
            $this->util->formValidation_required('q_number');
            $this->util->formValidation_required('q_body');
            $this->util->formValidation_required('q_options');
            $this->util->formValidation_required('answer');
            if ($this->util->formValidate_run()) {
                if (isset($_POST['q_add'])) {
                    // Menegcek apakah memang ada id try out di database
                    if ($this->getModel('Tryout_model')->getTryOutById($toId[0])) {

                        $question_number = (int) $_POST['q_number'];
                        $to_id = $toId[0];
                        $question_body = $_POST['q_body'];
                        $question_choices = $_POST['a'] . ';' . $_POST['b'] . ';' . $_POST['c'] . ';' . $_POST['d'] . ';' . $_POST['e'] . ';';
                        $answer = $_POST['answer'];
                        $time_created = date('Y-m-d H:i:s');
                        $admin_username = $_SESSION['admin']['username'];

                        try {
                            $this->getModel('Question_model')->createQuestion(
                                $question_number,
                                $to_id,
                                $question_body,
                                $question_choices,
                                $answer,
                                $time_created,
                                $admin_username
                            );
                            $this->util->set_flash_message('to_detail_message', "Berhasil menambahkan soal");
                        } catch (\Throwable $th) {
                            $this->util->set_flash_message('to_detail_message', $th->getMessage());
                        }
                    } else {
                        // Jika id try out tidak ada,maka jalankan ini
                        // Hal ini jaga jaga jika terdapat inspeksi element dalam browser dan mengubah action pada form dan mengubah parameter toId nya
                        $this->util->set_flash_message('to_detail_message', "Tidak ada try out yang dimaksud dalam database");
                    }
                }
            }
        } else {
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth';</script>";
            exit;
        }
        echo "<script>window.location.href='" . BASE_URL . "/Admin/toDetail/$to_id';</script>";
        exit;
    }


    public function questionDetail($questionData)
    {
        if (isset($_SESSION['admin']['org_id'])) {
            $to_id = (int) $questionData[0];
            $question_number = (int) $questionData[1];
            // Jika terdapat question di database yang sesuai dengan parameter url yang dikirim
            $question = $this->getModel('Question_model')->getQuestionByPK($to_id, $question_number);
            if ($question) {

                $data['question'] = $question;
                $data['title'] = 'Edit Soal';

                $this->view('template/admin/header', $data);
                $this->view('admin/questDetail', $data);
                $this->view('template/admin/footer');
            } else {
                echo 'tidak jalan';
            }
        } else {
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth';</script>";
            exit;
        }
    }

    public function updateQuestion($data)
    {
        if (isset($_SESSION['admin']['org_id'])) {

            $question_number = (int) $_POST['q_number'];
            $question_body = $_POST['q_body'];
            $question_choices = $_POST['a'] . ';' . $_POST['b'] . ';' . $_POST['c'] . ';' . $_POST['d'] . ';' . $_POST['e'] . ';';
            $answer = $_POST['answer'];
            $to_id = $data[0];
            $old_question_number = $data[1];

            if (isset($_POST['q_change'])) {
                try {
                    if ($this->getModel('Question_model')->updateQuestion(
                        $question_number,
                        $question_body,
                        $question_choices,
                        $answer,
                        $to_id,
                        $old_question_number
                    )) {
                        $this->util->set_flash_message('to_detail_message', "Berhasil mengubah Soal");
                        echo "<script>window.location.href='" . BASE_URL . "/Admin/toDetail/$to_id';</script>";
                        exit;
                    }
                } catch (PDOException $th) {
                    $this->util->set_flash_message('to_detail_message', $th->getMessage());
                    echo "<script>window.location.href='" . BASE_URL . "/Admin/toDetail/$to_id';</script>";
                    exit;
                }
            }
        } else {
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth';</script>";
            exit;
        }
        echo "<script>window.location.href='" . BASE_URL . "/Admin/toDetail/$to_id';</script>";
        exit;
    }

    public function deleteQuestion($data)
    {
        if (isset($_SESSION['admin']['org_id'])) {

            if (isset($data)) {
                $to_id = $data[0];
                $question_number = $data[1];

                $this->getModel('Question_model')->deleteQuestionByPK($to_id, $question_number);
                echo "<script>window.location.href='" . BASE_URL . "/Admin/toDetail/ $to_id';</script>";
                exit;
            } else {
                echo 'Tidak ada parameter yang diberikan';
            }
        } else {
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth';</script>";
            exit;
        }
    }




    // Pengelolaan Organisasi
    public function orgManager()
    {
        // Diperlukan pengecekan agar tidak sembarang orang dapat melihat maupun mengubah detial organisasi, sehingga hanya user yang memiliki sesi org_id yang bisa masuk. Jika tidak ada, maka akan diarahkan ke orgAuth
        if (isset($_SESSION['admin']['org_id'])) {
            $org_id = $_SESSION['admin']['org_id'];
            $username = $_SESSION['admin']['username'];
            $org = $this->getModel(ORG_MODEL)->getOrgById($org_id);
            $admin_role = $this->getModel(ADMIN_MODEL)->getByQuery(
                "SELECT role FROM admin WHERE username = ? AND org_id = ?",
                [0 => $username, 1 => $org_id]
            );

            if ($org) {

                $data['member'] = $this->getModel(ADMIN_MODEL)->getAdminByOrgId($org['org_id']);
                $data['org'] = $org;
                $data['admin_role'] = $admin_role[0]['role'];
                $data['title'] = "Organization Manager";
                // $data['flash-message'] = $this->util->get_flash_message();

                $this->view('template/admin/header', $data);
                $this->view('admin/orgManager', $data);
                $this->view('template/admin/footer');
            }
        } else {
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgAuth/';</script>";
            exit;
        }
    }

    public function insertNewAdmin()
    {
        $this->util->set_flash_message('name');
        $this->util->set_flash_message('username');
        $this->util->set_flash_message('password');
        $this->util->set_flash_message('conformPassword');
        $this->util->set_flash_message('email');
        if (isset($_POST['insert-new-admin'])) {
            $this->util->formValidation_required('name');
            $this->util->formValidation_required('username');
            $this->util->formValidation_minLength('password', 8);
            $this->util->formValidation_required('conformPassword');
            $this->util->formValidation_required('email');

            if ($this->util->formValidate_run()) {
                try {
                    $user  = $this->getModel('User_model')->getUserByUsername($_POST['username']);

                    if (!$user) {
                        $date_joined = date('Y-m-d');
                        $username = $_POST['username'];
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                        $role = 'admin';
                        $org_id = $_SESSION['admin']['org_id'];
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $role_admin = $_POST['role'];
                        $this->getModel('User_model')->insertUser(
                            $username,
                            $password,
                            $date_joined,
                            $role
                        );


                        $this->getModel(ADMIN_MODEL)->insertAdmin(
                            null,
                            $org_id,
                            $name,
                            $email,
                            $username,
                            $role_admin
                        );

                        $this->util->set_flash_message('org-message', 'Anda berhasil menambahkan' . $username);
                        echo "<script>window.location.href='" . BASE_URL . "/Admin/orgManager';</script>";
                        exit;
                    } else {
                        $this->util->set_flash_message('org-message', "Username sudah terdaftar");
                    }
                } catch (\Throwable $th) {
                    $this->util->set_flash_message('org-message', $th->getMessage());
                }
            }
        }

        echo "<script>window.location.href='" . BASE_URL . "/Admin/orgManager';</script>";
        exit;
    }

    public function updateOrg()
    {
        $org_id = $_SESSION['admin']['org_id'];
        $username = $_SESSION['admin']['username'];
        $admin = $this->getModel(ADMIN_MODEL)->getAdminByPK($org_id, $username);

        if (isset($_POST['org_change'])) {
            // Di cek apakah admin yang melakukan post benar-benar ada  
            if ($admin) {
                $org_name = $_POST['org_name'];
                $org_email = $_POST['org_email'];
                $password = $_POST['password'];
                $estab_date = date('Y-m-d', strtotime($_POST['estab_date']));
                try {
                    $org_password = $this->getModel(ORG_MODEL)->getOrgPassword($org_id)['password'];
                    if (password_verify($password, $org_password)) {

                        if ($this->getModel(ORG_MODEL)->updateOrgDetail($org_name, $org_email, $estab_date, $org_id)) {
                            $this->util->set_flash_message('org_message', 'Berhasil mengubah detail Organisasi');
                            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgManager';</script>";
                            exit;
                        } else {
                            $this->util->set_flash_message('org_messsage', "Gagal Mengubah Detail Organisasi");
                        }
                    } else {
                        $this->util->set_flash_message('org_message', 'Password yang dimasukkan salah');
                    }
                } catch (PDOException $pe) {
                    $this->util->set_flash_message('org_messsage', $pe->getMessage());
                }
            } else {
                $this->util->set_flash_message('org_messsage', "Gagal Mengubah Detail Organisasi");
            }
            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgManager';</script>";
            exit;
        }

        if (isset($_POST['org-password-change'])) {
            if ($admin) {
                $newPassword = $_POST['new-password'];
                $oldPassword = $_POST['old-password'];
                $confirmPassword = $_POST['confirm-password'];

                $this->util->formValidation_required('new-password');

                if ($this->util->formValidate_run()) {
                    $password = $this->getModel(ORG_MODEL)->getOrgPassword($org_id)["password"];
                    if ($confirmPassword == $newPassword) {
                        if (password_verify($oldPassword, $password)) {
                            if ($this->getModel(ORG_MODEL)->updateOrgPassword(password_hash($newPassword, PASSWORD_DEFAULT), $org_id)) {
                                $this->util->set_flash_message('org_message', 'Berhasil mengubah Password!');
                                echo "<script>window.location.href='" . BASE_URL . "/Admin/orgManager';</script>";
                                exit;
                            }
                        } else {
                            $this->util->set_flash_message('old-password', 'Password tidak sesuai');
                        }
                    } else {
                        $this->util->set_flash_message('confirm-password', 'Password Konfirmasi tidak sesuai');;
                    }
                }
            }

            echo "<script>window.location.href='" . BASE_URL . "/Admin/orgManager';</script>";
            exit;
        }
    }

    public function deleteOrg()
    {
        if (isset($_SESSION['admin']['org_id'])) {
            $org_id = $_SESSION['admin']['org_id'];

            $org = $this->getModel(ORG_MODEL)->getOrgById($org_id);
            if ($org) {
                try {
                    $this->getModel(ORG_MODEL)->deleteOrg($org_id);
                    unset($_SESSION['admin']['org_id']);

                    echo "<script>window.location.href='" . BASE_URL . "/Admin';</script>";
                    exit;
                } catch (\Throwable $th) {
                    $this->util->set_flash_message('org_message', $th->getMessage());
                }
            }
        }
        echo "<script>window.location.href='" . BASE_URL . "/Admin/orgManager';</script>";
        exit;
    }

    public function statistics()
    {
        echo "Maaf, fitur ini belum tersedia";
    }

    public function message()
    {
        echo "Maaf, fitur ini belum tersedia";
    }
}