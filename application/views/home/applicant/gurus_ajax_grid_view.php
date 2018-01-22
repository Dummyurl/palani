<div class="row grid-view user-row">    
         <?php if(!empty($gurus)): ?>
                <?php foreach($gurus as $guru_list): ?>
                <div class="col-sm-4">
                        <a href="<?php echo base_url(); ?>user/gurus_detail/<?php echo $guru_list['app_id']; ?>" class="guru-list">
                                <div class="guru-img">
                                        <img src="<?php echo ($guru_list['profile_img'] != '') ? base_url() . 'assets/images/'.$guru_list['profile_img'] : base_url() . 'assets/images/avatar-01.jpg'; ?>" alt="Guru" class="img-circle" width="150" height="150">
                                </div>
                             <?php $city = ($guru_list['city'] != '') ? $guru_list['city'] : ""; ?>
                             <?php $countryname = ($guru_list['country_name'] != '' && $guru_list['city'] != '') ? ', '.$guru_list['country_name'] : $guru_list['country_name']; ?>
                                <div class="guru-name"><?php echo $guru_list['first_name']." ".$guru_list['last_name']; ?></div>
                                <div class="guru-country"><?php echo $city.$countryname; ?></div>
                                <div class="ratings">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <span class="rating-count">0</span>
                                        <span class="total-rating">(0)</span>
                                </div>
                                <div class="price"><span class="currency">$</span> <span class="amount"><?php echo ($guru_list['mentor_charge'] != '') ? $guru_list['mentor_charge'] : '0.00'; ?></span>/hour</div>
                        </a>
                </div>
         <?php endforeach; endif;  ?> 
</div>
<div class="load-more-btn text-center">
        <button class="btn btn-default"><i class="fa fa-refresh"></i> Load More</button>
 </div>