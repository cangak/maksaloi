<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment_m extends CI_Model {

    // Function to save the main transaction to the database
    public function insert_transaction($data) {
        if ($this->db->insert('transactions', $data)) {
            return $this->db->insert_id(); // Return the ID of the newly saved transaction
        }
        return false; // Return false if insertion fails
    }

    // Function to save bill details to the database
    public function insert_bill_detail($data) {
        if ($this->db->insert('transaction_details', $data)) {
            return $this->db->insert_id(); // Return the ID of the inserted data
        }
        return false; // Return false if insertion fails
    }

    // Function to update invoice status
    public function update_invoice_status($invoice_id) {
        // Update the invoice status based on the invoice ID
        $this->db->set('status', 'SUDAH BAYAR');
        $this->db->where('invoice', $invoice_id); // Ensure the update is based on the specific invoice
        if ($this->db->update('invoice')) {
            return true; // Return true if the update was successful
        }
        return false; // Return false if the update fails
    }

    // Optionally, you can add a method to fetch transaction details or statuses if needed
    public function get_transaction_details($transaction_id) {
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('id', $transaction_id);
        return $this->db->get()->row_array(); // Return the transaction details
    }
}
