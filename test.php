<?php

declare(strict_types=1);

function run_db_test(PDO $conn): void
{
	$statement = $conn->query('SELECT * FROM `users`');
	$users = [];

	while ($row = $statement->fetch()) {
		$users[$row['id']] = $row['name'];
	}

	print_r('Users data<br/>');
	print_r($users);
	print_r('</br>');

	$statement = $conn->query('SELECT * FROM `user_accounts`');
	$user_accounts = [];

	while ($row = $statement->fetch()) {
		$user_accounts[$row['id']] = $row['user_id'];
	}

	print_r('User accounts data<br/>');
	print_r($user_accounts);
	print_r('</br>');

	$statement = $conn->query('SELECT * FROM `transactions`');
	$transactions = [];

	while ($row = $statement->fetch()) {
		$transactions[$row['id']] = $row['amount'];
	}

	print_r('Transactions data<br/>');
	print_r($transactions);
	print_r('</br>');
}
