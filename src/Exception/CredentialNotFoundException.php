<?php

namespace PJBank\Exception;

use Exception;

/**
 * Client Factory
 */
class CredentialNotFoundException extends Exception
{
	protected $message = 'Credencial não encontrada.';
}