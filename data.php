<?php

declare(strict_types=1);

require_once 'db.php';
require_once 'Services/UserService.php';

$user_id = isset($_GET['user'])
	? (int)$_GET['user']
	: null;

if ($user_id) {
	// Get transactions balances
	$transactions = (new UserService)->getUserTransactionsBalances($user_id, $conn);
	// TODO: implement
}
