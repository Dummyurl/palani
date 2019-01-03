<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo html_escape($title); ?> - <?php echo html_escape($settings->site_title); ?></title>
    <meta name="description" content="<?php echo html_escape($description); ?>"/>
    <meta name="keywords" content="<?php echo html_escape($keywords); ?>"/>
    <meta name="author" content="Codingest"/>
    <meta name="robots" content="all"/>
    <meta name="revisit-after" content="1 Days"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:site_name" content="<?php echo $settings->application_name; ?>"/>
<?php if (isset($page_type)): ?>
    <meta property="og:type" content="<?php echo $og_type; ?>"/>
    <meta property="og:title" content="<?php echo html_escape($post->title); ?>"/>
    <meta property="og:description" content="<?php echo html_escape($post->summary); ?>"/>
    <meta property="og:url" content="<?php echo $og_url; ?>"/>
    <meta property="og:image" content="<?php echo $og_image; ?>"/>
    <meta property="og:image:width" content="750"/>
    <meta property="og:image:height" content="415"/>
    <meta name="twitter:card" content=summary/>
    <meta name="twitter:title" content="<?php echo html_escape($post->title); ?>"/>
    <meta name="twitter:description" content="<?php echo html_escape($post->summary); ?>"/>
    <meta name="twitter:image" content="<?php echo $og_image; ?>"/>
<?php else: ?>
    <meta property="og:type" content=website/>
    <meta property="og:title" content="<?php echo html_escape($title); ?> - <?php echo html_escape($settings->site_title); ?>"/>
    <meta property="og:description" content="<?php echo html_escape($description); ?>"/>
    <meta property="og:url" content="<?php echo base_url(); ?>"/>
    <meta name="twitter:card" content=summary/>
    <meta name="twitter:title" content="<?php echo html_escape($title); ?> - <?php echo html_escape($settings->site_title); ?>"/>
    <meta name="twitter:description" content="<?php echo html_escape($description); ?>"/>
<?php endif; ?>

<?php if (empty($settings->favicon_path)): ?>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>blog_assets/img/favicon.png"/>
<?php else: ?>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() . html_escape($settings->favicon_path); ?>"/>
<?php endif; ?>

    <?php echo $primary_font_url; ?>
    <?php echo $secondary_font_url; ?>
    <?php echo $tertiary_font_url; ?>

    <!-- Font-awesome CSS -->
    <link href="<?php echo base_url(); ?>blog_assets/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>blog_assets/bootstrap/css/bootstrap.min.css">

    <!-- Owl-carousel CSS -->
    <link href="<?php echo base_url(); ?>blog_assets/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>blog_assets/plugins/owl-carousel/owl.theme.default.min.css" rel="stylesheet"/>

    <!-- Jquery Confirm CSS -->
    <link href="<?php echo base_url(); ?>blog_assets/plugins/jquery-confirm/jquery-confirm.min.css" rel="stylesheet"/>

    <!-- Magnific Popup CSS -->
    <link href="<?php echo base_url(); ?>blog_assets/css/magnific-popup.css" rel="stylesheet"/>

    <!-- Style CSS -->
    <link href="<?php echo base_url(); ?>blog_assets/css/style.min.css" rel="stylesheet"/>

    <!-- Color CSS -->
    <?php if ($settings->site_color == '') : ?>
        <link href="<?php echo base_url(); ?>blog_assets/css/colors/default.css" rel="stylesheet"/>
    <?php else : ?>
        <link href="<?php echo base_url(); ?>blog_assets/css/colors/<?php echo html_escape($settings->site_color); ?>.css"
              rel="stylesheet"/>
    <?php endif; ?>

    <!-- Responsive CSS -->
    <link href="<?php echo base_url(); ?>blog_assets/css/responsive.min.css" rel="stylesheet"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Jquery -->
    <script src="<?php echo base_url(); ?>blog_assets/js/jquery-1.12.4.min.js"></script>

    <?php echo $settings->google_analytics; ?>
    <?php echo $settings->head_code; ?>

    <?php $this->load->view('blog/partials/_font_style'); ?>

    <script>
        var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csfr_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
        var base_url = '<?php echo base_url(); ?>';
    </script>
</head>
<body>

<!-- header -->
<header id="header">
    <nav class="navbar navbar-inverse" role="banner">
        <div class="container nav-container">
            <div class="navbar-header">

                <div class="social-mobile">
                    <div class="col-sm-12">
                        <div class="row">
                            <ul class="nav navbar-nav">
                                <?php $this->load->view("blog/partials/_social_links"); ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a href="#" data-toggle="modal-search" class="search-icon mobile-search-icon"><i
                            class="fa fa-search"></i></a>

                <a class="navbar-brand" href="<?php echo base_url(); ?>blog">
                    <img src="<?php echo get_logo($settings); ?>" alt="logo">
                </a>

            </div>


            <?php $this->load->view("blog/partials/_nav.php"); ?>


        </div><!--/.container-->
    </nav><!--/nav-->


    <!--search modal-->
    <div class="modal-search">
        <?php echo form_open('search', ['method' => 'get']); ?>
        <div class="container">
            <input type="text" name="q" class="form-control" maxlength="300" pattern=".*\S+.*"
                   placeholder="<?php echo html_escape(trans("search_exp")); ?>" required>
            <i class="fa fa-times s-close"></i>
        </div>
        <?php echo form_close(); ?>
    </div><!-- /.modal-search -->


</header>
<!-- /.header-->




