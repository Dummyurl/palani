 <div class="row">
        
<div class="col-sm-12 col-xs-8">

        <div class="widget">
                <div class="widget-heading widget-default b-b-0 clearfix">
                    <h3 class="widget-title pull-left"><?php echo $count; ?> Matches for your search</h3>
                        <div class="sort-by pull-right">
                                <div class="form-group">
                                        <select class="select form-control">
                                                <option value="latest">Latest</option>
                                        </select>
                                </div>
                        </div>
                        <div class="sort-text pull-right">
                                <span>Sort by</span>
                        </div>

                </div>
        </div>
    <div id="guru-list">
    <?php if(!empty($gurus)): ?>
    <?php foreach($gurus as $guru_list): ?>
          <?php 
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
        <a href="<?php echo base_url(); ?>applicants-profile/<?php echo $guru_list['username']; ?>" class="guru-list">
                <div class="row">
                        <div class="col-sm-3 col-xs-4">
                            <?php $city = ($guru_list['city'] != '') ? $guru_list['city'] : ""; ?>
                            <?php $countryname = ($guru_list['country_name'] != '' && $guru_list['city'] != '') ? ', '.$guru_list['country_name'] : $guru_list['country_name']; ?>
                                <div class="guru-details text-center">
                                        <div class="guru-img"><img src="<?php echo $img; ?>" height="100" width="100" alt="Guru" class="img-circle"></div>
                                        <div class="guru-name"><?php echo $guru_list['first_name']." ".$guru_list['last_name']; ?></div>
                                        <div class="guru-country"><?php echo $city.$countryname; ?></div>
                                </div>
                        </div>
                        <div class="col-sm-9 col-xs-8">
                                <p><?php echo $guru_list['applicant_personal_mess']; ?></p>
                                <span class="read-more">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        </div>
                </div>
        </a>
        <?php endforeach; endif;  ?>

        <?php if($count > 5): ?>
        <div class="load-more-btn text-center">
           <button class="btn btn-default loadmore-applicant" data-page="2"><i class="fa fa-refresh"></i> Load More</button>
        </div>
        <?php endif; ?>
        </div>

    </div>
</div>