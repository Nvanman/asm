<?php
class DanhMucModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllDanhMuc() {
        $sql = "SELECT * FROM danhmuc";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDanhMucById($id) {
        $sql = "SELECT * FROM danhmuc WHERE MaDM = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createDanhMuc($tenDM, $mota, $matk) {
        $sql = "INSERT INTO danhmuc (TenDM, MoTa, MaTK) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sbi", $tenDM, $mota, $matk);
        return $stmt->execute();
    }

    public function updateDanhMuc($id, $tenDM, $mota, $matk) {
        $sql = "UPDATE danhmuc SET TenDM = ?, MoTa = ?, MaTK = ? WHERE MaDM = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sbii", $tenDM, $mota, $matk, $id);
        return $stmt->execute();
    }

    public function deleteDanhMuc($id) {
        $sql = "DELETE FROM danhmuc WHERE MaDM = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>