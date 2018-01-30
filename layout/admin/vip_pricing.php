<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-inverse rounded shadow">
                    <div class="panel-heading text-white">
                        <div class="pull-left">
                            <h3 class="panel-title text-special">VIP Account Pricing</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label class="font600">1 Month <div class="label label-default"><?=$settings->currency?></div> </label>
                                <input type="text" name="vip_1_month" value="<?=$settings->vip_1_month?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font600">3 Months <div class="label label-default"><?=$settings->currency?></div> </label>
                                <input type="text" name="vip_3_months" value="<?=$settings->vip_3_months?>" class="form-control">
                            </div>
                             <div class="form-group">
                                <label class="font600">6 Months <div class="label label-default"><?=$settings->currency?></div> </label>
                                <input type="text" name="vip_6_months" value="<?=$settings->vip_6_months?>" class="form-control">
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