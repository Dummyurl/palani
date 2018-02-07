 <?php 

 if(!empty($gurus)): 
    foreach($gurus as $guru_list):         

        $img1 = '';
        if($guru_list['picture_url'] != '')
        {
            $img1 = $guru_list['picture_url'];

        }
        if($guru_list['profile_img'] != '')
        {
            $file_to_check = FCPATH . '/assets/images/' . $guru_list['profile_img'];
            if (file_exists($file_to_check)) {
                $img1 = base_url() . 'assets/images/'.$guru_list['profile_img'];
            }
        }
        $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
        ?>   



        <a href="<?php echo base_url(); ?>gurus-profile/<?php echo $guru_list['username']; ?>" class="guru-list">

            <?php   // echo $this->db->last_query();            ?>
            <div class="row">
                <div class="col-sm-3 col-xs-4">
                    <div class="guru-details text-center">
                        <?php $city = ($guru_list['city'] != '') ? $guru_list['city'] : ""; ?>
                        <?php $countryname = ($guru_list['country_name'] != '' && $guru_list['city'] != '') ? ', '.$guru_list['country_name'] : $guru_list['country_name']; ?>
                        <div class="guru-img"><img src="<?php echo $img; ?>" height="100" width="100" alt="Guru" class="img-circle"></div>
                        <div class="guru-name"><?php echo $guru_list['first_name']." ".$guru_list['last_name']; ?></div>
                        <div class="guru-country"><?php echo $city.$countryname; ?></div>
                        <div class="price"><span class="currency">$</span> <span class="amount"><?php echo ($guru_list['mentor_charge'] != '') ? $guru_list['mentor_charge'] : '0.00'; ?></span>/hour</div>
                    </div>
                </div>
                <div class="col-sm-9 col-xs-8">
                    <h4 class="guru-title"><?php echo $guru_list['mentor_personal_message']; ?></h4>
                    <div class="ratings">
                        <?php for($i=1; $i<=5 ;$i++) {
                            if($i <= $guru_list['rating_value']){
                             ?>
                             <i class="fa fa-star" style="color:#ffc513 !important;"></i>
                             <?php }else{ ?>
                             <i class="fa fa-star"></i>
                             <?php } 
                         } ?>

                         <span class="rating-count"><?php echo ($guru_list['rating_value'] > 0) ? $guru_list['rating_value'] : '0'; ?></span>
                         <span class="total-rating">(<?php echo ($guru_list['rating_count'] > 0) ? $guru_list['rating_count'] : '0'; ?>)</span>
                     </div>
                     <p><?php echo $guru_list['mentor_job_desc']; ?></p>
                     <span class="read-more">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></span>
                 </div>
             </div>
         </a>
     <?php endforeach; endif;  ?>
     <?php if(!empty($loadcount)): ?>
        <div class="load-more-btn text-center">
           <button class="btn btn-default loadmore-a" data-page="<?php echo $loadcount; ?>"><i class="fa fa-refresh"></i> Load More</button>
       </div>
   <?php else: ?>
    <div class="load-more-btn text-center">No More Gurus</div>
<?php endif; ?>