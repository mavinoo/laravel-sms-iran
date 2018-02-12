<?php
namespace Mavinoo\LaravelSmsIran\Gateways;

class PostgahGateway extends GatewayAbstract {

	/**
	 * PostgahGateway constructor.
	 */
	public function __construct() {
		$this->webService   = config('sms.gateway.postgah.webService');
		$this->username     = config('sms.gateway.postgah.username');
		$this->password     = config('sms.gateway.postgah.password');
		$this->from         = config('sms.gateway.postgah.from');
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

        $webService = $this->webService . 'SendSms.ashx';

        $params = [
					'username' => $this->username,
					'password' => $this->password,
					'from'     => $this->from,
					'to'       => implode(',', $numbers),
					'text'     => $text,
					'flash'    => $isflash,
					'udh'      => '',
				];

        $response = $this->curlURL($webService, $params);

        return $response;
    }


	/**
	 * @return mixed
	 */
	public function getCredit() {
		if(!$this->username and !$this->password)
			return 'Blank Username && Password';
		try {

            $webService = $this->webService . 'GetCredit.ashx';

			$params = [
                "username" => $this->username,
                "password" => $this->password,
            ];

			return $this->curlURL($webService, $params);

		} catch( SoapFault $ex ) {
			echo $ex->faultstring;
		}
	}

	
	private function curlURL($webService, $params)
    {
        try
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $webService);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            $response = curl_exec($ch);

            if($typeRec)
            {
                if(preg_match("/^[0-9]{20}$/s", $response))
                    return $response;
            }
            else
            {
                return $response;
            }

            return false;
        }
        catch (Exception $exception)
        {
            return false;
        }
    }

}
