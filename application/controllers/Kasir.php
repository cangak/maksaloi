<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['customer_m', 'package_m', 'services_m', 'bill_m', 'income_m', 'user_m', 'payment_m']);
    }
    

    public function index()
    {
        $data['title'] = 'Kasir';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['bill'] = $this->bill_m->getInvoice()->result();
        $data['detail'] = $this->bill_m->getInvoiceDetail()->result();
        $data['invoice'] = $this->bill_m->invoice_no();
        $data['company'] = $this->db->get('company')->row_array();
        $data['status'] = $this->db->get('transaksi_midtrans')->result();
        $this->template->load('backend', 'payment/pay_manual', $data); // Load view
    }

    

    public function view_bill()
    {
        $no_services = $this->input->post('no_services');
         
        if ($no_services) {
         
            $data['customer'] = $this->customer_m->getNSCustomer($no_services);
    

            if ($data['customer']) {
                // Definisikan variabel $month dan $year (sesuaikan sumber datanya)
                $month = date('m'); // Ambil bulan saat ini
                $year = date('Y');  // Ambil tahun saat ini
                // Dapatkan kode invoice
                $data['invoice_id'] = $this->bill_m->invoice_no(); // Mengambil kode invoice
    
                // Ambil status transaksi
                $data['status'] = $this->db->get('invoice')->result(); // Fetching the status for bills
    
                // Ambil data user dari session
                $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    
                // Cek jika tombol 'cek2' dipencet
                if ($this->input->post('cek2')) {
                    // Dapatkan tagihan (bill) berdasarkan no_services
                    $data['bill'] = $this->services_m->getCekBill($no_services);
                    
                    // Load view dengan data yang sudah lengkap
                    $this->load->view('frontend/cek2', $data);
                } else {
                    echo "Not Found"; // Jika tombol 'cek2' tidak ditekan
                }
            } else {
                echo "Customer not found"; // Jika customer tidak ditemukan
            }
        } else {
            echo "No Services Input"; // Jika no_services tidak diisi
        }
    }
    
    public function status()
    {
        $data['midtrans'] = $this->db->get('transaksi_midtrans')->result();
        $this->load->view('frontend/cekbill', $data);
    }
  

    public function simpan_transaksi()
    {
        // Ambil data dari request
        $data = [
            'no_services' => $this->input->post('no_services'),
            'name' => $this->input->post('name'),
            'address' => $this->input->post('address'),
            'totalbayar' => $this->input->post('totalbayar'),
            // Tambahkan data lain yang diperlukan
        ];

        // Simpan ke database
        $this->db->insert('invoice', $data);

        echo json_encode(['status' => 'success']);
    }

   
    public function payment()
    {
        // Pastikan ini adalah request POST
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            // Ambil data dari request POST
            $post = $this->input->post(null, TRUE);
            $invoice = $this->input->post('invoice');
            $total = $this->input->post('total');
            $selectedBills = $this->input->post('selectedBills'); // Ini adalah array tagihan
            log_message('debug', 'Selected Bills: ' . print_r($selectedBills, TRUE));
            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $no_services = $this->input->post('no_services');
            $tanggal = $this->input->post('tanggal');
            $cashier = $this->input->post('cashier');
            
            // Load library dan helper yang diperlukan
            $this->load->helper('url');
            $this->load->library('form_validation');
    
            // Validasi input
            if (empty($selectedBills) || !is_array($selectedBills)) {
                echo json_encode(['status' => 'error', 'message' => '<p>The Selected Bills field is required.</p>']);
                return;
            }
            $this->form_validation->set_rules('invoice', 'Invoice', 'required');
            $this->form_validation->set_rules('total', 'Total', 'required|numeric');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('no_services', 'Service Number');
    
            // Jika validasi gagal
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(['status' => 'error', 'message' => validation_errors()]);
                return;
            }
    
            // Persiapkan data transaksi utama
            $transaction_data = array(
                'invoice_no' => $invoice,
                'total_amount' => $total,
                'name' => $name,
                'address' => $address,
                'no_services' => $no_services,
                'transaction_date' => $tanggal,
                'cashier' => $cashier,
                'status' => 'SUDAH BAYAR'
            );
    
            // Simpan transaksi utama
            $transaction_id = $this->payment_m->insert_transaction($transaction_data);
    
            if ($transaction_id) {
                // Simpan detail tagihan (selectedBills) ke database
                foreach ($selectedBills as $bill) {
                    $invoice_data = array(
                        'transaction_id' => $transaction_id,
                        'amount' => $bill
                    );
                    $this->payment_m->insert_bill_detail($invoice_data); // Perbaiki variabel di sini
                }
    
                // Persiapkan data untuk disimpan dalam tabel income
                $income_data = array(
                    'date_payment' => date('Y-m-d'), // Tanggal pembayaran
                    'remark' => 'Pembayaran atas nama ' . $name . ' dengan nomor langganan ' . $no_services, // Keterangan
                    'nominal' => $total, // Total yang dibayarkan
                );
    
                // Simpan data pembayaran ke tabel income
                $this->income_m->addPayment($income_data);
    
              // Menyimpan status pembayaran
// Menyimpan status pembayaran
$invoice = $this->input->post('invoice'); // Mengambil nomor invoice dari input POST

// Pastikan $invoice tidak kosong
if (empty($invoice)) {
    echo json_encode(['status' => 'error', 'message' => 'Invoice number is required.']);
    return;
}
$invoice_status = array(
    'status' => 'SUDAH BAYAR',
    'transaction_date' => date('Y-m-d H:i:s')
);

// Memperbarui tanggal pembayaran pada tabel invoice
$this->db->set('date_payment', date('Y-m-d H:i:s'));
$this->db->where('invoice', $invoice); // Pastikan $invoice berisi nomor invoice yang ingin diperbarui
$query = $this->db->get_compiled_update('invoice');
log_message('debug', 'Query Update: ' . $query);

// Mengeksekusi query update
if ($this->db->affected_rows() > 0) {
    echo json_encode(['status' => 'success', 'message' => 'Transaksi berhasil disimpan dan status berhasil diperbarui']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui status atau tidak ada perubahan']);
}
            }
        }
    }
}    