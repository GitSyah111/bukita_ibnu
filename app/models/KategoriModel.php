<?php
class KategoriModel
{
    private $table = 'kategori';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllKategori()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getKategoriById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahKategori($data)
    {
        // Mengambil ID terakhir untuk menghindari error
        $this->db->query("SELECT MAX(id) AS max_id FROM " . $this->table);
        $result = $this->db->single();
        $newId = ($result['max_id'] ?? 0) + 1; // Hitung ID baru

        $query = "INSERT INTO kategori (id, nama_kategori) VALUES (:id, :nama_kategori)";
        $this->db->query($query);
        $this->db->bind('id', $newId);
        $this->db->bind('nama_kategori', $data['nama_kategori']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateDataKategori($data)
    {
        $query = "UPDATE kategori SET nama_kategori=:nama_kategori WHERE id=:id";
        $this->db->query($query);
        $this->db->bind('id', $data['id']);
        $this->db->bind('nama_kategori', $data['nama_kategori']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteKategori($id)
    {
        // Cek apakah ada data di tabel 'buku' yang masih mengacu ke kategori ini
        $this->db->query('SELECT COUNT(*) AS count FROM buku WHERE kategori_id = :id');
        $this->db->bind('id', $id);
        $result = $this->db->single();

        if ($result['count'] > 0) {
            // Jika ada, hapus data buku terlebih dahulu
            $this->db->query('DELETE FROM buku WHERE kategori_id = :id');
            $this->db->bind('id', $id);
            $this->db->execute();
        }

        // Setelah data terkait di buku dihapus, hapus kategori
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind('id', $id);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function cariKategori()
    {
        $key = $_POST['key'];
        $this->db->query("SELECT * FROM " . $this->table . " WHERE nama_kategori LIKE :key");
        $this->db->bind('key', "%$key%");
        return $this->db->resultSet();
    }
}
