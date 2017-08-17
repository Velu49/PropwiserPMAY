<script id="nobhamasa-details-template" type="x-handlebars-template">
<center><h5> Your Family id is wrong.</h5></center>
</script>

<script id="bhamasa-details-template" type="x-handlebars-template">
<center><h5> Your Family id is 1{{hof_Details.FAMILYIDNO}}. </h5></center>
<table class="bamtable table-striped table-hover table-responsive table-bordered table-condensed col-md-12">
  <thead>
      <td>
      <center>Name</center>
      </td>
      <td>
      <center>Gender</center>
      </td>
      
      <td>
      <center>D.O.B</center>
      </td>
      <td>
      <center>M ID</center>
      </td>
      <td>
      <center>Aadhar ID</center>
      </td>
      <td>
      <center>Annual Income</center>
      </td>
      <td>
        <center>Applicant</center>
      </td>
  </thead>
  <tbody>
     <tr>
        <td>
        <input type="text"  class="memb_name form-control" placeholder="Dinesh Jain" id="memb_name[]" name="memb_name[]" value="{{toUpperCase hof_Details.NAME_ENG}}">
        </td>
        <td>
        {{hof_Details.GENDER}}
        </td>
        
        <td>
        <input type="text"  class="dob_date form-control" placeholder="39" id="dob" name="dob" value="{{hof_Details.DOB}}">
        </td>
        <td>
        <input type="text"  class="form-control" placeholder="4545 4545 1512" id="memb_id[]" name="memb_id[]" value="{{hof_Details.BHAMASHAH_ID}}">
        </td>
        <td>
        <input type="text"  class="form-control" placeholder="1254 1214 5875 5842" id="aadhar_id" name="aadhar_id[]" value="{{hof_Details.AADHAR_ID}}">
        </td>
        <td>
        <input type="text"  class="form-control income_amount formattedNumberField" placeholder="Enter income" id="income[]" name="income[]" value="">
        </td>
        <td><center>
          <input type="checkbox" class="is_applicant" checked name="is_applicant" value="1"></center>
        </td>
      </tr>
  {{#each family_Details}}
    <tr>
        <td>
        <input type="text"  class="memb_name form-control" placeholder="Dinesh Jain" id="memb_name[]" name="memb_name[]" value="{{toUpperCase NAME_ENG}}">
        </td>
        <td>
        {{GENDER}}
        </td>
        <td>
        <input type="text"  class="dob_date form-control" placeholder="39" id="dob" name="dob[]" value="{{DOB}}">
        </td>
        <td>
        <input type="text"  class="form-control" placeholder="4545 4545 1512" id="memb_id[]" name="memb_id[]" value="{{M_ID}}">
        </td>
        <td>
        <input type="text"  class="form-control" placeholder="1254 1214 5875 5842" id="aadhar_id" name="aadhar_id[]" value="{{AADHAR_ID}}">
        </td>
        <td>
        <input type="text"  class="form-control income_amount formattedNumberField" placeholder="Enter Income" id="income[]" name="income[]">
        </td>
        <td>
        <center>
          <input type="checkbox" class="is_applicant" name="is_applicant[]" value="2">
          </center>
        </td>
      </tr>
  {{/each}}

  </tbody>
</table>
</script>

<script id="pmay-noresult-template" type="x-handlebars-template">
   <div class="col-md-12"> 
        <center>
          <h3 class="text-center" style="color:#fb637e"> Not Eligible! </h3><br/>
              <h4 class="text-center">You and your family members (father, mother, unmarried sibling 1) together can not avail the scheme. You all are not eligible for PMAY.
              </h4>
        </center>
    </div>
</script>

<script id="pmay-result-template" type="x-handlebars-template">
  <input type="hidden" id="pmay_loan" name="pmay_loan" value="{{pmay_loan}}">
          <div class="col-md-12"> 
              <center>
               <center>  <img src="img/checked.png"/></center>
                                <h3 class="text-center" style="color:#fb637e"> Congratulations! </h3><br/>
              <h4 class="text-center">You and your family members together can avail the scheme. You all fall under {{pmay_dec}} ({{pmay_cat}}) and hence are eligible for
              </h4>

              <div class="col-md-6">
              <h3>Interest Subsidy of<br/><br/>
              <span style="font-size:45px;color:#fb637e">{{subsidy_rate}}%</span></h3>
              </div>
              <div class="col-md-6">
              <h3>Total subsidy amount of<br/><br/>
                <span style="font-size:45px;color:#fb637e"><i class="fa fa-inr"></i> {{subsisy_amount}}</span>
              </h3>
              </div>
              </center>
            </div> 
                    
                    <div class="clearfix"></div>

              <div class="col-md-10 col-md-offset-1"> 
                    <center><br/>

                    <h4>PMAY Results [FAMILY] </h4>
                    <table class="bamtable table-striped table-hover table-responsive table-bordered table-condensed col-md-12">
                    <thead>
                    <td>
                    Details
                    </td>
                    <td>
                    Result
                    </td>

                    </thead>
                    <tbody>
                    <tr>
                    <td>
                    Family Income
                    </td>
                    <td>
                    <i class="fa fa-inr"></i> {{family_income}}
                    </td>
                    </tr>

                    <tr>
                    <td>
                    Family Income Group
                    </td>
                    <td>
                    {{pmay_dec}} ({{pmay_cat}})
                    </td>
                    </tr>

                    <tr>
                    <td>
                    PMAY Loan Subsidy Eligible?
                    </td>
                    <td>
                    Yes
                    </td>
                    </tr>

                    <tr>
                    <td>
                    Eligible Subsidy Interest Rate
                    </td>
                    <td>
                    {{subsidy_rate}}%
                    </td>
                    </tr>

                    <tr>
                    <td>
                    Upfront Benefit from Subsidy
                    </td>
                    <td>
                    <i class="fa fa-inr"></i> {{subsisy_amount}}
                    </td>
                    </tr>



                    </tbody>
                    </table>

                    </center>

                    </div>

<div class="clearfix"></div>
<!--
            <div class="col-md-10 col-md-offset-1"> 
                  <center><br/><br/><br/>
                  <h4>PMAY Results [PROPERTY] </h4>
                  <table class="bamtable table-striped table-hover table-responsive table-bordered table-condensed col-md-12">
                  <thead>
                  <td>
                  Details
                  </td>
                  <td>
                  Result
                  </td>

                  </thead>
                  <tbody>
                  <tr>
                  <td>
                  Carpet Area
                  </td>
                  <td>
                  55 Sq.mts
                  </td>
                  </tr>

                  <tr>
                  <td>
                  PMAY Eligible
                  </td>
                  <td>
                  Yes
                  </td>
                  </tr>

                  <tr>
                  <td>
                  Property located in the listed towns (PMAY Scheme)
                  </td>
                  <td>
                  Yes
                  </td>
                  </tr>



                  </tbody>
                  </table>

                  </center>

        </div>

        <div class="clearfix"></div>

        <div class="col-md-10 col-md-offset-1"> 
              <center><br/><br/><br/>
              <h4>PMAY Results [Individual Members] </h4>
              <table class="bamtable table-striped table-hover table-responsive table-bordered table-condensed col-md-12">
              <thead>
              <td>
              Name
              </td>
              <td>
              Own a Pucca House?
              </td>
              <td>
              Has already availed subsidy through any housing program?
              </td>

              </thead>
              <tbody>
              <tr>
              <td>
              Mr. Rajesh Trivedi
              </td>
              <td>
              No
              </td>
              <td>
              No
              </td>
              </tr>


              <tr>
              <td>
              Mr. Rajeshwari Trivedi
              </td>
              <td>
              No
              </td>
              <td>
              No
              </td>
              </tr>

            </tbody>
            </table>

            </center>

          </div>
          -->
</script

<!-- Result Items-->
<script id="recompute-template" type="x-handlebars-template">
  <div class="panel panel-success idfcloanresultfilters">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-3 nonepadding"></div>
      <!-- Recomput Btn -->
      <div class="col-md-3 nonepadding col-md-offset-1">
        <div class="col-md-12 nonepadding">
          <div class="navbar-collapse collapse">
            <div class="">
              <div class="input-group center-block text-center">
                <a class="dropdown-toggle " data-toggle="dropdown">
                Recompute  <span class="caret"></span>
                </a>
                
                <div class="dropdown-menu idfcfilterddmenu">
                  <div class="col-sm-12">
                    
                    <div class="form-group">
                      <label>Loan Amount</label>
                      <input type="text" class="loan_amount_slider" data-step=".1" data-from="{{customranges.min_loan}}" data-min="5" data-max="{{customranges.max_loan}}" value="{{customranges.min_loan}}" required="">
                    </div>

                    <div class="form-group">
                      <label>Loan Tenure</label>
                      <input type="text" class="tenor_slider" data-step="12" data-from="{{customranges.min_tenor}}" data-min="60" data-max="{{customranges.max_tenor}}" value="{{customranges.min_tenor}}" >
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                      <button type="button" class="btn-recomputeoffer btn idfcbtn col-md-12">Re-Compute with Loan/Tenor</button>
                    </div>
                    <div class="clearfix"></div>
                    {{#if propidentify}}
                    
                    {{else}}
                      <div class="form-group">
                        <label>Cash in hand</label>
                        <input type="text" class="cashhand_slider" data-step=".1" data-from="{{customranges.cash_hand}}" data-min="0" data-max="100" value="{{customranges.cash_hand}}" >
                      </div>
                    {{/if}}
                    <div class="clearfix"></div>
                    
                    <div class="col-sm-12">
                      <button type="button" class="btn-cashhand-compute btn idfcbtn col-md-12">Re-Compute with Cash in Hand</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter Option -->
      <div class="col-md-3 nonepadding">

        <div class="col-md-12 nonepadding">
          <div class="navbar-collapse collapse">
            <div class="">
              <div class="input-group center-block text-center">
                <a class="dropdown-toggle " data-toggle="dropdown">
                Filter by : <span class="caret"></span>
                </a>
                
                <div class="dropdown-menu idfcfilterddmenu">
                  <div class="col-sm-12">
                    
                    <div class="form-group">
                      <label>Interest </label>
                      <input type="text" class="interest_slider" data-step=".01" data-from="{{customranges.min_int}}" data-to="{{customranges.max_int}}" data-min="{{customranges.min_int}}" data-max="{{customranges.max_int}}" value="{{customranges.max_int}}" >
                    </div>


                    <div class="form-group">
                      <label> EMI range</label>
                      <input type="text" class="emi_slider" data-step="100" data-from="{{customranges.min_emi}}" data-to="{{customranges.max_emi}}" data-min="{{customranges.min_emi}}" data-max="{{customranges.max_emi}}" value="{{customranges.max_emi}}" >
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="clearfix"></div>
    <!-- <div class="col-md-12 text-center">
      <button type="button" class="btn-recomputeoffer btn btn-primary">Compute</button>
     </div> -->
    <div class="clearfix"></div>
  </div>

</script>
<script id="schemelist-template" type="x-handlebars-template">

<div class="clearfix"></div>

<div id="available_offers">
  <div class="row matched-offers">
    <h4 class="text-center">All Available Offers</h4><br/>
    <div class="clearfix"></div>
    <table class="table table-striped table-condensed" id="matched_accordion">
      <thead style="background:#eaeaea;border:none;">
        <tr>
          <th>Bank</th>
          <th>Product Type</th>
          <th>Max Loan Eligible</th>
          <th>Intrest Rate</th>
          <th>EMI</th>
          <th>EMI after PMAY Subsidy</th>
          <th>OC Required</th>
          {{#if propidentify}}
          <th>Property Price</th>
          {{else}}
          <th>Affordable Price</th>
          {{/if}}
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody class="matched-table">
        {{#each matched}}
        <!-- Simple Loan-->
        <input type="hidden" class="scheme_obj" value="1">
        {{#ifCond plan_type '1'}}
        <tr class="matchedproduct matchproduct-{{scheme_id}}" data-scheme_id="{{scheme_id}}" data-loan="{{affordable.loan_lks}}" data-emi="{{affordable.emi_roundoff}}" data-tenor="{{affordable.actual_tenor}}" data-intrate="{{affordable.actual_int_rate}}" data-toggle="collapse" data-parent="#matched_accordion" href="#matchedproductbankDetails{{scheme_id}}" style="text-align:center;">
          <td>
            
            <center><img src="img/sbi.jpg" class="img-responsive" width="130"/></center>
          </td>
          <td  style="text-transform:uppercase;text-align:left;">{{plan_name}}</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable.max_loan_elig}}</td>
          <td>{{affordable.actual_int_rate}} %</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable.actual_emi}}</td>
          
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable.pmay_emi}}</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{min_oc_req}}</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable_price}}</td>
          <td><input type="radio" checked name="offer"/></td>
         <td> <center><img src="img/darrow.png" width="30"/></center></td>
        </tr>

        <tr id="matchedproductbankDetails{{scheme_id}}" class="collapse">
          <td colspan="9">
            <div class="col-md-12">
              <div class="clearfix"></div>
              <div class="col-md-12">
                <p class="text-primary text-center"><b> Simple Loan Details </b></p>
                <table class="table table-responsive table-striped table-bordered">
                  <tr>
                    <th>Tenor</th>
                    <td>{{affordable.actual_tenor}} months</td>
                  </tr>
                  <tr>
                    <th>EMI Eligible </th>
                    <td><i class="fa fa-inr"></i> {{affordable.actual_emi}}</td>
                  </tr>
                  <tr>
                    <th>Loan Eligible </th>
                    <td class="booster-emi-{{scheme_id}}"><i class="fa fa-inr"></i> {{affordable.actual_loan}}</td>
                  </tr>
                  
                </table>
              </div>
            </div>
          </td>
        </tr>
        {{/ifCond}}
        <!-- Booster Plan-->
        {{#ifCond plan_type '2'}}
        <tr class="matchedproduct matchproduct-{{scheme_id}}" data-scheme_id="{{scheme_id}}" data-income="{{affordable.booster_income}}"  data-loan="{{affordable.loan_lks}}" data-emi="{{affordable.emi_roundoff}}" data-tenor="{{affordable.actual_tenor}}" data-intrate="{{affordable.actual_int_rate}}" data-toggle="collapse" data-parent="#matched_accordion" href="#matchedproductbankDetails{{scheme_id}}" style="text-align:center;">
          <td>
            <center><img src="img/ba1.jpg" class="img-responsive" width="130"/>
            </center>
          </td>
          <td  style="text-transform:uppercase;text-align:left;">{{plan_name}}</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable.max_loan_elig}}</td>
          <td>{{affordable.actual_int_rate}} %</td>
          <td class="booster-emi-{{scheme_id}}"><i class="fa fa-inr"></i>&nbsp; {{affordable.booster_emi}}</td>
          
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable.pmay_emi}}</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{min_oc_req}}</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable_price}}</td>
         <td><input type="radio" name="offer"/></td>
           <td> <center><img src="img/darrow.png" width="30"/></center></td>
        </tr>
        <tr id="matchedproductbankDetails{{scheme_id}}" class="collapse">
          <td colspan="9">
            <div class="col-md-12">
              <div class="col-md-12">
                
                <div class="col-md-6 col-md-offset-3">
                  <p class="text-primary"><b> Interest Only Period (months) </b></p>
                  <div class="form-group">
                    <input type="text" class="intperiod_slider" data-parsley-range="[0,36]" data-income="{{affordable.booster_income}}" data-from="36" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-emi="{{affordable.actual_emi}}" data-loan="{{affordable.actual_loan}}" id="sch-{{scheme_id}}" value="" required="">
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="booster-result-{{scheme_id}}">
                <div class="col-md-9">
                  <p class="text-primary text-center"><b> Booster Product Details </b></p>
                  <table class="table table-responsive table-striped table-bordered">
                    <tbody>
                      <tr>
                        <th>EMI payable during interest only period</th>
                        <td><i class="fa fa-inr"></i> {{affordable.actual_emi}}</td>
                      </tr>
                      <tr>
                        <th>EMI payable during loan repayment</th>
                        <td class="booster-emi-{{scheme_id}}"><i class="fa fa-inr"></i> {{affordable.booster_emi}}</td>
                      </tr>
                      <tr>
                        <th>Increase in Loan Affordability because of the Booster c= (a-b)</th>
                        <td><i class="fa fa-inr"></i> {{affordable.booster_increase}}</td>
                      </tr>
                      
                      <td>  --Loan affordable with Booster (a)</td>
                      <td><i class="fa fa-inr"></i> {{affordable.booster_loan}}</td>
                    </tr>
                    <tr>
                      <td>  --Loan affordable without Booster (b)</td>
                      <td><i class="fa fa-inr"></i> {{affordable.actual_loan}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-3 loanresultdeco">
                <h4>Loan eligibility increase by</h4>
                <h1>{{affordable.booster_percentage}} %</h1>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </td>
      </tr>
      {{/ifCond}}
      <!-- Short & Sweet-->
      {{#ifCond plan_type '3'}}
      <tr class="matchedproduct matchproduct-{{scheme_id}}" data-scheme_id="{{scheme_id}}"  data-loan="{{affordable.loan_lks}}" data-emi="{{affordable.emi_roundoff}}" data-tenor="{{affordable.reduced_tenor}}" data-intrate="{{affordable.actual_int_rate}}" data-toggle="collapse" data-parent="#matched_accordion" href="#matchedproductbankDetails{{scheme_id}}" style="text-align:center;">
        <td>
          <center>
          <img src="img/ba2.jpg" class="img-responsive" width="130"/>
          </center>
        </td>
        <td  style="text-transform:uppercase;text-align:left;">{{plan_name}}</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{affordable.max_loan_elig}}</td>
        <td>{{affordable.actual_int_rate}} %</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{affordable.actual_emi}}</td>
        
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable.pmay_emi}}</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{min_oc_req}}</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{affordable_price}}</td>
        <td><input type="radio" name="offer"/></td>
         <td> <center><img src="img/darrow.png" width="30"/></center></td>
      </tr>
      <tr id="matchedproductbankDetails{{scheme_id}}" class="collapse">
        <td colspan="9">
          <div class="col-md-12">
            <div class="col-md-12">
              
              <div class="col-md-6">
                <p class="text-primary"><b> Average Monthly Balance </b></p>
                <div class="form-group">
                  <input type="text" id="avgbal-{{scheme_id}}" class="avgbalance_slider" data-parsley-range="[0,50]" data-from="0" data-emi="{{affordable.actual_emi}}" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-loan="{{affordable.actual_loan}}" value="0" required="">
                </div>
              </div>
              <div class="col-md-6">
                <p class="text-primary"><b> Recurring Deposit </b></p>
                <div class="form-group">
                  <input type="text" id="recurdep-{{scheme_id}}" class="recurdeposit_slider" data-parsley-range="[0,50]" data-from="10" data-emi="{{affordable.actual_emi}}" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-loan="{{affordable.actual_loan}}" value="10" required="">
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="shortsweet-result-{{scheme_id}}">
              <div class="col-md-9">
                <p class="text-primary text-center"><b> Product Details </b></p>
                <table class="table table-responsive table-striped table-bordered">
                  <tbody>
                    <tr>
                      <th>Total Interest Saved c=(a-b)</th>
                      <td><i class="fa fa-inr"></i>&nbsp; {{affordable.interest_amount_saved}}</td>
                    </tr>
                    <tr>
                      <td>  --Total Interest to be Paid (a)</td>
                      <td><i class="fa fa-inr"></i>&nbsp; {{affordable.simple_interest_paid}}</td>
                    </tr>
                    <tr>
                      <td>  --Interest to be Paid because of Short & Sweet Product (b)</td>
                      <td><i class="fa fa-inr"></i>&nbsp; {{affordable.shortswt_interest_paid}}</td>
                    </tr>
                    <tr>
                      <th>Tenor Saved f=(d-e)</th>
                      <td>{{affordable.tenor_saved}} months</td>
                    </tr>
                    <tr>
                      <td>  --Proposed Tenor (d)</td>
                      <td>{{affordable.actual_tenor}} months</td>
                    </tr>
                    <tr>
                      <td>  --Reduced Tenor because of Short & Sweet Product (e)</td>
                      <td>{{affordable.reduced_tenor}} months</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-3 loanresultdeco">
                <h6>Tenor reduced by</h6>
                <h1>{{affordable.tenor_saved}} <small>months</small></h1>
                <h6>Interest Saved by Short & Sweet Loan</h6>
                <h1>{{interest_percentage}} <small>%</small></h1>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </td>
      </tr>
      {{/ifCond}}
      <!-- Max Saver-->
      {{#ifCond plan_type '4'}}
      <tr class="matchedproduct matchproduct-{{scheme_id}}" data-scheme_id="{{scheme_id}}"  data-loan="{{affordable.loan_lks}}" data-emi="{{affordable.emi_roundoff}}" data-tenor="{{affordable.reduced_tenor}}" data-intrate="{{affordable.actual_int_rate}}" data-toggle="collapse" data-parent="#matched_accordion" href="#matchedproductbankDetails{{scheme_id}}" style="text-align:center;">
        <td>
          <center>
          <img src="img/ba3.jpg" class="img-responsive" width="130"/>
          </center>
        </td>
        <td  style="text-transform:uppercase;text-align:left;">{{plan_name}}</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{affordable.max_loan_elig}}</td>
        <!--<td class="loanamount-{{scheme_id}}"><i class="fa fa-inr"></i>&nbsp; {{affordable.actual_loan}}</td>-->
        <td>{{affordable.actual_int_rate}} %</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{affordable.actual_emi}}</td>
        
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable.pmay_emi}}</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{min_oc_req}}</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{affordable_price}}</td>
        <td><input type="radio" name="offer"/></td>
         <td> <center><img src="img/darrow.png" width="30"/></center></td>
      </tr>
      <tr id="matchedproductbankDetails{{scheme_id}}" class="collapse">
        <td colspan="9">
          <div class="col-md-12">
            <div class="col-md-12">
              
              <div class="col-md-6">
                <p class="text-primary"><b> Simple Loan Share </b></p>
                <div class="form-group">
                  <input type="text" id="avgbal-{{scheme_id}}" class="simpleshare_slider" data-parsley-range="[0,50]" data-from="30" data-emi="{{affordable.actual_emi}}" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-loan="{{affordable.actual_loan}}" value="30" required="">
                </div>
              </div>
              <div class="col-md-6">
                <p class="text-primary"><b> Short & Sweet Share </b></p>
                <div class="form-group">
                  <input type="text" id="recurdep-{{scheme_id}}" class="shortswtshare_slider" data-parsley-range="[0,100]" data-from="70" data-emi="{{affordable.actual_emi}}" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-loan="{{affordable.actual_loan}}" value="70" required="">
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
              <div class="col-md-6">
                <p class="text-primary"><b> Average Monthly Balance </b></p>
                <div class="form-group">
                  <input type="text" id="avgbal-{{scheme_id}}" class="mx_avgbalance_slider" data-parsley-range="[0,50]" data-from="0" data-emi="{{affordable.actual_emi}}" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-loan="{{affordable.actual_loan}}" value="0" required="">
                </div>
              </div>
              <div class="col-md-6">
                <p class="text-primary"><b> Recurring Deposit </b></p>
                <div class="form-group">
                  <input type="text" id="recurdep-{{scheme_id}}" class="mx_recurdeposit_slider" data-parsley-range="[0,50]" data-from="10" data-emi="{{affordable.actual_emi}}" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-loan="{{affordable.actual_loan}}" value="10" required="">
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="shortsweet-result-{{scheme_id}}">
              <div class="col-md-9">
                <p class="text-primary text-center"><b> Product Details </b></p>
                <table class="table table-responsive table-striped table-bordered">
                  <tbody>
                    <tr>
                      <th>Total Interest Saved c=(a-b)</th>
                      <td><i class="fa fa-inr"></i>&nbsp; {{affordable.interest_saved}}</td>
                    </tr>
                    <tr>
                      <td>  --Total Interest to be Paid (a)</td>
                      <td><i class="fa fa-inr"></i>&nbsp; {{affordable.total_interest_paid}}</td>
                    </tr>
                    <tr>
                      <td>  --Interest to be Paid because of Max Saver (b)</td>
                      <td><i class="fa fa-inr"></i>&nbsp; {{affordable.maxsaver_interest_paid}}</td>
                    </tr>
                    <tr>
                      <th>Tenor Saved f=(d-e)</th>
                      <td>{{affordable.tenor_saved}} months</td>
                    </tr>
                    <tr>
                      <td>  --Proposed Tenor (d)</td>
                      <td>{{affordable.actual_tenor}} months</td>
                    </tr>
                    <tr>
                      <td>  --Reduced Tenor because of Short & Sweet Product (e)</td>
                      <td>{{affordable.reduced_tenor}} months</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-3 loanresultdeco">
                <h6>Effective Interest Rate</h6>
                <h1>{{affordable.effective_int_rate}} <small>%</small></h1>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </td>
      </tr>
      {{/ifCond}}
      {{/each}}
      </tbody>
    </table>
  </div>
  <div class="row other-offers">
  {{#if unmatched_flag}}
  
    <h4 class="text-center">Other Offers</h4><br/>
    <div class="clearfix"></div>
    <table class="table table-striped table-condensed" id="matched_accordion">
      <thead style="background:#eaeaea;border:none;">
        <tr>
          <th>Bank</th>
          <th>Product Type</th>
          <th>Max Loan Eligible</th>
          <th>Intrest Rate</th>
          <th>EMI</th>
          <th>OC Required</th>
          <th>Affordable Price</th>
          <th></th>
        </tr>
      </thead>
      <tbody class="unmatched-table">
        <tr class="no-matched-offer" style="display:none;">
          <td colspan="{{#if cash_hand}}9 {{else}} 8{{/if}}"><center><h6>No offers found</h6></center></td>
        </tr>
        {{#each unmatched}}
        <!-- Simple Loan-->
        <input type="hidden" class="scheme_obj" value="1">
        {{#ifCond plan_type '1'}}
        <tr class="matchedproduct matchproduct-{{scheme_id}}" data-scheme_id="{{scheme_id}}" data-loan="{{affordable.loan_lks}}" data-emi="{{affordable.emi_roundoff}}" data-tenor="{{affordable.actual_tenor}}" data-intrate="{{affordable.actual_int_rate}}" data-toggle="collapse" data-parent="#matched_accordion" href="#matchedproductbankDetails{{scheme_id}}" style="text-align:center;">
          <td>
            
            <center><img src="img/ba1.jpg" class="img-responsive" width="130"/></center>
          </td>
          <td  style="text-transform:uppercase;text-align:left;">{{plan_name}}</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable.max_loan_elig}}</td>
          
          <td>{{affordable.actual_int_rate}} %</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable.actual_emi}}</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{min_oc_req}}</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable_price}}</td>
         
         <td> <center><img src="img/darrow.png" width="30"/></center></td>
        </tr>

        <tr id="matchedproductbankDetails{{scheme_id}}" class="collapse">
          <td colspan="9">
            <div class="col-md-12">
              <div class="clearfix"></div>
              <div class="col-md-12">
                <p class="text-primary text-center"><b> Simple Loan Details </b></p>
                <table class="table table-responsive table-striped table-bordered">
                  <tr>
                    <th>Tenor</th>
                    <td>{{affordable.actual_tenor}} months</td>
                  </tr>
                  <tr>
                    <th>EMI Eligible </th>
                    <td><i class="fa fa-inr"></i> {{affordable.actual_emi}}</td>
                  </tr>
                  <tr>
                    <th>Loan Eligible </th>
                    <td class="booster-emi-{{scheme_id}}"><i class="fa fa-inr"></i> {{affordable.actual_loan}}</td>
                  </tr>
                  
                </table>
              </div>
            </div>
          </td>
        </tr>
        {{/ifCond}}
        <!-- Booster Plan-->
        {{#ifCond plan_type '2'}}
        <tr class="matchedproduct matchproduct-{{scheme_id}}" data-scheme_id="{{scheme_id}}"  data-loan="{{affordable.loan_lks}}" data-emi="{{affordable.emi_roundoff}}"  data-tenor="{{affordable.actual_tenor}}" data-intrate="{{affordable.actual_int_rate}}" data-toggle="collapse" data-parent="#matched_accordion" href="#matchedproductbankDetails{{scheme_id}}" style="text-align:center;">
          <td>
            <center><img src="img/ba1.jpg" class="img-responsive" width="130"/>
            </center>
          </td>
          <td  style="text-transform:uppercase;text-align:left;">{{plan_name}}</td>
          <td class="booster-loan-{{scheme_id}}"><i class="fa fa-inr"></i>&nbsp; {{affordable.max_loan_elig}}</td>
          <!--<td class="booster-loan-{{scheme_id}}"><i class="fa fa-inr"></i>&nbsp; {{affordable.actual_loan}}</td>-->
          <td>{{affordable.actual_int_rate}} %</td>
          <td class="booster-emi-{{scheme_id}}"><i class="fa fa-inr"></i>&nbsp; {{affordable.booster_emi}}</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{min_oc_req}}</td>
          <td><i class="fa fa-inr"></i>&nbsp; {{affordable_price}}</td>
          
           <td> <center><img src="img/darrow.png" width="30"/></center></td>
        </tr>
        <tr id="matchedproductbankDetails{{scheme_id}}" class="collapse">
          <td colspan="9">
            <div class="col-md-12">
              <div class="col-md-12">
                
                <div class="col-md-6 col-md-offset-3">
                  <p class="text-primary"><b> Interest Only Period (months) </b></p>
                  <div class="form-group">
                    <input type="text" class="intperiod_slider" data-parsley-range="[0,36]" data-income="{{affordable.booster_income}}" data-from="36" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-emi="{{affordable.actual_emi}}" data-loan="{{affordable.actual_loan}}" id="sch-{{scheme_id}}" value="" required="">
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="booster-result-{{scheme_id}}">
                <div class="col-md-9">
                  <p class="text-primary text-center"><b> Booster Product Details </b></p>
                  <table class="table table-responsive table-striped table-bordered">
                    <tbody>
                      <tr>
                        <th>EMI payable during interest only period</th>
                        <td><i class="fa fa-inr"></i> {{affordable.actual_emi}}</td>
                      </tr>
                      <tr>
                        <th>EMI payable during loan repayment</th>
                        <td class="booster-emi-{{scheme_id}}"><i class="fa fa-inr"></i> {{affordable.booster_emi}}</td>
                      </tr>
                      <tr>
                        <th>Increase in Loan Affordability because of the Booster c= (a-b)</th>
                        <td><i class="fa fa-inr"></i> {{affordable.booster_increase}}</td>
                      </tr>
                      
                      <td>  --Loan affordable with Booster (a)</td>
                      <td class="booster-loan-{{scheme_id}}"><i class="fa fa-inr"></i> {{affordable.booster_loan}}</td>
                    </tr>
                    <tr>
                      <td>  --Loan affordable without Booster (b)</td>
                      <td><i class="fa fa-inr"></i> {{affordable.actual_loan}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-3 loanresultdeco">
                <h4>Loan eligibility increase by</h4>
                <h1>{{affordable.booster_percentage}} %</h1>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </td>
      </tr>
      {{/ifCond}}
      <!-- Short & Sweet-->
      {{#ifCond plan_type '3'}}
      <tr class="matchedproduct matchproduct-{{scheme_id}}" data-scheme_id="{{scheme_id}}"  data-loan="{{affordable.loan_lks}}" data-emi="{{affordable.emi_roundoff}}" data-tenor="{{affordable.reduced_tenor}}" data-intrate="{{affordable.actual_int_rate}}" data-toggle="collapse" data-parent="#matched_accordion" href="#matchedproductbankDetails{{scheme_id}}" style="text-align:center;">
        <td>
          <center>
          <img src="img/ba1.jpg" class="img-responsive" width="130"/>
          </center>
        </td>
        <td  style="text-transform:uppercase;text-align:left;">{{plan_name}}</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{affordable.max_loan_elig}}</td>
        <!--<td class="loanamount-{{scheme_id}}"><i class="fa fa-inr"></i>&nbsp; {{affordable.actual_loan}}</td>-->
        <td>{{affordable.actual_int_rate}} %</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{affordable.actual_emi}}</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{min_oc_req}}</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{affordable_price}}</td>
       
         <td> <center><img src="img/darrow.png" width="30"/></center></td>
      </tr>
      <tr id="matchedproductbankDetails{{scheme_id}}" class="collapse">
        <td colspan="9">
          <div class="col-md-12">
            <div class="col-md-12">
              
              <div class="col-md-6">
                <p class="text-primary"><b> Average Monthly Balance </b></p>
                <div class="form-group">
                  <input type="text" id="avgbal-{{scheme_id}}" class="avgbalance_slider" data-parsley-range="[0,50]" data-from="0" data-emi="{{affordable.actual_emi}}" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-loan="{{affordable.actual_loan}}" value="0" required="">
                </div>
              </div>
              <div class="col-md-6">
                <p class="text-primary"><b> Recurring Deposit </b></p>
                <div class="form-group">
                  <input type="text" id="recurdep-{{scheme_id}}" class="recurdeposit_slider" data-parsley-range="[0,50]" data-from="10" data-emi="{{affordable.actual_emi}}" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-loan="{{affordable.actual_loan}}" value="10" required="">
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="shortsweet-result-{{scheme_id}}">
              <div class="col-md-9">
                <p class="text-primary text-center"><b> Product Details </b></p>
                <table class="table table-responsive table-striped table-bordered">
                  <tbody>
                    <tr>
                      <th>Total Interest Saved c=(a-b)</th>
                      <td><i class="fa fa-inr"></i>&nbsp; {{affordable.interest_amount_saved}}</td>
                    </tr>
                    <tr>
                      <td>  --Total Interest to be Paid (a)</td>
                      <td><i class="fa fa-inr"></i>&nbsp; {{affordable.simple_interest_paid}}</td>
                    </tr>
                    <tr>
                      <td>  --Interest to be Paid because of Short & Sweet Product (b)</td>
                      <td><i class="fa fa-inr"></i>&nbsp; {{affordable.shortswt_interest_paid}}</td>
                    </tr>
                    <tr>
                      <th>Tenor Saved f=(d-e)</th>
                      <td>{{affordable.tenor_saved}} months</td>
                    </tr>
                    <tr>
                      <td>  --Proposed Tenor (d)</td>
                      <td>{{affordable.actual_tenor}} months</td>
                    </tr>
                    <tr>
                      <td>  --Reduced Tenor because of Short & Sweet Product (e)</td>
                      <td>{{affordable.reduced_tenor}} months</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-3 loanresultdeco">
                <h6>Tenor reduced by</h6>
                <h1>{{affordable.tenor_saved}} <small>months</small></h1>
                <h6>Interest Saved by Short & Sweet Loan</h6>
                <h1>{{interest_percentage}} <small>%</small></h1>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </td>
      </tr>
      {{/ifCond}}
      <!-- Max Saver-->
      {{#ifCond plan_type '4'}}
      <tr class="matchedproduct matchproduct-{{scheme_id}}" data-scheme_id="{{scheme_id}}"  data-loan="{{affordable.loan_lks}}" data-emi="{{affordable.emi_roundoff}}" data-tenor="{{affordable.reduced_tenor}}" data-intrate="{{affordable.actual_int_rate}}" data-toggle="collapse" data-parent="#matched_accordion" href="#matchedproductbankDetails{{scheme_id}}" style="text-align:center;">
        <td>
          <center>
          <img src="img/ba1.jpg" class="img-responsive" width="130"/>
          </center>
        </td>
        <td  style="text-transform:uppercase;text-align:left;">{{plan_name}}</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{affordable.max_loan_elig}}</td>
        <!--<td class="loanamount-{{scheme_id}}"><i class="fa fa-inr"></i>&nbsp; {{affordable.actual_loan}}</td>-->
        <td>{{affordable.actual_int_rate}} %</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{affordable.actual_emi}}</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{min_oc_req}}</td>
        <td><i class="fa fa-inr"></i>&nbsp; {{affordable_price}}</td>
        
         <td> <center><img src="img/darrow.png" width="30"/></center></td>
      </tr>
      <tr id="matchedproductbankDetails{{scheme_id}}" class="collapse">
        <td colspan="9">
          <div class="col-md-12">
            <div class="col-md-12">
              
              <div class="col-md-6">
                <p class="text-primary"><b> Simple Loan Share </b></p>
                <div class="form-group">
                  <input type="text" id="avgbal-{{scheme_id}}" class="simpleshare_slider" data-parsley-range="[0,50]" data-from="30" data-emi="{{affordable.actual_emi}}" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-loan="{{affordable.actual_loan}}" value="30" required="">
                </div>
              </div>
              <div class="col-md-6">
                <p class="text-primary"><b> Short & Sweet Share </b></p>
                <div class="form-group">
                  <input type="text" id="recurdep-{{scheme_id}}" class="shortswtshare_slider" data-parsley-range="[0,100]" data-from="70" data-emi="{{affordable.actual_emi}}" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-loan="{{affordable.actual_loan}}" value="70" required="">
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
              <div class="col-md-6">
                <p class="text-primary"><b> Average Monthly Balance </b></p>
                <div class="form-group">
                  <input type="text" id="avgbal-{{scheme_id}}" class="mx_avgbalance_slider" data-parsley-range="[0,50]" data-from="0" data-emi="{{affordable.actual_emi}}" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-loan="{{affordable.actual_loan}}" value="0" required="">
                </div>
              </div>
              <div class="col-md-6">
                <p class="text-primary"><b> Recurring Deposit </b></p>
                <div class="form-group">
                  <input type="text" id="recurdep-{{scheme_id}}" class="mx_recurdeposit_slider" data-parsley-range="[0,50]" data-from="10" data-emi="{{affordable.actual_emi}}" data-interest = "{{affordable.actual_int_rate}}" data-tenure="{{affordable.actual_tenor}}" data-loan="{{affordable.actual_loan}}" value="10" required="">
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="shortsweet-result-{{scheme_id}}">
              <div class="col-md-9">
                <p class="text-primary text-center"><b> Product Details </b></p>
                <table class="table table-responsive table-striped table-bordered">
                  <tbody>
                    <tr>
                      <th>Total Interest Saved c=(a-b)</th>
                      <td><i class="fa fa-inr"></i>&nbsp; {{affordable.interest_saved}}</td>
                    </tr>
                    <tr>
                      <td>  --Total Interest to be Paid (a)</td>
                      <td><i class="fa fa-inr"></i>&nbsp; {{affordable.total_interest_paid}}</td>
                    </tr>
                    <tr>
                      <td>  --Interest to be Paid because of Max Saver (b)</td>
                      <td><i class="fa fa-inr"></i>&nbsp; {{affordable.maxsaver_interest_paid}}</td>
                    </tr>
                    <tr>
                      <th>Tenor Saved f=(d-e)</th>
                      <td>{{affordable.tenor_saved}} months</td>
                    </tr>
                    <tr>
                      <td>  --Proposed Tenor (d)</td>
                      <td>{{affordable.actual_tenor}} months</td>
                    </tr>
                    <tr>
                      <td>  --Reduced Tenor because of Short & Sweet Product (e)</td>
                      <td>{{affordable.reduced_tenor}} months</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-3 loanresultdeco">
                <h6>Effective Interest Rate</h6>
                <h1>{{affordable.effective_int_rate}} <small>%</small></h1>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </td>
      </tr>
      {{/ifCond}}
      {{/each}}
      </tbody>
    </table>
  
  {{/if}}
  </div>
