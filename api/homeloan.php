<?php
error_reporting(1);
require_once('commonFunction.php');
require_once('ruleengine.php');
class Loan extends Pw_calculator 
{
	public function __construct()
    {
		parent::__construct();
	}

	public function parsingInputData($inputs) 
    {
        $trans_actype = 9; # Loan Marketplace
        $user_id = $inputs['user_id'];
        $cash_hand = isset($inputs['cash_hand']) ? $inputs['cash_hand'] : 0;
        $property_price = isset($inputs['property_price']) ? $inputs['property_price'] : 0;

        $d = new DateTime();
        $dt =$d->format('Y-m-d H:i:s');
        
        $transaction_id = 0;
        
        # Primary User Datails for Rule 'pass' / 'fail'
        $userarr = $inputs['user_data']['applicant'];
        $age = $userarr['ap_age'];
        $emp_type = $userarr['ap_emptype'];
        if($emp_type == 1) {
            $income = $userarr['ap_netincome'];
        }
        else {
            $income = $userarr['ap_netprofit'];
        }
        $city_tier = 1;
        $gender = 1;
        $exp = 5;
        $totexp = 5;

        # Rule Result - Loan Application Pre-approval
        $table_ruleresult = $this->loan_ruleresult_table;

        $this->coreDelete($table_ruleresult);

        $table = $this->loan_rule_table;
        $where = [
            [
                'field' => 'bank_id',
                'condition' => '=',
                'value' => 2 # IDFC Bank
            ]
        ];
        $rule_master = $this->coreSelect($table, $fields = '*', $where);

        foreach ($rule_master as $key => $rule) {
            $rule_id = $rule['id'];
            $bank_id = $rule['bank_id'];
            $product_id = $rule['product_id'];
            $scheme_id = $rule['scheme_id'];
            $rule_type = $rule['rule_type'];
            $rule_query = $rule['rule'];
            $fail_message = $rule['fail_message'];

            $rule_query = str_replace("#age", $age, $rule_query);
            $rule_query = str_replace("#emptype", $emp_type, $rule_query);
            $rule_query = str_replace("#citytier", $city_tier, $rule_query);
            $rule_query = str_replace("#income", $income, $rule_query);
            $rule_query = str_replace("#gender", $gender, $rule_query);
            //$rule_query = str_replace("#exp", $exp, $rule_query);
            //$rule_query = str_replace("#totexp", $totexp, $rule_query);

            $dual = $this->coreDualSelect($rule_query);
            $rule_status = ($dual['output'] == 'p') ? 1 : 0;

            $rule_arr = [
                'transaction_id' => $transaction_id,
                'rule_id' => $rule_id,
                'bank_id' => $bank_id,
                'product_id' => $product_id,
                'scheme_id' => $scheme_id,
                'rule_type' => $rule_type,
                'rule_status' => $rule_status,
                'fail_message' => $fail_message
            ];

            # Insert into Rule Result table
            $this->coreInsert($table_ruleresult, $rule_arr);
        }

        $response = [
            'transaction_id' => $transaction_id,
            'user_id' =>$user_id
        ];
        return $response;
    }

    # Booster Home Loan
    public function BoosterPlan($data)
    {
        $this->PopulateFOIR();
        $income_incr = 4.7;
        $emi_eligible = $data['emi_eligible'];
        $int_rate = $data['int_rate'];
        $max_tenure = $data['max_tenure'];
        $interest_period = $data['interest_period'];
        $actual_loan = $data['final_loan'];
        $income = $data['booster_income'];

        $booster_income = ($income * pow((1+($income_incr/100)),$interest_period/12));
        $foir = $this->FOIRCheck($booster_income,1);  

        $booster_emi_elig = round(($foir * $booster_income)/100); 
        $booster_loan_elig = round(($booster_emi_elig * (1-pow((1 + ($int_rate/1200)),-($max_tenure))))/($int_rate/1200));

        //$booster_loan_elig = round(($emi_eligible / ($int_rate/12)) * 100);
        //$booster_emi_elig = round(($booster_loan_elig * ($int_rate/1200)) / (1-pow((1 + ($int_rate/1200)),-($max_tenure - $interest_period) )));
        
        $booster_increase = ($booster_loan_elig - $actual_loan);
        $booster_increase_perc = round((($booster_increase/$actual_loan) * 100),1);
        $booster_arr = [
            'actual_emi' => $this->IND_money_format($emi_eligible),
            'actual_tenor' => $max_tenure,
            'actual_int_rate' => $int_rate,
            'actual_loan' => $this->IND_money_format($actual_loan),
            'booster_income' => $income,
            'booster_emi' => $this->IND_money_format($booster_emi_elig),
            'booster_loan' => $this->IND_money_format($booster_loan_elig),
            'booster_increase' => $this->IND_money_format($booster_increase),
            'booster_percentage' => $booster_increase_perc,
            'emi_roundoff' => $emi_eligible,
            'loan_lks' => number_format((float)$booster_loan_elig/100000, 2, '.', ''),
            'max_loan_elig' => $this->IND_money_format($booster_loan_elig)
        ];
        return $booster_arr;
    }

