<?php

namespace PJBank\Exception;

use Exception;

/**
 * Client Factory
 */
class KeyNotFoundException extends Exception
{
	protected $message = 'Chave não encontrada.';
}