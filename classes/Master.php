<?php
if(isset($_POST['price_product123'])){
$servername = "localhost";
$username = "root";
$password = "";
$db = "light_water_db";

// Create connection
$conn2 = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn2->connect_error) {
  die("Connection failed: " . $conn2->connect_error);
}

	$product_id1 = $_POST['id'];
	$new_price = $_POST['price_product123'];

	$sql2 = "UPDATE `stat` SET `price`='$new_price' WHERE product_id = '$product_id1'";
	$save2 = $conn2->query($sql2);
	if($save2){
		echo "Updated";
	}else{
		echo "error";
	}

}
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
		$check = $this->conn->query("SELECT * FROM `categories` where `category` = '{$category}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Category already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `categories` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `categories` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Category successfully saved.");
			else
				$this->settings->set_flashdata('success',"Category successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `categories` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Category successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_sub_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
		$check = $this->conn->query("SELECT * FROM `sub_categories` where `sub_category` = '{$sub_category}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Sub Category already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `sub_categories` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `sub_categories` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Sub Category successfully saved.");
			else
				$this->settings->set_flashdata('success',"Sub Category successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_sub_category(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `sub_categories` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Sub Category successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_product(){
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$v = addslashes($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
		$check = $this->conn->query("SELECT * FROM `products` where `title` = '{$title}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Book already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `products` set {$data} ";
			$save = $this->conn->query($sql);
			$id= $this->conn->insert_id;
		}else{
			$sql = "UPDATE `products` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$upload_path = "uploads/product_".$id;
			if(!is_dir(base_app.$upload_path))
				mkdir(base_app.$upload_path);
			if(isset($_FILES['img']) && count($_FILES['img']['tmp_name']) > 0){
				foreach($_FILES['img']['tmp_name'] as $k => $v){
					if(!empty($_FILES['img']['tmp_name'][$k])){
						move_uploaded_file($_FILES['img']['tmp_name'][$k],base_app.$upload_path.'/'.$_FILES['img']['name'][$k]);
					}
				}
			}
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Book successfully saved.");
			else
				$this->settings->set_flashdata('success',"Book successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_product(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `products` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Product successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_stat(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `stat` where `product_id` = '{$product_id}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "price already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `stat` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `stat` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New price successfully saved.");
			else
				$this->settings->set_flashdata('success',"price successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_stat(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `stat` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Invenory successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

	function register() {
		extract($_POST);
	
		// Check if passwords match
		if ($password !== $confirm_password) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Passwords do not match.';
			return json_encode($resp);
		}
	
		// Validate password requirements
		if (!preg_match('/^(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/', $password)) {
			$resp['status'] = 'failed';
			$resp['msg'] = 'Password must have at least one uppercase letter, one non-alphanumeric character, and be at least 8 characters long.';
			return json_encode($resp);
		}
	
		// Hash the password using password_hash
		// $hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$hashed_password = md5($password);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'confirm_password', 'password'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
	
		$check = $this->conn->query("SELECT * FROM `clients` where `email` = '{$email}' " . (!empty($id) ? " and id != {$id} " : ""))->num_rows;
	
		if ($this->capture_err())
			return $this->capture_err();
	
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Email already taken.";
			return json_encode($resp);
		}
	
		if (empty($id)) {
			include '../phpmailer/index.php';
			// $sql = "INSERT INTO `clients` set {$data}, `password`='{$hashed_password}' ";
			// $save = $this->conn->query($sql);
			// $id = $this->conn->insert_id;
		} else {
			// $sql = "UPDATE `clients` set {$data}, `password`='{$hashed_password}' where id = '{$id}' ";
			// $save = $this->conn->query($sql);
		}
	
		if ($save) {
			$resp['status'] = 'success';
			
			if (empty($id))
				$this->settings->set_flashdata('success', "Account successfully created.");
			else
				$this->settings->set_flashdata('success', "Account successfully updated.");
	
			foreach ($_POST as $k => $v) {
				$this->settings->set_userdata($k, $v);
			}
	
			$this->settings->set_userdata('id', $id);
	
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
	
		return json_encode($resp);
	}
	function add_to_cart(){
		extract($_POST);
		$data = " client_id = '".$this->settings->userdata('id')."' ";
		$_POST['price'] = str_replace(",","",$_POST['price']); 
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `cart` where `stat_id` = '{$stat_id}' and client_id = ".$this->settings->userdata('id'))->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$sql = "UPDATE `cart` set quantity = quantity + {$quantity} where `stat_id` = '{$stat_id}' and client_id = ".$this->settings->userdata('id');
		}else{
			$sql = "INSERT INTO `cart` set {$data} ";
		}
		
		$save = $this->conn->query($sql);
		if($this->capture_err())
			return $this->capture_err();
			if($save){
				$resp['status'] = 'success';
				$resp['cart_count'] = $this->conn->query("SELECT SUM(quantity) as items from `cart` where client_id =".$this->settings->userdata('id'))->fetch_assoc()['items'];
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
			return json_encode($resp);
	}
	function update_cart_qty(){
		extract($_POST);
		
		$save = $this->conn->query("UPDATE `cart` set quantity = '{$quantity}' where id = '{$id}'");
		if($this->capture_err())
			return $this->capture_err();
		if($save){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
		
	}
	function empty_cart(){
		$delete = $this->conn->query("DELETE FROM `cart` where client_id = ".$this->settings->userdata('id'));
		if($this->capture_err())
			return $this->capture_err();
		if($delete){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_cart(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM `cart` where id = '{$id}'");
		if($this->capture_err())
			return $this->capture_err();
		if($delete){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_order(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM `orders` where id = '{$id}'");
		$delete2 = $this->conn->query("DELETE FROM `order_list` where order_id = '{$id}'");
		$delete3 = $this->conn->query("DELETE FROM `sales` where order_id = '{$id}'");
		if($this->capture_err())
			return $this->capture_err();
		if($delete){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Order successfully deleted");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function place_order(){
		extract($_POST);
		$client_id = $this->settings->userdata('id');

		if($count_cart >= 1 || $count_cart == ''){
			$data = " client_id = '{$client_id}' ";
			$data .= " ,payment_method = '{$payment_method}' ";
			$data .= " ,order_type = '{$order_type}' ";
			$data .= " ,amount = '{$amount}' ";
			$data .= " ,paid = '{$paid}' ";
			$data .= " ,delivery_address = '{$delivery_address}' ";
			$order_sql = "INSERT INTO `orders` set $data";
			$save_order = $this->conn->query($order_sql);
			if($save_order){
				$order_id_query = $save_olist = $this->conn->query("SELECT * FROM orders WHERE client_id = '{$client_id}' ORDER BY id DESC LIMIT 1");
				$order_id_query_row = $order_id_query->fetch_assoc();
				$order_id = $order_id_query_row['id'];

				$list_sql = "INSERT INTO `order_list` (order_id,product_id,quantity,price,total) VALUES ('$order_id', '$product_id', '$quantity', '$price', '$amount')";
				$save_olist = $this->conn->query($list_sql);
				if($save_olist){
					$save_sales = $this->conn->query("INSERT INTO `sales`(`order_id`,`total_amount`) VALUES ('$order_id','$amount')");
					if($this->capture_err())
						return $this->capture_err();
					$resp['status'] ='success';
				}else{
					$resp['status'] ='failed';
					$resp['err_sql'] =$save_olist;
				}
			}else{
				$resp['status'] ='failed';
				$resp['err_sql'] =$save_order;
			}
			return json_encode($resp);
			
		}else{
			$data = " client_id = '{$client_id}' ";
			$data .= " ,payment_method = '{$payment_method}' ";
			$data .= " ,order_type = '{$order_type}' ";
			$data .= " ,amount = '{$amount}' ";
			$data .= " ,paid = '{$paid}' ";
			$data .= " ,delivery_address = '{$delivery_address}' ";
			$order_sql = "INSERT INTO `orders` set $data";
			$save_order = $this->conn->query($order_sql);
			if($this->capture_err())
				return $this->capture_err();
			if($save_order){
				$order_id = $this->conn->insert_id;
				$data = '';
				$cart = $this->conn->query("SELECT cart.*, products.title, products.id as pid FROM `cart` INNER JOIN `products` ON cart.stat_id = products.id WHERE `client_id` ='{$client_id}' ");
				while($row= $cart->fetch_assoc()):
					if(!empty($data)) $data .= ", ";
					$total = $row['price'] * $row['quantity'];
					$data .= "('{$order_id}','{$row['pid']}','{$row['quantity']}','{$row['price']}', $total)";
				endwhile;
				$list_sql = "INSERT INTO `order_list` (order_id,product_id,quantity,price,total) VALUES {$data} ";
				$save_olist = $this->conn->query($list_sql);
				if($this->capture_err())
					return $this->capture_err();
				if($save_olist){
					$empty_cart = $this->conn->query("DELETE FROM `cart` where client_id = '{$client_id}'");
					$data = " order_id = '{$order_id}'";
					$data .= " ,total_amount = '{$amount}'";
					$save_sales = $this->conn->query("INSERT INTO `sales` set $data");
					if($this->capture_err())
						return $this->capture_err();
					$resp['status'] ='success';
				}else{
					$resp['status'] ='failed';
					$resp['err_sql'] =$save_olist;
				}

			}else{
				$resp['status'] ='failed';
				$resp['err_sql'] =$save_order;
			}
			return json_encode($resp);
		}
		
	}
	function update_order_status(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `orders` set `status` = '$status' where id = '{$id}' ");
		if($update){
			$resp['status'] ='success';
			$this->settings->set_flashdata("success"," Order status successfully updated.");
		}else{
			$resp['status'] ='failed';
			$resp['err'] =$this->conn->error;
		}
		return json_encode($resp);
	}
	function pay_order(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `orders` set `paid` = '1' where id = '{$id}' ");
		if($update){
			$resp['status'] ='success';
			$this->settings->set_flashdata("success"," Order payment status successfully updated.");
		}else{
			$resp['status'] ='failed';
			$resp['err'] =$this->conn->error;
		}
		return json_encode($resp);
	}
	function update_account(){
		extract($_POST);
		$data = "";
		$delivery_address = $housenum.','.$street.','.$brgy.','.$real_city.','.$province;
		if(!empty($password)){
			$_POST['password'] = md5($password);
			if(md5($cpassword) != $this->settings->userdata('password')){
				$resp['status'] = 'failed';
				$resp['msg'] = "Current Password is Incorrect";
				return json_encode($resp);
				exit;
			}

		}
		$check = $this->conn->query("SELECT * FROM `clients`  where `email`='{$email}' and `id` != $id ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Email already taken.";
			return json_encode($resp);
			exit;
		}
		foreach($_POST as $k =>$v){
			if($k == 'cpassword' || ($k == 'password' && empty($v)))
				continue;
				if(!empty($data)) $data .=",";
					$data .= " `{$k}`='{$v}' ";
		}
		if($password == ''){
			$save2 = $this->conn->query("UPDATE `clients` SET `firstname`='$firstname',`lastname`='$lastname',`gender`='$gender',`contact`='$contact',`email`='$email',`default_delivery_address`='$delivery_address' WHERE id = '$id'");
		}else{
			$save2 = $this->conn->query("UPDATE `clients` SET `firstname`='$firstname',`lastname`='$lastname',`gender`='$gender',`contact`='$contact',`password`='$password',`email`='$email',`default_delivery_address`='$delivery_address' WHERE id = '$id'");
		}

		// $save = $this->conn->query("UPDATE `clients` set $data where id = $id ");
		$save = TRUE;
		if($save){
			foreach($_POST as $k =>$v){
				if($k != 'cpassword')
				$this->settings->set_userdata($k,$v);
			}
			
			$this->settings->set_userdata('id',$this->conn->insert_id);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_featured(){
		extract($_POST);
		$save = $this->conn->query("INSERT INTO `featured_Jar` set product_id = '{$product_id}' ");
		if($save){
			$this->settings->set_flashdata('success',"Jar successfully added to Featured Page.");
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'An error occured';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function soft_delete_featured($id){
		global $conn;
		$id = (int)$id;
		$conn->query("UPDATE `featured_Jar` SET is_deleted = 1 WHERE id = $id");
		if($conn->affected_rows > 0){
			return json_encode(array('status'=>'success'));
		}
		return json_encode(array('status'=>'error'));
	}
	
	function delete_featured(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `featured_Jar` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Jar successfully Removed from Featured List.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_expenses(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id', 'description', 'amount'))){
				if(!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (isset($_POST['amount'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `amount`='".addslashes(htmlentities($_POST['amount']))."' ";
		}
	
		if(isset($_POST['description'])){
			if(!empty($data)) $data .= ",";
			$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
	
		if(empty($id)){
			$sql = "INSERT INTO `expenses` SET {$data}";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `expenses` SET {$data} WHERE id = '{$id}'";
			$save = $this->conn->query($sql);
		}
	
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success', "New Expenses saved.");
			else
				$this->settings->set_flashdata('success', "Expenses successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
	
		return json_encode($resp);
	}

	function delete_expenses(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `expenses` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata("successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_featured':
		echo $Master->save_featured();
	break;
	case 'delete_featured':
		echo $Master->delete_featured();
	break;
	case 'save_sub_category':
		echo $Master->save_sub_category();
	break;
	case 'delete_sub_category':
		echo $Master->delete_sub_category();
	break;
	case 'save_product':
		echo $Master->save_product();
	break;
	case 'delete_product':
		echo $Master->delete_product();
	break;

	case 'save_stat':
		echo $Master->save_stat();
	break;
	case 'delete_stat':
		echo $Master->delete_stat();
	break;
	case 'register':
		echo $Master->register();
	break;
	case 'add_to_cart':
		echo $Master->add_to_cart();
	break;
	case 'update_cart_qty':
		echo $Master->update_cart_qty();
	break;
	case 'delete_cart':
		echo $Master->delete_cart();
	break;
	case 'empty_cart':
		echo $Master->empty_cart();
	break;
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'place_order':
		echo $Master->place_order();
	break;
	case 'update_order_status':
		echo $Master->update_order_status();
	break;
	case 'pay_order':
		echo $Master->pay_order();
	break;
	case 'update_account':
		echo $Master->update_account();
	break;
	case 'delete_order':
		echo $Master->delete_order();
	break;
	case 'delete_expenses';
		echo $Master->delete_expenses();
	break;
	case 'save_expenses';
		echo $Master->save_expenses();
	default:
		// echo $sysset->index();
		break;
}