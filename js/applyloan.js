$(function(){
    $('[data-toggle="tooltip"]').tooltip();

    $('body').on('click','.datepicker', function() {
        $(this).datepicker('destroy').datepicker({
         showOn:'focus',changeMonth: true,changeYear: true,dateFormat: 'mm/dd/yy'
        }).focus();
    });

    Handlebars.registerHelper("inc", function(value, options){
      return parseInt(value) + 1;
    });

    Handlebars.registerHelper('toUpperCase', function(str) {
  return str.toUpperCase();
});

    Handlebars.registerHelper('ifCond', function(v1, v2, options) {
      if(v1 === v2) {
        return options.fn(this);
      }
      return options.inverse(this);
    });

    // Parsley validation for multistep form begin
    $sections = $('.main_tabpane');

    mychart1 = "";
    mychart3 = "";
    mychartarr =  new Array();
    ajaxCompleteFlag = 0;
    lastSerialezedData = "";
    tax_table = "";

    $parsley = $('.affordableCalc').parsley({
        successClass: 'has-success',
        errorClass: 'has-error',
        excluded: "input[type=button], input[type=submit], input[type=reset], input[type=hidden], [disabled], :hidden",
        classHandler: function(el) {
          return el.$element.closest(".form-group");
        },
        errorsWrapper: '<span class="help-block"></span>',
        errorTemplate: "<span></span>",
        errorsContainer: function(el) {
          return el.$element.closest('.form-group');
        }
    });

    refreshSection();
    navigateTo(0); 
    dynamic_bind();

    // restrict viewing next pages without filling current page
    $('#myTab a[data-toggle="tab"]').on('hide.bs.tab', function (e) {

        parsvar = parseInt($(e.target).attr("href").slice(-1))-1;
        parsvarout = parseInt($(e.relatedTarget).attr("href").slice(-1))-1;
        parsvarout_orginal = $(e.relatedTarget).attr("href").slice(-1);
       
         // uncomment this when v need to restrict next tab view on load
        if (!$parsley.validate({ group: 'block-' + parsvar }) && parsvarout > parsvar) {
          return false;
        }

        parsvaroutVar = $(e.relatedTarget).attr("href");

        if(parsvaroutVar=="#step3"){
            if(lastSerialezedData != $("#affordableCalc").serialize()){
              // add modal
              if(!$('#errorBtn').hasClass('hidden'))
                      $('#errorBtn').addClass('hidden');
              if($('#resultLoader').hasClass('hidden'))
                      $('#resultLoader').removeClass('hidden');

              $("#errorMsg").html("");      

              $("#loadingmodal").modal('show');

              var loan = $(".loan_amount_slider").val();
              var tenor = $(".tenor_slider").val();
              var cash_hand = $(".cashhand_slider").val();

              performCalculation(loan, tenor, cash_hand);
              $("#current_step").html("3");

              return false;

            }
        }
        else {
           if(!$(e.relatedTarget).hasClass("valid-pass")){
              e.preventDefault;
              return false;
            }else{
                $("#current_step").html(parsvarout_orginal);
                
           }
        }
    }); 

    $('#myTab a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $(e.currentTarget.hash).find('.ct-chart').each(function(el, tab) {
          if(ajaxCompleteFlag==1){
            mychart1.update();
            $.each(mychartarr, function (key,onechart) {
                onechart.update();
            });
                  
            if($("#matching_point").val() > 0){
             var match = $("#matching_point").val();
             $(".ct-chart .ct-series-b").find(".ct-point:eq("+match+")").addClass("intersec_point");
             $(".ct-chart .ct-series-a").find(".ct-point:eq("+match+")").addClass("intersec_point");
            }
            
          }
          
        });

        $(e.currentTarget.hash).find('.ct-chart12').each(function(el, tab) {
         if(ajaxCompleteFlag==1){
          mychart3.update();
        }
    });

    // enable disable navigation clicks
    if(e.currentTarget.hash=="#tabaffordability" || e.currentTarget.hash=="#step3"){
        $(".leftNavResult").addClass("navwrapper");
    }
    else {
        $(".leftNavResult").removeClass("navwrapper");
    }

    if(e.currentTarget.hash=="#tabroi") {
        $(".rightNavResult").addClass("navwrapper");
    }
    else {
        $(".rightNavResult").removeClass("navwrapper");
    }
  });

    $(".propertyconstruction_section").show();
    $(".propertyrise_section").show();


      $(document).on("change","#buying_type",function(){
        var vl = $(this).val();
        if(vl==1){
          $("#typ1-i1").removeClass("hide");
          $("#typ1-i1").addClass("showInline");
          $("#typ2-i1").removeClass("showInline");
          $("#typ2-i1").addClass("hide");
        }else {
          $("#typ2-i1").removeClass("hide");
          $("#typ2-i1").addClass("showInline");
          $("#typ1-i1").removeClass("showInline");
          $("#typ1-i1").addClass("hide");
        }
    });


     // select from country list
    $(document).on('change','.country-list ',function() {
        var curr_id = parseInt($(this).attr('id').slice($(this).attr('id').lastIndexOf("-")+1)); 
        var cur = $(this).val();
        if(cur=='') {
           $("#pwpropnincome-"+curr_id).html('<i class="fa fa-inr"></i>');
           $("#pwpropnprofit-"+curr_id).html('<i class="fa fa-inr"></i>'); 
        
        }
        else {
           var currencyCode = cur.slice(cur.lastIndexOf("-")+1); 
           $("#pwpropnincome-"+curr_id).html(currencyCode);
           $("#pwpropnprofit-"+curr_id).html(currencyCode); 
        }
    });

    //change in property indetified show hide
    $('input[type=radio][name=property_identified]').change(function() {
      if (this.value == '2') {
          $('.propertyother_section').addClass('hidden');
      }
      else if (this.value == '1') {
        var pty = $('input[type=radio][name=property_type]:checked').val();
        if(!(pty=='3' || pty=='7' || pty=='9'))  
            $('.propertyother_section').removeClass('hidden');
      }
    });

