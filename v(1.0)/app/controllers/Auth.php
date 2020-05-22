<?php

class Auth extends Controller
{
    protected $util;
    public function __construct()
    {
        $this->util = new Utility();
        session_start();
        $this->util = new Utility();
        if (isset($_SESSION['participant'])) {
            $data['title'] = 'Home | ' . $_SESSION['participant']['username'];
            echo "<script>window.location.href='" . BASE_URL . "/Participant/';</script>";
            exit();
        }
        if (isset($_SESSION['admin'])) {
            $data['title'] = 'Admin | ' . $_SESSION['admin']['username'];
            echo "<script>window.location.href='" . BASE_URL . "/Admin/';</script>";
            exit();
        }
    }

    public function index()
    {
        $this->util->set_flash_message('password');
        $this->util->set_flash_message('username');
        $this->util->set_flash_message('auth');

        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Menyimpan sesi berupa username agar pengguna tidak perlu login jika berganti halaman ataupun browser
            // Melakukan Validasi Form
            $this->util->formValidation_required('password');
            $this->util->formValidation_required('username');


            if ($this->util->formValidate_run()) {
                // Mengambil data user dari dataabse
                $user = $this->getModel(USER_MODEL)->getUserByUsername($username);

                if ($user) {
                    $this->util->formValidation_password('password', $user['password']);

                    if ($this->util->formValidate_run()) {
                        if ($user['role'] == "admin") {
                            $_SESSION['admin']['username'] = $user['username'];
                            $_SESSION['admin']['id'] = $user['id'];

                            echo 'Anda sedang di alihkan';
                            echo "<script>window.location.href='" . BASE_URL . "/Admin/';</script>";
                            exit;
                        } else if ($user['role'] == 'participant') {
                            $_SESSION['participant']['username'] = $user['username'];
                            $_SESSION['participant']['id'] = $user['id'];

                            echo 'Anda sedang di alihkan';
                            echo "<script>window.location.href='" . BASE_URL . "/Participant/';</script>";
                            die();
                        } else {
                            $this->util->set_flash_message('auth', "Tidak ada role id dalam database");
                        }
                    }
                } else {
                    $this->util->set_flash_message('username', 'Tidak ada username dalam database');
                }
            }
        }

        $data['title'] = 'Login';
        $data['flash-message'] = $this->util->get_flash_message();

        $this->view('template/header', $data);
        $this->view("auth/index", $data);
        $this->view('template/footer');
    }

    public function signup()
    {
        $this->util->set_flash_message('username');
        $this->util->set_flash_message('name');
        $this->util->set_flash_message('password');
        $this->util->set_flash_message('conformPassword');
        $this->util->set_flash_message('email');
        $this->util->set_flash_message('gender');

        // Jika post sebagai admin
        if (isset($_POST['admin'])) {
            $username = $_POST['username'];
            $date_now = date('Y-m-d');
            $name = $_POST['name'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $email = $_POST['email'];
            $role_admin = "leader";

            $this->util->formValidation_required('username');
            $this->util->formValidation_required('name');
            $this->util->formValidation_required('password');
            $this->util->formValidation_required('conformPassword');
            $this->util->formValidation_required('email');
            $this->util->formValidation_required('gender');

            $this->util->formValidation_minLength('password', 8);

            if ($this->util->formValidate_run()) {
                $user = $this->getModel(USER_MODEL)->getUserByUsername($username);
                // Jika username tidak ada di database
                if (!$user) {
                    $org = $this->getModel(ORG_MODEL)->getOrgByName($name);
                    // Saat membuat akun admin, secara otomatis akan tercipta data organisasi dengan default nya diambil dari data akun admin yang baru dibuat
                    // Hal ini bertujuan agar admin dapat langsung mengelola try out. Sesuai dengan rancangan sistem try out
                    // Sehingga diperlukan pengecekan agar tidak terjadi duplikasi nama organisasi
                    // Jika nama organisasi tidak ada di database
                    if (!$org) {
                        try {
                            // Menambah data organisasi 
                            $this->getModel(ORG_MODEL)->insertOrg(
                                $name,
                                $date_now,
                                $email,
                                $password
                            );

                            // Menambahkan data user ke dalam database User
                            $this->getModel(USER_MODEL)->insertUser($username, $password, $date_now, 'admin');

                            // Mengambil id organsasi yang baru saja di tambahkan
                            $org_id = $this->getModel(ORG_MODEL)->getOrgByName($name);
                            $org_id = $org_id['org_id'];

                            // Menambahkan data admin ke dalam database Admin
                            $this->getModel(ADMIN_MODEL)->insertAdmin(
                                null,
                                $org_id,
                                $name,
                                $email,
                                $username,
                                $role_admin
                            );

                            echo "<script>window.location.href='" . BASE_URL . "/Auth/';</script>";
                            exit;
                        } catch (PDOException $th) {
                            $this->util->set_flash_message('auth', $th->getMessage());
                        }
                    }
                }
            }
        }


        // Sign Up Bagian Participant
        if (isset($_POST['participant'])) {
            $this->util->formValidation_required('username');
            $this->util->formValidation_required('name');
            $this->util->formValidation_required('password');
            $this->util->formValidation_required('conformPassword');
            $this->util->formValidation_required('email');
            $this->util->formValidation_required('gender');

            $this->util->formValidation_minLength('password', 8);

            if ($this->util->formValidate_run()) {

                try {
                    $user = $this->getModel(USER_MODEL)->getUserByUsername($_POST['username']);

                    // Mengecek apakah user dengan username yang dikirimkan sudah ada di dtabase atau belum
                    if (!$user) {
                        $date_now = date('Y-m-d');

                        $this->getModel(USER_MODEL)->insertUser($_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT), $date_now, 'participant');

                        $this->getModel(PARTICIPANT_MODEL)->insertParticipant(
                            $_POST['name'],
                            $_POST['gender'],
                            $_POST['email'],
                            $_POST['username']
                        );

                        echo "<script>window.location.href='" . BASE_URL . "/Auth/';</script>";
                        exit;
                    } else {
                        $this->util->set_flash_message('auth', "Username sudah dipakai");
                    }
                } catch (\Throwable $th) {
                    $this->util->set_flash_message('auth', $th->getMessage());
                }
            }
        }

        $data['title'] = "Sign Up";
        $data['flash-message'] = $this->util->get_flash_message();
        $this->view('template/header', $data);
        $this->view('auth/signup', $data);
        $this->view('template/footer');
    }
}