<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-inverse rounded shadow">
                    <div class="panel-heading text-white">
                        <div class="pull-left">
                            <h3 class="panel-title text-special">Payment API Configuration</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label class="font600">Fortumo Service ID</label>
                                <input type="text" name="fortumo_service_id" value="<?php echo $settings->fortumo_service_id?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font600">PayPal Account</label>
                                <input type="text" name="paypal_email" value="<?php echo $settings->paypal_email?>" class="form-control">
                            </div>   
                            <div class="form-group">
                                <label class="font600">Stripe Secret Key</label>
                                <input type="text" name="stripe_secret_key" value="<?php echo $settings->stripe_secret_key?>" class="form-control">
                            </div>   
                            <div class="form-group">
                                <label class="font600">Stripe Publishable Key</label>
                                <input type="text" name="stripe_publishable_key" value="<?php echo $settings->stripe_publishable_key?>" class="form-control">
                            </div>  
                            <div class="form-group">
                                <label class="font600">Currency</label>
                                <select name="currency" class="chosen">
                                    <option value="USD" <?php if($settings->currency == 'USD') { echo 'selected'; } ?>> USD </option>
                                    <option value="EUR" <?php if($settings->currency == 'EUR') { echo 'selected'; } ?>> EUR </option>
                                    <option value="GBP" <?php if($settings->currency == 'GBP') { echo 'selected'; } ?>> GBP </option>
                                </select>
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