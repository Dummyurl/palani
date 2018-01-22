<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php 

    $title = 'SchoolGuru';
    if($this->uri->segment(1) == 'dashboard'){
        $title = 'Dashboard';
    }
    if($this->uri->segment(1) == 'calendar'){
        $title = 'Calendar';
    }
    if($this->uri->segment(1) == 'mentors'){
        $title = 'Guru';
    }
    if($this->uri->segment(1) == 'applicants'){
        $title = 'Applicants';
    }
    if($this->uri->segment(1) == 'messages'){
        $title = 'Messages';
    }
    if($this->uri->segment(1) == 'conversations'){
        $title = 'Conversations';
    }

    ?>

    <title><?php echo $title; ?> - SchoolGuru</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()."assets/" ?>images/favicon.png"> 
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/dist/bootstrapValidator.css" type="text/css">
    <script src="<?php echo base_url()."assets/" ?>js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
    <script src="<?php echo base_url()."assets/" ?>js/sinch.min.js"></script>
    <?php if($this->uri->segment(1) == 'dashboard' || $this->uri->segment(2) =='dashboard#_=_' || $this->uri->segment(2) == 'dashboard'){ ?>
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/dist/cropper.min.css">
    <link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/dist/main.css"> 
    <style>
    #loading-img {
        background: url(<?php echo base_url();?>assets/css/img/loading.gif) center center no-repeat;
        height: 100%;
        z-index: 20;
    }
    .overlay {
        background: #e9e9e9;
        display: none;
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        opacity: 0.5;
        z-index: 999;
        overflow: auto;
        margin: auto;
    }
    .star {width:25px;height:25px; position:relative; float:left;}

    .available_calendar {

        max-width: 900px;

        margin: 0 auto;

    }

    #tfriday,#tmonday,#ttuesday,#twednesday,#tthursday,#tsaturday,#tsunday{

        height: 300px;

    }   

</style>

<?php } ?>

<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/bootstrap-datetimepicker.min.css" type="text/css">

<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/font-awesome.min.css" type="text/css">

<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/jquery.mCustomScrollbar.min.css" type="text/css">

<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/style.css" type="text/css">



<?php if($this->uri->segment(1) == 'calendar'){ ?>

<link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

<link rel="stylesheet" href="<?php echo base_url()."assets/" ?>css/fullcalendar.min.css" type="text/css">

<?php } ?>

<?php if($this->uri->segment(2) == 'schedule_guru'){ ?>



<?php } ?>

<style>

