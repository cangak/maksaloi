<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReceiptModel extends CI_Model {

    public function save_receipt($data)
    {
        // Menyimpan data ke tabel 'receipts'
        return $this->db->insert('receipts', $data);
    }
}
