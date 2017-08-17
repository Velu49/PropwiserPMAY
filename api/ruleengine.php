 <?php
class Engine
{
    public function RuleEvaluation($data)
    {
        $scheme_result = array();
        $transaction_id = $data['transaction_id'];
        $rule_table = $this->loan_ruleresult_table;
        $field = '*';
        $where = [
            [
                'field' => 'transaction_id',
                'condition' => '=',
                'value' => $transaction_id,
                'rel' => ' and '
            ],
            [
                'field' => 'rule_type',
                'condition' => '=',
                'value' => 'global',
                'rel' => ' and '
            ],
            [
                'field' => 'rule_status',
                'condition' => '=',
                'value' => 0
            ]
        ];
        $global_rule = $this->coreSelect($rule_table, $field, $where);
        if($global_rule) {
            # Global Rule Fail Here so no loan Scheme  available
        }
        else {
            # All Global rule pass here next check Bank wise rule
            $where = [
                [
                    'field' => 'transaction_id',
                    'condition' => '=',
                    'value' => $transaction_id,
                    'rel' => ' and '
                ],
                [
                    'field' => 'rule_type',
                    'condition' => '=',
                    'value' => 'bank'
                ]
            ];
            $filter = ' GROUP BY bank_id HAVING rule_status = min(rule_status) ';

            $bank_rule = $this->coreSelect($rule_table, $field, $where, $filter);

            # Product Rule
            if($bank_rule) {
                foreach ($bank_rule as $index => $bank) {
                    if($bank['rule_status'] == 1) {
                        $bank_id = $bank['bank_id'];

                        $where = [
                            [
                                'field' => 'transaction_id',
                                'condition' => '=',
                                'value' => $transaction_id,
                                'rel' => ' and '
                            ],
                            [
                                'field' => 'bank_id',
                                'condition' => '=',
                                'value' => $bank_id,
                                'rel' => ' and '
                            ],
                            [
                                'field' => 'rule_type',
                                'condition' => '=',
                                'value' => 'product',
                                'rel' => ' and '
                            ],
                            [
                                'field' => 'rule_status',
                                'condition' => '=',
                                'value' => 1
                            ]
                        ];
                        $product_rule = $this->coreSelect($rule_table, $field, $where);   
                        if($product_rule) {
                            foreach ($product_rule as $key => $product) {
                                $product_id = $product['product_id'];
                                $where = [
                                    [
                                        'field' => 'transaction_id',
                                        'condition' => '=',
                                        'value' => $transaction_id,
                                        'rel' => ' and '
                                    ],
                                    [
                                        'field' => 'product_id',
                                        'condition' => '=',
                                        'value' => $product_id,
                                        'rel' => ' and '
                                    ],
                                    [
                                        'field' => 'rule_type',
                                        'condition' => '=',
                                        'value' => 'scheme',
                                        'rel' => ' and '
                                    ],
                                    [
                                        'field' => 'rule_status',
                                        'condition' => '=',
                                        'value' => 1
                                    ]
                                ];
                                $scheme_rule = $this->coreSelect($rule_table, $field, $where);

                                /* Scheme Details */
                                if($scheme_rule) {
                                    foreach ($scheme_rule as $i => $scheme) {
                                        $scheme_id = $scheme['scheme_id'];
                                        # Bank Details
                                        $table = $this->bank_table;
                                        $field = '*';
                                        $where = [
                                            [
                                                'field' => 'id',
                                                'condition' => '=',
                                                'value' => $bank_id
                                            ]
                                        ];
                                        $bank_arr = $this->coreSelectExist($table, $field, $where);

                                        # Product Details
                                        $table = $this->product_table;
                                        $field = '*';
                                        $where = [
                                            [
                                                'field' => 'id',
                                                'condition' => '=',
                                                'value' => $product_id
                                            ]
                                        ];
                                        $product_arr = $this->coreSelectExist($table, $field, $where);

                                        # Scheme Details
                                        $table = $this->scheme_table;
                                        $field = '*';
                                        $where = [
                                            [
                                                'field' => 'id',
                                                'condition' => '=',
                                                'value' => $scheme_id
                                            ]
                                        ];
                                        $scheme_arr = $this->coreSelectExist($table, $field, $where);

                                        $scheme_result[$i]['bank_arr'] = $bank_arr;
                                        $scheme_result[$i]['product_arr'] = $product_arr;
                                        $scheme_result[$i]['scheme_arr'] = $scheme_arr;
                                    }
                                }
                                /* END Scheme Details */
                            }
                        }
                    }
                }
            }
            
        }
        return $scheme_result;
    }
}