</div>

</script>


<script id="maxsaver-table-template" type="x-handlebars-template">
<div class="col-md-9">
<p class="text-primary text-center"><b> Product Details </b></p>
<table class="table table-responsive table-striped table-bordered">
  <tbody>
    <tr>
      <th>Total Interest Saved c=(a-b)</th>
      <td><i class="fa fa-inr"></i>&nbsp; {{interest_saved}}</td>
    </tr>
    <tr>
      <td>  --Total Interest to be Paid (a)</td>
      <td><i class="fa fa-inr"></i>&nbsp; {{total_interest_paid}}</td>
    </tr>
    <tr>
      <td>  --Interest to be Paid because of Max Saver (b)</td>
      <td><i class="fa fa-inr"></i>&nbsp; {{maxsaver_interest_paid}}</td>
    </tr>
    <tr>
      <th>Tenor Saved f=(d-e)</th>
      <td>{{tenor_saved}} months</td>
    </tr>
    <tr>
      <td>  --Proposed Tenor (d)</td>
      <td>{{actual_tenor}} months</td>
    </tr>
    <tr>
      <td>  --Reduced Tenor because of Short & Sweet Product (e)</td>
      <td>{{reduced_tenor}} months</td>
    </tr>
  </tbody>
</table>
</div>
<div class="col-md-3 loanresultdeco">
<h6>Effective Interest Rate</h6>
<h1>{{effective_int_rate}} <small>%</small></h1>
</div>
</script>

