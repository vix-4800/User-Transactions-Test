<?php

declare(strict_types=1);

require_once 'db.php';
require_once 'Services/TransactionService.php';

header('Content-Type: application/json');

$user_id = isset($_GET['user'])
	? (int)$_GET['user']
	: null;

if ($user_id) {
	$conn = get_connect();

	$balances = (new TransactionService)->getUserTransactionsBalances($user_id, $conn);
	echo json_encode($balances);
}
