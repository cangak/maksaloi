<?php defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['customer_m', 'services_m', 'bill_m']);
    }

    public function index()
    {
        $data['title'] = 'Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/customer/data', $data);
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('no_ktp', 'No KTP', 'required|trim|is_unique[customer.no_ktp]');
        $this->form_validation->set_rules('no_wa', 'No Whatsapp', 'required|trim|is_unique[customer.no_wa]');

        $this->form_validation->set_message('required', '%s Wajib di isi');
        $this->form_validation->set_message('is_unique', '%s Sudah dipakai, Silahkan ganti');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Add Customer';
            $data['company'] = $this->db->get('company')->row_array();
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

            $this->template->load('backend', 'backend/customer/add_customer', $data);
        } else {
            $post = $this->input->post(null, TRUE);
            $this->customer_m->add($post);

            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data Pelanggan berhasil disimpan');
            }

            redirect('customer');
        }
    }

    public function edit($customer_id)
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('no_ktp', 'No KTP', 'required|trim|callback_no_ktp_check');
        $this->form_validation->set_rules('no_wa', 'No Whatsapp', 'required|trim|callback_no_wa_check');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_email_check');

        $this->form_validation->set_message('required', '%s Tidak boleh kosong, Silahkan isi');

        if ($this->form_validation->run() == false) {
            $query = $this->customer_m->getCustomer($customer_id);
            if ($query->num_rows() > 0) {
                $data['customer'] = $query->row();
                $data['title'] = 'Edit Customer';
                $data['company'] = $this->db->get('company')->row_array();
                $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

                $this->template->load('backend', 'backend/customer/edit_customer', $data);
            } else {
                $this->session->set_flashdata('error', 'Data tidak ditemukan');
                redirect('customer');
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $this->customer_m->edit($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data Pelanggan berhasil diperbaharui');
            }
            redirect('customer');
        }
    }

    public function delete()
    {
        $customer_id = $this->input->post('customer_id');
        $no_services = $this->input->post('no_services');

        if ($this->services_m->getServices($no_services)->num_rows() > 0) {
            $this->session->set_flashdata('error', 'Pelanggan tidak bisa dihapus dikarenakan masih ada daftar layanan yang aktif');
            redirect('customer');
        }

        if ($this->bill_m->getCekInvoice($no_services)->num_rows() > 0) {
            $this->session->set_flashdata('error', 'Pelanggan tidak bisa dihapus dikarenakan data-nya masih digunakan di detail tagihan !');
            redirect('customer');
        }

        $this->customer_m->delete($customer_id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        }
        redirect('customer');
    }

    public function update_status()
{
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Check if $data is null or not an array
        if (!is_array($data) || !isset($data['customer_id']) || !isset($data['status_p'])) {
            echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
            return;
        }

        $customer_id = $data['customer_id'];
        $status_p = $data['status_p'];

        // Validasi status baru
        $validStatuses = ['aktif', 'nonaktif', 'pending'];
        if (!in_array($status_p, $validStatuses)) {
            echo json_encode(['success' => false, 'message' => 'Status tidak valid']);
            return;
        }

        // Ambil subtotal dari database
        $this->db->select_sum('total');
        $this->db->from('services');
        $this->db->where('no_services', $customer_id);
        $subtotal = $this->db->get()->row()->total;

        // Cek subtotal untuk menentukan apakah status dapat diubah
        if ($subtotal === 0 && $status_p !== 'pending') {
            echo json_encode(['success' => false, 'message' => 'Hanya status "pending" yang diperbolehkan jika subtotal adalah 0']);
            return;
        }

        // Update status di database
        $this->db->where('customer_id', $customer_id);
        $result = $this->db->update('customer', ['status_p' => $status_p]);

        // Mengembalikan respons
        echo json_encode(['success' => $result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

    // Fungsi validasi untuk email, no_wa, dan no_ktp tetap sama
}