    # Short & Sweet Home Loan
    public function ShortSweetPlan($data)
    {
        $avg_balance = $data['avg_balance'];
        $recur_deposit = $data['recur_deposit'];
        $emi_eligible = $data['emi_eligible'];
        $int_rate = $data['int_rate'];
        $max_tenure = $data['max_tenure'];
        $final_loan = $data['final_loan'];
        
        $from_obj = new DateTime();
        $clone = clone $from_obj;
        $from_obj = $from_obj->modify('-1 month');
        $from_date = $from_obj->format('Y-m-d'); 
        $to_date = $clone->format('Y-m-d');

        $savings = $total_int_normal = $total_int_shsw = 0;
        $actual_tenor = 0;
        $princ_os_normal = $final_loan;
        $princ_os_shsw = ($final_loan - $avg_balance);
        for ($t=0; $t < $max_tenure; $t++) { 
            if($t != 0) {
                $date1 = new DateTime($from_date);
                $date2 = new DateTime($to_date);
                $dDiff = $date1->diff($date2);
                $days_int = $dDiff->days;

                # Normal Case
                $int_comp_normal = round(($princ_os_normal * ($int_rate/36500)) * $days_int);
                $int_comp_normal = ($int_comp_normal > 0) ? $int_comp_normal : 0;
                $princ_comp_normal = ($emi_eligible - $int_comp_normal);
                $princ_os_normal = ($princ_os_normal - $princ_comp_normal);
                $princ_os_normal = ($princ_os_normal > 0) ? $princ_os_normal : 0;

                # Short & Sweet Case
                $savings += $recur_deposit;
                $int_comp_shsw = round((($princ_os_shsw - $savings) * ($int_rate/36500)) * $days_int);
                $int_comp_shsw = ($int_comp_shsw > 0) ? $int_comp_shsw : 0;
                $princ_comp_shsw = round($emi_eligible - $int_comp_shsw);
                $princ_os_shsw = round($princ_os_shsw - $princ_comp_shsw);
                $princ_os_shsw = ($princ_os_shsw > 0) ? $princ_os_shsw : 0;

                $total_int_normal += $int_comp_normal;
                $total_int_shsw += $int_comp_shsw;

                $arr[$t-1] = [
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                    'days_int' => $days_int,
                    'princ_n' => $princ_os_normal,
                    'princ_s' => $princ_os_shsw
                ];

                $from_date = $to_date;
                $to_obj = new DateTime($to_date);
                $to_obj = $to_obj->modify('+1 month');
                $to_date = $to_obj->format('Y-m-d');

            }

            if($princ_os_shsw > 0)
                $actual_tenor++;
        }
        $total_int_saved = ($total_int_normal - $total_int_shsw);
        $int_rate_saved = round((($total_int_saved / $total_int_normal) * $int_rate),2);
        $actual_int_rate = ($int_rate - $int_rate_saved);
        $tenor_saved = $max_tenure - $actual_tenor;
        $perc = round((($total_int_saved/$total_int_normal)*$int_rate),2);
        $interest_percentage = $int_rate - $perc; 

        $shortsweet_arr = [
            'actual_emi' => $this->IND_money_format($emi_eligible),
            'actual_tenor' => $max_tenure,
            'actual_int_rate' => $int_rate,
            'actual_loan' => $this->IND_money_format($final_loan),
            'simple_interest_paid' => $this->IND_money_format($total_int_normal),
            'shortswt_interest_paid' => $this->IND_money_format($total_int_shsw),
            'interest_amount_saved' => $this->IND_money_format($total_int_saved),
            'interest_rate_saved' => $int_rate_saved,
            'reduced_tenor' => $actual_tenor,
            'tenor_saved' => $tenor_saved,
            'interest_percentage' => $interest_percentage,
            'emi_roundoff' => $emi_eligible,
            'loan_lks' => number_format((float)$final_loan/100000, 2, '.', ''),
            'max_loan_elig' => $this->IND_money_format($final_loan)
        ];
        return $shortsweet_arr;
    }

