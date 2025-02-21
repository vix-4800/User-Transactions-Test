<?php

declare(strict_types=1);

require_once __DIR__ . './../Models/User.php';
require_once 'TransactionService.php';

class UserService
{
	private readonly TransactionService $transactionService;

	public function __construct()
	{
		$this->transactionService = new TransactionService();
	}

	/**
	 * Return list of users.
	 * 
	 * @return User[]
	 */
	public function getUsers(PDO $conn, bool $withTransactions = false): array
	{
		$statement = $conn->query('SELECT * FROM `users`');

		$users = [];
		while ($row = $statement->fetch()) {
			$user = new User($row['id'], $row['name']);

			if (!$withTransactions || $this->transactionService->countTransactions($user->getId(), $conn) > 0) {
				$users[] = new User($row['id'], $row['name']);
			}
		}

		return $users;
	}
}
