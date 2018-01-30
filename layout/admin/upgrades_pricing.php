<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-inverse rounded shadow">
                    <div class="panel-heading text-white">
                        <div class="pull-left">
                            <h3 class="panel-title text-special">Upgrades Pricing</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label class="font600">Gift <div class="label label-default">Credits</div> </label>
                                <input type="text" name="gift_price" value="<?=$settings->gift_price?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font600">Sticker Pack <div class="label label-default">Credits</div> </label>
                                <input type="text" name="sticker_pack_price" value="<?=$settings->sticker_pack_price?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font600">"Get Featured" Price <div class="label label-default">Credits</div> </label>
                                <input type="text" name="feature_price" value="<?=$settings->feature_price?>" class="form-control">
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