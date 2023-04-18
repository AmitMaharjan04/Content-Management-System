<?php
namespace App\Http\Helper;

class ResponseCode{
	public static function validationError($message, $status='0'){
		return array(
	            	'status'    => $status,
	            	'statusCode'=> 411,
	            	'message'   => [$message]
				);
	}

	public static function accessDenied($message, $status='0'){
		return array(
	            	'status'    => $status,
	            	'statusCode'=> 403,
	            	'message'   => [$message]
				);
	}

	public static function unauthorized($message, $status='0'){
		return array(
	            	'status'    => $status,
	            	'statusCode'=> 401,
	            	'message'   => [$message]
				);
	}

	public static function forbidden($message, $status='0'){
		return array(
	            	'status'    => $status,
	            	'statusCode'=> 403,
	            	'message'   => [$message]
				);
	}

	public static function getData($users,$total=1, $time,$status='1'){
		$toreturn = array(
                    'time' => $time,
	                'status'    => $status,
	                'statusCode'=> 200,
	                'message'   => $total . '  ' . 'found',
	                'response'      => $users
				  );
		return $toreturn;
	}

	public static function notFound($status='0'){
		return array(
	                  'status'    => $status,
	                  'statusCode'=> 406,
	                  'message'   => "User doesnt exist",
	              );
	}

	public static function create($data, $message, $status='1'){
		return array(
	                'status'    => $status,
	                'statusCode'=> 201,
	                'message'   => [$message],
	                'response'      => $data
	            );
	}

	public static function successMessage($message, $status='1'){
		return array(
	                  "status" => $status,
	                  'statusCode' => 200,
	                  'message' => [$message]
	                );
	}
    public static function errorMessageClient($message, $status='0'){
		return array(
	                  "status" => $status,
	                  'statusCode' => 400,
	                  'message' => [$message]
	                );
	}
	public static function errorMessage($message, $status='0'){
		return array(
	                  "status" => $status,
	                  'statusCode' => 500,
	                  'message' => [$message]
	                );
	}


	public static function loginSuccessful($msg, $token, $status='1'){
		return array(
	                'status'    => $status,
	                'statusCode'=> 200,
	                'message'   => $msg,
	                'api_token'      => $token,
	              );
	}

	public static function loginFailure($msg,  $status='0'){
		return array(
	                'status'    => $status,
	                'statusCode'=> 400,
	                'message'   => $msg,
	              );
	}

	public static function validationErrors($message, $status='0'){
		return array(
	            	'status'    => $status,
	            	'statusCode'=> 411,
	            	'message'   => $message
				);
	}

}
?>