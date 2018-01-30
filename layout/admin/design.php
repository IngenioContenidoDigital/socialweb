<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">

                <form action="" method="post">
                    <div class="panel panel-inverse rounded shadow">
                        <div class="panel-heading text-white">
                            <div class="pull-left">
                                <h3 class="panel-title text-special">Design Settings</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="font600">Theme</label>
                                <select name="theme" class="chosen">
                                    <option value="0" <?php if($settings->winter_theme == 0) { echo'selected'; } ?>> Default</option>
                                    <option value="1" <?php if($settings->winter_theme == 1) { echo'selected'; } ?>> Winter</option>
                                </select>
                            </div>
                            <input type="submit" name="save" class="btn btn-theme" value="Save">
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <!--/ End body content -->

    </section>