<?php

namespace PJBank\Boleto;

use PJBank\Client\PJBank;
use PJBank\Client\PJBankInterface;

class BoletoManager {

	protected $pjBank;

	public static function create(PJBankInterface $pjBank = null) {
		return new static(
			$pjBank ?: PJBank::create()
		);
	}

	public function __construct(PJBankInterface $pjBank) {
		$this->pjBank = $pjBank;
	}

	public function getPjBank() {
		return $this->pjBank;
	}

	public function sendBoleto(Boleto $boleto) {
		return $this->pjBank->sendPost('/recebimentos/{{ %credencial% }}/transacoes', $boleto->toArray());
	}

	public function sendBoletoCollection(BoletoColletion $collection) {
		return $this->pjBank->sendPost('/recebimentos/{{ %credencial% }}/transacoes', $collection->toArray());
	}

}