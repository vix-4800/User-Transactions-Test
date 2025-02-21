<?php

declare(strict_types=1);

require_once __DIR__ . './../Models/User.php';
require_once __DIR__ . './../Models/UserAccount.php';

class UserService
{
	/**
	 * Return list of users.
	 * 
	 * @return User[]
	 */
	public function getUsers(PDO $conn): array
	{
		$statement = $conn->query('SELECT * FROM `users`');

		$users = [];
		while ($row = $statement->fetch()) {
			$users[] = new User($row['id'], $row['name']);
		}

		return $users;
	}

	/**
	 * Return user accounts of given user.
	 * 
	 * @return UserAccount[]
	 */
	public function getUserAccounts(int $user_id, PDO $conn): array
	{
		$statement = $conn->query("SELECT * FROM `user_accounts` WHERE `user_id` = {$user_id}");

		$accounts = [];
		while ($row = $statement->fetch()) {
			$accounts[] = new UserAccount($row['id'], $row['user_id']);
		}

		return $accounts;
	}
}