/* Surendar first page changes for IDFC tools begins */
$(document).on("change","#ap_resident",function(){

  var ap_emptype = $("#ap_emptype").val();
  var ap_resident = $(this).val();

  if(ap_resident == '')
    return false;

  if(ap_resident=='1'){
    $("#ap_prepo").html("an");
    $("#ap_city").removeClass("hide");
    $("#ap_city").addClass("showInline");
    $("#ap_residentcountry").removeClass("showInline");
    $("#ap_residentcountry").addClass("hide");

  }else if(ap_resident=='2'){
    $("#ap_prepo").html("a");

    $("#ap_residentcountry").removeClass("hide");
    $("#ap_residentcountry").addClass("showInline");
    $("#ap_city").removeClass("showInline");
    $("#ap_city").addClass("hide");

  }




  if(ap_emptype == ''){
    return false;
  }else {
    changeUserType('p');

  }

 return false;

});

$(document).on("change","#ap_emptype",function(){

  var ap_emptype = $(this).val();
  var ap_resident = $("#ap_resident").val();

  if(ap_emptype == '')
    return false;

  if(ap_resident == ''){
    return false;
  }else {
    changeUserType('p');

  }


 return false;
 
});



$(document).on("change","#cp_resident",function(){

  var ap_emptype = $("#cp_emptype").val();
  var ap_resident = $(this).val();

  if(ap_resident == '')
    return false;

  if(ap_resident=='1'){

    $("#cp_prepo").html("an");

    $("#cp_city").removeClass("hide");
    $("#cp_city").addClass("showInline");
    $("#cp_residentcountry").removeClass("showInline");
    $("#cp_residentcountry").addClass("hide");

  }else if(ap_resident=='2'){

    $("#cp_prepo").html("a");


    $("#cp_residentcountry").removeClass("hide");
    $("#cp_residentcountry").addClass("showInline");
    $("#cp_city").removeClass("showInline");
    $("#cp_city").addClass("hide");

  }




  if(ap_emptype == ''){
    return false;
  }else {
    changeUserType('c');

  }

 return false;

});

$(document).on("change","#cp_emptype",function(){

  var ap_emptype = $(this).val();

  var ap_resident = $("#cp_resident").val();

  if(ap_emptype == '')
    return false;

  if(ap_resident == ''){
    return false;
  }else {
    changeUserType('c');

  }

    $('.income_amount').each(function(e,v) {
        var inc = $(this).val().replace(/,/g, "");
        inc = (ap_emptype == 1) ? (inc/12) : inc;
        if(inc != '') {
           if(e == 1) {

            $('#cp_grossincome').val(parseInt(inc));
            $('#cp_netincome').val(parseInt(inc));
           }
        }
    });
    $('.formattedNumberField').autoNumeric('destroy');

    $('.formattedNumberField').each(function(index, value){
      $(this).autoNumeric('init',{aPad:false});
    }); 

 return false;
 
});


  $("#cp_have").on("change",function(){
    if(this.checked) {
        $(".idfcloanperson2").removeClass("hide");

       
    }else {
        $(".idfcloanperson2").addClass("hide");

    }

      $('.memb_name').each(function(i,v){
     
          if(i == 1) {
            var a = $(this).val();
            $('#cp_name').val(a);
          }
        });

      $('.dob_date').each(function(e,v) {
            if(e == 1) {
              var d = ($(this).val()).split("-");
              age = d[1]+'/'+d[0]+'/'+d[2];
              age = getAge(age);
              $('#cp_age').val(age);
            }
          });
    
  });


  $("#otherSources").on("change",function(){

    if(this.checked) {
        $(".idfcloanincomesource").removeClass("hide");
    }else {
        $(".idfcloanincomesource").addClass("hide");
    }
    
  });

   $("#emi_available").on("change",function(){

     if(this.checked) {
        $(".idfcloanotherincome").removeClass("hide");
    }else {
        $(".idfcloanotherincome").addClass("hide");
    }
    
  });


    $("#property_identified").on("change",function(){

     if(this.checked) {
        $(".idfcloanpropidfy").removeClass("hide");
    }else {
        $(".idfcloanpropidfy").addClass("hide");
    }
    
  });



