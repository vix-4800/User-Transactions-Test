<?php

declare(strict_types=1);

class Transaction
{
	public function __construct(
		private int $id,
		private int $accountFrom,
		private int $accountTo,
		private int|float $amount,
		private DateTime $date,
		private TransactionType $type
	) {
		// 
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getAccountFrom(): int
	{
		return $this->accountFrom;
	}

	public function getAccountTo(): int
	{
		return $this->accountTo;
	}

	public function getAmount(): int|float
	{
		return $this->isOutgoing() ? -$this->amount : $this->amount;
	}

	public function getDate(): DateTime
	{
		return $this->date;
	}

	public function getType(): TransactionType
	{
		return $this->type;
	}

	public function isOutgoing(): bool
	{
		return $this->type === TransactionType::OUTGOING;
	}
}
