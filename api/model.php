<?php
require_once('dbconfig.php');
class Model extends DBConfig
{
    # Loan Pre-approval Tables
    public $bank_table = 'tp_loanap_bankmaster';

    public $product_table = 'tp_loanap_product';

    public $scheme_table = 'tp_loanap_scheme';

    public $foir_table = 'tp_loanap_scheme_foir';

    public $ltv_table = 'tp_loanap_rbi_ltv';    

    public $loan_rule_table = 'tp_loanap_rulemaster';

    public $loan_ruleresult_table = 'tp_loanap_ruleresult';

    public $loan_pmay_table = 'tp_pmay_rule';

	public function __construct() 
	{
		parent::__construct();
	} 
	/**
     * To Select table data
     */
    public function coreDualSelect($where = '')
    {
        if($where) {
            $where = ' WHERE '.$where;
        }
        $query = "SELECT 'p' as output FROM DUAL {$where}";
        $records = $this->db->prepare($query);
        $records->execute();
        if ($records->rowCount() > 0) {
            $row = $records->fetch(\PDO::FETCH_ASSOC);
            return $row;
        }
        return false;
    }
    public function coreSelect($table, $fields = '*', $where = false, $filter = '')
    {
        // General Query Structure.
        $query = "SELECT {$fields} FROM {$table}";
        // If, Where condition is applied.
        if ($where) {
            if (is_array($where)) {
                $where_array = '';
                foreach ($where as $index => $condition) {
                    if (!isset($condition['rel'])) $condition['rel'] = '';
                    $val = "'{$condition['value']}'";
                    if($condition['condition'] == 'NOT IN')
                        $val = "{$condition['value']}";
                    $where_array .= " {$condition['field']} {$condition['condition']} {$val} {$condition['rel']}";
                    $rel = $condition['rel'];
                }
                $where = " WHERE " . rtrim($where_array, $rel);
            } 
            else {
                $where = "WHERE {$where['field']} {$where['condition']} {$where['value']}";
            }
        }
        $query = $query . $where . ' ' . $filter;
        $records = $this->db->prepare($query);
        $records->execute();
        if ($records->rowCount() > 0) {
            return $records->fetchAll(\PDO::FETCH_ASSOC);
        }
        return null;
    }

    /**
     * To Select Joint Table data
     */
    public function coreSelectJoint($table1, $table2, $join_type, $join_cond, $fields = '*', $where = false, $filter = '')
    {
        // General Query Structure.
        $query = "SELECT {$fields} FROM {$table1} as t1 {$join_type} {$table2} as t2 ON {$join_cond} ";
        // If, Where condition is applied.
        if ($where) {
            if (is_array($where)) {
                $where_array = '';
                foreach ($where as $index => $condition) {
                    if (!isset($condition['rel'])) $condition['rel'] = '';
                    $val = "'{$condition['value']}'";
                    if($condition['condition'] == 'NOT IN')
                        $val = "{$condition['value']}";
                    $where_array .= " {$condition['field']} {$condition['condition']} {$val} {$condition['rel']}";
                    $rel = $condition['rel'];
                }
                $where = " WHERE " . rtrim($where_array, $rel);
            } 
            else {
                $where = "WHERE {$where['field']} {$where['condition']} {$where['value']}";
            }
        }
        $query = $query . $where . ' ' . $filter;
        $records = $this->db->prepare($query);
        $records->execute();
        if ($records->rowCount() > 0) {
            return $records->fetchAll(\PDO::FETCH_ASSOC);
        }
        return null;
    }
    
    /**
     * check if Exist 
     */
    public function coreSelectExist($table, $fields = '*', $where = false, $filter = 'LIMIT 1')
    {
        // General Query Structure.
        $query = "SELECT {$fields} FROM {$table}";
        if ($where) {
            if (is_array($where)) {
                $where_array = '';
                foreach ($where as $index => $condition) {
                    if (!isset($condition['rel'])) $condition['rel'] = '';
                    $where_array .= " {$condition['field']} {$condition['condition']} '{$condition['value']}' {$condition['rel']}";
                    $rel = $condition['rel'];
                }
                $where = " WHERE " . rtrim($where_array, $rel);
            } 
            else {
                $where = "WHERE {$where['field']} {$where['condition']} {$where['value']}";
            }
        }
        $query = $query . $where . ' ' . $filter;
        $records = $this->db->prepare($query);
        $records->execute();
        if ($records->rowCount() > 0) {
            $row = $records->fetch(\PDO::FETCH_ASSOC);
            return $row;
        }
        return false;
    }
    /**
     * To Insert the table data
     */
    public function coreInsert($table, $inputs)
    {
        $data = '"' . implode('","', array_values($inputs)) . '"';
        $inputs = implode(',', array_keys($inputs));
        //return "INSERT INTO {$table}({$inputs}) VALUES({$data})";
        $record = $this->db->prepare("INSERT INTO {$table}({$inputs}) VALUES({$data})");
        $record->execute();
        return $this->db->lastInsertId();
    }
    /**
     * To Update the table data.
     */
    public function coreUpdate($table, $inputs, $filter, $value, $direct_filter = false)
    {
        $query = '';
        foreach ($inputs as $index => $input) {
            if (empty($input) || is_null($input)) $input = '0';
            $query .= $index . '="' . $input . '",';
        }
        $query = rtrim($query, ',');
        if ($direct_filter) {
            $sql = "UPDATE {$table} SET {$query} WHERE {$filter}";
        } 
        else {
            $sql = "UPDATE {$table} SET {$query} WHERE {$filter}={$value}";
        }
        $a = $sql;
        $record = $this->db->prepare($sql);
        $record->execute();
    }
    /**
     * Delete Table Row
     */
    public function coreDelete($table, $where = false)
    {
        $query = "DELETE FROM {$table}";
        $where_cond = "";
        if($where) {
        	if(is_array($where)) {        		
        		foreach ($where as $key => $condition) {
        			if(!isset($condition['rel'])) $condition['rel'] = '';
        			$where_cond .= "{$condition['field']} {$condition['condition']} {$condition['value']} {$condition['rel']}";
        			$rel = $condition['rel'];
        		}
        		$where = " WHERE " . rtrim($where_cond, $rel);
        	}
        }

        $query .= $where;
        $record = $this->db->prepare($query);
        $record->execute();
        return true;
    }
}