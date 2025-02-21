<?php

declare(strict_types=1);

require_once __DIR__ . './../Models/UserAccount.php';

class UserAccountService
{
	/**
	 * Return user accounts of given user.
	 * 
	 * @return UserAccount[]
	 */
	public function getUserAccounts(int|User $user, PDO $conn): array
	{
		$user_id = is_int($user) ? $user : $user->getId();

		$statement = $conn->query("SELECT * FROM `user_accounts` WHERE `user_id` = {$user_id}");

		$accounts = [];
		while ($row = $statement->fetch()) {
			$accounts[] = new UserAccount($row['id'], $row['user_id']);
		}

		return $accounts;
	}
}
