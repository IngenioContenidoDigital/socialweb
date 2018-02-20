<section id="page-content">
    <div class="row">
        <div class="col-lg-12">
        <div class="container">
            <form action="" method="post" enctype="multipart/form-data">
            <div class="panel bg-white">
                <div class="panel-body" style="padding:10px;">
                <div class="col-md-5 pull-left">
                    <h3><span style="font-size:22px;" class="font600"><?=$lang['Profile_Tab_Title']?></span></h3>
                    <hr class="mt-0">
                        <div class="form-group">
                            <label><?=$lang['Full_Name']?></label>
                            <input type="text" name="full_name" value="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><?=$lang['Gender']?></label>
                            <select name="gender" class="form-control" required>
                                <option value="Male" ><?= $lang['Male'] ?></option>
                                <option value="Female" selected="selected"><?= $lang['Female'] ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?=$lang['Age']?></label>
                            <input type="number" min="15" max="100" name="age" value="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><?=$lang['Height']?></label>
                            <div class="input-group">
                                <input type="number" name="height" min="15" max="220" value="" class="form-control" required>
                                <span class="input-group-addon"><?=$unit['height']?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?=$lang['Weight']?></label>
                            <div class="input-group">
                                <input type="number" name="weight" min="30" max="100" value="" class="form-control" required>
                                <span class="input-group-addon"><?=$unit['weight']?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?=$lang['type']?></label>
                            <select name="is_admin" class="form-control">
                                <option value="0"><?=$lang['type_user']?></option>
                                <option value="2"><?=$lang['type_customer']?></option>
                                <?php if ($user->is_admin==3 || $user->is_admin==1){?>
                                    <option value="1"><?=$lang['type_admin']?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5 pull-left">
                        <h3><span style="font-size:22px;" class="font600"><?=$lang['Account_Tab_Title']?></span></h3>
                        <hr class="mt-0">
                        <div class="form-group">
                            <label><?=$lang['Profile_Photo']?></label>
                            <input type="file" name="profile_photo" class="form-control-file" required>
                        </div>
                        <!--<div class="form-group">
                            <label><?=$lang['Email']?></label>
                            <input type="email" name="email" required value="<?=$user->email?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><?=$lang['New_Password']?></label>
                            <input type="password" required name="new_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><?=$lang['Confirm_Password']?></label>
                            <input type="password" required name="confirm_new_password" class="form-control">
                        </div>-->
                        <div class="form-group">
                            <label><?=$lang['Country']?></label>
                            <select name ="country" class="form-control" required="">
                                <?php
                                echo $system->getCountriesSelect();
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?=$lang['City']?></label>
                            <input type="text" name="city" value="" class="city-autocomplete form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label><?=$lang['Description']?></label>
                            <textarea name="bio" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label><?=$lang['Sexual_Orientation']?></label>
                            <select name="sexual_orientation" class="form-control" required>
                                <option value="1"> <?=$lang['Straight']?> </option>
                                <option value="2"> <?=$lang['Gay']?> </option>
                                <option value="3"> <?=$lang['Lesbian']?> </option>
                                <option value="4"> <?=$lang['Bisexual']?> </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?=$lang['Language']?></label>
                            <select name="website_language" class="form-control">
                                <option value="english">English</option>
                                <option value="español">Espa&ntilde;ol</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" name="save_1" class="btn btn-theme"> <?=$lang['Save']?> </button>
            </form>
            <br>
        </div> 
        </div>
    </div>
</section>