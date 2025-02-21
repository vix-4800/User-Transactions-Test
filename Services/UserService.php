<?php

declare(strict_types=1);

require_once __DIR__ . './../Models/User.php';

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
}
