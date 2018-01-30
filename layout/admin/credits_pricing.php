<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-inverse rounded shadow">
                    <div class="panel-heading text-white">
                        <div class="pull-left">
                            <h3 class="panel-title text-special">Credits Pricing</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label class="font600">100 Credits Price <div class="label label-default"><?=$settings->currency?></div> </label>
                                <input type="text" name="credits_price_100" value="<?php echo $settings->credits_price_100?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font600">500 Credits Price <div class="label label-default"><?=$settings->currency?></div> </label>
                                <input type="text" name="credits_price_500" value="<?php echo $settings->credits_price_500?>" class="form-control">
                            </div>  
                            <div class="form-group">
                                <label class="font600">1000 Credits Price <div class="label label-default"><?=$settings->currency?></div> </label>
                                <input type="text" name="credits_price_1000" value="<?php echo $settings->credits_price_1000?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font600">1500 Credits Price <div class="label label-default"><?=$settings->currency?></div> </label>
                                <input type="text" name="credits_price_1500" value="<?php echo $settings->credits_price_1500?>" class="form-control">
                            </div>    
                            <input type="submit" name="save" class="btn btn-theme" value="Save">
                        </form> 
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--/ End body content -->

</section>