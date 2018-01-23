<?php
namespace Mavinoo\LaravelSmsIran\Gateways;

interface GatewayInterface {

	/**
	 * @param array $numbers
	 * @param       $text
	 * @param bool  $isflash
	 *
	 * @return mixed
	 */
	public function sendSMS(array $numbers, $text, $isflash = false);

	/**
	 * @return int
	 */
	public function getCredit();
}