<?php

declare(strict_types=1);

require_once 'db.php';
require_once 'Services/UserService.php';

$user_id = isset($_GET['user'])
	? (int)$_GET['user']
	: null;

header('Content-Type: application/json');

// Get transactions balances
if ($user_id) {
	$conn = get_connect();

	echo json_encode((new UserService)->getUserTransactionsBalances($user_id, $conn));
}