<script id="shortsweet-table-template" type="x-handlebars-template">
<div class="col-md-9">
<p class="text-primary text-center"><b> Short & Sweet Product Details </b></p>
<table class="table table-responsive table-striped table-bordered">
  <tbody>
    <tr>
      <th>Total Interest Saved c=(a-b)</th>
      <td><i class="fa fa-inr"></i>&nbsp; {{interest_amount_saved}}</td>
    </tr>
    <tr>
      <td>  --Total Interest to be Paid (a)</td>
      <td><i class="fa fa-inr"></i>&nbsp; {{simple_interest_paid}}</td>
    </tr>
    <tr>
      <td>  --Interest to be Paid because of Short & Sweet Product (b)</td>
      <td><i class="fa fa-inr"></i>&nbsp; {{shortswt_interest_paid}}</td>
    </tr>
    <tr>
      <th>Tenor Saved f=(d-e)</th>
      <td>{{tenor_saved}} months</td>
    </tr>
    <tr>
      <td>  --Proposed Tenor (d)</td>
      <td>{{actual_tenor}} months</td>
    </tr>
    <tr>
      <td>  --Reduced Tenor because of Short & Sweet Product (e)</td>
      <td>{{reduced_tenor}} months</td>
    </tr>
  </tbody>
</table>
</div>
<div class="col-md-3 loanresultdeco">
<h6>Tenor reduced by</h6>
<h1>{{tenor_saved}} <small>months</small></h1>
<h6>Interest Saved by Short & Sweet</h6>
<h1>{{interest_percentage}} <small>%</small></h1>
</div>
</script>

