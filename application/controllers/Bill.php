<?php defined('BASEPATH') or exit('No direct script access allowed');

class Bill extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['customer_m', 'package_m', 'services_m', 'bill_m', 'income_m']);
    }

    public function index()
    {
        $data['title'] = 'Tagihan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['bill'] = $this->bill_m->getInvoice()->result();
        $data['detail'] = $this->bill_m->getInvoiceDetail()->result();
        $data['invoice'] = $this->bill_m->invoice_no();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/bill/bill', $data);
    }

    public function view_data()
    {
        if (isset($_POST['cek_data'])) {
            $data['services'] =  $this->services_m->getServicesDetail($this->input->post('no_services'));
            $this->load->view('backend/bill/detail_bill', $data);
        } else {
            echo "cek";
        }
    }
    
    public function addAllBills()
    {
        $data = $this->input->post('data');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $date_payment = $this->input->post('date_payment');
        
        // Ambil semua pelanggan dengan status_p aktif
        $this->db->where('status_p', 'aktif');
        $customers = $this->db->get('customer')->result();
        
        foreach ($customers as $customer) {
            // Cek apakah sudah ada tagihan untuk bulan dan tahun ini
            $existing_invoice = $this->db->get_where('invoice', [
                'no_services' => $customer->no_services,
                'month' => $month,
                'year' => $year,
                'date_payment' => date(),
            ])->row();
        
            if (!$existing_invoice) {
                // Ambil rincian layanan pelanggan
                $services = $this->services_m->getServicesDetail($customer->no_services)->result();
                
                // Hitung total tagihan
                $total_tagihan = 0;
                foreach ($services as $service) {
                    $total_tagihan += $service->total;
                }
                
                // Jika total tagihan lebih dari 0, buat tagihan baru
                if ($total_tagihan > 0) {
                    $invoice_id = $customer->no_services . $month . $year; // Generate unique invoice code
        
                    $invoice_data = [
                        'invoice' => $invoice_id,
                        'no_services' => $customer->no_services,
                        'month' => $month,
                        'year' => $year,
                        'status' => 'BELUM BAYAR',
                        'created' => time(), // Current timestamp
                        'date_payment' => date('Y-m-d'),
                    ];
        
                    $this->db->insert('invoice', $invoice_data);
                    $invoice = $this->db->insert_id(); // Get the newly inserted invoice ID
        
                    // Tambahkan rincian tagihan jika diperlukan
                    $detail_data = []; // Prepare an array to store details
                    foreach ($services as $service) {
                        $detail_data[] = [
                            'invoice_id' => $invoice_id, // Use the same code for details
                            'price' => $service->price,
                            'qty' => $service->qty,
                            'disc' => $service->disc,
                            'remark' => $service->remark,
                            'total' => $service->total,
                            'item_id' => $service->item_id,
                            'category_id' => $service->category_id
                        ];
                    }
        
                    if (!empty($detail_data)) {
                        $this->db->insert_batch('invoice_detail', $detail_data);
                    }
                }
            }
        }
        
        $this->session->set_flashdata('message', 'Tagihan berhasil ditambahkan ke semua pelanggan dengan status aktif.');
        redirect('bill');
        
    }
    



    public function addBill()
    {
        $data = $this->input->post(null, TRUE);
        $no_services = $this->input->post('no_services');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $cekperiode = $this->bill_m->cekPeriode($no_services, $month, $year);

        if ($cekperiode->num_rows() > 0) {
            $this->session->set_flashdata('error', 'Gagal, Tagihan untuk periode tersebut sudah tersedia, mohon dicek kembali !');
            echo "<script>window.location='" . site_url('bill') . "'; </script>";
        } else {
            $this->bill_m->addBill($data);
            $invoice = $this->input->post('invoice');
            $Detail = $this->services_m->getServicesDetail($this->input->post('no_services'))->result();
            $data2 = [];
            foreach ($Detail as $c => $row) {
                array_push(
                    $data2,
                    array(
                        'invoice_id' => $invoice,
                        'item_id' => $row->item_id,
                        'category_id' => $row->category_id,
                        'price' => $row->price,
                        'qty' => $row->qty,
                        'disc' => $row->disc,
                        'remark' => $row->remark,
                        'total' => $row->total,
                        'date_payment' =>  date('Y-m-d H:i:s')
                    )
                );
            }
            $this->bill_m->add_bill_detail($data2);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Tagihan berhasil dibuat');
            }
            redirect('bill');
        }
    }

    public function detail($invoice_id = null)
    {
        $data['title'] = 'Tagihan';
        $data['invoice'] = $this->bill_m->getEditInvoice($invoice_id);
        $data['p_item'] = $this->package_m->getPItem()->result();
        $data['bill'] = $this->bill_m->getBill($invoice_id)->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->template->load('backend', 'backend/bill/invoice_detail', $data);
    }

    public function delete()
    {
        $invoice = $this->input->post('invoice');
        $this->bill_m->delete($invoice);
        $this->bill_m->deleteDetailBill($invoice);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data Tagihan berhasil dihapus');
        }
        redirect('bill');
    }

    public function payment()
    {
        $post = $this->input->post(null, TRUE);
        $invoice = $this->input->post('invoice');
        $this->bill_m->payment($post);
        $this->income_m->addPayment($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Iuran berhasil terbayarkan');
        }
        echo "<script>window.location='" . site_url('bill/detail/' . $invoice) . "'; </script>";
    }

    public function finish()
    {
        // Ambil data dari hasil pembayaran
        $result = json_decode($this->input->post('result_data'), true);

        // Ambil informasi lain yang diperlukan
        $date_payment = $this->input->post('date_payment');

        // Simpan detail pembayaran dan statusnya di database
        $data = [
            'no_services' => $result['order_id'], // atau invoice_code yang Anda inginkan
            'status' => $result['transaction_status'], // status transaksi
            'date_payment' => $date_payment, // Simpan bulan tagihan
            'created' => time(),
            // Simpan informasi lain yang diperlukan
        ];

        $this->db->insert('invoice', $data); // Simpan ke tabel pembayaran

        // Redirect atau tampilkan hasil
        $this->session->set_flashdata('message', 'Pembayaran berhasil.');
        redirect('front'); // Redirect ke halaman yang diinginkan
    }
}
