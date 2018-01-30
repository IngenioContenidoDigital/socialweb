<section id="page-content">

  <!-- Start body content -->
  <div class="body-content animated fadeIn">

    <div class="row">
      <div class="col-lg-12">
        <br>
        <?php if(isset($_GET['success'])) { echo '<div class="alert alert-success"> <i class="fa fa-check-circle fa-fw"></i> Photo deleted successfully  </div>'; } ?>
        <?php if($photos->num_rows >= 1) { ?>
        <table class="table table-responsive table-inverse">
         <thead>
          <th style="text-align:center;"> # </th>
          <th style="text-align:center;"> Photo </th>
          <th style="text-align:center;"> Uploaded By </th>
          <th style="text-align:center;"> Imported from Instagram </th>
          <th style="text-align:center;"> Date </th>
          <th style="text-align:center;"> Actions </th>
        </thead>
        <tbody>
          <?php while($photo = $photos->fetch_object()) { 
          $uploader = $system->getUserInfo($photo->user_id);
          ?>
          <tr>
            <td style="vertical-align:middle;width:100px;text-align:center;"> <?=$photo->id?> </td>
            <td style="vertical-align:middle;width:100px;text-align:center;"> 
             <a href="<?=$system->getDomain()?>/uploads/<?=$photo->path?>" target="_blank"> <img src="<?=$system->getDomain()?>/uploads/<?=$photo->path?>" style="height:100px;width:100px" data-toggle="tooltip" data-placement="bottom" data-title="Click to view in full size" placeholder="" data-original-title="" title=""> 
             </a>
             <td style="vertical-align:middle;text-align:center;"> <?=$uploader->full_name?> </td>
             <td style="vertical-align:middle;text-align:center;"> 
              <?php
              switch ($photo->is_instagram) {
                case 1:
                echo 'Yes';
                break;
                default:
                echo 'No';
                break;
              }
              ?>
            </td>
            <td style="vertical-align:middle;text-align:center;"> <?=date("F j, Y",$photo->time)?> </td>
            <td style="vertical-align:middle;text-align:center;">
              <a href="<?=$system->getDomain()?>/uploads/<?=$photo->path?>" target="_blank" class="btn btn-theme"> <i class="fa fa-eye" style="color:#fff;"></i> </a>
              <a href="?delete=true&delid=<?=$photo->id?>&path=<?=$photo->path?>" class="btn btn-theme"> <i class="fa fa-trash" style="color:#fff;"></i> </a>
            </td>
          </tr>
          <? } ?>
        </tbody>
      </table>
      <ul class="pagination pagination-lg">
            <?php
            if(($last_page >= $p) && $last_page > 1) {
              for($i=1; $i<=$last_page; $i++) {
                if($i == $p) {
                  echo '<li class="active"> <a href="photos.php?p='.$i.'"> '.$i.' </a> </li>';
                } else {
                  echo '<li> <a href="photos.php?p='.$i.'"> '.$i.' </a> </li>';
                }
              }
            }
            ?>
          </ul>
      <? } ?>

    </div>
  </div>

</div>
<!--/ End body content -->

</section>