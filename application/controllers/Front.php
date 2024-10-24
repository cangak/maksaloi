<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Fixing typo in the header
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

/**
 * Index Page for this controller.
 * Maps to the following URL
 *      http://example.com/index.php/welcome
 *  - or -  
 *      http://example.com/index.php/welcome/index
 *  - or -
 * Since this controller is set as the default controller in 
 * config/routes.php, it's displayed at http://example.com/
 * So any other public methods not prefixed with an underscore will
 * map to /index.php/welcome/<method_name>
 * @see http://codeigniter.com/user_guide/general/urls.html
 */

class Front extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $params = [
            'server_key' => 'SB-Mid-server-LDjew5yDSGPXcY_25a7kgqJX', 
            'production' => false
        ];
        $this->load->library('midtrans');
        $this->midtrans->config($params);
        $this->load->helper('url');    
        $this->load->model(['services_m', 'customer_m']);
    }

    public function index()
    {
        $data['title'] = 'Home';
        $data['company'] = $this->db->get('company')->row_array();
        $data['status'] = $this->db->get('transaksi_midtrans')->result();
        $this->template->load('frontend', 'frontend/welcome_message', $data);
    }
    
    public function view_bill()
    {
        $no_services = $this->input->post('no_services');
        
        // Fetching the status for bills
        $data['status'] = $this->db->get('transaksi_midtrans')->result(); 

        if ($this->input->post('cek_bill')) {
            $data['bill'] = $this->services_m->getCekBill($no_services);
            $data['customer'] = $this->customer_m->getNSCustomer($no_services);
            $this->load->view('frontend/cek_bill', $data);
        } else {
            echo "Not Found";
        }
    }

    public function status()
    {
        $data['midtrans'] = $this->db->get('transaksi_midtrans')->result();
        $this->load->view('frontend/cekbill', $data);
    }

    
    public function finish()
    {
        $result = json_decode($this->input->post('result_data'), true);
        $data = [
            'order_id' => $result['order_id'],
            'gross_amount' => $result['gross_amount'],
            'payment_type' => $result['payment_type'],
            'transaction_time' => $result['transaction_time'],
            'bank' => $result['va_numbers'][0]["bank"],
            'va_number' => $result['va_numbers'][0]["va_number"],
            'pdf_url' => $result['pdf_url'],
            'status_code' => $result['status_code'],
        ];

        $this->db->insert('transaksi_midtrans', $data);
        
        // Fixed redirection, previously it didn't redirect correctly
        redirect('frontend');
    }
}
