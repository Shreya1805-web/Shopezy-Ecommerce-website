<?php

session_start();


if(!isset($_SESSION["uid"])){
	header("location:index.php");
}

	$trx_id = 123456789;
		$p_st = 'Completed';
		$cm_user_id = $_SESSION["uid"];
	if (1) {
		include_once("db.php");
		$sql = "SELECT p_id,qty FROM cart WHERE user_id = '$cm_user_id'";
		$query = mysqli_query($con,$sql);
		if (mysqli_num_rows($query) > 0) {
			# code...
			while ($row=mysqli_fetch_array($query)) {
			$product_id[] = $row["p_id"];
			$qty[] = $row["qty"];
			}

			for ($i=0; $i < count($product_id); $i++) { 
				$sql = "INSERT INTO orders (user_id,product_id,qty,trx_id,p_status) VALUES ('$cm_user_id','".$product_id[$i]."','".$qty[$i]."','$trx_id','$p_st')";
				mysqli_query($con,$sql);
			}

      for($i=0; $i< count($product_id); $i++){
        $abc = "SELECT product_qty FROM products WHERE product_id = '".$product_id[$i]."' ";
        $query = mysqli_query($con,$abc);
        $row=mysqli_fetch_array($query);
        $p_qty = $row["product_qty"];

        $sql = "UPDATE products SET product_qty= $p_qty- ".$qty[$i]."  WHERE product_id = '".$product_id[$i]."' ";
        mysqli_query($con,$sql);
      }

			$sql = "DELETE FROM cart WHERE user_id = '$cm_user_id'";
			if (mysqli_query($con,$sql)) {
				?>
					<!DOCTYPE html>
					<html>
						<head>
							<meta charset="UTF-8">
							<title>ShopEzy</title>
							<link rel="stylesheet" href="css/bootstrap.min.css"/>
							<script src="js/jquery2.js"></script>
							<script src="js/bootstrap.min.js"></script>
							<script src="main.js"></script>
							<style>
								table tr td {padding:10px;}
							</style>
						</head>
					<body>
						<div class="navbar navbar-inverse navbar-fixed-top">
							<div class="container-fluid">	
								<div class="navbar-header">
									<a href="#" class="navbar-brand">ShopEzy</a>
								</div>
								<ul class="nav navbar-nav">
									<li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
									<li><a href="profile.php"><span class="glyphicon glyphicon-modal-window"></span>Product</a></li>
								</ul>
							</div>
						</div>
						<p><br/></p>
						<p><br/></p>
						<p><br/></p>
						<div class="container-fluid">
						
							<div class="row">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<div class="panel panel-default">
										<div class="panel-heading"></div>
										<div class="panel-body">
											<h1>Thankyou </h1>
											<hr/>
											<p>Hello <?php echo "<b>".$_SESSION["name"]."</b>"; ?>,Your payment process is 
											successfully completed and your Transaction id is <b><?php echo $trx_id; ?></b><br/>
											you can continue your Shopping <br/></p>
											<a href="index.php" class="btn btn-success btn-lg">Continue Shopping</a>
										</div>
										<div class="panel-footer"></div>
									</div>
								</div>
								<div class="col-md-2"></div>
							</div>
						</div>
					</body>
					</html>

				<?php
			}
		}else{
			header("location:index.php");
		}
		
	}
// }


?>


<?php require_once('footer.php'); ?>



































