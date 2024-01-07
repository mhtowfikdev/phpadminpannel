<?php
session_start();

require_once('functions.php');
require_once('dbconnection.php');
require_once('includes/init.php');

$password = $_SESSION['password'];
$admin_data = get_admin($conn, $password);
if ($password != $admin_data['password']) {
	header('location: login.php');
}
if ( !isset($_SESSION['password']) ) {
	header('location: login.php');
}
if ( empty( $admin_data ) ) header('location: login.php');

$pageTitle = "Task History";


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM history WHERE id = $id";
	$result = $conn -> query($sql);
    if ($result === TRUE) {
		snack ("success", "Success");
    } else {
    	snack ("error", "Failed");
    	echo $conn->error;
    }
}

$list = 'all';

$sql = "SELECT * FROM history ORDER BY date DESC";

if (isset($_GET['list'])) {
	$list = $_GET['list'];
	$pageTitle = $pageTitle . ' - ' . $list;
	$sql = "SELECT * FROM history WHERE number='$list' ORDER BY date DESC";
}

$data = mysqli_query($conn, $sql);

$rows = [];
while($row = mysqli_fetch_array($data))
{
    $rows[] = $row;
}

$index = 1 ;

$sql2 = "SELECT
		( SELECT COUNT(1) FROM history) AS history_count,
		( SELECT SUM(amount) FROM history WHERE status = 'Paid') AS paid_amount,
		( SELECT SUM(amount) FROM history WHERE status = 'Pending') AS pending_amount
		FROM dual";
if (isset($_GET['list'])) {
	$list = $_GET['list'];
	$sql2 = "SELECT
		( SELECT COUNT(1) FROM history WHERE number = '$list') AS history_count,
		( SELECT SUM(amount) FROM history WHERE status = 'Paid') AS paid_amount,
		( SELECT SUM(amount) FROM history WHERE status = 'Pending') AS pending_amount
		FROM dual";
}		
$result2 = $conn -> query($sql2);
$data2 = $result2 -> fetch_assoc();


?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $pageTitle ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false, shrink-to-fit=no">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<style>
			*, .select {
				user-select: text !important;
			}
			main {
				overflow: auto;
				padding: 1em;
			}
			table {
				white-space: nowrap;
			}
			tbody > tr:nth-child(even) {
				background: #F8F8F8;
			}
			.Paid {
				color: green;
			}
			.Pending {
				color: red;
			}
		</style>
	</head>
	<body class="bg-gray-200">
		<?php include("header.php") ?>
		<main>
			<section class="fr-container fr-lg" style="width: 800px;">
									<section class="table-wrapper">
						<table class="table table-divo">
							<thead><tr>
								<th><i class="material-icons" style="vertical-align: -3px">insights</i> <?= $data2['history_count'] ?? '0' ?></th>
					<th scope="col">Date</th>
					<th scope="col">Account</th>
					<th scope="col">Amount</th>
					<th scope="col">Status</th>
					<th scope="col">Action</th>
				
				</tr></thead>
				<tbody>
				<?php foreach ($rows as $row) : ?>
				<tr>
					<td><?php echo $index ?></td>
					<td><?php echo date("d-M-y @ H:i", strtotime($row['date']) + 10*3600 ) ?></td>
					<td><?php echo $row['number'] ?></td>
					<td><?php echo $row['amount'] ?></td>
					<td class="<?php echo $row['status'] ?>"><?php echo $row['status'] ?></td>
					<td class="">
						<a href="history.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-block"><span class="material-icons">delete</span></a>
					</td>
				</tr>
				<?php $index++ ?>
				<?php endforeach ?>
				</tbody>
			</table>
		</main>
		
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


		<?php if (isset($_GET['success'])) : ?>
			<p class="snackbar success">Success</p>
		<?php endif ?>
		<?php include('footer.php') ?>
	
	</body>
</html>