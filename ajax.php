<?php

//Definitions
define('URL_Buckets', 'https://api.metadisk.org/buckets');
define('URL_Keys', 'https://api.metadisk.org/keys/');
define('URL_Users', 'https://api.metadisk.org/users');
define('URL_Activations', 'https://api.metadisk.org/activations/');

define('Bucket_Storage', 100);
define('Bucket_Transfer', 100);

define('PUBKEY', '04209dfc4d6bc17ddfd53a0af161b6f79ed3ce95fa6bc50b29f15a4b7d2fc90ab4d7bc8cb5ec0ccb87ef58938d83ced382902c0a7332e3c0ce1b1520f6f3f256e7');


class metavault {

	public $apiBucket = "https://api.metadisk.org/buckets";
	
	function listBuckets($username)	{
		return $this->curlGet($this->apiBucket);		
	}
		
	function deleteBucket($bucketID)	{
		return $this->curlDelete($this->apiBucket."/".$bucketID,"DELETE");				
	}
	
	function deleteAllBuckets()	{
		$json = $this->listBuckets("blakely.colin@gmail.com");
		print("<pre>".print_r($json,true)."</pre>");
		
		foreach($json as $d)
		{
			$this->deleteBucket($d["id"]);
			echo rand().$d["id"]."<br/>";
		}			
	}

	
	function bucketInfo($bucketID)
	{
		return $this->curlDo($this->apiBucket."/".$bucketID,"GET");			
	}	

	function listFiles($bucketID)
	{
		return $this->curlDo($this->apiBucket."/".$bucketID."/files","GET","id=".$bucketID);	
			
	}	
	
	function curlGet($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER,
               array('Content-Type:application/json',
                     'Accept: application/json')
               );
		curl_setopt($curl, CURLOPT_HTTPGET, 1);
		curl_setopt($curl, CURLOPT_USERPWD, "blakely.colin@gmail.com:4e691c2faeec70155cbf996ea0492119bed783b0c5241db547cb4701daff428f");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($curl);
		curl_close ($curl);	
		
		if(!curl_errno($curl))
			return json_decode($result, true);	
		else
			return curl_getinfo($curl, CURLINFO_HTTP_CODE);	
	}
	
	function curlPost($action, $url, $postString)
	{
		$curl = curl_init();

		switch($action) {
			case("createBucket"):
				exec('printf "POST\n/buckets\n{\"name\":\"'.$postString['name'].'\",\"transfer\":'.$postString['transfer'].',\"storage\":'.$postString['storage'].',\"__nonce\":'.$postString['__nonce'].'}" | openssl dgst -sha256 -hex -sign key/private.key -keyform DER', $sig) or die("error1");
				curl_setopt($curl, CURLOPT_POSTFIELDS, '{"name":"MyBucket","transfer":100,"storage":100,"__nonce":'.$postString['__nonce'].'}');
			break;
			case("token"):
				curl_setopt($curl, CURLOPT_USERPWD, "blakely.colin@gmail.com:4e691c2faeec70155cbf996ea0492119bed783b0c5241db547cb4701daff428f");
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postString));
			break;
		}
		
		curl_setopt($curl, CURLOPT_VERBOSE, true);

		$verbose = fopen('php://temp', 'w+');
		curl_setopt($curl, CURLOPT_STDERR, $verbose);
		
		
		
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER,
               array('x-signature:'.substr($sig[0],9),
			   		 'x-pubkey:'.PUBKEY,
					 'Content-Type:application/json',
                     'Accept:application/json')
               );
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		$result = curl_exec ($curl);
		
		if ($result === FALSE) {
			printf("cUrl error (#%d): %s<br>\n", curl_errno($curl),
				   htmlspecialchars(curl_error($curl)));
		}
		
		rewind($verbose);
		$verboseLog = stream_get_contents($verbose);
		
		echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
		
		
		
		
		echo '<pre>'.$result.'</pre>';
		
		
		
		curl_close ($curl);	
		
		if(!curl_errno($curl))
			return json_decode($result, true);	
		else
			return curl_getinfo($curl, CURLINFO_HTTP_CODE);
	}
	
	function curlPatch($url, $postString)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLINFO_HEADER_OUT, true);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER,
               array('Content-Type:application/json',
                     'Accept: application/json')
               );
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postString);
		curl_setopt($curl, CURLOPT_USERPWD, "blakely.colin@gmail.com:4e691c2faeec70155cbf996ea0492119bed783b0c5241db547cb4701daff428f");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($curl);
		curl_close ($curl);	
		
		if(!curl_errno($curl))
			return json_decode($result, true);	
		else
			return curl_getinfo($curl, CURLINFO_HTTP_CODE);
	}
	
	function curlDelete($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLINFO_HEADER_OUT, true);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER,
               array('Content-Type:application/json',
                     'Accept: application/json')
               );
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_USERPWD, "blakely.colin@gmail.com:4e691c2faeec70155cbf996ea0492119bed783b0c5241db547cb4701daff428f");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($curl);
		curl_close ($curl);	
		
		if(!curl_errno($curl))
			return json_decode($result, true);	
		else
			return curl_getinfo($curl, CURLINFO_HTTP_CODE);
	}
	
	function curlPut($url, $token)
	{
		$tmpfile = $_FILES['file']['tmp_name'];
		$filename = basename($_FILES['file']['name']);
		
		$data = array(
			'file' => '@'.$tmpfile,
			);
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTPHEADER,
		   array('Content-Type:multipart/form-data',
				 'Accept: application/json',
				 'x-token: '.$token,
				 'x-Filesize: '.filesize($tmpfile)
				 )
		   );	
		curl_setopt($curl, CURLOPT_VERBOSE, true);
		curl_setopt($curl, CURLOPT_USERPWD, "blakely.colin@gmail.com:4e691c2faeec70155cbf996ea0492119bed783b0c5241db547cb4701daff428f");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($curl);
		
		print_r("<pre>".$result."</pre>");
		
		curl_close ($curl);	
		
		if(!curl_errno($curl))
			return json_decode($result, true);	
		else
			return curl_getinfo($curl, CURLINFO_HTTP_CODE);
	}
	
	function curlDownload($url, $token)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTPHEADER,
		   array('Content-Type:multipart/form-data',
				 'Accept: application/json',
				 'x-token: '.$token,
				 )
		   );	
		curl_setopt($curl, CURLOPT_VERBOSE, true);
		curl_setopt($curl, CURLOPT_USERPWD, "blakely.colin@gmail.com:4e691c2faeec70155cbf996ea0492119bed783b0c5241db547cb4701daff428f");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($curl);
		
		print_r("<pre>".$result."</pre>");
		
		curl_close ($curl);	
		
		if(!curl_errno($curl))
			return json_decode($result, true);	
		else
			return curl_getinfo($curl, CURLINFO_HTTP_CODE);
	}
		
};

