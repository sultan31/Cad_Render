<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Log</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">

    <!-- third party css -->
    <link href="<?php echo base_url();?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

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

    <link href="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />


</head>

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": false}'>

<!-- Begin page -->
<div id="wrapper">

    <!-- Topbar Start -->
    <?php $this->load->view('common/header');?>
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->
    <?php $this->load->view('common/sidebar');?>
    <!-- Left Sidebar End -->

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
                            <h4 class="page-title"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?> Log</h4>
                        </div>
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
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                

                                

                                <div class="table-responsive">
                                      
                                    <table class="table table-hover table-bordered m-0 table-centered ">
                                        <thead class="thead-light">
                                        <tr>
                                            
                                            <th>#</th>
                                            <th>Order Number</th>
                                            <th>Category</th>
                                            <th>Client</th>
                                            <th>Order Date</th>
                                            <th>Type</th>
                                            <th>Remark</th>
                                            <th>File Path</th>
                                            <th>Client Design No</th>
                                            <th>PO No</th>
                                            <th>Order Description</th>
                                            <th>File Type</th>
                                            <th>Product Type</th>
                                            <th>F</th>
                                            <th>Rhodium Instructions</th>
                                            <th>Order Type</th>
                                            <th>Center Prong Type</th>
                                            <th>Master Location</th>
                                            <th>image Gold Tone</th>
                                            <th>image Angles</th>
                                            <th>image Background</th>
                                            <th>image Shdaow</th>
                                            <th>image Logo</th>
                                            <th>image Logo Location</th>
                                            <th>i Frame Logo</th>
                                            <th>image Gemstone Details</th>
                                            <th>image Output</th>
                                            <th>image Resolution</th>
                                            <th>image Size</th>
                                            <th>image Remarks</th>
                                            <th>image Text Logo</th>
                                            <th>video Gold Tone</th>
                                            <th>video Type</th>
                                            <th>video Rhodium Instruction</th>
                                            <th>video Background</th>
                                            <th>video Shadow</th>
                                            <th>video Logo</th>
                                            <th>video Logo Location</th>
                                            <th>video Frame Logo Location</th>
                                            <th>video Gemstone Details</th>
                                            <th>video Output</th>
                                            <th>video Size</th>
                                            <th>video Resolution</th>
                                            <th>video Duration</th>
                                            <th>video Rotation Type</th>
                                            <th>video Remarks</th>
                                            <th>video Text Logo</th>
                                            <th>iv Gold Tone</th>
                                            <th>IV Type</th>
                                            <th>IV Rhodium Instruction</th>
                                            <th>IV Background</th>
                                            <th>IV Shadow</th>
                                            <th>IV Logo</th>
                                            <th>IV Logo Location</th>
                                            <th>IV Frame Logo</th>
                                            <th>IV Gemstone Details</th>
                                            <th>IV Output</th>
                                            <th>IV Frame Size</th>
                                            <th>IV Rotation</th>
                                            <th>IV Remarks</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                         $this->db->select('*');
                                         $this->db->from('website_order_log');
                                         $this->db->where('portal_order_id', $portal_order_id);                                      

                                         $this->db->order_by('id', 'DESC');
                                        $res = $this->db->get();
                                        // pre($this->db->last_query());
                                        $row = $res->result_array();
                                        $i = 0;
                                        foreach($row as $r)
                                        {
                                            $i++;
                                            ?>
                                            <tr id="order_id_"<?php echo $r['id'];?>>
                                                
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $r['type'] == 'CAD' ? '<a href="'.base_url().'production_orders/form_view/port/'.$r['order_number'].'">'.$r['order_number'].'</a>' : '<a href="'.base_url().'portal_orders/form_view/view/'.$r['id'].'">'.$r['order_number'].'</a>'; ?></td>
                                                <td><?php echo $r['category']; ?></td>
                                                <td><?php echo $r['client_name']; ?></td>
                                                <td><?php echo date('Y-m-d', strtotime($r['order_date'])); ?></td>
                                                <td><?php echo $r['type']; ?></td>
                                                <td><?php echo $r['remark']; ?></td>
                                                <td>
                                                    <?php
                                                        if(isset($r['file_path']) && $r['file_path'] != '')
                                                        {
                                                    ?>
                                                            <button type="button" onclick="file_path(<?php echo $r['id']; ?>);" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;"><i class="fe-eye vertical-middle"></i> View</button>
                                                                   
                                                    <?php
                                                        }
                                                    ?>
                                                </td>

                                                <td><?php echo $r['client_design_no']; ?></td>
                                                <td><?php echo $r['po_no']; ?></td>
                                                <td><?php echo $r['order_description']; ?></td>
                                                <td><?php echo $r['file_type']; ?></td>
                                                <td><?php echo $r['prod_type']; ?></td>
                                                <td><?php echo $r['findings']; ?></td>
                                                <td><?php echo $r['rhodium_instructions']; ?></td>
                                                <td><?php echo $r['order_type']; ?></td>
                                                <td><?php echo $r['center_prong_type']; ?></td>
                                                <td><?php echo $r['master_location']; ?></td>
                                                <td><?php echo $r['i_gold_tone']; ?></td>
                                                <td><?php echo $r['i_angles']; ?></td>
                                                <td><?php echo $r['i_bg_color']; ?></td>
                                                <td><?php echo $r['i_shdaow']; ?></td>
                                                <td><?php echo $r['i_logo']; ?></td>
                                                <td><?php echo $r['i_logo_location']; ?></td>
                                                <td><?php echo $r['i_frame_logo']; ?></td>
                                                <td><?php echo $r['i_gemstone_details']; ?></td>
                                                <td><?php echo $r['i_output']; ?></td>
                                                <td><?php echo $r['i_resolution']; ?></td>
                                                <td><?php echo $r['i_size']; ?></td>
                                                <td><?php echo $r['i_remarks']; ?></td>
                                                <td><?php echo $r['image_text_logo']; ?></td>
                                                <td><?php echo $r['v_gold_tone']; ?></td>
                                                <td><?php echo $r['video_type']; ?></td>
                                                <td><?php echo $r['v_rhodium_instruction']; ?></td>
                                                <td><?php echo $r['v_bg_color']; ?></td>
                                                <td><?php echo $r['v_shadow']; ?></td>
                                                <td><?php echo $r['v_logo']; ?></td>
                                                <td><?php echo $r['v_logo_location']; ?></td>
                                                <td><?php echo $r['v_frame_logo_location']; ?></td>
                                                <td><?php echo $r['v_gemstone_details']; ?></td>
                                                <td><?php echo $r['v_output']; ?></td>
                                                <td><?php echo $r['v_size']; ?></td>
                                                <td><?php echo $r['v_resolution']; ?></td>
                                                <td><?php echo $r['v_duration']; ?></td>
                                                <td><?php echo $r['v_rotation_type']; ?></td>
                                                <td><?php echo $r['v_remarks']; ?></td>
                                                <td><?php echo $r['video_text_logo']; ?></td>
                                                <td><?php echo $r['iv_gold_tone']; ?></td>
                                                <td><?php echo $r['iv_type']; ?></td>
                                                <td><?php echo $r['iv_rhodium_instruction']; ?></td>
                                                <td><?php echo $r['iv_bg_color']; ?></td>
                                                <td><?php echo $r['iv_shadow']; ?></td>
                                                <td><?php echo $r['iv_logo']; ?></td>
                                                <td><?php echo $r['iv_logo_location']; ?></td>
                                                <td><?php echo $r['iv_frame_logo']; ?></td>
                                                <td><?php echo $r['iv_gemstone_details']; ?></td>
                                                <td><?php echo $r['iv_output']; ?></td>
                                                <td><?php echo $r['iv_frame_size']; ?></td>
                                                <td><?php echo $r['iv_rotation']; ?></td>
                                                <td><?php echo $r['iv_remarks']; ?></td>

                                            </tr>
                                            <?php
                                        }
                                        ?>

                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
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
<?php $this->load->view('common/footer');?>

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

<!-- Plugins js-->
<script src="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/clockpicker/bootstrap-clockpicker.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- Init js-->
<script src="<?php echo base_url();?>assets/js/pages/form-pickers.init.js"></script>


<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>
<script type="text/javascript">
   function copyToClipboard(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      alert('textt = '+$(element).text());
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
    }
</script>
<?php $this->load->view('common/change_password');?>
</body>
</html>