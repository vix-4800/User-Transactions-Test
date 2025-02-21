<?php

declare(strict_types=1);

require_once 'db.php';
require_once 'Services/UserService.php';

$user_id = isset($_GET['user'])
	? (int)$_GET['user']
	: null;

header('Content-Type: application/json');

if ($user_id) {
	// Get transactions balances
	$conn = get_connect();

	// TODO: implement
	echo json_encode((new UserService)->getUserTransactionsBalances($user_id, $conn));
}