<script id="booster-table-template" type="x-handlebars-template">
<div class="col-md-9">
<p class="text-primary text-center"><b> Product Details </b></p>
<table class="table table-responsive table-striped table-bordered">
  <tbody>
    <tr>
      <th>EMI payable during interest only period</th>
      <td><i class="fa fa-inr"></i> {{actual_emi}}</td>
    </tr>
    <tr>
      <th>EMI payable during loan repayment</th>
      <td ><i class="fa fa-inr"></i> {{booster_emi}}</td>
    </tr>
    <tr>
      <th>Increase in Loan Affordability because of the Booster c= (a-b)</th>
      <td><i class="fa fa-inr"></i> {{booster_increase}}</td>
    </tr>
    
    <td>  --Loan affordable with Booster (a)</td>
    <td><i class="fa fa-inr"></i> {{booster_loan}}</td>
  </tr>
  <tr>
    <td>  --Loan affordable without Booster (b)</td>
    <td><i class="fa fa-inr"></i> {{actual_loan}}</td>
  </tr>
</tbody>
</table>
</div>
<div class="col-md-3 loanresultdeco">
<h4>Loan eligibility increase by</h4>
<h1>{{booster_percentage}} %</h1>
</div>
</script>
<!-- END Result Items-->


<script id="tab1-psindian-template" type="x-handlebars-template">
  My gross income is &#x20B9;<input type="text" required="true" class="form-control formattedNumberField" data-d-group="2"  id="ap_grossincome" name="ap_grossincome" placeholder="" style="width: 20%;display: inline"> / month and net take home salary of &#x20B9;<input type="text" required="true" class="form-control formattedNumberField" data-d-group="2"  id="ap_netincome" name="ap_netincome" placeholder="" style="width: 15%;display: inline"> / month.<br/>
                           I work for <input type="text" required="true" class="form-control" id="ap_companyname" name="ap_companyname" placeholder="" style="width: 30%;display: inline"> ; since <input type="text" required="true" class="form-control formattedMonthField" id="ap_workingsince_mm"  name="ap_workingsince_mm" placeholder="MM" style="width: 20%;display: inline">,<input type="text" required="true" class="form-control formattedYearField" placeholder="YYYY" id="ap_workingsince_yy" name="ap_workingsince_yy" style="width: 20%;display: inline"> , while my total work experience is <input type="text" required="true" class="formattedworkExYField form-control" id="ap_expyear"  name="ap_expyear" placeholder="" style="width: 10%;display: inline"> year(s) & <input type="text" required="true" class="formattedworkExMField form-control"  placeholder="" id="ap_expmonth" name="ap_expmonth" style="width: 10%;display: inline"> months.
