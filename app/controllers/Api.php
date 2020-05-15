<?php

class Api extends Controller
{
    public function __construct()
    {
        if (isset($_GET['to-key'])) {
            if (isset($_GET['to-name'])) {
                try {
                    $result = $this->getModel(TRYOUT_MODEL)->getByQuery(
                        "SELECT t.to_id, t.name, t.description, t.date_start, t.date_end, t.org_id, o.org_name FROM tryout t, organizations o WHERE t.org_id = o.org_id AND t.name LIKE ? AND t.published=?",
                        ['%' . $_GET['to-key'] . '%', true]
                    );
                    header('Content-type: Application/json');
                    echo json_encode($result);
                } catch (\Throwable $th) {
                    header('Content-type: Application/json');
                    echo json_encode(['error' => $th->getMessage()]);
                }
            }


            if (isset($_GET['to-org'])) {
                try {
                    $result = $this->getModel(TRYOUT_MODEL)->getByQuery(
                        "SELECT t.to_id, t.name, t.description, t.date_start, t.date_end, t.org_id, o.org_name FROM tryout t, organizations o WHERE t.org_id = o.org_id AND o.org_name LIKE ? AND t.published = ?",
                        ['%' . $_GET['to-key'] . '%', true]
                    );
                    header('Content-type: Application/json');
                    echo json_encode($result);
                } catch (\Throwable $th) {
                    header('Content-type: Application/json');
                    echo json_encode(['error' => $th->getMessage()]);
                }
            }

            if (isset($_GET['to-org']) && isset($_GET['to-name'])) {
                try {
                    $result = $this->getModel(TRYOUT_MODEL)->getByQuery(
                        "SELECT t.to_id, t.name, t.description, t.date_start, t.date_end, t.org_id, o.org_name FROM tryout t, organizations o WHERE t.org_id = o.org_id AND (o.org_name LIKE ? OR t.name LIKE ?) AND t.published = ?",
                        [0 => '%' . $_GET['to-org'] . '%', 1 => '%' . $_GET['to-name'] . '%', 2 => true]
                    );
                    header('Content-type: Application/json');
                    echo json_encode($result);
                } catch (\Throwable $th) {
                    header('Content-type: Application/json');
                    echo json_encode(['error' => $th->getMessage()]);
                }
            }
        } else {
            header('Content-type: Application/json');
            echo json_encode(['error' => "key harus ada semua"]);
        }
    }

    public function index()
    {
    }
}