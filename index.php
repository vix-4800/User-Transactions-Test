<?php

declare(strict_types=1);

require_once 'db.php';
require_once 'test.php';
require_once 'Services/UserService.php';

$conn = get_connect();

$users = (new UserService())->getUsers($conn);

// Uncomment to see data in db
// run_db_test($conn);
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
	<main>
		<section id="form_section">
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
		</section>

		<section id="data_section">
			<h2>Transactions of `<span id="user_name">User Name</span>`</h2>
			<table>
				<thead>
					<tr>
						<th>Month</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody id="data"></tbody>
			</table>
		</section>
	</main>

	<script src="script.js"></script>
</body>

</html>