</script>

<script id="tab1-pspindian-template" type="x-handlebars-template">
    My gross professional receipt (current year) is &#x20B9;<input type="text" required="true" class="form-control formattedNumberField" data-d-group="2"  id="ap_grossprofit" name="ap_grossprofit" placeholder="" style="width: 20%;display: inline"> and net profits (current year) is &#x20B9;<input type="text" required="true" id="ap_netprofit" name="ap_netprofit" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 20%;display: inline"> I work for <input type="text" required="true" id="ap_companyname" name="ap_companyname" class="form-control" placeholder="" style="width: 30%;display: inline"> since <input type="text" required="true" class="form-control formattedMonthField" id="ap_workingsince_mm"  name="ap_workingsince_mm" placeholder="MM" style="width: 20%;display: inline">,<input type="text" required="true" class="form-control formattedYearField" id="ap_workingsince_yy"  name="ap_workingsince_yy" placeholder="YYYY" style="width: 20%;display: inline"> with total work experience of <input type="text" required="true" id="ap_expyear"  name="ap_expyear" class="form-control formattedworkExYField" placeholder="" style="width: 10%;display: inline"> year(s) & <input id="ap_expmonth"  name="ap_expmonth" type="text" required="true" class="form-control formattedworkExMField" placeholder="" style="width: 10%;display: inline"> months as a 
                          <select required="true" class="form-control" id="ap_profession" name="ap_profession">
                          <option value="Doctor" >Doctor</option>
                          <option value="Chartered Accountant" >Chartered Accountant</option>
                          <option value="Architect" >Architect</option>
                          <option value="Others" >Others</option>
                        </select>

