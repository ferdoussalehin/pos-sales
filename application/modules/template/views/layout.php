<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('includes/head') ?>
    </head>

    <body class="hold-transition sidebar-mini">
        <!-- <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>  -->
      
        <!-- Site wrapper -->
        <div class="wrapper">
 
            <!-- sidebar -->
            <?php $this->load->view('includes/sidebar') ?>
           
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                
            <!-- Main content -->
            <div class="content <?php $gui_segment = $this->uri->segment(1);
            if($gui_segment == 'gui_pos'){echo 'p-0';}else{echo ' ';}
            ?>">

            <?php 
                $gui_p = $this->uri->segment(1);
                if($gui_p != 'gui_pos'){
            ?>    
                <nav aria-label="breadcrumb" class="p-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><i class="pe-7s-home"></i> <?php echo ('home') ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url().$module ?>"><?php echo $module; ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>
            <?php } ?>

            <!-- load messages -->
            <?php $this->load->view('includes/messages') ?>
            <div class="se-pre-con"></div>
            <!-- load custom page -->
            <?php echo $this->load->view($module.'/'.$page) ?>
            </div> <!-- /.content -->
        </div> <!-- /.content-wrapper -->
            
        <?php $this->load->view('includes/footer') ?>
            
    </div> <!-- ./wrapper -->
        <!-- Start Core Plugins-->
    <?php $this->load->view('includes/js') ?>
    <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        
    </div>
    </body>
    <script>
        const site = <?= json_encode(['base_url' => base_url(), 'settings' => $Settings, 'pos_settings' => $pos_settings])?>;
    </script>
</html>
