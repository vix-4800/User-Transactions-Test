<?php

declare(strict_types=1);

require_once __DIR__ . './../Enums/TransactionType.php';
require_once __DIR__ . './../Models/Transaction.php';
require_once 'UserService.php';

class TransactionService
{
	/**
	 * Return transactions balances of given user.
	 */
	public function getUserTransactionsBalances(int $user_id, PDO $conn): array
	{
		$accounts = (new UserService)->getUserAccounts($user_id, $conn);
		$outgoingTransactions = $this->getUserOutgoingTransactions($accounts, $conn);
		$incomingTransactions = $this->getUserIncomingTransactions($accounts, $conn);

		$groupedTransactions = [];
		foreach (array_merge($outgoingTransactions, $incomingTransactions) as $transaction) {
			$groupedTransactions[$transaction->getDate()->format('F')] += $transaction->getAmount();
		}

		return $groupedTransactions;
	}

	/**
	 * Return outgoing transactions of given user.
	 * 
	 * @return Transaction[]
	 */
	public function getUserOutgoingTransactions(array $accounts, PDO $conn): array
	{
		$accountsIds = array_map(fn(UserAccount $account): int => $account->getId(), $accounts);
		$statement = $conn->query("SELECT * FROM `transactions` WHERE `account_from` IN (" . implode(',', $accountsIds) . ")");

		$transactions = [];
		while ($row = $statement->fetch()) {
			$transactions[] = new Transaction(
				$row['id'],
				$row['account_from'],
				$row['account_to'],
				$row['amount'],
				new DateTime($row['trdate']),
				TransactionType::OUTGOING
			);
		}

		return $transactions;
	}

	/**
	 * Return incoming transactions of given user.
	 * 
	 * @return Transaction[]
	 */
	public function getUserIncomingTransactions(array $accounts, PDO $conn): array
	{
		$accountsIds = array_map(fn(UserAccount $account): int => $account->getId(), $accounts);
		$statement = $conn->query("SELECT * FROM `transactions` WHERE `account_to` IN (" . implode(',', $accountsIds) . ")");

		$transactions = [];
		while ($row = $statement->fetch()) {
			$transactions[] = new Transaction(
				$row['id'],
				$row['account_from'],
				$row['account_to'],
				$row['amount'],
				new DateTime($row['trdate']),
				TransactionType::INCOMING
			);
		}

		return $transactions;
	}
}