</script>
<script id="tab1-psnpindian-template" type="x-handlebars-template">
  My turn over (current year) is &#x20B9;<input id="ap_turnover" name="ap_turnover" type="text" required="true" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 20%;display: inline"> and net profits (current year) is &#x20B9;<input type="text" required="true" id="ap_netprofit" name="ap_netprofit" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 20%;display: inline"> . I work for <input type="text" required="true" id="ap_companyname" name="ap_companyname" class="form-control" placeholder="" style="width: 30%;display: inline"> which is a 
                           <select required="true" class="form-control" id="ap_companytype" name="ap_companytype">
                          <option value="Manufacturing">Manufacturing</option>
                          <option value="Trading">Trading</option>
                          <option value="Services">Services</option>
                          <option value="Others">Others</option>
                        </select>
                        firm, operating since <input type="text" required="true" class="form-control formattedYearField" id="ap_workingsince_mm"  name="ap_workingsince_mm" placeholder="MM" style="width: 20%;display: inline">,<input type="text" required="true" class="form-control formattedMonthField" id="ap_workingsince_yy"  name="ap_workingsince_yy" placeholder="YYYY" style="width: 20%;display: inline"> with total work experience of <input id="ap_expyear"  name="ap_expyear" type="text" required="true" class="form-control formattedworkExYField" placeholder="" style="width: 10%;display: inline"> year(s) & <input id="ap_expmonth"  name="ap_expmonth" type="text" required="true" class="form-control formattedworkExMField" placeholder="" style="width: 10%;display: inline"> months.
