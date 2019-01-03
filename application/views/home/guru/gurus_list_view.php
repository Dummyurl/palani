 <style type="text/css">
 	 .alert-danger:empty{display: none;}
 </style>
 <link href="<?php echo base_url()."assets/" ?>css/search.css" rel="stylesheet">
 <div class="row">
    <div class="col-sm-4 col-md-3 col-xs-12">
        <div class="theiaStickySidebar leftsidebar">
            <h3 class="filter-title">Filters</h3>
            <div class="form-group">
                <label class="control-label">Gender</label>
                <select class="form-control" name="gender" id="gender">
                    <option value="">No Preference</option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Subject</label>
                <select class="form-control" name="subject" id="subject">
                    <option value="">--Select--</option>   
                    <?php foreach($subjects as $s){
                        echo '<option value="'.$s->subject_id.'">'.$s->subject.'</option>';
                    } ?>                             
                </select> 
            </div>
            <div class="form-group">
                <label class="control-label">Course</label>
                <select class="form-control" name="course" id="course">
                    <option value="">--Select--</option>                                                       
                </select> 
            </div>          
            <div style="color:red;" id="search-error"></div>
            <div class="search-btn">
                <button class="btn btn-primary" type="button" onclick="search_all_mentee(0)">Search</button> <!-- search-left -->
            </div>
             <div class="profile-preview">
                <a class="btn btn-success btn-block" href="#" data-toggle="modal" data-target="#advancedsearch">Advanced Search</a>
            </div>
        </div>
    </div>
    <div class="col-sm-8 col-md-9 col-xs-12">
      <div class="rightsidebar">
        
            <form id="search_all_mentee">
              <div class="row">
          <div class="col-md-12 mentor-search">
            <div class="input-group">
              <input class="pull-left form-control right_top_search"  name="right_top_search"  type="text" placeholder="Search by course or mentee..." value="<?php
              if($this->uri->segment(2)!=''){
                echo $this->uri->segment(2);
                }else{
                  echo set_value('keyword',$this->input->post('keyword'));
                }

                ?>" />
                <span class="input-group-addon">
                  <button type="submit">Search</button>
                </span>
              </div>        
            </div>
            </form>
          </div>
          <div class="row">
            <div class="col-md-12 mentor-sort-by">
              <h3 class="widget-title pull-left">0 Matches for your search</h3>
              <div class="widget mentor-sort-widget pull-right">
                <div class="widget-heading widget-default b-b-0 clearfix">

                  <div class="sort-by pull-right">
                    <div class="form-group">
                      <select class="select form-control" id="orderby" onchange="search_all_mentee(0)"> <!-- ordering -->
                        <option value="">--Select--</option>
                        <!-- <option value="Rating">Rating</option> -->
                        <option value="Popular">Popular</option>
                        <option value="Latest">Latest</option>
                        <!-- <option value="Free">Free</option> -->
                      </select>
                    </div>
                  </div>
                  <div class="sort-text pull-right">
                    <span>Sort by</span>
                  </div>
                </div>
              </div>
              <input type="hidden" name="page" id="page_no_hidden" value="1" >
            </div>
          </div>    



          <div id="guru-list"></div>        
        <div class="load-more-btn text-center hidden" id="load_more_btn">
         <button class="btn btn-default" ><i class="fa fa-refresh"></i> Load More</button>
       </div>
       <div id="no_more" align="center" >No more mentees.</div>
     </div>
   </div>
</div>



 <!-- Modal -->
       <div class="modal fade bs-example-modal-lg" id="advancedsearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Advanced Search</h3>
            </div>
            <div class="alert alert-danger" id="search-advance-error" align="center"></div>
            <form  method="post" id="advance_search_form" autocomplete="off">         

               <div class="modal-body">   
               <div class="row">
                  <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Undergraduate college</label>
                            <input type="text" class="form-control"  id="under_college">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Undergraduate major</label>
                            <input type="text" class="form-control"  id="under_major" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Graduate college</label>
                            <input type="text" class="form-control"  id="graduate_college">
                        </div>
                    </div>                
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Type of degree</label>
                            <input type="text" class="form-control"  id="degree" autocomplete="off">
                        </div>
                    </div>                  
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <input type="text" class="form-control"  id="city" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">State</label>
                            <input type="text" class="form-control"  id="state" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Country</label>
                            <input type="text" class="form-control"  id="country" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>
</div>
</div>
<!-- Modal -->
<style type="text/css">
.guru-det {
    border-right: none;
}
</style>