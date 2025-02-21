<?php

declare(strict_types=1);

require_once __DIR__ . './../Models/User.php';
require_once __DIR__ . './../Models/Transaction.php';

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
	 * Return transactions balances of given user.
	 */
	public function getUserTransactionsBalances(int $user_id, PDO $conn): array
	{
		$transactions = $this->getUserTransactions($user_id, $conn);

		$groupedTransactions = [];
		foreach ($transactions as $transaction) {
			$groupedTransactions[$transaction->getDate()->format('F')] += $transaction->getAmount();
		}

		return $groupedTransactions;
	}

	/**
	 * Return transactions of given user.
	 * 
	 * @return Transaction[]
	 */
	public function getUserTransactions(int $user_id, PDO $conn): array
	{
		$statement = $conn->query("SELECT * FROM `transactions` WHERE `account_from` = {$user_id}");

		$transactions = [];
		while ($row = $statement->fetch()) {
			$transactions[] = new Transaction(
				$row['id'],
				$row['account_from'],
				$row['account_to'],
				$row['amount'],
				new DateTime($row['trdate'])
			);
		}

		return $transactions;
	}
}
