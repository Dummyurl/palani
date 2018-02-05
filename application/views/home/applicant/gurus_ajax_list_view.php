    <?php if(!empty($gurus)): ?>
    <?php foreach($gurus as $guru_list): ?>
        <a href="<?php echo base_url(); ?>user/gurus_detail/<?php echo $guru_list['app_id']; ?>" class="guru-list">
                <div class="row">
                        <div class="col-sm-3 col-xs-4">
                                <div class="guru-details text-center">
                                    <?php $city = ($guru_list['city'] != '') ? $guru_list['city'] : ""; ?>
                                    <?php $countryname = ($guru_list['country_name'] != '' && $guru_list['city'] != '') ? ', '.$guru_list['country_name'] : $guru_list['country_name']; ?>
                                        <div class="guru-img"><img src="<?php echo ($guru_list['profile_img'] != '') ? base_url() . 'assets/images/'.$guru_list['profile_img'] : base_url() . 'assets/images/avatar-01.jpg'; ?>" height="100" width="100" alt="Guru" class="img-circle"></div>
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
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <span class="rating-count">0</span>
                                        <span class="total-rating">(0)</span>
                                </div>
                                <p><?php echo $guru_list['mentor_job_desc']; ?></p>
                                <span class="read-more">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                </div>
        </a>
        <?php endforeach; endif;  ?>
        <div class="load-more-btn text-center">
           <button class="btn btn-default"><i class="fa fa-refresh"></i> Load More</button>
        </div>
