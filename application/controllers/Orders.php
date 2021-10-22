<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Orders extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Orders';

		$this->load->model('model_orders');
		$this->load->model('model_products');
		$this->load->model('model_company');
		//$this->load->model('model_tables');
		$this->load->model('model_category');
		$this->load->helper('date');
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		$today_date = date('Y-m-d');		
		$this->data['selected_day'] = $today_date;

		$this->data['page_title'] = 'Manage Orders';
		$this->render_template('orders/index', $this->data);		
	}

	/*
	* Fetches the orders data from the orders table 
	* this function is called from the datatable ajax function
	*/
	

	public function fetchOrdersData()
	{
		$result = array('data' => array());

		$submited_date = $this->uri->segment(3);

		
		$data = $this->model_orders->getOrderDatabyDate($submited_date);

	
		foreach ($data as $key => $value) {

			$count_total_item = $this->model_orders->countOrderItem($value['o_id']);
			$date = date('d-m-Y', $value['date_sold']);
			$time = date('h:i a', $value['time_sold']);

			$date_time = $date . ' ' . $time;

			// button
			$buttons = '';

			// if(in_array('viewOrder', $this->permission)) {
			// 	$buttons .= '<a target="__blank" href="'.base_url('orders/printDiv/'.$value['id']).'" class="btn btn-default"><i class="fa fa-print"></i></a>';
			// }

			
				$buttons .= ' <a href="'.base_url('orders/update/'.$value['o_id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			

			
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['o_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			

			if($value['paid_status'] == 1) {
				$paid_status = '<span class="label label-success">Paid</span>';	
			}
			else {
				$paid_status = '<span class="label label-warning">Not Paid</span>';
			}

			$result['data'][$key] = array(
				$value['bill_no'],
				$count_total_item,
				"GH¢".$value['net_amount'],
				$paid_status,
				$date_time,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* If the validation is not valid, then it redirects to the create page.
	* If the validation for each input field is valid then it inserts the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/



	public function create()
	{
		
		
		if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		
		$this->data['page_title'] = 'Add Order';

		
		$this->form_validation->set_rules('product[]', 'Product Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {

		
        	$order_id = $this->model_orders->create();

			
        	if($order_id) {
        		$this->session->set_flashdata('success', 'Order Successfully created');
        		//redirect('orders/update/'.$order_id, 'refresh');
				redirect('orders/index', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/create/', 'refresh');
        	}
		
		}

		else {
            // false case
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
			$this->data['categories'] = $this->model_category->getActiveCategory();
        	$this->data['products'] = $this->model_products->getActiveProductData();      	

            $this->render_template('orders/create', $this->data);
        }	
        	

        	
	}

	/*
	* It gets the product id passed from the ajax method.
	* It checks retrieves the particular product data from the product id 
	* and return the data into the json format.
	*/
	public function getProductValueById()
	{
		$product_id = $this->input->post('product_id');
		
		if($product_id) {
			$product_data = $this->model_products->getProductData($product_id);
			echo json_encode($product_data);
		}
	}


	public function getProductById()
	{
		$product_id = $this->input->post('product_id');
		$row_id = $this->input->post('row_id');
		if($product_id) {
			$product_data = $this->model_products->getProductData($product_id);
			//var_dump($product_data['name']);

			// $html='';
			// $html.='
			// <tr id="row_'.$row_id.'">
			// <td>'.$product_data['name'].'<input type="hidden" name="product[]" id="product_'.$row_id.'" value='.$product_data['name'].' disabled autocomplete="off"></td>
			// <td><input type="number" class="form-control" min="1" id="qty_'.$row_id.'" name="qty[]" value="1" onchange="getTotal('.$row_id.')"></td>
			// <td><input type="text" name="amount[]" id="amount_'.$row_id.'" value='.$product_data['price'].' disabled autocomplete="off">
			// <input type="hidden" name="amount_value[]" id="amount_value'.$row_id.'" value='.$product_data['price'].' disabled autocomplete="off">
			// </td>
			// <td><button type="button" class="btn btn-default" onclick="removeRow('.$row_id.')"><i class="fa fa-close"></i></button></td>
			// </tr>
			// ';

			echo json_encode($product_data);
		}
	}

	function getCategoryProduct(){
		$category_id = $this->input->post('category_id');
		
		if($category_id) {
			$product_data = $this->model_products->getProductDatabyCategory($category_id);
			if(!empty($product_data)){
				foreach($product_data as $product){
					$name=$product['name'];
					$price=$product['price'];
					$id=$product['p_id'];
					$data ='
					<a href="#" class="item add-cart" id= "'.$id.'">'.$name.'</a>';

				// $data ='
				// 	<div class="col-sm-4">
				// 	<div class="card">
				// 	<div class="card-body">
				// 		<h5 class="card-title">'.$name.'</h5>
				// 		<p class="card-text">Ghc '.$price.'</p>
				// 		<button type="submit" class="add-cart btn btn-primary"  id= "'.$id.'"><i class="fa fa-cart-plus"></i></button>
				// 	</div>
				// 	</div>
				// </div>';
	
			echo ($data);
	
				}
			}
			else{
				echo '<div class="col-sm-12" style="color:red;">No result found</div>';
			}
			
			
			
			
		}
	}

	function getCategoryProductBySearch(){
		// $category_id = $this->input->post('category_id');

		$product_name = $this->input->post('value');
		
		if($product_name) {
			$product_data = $this->model_products->getProductDatabyCategoryandSearch($product_name);
			if(!empty($product_data)){
				foreach($product_data as $product){
					$name=$product['name'];
					$price=$product['price'];
					$id=$product['p_id'];
					$data ='
					<a href="#" class="item add-cart" id= "'.$id.'">'.$name.'</a>';

				// $data ='
				// 	<div class="col-sm-4">
				// 	<div class="card">
				// 	<div class="card-body">
				// 		<h5 class="card-title">'.$name.'</h5>
				// 		<p class="card-text">Ghc '.$price.'</p>
				// 		<button type="submit" class="add-cart btn btn-primary"  id= "'.$id.'"><i class="fa fa-cart-plus"></i></button>
				// 	</div>
				// 	</div>
				// </div>';
	
			echo ($data);
	
				}
			}
			else{
				echo '<div class="col-sm-12" style="color:red;">No result found</div>';
			}
			
			
			
			
		}
	}


	function getAllProducts(){
		// $category_id = $this->input->post('category_id');
			$product_data = $this->model_products->getProductDataOrder();
			if(!empty($product_data)){
				foreach($product_data as $product){
					$name=$product['name'];
					$price=$product['price'];
					$id=$product['p_id'];
					$data ='
					<a href="#" class="item add-cart" id= "'.$id.'">'.$name.'</a>';

	
			echo ($data);
	
				}
			}
			else{
				echo '<div class="col-sm-12" style="color:red;">No result found</div>';
			}
	
	}

	public function checkqty()
	{
		$qty = $this->input->post('current_qty');
		
		// if($product_id) {
		// 	$product_data = $this->model_products->getProductData($product_id);
		// 	echo json_encode($product_data);
		// }
	}

	/*
	* It gets the all the active product inforamtion from the product table 
	* This function is used in the order page, for the product selection in the table
	* The response is return on the json format.
	*/
	public function getTableProductRow()
	{
		$products = $this->model_products->getActiveProductData();
		echo json_encode($products);
	}

	/*
	* If the validation is not valid, then it redirects to the edit orders page 
	* If the validation is successfully then it updates the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function update($id)
	{
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Order';

		$this->form_validation->set_rules('product[]', 'Product name', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$update = $this->model_orders->update($id);
        	
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        		redirect('orders/update/'.$id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('orders/update/'.$id, 'refresh');
        	}
        }
        else {
            // false case
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['company_data'] = $company;
        	$this->data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;

        	$result = array();

			
			$orders_data = $this->model_orders->getOrdersData($id);
			
			
			

			$result['order'] = $orders_data;
			
    		$orders_item = $this->model_orders->getOrdersItemData($orders_data['o_id']);

			

    		foreach($orders_item as $k => $v) {
    			$result['order_item'][] = $v;
    		}

    		$this->data['order_data'] = $result;
			// echo "<pre>";
			// var_dump($result);
			
			// echo "</pre>";
			// exit();
        	//$this->data['products'] = $this->model_products->getActiveProductData();      	

            $this->render_template('orders/edit', $this->data);
        }
	}

	/*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	public function remove()
	{
		if(!in_array('deleteOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$order_id = $this->input->post('order_id');

        $response = array();
        if($order_id) {
            $delete = $this->model_orders->remove($order_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response); 
	}

	/*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
	public function printDiv_old($id)
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Print Order Details';
        
		if($id) {
			$order_data = $this->model_orders->getOrdersData($id);
			$orders_items = $this->model_orders->getOrdersItemData($id);
			$company_info = $this->model_company->getCompanyData(1);
			// $order_date = $date;
			$paid_status = ($order_data['paid_status'] == 1) ? "Paid" : "Unpaid";

			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>AdminLTE 2 | Invoice</title>
			  <!-- Tell the browser to be responsive to screen width -->
			  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			  <!-- Bootstrap 3.3.7 -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
			  <!-- Font Awesome -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
			  <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
			</head>
			<body onload="window.print();">
			
			<div class="wrapper">
			  <section class="invoice">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
			        <h2 class="page-header">
			          '.$company_info['company_name'].'
			        </h2>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- info row -->
			    <div class="row invoice-info">
			      
			      <div class="col-sm-4 invoice-col">
			        
			        <b>Bill ID:</b> '.$order_data['bill_no'].'<br>
			        <b>Name:</b> '.$order_data['customer_name'].'<br>
			        <b>Phone:</b> '.$order_data['customer_phone'].'
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Product name</th>
			            <th>Price</th>
			            <th>Qty</th>
			            <th>Amount</th>
			          </tr>
			          </thead>
			          <tbody>'; 

			          foreach ($orders_items as $k => $v) {

			          	$product_data = $this->model_products->getProductData($v['product_id']); 
			          	
			          	$html .= '<tr>
				            <td>'.$product_data['name'].'</td>
				            <td>'.$v['rate'].'</td>
				            <td>'.$v['order_qty'].'</td>
				            <td>'.$v['amount'].'</td>
			          	</tr>';
			          }
			          
			          $html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <div class="row">
			      
			      <div class="col-xs-6 pull pull-right">

			        <div class="table-responsive">
			          <table class="table">
			            <tr>
			              <th style="width:50%">Gross Amount:</th>
			              <td>'.$order_data['gross_amount'].'</td>
			            </tr>';

			            if($order_data['vat_charge'] > 0) {
			            	$html .= '<tr>
				              <th>Vat Charge ('.$order_data['vat_charge_rate'].'%)</th>
				              <td>'.$order_data['vat_charge'].'</td>
				            </tr>';
			            }
			            
			            
			            $html .=' <tr>
			              <th>Discount:</th>
			              <td>'.$order_data['discount'].'</td>
			            </tr>
			            <tr>
			              <th>Net Amount:</th>
			              <td>'.$order_data['net_amount'].'</td>
			            </tr>
			            <tr>
			              <th>Paid Status:</th>
			              <td>'.$paid_status.'</td>
			            </tr>
			          </table>
			        </div>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
		</body>
	</html>';

			  echo $html;
		}
	}

	public function printDiv($id)
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Print Order Details';
        
		if($id) {
			date_default_timezone_set('Africa/Accra');
			$userdata= $this->model_orders->getUserID($id);
		
			$order_data = $this->model_orders->getOrdersData($id);
			$orders_items = $this->model_orders->getOrdersItemData($id);
			$company_info = $this->model_company->getCompanyData(1);
			// $order_date = $date;
			$paid_status = ($order_data['paid_status'] == 1) ? "Paid" : "Unpaid";

			try {
				// Enter the share name for your USB printer here
				$connector = null;
				$connector = new WindowsPrintConnector("EPSON TM-T20II Receipt");
			
				/* Print a "Hello world" receipt" */
				
				// $printer -> text("Hello World!\n");
				// $printer->text($html);
				// $printer -> cut();
		
				/* Start the printer */
		// $logo = EscposImage::load("resources/escpos-php.png", false);
		$printer = new Printer($connector);
		
		/* Print top logo */
		$printer -> setJustification(Printer::JUSTIFY_CENTER);
		// $printer -> graphics($logo);
		
		/* Name of shop */
		$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
		$printer -> text("DE-VAULT GARDENS.\n");
		$printer -> selectPrintMode();
		$printer -> text("ADJ COMM.5 PRESBY CHURCH-TEMA.\n");
		$printer -> text("055 707 9977"." ". "- Momo     \n");
		$printer -> text("050 256 6161"." ". "- Vodacash \n");
		// $printer -> text("050 256 6161 - Vodacash.\n");
		$printer -> text("020 882 7451"." ". "           \n");
		$printer -> text("--------------------------------------.\n");

		$printer -> feed();
		
		/* Title of receipt */
		$printer -> setEmphasis(true);
		// $printer -> text("Ticket\n");
		$printer -> text("-----------------------------------------");
		$printer -> text("\n");
		$printer -> text("Date:".date("d/m/Y", $order_data['date_sold'])."\n");
		$printer -> text("Time:".date("h:i:s:a", $order_data['time_sold'])."\n");
		$printer -> text("Ticket No:".$order_data['bill_no']."\n");
		$printer -> text($order_data['order_type']."\n");
		/*$printer -> text($order_data['order_table']."\n");*/
		/*$printer -> text("Staff:".$userdata[0]['firstname']." ".$userdata[0]['lastname']."\n");*/
		$printer -> text("------------------------------------------"."\n");
		$printer -> setEmphasis(false);
		
		/* Items */
		$printer -> setJustification(Printer::JUSTIFY_LEFT);
		$printer -> setEmphasis(true);
		// $printer -> text(new item('', '$'));
		$printer -> setEmphasis(false);
		foreach ($orders_items as $k => $v) {
			$product_data = $this->model_products->getProductData($v['product_id']);

			$texttoprint= sprintf('%-30.30s%8.2f', "-".$v['order_qty']." ".$product_data['name'], $v['amount']."\n");
	
			$printer -> text($texttoprint);
			$printer -> text("\n");
			
		}
		$printer -> setEmphasis(true);
		$printer -> text("\n");
		$printer -> text("--------------------------------------.\n");
		$total= sprintf('%-30.30s%8.2f', "Total" . "", $order_data['net_amount']."\n");
		$printer -> text($total);
		$printer -> setEmphasis(false);
		$printer -> feed();
		
		/* Tax and total */
		// $printer -> text($tax);
		$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
		// $printer -> text($v['amount']);
		$printer -> selectPrintMode();
		
		/* Footer */
		$printer -> feed(2);
		$printer -> setJustification(Printer::JUSTIFY_CENTER);
		$printer -> text("TAX INCLUSIVE\n");
		$printer -> text("Thank you very much\n");
		$printer -> feed(2);
		
		
		/* Cut the receipt and open the cash drawer */
		$printer -> cut();
		$printer -> pulse();

				/* Close printer */
				$printer -> close();
				redirect('orders/update/'.$id, 'refresh');

			} catch (Exception $e) {
				echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
			}

			  //echo $html;
		}
	}
	

}

