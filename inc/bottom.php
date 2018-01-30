<footer class="footer footer-black">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-9">
        <div class="links">
          <ul class="uppercase-links">
            <?php while($custom_page = $custom_pages->fetch_object()) { ?>
            <li>
              <a href="<?=$system->getDomain()?>/page/<?=$custom_page->id?>">
                <?=$custom_page->page_title?>
              </a>
            </li>
            <? } ?>
          <hr>
          <div class="copyright">
            © <?=date('Y')?> <?=$site_name?>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-md-offset-2 col-sm-2 col-sm-offset-1">
        <div class="social-area">
          <?php if(!empty($settings->facebook_link)) { ?>
          <a href="<?=$settings->facebook_link?>" target="_blank" class="btn btn-icon btn-facebook btn-fill">
            <i class="ti-facebook"></i>
          </a>
          <? } ?>
          <?php if(!empty($settings->twitter_link)) { ?>
          <a href="<?=$settings->twitter_link?>" target="_blank" class="btn btn-icon btn-twitter btn-fill">
            <i class="ti-twitter"></i>
          </a>
          <? } ?>
          <?php if(!empty($settings->google_plus_link)) { ?>
          <a href="<?=$settings->twitter_link?>" target="_blank" class="btn btn-icon btn-google btn-fill">
            <i class="ti-google"></i>
          </a>
          <? } ?>
        </div>
      </div>
    </div>
  </div>
</footer>
<!--  Plugins -->
<script src="<?=$system->getDomain()?>/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="<?=$system->getDomain()?>/assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script src="<?=$system->getDomain()?>/assets/bootstrap3/js/bootstrap.js" type="text/javascript"></script>
<script src="<?=$system->getDomain()?>/assets/js/ct-paper-checkbox.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/bootstrap-select.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/ct-paper-bootstrapswitch.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/jquery.tagsinput.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/lightslider.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/bxslider.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/jquery.easypiechart.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/jquery.gritter.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/autocomplete.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/emojione.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/icomoon.js"></script>
<!-- Main JS -->
<script src="<?=$system->getDomain()?>/assets/js/app.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/theme.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/mobile.js"></script>
<!-- PhotoSwipe -->
<script src="<?=$system->getDomain()?>/assets/js/photo_swipe/photoswipe.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/photo_swipe/photoswipe-ui-default.min.js"></script>
<script src="<?=$system->getDomain()?>/assets/js/photo_swipe/init-gallery.js"></script>
<?=$page['js']?>
<script>
$("#distance-range").slider({
 range:true,
 min: 0,
 max: 500,
 values: [<?=$filter->distance_range?>],
 slide: function (event, ui) {
    var values = ui.values + ' ';
    $("#distance_range_val").val(values);
    var split = values.split(',');
    $("#distance-info").html(split[0]+' - '+split[1]+' km');
  }
});
$("#distance_range_val").val('<?=$filter->distance_range?>');
$("#age-range").slider({
 range:true,
 min: 0,
 max: 100,
 values: [<?=$filter->age_range?>],
 slide: function (event, ui) {
    var values = ui.values + ' ';
    $("#age_range_val").val(values);
    var split = values.split(',');
    $("#age-info").html(split[0]+' - '+split[1]+' years');
  }
});
$("#age_range_val").val('<?=$filter->age_range?>');
$('.easy-pie-chart .percentage').easyPieChart();
</script>
<script>
var handler = StripeCheckout.configure({
  key: '<?=$settings->stripe_publishable_key?>',
  image: '<?=$system->getDomain?>/img/credit-card.png',
  locale: 'auto',
  token: function(token) {
    if(type == 'vip') {
    $.get("<?=$system->getDomain()?>/api/stripe.php?t="+token.id+'&duration='+$('#vip_duration').val()+'&type=vip', function(data) {
      $("#payment-result").html(data);
    });
    } else {
    $.get("<?=$system->getDomain()?>/api/stripe.php?t="+token.id+'&amount='+$('#credit_amount').val()+'&type=credits', function(data) {
      $("#payment-result").html(data);
    }); 
    }
  }
});

$("#stripe_pay").on("click", function(){
  if(type == 'vip') {
  var id = $('#vip_duration').val();
  if(id == 1) {
    vip_price = '<?=$settings->vip_1_month?>';
  } else if(id == 2) {
    vip_price = '<?=$settings->vip_3_months?>';
  } else if(id == 3) {
    vip_price = '<?=$settings->vip_6_months?>';
  }
  if($('#stripe_pay').length) {
  handler.open({
    name: '<?=$site_name?>',
    description: 'VIP Account',
    zipCode: true,
    amount: vip_price*100,
  });
  e.preventDefault();
  }
  } else if(type == 'credits') {
  var amount = $('#credit_amount').val();
  if(amount == 100) {
    credits_price = '<?=$settings->credits_price_100?>';
  } else if(amount == 500) {
    credits_price = '<?=$settings->credits_price_500?>';
  } else if(amount == 1000) {
    credits_price = '<?=$settings->credits_price_1000?>';
  } else if(amount == 1500) {
    credits_price = '<?=$settings->credits_price_1500?>';
  }
  if($('#stripe_pay').length) {
  // Open Checkout with further options:
  handler.open({
    name: '<?=$site_name?>',
    description: 'Credits',
    zipCode: true,
    amount: credits_price*100,
  });
  }
}
});

// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
  handler.close();
});

var pay1 = $('#stripe_pay');
pay1.removeAttr('id');
pay1.attr('id', 'pay');
</script>
<audio id="notification" src="<?=$system->getDomain()?>/assets/notification.mp3">
</body>
</html>