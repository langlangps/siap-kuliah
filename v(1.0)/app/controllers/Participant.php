<?php
class Participant extends Controller
{
    protected $util;
    public function __construct()
    {
        $this->util = new Utility();
        session_start();
        if (!isset($_SESSION['participant'])) {
            echo "<script>window.location.href='" . BASE_URL . "/Auth';</script>";
            exit;
        }
    }

    public function index()
    {
        $data['title'] = 'Home | ' . $_SESSION['participant']['username'];

        try {
            $data['participant'] = $this->getModel(PARTICIPANT_MODEL)->getParticipantByUsername($_SESSION['participant']['username']);
            $participant_tos = $this->getModel(PARTICIPANT_MODEL)->getParticipantTOsByUsername($data['participant']['username']);
            $data['participant_tos'] = [];

            foreach ($participant_tos as $participant_to) {
                $to = $this->getModel(TRYOUT_MODEL)->getTryOutById($participant_to['to_id']);
                array_push($data['participant_tos'], $to);
            }

            $this->view('template/participant/header', $data);
            $this->view('participant/index', $data);
            $this->view('template/participant/footer');
        } catch (\Throwable $th) {
            echo "<script>window.location.href='" . BASE_URL . "/Auth';</script>";
            exit;
        }
    }

    public function publicTryOut($data)
    {
        if (isset($_SESSION['participant'])) {
            if (isset($data[0])) {
                $to_id = $data[0];
                $data['to'] = $this->getModel(TRYOUT_MODEL)->getTryOutById($to_id);
                // Jika terdapat id to di database, maka alihkan ke halaman toDetail
                if ($data['to']) {
                    if ($data['to']['published']) {

                        $data['title'] = $data['to']['name'];

                        $data['is-joined'] = false;
                        // Jika PArticipant sudah bergabung dengan TO Sebelumnya
                        if ($this->getModel(PARTICIPANT_MODEL)->getParticipantTOsByPK($_SESSION['participant']['username'], $to_id)) {
                            $data['is-joined'] = true;
                        }

                        $this->view('template/participant/header', $data);
                        $this->view('participant/toDetail', $data);
                        $this->view('template/participant/footer');
                    } else {
                        // Jika Try Out belum di publish oleh admin
                        echo "<script>window.location.href='" . BASE_URL . "/Participant/';</script>";
                        exit;
                    }
                } else {
                    // Jika tidak terdapat to id di dataabse, maka alihkan ke halaman to manager
                    echo "<script>window.location.href='" . BASE_URL . "/Participant/';</script>";
                    exit;
                }
            } else {
                echo '<strong>Tidak ada id Try Out yang dikirimkan</strong>';
                echo "<script>window.location.href='" . BASE_URL . "/Participant/';</script>";
            }
        } else {
            echo "<script>window.location.href='" . BASE_URL . "/Participant';</script>";
            exit;
        }
    }

    public function joinTryOut($data)
    {
        $to_id = $data[0];
        if (isset($_SESSION['participant']['username'])) {
            $username = $_SESSION['participant']['username'];
            $date_get_to = date('Y-m-d');
            try {
                if ($this->getModel(TRYOUT_MODEL)->getTryOutById($to_id)['published']) {
                    if ($this->getModel(PARTICIPANT_MODEL)->insertParticipantTO($to_id, $username, $date_get_to)) {

                        $this->util->set_flash_message('participant_message', "Berhasil bergabung dengan try out pilihan anda");
                        echo "<script>window.location.href='" . BASE_URL . "/Participant/';</script>";
                        exit;
                    } else {
                        $this->util->set_flash_message('to_participant_message', "Gagal untuk bergabung");
                    }
                } else {
                    $this->util->set_flash_message('to_participant_message', "Tidak ada try out seperti yang anda minta");
                }
            } catch (\Throwable $th) {
                $this->util->set_flash_message('to_participant_message', $th->getMessage());
            }
        }
        echo "<script>window.location.href='" . BASE_URL . "/Participant/publicTryOut/$to_id';</script>";
        exit;
    }

    public function unJoinTryOut($data)
    {
        $to_id = $data[0];
        if (isset($_SESSION['participant']['username'])) {
            $username = $_SESSION['participant']['username'];
            try {

                $this->getModel(PARTICIPANT_MODEL)->deleteParticipantTO($username, $to_id);

                $this->util->set_flash_message('participant_message', "Berhasil Keluar dari Try Out");
                echo "<script>window.location.href='" . BASE_URL . "/Participant/';</script>";
                exit;
            } catch (\Throwable $th) {
                $this->util->set_flash_message('to_participant_message', $th->getMessage());
            }
        }
        echo "<script>window.location.href='" . BASE_URL . "/Participant/publicTryOut/$to_id';</script>";
        exit;
    }

    public function logout()
    {
        unset($_SESSION['participant']);
        session_destroy();
        echo "<script>window.location.href='" . BASE_URL . "/Home/';</script>";
        exit;
    }

    public function message()
    {
        echo 'Maaf fitur ini sedang dalam pengembangan';
    }

    public function profile()
    {
        echo 'Maaf fitur ini sedang dalam pengembangan';
    }

    public function startTryOut()
    {
        echo 'Maaf fitur ini sedang dalam pengembangan';
    }

    public function forum()
    {
        echo 'Maaf fitur ini sedang dalam pengembangan';
    }

    public function myClass()
    {
        echo 'Maaf fitur ini sedang dalam pengembangan';
    }
}