</script>
<script id="tab1-psnri-template" type="x-handlebars-template">
  My monthly income is 
 <select required="true" class="form-control" id="ap_currency" name="ap_currency" style="width:100px;">
                          <option value="USD">USD</option>
                          <option value="GBP">GBP</option>
                          <option value="SGD">SGD</option>
                          <option value="AED">AED</option>
                        </select>
                          <input type="text" required="true" id="ap_grossincome" name="ap_grossincome" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 20%;display: inline"> <br/>
                           I work for <input type="text" required="true" id="ap_companyname" name="ap_companyname"  class="form-control" placeholder="" style="width: 30%;display: inline"> ; since <input type="text" required="true" class="form-control formattedMonthField" id="ap_workingsince_mm"  name="ap_workingsince_mm" placeholder="MM" style="width: 20%;display: inline">,<input type="text" required="true" class="form-control formattedYearField" id="ap_workingsince_yy"  name="ap_workingsince_yy" placeholder="YYYY" style="width: 20%;display: inline"> , while my total work experience is <input id="ap_expyear"  name="ap_expyear" type="text" required="true" class="form-control formattedworkExYField" placeholder="" style="width: 10%;display: inline"> year(s) & <input type="text" required="true" class="form-control formattedworkExMField" placeholder="" id="ap_expmonth"  name="ap_expmonth" style="width: 10%;display: inline"> months.
</script>
<script id="tab1-pspnri-template" type="x-handlebars-template">
  My Annual gross receipt (profit after taxes) is <br/>
  <select required="true" class="form-control" id="ap_currency" style="width:100px;">
                          <option value="USD">USD</option>
                          <option value="GBP">GBP</option>
                          <option value="SGD">SGD</option>
                          <option value="AED">AED</option>
                        </select>
                          <input type="text" required="true" id="ap_grossprofit" name="ap_grossprofit" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 20%;display: inline"> and working for <input type="text" required="true" class="form-control" id="ap_companyname" name="ap_companyname" placeholder="" style="width: 30%;display: inline"> since <input type="text" required="true" class="form-control formattedMonthField" id="ap_workingsince_mm"  name="ap_workingsince_mm" placeholder="MM" style="width: 20%;display: inline">,<input type="text" required="true" class="form-control formattedYearField" id="ap_workingsince_yy"  name="ap_workingsince_yy" placeholder="YYYY" style="width: 20%;display: inline"> with total work experience of <input type="text" required="true" id="ap_expyear"  name="ap_expyear" class="form-control formattedworkExYField" placeholder="" style="width: 10%;display: inline"> year(s) & <input type="text" required="true" class="form-control formattedworkExMField" id="ap_expmonth"  name="ap_expmonth" placeholder="" style="width: 10%;display: inline"> months as a <select required="true" class="form-control" id="ap_profession" name="ap_profession">
                          <option value="Doctor">Doctor</option>
                          <option value="Chartered Accountant">Chartered Accountant</option>
                          <option value="Architect">Architect</option>
                          <option value="Others">Others</option>
                        </select>
</script>
<script id="tab1-psnpnri-template" type="x-handlebars-template">
    My turn over (current year) is  <select required="true" class="form-control" id="ap_currency" name="ap_currency" style="width:100px;">
                          <option value="USD">USD</option>
                          <option value="GBP">GBP</option>
                          <option value="SGD">SGD</option>
                          <option value="AED">AED</option>
                        </select> <input type="text" required="true" class="form-control formattedNumberField" data-d-group="2"  id="ap_turnover" name="ap_turnover" placeholder="" style="width: 20%;display: inline"> and net profits (current year) is  <select required="true" class="form-control" id="ap_currency" name="ap_currency" style="width:100px;">
                          <option value="USD">USD</option>
                          <option value="GBP">GBP</option>
                          <option value="SGD">SGD</option>
                          <option value="AED">AED</option>
                        </select><input type="text" required="true" id="ap_netprofit" name="ap_netprofit" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 20%;display: inline"> . I work for <input id="ap_companyname" name="ap_companyname" type="text" required="true" class="form-control" placeholder="" style="width: 30%;display: inline"> which is a 
                           <select required="true" class="form-control" id="ap_companytype" name="ap_companytype">
                          <option>Manufacturing</option>
                          <option>Trading</option>
                          <option>Services</option>
                          <option>Others</option>
                        </select>
                       firm, operating since <input type="text" required="true" class="form-control formattedMonthField" id="ap_workingsince_mm"  name="ap_workingsince_mm" placeholder="MM" style="width: 20%;display: inline">,<input type="text" required="true" class="form-control formattedYearField" id="ap_workingsince_yy"  name="ap_workingsince_yy" placeholder="YYYY" style="width: 20%;display: inline"> with total work experience of <input id="ap_expyear"  name="ap_expyear" type="text" required="true" class="form-control formattedworkExYField" placeholder="" style="width: 10%;display: inline"> year(s) & <input type="text" required="true" id="ap_expmonth"  name="ap_expmonth" class="form-control formattedworkExMField" placeholder="" style="width: 10%;display: inline"> months.
</script>



<script id="tab1-csindian-template" type="x-handlebars-template">
   My gross income is &#x20B9;<input type="text" required="true" class="form-control formattedNumberField" data-d-group="2"  id="cp_grossincome" name="cp_grossincome" placeholder="" style="width: 20%;display: inline"> / month and net take home salary of &#x20B9;<input type="text" required="true" class="form-control formattedNumberField" data-d-group="2"  id="cp_netincome" name="cp_netincome" placeholder="" style="width: 15%;display: inline"> / month.<br/>
                           I work for <input type="text" required="true" class="form-control" id="cp_companyname" name="cp_companyname" placeholder="" style="width: 30%;display: inline"> ; since <input type="text" required="true" class="form-control formattedMonthField" id="cp_workingsince_mm"  name="cp_workingsince_mm" placeholder="MM" style="width: 20%;display: inline">,<input type="text" required="true" class="form-control formattedYearField" id="cp_workingsince_yy" name="cp_workingsince_yy" placeholder="YYYY" style="width: 20%;display: inline"> , while my total work experience is <input type="text" required="true" class="form-control formattedworkExYField" id="cp_expyear"  name="cp_expyear" placeholder="" style="width: 10%;display: inline"> year(s) & <input type="text" required="true" class="form-control formattedworkExMField" placeholder="" id="cp_expmonth"  name="cp_expmonth" style="width: 10%;display: inline"> months.
