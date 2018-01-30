<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">

                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="panel rounded shadow">
                        <div class="panel-heading text-center" style="background-color:#2A2A2A;color:#fff;">
                            <p class="inner-all no-margin">
                                <i class="fa fa-users fa-5x"></i>
                            </p>
                        </div>
                        <div class="panel-body text-center">
                            <p class="h4 no-margin text-strong"><span class="counter"><?=number_format($user_count)?></span> Users</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="panel rounded shadow">
                        <div class="panel-heading text-center" style="background-color:#2A2A2A;color:#fff;">
                            <p class="inner-all no-margin">
                                <i class="fa fa-user fa-5x"></i>
                            </p>
                        </div>
                        <div class="panel-body text-center">
                            <p class="h4 no-margin text-strong"><span class="counter"><?=number_format($online_users_count)?></span> Online Users</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="panel rounded shadow">
                        <div class="panel-heading text-center" style="background-color:#2A2A2A;color:#fff;">
                            <p class="inner-all no-margin">
                                <i class="fa fa-image fa-5x"></i>
                            </p>
                        </div>
                        <div class="panel-body text-center">
                            <p class="h4 no-margin text-strong"><span class="counter"><?=number_format($photo_count)?></span> Photos</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4">
                    <div class="panel rounded shadow">
                        <div class="panel-heading text-center" style="background-color:#2A2A2A;color:#fff;">
                            <p class="inner-all no-margin">
                                <i class="fa fa-info-circle fa-5x"></i>
                            </p>
                        </div>
                        <div class="panel-body text-center">
                            <p class="h4 no-margin text-strong">3.3 Version</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="panel panel-inverse rounded shadow">
                        <div class="panel-heading text-white ">
                            <div class="pull-left">
                                <h3 class="panel-title text-special">Online Users</h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                         <?php
                         if($online_users_count >= 1) {
                             while($online_user = $online_users->fetch_object()) { 
                                echo '<a href="'.$system->getDomain.'/user/'.$online_user->id.'">';
                                echo '<img src="'.$system->getProfilePicture($online_user).'" class="img-circle m-5" style="width:50px;height:50px;">';
                                echo '</a>';
                            } 
                        } else {
                            echo 'No users are online at the moment';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="panel panel-inverse rounded shadow">
                    <div class="panel-heading text-white">
                        <div class="pull-left">
                            <h3 class="panel-title text-special">Newest Users</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                       <?php
                       if($user_count >= 1) {
                           while($newest_user = $newest_users->fetch_object()) { 
                            echo '<a href="'.$system->getDomain.'/user/'.$newest_user->id.'">';
                            echo '<img src="'.$system->getProfilePicture($newest_user).'" class="img-circle m-5" style="width:50px;height:50px;">';
                            echo '</a>';
                        } 
                    } else {
                        echo 'No users exist at the moment';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
         <div class="panel panel-inverse rounded shadow">
            <div class="panel-heading text-white">
                <div class="pull-left">
                    <h3 class="panel-title text-special">Get Started</h3>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <ul>
                <li> <a href="ads.php"> Configure Ads </a> </li>
                <li> <a href="payments.php"> Configure Payments </a> </li>
                <li> <a href="https://codecanyon.net/item/matchme-complete-dating-script/12494116/support" target="_blank"> Contact Support </a> </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div id="tour-15" class="blog-item blog-quote rounded shadow">
            <div class="quote quote-inverse">
                <a href="#" class="no-underline">
                    <?=$quote['quote']?>
                    <small class="quote-author">- <?=$quote['author']?> -</small>
                </a>
            </div>
            <div class="blog-details">
                <ul class="blog-meta">
                    <li>Your daily dose of motivation</li>
                </ul>
            </div>
        </div>
    </div>

</div>
</div>

</div>
<!--/ End body content -->

</section>