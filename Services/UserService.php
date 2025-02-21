<?php

declare(strict_types=1);

require_once __DIR__ . './../Models/User.php';

class UserService
{
	/**
	 * Return list of users.
	 * @return User[]
	 */
	public function getUsers(PDO $conn): array
	{
		// TODO: implement
		return [];
	}

	/**
	 * Return transactions balances of given user.
	 */
	public function getUserTransactionsBalances(int $user_id, PDO $conn): array
	{
		// TODO: implement
		return [];
	}
}
