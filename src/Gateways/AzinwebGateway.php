<?php
namespace Mavinoo\LaravelSmsIran\Gateways;

class AzinwebGateway extends GatewayAbstract {

	/**
	 * AzinwebGateway constructor.
	 */
	public function __construct() {

		$this->webService  = config('sms.gateway.azinweb.webService');
		$this->username    = config('sms.gateway.azinweb.username');
		$this->password    = config('sms.gateway.azinweb.password');
		$this->from        = config('sms.gateway.azinweb.from');
	}


	/**
	 * @param array $numbers
	 * @param       $text
	 * @param bool  $isflash
	 *
	 * @return mixed
	 * @internal param $to | array
	 */
	public function sendSMS( array $numbers, $text, $isflash = false ) {
		// Check credit for the gateway
		if(!$this->GetCredit()) return;
		try {
			$client = new \SoapClient( $this->webService );
			$result = $client->SendSms(
				[
					'username' => $this->username,
					'password' => $this->password,
					'from'     => $this->from,
					'to'       => $numbers,
					'text'     => $text,
					'flash'    => $isflash,
					'udh'      => '',
				]
			);

			return $result;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}


	/**
	 * @return mixed
	 */
	public function getCredit() {
		if(!$this->username and !$this->password)
			return 'Blank Username && Password';
		try {
			$client = new \SoapClient( $this->webService );

			return $client->Credit( [
				                        "username" => $this->username,
				                        "password" => $this->password,
			                        ] )->CreditResult;
		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}

}