<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1))). ' | ';?>Import</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">

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

                                    <li class="breadcrumb-item active"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?></li>
                                </ol>
                            </div> -->
                            <h4 class="page-title"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?></h4>
                        </div>

                        <?php
                        if($this->session->flashdata('msg'))
                        {
                            ?>
                            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <?php echo $this->session->flashdata('msg');?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-box">

                            <form action="<?php echo isset($mode) && $mode == 'cad' ? base_url().'portal_orders/uploadData' : base_url().'portal_orders/uploadDataRender';?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>">
                                <div class="form-group">
                                    <label for="excel_file">Upload Excel</label>
                                    <input type="file" class="form-control" id="excel_file" name="excel_file" required>

                                </div>

                                <div class="form-group mb-0">
                                    <div>
                                        
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    Submit
                                                </button>
                                                <?php
                                                    if(isset($mode) && $mode == 'cad')
                                                    {
                                                ?>
                                                        <a class="btn btn-danger" href="<?php echo base_url();?>assets/sample/order_data.xlsx" style="color:#fff;" download>Download Sample <i class="mdi mdi-file-excel"></i></a>       
                                                <?php
                                                    }
                                                    else
                                                    {
                                                ?>
                                                        <a class="btn btn-danger" href="<?php echo base_url();?>assets/sample/website_order.xlsx" style="color:#fff;" download>Download Sample <i class="mdi mdi-file-excel"></i></a>       
                                                <?php
                                                    }
                                                ?>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end card-box -->
                    </div> <!-- end col-->


                </div>
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

<script src="<?php echo base_url();?>assets/libs/multiselect/js/jquery.multi-select.js"></script>
<script src="<?php echo base_url();?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/jquery-mockjax/jquery.mockjax.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>

<script src="<?php echo base_url();?>assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

<!-- Init js-->
<script src="<?php echo base_url();?>assets/js/pages/form-advanced.init.js"></script>


<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {


        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000); // <-- time in milliseconds

    });
</script>
<?php $this->load->view('common/change_password');?>
</body>
</html>