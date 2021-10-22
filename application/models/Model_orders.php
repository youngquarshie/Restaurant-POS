<?php 

class Model_orders extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
	}

	public function getOrdersData($id = null)
	{
		$user_id = $this->session->userdata('id');
		if($id) {
			$sql = "SELECT * FROM orders 
			INNER JOIN orders_item ON orders.o_id=orders_item.order_id
			WHERE orders.o_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM orders 
		INNER JOIN orders_item ON orders.o_id=orders_item.order_id ORDER BY o_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get the orders data */


	public function getOrderDatabyDate($date)
	{	$user_id = $this->session->userdata('id');
		if($date) {
			$selected_date= strtotime($date);
			
			$sql = "SELECT * FROM orders 
			INNER JOIN users ON users.id = orders.user_id
			WHERE orders.paid_status = ? and orders.date_sold = ?
			ORDER BY orders.o_id DESC";
			$query = $this->db->query($sql, array(1, $selected_date));
			$result = $query->result_array();	


			return $result;
			
		}
	}

	// get the orders item data
	public function getOrdersItemData($order_id = null)
	{
		if(!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM orders_item 
		INNER JOIN products ON orders_item.product_id = products.p_id WHERE order_id = ?";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}

	public function create()
	{

	
		date_default_timezone_set('Africa/Accra');
		
		$user_id = $this->session->userdata('id');
		$bill_no = 'DE-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
    	$data = array(
    		'bill_no' => $bill_no,
    		// 'order_type' => $this->input->post('order_type'),
    		// 'order_table' => $this->input->post('order_table'),
    		'date_sold' => strtotime(date('Y-m-d')),
			'time_sold' => strtotime(date('h:i:s a')),
    		// 'gross_amount' => $this->input->post('gross_amount_value'),
    		// 'vat_charge_rate' => $this->input->post('vat_charge_rate'),
    		// 'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
    		'net_amount' => $this->input->post('net_amount_value'),
    		// 'discount' => $this->input->post('discount'),
    		'paid_status' => 1,
    		'user_id' => $user_id
		);
		

		$insert = $this->db->insert('orders', $data); 
		$order_id = $this->db->insert_id();


		$this->load->model('model_products');

		


		$count_product = count($this->input->post('product'));

		// var_dump($count_product);
		// exit()
		
		
    	for($x = 0; $x < $count_product; $x++) {
    		$items = array(
    			'order_id' => $order_id,
    			'product_id' => $this->input->post('product')[$x],
    			'order_qty' => $this->input->post('qty')[$x],
    			'rate' => $this->input->post('amount_value')[$x],
    			'amount' => $this->input->post('amount')[$x],
			);

			// $items = array(
    		// 	'order_id' => $order_id,
    		// 	'product_id' => $this->input->post('product')[$x],
    		// 	'order_qty' => $this->input->post('qty')[$x],
    		// 	'rate' => $this->input->post('value')[$x],
    		// 	'amount' => $this->input->post('amount_value')[$x],
			// );
			

    		$this->db->insert('orders_item', $items);

    		//now decrease the stock from the product
    		$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
    		$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

    		$update_product = array('qty' => $qty);


    		$this->model_products->update($update_product, $this->input->post('product')[$x]);
    	}

		

		return ($order_id) ? $order_id : false;
	}

	public function countOrderItem($order_id)
	{
		if($order_id) {
			$sql = "SELECT * FROM orders_item WHERE order_id = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}
	
	function getUserID($order_id){

		if($order_id) {
			$sql = "SELECT * FROM users INNER JOIN orders ON users.id = orders.user_id WHERE orders.o_id = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->result_array();
		}
	}

	public function update($id)
	{
		if($id) {
			$user_id = $this->session->userdata('id');
			// fetch the order data 

			$data = array(
				'order_table' => $this->input->post('order_table'),
	    		'order_type' => $this->input->post('order_type'),
	    		'gross_amount' => $this->input->post('gross_amount_value'),
	    		'vat_charge_rate' => $this->input->post('vat_charge_rate'),
	    		'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
	    		'net_amount' => $this->input->post('net_amount_value'),
	    		'discount' => $this->input->post('discount'),
	    		'paid_status' => $this->input->post('paid_status'),
	    		'user_id' => $user_id
	    	);

			$this->db->where('o_id', $id);
			$update = $this->db->update('orders', $data);

			// now the order item 
			// first we will replace the product qty to original and subtract the qty again
			$this->load->model('model_products');
			$get_order_item = $this->getOrdersItemData($id);
			foreach ($get_order_item as $k => $v) {
				$product_id = $v['product_id'];
				$qty = $v['order_qty'];
				// get the product 
				$product_data = $this->model_products->getProductData($product_id);
				$update_qty = $qty + $product_data['qty'];
				$update_product_data = array('qty' => $update_qty);
				
				// update the product qty
				$this->model_products->update($update_product_data, $product_id);
			}

			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('orders_item');

			// now decrease the product qty
			$count_product = count($this->input->post('product'));
	    	for($x = 0; $x < $count_product; $x++) {
	    		$items = array(
	    			'order_id' => $id,
	    			'product_id' => $this->input->post('product')[$x],
	    			'order_qty' => $this->input->post('qty')[$x],
	    			'rate' => $this->input->post('rate_value')[$x],
	    			'amount' => $this->input->post('amount_value')[$x],
	    		);
	    		$this->db->insert('orders_item', $items);

	    		// now decrease the stock from the product
	    		$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
	    		$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

	    		$update_product = array('qty' => $qty);
	    		$this->model_products->update($update_product, $this->input->post('product')[$x]);
	    	}

			return true;
		}
	}



	public function remove($id)
	{
		if($id) {
			$this->db->where('o_id', $id);
			$delete = $this->db->delete('orders');

			$this->db->where('order_id', $id);
			$delete_item = $this->db->delete('orders_item');
			return ($delete == true && $delete_item) ? true : false;
		}
	}

	public function countTotalPaidOrders()
	{
		$sql = "SELECT * FROM orders_item";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}

}