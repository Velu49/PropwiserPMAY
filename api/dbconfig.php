<?php
class DBConfig
{
	const DB_SERVER = "localhost";	
	const DB_USER = "hackathon_pmay";
    const DB_PASSWORD = "pmay123";
	const DB = "hackathon_pmay";
	
	protected $db = NULL;
	public $_allow = array();
	public $_content_type = "application/json";
	public $_request = array();
	
	private $_method = "";		
	private $_code = 200;
	
	public function __construct()
	{
		$this->inputs();
                date_default_timezone_set('Asia/Kolkata');
		$this->dbConnect();
	}
	private function set_headers()
	{
		header("HTTP/1.1 ".$this->_code." ".$this->get_status_message());
		header("Content-Type:".$this->_content_type);
	}
	protected function dbConnect()
	{
		try {
			$this->db = new PDO('mysql:host='.self::DB_SERVER.';dbname='.self::DB.';charset=UTF8;', self::DB_USER, self::DB_PASSWORD);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e) {
			echo 'ERROR: '.$e->getMessage();
			die();
		}
	}
	# Money Format comma(,)
	public function IND_money_format($num){
	    $num = round($num);
	    //converting it to string
	    $numToString = (string)$num;
	    //take care of decimal values
	    $change = explode('.', $numToString);
	    //taking care of minus sign
	    $checkifminus =  explode('-', $change[0]);
	    //if minus then change the value as per
	    $change[0] = (count($checkifminus) > 1)? $checkifminus[1] : $checkifminus[0];
	    //store the minus sign for further
	    $min_sgn = '';
	    $min_sgn = (count($checkifminus) > 1)?'-':'';
	    //catch the last three
	    $lastThree = substr($change[0], strlen($change[0])-3);
	    //catch the other three
	    $ExlastThree = substr($change[0], 0 ,strlen($change[0])-3);
	    //check whethr empty 
	    if($ExlastThree != '')
	        $lastThree = ',' . $lastThree;
	    //replace through regex
	    $res = preg_replace("/\B(?=(\d{2})+(?!\d))/",",",$ExlastThree);
	    //main container num
	    $lst = '';
	    if(isset($change[1]) == ''){
	        $lst =  $min_sgn.$res.$lastThree;
	    } else {
	        $lst =  $min_sgn.$res.$lastThree.".".$change[1];
	    }
	    // special case if equals to 2 then
	    if(strlen($change[0]) === 2){
	        $lst = str_replace(",","",$lst);
	    }
	    return $lst;
	} 
	# Time Difference between Two Dates
	public function TimeDifference($created_at)
	{
		$d = new DateTime();
        $today = $d->format('Y-m-d H:i:s');

        $date1 = new DateTime($created_at);
		$date2 = new DateTime($today);

		$interval = date_diff($date1,$date2);
		$dDiff =  explode(':',$interval->format('%d:%h:%i:%s'));
		
		$ans = array();
		$ans["day"]    = $dDiff[0];
	    $ans["hour"]   = $dDiff[1];
	    $ans["minute"] = $dDiff[2];
	    $ans["second"] = $dDiff[3];

	    $d = new DateTime($created_at);

        if($ans["day"] > 30){
          $timeline = $d->format("F j, Y, g:i a");
        }
        else if($ans["day"] == 1){
          $timeline = $ans["day"].' day ago';
        }
        else if($ans["day"] > 1){
          $timeline = $ans["day"].' days ago';
        }
        else if($ans["hour"] == 1){
          $timeline = $ans["hour"].' hour ago';
        }
        else if($ans["hour"] > 1){
          $timeline = $ans["hour"].' hours ago';
        }
        else if($ans["minute"] > 1){
           $timeline = $ans["minute"].' minutes ago ';
        }
        else {
          $timeline = ' few seconds ago ';
        }
	    return $timeline;
	}
	public function get_referer()
	{
		return $_SERVER['HTTP_REFERER'];
	}
	public function response($data,$status)
	{
		$this->_code = ($status)?$status:200;
		$this->set_headers();
		echo $data;
		exit();	
	}
	public function json($data)
	{
		if( is_array($data) ){
			return json_encode($data);
		}
	}
	private function get_status_message()
	{
		$status = array(
				100 => 'Continue',  
				101 => 'Switching Protocols',  
				200 => 'OK',
				201 => 'Created',  
				202 => 'Accepted',  
				203 => 'Non-Authoritative Information',  
				204 => 'No Content',  
				205 => 'Reset Content',  
				206 => 'Partial Content',  
				300 => 'Multiple Choices',  
				301 => 'Moved Permanently',  
				302 => 'Found',  
				303 => 'See Other',  
				304 => 'Not Modified',  
				305 => 'Use Proxy',  
				306 => '(Unused)',  
				307 => 'Temporary Redirect',  
				400 => 'Bad Request',  
				401 => 'Unauthorized',  
				402 => 'Payment Required',  
				403 => 'Forbidden',  
				404 => 'Not Found',  
				405 => 'Method Not Allowed',  
				406 => 'Not Acceptable',  
				407 => 'Proxy Authentication Required',  
				408 => 'Request Timeout',  
				409 => 'Conflict',  
				410 => 'Gone',  
				411 => 'Length Required',  
				412 => 'Precondition Failed',  
				413 => 'Request Entity Too Large',  
				414 => 'Request-URI Too Long',  
				415 => 'Unsupported Media Type',  
				416 => 'Requested Range Not Satisfiable',  
				417 => 'Expectation Failed',  
				500 => 'Internal Server Error',  
				501 => 'Not Implemented',  
				502 => 'Bad Gateway',  
				503 => 'Service Unavailable',  
				504 => 'Gateway Timeout',  
				505 => 'HTTP Version Not Supported');
		return ($status[$this->_code])?$status[$this->_code]:$status[500];
	}
	public function get_request_method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}
	private function inputs()
	{
		switch($this->get_request_method()){
			case "POST":
				$this->_request = $this->cleanInputs($_POST);
				break;
			case "GET":
			case "DELETE":
				$this->_request = $this->cleanInputs($_GET);
				break;
			case "PUT":
				parse_str(file_get_contents("php://input"),$this->_request);
				$this->_request = $this->cleanInputs($this->_request);
				break;
			default:
				$this->response('',406);
				break;
		}
	}		
	private function cleanInputs($data)
	{
		$clean_input = array();
		if(is_array($data)){
			foreach($data as $k => $v){
				$clean_input[$k] = $this->cleanInputs($v);
			}
		}
		else{
			$clean_input = filter_var($data, FILTER_SANITIZE_STRING);
		}
		return $clean_input;
	}

}	