    # Max Saver
    public function MaxSaver($data) 
    {
        $simple_share = $data['simple_share'];
        $shortswt_share = $data['shortswt_share'];
        $avg_balance = $data['avg_balance'];
        $recur_deposit = $data['recur_deposit'];
        $emi_eligible = $data['emi_eligible'];
        $int_rate = $data['int_rate'];
        $max_tenure = $data['max_tenure'];
        
        $final_loan = $data['final_loan'];
        $simple_loan = round(($simple_share/100) * $final_loan);
        $shortswt_loan = round(($shortswt_share/100) * $final_loan);

        $simple_emi = round(($simple_loan * ( $int_rate/1200 )) / (1-pow((1 + ($int_rate/1200)),-$max_tenure)));
        $shortswt_emi = round(($shortswt_loan * ( $int_rate/1200 )) / (1-pow((1 + ($int_rate/1200)),-$max_tenure)));
        
        $from_obj = new DateTime();
        $clone = clone $from_obj;
        $from_obj = $from_obj->modify('-1 month');
        $from_date = $from_obj->format('Y-m-d'); 
        $to_date = $clone->format('Y-m-d');

        $actual_tenor = 0;
        $savings = $total_int_normal = $total_int_simple = $total_int_shsw = 0;

        $princ_os_normal = $final_loan;
        $princ_os_simple = $simple_loan;
        $princ_os_shsw = ($shortswt_loan - $avg_balance);

        for ($t=0; $t < $max_tenure; $t++) { 
            if($t != 0) {
                $date1 = new DateTime($from_date);
                $date2 = new DateTime($to_date);
                $dDiff = $date1->diff($date2);
                $days_int = $dDiff->days;

                # No Sharing 100% Simple Loan Amount 
                $int_comp_normal = round(($princ_os_normal * ($int_rate/36500)) * $days_int);
                $int_comp_normal = ($int_comp_normal > 0) ? $int_comp_normal : 0;
                $princ_comp_normal = ($emi_eligible - $int_comp_normal);
                $princ_os_normal = ($princ_os_normal - $princ_comp_normal);
                $princ_os_normal = ($princ_os_normal > 0) ? $princ_os_normal : 0;

                # Simple Loan - Share 
                $int_comp_simple = round(($princ_os_simple * ($int_rate/36500)) * $days_int);
                $int_comp_simple = ($int_comp_simple > 0) ? $int_comp_simple : 0;
                $princ_comp_simple = ($simple_emi - $int_comp_simple);
                $princ_os_simple = ($princ_os_simple - $princ_comp_simple);
                $princ_os_simple = ($princ_os_simple > 0) ? $princ_os_simple : 0;

                # Short & Sweet - Loan Share
                $savings += $recur_deposit;
                $int_comp_shsw = round((($princ_os_shsw - $savings) * ($int_rate/36500)) * $days_int);
                $int_comp_shsw = ($int_comp_shsw > 0) ? $int_comp_shsw : 0;
                $princ_comp_shsw = round($shortswt_emi - $int_comp_shsw);
                $princ_os_shsw = round($princ_os_shsw - $princ_comp_shsw);
                $princ_os_shsw = ($princ_os_shsw > 0) ? $princ_os_shsw : 0;

                $total_int_normal += $int_comp_normal;
                $total_int_simple += $int_comp_simple;
                $total_int_shsw += $int_comp_shsw;

                $from_date = $to_date;
                $to_obj = new DateTime($to_date);
                $to_obj = $to_obj->modify('+1 month');
                $to_date = $to_obj->format('Y-m-d');
            }

            if($princ_os_shsw > 0) {
                $actual_tenor++;
            }
        }

        $tenor_saved = $max_tenure - $actual_tenor;

        $int_w_maxsaver = ($total_int_simple + $total_int_shsw);
        $int_wo_maxsaver = $total_int_normal;
        $total_int_saved = ($int_wo_maxsaver - $int_w_maxsaver);

        $int_rate_saved = round((($total_int_saved / $int_wo_maxsaver) * $int_rate),2); 
        $actual_int_rate = ($int_rate - $int_rate_saved);        
        
        $eff_int_rate = (($simple_loan * ($int_rate/100) + ($shortswt_loan * ($actual_int_rate/100))) / ($simple_loan+$shortswt_loan));
        $eff_int_rate = round($eff_int_rate * 100,2);

        $maxsaver_arr = [
            'actual_emi' => $this->IND_money_format($emi_eligible),
            'actual_tenor' => $max_tenure,
            'actual_int_rate' => $int_rate,
            'actual_loan' => $this->IND_money_format($final_loan),
            'emi_roundoff' => $emi_eligible,
            'simple_emi' => $this->IND_money_format($simple_emi),
            'shortswt_emi' => $this->IND_money_format($shortswt_emi),
            'simple_loan' => $this->IND_money_format($simple_loan),
            'shortswt_loan' => $this->IND_money_format($shortswt_loan),
            'total_int_simple' => $total_int_simple,
            'total_int_shsw' => $total_int_shsw,
            'total_interest_paid' => $this->IND_money_format($int_wo_maxsaver),
            'maxsaver_interest_paid' => $this->IND_money_format($int_w_maxsaver),
            'interest_saved' => $this->IND_money_format($total_int_saved),
            'reduced_tenor' => $actual_tenor,
            'tenor_saved' => $tenor_saved,
            'interest_rate_saved' => $int_rate_saved,
            'effective_int_rate' => $eff_int_rate ,
            'loan_lks' => number_format((float)$final_loan/100000, 2, '.', ''),
            'max_loan_elig' => $this->IND_money_format($final_loan)           
        ];
        return $maxsaver_arr;
    }

