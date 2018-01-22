<?php if($this->session->userdata('role') == 0): ?>
<div class="row">
        <div class="col-sm-3 col-xs-4 leftsidebar">
                <div class="theiaStickySidebar">
                        <h3 class="filter-title">Filters</h3>
<div class="form-group">
    <label class="control-label">Gender</label>
    <select class="form-control">
        <option>No Preference</option>
        <option>Male</option>
        <option>Female</option>
    </select>
</div>
<div class="form-group">
    <label class="control-label">Admitted School</label>
    <input type="email" class="form-control">
</div>
<div class="form-group">
    <label class="control-label">School Offers Received</label>
    <input type="email" class="form-control">
</div>
<div class="form-group">
    <label class="control-label">Year of School currently in</label>
    <select class="form-control">
        <option>First Year</option>
        <option>Second Year</option>
        <option>Third Year</option>
        <option>Fourth Year</option>
    </select>
</div>
<div class="search-btn">
    <button class="btn btn-primary" type="button">Search</button>
</div>


                </div>
</div>
        <div class="col-sm-9 col-xs-8">

                <div class="widget">
                        <div class="widget-heading widget-default b-b-0 clearfix">
                                <h3 class="widget-title pull-left">329 Matches for your search</h3>
                                <div class="sort-by pull-right">
                                        <div class="form-group">
                                                <select class="select form-control">
                                                        <option value="">Rating</option>
                                                        <option value="">Popular</option>
                                                        <option value="">Latest</option>
                                                </select>
                                        </div>
                                </div>
                                <div class="sort-text pull-right">
                                        <span>Sort by</span>
                                </div>
                                <div class="view-format pull-right">
                                        <span>View</span> 
                                        <div class="btn-group">
                                                <a id="results-list-view" class="btn btn-default" href="#" title="List View"><i class="fa fa-th-list"></i></a>
                                                <a id="results-grid-view" class="btn btn-default active" href="#" title="Grid View"><i class="fa fa-th"></i></a>
                                        </div>
                                </div>
                        </div>
                </div>
                <div class="row grid-view user-row" >
                    <?php if(!empty($gurus)): ?>
                       <?php foreach($gurus as $guru_list): ?>
                        <div class="col-sm-4">
                                <a href="<?php echo base_url(); ?>user/gurus_detail/<?php echo $guru_list['id']; ?>" class="guru-list">
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
                                </a>
                        </div>
                        <?php endforeach; endif;  ?> 
                </div>
                <div class="load-more-btn text-center">
                   <button class="btn btn-default"><i class="fa fa-refresh"></i> Load More</button>
                </div>
</div>
</div>
<?php else: ?>
<?php $this->load->view('home/guru/gurus_grid_view'); ?>
<?php endif; ?>