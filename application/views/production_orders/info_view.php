<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo isset($show_edit) && $show_edit == 'Yes' ? 'Portal Orders' : 'Production Orders';?></title>
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
                            <h4 class="page-title"><?php echo isset($show_edit) && $show_edit == 'Yes' ? 'Portal Orders' : 'Production Orders';?>
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="col-12">
                    <div id="flash_msg">
                        <?php
                        if($this->session->flashdata('message'))
                        {
                            ?>
                                <div class="alert alert-<?php echo $this->session->flashdata('class');?> alert-dismissible bg-<?php echo $this->session->flashdata('class');?> text-white border-0 fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <?php echo $this->session->flashdata('message');?>
                                </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="col-sm-12 text-right">
                    <?php 
                        if(isset($show_edit) && $show_edit == 'Yes')
                            {
                    ?>
                                <button onclick="edit_order('<?php echo $edit_data[0]['id'];?>');" class="btn btn-success mb-2"><i class="mdi mdi-pencil mr-2"></i>Edit</button>
                    <?php
                            }
                    ?>
                    
                </div>

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

                                                <?php
                                                    if($mode == 'prod')
                                                    {
                                                ?>
                                                        <div class="col-lg-3 form-group mb-3 col-lg-4">
                                                        <?php
                                                            $status_data = $this->db->query('SELECT * FROM status WHERE id = '.$edit_data[0]['status'])->result_array();
                                                            
                                                        ?>
                                                        <label>Status: <span><?php echo isset($status_data[0]['status_name']) && !empty($status_data[0]['status_name']) ? '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$status_data[0]['color'].';border:1px solid '.$status_data[0]['color'].';">'.$status_data[0]['status_name'].'</span>' : '';?></span></label>
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
                                                        <label for="i_frame_logo">File Path: <span id="file_path"><?php echo isset($edit_data[0]['file_path']) && !empty($edit_data[0]['file_path']) ? $edit_data[0]['file_path'] : '';?></span>
                                                            <button type="button" onclick="copyToClipboard('#file_path')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">Copy <span class="mdi mdi-content-copy"></span></button>
                                                        </label>
                                                        
                                                </div>
                                                <div class="form-group mb-3 col-lg-4">
                                                        <label for="i_customer_details">Complet File Path: <span id="complet_file_path"><?php echo isset($edit_data[0]['complet_file_path']) && !empty($edit_data[0]['complet_file_path']) ? $edit_data[0]['complet_file_path'] : '';?></span>
                                                            <button type="button" onclick="copyToClipboard('#complet_file_path')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">Copy <span class="mdi mdi-content-copy"></span></button>
                                                        </label>
                                                        
                                                    </div>

                                                    <div class="form-group mb-3 col-lg-4">
                                                    <label>Client Design No: <span><?php echo isset($edit_data[0]['client_design_no']) && !empty($edit_data[0]['client_design_no']) ? $edit_data[0]['client_design_no'] : '';?></span></label>
                                                    </div>

                                                    <div class="form-group mb-3 col-lg-4">
                                                    <label>PO No: <span><?php echo isset($edit_data[0]['po_no']) && !empty($edit_data[0]['po_no']) ? $edit_data[0]['po_no'] : '';?></span></label>
                                                    </div>
                                                <?php   
                                                    }
                                                ?>

                                                
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

<!-- Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Order Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>portal_orders/cad_form_action" method="post" class="parsley-examples">
                        <input type="hidden" id="current_order_id" name="current_order_id" value="">
                        
                        <div class="form-group">
                            <label for="order_number">Order Number <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="order_number" id="order_number" value="" required readonly>
                            
                        </div>
                        <div class="form-group">
                            <label for="category">Category <span style="color:red;">*</span></label>                                                
                            <select class="form-control" name="category" id="category" data-toggle="select2" required>
                                <option value="">Select</option>                                                    
                                <option value="Ring">Ring</option>
                                <option value="Earring">Earring</option>
                                <option value="Pendant">Pendant</option>
                                <option value="Necklace">Necklace</option>
                                <option value="Bangle">Bangle</option>
                                <option value="Bracelet">Bracelet</option>
                                <option value="Tiepin">Tiepin</option>
                                <option value="Cufflink">Cufflink</option>
                                <option value="Brooch">Brooch</option>
                                <option value="Chain">Chain</option>  
                                <option value="Charm">Charm</option>
                            </select>
                        </div>



                        <div class="form-group">
                            <label for="remark">Remark <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="remark" id="remark" value="" placeholder="File Path" required>
                            
                        </div>
                        <div class="form-group">
                            <label for="file_path">File Path <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="file_path" id="file_path" value="" placeholder="File Path" required>
                            
                        </div>
                        
                        
                    <div class="text-right">
                        
                        <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


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

<script type="text/javascript">
    

   function copyToClipboard(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
      $('#flash_msg').html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                    '<span aria-hidden="true">×</span>'+
                                '</button>Copied!'+                                        
                                    '</div>');

      setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000); // <-- time in milliseconds
    }

    
    function edit_order(id) {
        
        $('#edit-modal').modal('toggle');
        $('#current_order_id').val(<?php echo $edit_data[0]['id'];?>);
        $('#order_number').val('<?php echo $edit_data[0]['order_number'];?>');
        $('#category').val('<?php echo $edit_data[0]['category'];?>').trigger('change');
        $('#remark').val('<?php echo $edit_data[0]['remark'];?>');
        $('#file_path').val('<?php echo $edit_data[0]['file_path'];?>');
    }
</script>

</body>
</html>