<?php

declare(strict_types=1);

class UserAccount
{
	public function __construct(
		private int $id,
		private int $userId,
	) {
		// 
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getUserId(): int
	{
		return $this->userId;
	}
}
