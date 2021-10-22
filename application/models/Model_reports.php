<?php 

class Model_reports extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*getting the total months*/
	private function months()
	{
		return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
	}

	/* getting the year of the orders */
	public function getOrderYear()
	{
		$sql = "SELECT * FROM orders WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();
		
		$return_data = array();
		foreach ($result as $k => $v) {
			$date = date('Y', $v['date_sold']);
			$return_data[] = $date;
		}

		$return_data = array_unique($return_data);

		return $return_data;
	}

	// getting the order reports based on the year and moths
	public function getOrderData($year)
	{	
		if($year) {
			$months = $this->months();
			
			$sql = "SELECT * FROM orders WHERE paid_status = ?";
			$query = $this->db->query($sql, array(1));
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year.'-'.$month_y;	

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					$month_year = date('Y-m', $v['date_sold']);

					if($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}	


			return $final_data;
			
		}
	}

	public function getOrderDatabyDate($date)
	{	
		if($date) {
			$selected_date= strtotime($date);
			
			$sql = "SELECT products.name, date_sold, time_sold, SUM(orders_item.amount) as total_price, COUNT(*) as total_qty FROM orders_item INNER JOIN orders ON orders.o_id=orders_item.order_id 
			INNER JOIN products ON orders_item.product_id = products.p_id 
			WHERE orders.paid_status = ? and orders.date_sold = ? GROUP BY products.name ORDER BY products.name";
			// $sql = "SELECT * FROM orders INNER JOIN orders_item ON orders.o_id=orders_item.order_id 
			// INNER JOIN products ON orders_item.product_id = products.p_id
			// WHERE orders.paid_status = ? and orders.date_sold = ?";
			$query = $this->db->query($sql, array(1, $selected_date));
			$result = $query->result_array();	


			return $result;
			
		}
	}

	public function getOrderDatabyCategory($category)
	{	
		if($category) {
			
			$sql = "SELECT * FROM orders INNER JOIN orders_item ON orders.o_id=orders_item.order_id 
			INNER JOIN products ON orders_item.product_id = products.p_id
			INNER JOIN categories ON categories.id= products.category_id
			WHERE orders.paid_status = ? and products.category_id = ? ";
			$query = $this->db->query($sql, array(1, $category));
			$result = $query->result_array();	


			return $result;
			
		}
	}

	public function getOrderDatabyProduct($product_id)
	{	
		if($product_id) {
			
			$sql = "SELECT * FROM orders INNER JOIN orders_item ON orders.o_id=orders_item.order_id 
			INNER JOIN products ON orders_item.product_id = products.p_id
			WHERE orders.paid_status = ? and products.p_id = ? ";
			$query = $this->db->query($sql, array(1, $product_id));
			$result = $query->result_array();	


			return $result;
			
		}
	}

	public function getAllProducts()
	{	
	
			
			$sql = "SELECT * FROM products 
			INNER JOIN categories ON products.category_id =categories.id 
			ORDER BY products.name ASC";
			$query = $this->db->query($sql);
			$result = $query->result_array();	


			return $result;
			
	}

	public function getAllStockLogs()
	{	
	
			$sql = "SELECT * FROM product_stock_logs
			INNER JOIN products ON products.p_id = product_stock_logs.product_id
			INNER JOIN users ON product_stock_logs.user_id = users.id
			ORDER BY product_stock_logs.date_created DESC";
			$query = $this->db->query($sql);
			$result = $query->result_array();	

			return $result;
			
	}

	

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
}