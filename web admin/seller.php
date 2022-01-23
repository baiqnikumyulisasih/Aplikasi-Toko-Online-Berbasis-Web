<?php 

error_reporting(0);
require_once '../config/config.php';
require_once '../config/koneksi.php';

session_start();
	if (!isset($_SESSION['pembeli'])) {
	}


$limit = 5;
if(isset($_GET['p']))
{
    $noPage = $_GET['p'];
}
else $noPage = 1;

$offset = ($noPage - 1) * $limit;

$terkini = 'SELECT
pembeli.nama,
pembeli.email,
pembeli.no_hp,
pembeli.alamat
FROM
pembeli
WHERE
pembeli.role = "admin" or "seller"
ORDER BY
pembeli.id_pembeli DESC
LIMIT '
.$offset.",". $limit;

$qry = $mysqli->query($terkini);

$sql_rec = "SELECT id_pembeli FROM pembeli WHERE role = 'admin' ";

$total_rec = $mysqli->query($sql_rec);

$total_rec_num = $total_rec->num_rows;

$total_page = ceil($total_rec_num/$limit);

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../asset/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../asset/font-awesome/css/font-awesome.min.css">
  	<link rel="stylesheet" type="text/css" href="../asset/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/admin-style.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
	<div class="header" style="background: black; height: 50px; ">
		<h3>Amanah Batu Ukir</h3>
	</div>
	<div class="container">
		<nav class="sidebar">
			<div class="text">Side Menu</div>
			<ul>
				<li><a href="dashboard-admin.php">Dashboard</a></li>
				<li>
					<a href="#" class="prod-btn ">Produk
						<span class="fas fa-caret-down first"></span>
					</a>
					<ul class="prod-show">
						<li><a href="add_produk.php">Add Produk</a></li>
						<li><a href="list_produk.php">List Produk</a></li>
					</ul>
				</li>
				<li>
					<a href="#" class="ord-btn ">Orders
						<span class="fas fa-caret-down second"></span>
					</a>
					<ul class="ord-show">
						<li><a href="new-order.php">New Orders</a></li>
						<li><a href="list-order.php">List Orders</a></li>
					</ul>
				</li>
				<li><a href="customer.php">Customers</a></li>
				<li><a href="seller.php">Sellers</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
	</div>

	<div class="dashboard">
		<div class="latest-orders">
			<h5>Data Seller<a href="" style="float: right;font-size: 2em; text-decoration: none;color: black;margin-right: 20px; position: relative;">+</a></h5>
			<table class="table table-hover">
				<?php 
                    while ($data = $qry->fetch_assoc()) { ?>
				<tr>
					<td><?php echo $data['nama']; ?></td>
					<td><?php echo $data['email']; ?></td>
					<td><?php echo $data['no_hp']; ?></td>
					<td><?php echo $data['alamat']; ?></td>
					<td><?php echo $data['tanggal']; ?></td>
					<td>
						<a class="btn btn-primary" href="">Edit</a>
					</td>
				</tr>
				<?php } ?>
			</table>
			<div style="padding-bottom: 10px; padding-top: 10px;">
                <nav aria-label="Page navigation example">
                </nav>
                <ul class="pagination">
                <?php if ($total_rec_num > $limit) { ?>
                <?php if ($noPage > 1 ) { ?>
                	<li class="page-item">
                		<a class="page-link" href="<?php echo $base_url."web admin/list-order.php?p=".($noPage-1);?>">
                			<span aria-hidden="true">&laquo;</span>
                    	</a>
                    </li>
                    <?php } ?>
                    <?php for ($page=1; $page <= $total_page ; $page++) { ?>
                    	<?php if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $total_page)) { ?>
                        	<?php
                                $showPage = $page;
                                if ($page==$total_page && $noPage <= $total_page-5) echo "<li class='active page-item'><a class='page-link'>...</a></li>";
                                if ($page == $noPage) echo "<li class='active page-item'><a class='page-link' href='#'>".$page."</a></li> ";
                               	else echo   " <li class='page-item' ><a class='page-link' href='".$_SERVER['PHP_SELF']."?p=".$page."'>".$page."</a></li> ";
                                if ($page == 1 && $noPage >=6) echo "<li class='active page-item'><a class='page-link'>...</a></li>";
                            ?>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($noPage < $total_page) { ?>
                    	<li class="page-item">
                        	<a class="page-link" href="<?php echo $base_url."web admin/list-order.php?p=".($noPage+1); ?>">
                            	<span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
                </ul>
           	</div>
		</div>
	</div>

	<script>
		$('.prod-btn').click(function(){
			$('nav ul .prod-show').toggleClass("show"); 
		});
		$('.ord-btn').click(function(){
			$('nav ul .ord-show').toggleClass("show1"); 
		});
	</script>
</body>
</html>