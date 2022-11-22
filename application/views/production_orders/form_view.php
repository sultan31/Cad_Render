<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1))). ' | ';?><?php echo isset($edit_data[0]['id']) ? 'Edit' : 'Add';?></title>
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

    <style type="text/css">

label {
    font-weight: 500;
    width: 100%;
}
    </style>

    

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

                
                <form action="<?php echo isset($edit_data[0]['id']) ? base_url().'production_orders/form_action/'.$edit_data[0]['id'] : base_url().'production_orders/form_action';?>" method="post" enctype="multipart/form-data" class="parsley-examples" id="myform">

               
                <div class="row">
                    <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <div class="row">
                                          <div class="form-group mb-3 col-lg-12">
                                              <div class="col-lg-6" style="float:left;">
                                                <label for="order_number">Order No <span style="color:red;">*</span></label>
                                                <input type="text" id="order_number" name="order_number" class="form-control" placeholder="Order No" value="<?php echo isset($edit_data[0]['order_number']) ? $edit_data[0]['order_number'] : '';?>" required>
                                              </div>
                                              <div class="col-lg-6" style="float:left;">
                                                  <label for="category">Category <span style="color:red;">*</span></label>
                                                  <input type="text" id="category" name="category" placeholder="Category" class="form-control" value="<?php echo isset($edit_data[0]['category']) ? $edit_data[0]['category'] : '';?>" required>
                                              </div>
                                              
                                          </div>

                                          <div class="form-group mb-3 col-lg-12">
                                              <div class="col-lg-6" style="float:left;">
                                                <label for="client_design_no">Client Design No <span style="color:red;">*</span></label>
                                                <input type="text" id="client_design_no" name="client_design_no" class="form-control" placeholder="Order No" value="<?php echo isset($edit_data[0]['client_design_no']) ? $edit_data[0]['client_design_no'] : '';?>" required>
                                              </div>
                                              <div class="col-lg-6" style="float:left;">
                                                  <label for="po_no">PO No <span style="color:red;">*</span></label>
                                                  <input type="text" id="po_no" name="po_no" placeholder="PO No" class="form-control" value="<?php echo isset($edit_data[0]['po_no']) ? $edit_data[0]['po_no'] : '';?>" required>
                                              </div>
                                              
                                          </div>


                                          <div class="form-group mb-3 col-lg-12">
                                              <div class="col-lg-6" style="float:left;">
                                                <label for="remark">Remark</label>
                                                <input type="text" id="remark" name="remark" class="form-control" placeholder="Remark" value="<?php echo isset($edit_data[0]['remark']) ? $edit_data[0]['remark'] : '';?>">
                                              </div>
                                              <div class="col-lg-6" style="float:left;">
                                                <label for="file_path">File Path <span style="color:red;">*</span></label>
                                                <input type="text" id="file_path" name="file_path" class="form-control" placeholder="File Path" value="<?php echo isset($edit_data[0]['file_path']) ? $edit_data[0]['file_path'] : '';?>" required>
                                              </div>
                                              
                                          </div>

                                        </div>

                                        <div class="row" style="width:100%;padding-top:20px;">
                                          <div class="form-group mb-3 col-lg-12">
                                              <div class="col-lg-6" style="float:left;">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
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