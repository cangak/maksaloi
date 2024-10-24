<?php defined('BASEPATH') or exit('No direct script access allowed');

class Customer_m extends CI_Model
{
    public function getCustomer($customer_id = null, $no_services = null)
    {
        $this->db->select('*');
        $this->db->from('customer');
        if ($customer_id != null) {
            $this->db->where('customer_id', $customer_id);
        }
        if ($no_services != null) {
            $this->db->where('no_services', $no_services);
        }
        $query = $this->db->get();
        return $query;
    }

    public function getNSCustomer($no_services = null)
    {
        $this->db->select('*');
        $this->db->from('customer');
        if ($no_services != null) {
            $this->db->where('no_services', $no_services);
        }
        $query = $this->db->get();
        return $query;
    }

    public function getInvoiceCustomer($no_services = null)
    {
        $this->db->select('*');
        $this->db->from('customer');
        if ($no_services != null) {
            $this->db->where('no_services', $no_services);
        }
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params = [
            'name' => $post['name'],
            'no_services' => $post['no_services'],
            'no_ktp' => $post['no_ktp'],
            'no_wa' => $post['no_wa'],
            'address' => $post['address'],
            'created' => time(),
        ];

        return $this->db->insert('customer', $params);
    }

    public function edit($post)
    {
        $params = [
            'name' => $post['name'],
            'no_ktp' => $post['no_ktp'],
            'email' => $post['email'],
            'no_wa' => $post['no_wa'],
            'address' => $post['address'],
        ];
        $this->db->where('customer_id', $post['customer_id']);
        return $this->db->update('customer', $params);
    }

    public function delete($customer_id)
    {
        $this->db->where('customer_id', $customer_id);
        return $this->db->delete('customer');
    }

    public function get_customers($month = '', $year = '')
    {
        $this->db->select('c.*, SUM(s.total) as subtotal');
        $this->db->from('customer c');
        $this->db->join('services s', 'c.no_services = s.no_services', 'left');

        if ($month && $year) {
            $this->db->like('s.date', "$year-$month", 'after');
        }

        $this->db->group_by('c.customer_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_status($customer_id, $status) {
        // Validasi input
        if (!in_array($status, ['aktif', 'nonaktif'])) {
            return [
                'success' => false,
                'message' => 'Status tidak valid.'
            ];
        }

        // Perbarui status pelanggan
        $this->db->where('customer_id', $customer_id);
        $this->db->update('customers', ['status_p' => $status]);

        // Cek apakah ada baris yang terpengaruh
        if ($this->db->affected_rows() > 0) {
            return [
                'success' => true,
                'message' => 'Status pelanggan berhasil diperbarui.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Gagal memperbarui status. Pastikan ID pelanggan valid atau status tidak berubah.'
            ];
        }
    }
}

