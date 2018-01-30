<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-inverse rounded shadow">
                    <div class="panel-heading text-white">
                        <div class="pull-left">
                            <h3 class="panel-title text-special">Email Settings</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label class="font600">Email Sender</label>
                                <input type="text" name="email_sender" value="<?=$settings->email_sender?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font600">SMTP Host</label>
                                <input type="text" name="smtp_host" value="<?=$settings->smtp_host?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font600">SMTP Username</label>
                                <input type="text" name="smtp_username" value="<?=$settings->smtp_username?>" class="form-control">
                            </div>
                            <div class="form-group">SMTP Password</label>
                                <input type="text" name="smtp_password" value="<?=$settings->smtp_password?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font600">SMTP Encryption</label>
                                <select name="smtp_encryption" class="chosen">
                                <option value="tls" <?php if($settings->smtp_encryption == 'tls') { echo 'selected'; } ?>> TLS </option>
                                <option value="tls" <?php if($settings->smtp_encryption == 'ssl') { echo 'selected'; } ?>> SSL </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font600">SMTP Port</label>
                                <input type="text" name="smtp_port" value="<?=$settings->smtp_port?>" class="form-control">
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