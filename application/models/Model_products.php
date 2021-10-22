<?php 

require_once ('vendor/autoload.php');

class Model_products extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getProductData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM products where p_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM products ORDER BY p_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getProductDataOrder(){
		$sql = "SELECT * FROM products INNER JOIN categories ON products.category_id=categories.id where categories.id=4";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getProductDatabyCategory($category_id){
		$sql = "SELECT * FROM products WHERE category_id =?";
		$query = $this->db->query($sql, array($category_id));
		return $query->result_array();
	}

	function getProductDatabyCategoryandSearch($product_name){
		$sql = "SELECT * FROM products WHERE name LIKE '%$product_name%' ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getActiveProductDataforSupplies($id)
	{
		if($id) {
			$sql = "SELECT * FROM products 
			INNER JOIN received_supplies_items ON received_supplies_items.product_id= products.p_id
			where received_supplies_items.id_receiving = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

	}

	


	public function getActiveProductData()
	{
		$sql = "SELECT * FROM products WHERE availability = ? AND qty > ?  ORDER BY p_id DESC";
		$query = $this->db->query($sql, array(1, 0));
		return $query->result_array();
	}

	public function getAllProductData()
	{
		$sql = "SELECT * FROM products ORDER BY p_id DESC";
		$query = $this->db->query($sql, array(1, 0));
		return $query->result_array();
	}

	public function checkDuplicate($data)
	{
		
	
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where($data);
		$query = $this->db->get();
		echo $query->num_rows();
	}


	

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('products', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('p_id', $id);
			$update = $this->db->update('products', $data);
			return ($update == true) ? true : false;
		}
	}

	public function update_qty($email_data, $insert_data, $update_data, $id){

		if($insert_data && $update_data && $id) {
			
			$insert = $this->db->insert('product_stock_logs', $insert_data);

			if($insert){
				$this->db->where('p_id', $id);
				$update = $this->db->update('products', $update_data);
				
				$transport = (new Swift_SmtpTransport('mail.adaptivebibo.com', 587 ))
  				->setUsername('test@adaptivebibo.com')
  				->setPassword('ckDbB2UDmXPD')
				;

				

			// Create the Mailer using your created Transport
			$mailer = new Swift_Mailer($transport);

			// Create a message
			$message = (new Swift_Message('Product Quantity Stock Update'))
			->setFrom(['test@adaptivebibo.com' => 'KCL'])
			->setTo(['youngquarshie@gmail.com', 'youngquarshie@gmail.com' => 'A name'])
			->setBody('
			<style>
			table, th, td {
				border: 1px solid black;
				border-collapse: collapse;
			  }
			</style>
			<table style="border: 1px solid black;">
			
				<thead>
					<tr>
						<th>Product </th>
						<th>Old Qty</th>
						<th> New Qty </th>
						<th> Av. Qty </th>
						<th> Reason </th>
						<th>Date </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>'.$email_data['product_name'].'</td>
						<td>'.$email_data['old_qty'].'</td>
						<td>'.$email_data['new_qty'].'</td>
						<td>'.$email_data['total'].'</td>
						<td>'.$email_data['notes'].'</td>
						<td>'.$email_data['date_created'].'</td>
					</tr>
				</tbody>
			</table>', 
			'text/html')
			;

			// Send the message
			$result = $mailer->send($message);

			

			return ($update == true) ? true : false;
			}
			
			
			
		}


			
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('p_id', $id);
			$delete = $this->db->delete('products');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalProducts()
	{
		$sql = "SELECT * FROM products";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}