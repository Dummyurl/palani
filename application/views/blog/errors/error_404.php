<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">
            <div class="error-404">
                <h1>404</h1>
                <h2><?php echo trans("page_not_found"); ?></h2>
                <p><?php echo trans("page_not_found_sub"); ?></p>
                <a class="btn btn-primary btn-error-back btn-custom btn-go-home" href="<?php echo base_url(); ?>"><?php echo trans("go_to_home"); ?></a>
            </div>
        </div>
    </div>
</section>
<!-- /.Section: main -->

