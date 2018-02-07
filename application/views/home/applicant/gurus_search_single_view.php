
<div class="widget">
    <div class="widget-heading widget-default b-b-0 clearfix">
      
        <h3 class="widget-title pull-left"><?php 

        echo $count; ?> Matches for your search</h3>
        <div class="sort-by pull-right">
            <div class="form-group">
                <select class="select form-control ordering">
                    <option value="Rating" 
                    <?php if(!empty($_POST['order_by']) && $_POST['order_by'] == 'Rating'){ echo 'selected="selected"'; } ?> >Rating</option>
                    <option value="Popular" <?php if(!empty($_POST['order_by']) && $_POST['order_by'] == 'Popular'){ echo 'selected="selected"'; } ?> >Popular</option>
                    <option value="Latest" <?php if(!empty($_POST['order_by']) && $_POST['order_by'] == 'Latest'){ echo 'selected="selected"'; } ?> >Latest</option>
                    <option value="Free" <?php if(!empty($_POST['order_by']) && $_POST['order_by'] == 'Free'){ echo 'selected="selected"'; } ?> >Free</option>
                </select>
            </div>
        </div>
        <div class="sort-text pull-right">
            <span>Sort by</span>
        </div>

    </div>
</div> 
<div id="guru-list"> 
    <?php 

        if(!empty($gurus)): 
            foreach($gurus as $guru_list):
            
            $profile_img = '';
            if(isset($guru_list['profile_img'])&&!empty($guru_list['profile_img'])){
                $profile_img = $guru_list['profile_img'];
            }  
            $social_profile_img = '';
            if(isset($guru_list['picture_url'])&&!empty($guru_list['picture_url'])){
                $social_profile_img = $guru_list['picture_url'];
            }  
            $img1 = '';
            if($social_profile_img != ''){
                $img1 = $social_profile_img;
            }
            if($profile_img != ''){
                $file_to_check = FCPATH . '/assets/images/' . $profile_img;
                if (file_exists($file_to_check)) {
                    $img1 = base_url() . 'assets/images/'.$profile_img;
                }
            }
            $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';

            ?>   




            <a href="<?php echo base_url(); ?>gurus-profile/<?php echo $guru_list['username']; ?>" class="guru-list">
                <div class="row">
                    <div class="col-sm-3 col-xs-4">
                        <div class="guru-details text-center">
                            <?php $city = ($guru_list['city'] != '') ? $guru_list['city'] : ""; ?>
                            <?php $countryname = ($guru_list['country_name'] != '' && $guru_list['city'] != '') ? ', '.$guru_list['country_name'] : $guru_list['country_name']; ?>
                            <div class="guru-img"><img src="<?php echo $img; ?>" height="100" width="100" alt="Guru" class="img-circle"></div>
                            <div class="guru-name"><?php echo $guru_list['first_name']." ".$guru_list['last_name']; ?></div>
                            <div class="guru-country"><?php echo $city.$countryname; ?></div>
                            <?php 

                            if($guru_list['charge_type'] == 'charge' ){ 
                                ?>
                                <div class="price">
                                    <span class="currency">$</span>
                                    <span class="amount"><?php echo ($guru_list['mentor_charge'] != '') ? $guru_list['mentor_charge'] : '0.00'; ?></span>/hour
                                </div>
                                <?php  }else{  ?>
                                <div class="price">
                                    <button class="btn btn-primary btn-xs">Free</button>
                                </div>
                                <?php }  ?>

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
               <?php if($count > 5): ?>
                <div class="load-more-btn text-center">
                 <button class="btn btn-default loadmore-guru" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
             </div>
         <?php else: ?>
            <div class="load-more-btn text-center">No More Gurus</div>
        <?php endif; ?>
    </div>