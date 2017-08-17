<?php
session_start();

date_default_timezone_set('Asia/Kolkata');

define("BASE_URL","http://localhost/hackathon/");
define("API_URL","http://localhost/hackathon/api/");

$redirect_url = 'dashboard.php';

include_once("httpful.phar");

# Money Format comma(,)
function IND_money_format($num){
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

# Price to String format
function price_to_string($price) {	
	$sign = 1;
    if($price < 0 ) {
      $sign = -1;
      $price = ($price * -1);
    }

    if ($price >= 10000000 ) {  
        $price = ($price / 10000000) * $sign;
        return round($price,1). ' crore';
    } 
    else if ($price >= 100000 ) {  
        $price = ($price / 100000) * $sign;
        if($price > 1)
          $text = ' lakhs';
        else
          $text = ' lakh';
        return round($price,0). $text;
     } 
    else if ($price >= 1000) {  
        $price = ($price / 1000) * $sign;
            if ($price < 10) {
                return $price.toFixed(1)+" K";
            }
        return round($price,0)."K";
    }
    return ($price * $sign);
}


?>