/* Surendar first page changes for IDFC tools Ends */

    // change in employment type
    $(document).on('change', 'input[type=radio][name*="nemploy"]', function() {
        var curr_id = parseInt($(this).attr('id').slice($(this).attr('id').lastIndexOf("-")+1)); 
        if(this.value==1) {
          if(!$(".emppro-"+curr_id).hasClass('hidden')){
               $(".empinc-"+curr_id).removeClass('hidden');
               $(".empnonprof-"+curr_id).removeClass('hidden');
               $(".emppro-"+curr_id).addClass('hidden');
               $("#cmp_lbl-"+curr_id).html("Existing");
               $("#wrk_lbl-"+curr_id).html("Working");
          }
        }
        else if(this.value==2){
          if(!$(".empinc-"+curr_id).hasClass('hidden')){
               $(".emppro-"+curr_id).removeClass('hidden');
               $(".empnonprof-"+curr_id).removeClass('hidden');
               $(".empinc-"+curr_id).addClass('hidden');
               $("#cmp_lbl-"+curr_id).html("Your");
               $("#wrk_lbl-"+curr_id).html("Operating");
          }
        }   
        else if(this.value==3){
          if(!$(".empinc-"+curr_id).hasClass('hidden')){
            $(".empnonprof-"+curr_id).addClass('hidden');
            $(".emppro-"+curr_id).removeClass('hidden');
            $(".empinc-"+curr_id).addClass('hidden');
            $("#cmp_lbl-"+curr_id).html("Your");
            $("#wrk_lbl-"+curr_id).html("Operating");
          }
        }   
    });

    $(document).on('change','input[type=radio][name*="st_propidentify"]',function() {
        if(this.value==1){
          $('.prop-details-sec').show();
        }
        else {
          $('.prop-details-sec').hide();
        }
    });
    
    // change in resident type
    $(document).on('change','input[type=radio][name*="restatus"]',function() {
        var curr_id = parseInt($(this).attr('id').slice($(this).attr('id').lastIndexOf("-")+1)); 
        if(this.value==1){
          $("#oinrinc-"+curr_id).addClass('hidden');
          $("#lis-con-"+curr_id).html(" ");
          $("#pwpropnincome-"+curr_id).html('<i class="fa fa-inr"></i>');
          $("#pwpropnprofit-"+curr_id).html('<i class="fa fa-inr"></i>'); 
        }
        else if(this.value==2){
          $("#oinrinc-"+curr_id).removeClass('hidden');
          $.getJSON( "includes/country.json", function( out ) {
              var input = {id:curr_id,data:out};
              var theTemplateScript = $("#countryList-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript); 
              $("#lis-con-"+curr_id).append(theTemplate(input)); 
               refreshSection();
          });
        }       
    });

    // next step action: other than last step procced to next for last step submit form to ajax
    $(".btn-action-calculator").on("click",function() {
        if ($parsley.validate({ group: 'block-' + curIndex() })) {            
            navigateTo(curIndex() + 1);
        }
        else {
          return false;
        }
        

        /* Final Step Ajax Call */
        if($(this).attr('id')=='proceed-step1a'){
          var income = 0;
          $('.income_amount').each(function(e,v) {
            if($(this).val() != '') {
              var inc = $(this).val().replace(/,/g, "");
              income += parseInt(inc);
            }
          });

           pmayResult(income);
        }
        else if($(this).attr('id')=='proceed-step2'){
          $('.memb_name').each(function(i,v){
            if(i == 0) {
              var a = $(this).val();
              $('#ap_name').val(a);
            }
          });

          $('.dob_date').each(function(e,v) {
            if(e == 0) {
              var d = ($(this).val()).split("-");
              age = d[1]+'/'+d[0]+'/'+d[2];
              age = getAge(age);
              $('#ap_age').val(age);
            }
          });
         // var data = JSON.stringify($("#affordableCalc").serializeArray());
          //var d = $("#affordableCalc").serializeArray();
        }
        else if($(this).attr('id')=='proceed-step3') {
          if(!$('#errorBtn').hasClass('hidden'))
                  $('#errorBtn').addClass('hidden');
          if($('#resultLoader').hasClass('hidden'))
                  $('#resultLoader').removeClass('hidden');

          $("#errorMsg").html("");  
          $("#loadingmodal").modal('show');

          var loan = $(".loan_amount_slider").val();
          var tenor = $(".tenor_slider").val();
          var cash_hand = $(".cashhand_slider").val();
          performCalculation(loan, tenor, cash_hand);
          //RETURN FALSE UNTIL U GOT THE RESULT
          return false;
        } 

        //from proceed-step2 seperate step 2
        var next_step = $(this).attr('id').slice($(this).attr('id').lastIndexOf("-")+1); 
        $('#myTab a[href="#' + next_step + '"]').addClass("valid-pass");
        $('#myTab a[href="#' + next_step + '"]').tab('show');
        $('html,body').scrollTop(100);
        $("#current_step").html(next_step.substring(4));

    });

    // Recompute the offers based on loan, tenor
    $(document).on('click', '.btn-recomputeoffer', function(e) {
        e.preventDefault();
        var loan = $(".loan_amount_slider").val();
        var tenor = $(".tenor_slider").val();
        var cash_hand = $(".cashhand_slider").val();

        $("#errorMsg").html("");  
        $("#loadingmodal").modal('show');
        performSimulation(loan,tenor, cash_hand,1);
    });

     $(document).on('click', '.btn-cashhand-compute', function(e) {
        e.preventDefault();
        var loan = $(".loan_amount_slider").val();
        var tenor = $(".tenor_slider").val();
        var cash_hand = $(".cashhand_slider").val();

        $("#errorMsg").html("");  
        $("#loadingmodal").modal('show');
        performSimulation(loan,tenor,cash_hand,2);
    });
    // result page left right navigate

    $(document).on("click", ".idfcfilterddmenu", function(e){
      e.stopPropagation(); 
    });


    // Bhamasa Details
    $(document).on('click', '.btn-fatchbhamasa', function(e) {
        e.preventDefault();
        var b_id = $("#bhamasa_id").val();
         $.ajax({  
          type: "POST",
          url: "includes/corefunction.php?calc=bhamasadetails",
          data: {'bhamasa_id': b_id},
          dataType: 'json',
          beforeSend: function() {
            var loader = '<center><img class="" src="img/gears.gif"> <br/>';
            loader += '<h5 class="text-primary">Please wait.. </h5></center>';
            $('#bhamasa-result').html(loader);
          },
          success: function (result) 
          {  
            if(result != '0'){
              var theTemplateScript = $("#bhamasa-details-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('#bhamasa-result').html(theTemplate(result));
              $('.property-section').show(); 

              $('.formattedNumberField').autoNumeric('destroy');

              $('.formattedNumberField').each(function(index, value){
               $(this).autoNumeric('init',{aPad:false});
              }); 
            }
            else {
              var theTemplateScript = $("#nobhamasa-details-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('#bhamasa-result').html(theTemplate(result));
              $('.property-section').hide(); 
            }
          }
        });
    });

});


  function getAge(dateString) 
{
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) 
    {
        age--;
    }
    return age;
}

  function pmayResult(income) {
      $.ajax({  
          type: "POST",
          url: "includes/corefunction.php?calc=pmayeligible",
          data: {'income': income},
          dataType: 'json',
          beforeSend: function() {
            $("#loadingmodal").modal('show');
          },
          success: function (result) 
          {   
            if(result) {
              var theTemplateScript = $("#pmay-result-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('#pmay-result').html(theTemplate(result)); 
            }
            else {
              var theTemplateScript = $("#pmay-noresult-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('#pmay-result').html(theTemplate(result)); 
            }

            $('.formattedNumberField').autoNumeric('destroy');

            $('.formattedNumberField').each(function(index, value){
              $(this).autoNumeric('init',{aPad:false});
            }); 
            $("#loadingmodal").modal('hide');
              
          }
      });
  }

  function performCalculation(loan,tenor,cash_hand) {
      var fid = $("#affordableCalc")[0];
      var formData = new FormData(fid);
      formData.append('cash_hand', cash_hand);
      formData.append('simulate_loan', loan);
      formData.append('simulate_tenor', tenor);
      formData.append('recompute_flag', 0);

      lastSerialezedData = $("#affordableCalc").serialize();
      $.ajax({  
          type: "POST",
          url: "includes/corefunction.php?calc=applyloan",
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          beforeSend: function() {
            //console.log("before send");
          },
          success: function (result) 
          {   
              json_out = $.parseJSON(result); 
              var theTemplateScript = $("#recompute-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('.recompute-menus').html(theTemplate(json_out.result)); 

              var theTemplateScript = $("#schemelist-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('.schemewise-offers').html(theTemplate(json_out.result));  

              dynamic_bind(); 
              ajaxCompleteFlag = 1;
                
              $('#myTab a[href="#step1"]').addClass("valid-pass");
              $('#myTab a[href="#step2"]').addClass("valid-pass");
              $('#myTab a[href="#step3"]').addClass("valid-pass");
              $('#myTab a[href="#step3"]').tab('show');
              $('html,body').scrollTop(100);
              $("#current_step").html("3");

              $("#loadingmodal").modal('hide');
          },
          error: function (jqXHR, exception) {
              var msg = '';
              if (jqXHR.status === 0) {
                  msg = 'Not connect.\n Verify Network.';
              } else if (jqXHR.status == 404) {
                  msg = 'Requested page not found. [404]';
              } else if (jqXHR.status == 500) {
                  msg = 'Internal Server Error [500].';
              } else if (exception === 'parsererror') {
                  msg = 'Requested JSON parse failed.';
              } else if (exception === 'timeout') {
                  msg = 'Time out error.';
              } else if (exception === 'abort') {
                  msg = 'Ajax request aborted.';
              } else {
                  msg = 'Uncaught Error.\n' + jqXHR.responseText;
              }

              $('#errorMsg').html("<p>"+msg+"</p>");
              $('#errorBtn').removeClass('hidden');
              $('#resultLoader').addClass('hidden');
          }
      });
  }


  function performSimulation(loan,tenor,cash_hand, type) {
      var fid = $("#affordableCalc")[0];
      var formData = new FormData(fid);
      formData.append('cash_hand', cash_hand);
      formData.append('simulate_loan', loan);
      formData.append('simulate_tenor', tenor);
      formData.append('recompute_flag', 1);
      formData.append('compute_type', type);

      lastSerialezedData = $("#affordableCalc").serialize();
      $.ajax({  
          type: "POST",
          url: "includes/corefunction.php?calc=applyloan",
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          beforeSend: function() {
            //console.log("before send");
          },
          success: function (result) 
          {   
              json_out = $.parseJSON(result); 
              var theTemplateScript = $("#schemelist-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
             // $('#available_offers').html(theTemplate(json_out.result));
              $('.schemewise-offers').html(theTemplate(json_out.result));   

              dynamic_bind(); 
              ajaxCompleteFlag = 1;

              $('.dropdown-toggle').parent().removeClass('open');
                
              $('#myTab a[href="#step1"]').addClass("valid-pass");
              $('#myTab a[href="#step2"]').addClass("valid-pass");
              $('#myTab a[href="#step3"]').addClass("valid-pass");
              $('#myTab a[href="#step2"]').tab('show');
              $('html,body').scrollTop(100);
              $("#current_step").html("2");

              $("#loadingmodal").modal('hide');
          },
          error: function (jqXHR, exception) {
              var msg = '';
              if (jqXHR.status === 0) {
                  msg = 'Not connect.\n Verify Network.';
              } else if (jqXHR.status == 404) {
                  msg = 'Requested page not found. [404]';
              } else if (jqXHR.status == 500) {
                  msg = 'Internal Server Error [500].';
              } else if (exception === 'parsererror') {
                  msg = 'Requested JSON parse failed.';
              } else if (exception === 'timeout') {
                  msg = 'Time out error.';
              } else if (exception === 'abort') {
                  msg = 'Ajax request aborted.';
              } else {
                  msg = 'Uncaught Error.\n' + jqXHR.responseText;
              }

              $('#errorMsg').html("<p>"+msg+"</p>");
              $('#errorBtn').removeClass('hidden');
              $('#resultLoader').addClass('hidden');
          }
      });
  }

  function navigateTo(index) {
      // Mark the current section with the class 'current'
      $sections.removeClass('current').eq(index).addClass('current');
  }

  function curIndex() {
    // Return the current index by looking at which section has the class 'current'
    return $sections.index($sections.filter('.current'));
  }

  // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
  refreshSection = function(){
   // $(".affordableCalc").parsley({ excluded: "input[type=button], input[type=submit], input[type=reset], input[type=hidden], [disabled], :hidden" });
    $sections.each(function(index, section) {
      $(section).find(':input').attr('data-parsley-group', 'block-' + index);
    });
  }


  //functions added surendar 0908 begins

  function changeUserType(itm){

    if(itm == 'p') // primary user !
    {
      var ap_emptype = $("#ap_emptype").val();
      var ap_resident = $("#ap_resident").val();
   
      if(ap_emptype == '1' && ap_resident == '1'){
      var theTemplateScript = $("#tab1-psindian-template").html();
      }
      else if(ap_emptype == '1' && ap_resident == '2'){
      var theTemplateScript = $("#tab1-psnri-template").html();
 
      }
      else if(ap_emptype == '2' && ap_resident == '1'){
      var theTemplateScript = $("#tab1-pspindian-template").html();

      }
      else if(ap_emptype == '2' && ap_resident == '2'){
    
      var theTemplateScript = $("#tab1-pspnri-template").html();

      }
      else if(ap_emptype == '3' && ap_resident == '1'){

      var theTemplateScript = $("#tab1-psnpindian-template").html();

      }
      else if(ap_emptype == '3' && ap_resident == '2'){
        
      var theTemplateScript = $("#tab1-psnpnri-template").html();
       
      }

      var theTemplate = Handlebars.compile(theTemplateScript);
      $('#ppersontype').html(theTemplate());


        $('.income_amount').each(function(e,v) {
          var inc = $(this).val().replace(/,/g, "");
          inc = (ap_emptype == 1) ? (inc/12) : inc;
          if(inc != '') {
             if(e == 0) {
              $('#ap_grossincome').val(parseInt(inc));
              $('#ap_netincome').val(parseInt(inc));
             }
          }
      });

    }
    else if(itm == 'c'){

          var ap_emptype = $("#cp_emptype").val();
      var ap_resident = $("#cp_resident").val();
   

     if(ap_emptype == '1' && ap_resident == '1'){
      var theTemplateScript = $("#tab1-csindian-template").html();
      }
      else if(ap_emptype == '1' && ap_resident == '2'){
      var theTemplateScript = $("#tab1-csnri-template").html();
 
      }
      else if(ap_emptype == '2' && ap_resident == '1'){
      var theTemplateScript = $("#tab1-cspindian-template").html();

      }
      else if(ap_emptype == '2' && ap_resident == '2'){
    
      var theTemplateScript = $("#tab1-cspnri-template").html();

      }
      else if(ap_emptype == '3' && ap_resident == '1'){

      var theTemplateScript = $("#tab1-csnpindian-template").html();

      }
      else if(ap_emptype == '3' && ap_resident == '2'){
        
      var theTemplateScript = $("#tab1-csnpnri-template").html();
       
      }


      var theTemplate = Handlebars.compile(theTemplateScript);
      $('#cpersontype').html(theTemplate());

    }

    dynamic_bind();
    refreshSection();

  }

  //functions added surendar 0909 ends 

  function SchemelistHTML(data) {
    var html = '<h3 class="text-center">Matched Offers</h3><div class="clearfix"></div>';
      html += '<table class="table table-striped table-bordered table-condensed" id="accordion">';
      html += '<thead><tr><th>Bank</th><th>Product Type</th><th>Intrest Rate</th><th>EMI</th>';
      html += '<th>Loan Eligible</th><th>View More</th></tr></thead><tbody>';
      html += data+'</tbody></table>';
    $('.matched-schemelist').html(html);  
  }

  function dynamic_bind() {
      // Product inside filter range
      $(".intperiod_slider").ionRangeSlider({
        type: "single",
        grid: true,
        min: 0,
        max: 36,
        from: 20,
        to: 50,
        postfix: " months",
        onFinish: function (data) {
          /* Call API to compute */
          var interest_period = data.from;
          var $input = data.input;
          var id_arr = ($input.prop('id')).split('-');
          scheme_id = id_arr[1];
          var emi_eligible = $input.data('emi');
          emi_eligible = emi_eligible.replace(/,/g, "");
          var int_rate = $input.data('interest');
          var max_tenure = $input.data('tenure');
          var final_loan = $input.data('loan');
          var income = $input.data('income');
          final_loan = final_loan.replace(/,/g, "");

          $.ajax({  
            type: "POST",
            url: "includes/corefunction.php?calc=boosterplan",
            data: {'income':income,'emi_eligible':emi_eligible, 'int_rate':int_rate, 'max_tenure':max_tenure, 'final_loan':final_loan, 'interest_period':interest_period},
            dataType: 'json',
            beforeSend: function() {
              var loading = '<center><img class="" src="img/gears.gif" width="60px" height="60px"> Loading...</center>';
              $('.booster-result-'+scheme_id).html(loading);
            },
            success: function (json_out) {   
              var theTemplateScript = $("#booster-table-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('.booster-result-'+scheme_id).html(theTemplate(json_out));

              emi = '<i class="fa fa-inr"></i>&nbsp;'+json_out.booster_emi;
              $('.booster-emi-'+scheme_id).html(emi);

              loan = '<i class="fa fa-inr"></i>&nbsp;'+json_out.booster_loan;
              $('.booster-loan-'+scheme_id).html(loan);
            }
          });
        }
      });

      // Short & Sweet Simulation
      $(".avgbalance_slider").ionRangeSlider({
        type: "single",
        grid: true,
        min: 0,
        max: 100,
        from: 20,
        to: 50,
        prefix: "Rs.",
        postfix: " K",
        onFinish: function (data) {
          /* Call API to compute */
          var avg_balance = (parseInt(data.from) * 1000);
          var $input = data.input;
          var id_arr = ($input.prop('id')).split('-');
          scheme_id = id_arr[1];
          var emi_eligible = $input.data('emi');
          emi_eligible = emi_eligible.replace(/,/g, "");
          var int_rate = $input.data('interest');
          var max_tenure = $input.data('tenure');
          var final_loan = $input.data('loan');
          final_loan = final_loan.replace(/,/g, "");

          var recur_deposit = $('#recurdep-'+scheme_id).val();
          recur_deposit = parseInt(recur_deposit) * 1000;
          $.ajax({  
            type: "POST",
            url: "includes/corefunction.php?calc=shortandsweet",
            data: {'emi_eligible':emi_eligible, 'int_rate':int_rate, 'max_tenure':max_tenure, 'final_loan':final_loan, 'recur_deposit':recur_deposit, 'avg_balance':avg_balance},
            dataType: 'json',
            beforeSend: function() {
              var loading = '<center><img class="" src="img/gears.gif" width="60px" height="60px"> Loading...</center>';
              $('.shortsweet-result-'+scheme_id).html(loading);
            },
            success: function (json_out) 
            { 
              var theTemplateScript = $("#shortsweet-table-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('.shortsweet-result-'+scheme_id).html(theTemplate(json_out));
            }
          });
        }
      });

      $(".recurdeposit_slider").ionRangeSlider({
        type: "single",
        grid: true,
        min: 0,
        max: 100,
        from: 20,
        to: 50,
        prefix: "Rs.",
        postfix: " K",
        onFinish: function (data) {
          /* Call API to compute */
          var recur_deposit = (parseInt(data.from) * 1000);
          var $input = data.input;
          var id_arr = ($input.prop('id')).split('-');
          scheme_id = id_arr[1];
          var emi_eligible = $input.data('emi');
          emi_eligible = emi_eligible.replace(/,/g, "");
          var int_rate = $input.data('interest');
          var max_tenure = $input.data('tenure');
          var final_loan = $input.data('loan');
          final_loan = final_loan.replace(/,/g, "");

          var avg_balance = $('#avgbal-'+scheme_id).val();
          avg_balance = parseInt(avg_balance) * 1000;
          $.ajax({  
            type: "POST",
            url: "includes/corefunction.php?calc=shortandsweet",
            data: {'emi_eligible':emi_eligible, 'int_rate':int_rate, 'max_tenure':max_tenure, 'final_loan':final_loan, 'avg_balance':avg_balance, 'recur_deposit':recur_deposit},
            dataType: 'json',
            beforeSend: function() {
              var loading = '<center><img class="" src="img/gears.gif" width="60px" height="60px"> Loading...</center>';
              $('.shortsweet-result-'+scheme_id).html(loading);
            },
            success: function (json_out) 
            { 
              var theTemplateScript = $("#shortsweet-table-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('.shortsweet-result-'+scheme_id).html(theTemplate(json_out));
            }
          });
        }
      });

      // Max Saver Simulation
      $(".mx_avgbalance_slider").ionRangeSlider({
        type: "single",
        grid: true,
        min: 0,
        max: 100,
        from: 20,
        to: 50,
        prefix: "Rs.",
        postfix: " K",
        onFinish: function (data) {
          /* Call API to compute */
          var avg_balance = (parseInt(data.from) * 1000);
          var $input = data.input;
          var id_arr = ($input.prop('id')).split('-');
          scheme_id = id_arr[1];
          var emi_eligible = $input.data('emi');
          emi_eligible = emi_eligible.replace(/,/g, "");
          var int_rate = $input.data('interest');
          var max_tenure = $input.data('tenure');
          var final_loan = $input.data('loan');
          final_loan = final_loan.replace(/,/g, "");

          var simple_share = $('#simpleshare-'+scheme_id).val();
          var shortswt_share = $('#sswtshare-'+scheme_id).val();

          var recur_deposit = $('#mxrecurdep-'+scheme_id).val();
          recur_deposit = parseInt(recur_deposit) * 1000;
          $.ajax({  
            type: "POST",
            url: "includes/corefunction.php?calc=maxsaver",
            data: {'simple_share':simple_share, 'shortswt_share':shortswt_share, 'emi_eligible':emi_eligible, 'int_rate':int_rate, 'max_tenure':max_tenure, 'final_loan':final_loan, 'recur_deposit':recur_deposit, 'avg_balance':avg_balance},
            dataType: 'json',
            beforeSend: function() {
              var loading = '<center><img class="" src="img/gears.gif" width="60px" height="60px"> Loading...</center>';
              $('.shortsweet-result-'+scheme_id).html(loading);
            },
            success: function (json_out) 
            { 
              var theTemplateScript = $("#maxsaver-table-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('.shortsweet-result-'+scheme_id).html(theTemplate(json_out));
            }
          });
        }
      });

      $(".mx_recurdeposit_slider").ionRangeSlider({
        type: "single",
        grid: true,
        min: 0,
        max: 100,
        from: 20,
        to: 50,
        prefix: "Rs.",
        postfix: " K",
        onFinish: function (data) {
          /* Call API to compute */
          var recur_deposit = (parseInt(data.from) * 1000);
          var $input = data.input;
          var id_arr = ($input.prop('id')).split('-');
          scheme_id = id_arr[1];
          var emi_eligible = $input.data('emi');
          emi_eligible = emi_eligible.replace(/,/g, "");
          var int_rate = $input.data('interest');
          var max_tenure = $input.data('tenure');
          var final_loan = $input.data('loan');
          final_loan = final_loan.replace(/,/g, "");

          var simple_share = $('#simpleshare-'+scheme_id).val();
          var shortswt_share = $('#sswtshare-'+scheme_id).val();

          var avg_balance = $('#mxavgbal-'+scheme_id).val();
          avg_balance = parseInt(avg_balance) * 1000;
          $.ajax({  
            type: "POST",
            url: "includes/corefunction.php?calc=maxsaver",
            data: {'simple_share':simple_share, 'shortswt_share':shortswt_share,'emi_eligible':emi_eligible, 'int_rate':int_rate, 'max_tenure':max_tenure, 'final_loan':final_loan, 'avg_balance':avg_balance, 'recur_deposit':recur_deposit},
            dataType: 'json',
            beforeSend: function() {
              var loading = '<center><img class="" src="img/gears.gif" width="60px" height="60px"> Loading...</center>';
              $('.shortsweet-result-'+scheme_id).html(loading);
            },
            success: function (json_out) 
            { 
              var theTemplateScript = $("#maxsaver-table-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('.shortsweet-result-'+scheme_id).html(theTemplate(json_out));
            }
          });
        }
      });

      $(".simpleshare_slider").ionRangeSlider({
        type: "single",
        grid: true,
        min: 0,
        max: 100,
        from: 30,
        to: 100,
        postfix: " %",
        onFinish: function (data) {
          /* Call API to compute */
          var simple_share = parseInt(data.from);
          var $input = data.input;
          var id_arr = ($input.prop('id')).split('-');
          scheme_id = id_arr[1];
          var emi_eligible = $input.data('emi');
          emi_eligible = emi_eligible.replace(/,/g, "");
          var int_rate = $input.data('interest');
          var max_tenure = $input.data('tenure');
          var final_loan = $input.data('loan');
          final_loan = final_loan.replace(/,/g, "");

          var shortswt_share = $('#sswtshare-'+scheme_id).val();

          var recur_deposit = $('#mxrecurdep-'+scheme_id).val();
          recur_deposit = parseInt(recur_deposit) * 1000;

          var avg_balance = $('#mxavgbal-'+scheme_id).val();
          avg_balance = parseInt(avg_balance) * 1000;
          $.ajax({  
            type: "POST",
            url: "includes/corefunction.php?calc=maxsaver",
            data: {'simple_share':simple_share, 'shortswt_share':shortswt_share,'emi_eligible':emi_eligible, 'int_rate':int_rate, 'max_tenure':max_tenure, 'final_loan':final_loan, 'recur_deposit':recur_deposit, 'avg_balance':avg_balance},
            dataType: 'json',
            beforeSend: function() {
              var loading = '<center><img class="" src="img/gears.gif" width="60px" height="60px"> Loading...</center>';
              $('.shortsweet-result-'+scheme_id).html(loading);
            },
            success: function (json_out) 
            { 
              var theTemplateScript = $("#maxsaver-table-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('.shortsweet-result-'+scheme_id).html(theTemplate(json_out));
            }
          });
        }
      });

      $(".shortswtshare_slider").ionRangeSlider({
        type: "single",
        grid: true,
        min: 0,
        max: 100,
        from: 70,
        to: 100,
        prefix: "",
        postfix: " %",
        onFinish: function (data) {
          /* Call API to compute */
          var shortswt_share = parseInt(data.from);
          var $input = data.input;
          var id_arr = ($input.prop('id')).split('-');
          scheme_id = id_arr[1];
          var emi_eligible = $input.data('emi');
          emi_eligible = emi_eligible.replace(/,/g, "");
          var int_rate = $input.data('interest');
          var max_tenure = $input.data('tenure');
          var final_loan = $input.data('loan');
          final_loan = final_loan.replace(/,/g, "");

          var simple_share = $('#simpleshare-'+scheme_id).val();

          var recur_deposit = $('#mxrecurdep-'+scheme_id).val();
          recur_deposit = parseInt(recur_deposit) * 1000;

          var avg_balance = $('#mxavgbal-'+scheme_id).val();
          avg_balance = parseInt(avg_balance) * 1000;

          $.ajax({  
            type: "POST",
            url: "includes/corefunction.php?calc=maxsaver",
            data: {'simple_share':simple_share, 'shortswt_share':shortswt_share,'emi_eligible':emi_eligible, 'int_rate':int_rate, 'max_tenure':max_tenure, 'final_loan':final_loan, 'recur_deposit':recur_deposit, 'avg_balance':avg_balance},
            dataType: 'json',
            beforeSend: function() {
              var loading = '<center><img class="" src="img/gears.gif" width="60px" height="60px"> Loading...</center>';
              $('.shortsweet-result-'+scheme_id).html(loading);
            },
            success: function (json_out) 
            { 
              var theTemplateScript = $("#maxsaver-table-template").html();
              var theTemplate = Handlebars.compile(theTemplateScript);
              $('.shortsweet-result-'+scheme_id).html(theTemplate(json_out));
            }
          });
        }
      });

      // Recompute the Customize offer 
      $(".loan_amount_slider").ionRangeSlider({
        type: "single",
        grid: true,
        prefix: "Rs.",
        postfix: " Lakhs",  
        onFinish: function (data) {
          var loan = parseInt(data.from);
          var tenor = parseInt($(".tenor_slider").val());

          // Recompute the  offer value based on tenor loan

          return true;          

          var emi_arr = ($(".emi_slider").val()).split(';');
          var int_arr = ($(".interest_slider").val()).split(';');

          var emi_min = parseInt(emi_arr[0]);
          var emi_max = parseInt(emi_arr[1]);
          var int_min = parseInt(int_arr[0]);
          var int_max = parseInt(int_arr[1]);

          var match_offer = 0;
          var other_offer = 0;

          $('.bankproduct').each(function(e){
            var scheme_id = parseInt($(this).data('scheme_id'));
            var loan = parseInt($(this).data('loan'));
            var emi = parseInt($(this).data('emi'));
            var tenor = parseInt($(this).data('tenor'));
            var loan_flag = 0;
            var emi_flag = 0;
            var tenor_flag = 0;
            if(loan >= loan_min && loan <= loan_max) {
              loan_flag = 1;
            }
            if(emi >= emi_min && emi <= emi_max) {
              emi_flag = 1;
            }
            if(tenor >= tenor_min && tenor <= tenor_max) {
              tenor_flag = 1;
            }

            if(loan_flag == 1 && emi_flag == 1 && tenor_flag == 1) {             
              $('.matchproduct-'+scheme_id).show();
              $(this).hide();
              match_offer = 1;
            }
            else {
              $('.matchproduct-'+scheme_id).hide();
              $(this).show();
              $('.other-offers').show();
              other_offer = 1;
            } 
          });

          if(match_offer == 0) {
            $('.no-matched-offer').show();
          }
          else {
            $('.no-matched-offer').hide();
          }

          if(other_offer == 0) {
            $('.no-other-offer').show();
          }
          else {
            $('.no-other-offer').hide();
          }
        }      
      });

      $(".tenor_slider").ionRangeSlider({
        type: "single",
        grid: true,
        postfix: " Months",
        /*
        onFinish: function (data) {         
          var loan_arr = ($(".loan_amount_slider").val()).split(';');
          var emi_arr = ($(".emi_slider").val()).split(';');

          var tenor_min = parseInt(data.from);
          var tenor_max = parseInt(data.to);
          var loan_min = parseInt(loan_arr[0]);
          var loan_max = parseInt(loan_arr[1]);
          var emi_min = parseInt(emi_arr[0]);
          var emi_max = parseInt(emi_arr[1]);

          var match_offer = 0;
          var other_offer = 0;

          $('.bankproduct').each(function(e){
            var scheme_id = parseInt($(this).data('scheme_id'));
            var loan = parseInt($(this).data('loan'));
            var emi = parseInt($(this).data('emi'));
            var tenor = parseInt($(this).data('tenor'));
            var loan_flag = 0;
            var emi_flag = 0;
            var tenor_flag = 0;
            if(loan >= loan_min && loan <= loan_max) {
              loan_flag = 1;
            }
            if(emi >= emi_min && emi <= emi_max) {
              emi_flag = 1;
            }
            if(tenor >= tenor_min && tenor <= tenor_max) {
              tenor_flag = 1;
            }

            if(loan_flag == 1 && emi_flag == 1 && tenor_flag == 1) {             
              $('.matchproduct-'+scheme_id).show();
              $(this).hide();
              match_offer = 1;
            }
            else {
              $('.matchproduct-'+scheme_id).hide();
              $(this).show();
              $('.other-offers').show();
              other_offer = 1;
            }

          });

          if(match_offer == 0) {
            $('.no-matched-offer').show();
          }
          else {
            $('.no-matched-offer').hide();
          }

          if(other_offer == 0) {
            $('.no-other-offer').show();
          }
          else {
            $('.no-other-offer').hide();
          }
        }
        */
      });

      $(".cashhand_slider").ionRangeSlider({
        type: "single",
        grid: true,
        postfix: " Lakhs"
      });

      //Customize filter range
      $(".emi_slider").ionRangeSlider({
        type: "double",
        grid: true,
        prefix: "Rs.",
        onFinish: function (data) {
          return;
          var int_arr = ($(".interest_slider").val()).split(';');
          var emi_min = parseInt(data.from);
          var emi_max = parseInt(data.to);
          var int_min = parseFloat(int_arr[0]);
          var int_max = parseFloat(int_arr[1]);

          var match_offer = 0;
          var other_offer = 0;
          alert('here');

          $('.matchedproduct').each(function(e){
            var scheme_id = parseInt($(this).data('scheme_id'));
            var intrate = parseFloat($(this).data('intrate'));
            var emi = parseInt($(this).data('emi'));
            var int_flag = 0;
            var emi_flag = 0;
            
            if(intrate >= int_min && intrate <= int_max) {
              int_flag = 1;
            }
            if(emi >= emi_min && emi <= emi_max) {
              emi_flag = 1;
            }            

            if(int_flag == 1 && emi_flag == 1) {             
              var d = $('.matchproduct-'+scheme_id).clone();
              $('.matched-table').append(d);
              $(this).hide();
              match_offer = 1;
            }
            else {
              var d = $('.matchproduct-'+scheme_id).clone();
              $('.unmatched-table').append(d);
              $(this).hide();
              $('.other-offers').show();
              other_offer = 1;
            }

          });

          if(match_offer == 0) {
            $('.no-matched-offer').show();
          }
          else {
            $('.no-matched-offer').hide();
          }

          if(other_offer == 0) {
            $('.no-other-offer').show();
          }
          else {
            $('.no-other-offer').hide();
          }
        }
      }); 

      $(".interest_slider").ionRangeSlider({
        type: "double",
        grid: true,
        postfix: " %",
        onFinish: function (data) {
          return;
          var emi_arr = ($(".emi_slider").val()).split(';');
          var int_min = parseFloat(data.from);
          var int_max = parseFloat(data.to);
          var emi_min = parseInt(emi_arr[0]);
          var emi_max = parseInt(emi_arr[1]);

          var match_offer = 0;
          var other_offer = 0;

          $('.matchedproduct').each(function(e){
            var scheme_id = parseInt($(this).data('scheme_id'));
            var emi = parseInt($(this).data('emi'));
            var intrate = parseFloat($(this).data('intrate'));
            var int_flag = 0;
            var emi_flag = 0;
            if(intrate >= int_min && intrate <= int_max) {
              int_flag = 1;
            }
            if(emi >= emi_min && emi <= emi_max) {
              emi_flag = 1;
            }

            if(int_flag == 1 && emi_flag == 1) {             
              var d = $('.matchproduct-'+scheme_id).clone();
              $('.matched-offers').append(d);
              $(this).hide();
              match_offer = 1;
            }
            else {
              var d = $('.matchproduct-'+scheme_id).clone();
              $('.other-offers').append(d);
              $(this).hide();
              $('.other-offers').show();
              other_offer = 1;
            }

          });

          if(match_offer == 0) {
            $('.no-matched-offer').show();
          }
          else {
            $('.no-matched-offer').hide();
          }

          if(other_offer == 0) {
            $('.no-other-offer').show();
          }
          else {
            $('.no-other-offer').hide();
          }
        }
      }); 

      $('.formattedNumberField').autoNumeric('destroy');

      $('.formattedNumberField').each(function(index, value){
        $(this).autoNumeric('init',{aPad:false});
      }); 

      $('.formattedAgeField').autoNumeric('destroy');


       $('.formattedAgeField').each(function(index, value){
        $(this).autoNumeric('init',{aPad:false,aSep:"",vMax:'80'});
      }); 

      $('.formattedYearField').autoNumeric('destroy');

        $('.formattedYearField').each(function(index, value){
        $(this).autoNumeric('init',{aPad:false,aSep:"",vMax:'2017'});
      }); 

        $('.formattedMonthField').autoNumeric('destroy');

        $('.formattedMonthField').each(function(index, value){
        $(this).autoNumeric('init',{aPad:false,aSep:"",vMax:'12'});
      }); 

        $('.formattedworkExMField').autoNumeric('destroy');

        $('.formattedworkExMField').each(function(index, value){
        $(this).autoNumeric('init',{aPad:false,aSep:"",vMax:'11'});
      }); 

        $('.formattedworkExYField').autoNumeric('destroy');

        $('.formattedworkExYField').each(function(index, value){
        $(this).autoNumeric('init',{aPad:false,aSep:"",vMax:'50'});
      }); 

  }

  function validateAnswers(groupName) {

    var formInstance = $("#affordableCalc").parsley();
    var isValid = formInstance.validate(groupName);

    // Just for debugging:
    $.each(formInstance.fields, function(idx, field) {
        if (typeof field.validationResult === 'boolean') {
            // Validated.
        }  
        else if (field.validationResult.length > 0) {
          console.log(field);
            console.log('Failed: ' + field.validationResult[0].assert.name);
        }
    });

    return isValid;
  }

  function IND_moneyformat(x) {
    x=x.toString();
    var lastThree = x.substring(x.length-3);
    var otherNumbers = x.substring(0,x.length-3);
    if(otherNumbers != '')
    lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
    return res;
  }

  $(document).ready(function(){
    // Add minus icon for collapse element which is open by default
    $(".collapse.in").each(function(){
      $(this).siblings("tr").find(".fa").addClass("fa-chevron-down").removeClass("fa-chevron-up");
    });
    
    // Toggle plus minus icon on show hide of collapse element
    $(".collapse").on('show.bs.collapse', function(){
      $(this).parent().find(".fa").removeClass("fa-chevron-up").addClass("fa-chevron-down");
    }).on('hide.bs.collapse', function(){
      $(this).parent().find(".fa").removeClass("fa-chevron-down").addClass("fa-chevron-up");
    });
  });
