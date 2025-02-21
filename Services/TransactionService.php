<?php

declare(strict_types=1);

require_once __DIR__ . './../Enums/TransactionType.php';
require_once __DIR__ . './../Models/Transaction.php';
require_once 'UserAccountService.php';
require_once __DIR__ . './../Models/UserAccount.php';

class TransactionService
{
	private readonly UserAccountService $userAccountService;

	public function __construct()
	{
		$this->userAccountService = new UserAccountService();
	}

	/**
	 * Return transactions balances of given user.
	 */
	public function getUserTransactionsBalances(int|User $user, PDO $conn): array
	{
		$user_id = is_int($user) ? $user : $user->getId();

		$accounts = $this->userAccountService->getUserAccounts($user_id, $conn);

		if (empty($accounts)) {
			return [];
		}

		$outgoingTransactions = $this->getUserOutgoingTransactions($accounts, $conn);
		$incomingTransactions = $this->getUserIncomingTransactions($accounts, $conn);

		$groupedTransactions = [];
		foreach (array_merge($outgoingTransactions, $incomingTransactions) as $transaction) {
			$month = $transaction->getDate()->format('F');

			if (!isset($groupedTransactions[$month])) {
				$groupedTransactions[$month] = 0;
			}
			$groupedTransactions[$month] += $transaction->getAmount();
		}

		return $groupedTransactions;
	}

	/**
	 * Return outgoing transactions of given user.
	 * 
	 * @param UserAccount[] $accounts
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
	 * @param UserAccount[] $accounts
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

	/**
	 * Count transactions of given user.
	 */
	public function countTransactions(int|User $user, PDO $conn): int
	{
		$user_id = is_int($user) ? $user : $user->getId();

		$statement = $conn->query(
			"SELECT COUNT(*) FROM `transactions` 
				WHERE `account_from` IN (SELECT `id` FROM `user_accounts` WHERE `user_id` = {$user_id}) 
				OR `account_to` IN (SELECT `id` FROM `user_accounts` WHERE `user_id` = {$user_id})"
		);

		return (int)$statement->fetchColumn();
	}
}
