<?php

session_start();
include 'firstimport.php';


mysqli_select_db($conn,"$db_name") or die("cannot select db");
	
	


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="trader.css">

	<title>AgriBid</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">AgriBid</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="myorder.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">My Order</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Analytics</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Message</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-group' ></i>
					<span class="text">Team</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="logout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
				<img src="img/people.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1> Trader's Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
			</div>
			<?php 
				$sql = "select * from ord";
				$result = mysqli_query($conn,$sql);
				$rowcount = mysqli_num_rows( $result );

				

			echo
			'<ul class="box-info">
				<li>
					<i class="bx bxs-calendar-check" ></i>
					<span class="text">
						<h3 id="myorder">'.$rowcount; ?></h3>
						<p>My Order</p>
					</span>
				</li>
				
				<?php 
					$sql1 = "select baseprice from ord";
					$result1 = mysqli_query($conn,$sql1);
					$cost = 0;
				while($row = mysqli_fetch_assoc($result1)){	
					$cost = $cost+$row['baseprice'];	
				}
				echo'
				<li>
					<i class="bx bxs-dollar-circle" ></i>
					<span class="text">
						<h3>$ <span class="totalprice" id="totalprice">'.$cost;?></span></h3>
						<p>Total cost</p>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Item List</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table id="table-body">
						<thead>
							<tr>
								<th>Name</th>
								<th>crop</th>
								<th>Place</th>
								<th>quantity</th>
								<th>Base Price</th>
								<th>buy </th>
							</tr>
						</thead>
						<tbody>
							<?php
								
								$sql="SELECT * FROM trade;";
								$result=mysqli_query($conn,$sql);
								while($row = mysqli_fetch_assoc($result)){
								echo 
								'<tr>
										
										<td class="name">'.$row['uname'].'</td>    
                                    	<td class="crop">'.$row['crop'].'</td>   
                                    	<td class="place">'.$row['place'].'</td>   
                                    	<td class="place">'.$row['quantity'].'</td>   
                                    	<td class="price">'.$row['baseprice'].'</td> 
                                    	<td><a href="buy.php?buyid='.$row['tradeid'].'"><input type="submit" value="Buy" name="buy" class="buy" onclick="myorder();"></a></td>  
                            		</tr>';
							
								}

				?>
				<?php 
					if(isset($_POST['buy'])){
						$tradeid = $row['tradeid'];
						$crop = $row['crop'];
						$quantity = $row['quantity'];
						$baseprice = $row['baseprice'];
						

						$sql2 = "insert into `ord` (orderid,tradeid,crop,quantity,baseprice) values('','$tradeid','$crop','$quantity','$baseprice');";
			
			 			$result2 = mysqli_query($conn,$sql2);
					}
				?>
											
														
						</tbody>
					</table>
                    <script>
                         function myorder(){
							
							// alert("successfully bought the crop");

                            x = document.getElementById("myorder").innerHTML;
                            x = parseInt(x);
                            document.getElementById("myorder").innerHTML = x+1;
							
							
                        }
						
						

						$(document).ready(function(){
							$(".buy").click(function(){
								$(this).closest("tr").remove();
							});
						});
						

                    
                    </script>
				</div>
				 
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="ag.js"></script>
</body>
</html>