</script>
<script id="tab1-cspindian-template" type="x-handlebars-template">
  My gross professional receipt (current year) is &#x20B9;<input type="text" required="true" class="form-control formattedNumberField" data-d-group="2"  id="cp_grossprofit" name="cp_grossprofit" placeholder="" style="width: 20%;display: inline"> and net profits (current year) is &#x20B9;<input type="text" required="true" id="cp_netprofit" name="cp_netprofit" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 20%;display: inline"> I work for <input type="text" required="true" id="cp_companyname" name="cp_companyname" class="form-control" placeholder="" style="width: 30%;display: inline"> since <input type="text" required="true" class="form-control formattedMonthField" id="cp_workingsince_mm"  name="cp_workingsince_mm" placeholder="MM" style="width: 20%;display: inline">,<input type="text" required="true" class="form-control formattedYearField" id="cp_workingsince_yy" name="cp_workingsince_yy" placeholder="YYYY" style="width: 20%;display: inline"> with total work experience of <input type="text" required="true" id="cp_expyear"  name="cp_expyear" class="form-control formattedworkExYField" placeholder="" style="width: 10%;display: inline"> year(s) & <input id="cp_expmonth"  name="cp_expmonth" type="text" required="true" class="form-control formattedworkExMField" placeholder="" style="width: 10%;display: inline"> months as a 
                          <select required="true" class="form-control" id="cp_profession" name="cp_profession">
                    <option value="Doctor">Doctor</option>
                    <option value="Chartered Accountant">Chartered Accountant</option>
                    <option value="Architect">Architect</option>
                    <option value="Others">Others</option>
                  </select>
</script>
<script id="tab1-csnpindian-template" type="x-handlebars-template">
  My turn over (current year) is &#x20B9;<input id="cp_turnover" name="cp_turnover" type="text" required="true" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 20%;display: inline"> and net profits (current year) is &#x20B9;<input type="text" required="true" id="cp_netprofit" name="cp_netprofit" class="form-control formattedNumberField" data-d-group="2" placeholder="" style="width: 20%;display: inline"> . I work for <input type="text" required="true" id="cp_companyname" name="cp_companyname" class="form-control" placeholder="" style="width: 30%;display: inline"> which is a 
                           <select required="true" class="form-control" id="cp_companytype" name="cp_companytype">
                          <option value="Manufacturing">Manufacturing</option>
                          <option value="Trading">Trading</option>
                          <option value="Services">Services</option>
                          <optionvalue="Others">Others</option>
                        </select>
                        firm, operating since <input type="text" required="true" class="form-control formattedMonthField" id="cp_workingsince_mm"  name="cp_workingsince_mm" placeholder="MM" style="width: 20%;display: inline">,<input type="text" required="true" class="form-control formattedYearField" id="cp_workingsince_yy" name="cp_workingsince_yy" placeholder="YYYY" style="width: 20%;display: inline"> with total work experience of <input id="cp_expyear"  name="cp_expyear" type="text" required="true" class="form-control formattedworkExYField" placeholder="" style="width: 10%;display: inline"> year(s) & <input id="cp_expmonth"  name="cp_expmonth" type="text" required="true" class="form-control formattedworkExMField" placeholder="" style="width: 10%;display: inline"> months.
</script>
<script id="tab1-csnri-template" type="x-handlebars-template">
                 
                          His/Her monthly income is 
    <select required="true" class="form-control" id="cp_currency" name="cp_currency" style="width:100px;">
                          <option value="USD">USD</option>
                          <option value="GBP">GBP</option>
                          <option value="SGD">SGD</option>
                          <option value="AED">AED</option>
                        </select>
                          <input type="text" required="true" id="cp_grossincome" name="cp_grossincome" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 20%;display: inline"> <br/>
                           I work for <input type="text" required="true" id="cp_companyname" name="cp_companyname"  class="form-control" placeholder="" style="width: 30%;display: inline"> ; since <input type="text" required="true" class="form-control formattedMonthField"  id="cp_workingsince_mm"  name="cp_workingsince_mm" placeholder="MM" style="width: 20%;display: inline">,<input type="text" required="true" class="form-control formattedYearField" id="cp_workingsince_yy" name="cp_workingsince_yy" placeholder="YYYY" style="width: 20%;display: inline"> , while my total work experience is <input id="cp_expyear"  name="cp_expyear" type="text" required="true" class="form-control formattedworkExYField" placeholder="" style="width: 10%;display: inline"> year(s) & <input type="text" required="true" class="form-control formattedworkExMField" placeholder="" id="cp_expmonth"  name="cp_expmonth" style="width: 10%;display: inline"> months.
</script>
<script id="tab1-cspnri-template" type="x-handlebars-template">
  His/Her Annual gross receipt (profit after taxes) is <br/>
  <select required="true" class="form-control " id="cp_expmonth"  name="cp_expmonth" style="width:100px;">
                          <option value="USD">USD</option>
                          <option value="GBP">GBP</option>
                          <option value="SGD">SGD</option>
                          <option value="AED">AED</option>
                        </select>
                          <input type="text" required="true" id="cp_grossprofit" name="cp_grossprofit" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 20%;display: inline"> and working for <input type="text" required="true" class="form-control" id="cp_companyname" name="cp_companyname" placeholder="" style="width: 30%;display: inline"> since <input type="text" required="true" class="form-control formattedMonthField" id="cp_workingsince_mm"  name="cp_workingsince_mm" placeholder="MM" style="width: 20%;display: inline">,<input type="text" required="true" class="form-control formattedYearField" id="cp_workingsince_yy" name="cp_workingsince_yy" placeholder="YYYY" style="width: 20%;display: inline"> with total work experience of <input type="text" required="true" id="cp_expyear"  name="cp_expyear" class="form-control formattedworkExYField" placeholder="" style="width: 10%;display: inline"> year(s) & <input type="text" required="true" class="form-control formattedworkExMField" id="cp_expmonth"  name="cp_expmonth" placeholder="" style="width: 10%;display: inline"> months as a <select required="true" class="form-control" id="cp_profession" name="cp_profession">
                          <option value="Doctor">Doctor</option>
                          <option value="Chartered Accountant">Chartered Accountant</option>
                          <option value="Architect">Architect</option>
                          <option value="Others">Others</option>
                        </select>
</script>
<script id="tab1-csnpnri-template" type="x-handlebars-template">
    My turn over (current year) is <input type="text" required="true" class="form-control formattedNumberField" data-d-group="2"  id="cp_turnover" name="cp_turnover" placeholder="" style="width: 20%;display: inline"> and net profits (current year) is <input type="text" required="true" id="cp_netprofit" name="cp_netprofit" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 20%;display: inline"> . I work for <input id="cp_companyname" name="cp_companyname" type="text" required="true" class="form-control" placeholder="" style="width: 30%;display: inline"> which is a 
                           <select required="true" class="form-control" id="cp_companytype" name="cp_companytype">
                          <option value="Manufacturing">Manufacturing</option>
                          <option value="Trading">Trading</option>
                          <option value="Services">Services</option>
                          <option value="Others">Others</option>
                        </select>
                       firm, operating since <input type="text" required="true" class="form-control formattedMonthField" id="cp_workingsince_mm"  name="cp_workingsince_mm" placeholder="MM" style="width: 20%;display: inline">,<input type="text" required="true" class="form-control formattedYearField" id="cp_workingsince_yy" name="cp_workingsince_yy" placeholder="YYYY" style="width: 20%;display: inline"> with total work experience of <input id="cp_expyear"  name="cp_expyear" type="text" required="true" class="form-control formattedworkExYField" placeholder="" style="width: 10%;display: inline"> year(s) & <input type="text" required="true" id="cp_expmonth"  name="cp_expmonth" class="form-control formattedworkExMField" placeholder="" style="width: 10%;display: inline"> months.   
</script>