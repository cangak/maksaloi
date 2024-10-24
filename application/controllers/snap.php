<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Controll-Allow-Origin: *');
header("Access-Controll-Allow-Methods: GET. OPTIONS");
class Snap extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-LDjew5yDSGPXcY_25a7kgqJX', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');	
    }

    public function index()
    {
    	$this->load->view('checkout_snap');
    }
public function paybill()
{
	$this->load->view('cek_bill');
}
	

public function token()
{
    // Mengambil data dari input POST
    $id_pelanggan = $this->input->post('id_pelanggan');
    $nama_pelanggan = $this->input->post('nama_pelanggan');
    $bulan_tagihan = $this->input->post('bulan_tagihan');
    $jumlah_tagihan = $this->input->post('jumlah_tagihan');
    $invoice_code = $this->input->post('invoice_code'); // Mengambil invoice_code dari input POST

    // Required
    $transaction_details = array(
        'order_id' => rand(), // Menggunakan invoice_code sebagai order_id
        'gross_amount' => (int)$jumlah_tagihan, // gunakan jumlah tagihan dari input
    );

    // Item details
    $item_details = array(
        array(
            'id' => 'item1',
            'price' => (int)$jumlah_tagihan, // total tagihan
            'month' => (int)$bulan_tagihan, // total tagihan
            'quantity' => 1,
            'name' => "Langganan Internet $bulan_tagihan"
        )
    );

    // Optional: Menggunakan data pelanggan yang diambil
    $billing_address = array(
        'first_name' => $nama_pelanggan,
        'last_name' => $bulan_tagihan, // bisa diisi jika ada
        'address' => "", // ganti dengan data yang relevan
        'city' => "ID Pelanggan $id_pelanggan", // ganti dengan data yang relevan
        'postal_code' => "", // ganti dengan data yang relevan
        'phone' => "", // ganti dengan data yang relevan
        'country_code' => ''
    );

    // Customer details
    $customer_details = array(
        'first_name' => $nama_pelanggan,
        'last_name' => "", // bisa diisi jika ada
        'email' => "email@example.com", // ganti dengan data yang relevan
        'phone' => "Nomor Telepon", // ganti dengan data yang relevan
        'billing_address' => $billing_address,
    );

    $time = time();
    $custom_expiry = array(
        'start_time' => date("Y-m-d H:i:s O", $time),
        'unit' => 'minute', 
        'duration'  => 60
    );

    // Data untuk permintaan
    $transaction_data = array(
        'transaction_details' => $transaction_details,
        'item_details' => $item_details,
        'customer_details' => $customer_details,
        'credit_card' => array('secure' => true),
        'expiry' => $custom_expiry
    );

    error_log(json_encode($transaction_data));
    $snapToken = $this->midtrans->getSnapToken($transaction_data);
    error_log($snapToken);
    error_log('ID Pelanggan: ' . $id_pelanggan);
    error_log('Nama Pelanggan: ' . $nama_pelanggan);
    error_log('Bulan Tagihan: ' . $bulan_tagihan);
    error_log('Jumlah Tagihan: ' . $jumlah_tagihan);

    echo $snapToken;
}


  
}
