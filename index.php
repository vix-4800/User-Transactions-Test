<?php

declare(strict_types=1);

require_once 'db.php';
require_once 'test.php';
require_once 'Services/UserService.php';

$conn = get_connect();

// Uncomment to see data in db
// run_db_test($conn);

$month_names = [
	'01' => 'January',
	'02' => 'February',
	'03' => 'March'
];

$users = (new UserService())->getUsers($conn);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>User transactions information</title>

	<link rel="stylesheet" href="style.css">
</head>

<body>
	<h1>User transactions information</h1>
	<form action="data.php" method="GET" id="form">
		<label for="user">Select user:</label>
		<select name="user" id="user">
			<?php foreach ($users as $user) : ?>
				<option value="<?= $user->getId() ?>">
					<?= $user->getName() ?>
				</option>
			<?php endforeach ?>
		</select>

		<button id="submit" type="submit">Show</button>
	</form>

	<div id="data">
		<h2>Transactions of `User name`</h2>
		<table>
			<tr>
				<th>Mounth</th>
				<th>Amount</th>
			</tr>
			<tr>
				<td>...</td>
				<td>...</td>
		</table>
	</div>
	<script src="script.js"></script>
</body>

</html>