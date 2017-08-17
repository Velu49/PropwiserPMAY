<div class="clearfix"></div>
<footer>
  <!-- <img src="img/footerbg.png" class="img-responsive"/> -->
<!--   <div class="container">
    <div class="row">
      <div class="col-md-4 footerblock1">
        <h6> About Propwiser </h6>
        <p>
          Propwiser is started with a mission of guiding consumers on financial, loan, taxation, legal and commercial aspects of real estate in India at one central place.
          We strive to offer end to end guidance with respect to steps to be followed and decisions to be taken at each step. 
        </p>
      </div>
      <div class="col-md-4 footerblock2">
        <h6> Real Estate Phases </h6>
        <div class="col-md-6 nonepadding">
          
          <ul class="text-left">
            <li><a href="<?php echo BASE_URL;?>planning.php"><img src="img/icons/iconyes.png"/>Planning</a></li>
            <li><a href="<?php echo BASE_URL;?>buying.php"><img src="img/icons/iconyes.png"/>Buying</a></li>
            <li><a href="<?php echo BASE_URL;?>salepurchase.php"><img src="img/icons/iconyes.png"/>Sale Purchase</a></li>
            
          
          </ul>
        </div>
        <div class="col-md-6 nonepadding">
          <ul class="text-left">
            
            <li><a href="<?php echo BASE_URL;?>portfolios.php"><img src="img/icons/iconyes.png"/>Portfolio</a></li>
            <li><a href="<?php echo BASE_URL;?>selling.php"><img src="img/icons/iconyes.png"/>Selling</a></li>
        
          </ul>
        </div>
      </div>
      <div class="col-md-2 footerblock3">
        <h6> Our Offerings </h6>
        <ul class="text-left">
         <li><a href="<?php echo BASE_URL;?>blog"><img src="img/icons/iconyes.png"/>Articles</a></li>
          <li><a href="<?php echo BASE_URL;?>planningguidehome.php"><img src="img/icons/iconyes.png"/>Guides</a></li>
          <li><a href="<?php echo BASE_URL;?>decisiontools.php"><img src="img/icons/iconyes.png"/>Tools</a></li>
          <li><a style="pointer-events: none; cursor: default;" href=""><img src="img/icons/iconyes.png"/>Journey Apps</a></li>
          <li><a style="pointer-events: none; cursor: default;" href=""><img src="img/icons/iconyes.png"/>Marketplace</a></li>
        </ul>
      </div>
      <div class="col-md-2 footerblock2">
        <h6> Connect with us </h6>
        <ul class="text-left">
          <li><a href="https://facebook.com/propwiser"><img src="img/icons/iconyes.png"/>Facebook</a></li>
          <li><a href="https://twitter.com/propwiserdotcom"><img src="img/icons/iconyes.png"/>Twitter</a></li>
          <li><a href="https://www.linkedin.com/company-beta/10060005/"><img src="img/icons/iconyes.png"/>Linkedin</a></li>
          <li><a href="https://www.youtube.com/channel/UCy3yVyE7pTB-qb7uu86a0iQ"><img src="img/icons/iconyes.png"/>Youtube</a></li>
          <li><a href="about.php"><img src="img/icons/iconyes.png"/>About</a></li>
          <li><a href="contact.php"><img src="img/icons/iconyes.png"/>Contact</a></li>
           </ul>
      </div>
    </div>
    <center><p class="text-teritary">Propwiser &copy; 2016-17 - All Rights Reserved | Icons Credit: <a class="text-teritary" href="http://freepik.com" target="_blank">Freepik</a></p> 
      <p><a href="https://heapanalytics.com/?utm_source=badge" rel="nofollow"><img style="width:108px;height:41px" src="//heapanalytics.com/img/badge.png" alt="Heap | Mobile and Web Analytics" /></a></p></center>
  </div> -->
</footer>

<!-- jQuery -->
<script src="js/plugins/jquery.min.js"></script>
<script src="js/plugins/bootstrap.min.js"></script>
<script src="js/plugins/jquery.easing.min.js"></script>
<script src="js/plugins/parsley.js"></script>
<script src="js/plugins/ion.rangeSlider.min.js"></script>
<!--  <script src="js/plugins/contact_me.js"></script> -->
<script src="js/plugins/jqueryUI.js"></script>
<script src="js/plugins/jqueryuiorg.js"></script>
<script src="js/plugins/chartist.min.js"></script>
<script src="js/plugins/jquery.dataTables.min.js"></script>
<script src="js/plugins/chartist-plugin-legend.js"></script>
<script src="js/plugins/chartist-plugin-tooltip.js"></script>
<script src="js/plugins/chartist-plugin-axistitle.js"></script>
<script src="js/plugins/handlebars-latest.js"></script>
<script src="js/plugins/wow.min.js"></script>
<script src="js/plugins/autoNumeric.js"></script>
<script src="js/plugins/jquery.circliful.js"></script>
<script src="js/plugins/jqBootstrapValidation.js"></script>
<script src="js/plugins/jquery.validate.js"></script>
<script type="text/javascript" src="js/plugins/jquery.multiselect.js"></script>
<script>
  new WOW().init();
  $(function(){
      $(window).scroll(function () {
        if ( $(this).scrollTop() > 1 && !$('.showheader').hasClass('open') ) {
          $('.showheader').addClass('open');
          $('.showheader').fadeIn('slow');
        }
        else if ( $(this).scrollTop() <= 1 ) {
          $('.showheader').removeClass('open');
          $('.showheader').fadeOut('slow',function(){
          });
        }
      });
  });
</script>

<!-- Go to www.addthis.com/dashboard to customize your tools --> 
<!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e3ea6e02c589482"></script> -->
<script type="text/javascript">
  $(document).ready(function(){
    var url = $("#cartoonVideo7").attr('src');
    $("#cartoonVideo7").attr('src', '');
    $("#buythreevideoModal").on('shown.bs.modal', function(){
    $("#cartoonVideo7").attr('src', url);
    });
    $("#buythreevideoModal").on('hide.bs.modal', function(){
    $("#cartoonVideo7").attr('src', '');
    });
  });
</script>


</body>
</html>