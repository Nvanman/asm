<?php
class DanhMucController {
    private $danhMucModel;

    public function __construct($db) {
        $this->danhMucModel = new DanhMucModel($db);
    }

    public function index() {
        $danhMucList = $this->danhMucModel->getAllDanhMuc();
        require_once 'views/admin/danhmuc.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenDM = $_POST['ten_dm'];
            $mota = $_POST['mo_ta'];
            $matk = $_POST['ma_tk'];
            $this->danhMucModel->createDanhMuc($tenDM, $mota, $matk);
            header('Location: danhmuc.php?controller=danh-muc&action=danhmuc');
        }
        require_once 'views/admin/create.php';
    }

    public function edit($id) {
        $danhMuc = $this->danhMucModel->getDanhMucById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenDM = $_POST['ten_dm'];
            $mota = $_POST['mo_ta'];
            $matk = $_POST['ma_tk'];
            $this->danhMucModel->updateDanhMuc($id, $tenDM, $mota, $matk);
            header('Location: danhmuc.php?controller=danh-muc&action=danhmuc');
        }
        require_once 'views/admin/edit.php';
    }

    public function delete($id) {
        $this->danhMucModel->deleteDanhMuc($id);
        header('Location: danhmuc.php?controller=danh-muc&action=danhmuc');
    }
}
?>