    public function applyforloan($inputs) 
    {       
        # LTV Slabs for Loan 
        $this->PopulateLTV();
        $this->PopulateFOIR();
        $this->PopulatePMAY();

        $pmay_subsidy =isset($inputs['pmay_subsidy']) ? $inputs['pmay_subsidy'] : 0;

        # Slider Values
        $compute_type = $inputs['compute_type'];
        $recompute_flag = $inputs['recompute_flag'];
        $simulate_loan = $inputs['simulate_loan'];
        $simulate_tenor = $inputs['simulate_tenor'];
        $cash_hand_lks = $inputs['cash_hand'];
        $cash_hand = ($cash_hand_lks * 100000);
        
        $have_coapplicant = $inputs['have_coapplicant']; #single or join

        $property_price = 0;
        $have_propidentify = $inputs['have_propidentify']; #single or join
        if($have_propidentify == 1) {
            $property_price = $inputs['property_price'];
        }

        $other_income = 0;
        $have_othersource = $inputs['have_othersource'];
        if($have_othersource) {
            # Only Consider 50% of other income
            $other_income = $inputs['other_income'] + $inputs['rental_income'];
            $other_income = ($have_coapplicant) ? ($other_income/4) : ($other_income / 2);
        }
        $outgoing_emi = 0;
        $have_outgoingemi = $inputs['have_outgoingemi'];
        if($have_outgoingemi) {
            $outgoing_emi = $inputs['outgoing_emi'];
            $outgoing_emi = ($have_coapplicant) ? ($outgoing_emi/2) : $outgoing_emi;
        }
        $inputs['other_income'] = $other_income;
        $inputs['outgoing_emi'] = $outgoing_emi;

        # Inserts Inputs to DB
        $response = $this->parsingInputData($inputs);
        $user_id = $response['user_id'];
        $transaction_id = $response['transaction_id'];

        # Primary User Details First Applicant
        $applicant_arr = $inputs['user_data']['applicant'];
        $coapplicant_arr = $inputs['user_data']['coapplicant'];

        $income = ($applicant_arr['ap_emptype'] == 1) ? $applicant_arr['ap_netincome'] : ($applicant_arr['ap_netprofit']/12);
        if($have_coapplicant == 1) {
            $income += ($coapplicant_arr['cp_emptype'] == 1) ? $coapplicant_arr['cp_netincome'] : ($coapplicant_arr['cp_netprofit']/12);
        }
        $primary_user = [
            'transaction_id' => $transaction_id,
            'age' => $applicant_arr['ap_age'],
            'emp_type' => $applicant_arr['ap_emptype'],
            'income' => $income,
            'gender' => 1
        ];

        # Rule Engine Evluation
        $sch_result_arr = $matched_arr = $unmatched_arr =  array();
        $cust_loan_arr = $cust_emi_arr = $cust_tenor_arr = $cust_int_arr = array();
        $s = 0;

        $rule_engine = Engine::RuleEvaluation($primary_user);
        //return $rule_engine;
        if($rule_engine) {
            foreach ($rule_engine as $v => $rule) {
                $bankarr = $rule['bank_arr'];
                $productarr = $rule['product_arr'];
                $arr = $rule['scheme_arr'];
                $unmatched = 0;
                $booster_flag = 1;
                # Scheme wise Affordability
                if($arr) {
                    $scheme_id = $arr['id'];
                    $plan_type = $arr['plan_type']; # Simple / Booster / Short & Sweet 
                    $scheme_name = $arr['scheme_name'];
                    $min_loan = $arr['min_loan'];
                    $max_loan = $arr['max_loan'];
                    $min_tenure = $arr['min_tenure'];

                    if($simulate_tenor !=0){
                    $max_tenure =$simulate_tenor;

                     }else {
                    $max_tenure = $arr['max_tenure'];
                    }

                    $min_int_rate = $arr['min_interest_rate'];
                    $int_rate = $max_int_rate = $arr['max_interest_rate'];
                    $ltv_reduction = $arr['ltv_reduction'];
                    $interest_period = $arr['interest_period']; # months for Booster Plan                
                    $curyr_multiplier = $arr['cur_year_multiplier'];
                    $prevyr_multiplier = $arr['perv_year_multiplier'];
                    $avg_multiplier = $arr['average_multiplier'];

                    # Calculation
                    $income_eligible = $annual_profit_prev = 0;
                    $depreci_curyr = $depreci_prevyr = 0;

                    $age = ($applicant_arr['ap_age']) ? $applicant_arr['ap_age'] : 0;
                    $ap_employee_type = $employee_type = $applicant_arr['ap_emptype'];  # Salaried or Selfemployed
                    $resident_status = $applicant_arr['ap_resident'];
                    $resident_country = $applicant_arr['ap_residentcountry'];  
                   
                    # Salaried
                    if($employee_type == 1) {
                        $gross_income = $applicant_arr['ap_grossincome'];
                        $net_income = $applicant_arr['ap_netincome'];

                        $reqular_income = ( $net_income);
                        # NRI
                        if($resident_status == 1) {
                            $income_eligible +=  ($reqular_income + $other_income);
                        }
                        else {
                            $resd_arr = [
                                'resident_country' => $resident_country,
                                'income' => $net_income
                            ];
                            $net_income = $this->ConvertCurrencytoINR($resd_arr);
                            $income_eligible +=  round(( $net_income * 65) + $other_income);
                        }
                    }
                    # Self Employed Professional & non Prof
                    else {
                        $annual_grossprofit = $applicant_arr['ap_grossprofit'];
                        $annual_profit = $applicant_arr['ap_netprofit'];

                        if($resident_status == 2) {
                            $resd_arr = [
                                'resident_country' => $resident_country,
                                'income' => $net_income
                            ];
                            $annual_profit = $this->ConvertCurrencytoINR($resd_arr);
                        }

                        $profit = round(((($annual_profit + $annual_profit_prev) - ($depreci_curyr + $depreci_prevyr))/12));

                        $cur_yr = round($curyr_multiplier * ($annual_profit - $depreci_curyr));
                        $prev_yr = round($prevyr_multiplier * ($annual_profit_prev - $depreci_prevyr));

                        $income_eligible += round(($avg_multiplier * (($cur_yr + $prev_yr)))/12) + $other_income;
                    }

                    # Co-applicant Details
                    if($have_coapplicant == 1) {
                        $age = ($coapplicant_arr['cp_age']) ? $coapplicant_arr['cp_age'] : 0;
                        $cp_employee_type = $employee_type = $coapplicant_arr['cp_emptype'];  # Salaried or Selfemployed
                        $resident_status = $coapplicant_arr['cp_resident'];
                        $resident_country = $coapplicant_arr['cp_residentcountry'];  
                        
                        # Salaried
                        if($employee_type == 1) {
                            $gross_income = $coapplicant_arr['cp_grossincome'];
                            $net_income = $coapplicant_arr['cp_netincome'];

                            $reqular_income = ( $net_income );
                            if($resident_status == 1) {
                                $income_eligible +=  ($reqular_income + $other_income);
                            }
                            else {
                                # NRI
                                $resd_arr = [
                                    'resident_country' => $resident_country,
                                    'income' => $net_income
                                ];
                                $net_income = $this->ConvertCurrencytoINR($resd_arr);
                                $income_eligible +=  round(( $net_income * 65) + $other_income);
                            }
                        }
                        # Self Employed Professional & non Prof
                        else {
                            $annual_grossprofit = $coapplicant_arr['cp_grossprofit'];
                            $annual_profit = $coapplicant_arr['cp_netprofit'];
                            if($resident_status == 2) {
                                $resd_arr = [
                                    'resident_country' => $resident_country,
                                    'income' => $net_income
                                ];
                                $annual_profit = $this->ConvertCurrencytoINR($resd_arr);
                            }

                            $profit = round(((($annual_profit + $annual_profit_prev) - ($depreci_curyr + $depreci_prevyr))/12));

                            $cur_yr = round($curyr_multiplier * ($annual_profit - $depreci_curyr));
                            $prev_yr = round($prevyr_multiplier * ($annual_profit_prev - $depreci_prevyr));

                            $income_eligible += round(($avg_multiplier * (($cur_yr + $prev_yr)))/12) + $other_income;
                        }
                    }

                    # FOIR Slabs
                    $foir = $arr['foir_value'];
                    $foir_type = $arr['foir_type'];
                    $foir = $this->FOIRCheck($income_eligible,$ap_employee_type);  

                    # Simple/Standard Loan Calculation
                    $emi_eligible = round((($foir * $income_eligible)/100) - $outgoing_emi); 

                    $loan_eligible_income = round(($emi_eligible * (1-pow((1 + ($int_rate/1200)),-$max_tenure)))/($int_rate/1200)); 


                    
                    $final_loan = min($max_loan, $loan_eligible_income);

                    # If Property Identified
                    if($have_propidentify == 1) {

                        $loanltv = $this->LTVCheck($final_loan,4);
                        $loan_elig_prop = (($loanltv / 100) * $property_price);

                        if($loan_eligible_income >= $loan_elig_prop) {
                            $booster_flag = 0;
                        }
                        

                        $final_loan = min($loan_eligible_income,$loan_elig_prop);
                        if($simulate_loan != 0 && $simulate_loan < $final_loan) {   
                            $final_loan = $simulate_loan;

                            if($loan_eligible_income >= $simulate_loan) {
                                $booster_flag = 0;
                            }

                            }
                        else if($simulate_loan != 0){
                            $unmatched = 1;   
                        }
                        
                        $emi_eligible = round(($final_loan * ($int_rate/1200)) / (1-pow((1 + ($int_rate/1200)),-$max_tenure )));
                    }
                    else {

                        if($cash_hand != 0 && $compute_type == 2) {
                            $ltv = $this->LTVCheck($final_loan,3);
                            $final_loan = round(($ltv / (100 - $ltv)) * $cash_hand);
                        }
                        else {

                             if($simulate_loan != 0 && $simulate_loan < $final_loan) {   
                                $final_loan = $simulate_loan;

                                if($loan_eligible_income >= $simulate_loan) {
                                    $booster_flag = 0;
                                }

                            }
                            else if($simulate_loan != 0 && $simulate_loan > $final_loan){
                                $booster_flag = 1;
                                $unmatched = 1; 
                            }
                       
                        }  

                        if($simulate_loan !=0 || $cash_hand !=0) {
                        
                            $emi_eligible = round(($final_loan * ($int_rate/1200)) / (1-pow((1 + ($int_rate/1200)),-$max_tenure )));
                        
                        }
                        
                    }

                    if($plan_type == '1') {
                        # Simple Loan
                        $loan_arr = [
                            'actual_emi' => $this->IND_money_format($emi_eligible),
                            'actual_tenor' => $max_tenure,
                            'actual_int_rate' => $int_rate,
                            'actual_loan' => $this->IND_money_format($final_loan),
                            'emi_roundoff' => $emi_eligible,
                            'loan_lks' => number_format((float)$final_loan/100000, 2, '.', ''),
                            'max_loan_elig' => $this->IND_money_format($final_loan) 
                        ];
                        $plan_name = 'Simple Loan';
                    }
                    else if($plan_type == '2') {
                        $interest_period = 36;
                        $income_incr = 4.7;
                        
                        # Booster Loan Calculation
                        if($booster_flag == 0) {
                            $unmatched = 1;
                            $final_loan = $loan_eligible_income;
                            $emi_eligible = round(($final_loan * ($int_rate/1200)) / (1-pow((1 + ($int_rate/1200)),-$max_tenure )));
                        }else {
                            $unmatched =0;
                        }
                        
                        
                        $data_arr = [
                            'emi_eligible' => $emi_eligible,
                            'int_rate' => $int_rate,
                            'final_loan' => $final_loan,
                            'max_tenure' => $max_tenure,
                            'interest_period' => $interest_period,
                            'foir' =>$foir,
                            'booster_income' => $income_eligible
                        ];
                        $loan_arr = $this->BoosterPlan($data_arr);
                        $plan_name = 'Booster Plan'; # IDFC
                        //$plan_name = 'Flexipay'; # SBI  

                        $emi_eligible = str_replace(',', '', $loan_arr['booster_emi']);
                        $final_loan = str_replace(',', '', $loan_arr['booster_loan']); 
                        //$loan_arr['actual_loan'] = $loan_arr['booster_loan']; 
                    }
                    else if($plan_type == '3') {
                        # Short & Sweet Loan Calculation
                        $recur_deposit = 10000;
                        $data_arr = [
                            'emi_eligible' => $emi_eligible,
                            'int_rate' => $int_rate,
                            'final_loan' => $final_loan,
                            'max_tenure' => $max_tenure,
                            'recur_deposit' => $recur_deposit,
                            'avg_balance' => 0,
                        ];
                        $loan_arr = $this->ShortSweetPlan($data_arr);
                        $plan_name = 'Short & Sweet'; # IDFC
                        //$plan_name = 'MaxGain'; # SBI
                        //$max_tenure = str_replace(',', '', $loan_arr['reduced_tenor']); 
                    }
                    else if($plan_type == '4') {
                        # Max Saver Loan
                        $recur_deposit = 10000;
                        $simple_share = 30;
                        $shortswt_share = 70;
                        $data_arr = [
                            'emi_eligible' => $emi_eligible,
                            'int_rate' => $int_rate,
                            'final_loan' => $final_loan,
                            'max_tenure' => $max_tenure,
                            'recur_deposit' => $recur_deposit,
                            'avg_balance' => 0,
                            'simple_share' => $simple_share,
                            'shortswt_share' => $shortswt_share
                        ];
                        $loan_arr = $this->MaxSaver($data_arr);
                        $plan_name = 'MaxSaver'; # IDFC
                        //$max_tenure = str_replace(',', '', $loan_arr['reduced_tenor']); 
                    }

                    # For Filter Range   
                    if($unmatched == 0) {  
                        array_push($cust_loan_arr, number_format((float)$final_loan/100000, 2, '.', '')); 
                        array_push($cust_emi_arr, $emi_eligible); 
                    }
                    $cust_tenor_arr[$s] = $max_tenure;
                    $cust_int_arr[$s] = $int_rate;

                    if($have_propidentify == 1 && $unmatched == 0) {
                        $oc_req = ($property_price - $final_loan);
                        $affordable_price = $property_price;
                    }
                    else if($cash_hand != 0 && $compute_type == 2) {
                        $oc_req = $cash_hand;
                        $affordable_price =  $oc_req + $final_loan;
                    }
                    else {
                        # OC Required
                        $ltv = $this->LTVCheck($final_loan,3);
                        $oc_req = (((100 - $ltv) / $ltv) * $final_loan);

                        $actual_affordable = ($oc_req + $final_loan);
                        $affordable_price = round((100/ $ltv) * $final_loan);
                    }

                    $pmay_loan = $final_loan - $pmay_subsidy;

                    $pmay_emi = round(($pmay_loan * ($int_rate/1200)) / (1-pow((1 + ($int_rate/1200)),-$max_tenure )));

                    $loan_arr['pmay_loan'] = $this->IND_money_format($pmay_loan);
                    $loan_arr['pmay_emi'] = $this->IND_money_format($pmay_emi);

                    $loan_arr['oc_req'] = $oc_req;
                    $loan_arr['actual_affordable'] = $actual_affordable;
                    $sch_result_arr[$s] = [
                        'scheme_id' => $scheme_id,
                        'plan_type' => $plan_type,
                        'plan_name' => $plan_name,
                        'bank_name' => $bankarr['bank_name'],
                        'bank_logo' => $bankarr['bank_logo'],
                        'product_name' => $productarr['product_name'],
                        'affordable' => $loan_arr,
                        'min_oc_req' => $this->IND_money_format($oc_req),
                        'affordable_price' => $this->IND_money_format($affordable_price)
                    ];
                    if($unmatched == 1){
                        array_push($unmatched_arr,$sch_result_arr[$s]);
                    }else {
                        array_push($matched_arr,$sch_result_arr[$s]);

                    }
                    
                    $s++;
                }
            }
        }

        $range = [
            'cash_hand' => $cash_hand_lks,
            'min_loan' => min($cust_loan_arr),
            'max_loan' => max($cust_loan_arr),
            'min_tenor' => min($cust_tenor_arr),
            'max_tenor' => max($cust_tenor_arr),
            'min_emi' => min($cust_emi_arr),
            'max_emi' => max($cust_emi_arr),
            'min_int' => min($cust_int_arr),
            'max_int' => max($cust_int_arr),
            'loan_arr' => $cust_loan_arr,
            'tenor_arr' => $cust_tenor_arr
        ];

        # Final Result
        $return = [
            'user_id' => $user_id, 
            'anonymous_user' => 1,
            'recompute_flag' => $recompute_flag,
            'propidentify' => $have_propidentify,
            'cash_hand' => (int)$cash_hand,
            'customranges' => $range,
            'prev_result' => $primary_user,
            'schemelist' => $sch_result_arr,
            'unmatched' => $unmatched_arr,
            'unmatched_flag' => count($unmatched_arr),
            'matched' => $matched_arr,
            'sloan' => $simulate_loan
            ];
        return $return;
    } 

    public function CallAPIs()
    {
        $inputs = json_decode(file_get_contents('php://input'),true);
        $call = $_REQUEST['call'];
        switch ($call) {
            case 'applyforloan':
                $result = $this->applyforloan($inputs);
                break;
            case 'computeactualoc':
                $result = $this->actualownc($inputs);
                break;
            case 'shortsweet':
                $result = $this->ShortSweetPlan($inputs);  
                break;  
            case 'boosterplan':
                $result = $this->BoosterPlan($inputs); 
                break;  
            case 'maxsaver':
                $result = $this->MaxSaver($inputs); 
                break;  
        }
        $output_json = json_encode($result,true);
        echo $output_json;
    }
}

$calc = new Loan;
$calc->CallAPIs();
?>