class buckets extends metavault {
   
   private $user;
   private $created;
   private $name;
   private $pubkeys;
   private $status;
   private $transfer;
   private $storage;
   private $id;
   
   
   /**
   * Constructs the new bucket - gets pertient bucket information
   * @function 	constructor
   * @param 	$id				Bucket id if passed, creates new if not
   */
	function __construct($id = NULL)
	{
		if($id == NULL)
			$this->createBucket();
		else
			$this->populateBucket($id);
	}
	
	private function populateBucket($bucketID)
	{
		$result = $this->curlGet(URL_Buckets."/".$bucketID);
		foreach($result as $key=>$value)
		{
			$this->{$key} = $value;
		}
	}
	
	private function createBucket()
	{
		$postString = array(
			'name' => 'MyBucket',
			'transfer' => Bucket_Transfer,
			'storage' => Bucket_Storage,
			'__nonce' => time() + 14532226693762222222
			);
		
		$result = $this->curlPost("createBucket", URL_Buckets, $postString);
		$this->id = $result['id'];

		$this->populateBucket($this->id);
	}
	
	function destroyBucket()
	{
		$result = $this->curlDelete(URL_Buckets.$this->id);
		
		if($result == "200")
			return 1;
		return $result;
	}
	
	function updateBucket($postString)
	{
		//Need to get the user input and pass to function as array
		$postString = array(
			'name' => 'test bucket - patch',
			'transfer' => 50,
			'storage' => Bucket_Storage
			);
		
		$result = $this->curlPatch(URL_Buckets.$this->id, json_encode($postString));

		if($result == "200")
			return 1;
		return $result;
	}
	
	function getToken($operation)
	{
		$postString = array(
			'operation'  => $operation,
			'__nonce' => time() + 14532226693762222222
			);
		
		$result = $this->curlPost("token", URL_Buckets."/".$this->id."/tokens", $postString);
		
		if($result == "200")
			return 1;
		return $result['token'];	
			
	}	
	
	function uploadFile($filePath, $token)
	{
		$result = $this->curlPut(URL_Buckets."/".$this->id."/files",$token);
		
		if($result == "200")
			return 1;
		return $result['hash'];
	}
	
	//need to add database functionality here
	function downloadFile($hash, $token)
	{
		$result = $this->curlDownload(URL_Buckets.$this->id."/files/".$hash, $token);

		echo "<pre>".$result[0]['channel']."</pre>";
		/* Open a server socket to port 1234 on localhost */
		$server = stream_socket_server($result[0]['channel']);
		
		/* Accept a connection */
		$socket = stream_socket_accept($server);
		
		/* Grab a packet (1500 is a typical MTU size) of OOB data */
		echo "Received Out-Of-Band: '" . stream_socket_recvfrom($socket, 5000) . "'\n";
		
		/* Take a peek at the normal in-band data, but don't comsume it. */
		echo "Data: '" . stream_socket_recvfrom($socket, 5000, STREAM_PEEK) . "'\n";
		
		/* Get the exact same packet again, but remove it from the buffer this time. */
		echo "Data: '" . stream_socket_recvfrom($socket, 5000) . "'\n";
		
		/* Close it up */
		fclose($socket);
		fclose($server);

	}
	
};


$metadisk = new metavault();

//$metadisk->deleteAllBuckets();

$bucket = new buckets("56ed48f256bf7b950faaccd5");

//$bucket->deleteAllBuckets();
//echo $bucket->signKey("POST", "/buckets",$test);

$hash = $bucket->uploadFile($filepath, $bucket->getToken("PUSH"));
//$bucket->downloadFile($hash, $bucket->getToken("PULL"));

//$bucket->destroyBucket();

?>



