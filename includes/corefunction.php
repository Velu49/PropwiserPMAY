<?php
session_start();
error_reporting(1); 
include_once("define.php");  

$user_id = 0;
$user_type = 0; 
$calc = isset($_GET['calc']) ? $_GET['calc'] : '0'; 

if($calc == 'applyloan') {
    $input_array = array();
    $input_array['user_id'] = $user_id;
    $input_array['user_type'] = $user_type;
    $input_array['pmay_subsidy'] = isset($_POST['pmay_loan']) ? $_POST['pmay_loan'] : 0;
    $input_array['compute_type'] = $_POST['compute_type'];
    $input_array['recompute_flag'] = $_POST['recompute_flag'];

    if($_POST['recompute_flag'] == 1) {
        $input_array['simulate_loan'] = ($_POST['simulate_loan'] != 'undefined') ?  $_POST['simulate_loan']*100000 : 0;
        $input_array['simulate_tenor'] = ($_POST['simulate_tenor'] != 'undefined') ?  $_POST['simulate_tenor'] : 0;
        $input_array['cash_hand'] = ($_POST['cash_hand'] != 'undefined') ?  $_POST['cash_hand'] : 0;
    }
    else  {
        $input_array['simulate_loan'] =  0;
        $input_array['simulate_tenor'] =  0;
        $input_array['cash_hand'] = 0;
    }
   
    $input_array['have_coapplicant'] = (isset($_POST['cp_have'])) ? 1 : 0;

    # Other source
    $input_array['have_othersource'] = (isset($_POST['otherSources'])) ? 1 : 0;
    $input_array['rental_income'] = str_replace(',', '', $_POST['rental_income']);
    $input_array['other_income'] = str_replace(',', '', $_POST['other_income']);

    # Outgoing EMI
    $input_array['have_outgoingemi'] = (isset($_POST['emi_available'])) ? 1 : 0;
    $input_array['outgoing_emi'] = str_replace(',', '', $_POST['outgoingemi']);
    
    # Property Identify
    $input_array['have_propidentify'] = (isset($_POST['property_identified'])) ? $_POST['property_identified'] : 0;
    $input_array['project_name'] = $_POST['project_name'];
    $input_array['property_price'] = str_replace(',', '', $_POST['property_price']);

    # Primary Applicant
    $ap_arr = array();
    $ap_arr['ap_name'] = $_POST['ap_name'];
    $ap_arr['ap_age'] = $_POST['ap_age'];
    $ap_arr['ap_resident'] = $_POST['ap_resident'];
    $ap_arr['ap_city'] = $_POST['ap_city'];
    $ap_arr['ap_residentcountry'] = (isset($_POST['ap_residentcountry'])) ? $_POST['ap_residentcountry'] : 0;
    $ap_arr['ap_emptype'] = $_POST['ap_emptype'];
    $ap_arr['ap_grossincome'] = str_replace(',', '', $_POST['ap_grossincome']);
    $ap_arr['ap_netincome'] = str_replace(',', '', $_POST['ap_netincome']);
    $ap_arr['ap_grossprofit'] = str_replace(',', '', $_POST['ap_grossprofit']);
    $ap_arr['ap_netprofit'] = str_replace(',', '', $_POST['ap_netprofit']);
    $ap_arr['ap_turnover'] = str_replace(',', '', $_POST['ap_turnover']);
    $ap_arr['ap_companyname'] = $_POST['ap_companyname'];
    $ap_arr['ap_companytype'] = $_POST['ap_companytype'];
    $ap_arr['ap_workingsince_mm'] = $_POST['ap_workingsince_mm'];
    $ap_arr['ap_workingsince_yy'] = $_POST['ap_workingsince_yy'];
    $ap_arr['ap_expyear'] = $_POST['ap_expyear'];
    $ap_arr['ap_expmonth'] = $_POST['ap_expmonth'];
    $ap_arr['ap_profession'] = $_POST['ap_profession'];
    $ap_arr['ap_currency'] = $_POST['ap_currency'];

    # Co-Applicant
    $coap_arr = array();
    if($input_array['have_coapplicant'] == 1) {
        $coap_arr['cp_name'] = $_POST['cp_name'];
        $coap_arr['cp_age'] = $_POST['cp_age'];
        $coap_arr['cp_resident'] = $_POST['cp_resident'];
        $coap_arr['cp_city'] = $_POST['cp_city'];
        $coap_arr['cp_residentcountry'] = (isset($_POST['cp_residentcountry'])) ? $_POST['cp_residentcountry'] : 0;
        $coap_arr['cp_emptype'] = $_POST['cp_emptype'];
        $coap_arr['cp_outgoingemi'] = str_replace(',', '', $_POST['cp_outgoingemi']);
        $coap_arr['cp_grossincome'] = str_replace(',', '', $_POST['cp_grossincome']);
        $coap_arr['cp_netincome'] = str_replace(',', '', $_POST['cp_netincome']);
        $coap_arr['cp_grossprofit'] = str_replace(',', '', $_POST['cp_grossprofit']);
        $coap_arr['cp_netprofit'] = str_replace(',', '', $_POST['cp_netprofit']);
        $coap_arr['cp_turnover'] = str_replace(',', '', $_POST['cp_turnover']);
        $coap_arr['cp_companyname'] = $_POST['cp_companyname'];
        $coap_arr['cp_companytype'] = $_POST['cp_companytype'];
        $coap_arr['cp_workingsince_mm'] = $_POST['cp_workingsince_mm'];
        $coap_arr['cp_workingsince_yy'] = $_POST['cp_workingsince_yy'];
        $coap_arr['cp_expyear'] = $_POST['cp_expyear'];
        $coap_arr['cp_expmonth'] = $_POST['cp_expmonth'];
        $coap_arr['cp_profession'] = $_POST['cp_profession'];
        $coap_arr['cp_currency'] = $_POST['cp_currency'];
    }
    
    # Co-applicant Details
    $user_data = [
        'applicant' => $ap_arr,
        'co_applicant' => $coap_arr
    ];
    $input_array['user_data'] = $user_data;
    $json_encoded_array = json_encode($input_array,true);


     // print_r($json_encoded_array);
     // return false;

    $url = API_URL.'homeloan.php?call=applyforloan';
    $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($json_encoded_array)
        ->send();
    // print_r($response->body);
    // return false;
    
    $output = json_decode($response->body,true);

    $user_id = $output['user_id'];
    $user_type = $output['user_type'];
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_type'] = $user_type;

    $result = [
        "userid" =>  $user_id,
        'result' => $output
    ];
    echo json_encode($result,true);
    return false;
}
else if($calc == 'boosterplan') {
    $data_arr = [
        'emi_eligible' => $_POST['emi_eligible'],
        'int_rate' => $_POST['int_rate'],
        'final_loan' => $_POST['final_loan'],
        'max_tenure' => $_POST['max_tenure'],
        'interest_period' => $_POST['interest_period'],
        'booster_income' => $_POST['income']
    ];
    $json_encoded_array = json_encode($data_arr,true);
    
    $url = API_URL.'homeloan.php?call=boosterplan';
    $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($json_encoded_array)
        ->send();
    
    $output = $response->body;
    echo $output;
    return false;
}
else if($calc == 'shortandsweet') {
    $data_arr = [
        'emi_eligible' => $_POST['emi_eligible'],
        'int_rate' => $_POST['int_rate'],
        'final_loan' => $_POST['final_loan'],
        'max_tenure' => $_POST['max_tenure'],
        'recur_deposit' => $_POST['recur_deposit'],
        'avg_balance' => $_POST['avg_balance']
    ];
    $json_encoded_array = json_encode($data_arr,true);

    $url = API_URL.'homeloan.php?call=shortsweet';
    $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($json_encoded_array)
        ->send();
    
    $output = $response->body;
    echo $output;
    return false;
}
else if($calc == 'maxsaver') {
    $data_arr = [
        'simple_share' => $_POST['simple_share'],
        'shortswt_share' => $_POST['shortswt_share'],
        'emi_eligible' => $_POST['emi_eligible'],
        'int_rate' => $_POST['int_rate'],
        'final_loan' => $_POST['final_loan'],
        'max_tenure' => $_POST['max_tenure'],
        'recur_deposit' => $_POST['recur_deposit'],
        'avg_balance' => $_POST['avg_balance']
    ];
    $json_encoded_array = json_encode($data_arr,true);

    $url = API_URL.'homeloan.php?call=maxsaver';
    $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($json_encoded_array)
        ->send();
    
    $output = $response->body;
    echo $output;
    return false;
}
else if($calc == 'bhamasadetails')
{
    # Family Details
        $bhamasa_id = $_POST['bhamasa_id']; //1067-7PVQ-28383

        $url = 'https://apitest.sewadwaar.rajasthan.gov.in/app/live/Service/family/details/'.$bhamasa_id.'?client_id=ad7288a4-7764-436d-a727-783a977f1fe1';

        $response = \Httpful\Request::get($url)
            ->sendsJson()
            ->send();

        $output = $response->body;

        $result = json_encode($response->body, true);

        echo $result;

        if(isset($response->body->hof_Details)) {
            $data = array();
            $data[0] = $response->body->hof_Details;

            $temp = array();
            foreach ($response->body->family_Details as $key => $res) {
                $temp[strtotime($res->DOB)] = $res;
            }
            krsort($temp);
            foreach ($temp as $i => $value) {
                $data[$i+1] = $value;
            }
            //echo $result;
        }
        else {
            echo 0;
        }
        
        return true;
}
else if($calc == 'pmayeligible') {
    $data_arr = [
        'income' => $_POST['income']
    ];
    $json_encoded_array = json_encode($data_arr,true);

    $url = API_URL.'pmay.php?call=pmayeligible';
    $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($json_encoded_array)
        ->send();
    
    $output = $response->body;
    echo $output;
    return false;
}
?>