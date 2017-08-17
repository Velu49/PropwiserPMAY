<?php
error_reporting(1); 
require_once('model.php');
require_once('httpful.phar');
class PW_Calculator extends Model 
{	
	public function __construct()
	{
		parent::__construct();
		$this->PMAYArray = array();
		$this->FOIRslabsArray = array();
		$this->LTVslabsArray = array();
	}	

  	# Current Financial Year month
	public function CurrentFinancialYear()
	{
		$now   = new DateTime();
		$cur_year = $now->format( 'Y' );
		$cur_mon = $now->format( 'm' );
		$cur_d = $now->format( 'd' );
		$st = $cur_year.'-'.$cur_mon.'-01';
		$en = ($cur_mon <= '03') ? ($cur_year.'-03-01') : (($cur_year+1).'-03-01');
		$date1 = new DateTime($st);
		$date2 = new DateTime($en);
		
		$dDiff = $date1->diff($date2);
		$days = $dDiff->days;
		$m = ceil($days / 30);
		
		$fin_month = $calc_months = ($m) ? $m : 1;
		$clone   = new DateTime( $st );
        $clone->modify( '+'.$fin_month.' month' );
        $fy_date = $clone->format( 'Y-m-d' );

		$data = array('start_date' => $st, 'fin_date' => $fy_date ,'fin_month' => $fin_month);
		return $data;
	}

	# Current Financial Year month
	public function FinancialYear()
	{
		$now   = new DateTime();
		$cur_year = $now->format( 'Y' );
		$cur_mon = $now->format( 'm' );
		$st = $cur_year.'-'.$cur_mon.'-01';
		$en = ($cur_mon <= '03') ? ($cur_year.'-03-01') : (($cur_year+1).'-03-01');
		$date1 = new DateTime($st);
		$date2 = new DateTime($en);
		//$interval = date_diff($date1, $date2);
		//$m = ($interval->m + ($interval->y * 12)); 

		$dDiff = $date1->diff($date2);
		$days = $dDiff->days;
		$m = ceil($days / 30);
		
		$fin_month = $calc_months = ($m) ? $m : 1;
		$clone   = new DateTime( $st );
        $clone->modify( '+'.$fin_month.' month' );
        $fy_date = $clone->format( 'Y-m-d' );

		$data = array('today_date' => $fy_date, 'fin_month' => $fin_month);
		return $data;
	}
	
	# Given Date financial Year
	public function dateFinancialYear($date)
	{
		$now   = new DateTime($date);
		$cur_year = $now->format( 'Y' );
		$cur_mon = $now->format( 'm' );
		$st = $cur_year.'-'.$cur_mon.'-01';
		$en = ($cur_mon <= '03') ? ($cur_year.'-03-01') : (($cur_year+1).'-03-01');
		$date1 = new DateTime($st);
		$date2 = new DateTime($en);

		$dDiff = $date1->diff($date2);
		$days = $dDiff->days;
		$m = ceil($days / 30);		
		$fin_month = $calc_months = ($m) ? $m : 1;

		$clone   = new DateTime( $st );
        $clone->modify( '+'.$fin_month.' month' );
        $fy_date = $clone->format( 'Y-m-d' );

		$data = array('start_date' => $st,'end_date' => $en,'fin_date' => $fy_date, 'fin_month' => $fin_month);
		return $data;
	}

	public function CostIndex($year)
	{
		$records = $this->db->prepare("SELECT ci_index FROM tp_adm_costinf WHERE actual_year= :year LIMIT 1");
		$records->bindParam(':year', $year);
		$records->execute();
		if ( $records->rowCount() > 0 ) {
			$row = $records->fetch(PDO::FETCH_ASSOC);
			$ci_index = $row['ci_index'];
		}
		else
			$ci_index = 1;
		return $ci_index;
	}

	public function PopulateLTV()
	{
		if(empty($this->LTVslabsArray)){
			$records = $this->db->prepare("SELECT * FROM tp_adm_ltvslabs");
			$records->execute();
			if ( $records->rowCount() > 0 )
				$row = $records->fetchAll(PDO::FETCH_ASSOC);
			else
				$row = array();	
			$this->LTVslabsArray = $row;
		}
		return $this->LTVslabsArray;		
	}

	public function PopulateFOIR()
	{
		if(empty($this->FOIRslabsArray)){
			$records = $this->db->prepare("SELECT * FROM tp_loanap_scheme_foir");
			$records->execute();
			if ( $records->rowCount() > 0 )
				$row = $records->fetchAll(PDO::FETCH_ASSOC);
			else
				$row = array();	
			$this->FOIRslabsArray = $row;
		}
		return $this->FOIRslabsArray;		
	}

	public function PopulatePMAY()
	{
		if(empty($this->PMAYArray)){
			$records = $this->db->prepare("SELECT * FROM tp_pmay_rule");
			$records->execute();
			if ( $records->rowCount() > 0 )
				$row = $records->fetchAll(PDO::FETCH_ASSOC);
			else
				$row = array();	
			$this->PMAYArray = $row;
		}
		return $this->PMAYArray;		
	}

	public function LTVCheck($owncontribute,$slab) 
	{
		foreach ($this->LTVslabsArray as $key => $oneRow) {
			if($oneRow['slab_type']==$slab){
				if ($oneRow['amount_from'] <= $owncontribute && $oneRow['amount_to'] > $owncontribute ) {
					return $oneRow['percentage'];
				}
			}
		}	
		return 0;
	}

	public function FOIRCheck($income,$ap_emp) 
	{
		foreach ($this->FOIRslabsArray as $key => $oneRow) {
			if($oneRow['employee_type']==$ap_emp){
				if ($oneRow['min_monthly'] < $income && $oneRow['max_monthly'] >= $income ) {
					return $oneRow['foir_percentage'];
				}
			}
		}	
		return 0;
	}

	public function PMAYCheck($income) 
	{
		foreach ($this->PMAYArray as $key => $oneRow) {
				if ($oneRow['income_from'] < $income && $oneRow['income_to'] >= $income ) {
					return $oneRow;
				}
		}	
		return array();
	}

	public function ConvertCurrencytoINR($resd_arr) 
	{
		$resident_country = $resd_arr['resident_country'];
		$income = $resd_arr['income'];
		
		$country = explode('-', $resident_country);
		switch ($country[1]) {
			case 'USD':
				$cur_val = 66;
				break;						
			case 'AED':
				$cur_val = 18;
				break;
			case 'EURO':
				$cur_val = 70;
				break;
			case 'SGD':
				$cur_val = 47;
				break;	
			case 'MYR':
				$cur_val = 15;
				break;
			default:
				$cur_val = 66;
				break;	
		}
		$conv_income = round($income * $cur_val);
		
		return $conv_income;
	}
}