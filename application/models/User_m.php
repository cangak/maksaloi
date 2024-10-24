<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_m extends CI_Model
{
    /**
     * Fungsi untuk mendapatkan data pengguna
     * @param int|null $id ID pengguna (optional)
     * @return object Query result
     */

     public function __construct() {
        $this->load->database();
    }

    public function add_user($data) {
        return $this->db->insert('users', $data);
    }
    
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('user');  // Ambil data dari tabel 'user'
        $this->db->where('email !=', 'ginginabdulgoni@gmail.com');  // Kecualikan email tertentu

        // Jika ada ID, maka tambahkan kondisi untuk ID tersebut
        if ($id != null) {
            $this->db->where('id', $id);
        }

        // Eksekusi query dan kembalikan hasilnya
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Fungsi untuk mengedit pengguna
     * @param array $post Data yang akan diupdate
     */
    public function edit($post)
    {
        // Parameter yang akan diupdate
        $params = [
            'is_active' => $post['is_active'],
            'role_id'   => $post['role_id'],
        ];

        // Update data pada tabel 'user' berdasarkan ID
        $this->db->where('id', $post['id']);
        $this->db->update('user', $params);
    }

    /**
     * Fungsi untuk menghapus pengguna berdasarkan ID
     * @param int $id ID pengguna yang akan dihapus
     */
    public function del($id)
    {
        // Hapus data pada tabel 'user' berdasarkan ID
        $this->db->where('id', $id);
        $this->db->delete('user');
    }
}

