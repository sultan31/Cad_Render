<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1))).' | View';?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">
    <link href="<?php echo base_url();?>assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="<?php echo base_url();?>assets/css/bootstrap-material.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?php echo base_url();?>assets/css/app-material.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="<?php echo base_url();?>assets/css/bootstrap-material-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="<?php echo base_url();?>assets/css/app-material-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="<?php echo base_url();?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url();?>assets/libs/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
    

</head>

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": false}'>

<!-- Begin page -->
<div id="wrapper">

    <?php $this->load->view('common/header');?>

    <?php $this->load->view('common/sidebar');?>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <!-- <div class="page-title-right">
                                <ol class="breadcrumb m-0">

                                    <li class="breadcrumb-item active"><?php echo ucwords($this->uri->segment(1));?></li>
                                </ol>
                            </div> -->
                            <h4 class="page-title"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?></h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <form action="<?php echo base_url();?>portal_orders/form_action" method="post" enctype="multipart/form-data">

               
                <div class="row">
                    <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <div class="row">
                                            <div class="col-lg-12">

                                                

                                                <div class="row">
                                                    <div class="form-group mb-3 col-lg-4">
                                                        <label>Order No: <span><?php echo isset($edit_data[0]['order_number']) && !empty($edit_data[0]['order_number']) ? $edit_data[0]['order_number'] : '';?></span></label>
                                                        
                                                    </div>                                                    

                                                    <div class="form-group mb-3 col-lg-4">
                                                        <label>Category: <span><?php echo isset($edit_data[0]['category']) && !empty($edit_data[0]['category']) ? $edit_data[0]['category'] : '';?></span></label>
                                                        
                                                    </div>

                                                    

                                                    <div class="form-group mb-3 col-lg-4">
                                                        <label>Client Name: <span><?php echo isset($edit_data[0]['client_name']) && !empty($edit_data[0]['client_name']) ? $edit_data[0]['client_name'] : '';?></span></label>
                                                        
                                                    </div>

                                                    
                                                    <div class="form-group mb-3 col-lg-4">
                                                        <label>Order Date: <span><?php echo isset($edit_data[0]['order_date']) && !empty($edit_data[0]['order_date']) ? date('d F, Y', strtotime($edit_data[0]['order_date'])) : '';?></span></label>

                                                    </div>

                                                    <div class="form-group mb-3 col-lg-4">
                                                    <label for="client_style_no">Type: <span><?php echo isset($edit_data[0]['type']) && !empty($edit_data[0]['type']) ? $edit_data[0]['type'] : '';?></span></label>
                                                    
                                                </div>

                                                <div class="col-lg-3 form-group mb-3 col-lg-4">
                                                    <label for="remark">Remark: <?php echo isset($edit_data[0]['remark']) ? $edit_data[0]['remark'] : '';?>s</label>
                                                    
                                                </div>

                                                <div class="col-lg-3 form-group mb-3 col-lg-4">
                                                        <?php
                                                            $status_data = $this->db->query('SELECT * FROM ms_render_status WHERE id = '.$edit_data[0]['status'])->result_array();

                                                            
                                                        ?>
                                                        <label>Status: <span><?php echo isset($status_data[0]['name']) && !empty($status_data[0]['name']) ? '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$status_data[0]['color'].';border:1px solid '.$status_data[0]['color'].';">'.$status_data[0]['name'].'</span>' : '';?></span></label>
                                                </div>
                                                 <div class="col-lg-3 form-group mb-3 col-lg-4">
                                                        <label for="img_description">Difficulty: <span>                                                     <?php echo isset($edit_data[0]['difficulty_id']) && !empty($edit_data[0]['difficulty_id']) ? $this->master_model->get_one_record('difficulty', 'difficulty_name', $edit_data[0]['difficulty_id']) : '';?>
                                                        </span></label>
                                                        
                                                </div>

                                                <div class="form-group mb-3 col-lg-4">
                                                        <label for="customRadio1">Moved to production by: <span><?php echo isset($edit_data[0]['move_production_by']) && !empty($edit_data[0]['move_production_by']) ? $this->master_model->get_one_record('users', 'full_name', $edit_data[0]['move_production_by']) : '';?></span></span></label>
                                                </div>
                                                <div class="form-group mb-3 col-lg-4">
                                                        <label>Deadline: <span><?php echo isset($edit_data[0]['deadline']) && !empty($edit_data[0]['deadline']) ? date('d F, Y', strtotime($edit_data[0]['deadline'])) : '';?></span></label>
                                                        
                                                        
                                                    </div>
                                                <div class="form-group mb-3 col-lg-4">
                                                        <label for="i_logo_location">Current Designer: <span><?php echo isset($edit_data[0]['assigned_to']) && !empty($edit_data[0]['assigned_to']) ? $this->master_model->get_one_record('users', 'full_name', $edit_data[0]['assigned_to']) : '';?></span></label>
                                                        
                                                </div>
                                                <div class="form-group mb-3 col-lg-4">
                                                        <label for="i_frame_logo">File Path: <span><?php echo isset($edit_data[0]['file_path']) && !empty($edit_data[0]['file_path']) ? $edit_data[0]['file_path'] : '';?></span></label>
                                                        
                                                </div>
                                                <div class="form-group mb-3 col-lg-4">
                                                        <label for="i_customer_details">Complet File Path: <span><?php echo isset($edit_data[0]['complet_file_path']) && !empty($edit_data[0]['complet_file_path']) ? $edit_data[0]['complet_file_path'] : '';?></span></label>
                                                        
                                                    </div>
                                                </div>

                                            </div>
                                           
                                        </div>

                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                        </div><!-- end col -->
                    </div>
                </form>
                <!-- end row -->

            </div> <!-- container -->

        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <script>document.write(new Date().getFullYear())</script> &copy; DEMO
                    </div>
                    <div class="col-md-6">
                        <!-- <div class="text-md-right footer-links d-none d-sm-block">
                            <a href="javascript:void(0);">About Us</a>
                            <a href="javascript:void(0);">Help</a>
                            <a href="javascript:void(0);">Contact Us</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->


<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
<script src="<?php echo base_url();?>assets/js/vendor.min.js"></script>

<!-- Plugin js-->
<script src="<?php echo base_url();?>assets/libs/parsleyjs/parsley.min.js"></script>

<!-- Validation init js-->
<script src="<?php echo base_url();?>assets/js/pages/form-validation.init.js"></script>

<script src="<?php echo base_url();?>assets/libs/selectize/js/standalone/selectize.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/mohithg-switchery/switchery.min.js"></script>

<script src="<?php echo base_url();?>assets/libs/multiselect/js/jquery.multi-select.js"></script>
<script src="<?php echo base_url();?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/jquery-mockjax/jquery.mockjax.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>

<script src="<?php echo base_url();?>assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

<!-- Init js-->
<script src="<?php echo base_url();?>assets/js/pages/form-advanced.init.js"></script>


<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>
<?php $this->load->view('common/change_password');?>
</body>
</html>