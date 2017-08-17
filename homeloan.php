<?php
include "includes/define.php";
$page = 'p1';
include "includes/header.php";
$redirect_url = 'homeloan.php';
// set default values for affordable property
$Affordabledefaults = array();
$validPassDefault=1;
?>
<!-- Overview Header Section -->
<div class="overviewblock calcultorblock">
  <div class="overviewheader idfcmainbannerinverse">
    <h2 class="text-center"> PMAY based Home Loan Recommendation Tool </h2>
  </div>
  <div class="overviewbody overviewinverseidfcbody row">
    <div class="col-md-12">
      <div class="container">
        <form id="affordableCalc" data-parsley-focus="first" data-parsley-validate="" class="affordableCalc inline-block" name="affordableCalc" method="post" action="#" role="">
          <div class="calculatorcard calculatoridfccard">
            <div class="board loan-board legal">
              <div class="board-inner">
                <ul class="circlenav nav nav-tabs" id="myTab">
                  <div class="liner1 hidden-xs"></div>
                  <div class="liner2 visible-xs"></div>
                  <li class="col-md-4 active" style="width: 20%;">
                    <div class="tabheadercontent">
                      <h5 class="text-center">BHAMASHAH DETAILS</h5>
                    </div>
                    <a href="#step1" data-toggle="tab" class="valid-pass" title="Choose Auditor">
                      <span class="round-tabs one">
                        1
                      </span>
                    </a>
                  </li>
                   <li class="col-md-4" style="width: 20%;">
                    <div class="tabheadercontent">
                      <h5 class="text-center">PMAY ELIGIBILITY</h5>
                    </div>
                    <a href="#step1a" data-toggle="tab" class="valid-pass" title="">
                      <span class="round-tabs one">
                        2
                      </span>
                    </a>
                  </li>
                  <li class="col-md-4" style="width: 20%;">
                    <div class="tabheadercontent">
                      <h5 class="text-center">FAMILY DETAILS</h5>
                    </div>
                    <a href="#step2" data-toggle="tab" class="valid-pass" title="Choose Auditor">
                      <span class="round-tabs one">
                        3
                      </span>
                    </a>
                    
                  </li>
                  <li class="col-md-4" style="width: 20%;">
                    <div class="tabheadercontent hidden-xs ">
                      <h5 class="text-center">LOAN OFFERS</h5>
                    </div>
                    <a href="#step3" data-toggle="tab" class="calccompleted1 <?php echo ($validPassDefault==1)?"valid-pass":""; ?>" title="Property Details">
                      <span class="round-tabs two">
                        4
                      </span>
                    </a>
                    
                  </li>
                  <li class="col-md-4" style="width: 20%;">
                    <div class="tabheadercontent hidden-xs ">
                      <h5 class="text-center">APPLY FOR LOAN</h5>
                    </div>
                    <a href="#step4" data-toggle="tab" class="calccompleted1 <?php echo ($validPassDefault==1)?"valid-pass":""; ?>" title="Property Details">
                      <span class="round-tabs two">
                        5
                      </span>
                    </a>
                    
                  </li>
                </ul>
              </div>
              <div class="calculatorblock tab-content">

               <!-- START Step 1 --> 
              <div class="main_tabpane tab-pane fade in active" id="step1">
                <div id="existingprop">
                  
                    <div class="nonepadding">
                    <div class="col-md-12"><br/>
                      <center>
                      <h4> Enter your Bamashah ID </h4>
                      <p class=""><input type="text" id="bhamasa_id" name="bhamasa_id" class="form-control " data-d-group="2"  placeholder="" value="1067-7PVQ-28383" style="width: 40%;"></p> <a style="" href="#" class="idfcbtn btn-fatchbhamasa">Fetch Information</a>
                      <br><br/><br/>
                      </center>

                      <div id="bhamasa-result">
                      </div>

                      
                    </div>

                    <div class="clearfix"></div>
                  <div class="property-section" style="display:none;">  
                    <div class="col-md-12" ><br/><br/><br/>
                      <div class="col-md-4 col-md-offset-4">
                        <div class="form-group text-center">
                          <h4 style="padding-bottom:5px;text-align:center" for="restatus">Did you Identify the property? </h4>
                          <label class="radio-inline"><input type="radio" class="restatus" id="res-1-0" name="st_propidentify" value="1"  data-parsley-multiple="restatus0" data-parsley-group="block-1">Yes</label>
                          <label class="radio-inline"><input checked="" type="radio" class="restatus" id="res-2-0" name="st_propidentify" value="2" data-parsley-multiple="restatus0" data-parsley-group="block-1" >No</label>
                        </div>
                      </div>

                    <div class="clearfix"></div><br/>
                    <div class="prop-details-sec" style="display:none;">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="aname">Sub Registrar's Office</label>
                        <input type="text" class="form-control" name="aname[]" value=""  data-parsley-group="block-1">
                      </div> `
                    </div> 
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="aname">Village Name</label>
                        <input type="text" class="form-control" name="aname[]" value=""  data-parsley-group="block-1">
                      </div>
                    </div>
                    
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="aname">Survey Number</label>
                        <input type="text" class="form-control" name="aname[]" value=""  data-parsley-group="block-1">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="aname">Property Size (sqft)</label>
                        <input type="text" class="form-control" name="propsize[]" value=""  data-parsley-group="block-1">
                      </div>
                    </div>
                    </div>
                  
                    </div>

              
                    <div class="col-md-12"> <br/><br/>
                      <center>
                     <a style="z-index:105;position:relative;" id="proceed-step1a" class="btn btn-md btn-primary btn-action-calculator idfcbtn">Check My Eligibility</a>
                      </center>
                    </div>
                  </div>
                  <!-- Prop Idenfid -->  


                      <div class-"clearfix"></div>
 

                    </div>
                </div>
              </div>
              <!-- START Step 1 -->


                   <!-- START Step 1a -->
              <div class="main_tabpane tab-pane fade nonepadding" id="step1a">
                  <div id="existingprop">
                    <div data-wow-delay="0.1s" class="idfchomeloanblock calculator_section row existproperty_section cal-sec" style="background: #ec8e1e">
                      <div class="fixer1"></div>
                      <div class="fixer2"></div>
                      <div class="panel panel-primary panelhomeloan col-md-12">
                        
                        <div class="" id="pmay-result">

                        </div>
                      </div>
                    <div class="nonepadding">
                      <center>
                      <a style="z-index:105;position:relative;" id="proceed-step2" class="btn btn-md btn-primary btn-action-calculator idfcbtn">Apply for Loan</a>
                      </center>
                    </div>
                    
                  </div>
                
                  </div>
                  
              </div>
              <!-- ENDS Step 1a-->



              <!-- START Step 2 -->
                    <!-- START Step 1 -->
                <div class="main_tabpane tab-pane fade in" id="step2">
                  <div id="existingprop">
                    <div data-wow-delay="0.1s" class="idfchomeloanblock calculator_section row existproperty_section cal-sec" style="background: #ec8e1e">
                     <div class="fixer1"></div>
                     <div class="fixer2"></div>
                      <div class="panel panel-primary panelhomeloan col-md-12">
                        
                        <div class="panel-body tds-para">
                          
                          <div class="idfcloanperson1">
                            <div class="idfcloanblock1">
                              I am <span class="validationidfc"><input type="text" required="true" class="form-control" placeholder="" id="ap_name" name="ap_name" style="width: 25%;display: inline"> </span>aged <input type="text" required="true" class="form-control formattedAgeField" id="ap_age" name="ap_age" placeholder="" style="width: 16%;display: inline">, <span id="ap_prepo"> an </span><select required="true" class="form-control" id="ap_resident" name="ap_resident">
                              <option value="1" selected>Indian resident</option>
                              <option value="2">NRI</option>
                              
                            </select> &  living in 
                            <select required="true" class=" hide form-control" id="ap_residentcountry" name="ap_residentcountry">
                            <option> </option>
                            <option value="US">US</option>
                            <option value="UK">UK</option>
                            <option value="UAE">UAE</option>
                            <option value="SGD">Singapore</option>
                            <option value="OTH">Others</option>
                          </select>
                        

                          <select required="true" class="form-control" id="ap_city" name="ap_city">
                            <option value="chandigarh" selected>Chandigarh </option>
                            <option value="chennai">Chennai</option>
                            <option value="mumbai">Mumbai</option>
                            <option value="bangalore">Bangalore</option>
                            <option value="delhi">Delhi</option>
                            <option value="OTH">Others</option>
                          </select>
                        
                          ; I'm a <select required="true" class="form-control" id="ap_emptype" name="ap_emptype" style="width:430px;">
                            <option value=""> </option>
                            <option value="1">Salaried Individual</option>
                            <option value="2">Self Employed Professional</option>
                            <option value="3">Self Employed Non-Professional</option>
                          </select>
                          
                        </div>
                     
                          <div id="ppersontype">
                            <!-- p1 content here -->
                          </div>
                      </div>      
                       
                    <div class="idfchomeloancheckcondition">
                      <hr/>
                      <input type="checkbox" name="cp_have" id="cp_have" value="1"> I have a Co-Applicant<br>
                    </div>
                    <div class="idfcloanperson2 hide">
            
                      <div class="idfcloanblock1">
                              I am <span class="validationidfc"><input type="text" required="true" class="form-control" placeholder="" id="cp_name" name="cp_name" style="width: 25%;display: inline"> </span>aged <input type="text" data-parsley-type="digits" min="18" max="85" required="true" class="form-control" id="cp_age" name="cp_age" placeholder="" style="width: 16%;display: inline">, <span id="cp_prepo"> an </span> <select required="true" class="form-control" id="cp_resident" name="cp_resident">
                              <option value=""> </option>
                              <option value="1">Indian resident</option>
                              <option value="2">NRI</option>
                        
                            </select> &  living in 
                            <select required="true" class=" hide form-control" id="cp_residentcountry" name="cp_residentcountry">
                            <option> </option>
                                    <option value="US">US</option>
                                    <option value="UK">UK</option>
                                    <option value="UAE">UAE</option>
                                    <option value="SGD">Singapore</option>
                                    <option value="OTH">Others</option>
                          </select>


                        

                          <select required="true" class="form-control" id="cp_city" name="cp_city">
                            <option> </option>
                            <option value="chennai">Chennai</option>
                            <option value="mumbai">Mumbai</option>
                            <option value="bangalore">Bangalore</option>
                            <option value="delhi">Delhi</option>
                            <option value="OTH">Others</option>
                          </select>
                        
                          ; I'm a <select required="true" class="form-control" id="cp_emptype" name="cp_emptype" style="width:430px;">
                            <option value=""> </option>
                            <option value="1">Salaried Individual</option>
                            <option value="2">Self Employed Professional</option>
                            <option value="3">Self Employed Non-Professional</option>
                          </select>
                          
                  </div>
                        
                  <div id="cpersontype">
                            <!-- c1 content here -->
                   </div>     
                        
              </div>
              <div class="idfchomeloancheckcondition">
                <hr/>
                <input type="checkbox" name="otherSources" id="otherSources"  value="1"> Earning income from other resources
              </div>
              <div class="idfcloanincomesource hide tdspara2">
                <div class="row">
                  <div class="col-md-6">
                    <p class="tds-para tdspara2 text-center">Rental Income<br>&#x20B9;<input type="text" required="true" id="rental_income" name="rental_income" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 60%;display: inline"></p>
                  </div>
                  <div class="col-md-6">
                    <p class="tds-para tdspara2 text-center">From Any Other Source<br>&#x20B9;<input id="other_income" name="other_income" type="text" required="true" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 60%;display: inline"></p>
                  </div>
                </div>
              </div>
              <div class="idfchomeloancheckcondition ">
                <hr/>
                <input type="checkbox" name="emi_available" id="emi_available" value="1"> Currently paying EMIs<br>
              </div>
              <div class="idfcloanotherincome hide tdspara2">
                <div class="row">
                  <div class="col-md-12">
                    <p class="tds-para tdspara2 text-center" style="width: 50%;margin: 0  auto;">My Outgoing EMI/Month<br>&#x20B9;<input type="text" required="true" id="outgoingemi" name="outgoingemi" class="form-control formattedNumberField" data-d-group="2"  placeholder="" style="width: 60%;display: inline"></p>
                  </div>
                </div>
              </div>
              <div class="idfchomeloancheckcondition">
                <hr/>
                <input type="checkbox" id="property_identified" name="property_identified" value="1"> Identified the property<br>
              </div>
              <div class="idfcloanpropidfy hide">
                <div class="row">
                  <div class="col-md-6">
                    <p class="tds-para tdspara2 text-center">Property price<br>&#x20B9;<input type="text" required="true" class="form-control formattedNumberField" data-d-group="2"  placeholder="" name="property_price" style="width: 60%;display: inline"></p>
                  </div>
                  <div class="col-md-6">
                    <p class="tds-para tdspara2 text-center">Name of the builder<br><input type="text" name="project_name" required="true" class="form-control" placeholder="" style="width: 60%;display: inline"></p>
                  </div>
                </div>
              </div>
              <!-- VASA -->
              
            </div>
          </div>
                <div class="nonepadding">
          <center>
          <a style="z-index:105;position:relative;" id="proceed-step3" class="btn btn-md btn-primary btn-action-calculator idfcbtn">Show me my eligible Loans</a>
          </center>
        </div>
          
        </div>
        <div class="clearfix"></div>
 
  
       
        <div class="clearfix"></div>
      </div>
      
    </div>
    <!-- ENDS Step 1-->
              <!-- ENDS Step 2-->

              <!-- START Step 3 -->
              <div class="main_tabpane tab-pane fade nonepadding" id="step3">
                <div class="calculator_section  row propertyrise_section nonepadding">
                  <div class="row recompute-menus"></div>
                  <div class="col-md-12 schemewise-offers nonepadding"></div>
                    <div class="col-md-12">
                      <center>
                        <a id="proceed-step4" class="btn btn-md btn-primary btn-action-calculator idfcbtn"> Apply for loan </a>
                      </center>
                    </div>
                    <br/><br/>
                </div>
              </div>
              <!-- END Step 3 -->

              <!-- START Step 4 -->
              <div class="main_tabpane tab-pane fade" id="step4">
                <!-- Result-->
                 <div data-wow-delay="0.1s" class="calculator_section row existproperty_section applyloansection">
               <br/><div class="col-md-6 col-md-offset-3 calcblock">
                                  
                                
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="price">Name </label>
                                      <input type="text" name="aname" id="aname" placeholder="" >
                                      
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="street">Mobile</label>
                                      <input type="text" class="form-control" name="pref_locality" placeholder=""  >
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="city">Email</label>
                                      <input type="text" class="form-control" name="city" placeholder=""  >
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                     <center>
                                <a id="" class="btn btn-md btn-primary btn-action-calculator idfcbtn"> call me back </a>
                                </center>
                              </div>
                             
                                 
                                </div>
                              </div>
                <div class="clearfix"></div>
              </div>
              <!-- END Step 4 -->
  </div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
<!-- templates to be used -->
<!-- Result Loading.. -->
<div class="modal fade" id="loadingmodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-body">
<div id="resultLoader">
<center>
<img class="" src="img/gears.gif"> <br/><h5 class="text-primary">We are computing your eligibility, Please wait.. </h5>
</center>
</div>
<div id="errorMsg">

</div>
</div>
<div class="modal-footer hidden" id="errorBtn">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<div class="footeridfcinverse">
<img src="img/bannerddo.png"/>
</div>
<?php
include "includes/footer.php";
include "handlebartemplates/applyloan-template.php";
?>
<script type="text/javascript" src="js/applyloan.js"></script>
<script type="text/javascript">
$('.dropdown-menu input').click(function (event) {
event.stopPropagation();
});
</script>