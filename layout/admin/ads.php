<section id="page-content">

    <!-- Start body content -->
    <div class="body-content animated fadeIn">

        <div class="row">
            <div class="col-lg-12">
                <?php //if($pages->num_rows >= 1) { ?>
                <table class="table table-responsive table-inverse">
                 <thead>
                    <th style="text-align:center;"> Encounter </th>
                    <th style="text-align:center;"> Name </th>
                    <th style="text-align:center;"> Email </th>
                    <th style="text-align:center;"> Requests </th>
                    <th style="text-align:center;"> On Date </th>
                    <th style="text-align:center;"> Status </th>
                    <th style="text-align:center;"> Options </th>
                </thead>
                <tbody>
                    <?php while($encounter = $encounters->fetch_object()) { ?>
                    <tr>
                        <td style="vertical-align:middle;width:100px;text-align:center;"> <?=$encounter->id?> </td>
                        <td style="vertical-align:middle;text-align:center;"> <?=$encounter->full_name?> </td>
                        <td style="vertical-align:middle;text-align:center;"><?=$encounter->email?></td>
                        <td style="vertical-align:middle;text-align:center;"> <?=$encounter->requests?> </td>
                        <td style="vertical-align:middle;text-align:center;"> <?=$encounter->encounter_date?> </td>
                        <td style="vertical-align:middle;text-align:center;"> <?php
                            if($encounter->accepted==1){
                                echo 'Approved';
                            }else{
                                echo 'Pending';
                            }
                        ?> </td>
                        <td style="vertical-align:middle;text-align:center;">
                            <a href="<?=$system->getDomain()?>/ajax/adminEncounters.php?encounter=<?=$encounter->id?>&user1=<?=$encounter->user1?>&user2=<?=$encounter->user2?>" class="btn btn-theme"> <i class="fa fa-heart" style="color:#fff;"></i> </a> 
                            <!--<a href="edit-page.php?id=<?//=$page->id?>" class="btn btn-theme"> <i class="fa fa-pencil" style="color:#fff;"></i> </a> -->
                            <a href="?delete=true&delid=<?//=$page->id?>" class="btn btn-theme"> <i class="fa fa-trash" style="color:#fff;"></i> </a>
                        </td>
                    </tr>
                    <? } ?>
                </tbody>
            </table>
            <? //} ?>

        </div>
    </div>

</div>
<!--/ End body content -->

</section>