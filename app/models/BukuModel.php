<?php
class BukuModel
{
    private $table = 'buku';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllBuku()
    {
        $this->db->query('SELECT buku.*, kategori.nama_kategori 
                          FROM ' . $this->table . ' 
                          JOIN kategori ON kategori.id = buku.kategori_id');
        return $this->db->resultSet();
    }

    public function getBukuById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahBuku($data)
    {
        // Hitung ID secara manual
        $this->db->query("SELECT MAX(id) AS max_id FROM " . $this->table);
        $result = $this->db->single();
        $newId = ($result['max_id'] ?? 0) + 1;

        $query = "INSERT INTO buku (id, judul, penerbit, pengarang, tahun, kategori_id, harga) 
                  VALUES(:id, :judul, :penerbit, :pengarang, :tahun, :kategori_id, :harga)";
        $this->db->query($query);
        $this->db->bind('id', $newId);
        $this->db->bind('judul', $data['judul']);
        $this->db->bind('penerbit', $data['penerbit']);
        $this->db->bind('pengarang', $data['pengarang']);
        $this->db->bind('tahun', $data['tahun']);
        $this->db->bind('kategori_id', $data['kategori_id']);
        $this->db->bind('harga', $data['harga']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateDataBuku($data)
    {
        $query = "UPDATE buku 
                  SET judul=:judul, penerbit=:penerbit, pengarang=:pengarang, tahun=:tahun, kategori_id=:kategori_id, harga=:harga 
                  WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id', $data['id']);
        $this->db->bind('judul', $data['judul']);
        $this->db->bind('penerbit', $data['penerbit']);
        $this->db->bind('pengarang', $data['pengarang']);
        $this->db->bind('tahun', $data['tahun']);
        $this->db->bind('kategori_id', $data['kategori_id']);
        $this->db->bind('harga', $data['harga']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteBuku($id)
    {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function cariBuku()
    {
        $key = $_POST['key'] ?? '';
        $this->db->query("SELECT buku.*, kategori.nama_kategori 
                          FROM " . $this->table . " 
                          JOIN kategori ON kategori.id = buku.kategori_id 
                          WHERE judul LIKE :key");
        $this->db->bind('key', "%$key%");
        return $this->db->resultSet();
    }
}