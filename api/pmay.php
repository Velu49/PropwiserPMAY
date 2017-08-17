<?php
error_reporting(1);
require_once('commonFunction.php');
class Loan extends Pw_calculator 
{
	public function __construct()
    {
		parent::__construct();
	}


	public function pmayeligible($inputs)
	{
		$this->PopulatePMAY();

		$income = $inputs['income'];

		$pmay = $this->PMAYCheck($income);  
        $pmay['family_income'] = $this->IND_money_format($income);
        $pmay['pmay_loan'] = $pmay['subsisy_amount'];
        $pmay['subsisy_amount'] = $this->IND_money_format($pmay['subsisy_amount']);

		return $pmay;
	}

    public function CallAPIs()
    {
        $inputs = json_decode(file_get_contents('php://input'),true);
        $call = $_REQUEST['call'];
        switch ($call) {
            case 'pmayeligible';
            	$result = $this->pmayeligible($inputs);
            	break;
        }
        $output_json = json_encode($result,true);
        echo $output_json;
    }
}

$calc = new Loan;
$calc->CallAPIs();
?>