.fa-star{color:#D3D3D3;}

#rating_modal .fa-star{color:#D3D3D3;font-size:30px;}

.gray{color:#D3D3D3;}

.yellow{color:#ffc513;}

</style>

</head>



<body>



    <div class="overlay">

        <div id="loading-img"></div>

    </div>

    <?php $currentuser = get_userdata(); ?>

    <div id="verified" style="display:none;"><?php echo $currentuser['is_verified']; ?></div>
    <input type="hidden" id="sinch_username" value="<?php echo $currentuser['username']; ?>">
    <input type="hidden" id="user_role" value="<?php echo $currentuser['role']; ?>">
    <input type="hidden" id="uri_segment" value="<?php echo $this->uri->segment(1); ?>">
    <input type="hidden" id="uri_segments" value="<?php echo $this->uri->segment(2); ?>">
    <header class="header">
    	<div class="container-fluid">
         <div class="row">
             <div class="col-sm-2 top1">
                 <div class="logo"><a href="<?php echo base_url();?>user/dashboard"><img src="<?php echo base_url()."assets/" ?>images/logo.png" alt="SchoolGuru" title="SchoolGuru"></a></div>
             </div>
             <div class="col-sm-7 top2">
                 <div class="mainnav">
                  <ul>
                    <li><a class="<?php echo ($this->uri->segment(1) == 'dashboard') ? 'active': ''; ?> " href="<?php echo base_url();?>dashboard"><i aria-hidden="true" class="fa fa-user"></i> Profile</a></li>

                    <li><a class="<?php echo ($this->uri->segment(1) == 'calendar' || $this->uri->segment(1) == 'list-view') ? 'active': ''; ?> " href="<?php echo base_url();?>calendar"><i aria-hidden="true" class="fa fa-calendar"></i> Calendar</a></li>

                    <?php if($this->session->userdata('role') == 0): ?>

                        <li><a class="<?php echo ($this->uri->segment(1) == 'mentors') ? 'active': ''; ?> " href="<?php echo base_url();?>mentors"><i aria-hidden="true" class="fa fa-user-circle"></i> Gurus</a></li>

                    <?php endif; ?>

                    <?php if($this->session->userdata('role') == 1): ?>

                        <li><a class="<?php echo ($this->uri->segment(1) == 'applicants') ? 'active': ''; ?> " href="<?php echo base_url();?>applicants"><i aria-hidden="true" class="fa fa-user-circle"></i> Applicant</a></li>

                    <?php endif; ?>

                    <li><a class="<?php echo ($this->uri->segment(1) == 'messages') ? 'active': ''; ?> " href="<?php echo base_url();?>messages"><i aria-hidden="true" class="fa fa-comments"></i> Messages</a></li>

                    <li><a class="<?php echo ($this->uri->segment(1) == 'conversations') ? 'active': ''; ?> " href="<?php echo base_url();?>conversations"><i aria-hidden="true" class="fa fa-video-camera"></i> Conversations</a></li>

                </ul>





            </div>

        </div>

        <div class="col-sm-3 top3">
         <div class="rightitem topsearch">
             <div class="topsearchform">
                <form class="titlerightsearch">
                    <input type="search" id="page_common_search" placeholder="Search" autocomplete="off">
                    <div id="divResult"></div>
                </form>
            </div>
        </div>


        <script>

            $("#page_common_search").keyup(function(){ 
                var inputSearch = $(this).val();
                var dataString = 'user_name='+ inputSearch;
                if(inputSearch!=''){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>user/get_user",
                        data: dataString,
                        cache: false,
                        success: function(html)
                        {
//                            console.log(html);


                            if(html){
                                $("#divResult").html(html).show();    
                            }else{
                                $("#divResult").html('').hide();
                            }

                        }
                    });
                }else{
                 $("#divResult").html('').hide();
             }
             return false;    
         });   


            $("#page_common_search").blur(function(){
                setTimeout(function() {
                    $("#divResult").html('').hide();
                    $("#page_common_search").val(''); 
                }, 100);

            });
        </script> 

        <style type="text/css">
        #divResult
        {
            position:absolute;
            width:350px;
            display:none;
            margin-top:-1px;
            border:solid 1px #dedede;
            border-top:0px;
            overflow:hidden;
            border-bottom-right-radius: 6px;
            border-bottom-left-radius: 6px;
            -moz-border-bottom-right-radius: 6px;
            -moz-border-bottom-left-radius: 6px;
            box-shadow: 0px 0px 5px #999;
            border-width: 3px 1px 1px;
            border-style: solid;
            border-color: #333 #DEDEDE #DEDEDE;
            background-color: white;
            color: black;
        }
        .display_box
        {
            padding:4px; border-top:solid 1px #dedede; 
            font-size:12px; height:50px;
        }
        .display_box:hover
        {
            background:#5c65be;
            color:#FFFFFF;
            cursor:pointer;
        }
    </style>
    <?php //exit; ?>
    <div class="rightitem topnotification">
     <div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <a href="<?php echo base_url(); ?>dashboard">                    
            <i class="fa fa-bell-o" aria-hidden="true"></i>
        </a>
        <div class="redcircle" style="display: none;"></div>
    </div>
    <ul class="dropdown-menu">
        <li><h3>Notifications</h3></li>
        <li class="text-center jnotify"><a href="<?php echo base_url();?>dashboard">See All Notifications <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></li>
    </ul>
</div>
<div class="rightitem topprofile">
   <?php 
   $profile_img = '';
   if(isset($currentuser['profile_img'])&&!empty($currentuser['profile_img'])){
    $profile_img = $currentuser['profile_img'];
}  
$social_profile_img = '';
if(isset($currentuser['picture_url'])&&!empty($currentuser['picture_url'])){
    $social_profile_img = $currentuser['picture_url'];
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
<div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <div class="topprfpic "><img class="img-responsive" height="60" width="60" src="<?php echo $img;?>"></div>
</div>
<ul class="dropdown-menu">
    <?php if($currentuser['is_verified'] == 1): ?>
        <li><a href="<?php echo base_url(); ?>user/profile">My Profile</a></li>
        <li><a href="<?php echo base_url(); ?>user/dashboard?account=true">Account Settings</a></li>
        <li><a href="<?php echo base_url(); ?>user/dashboard?account=true">My Account</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="javascript:void(0)" onClick="sinchLogout();">Logout</a></li>
    <?php else: ?>

        <li class="warning-message"><a style="color:orange;"><i class="fa fa-warning"></i> Please verify your email</a></li>

        <li role="separator" class="divider"></li>

        <li><a href="javascript:void(0)" onClick="sinchLogout();">Logout</a></li>

    <?php endif; ?>

</ul>

</div>
</div>
</div>
</div>
</header>



<section class="mainarea">
    <div class="alert alert-success" id="profile_update_success" style="display: none">  </div>
    <div class="alert alert-danger" id="profile_update_error" style="display: none">  </div>
    <div class="container">
        <!-- video call alert notification  -->

        <div class="new_call form-group"></div>
        <audio id="ringback" src='<?php echo base_url();?>assets/css/style/ringback.wav' loop></audio>
        <audio id="ringtone" src='<?php echo base_url();?>assets/css/style/phone_ring.wav' loop></audio>

        <style type="text/css">
        .new_call{
           background: #f6f6f6;
           border-radius: 6px;
           position: fixed;
           right: 34px;
           z-index: 10000;
           top: 91px;
           display: block;    
           border: 1px solid #e9e9e9;
           padding:9px 1px 8px 13px;
       }
       .new_call:empty{
        display: none;
    }
</style>