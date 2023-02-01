<?php
/**
 * The file is part of the "getonecms/ext-user", OneCMS extension package.
 *
 * @see https://getonecms.com/extension/user
 *
 * @license Copyright (c) 2022 OneCMS
 * @license https://getonecms.com/extension/user/license
 * @author Mohammed Shifreen <mshifreen@gmail.com>
 */
declare(strict_types=1);

namespace OneCMS\User\Infrastructure\Service\PasswordHash;

use OneCMS\User\Domain\Service\HashServiceInterface;
use yii\base\Security;

/**
 * Hash service implementation.
 */
final class HashService implements HashServiceInterface
{
	/**
	 * The object constructor.
	 */
	public function __construct(private readonly Security $securityComponent)
	{
	}

	/**
	 * {@inheritDoc}
	 */
	public function generateHash(string $string): string
	{
		return $this->securityComponent->generatePasswordHash($string);
	}

	/**
	 * {@inheritDoc}
	 */
	public function validatesHash(string $string, string $hash): bool
	{
		return $this->securityComponent->validatePassword($string, $hash);
	}
}
