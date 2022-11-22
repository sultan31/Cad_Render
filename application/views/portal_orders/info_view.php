<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?> | View</title>
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
        
            .table-bordered td, .table-bordered th {
            border: 1px solid #777;
        }
        td:nth-child(1) {
        font-weight: bold;
    }
        td:nth-child(2) {
                word-break: break-all;
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
    <?php //pre($edit_data); ?>
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            
                            <h4 class="page-title"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?>                             
                                
                            </h4>
                            
                        </div>


                    </div>
                    
                </div>
                <!-- end page title -->
                
                <div class="row">
                    <div class="col-12">
                                <div class="card">
                                    <div class="card-body">



                                        <div class="row mb-2">
                                            <div class="col-sm-12">
                                                <div id="flash_msg">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 text-right">
                                                <?php 
                                                    if(isset($edit_data[0]['id']) && $edit_data[0]['id'] != 0)
                                                        {
                                                            if($this->session->userdata('user_role') == 1 || $this->session->userdata('user_role') == 3 || $this->session->userdata('user_role') == 8)
                                                            {
                                                ?>
                                                                <a href="<?php echo base_url().'portal_orders/form_view/edit/'.$edit_data[0]['id'];?>" class="btn btn-success mb-2"><i class="mdi mdi-pencil mr-2"></i>Edit</a>
                                                <?php
                                                            }
                                                ?>

                                                            <a href="<?php echo base_url().'portal_orders/media_uploded/'.$edit_data[0]['id'];?>" class="btn btn-danger mb-2"><i class="fe-eye vertical-middle mr-2"></i> View Media</a>
                                                <?php
                                                        }
                                                ?>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="row">
                                            <!-- <div class="col-lg-12">
                                                <?php
                                                if($this->uri->segment(1) == 'render_production_orders' && isset($edit_data[0]['id']) && $edit_data[0]['id'] != 0)
                                                {
                                                        if($this->session->userdata('user_role') == 1 || $this->session->userdata('user_role') == 3 || $this->session->userdata('user_role') == 8)
                                                        {
                                                ?>
                                                            <a href="<?php echo base_url().'portal_orders/form_view/edit/'.$edit_data[0]['id'];?>" class="btn btn-success mb-2"><i class="mdi mdi-pencil mr-2"></i>Edit</a>
                                                <?php
                                                        }
                                                ?>


                                                    <a href="<?php echo base_url().'render_production_orders/media_uploded/'.$edit_data[0]['id'];?>" class="btn btn-danger mb-2"><i class="fe-eye vertical-middle mr-2"></i> View Media</a>
                                                <?php
                                                }
                                                ?>
                                                
                                            </div> -->
                                            <div class="col-lg-3">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td colspan="2"><h4>GENERAL</h4></td>
                                                    </tr>
                                                    <tr>
                                                        <td>TCC Style No</td>
                                                        <td><?php echo isset($edit_data[0]['order_number']) && !empty($edit_data[0]['order_number']) ? $edit_data[0]['order_number'] : '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Client Design No</td>
                                                        <td><?php echo isset($edit_data[0]['client_design_no']) && !empty($edit_data[0]['client_design_no']) ? $edit_data[0]['client_design_no'] : '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>PO No</td>
                                                        <td><?php echo isset($edit_data[0]['po_no']) && !empty($edit_data[0]['po_no']) ? $edit_data[0]['po_no'] : '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Order Desc</td>
                                                        <td><?php echo isset($edit_data[0]['order_description']) && !empty($edit_data[0]['order_description']) ? $edit_data[0]['order_description'] : '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>File Type</td>
                                                        <td><?php echo isset($edit_data[0]['file_type']) && !empty($edit_data[0]['file_type']) ? $edit_data[0]['file_type'] : '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Product type</td>
                                                        <td><?php echo isset($edit_data[0]['category']) && !empty($edit_data[0]['category']) ? $edit_data[0]['category'] : '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Findings</td>
                                                        <td><?php echo isset($edit_data[0]['findings']) && !empty($edit_data[0]['findings']) ? $edit_data[0]['findings'] : '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rhodium Instructions</td>
                                                        <td><?php echo isset($edit_data[0]['rhodium_instructions']) && !empty($edit_data[0]['rhodium_instructions']) ? $edit_data[0]['rhodium_instructions'] : '';?></td>
                                                    </tr>

                                                    <tr>
                                                        <td>Order Type</td>
                                                        <td><?php echo isset($edit_data[0]['order_type']) && !empty($edit_data[0]['order_type']) ? $edit_data[0]['order_type'] : '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>File Path</td>
                                                        <td><?php 
                                                                if(isset($edit_data[0]['file_path']) && !empty($edit_data[0]['file_path']))
                                                                {
                                                            ?>
                                                                    <span id="file_path" style="display:none;"><?php echo $edit_data[0]['file_path'];?></span>
                                                                    <button type="button" onclick="copyToClipboard('#file_path')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">Copy <span class="mdi mdi-content-copy"></span></button></td>
                                                            <?php
                                                                } 
                                                            ?>
                                                                
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Remark</td>
                                                        <td><?php echo isset($edit_data[0]['remark']) && !empty($edit_data[0]['remark']) ? $edit_data[0]['remark'] : '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Center Prong Type</td>
                                                        <td><?php echo isset($edit_data[0]['center_prong_type']) && !empty($edit_data[0]['center_prong_type']) ? $edit_data[0]['center_prong_type'] : '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Master Location</td>
                                                        <td><?php 
                                                                if(isset($edit_data[0]['master_location']) && !empty($edit_data[0]['master_location']))
                                                                {
                                                            ?>
                                                                    <span id="master_location" style="display:none;"><?php echo $edit_data[0]['master_location'];?></span>
                                                                    <button type="button" onclick="copyToClipboard('#master_location')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">Copy <span class="mdi mdi-content-copy"></span></button></td>
                                                            <?php
                                                                } 
                                                            ?>
                                                                
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td>Is RR Order?</td>
                                                        <td><?php echo isset($edit_data[0]['only_RR_order']) && !empty($edit_data[0]['only_RR_order']) ? $edit_data[0]['only_RR_order'] : 'No';?></td>
                                                    </tr>
                                                    
                                                </table>
                                            </div>
                                            <?php
                                                $order_type = isset($edit_data[0]['order_type']) && !empty($edit_data[0]['order_type']) ? explode(',', $edit_data[0]['order_type']) : [];

                                                if(in_array('Image', $order_type))
                                                {   
                                                    if($edit_data[0]['only_RR_order'] != 'Yes'){


                                            ?>
                                                    <!--Image-->
                                                    <div class="col-lg-3">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td colspan="2"><h4>Image</h4></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gold Tone</td>
                                                                <td><?php echo isset($edit_data[0]['i_gold_tone']) && !empty($edit_data[0]['i_gold_tone']) ? $edit_data[0]['i_gold_tone'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Image Angles</td>
                                                                <td><?php echo isset($edit_data[0]['i_angles']) && !empty($edit_data[0]['i_angles']) && $edit_data[0]['i_angles'] == 'MN' ? $edit_data[0]['i_angles_mn'] : $edit_data[0]['i_angles'];?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Background</td>
                                                                <td><?php echo isset($edit_data[0]['i_bg_color']) && !empty($edit_data[0]['i_bg_color']) ? $edit_data[0]['i_bg_color'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Image</td>
                                                                <td><?php echo isset($edit_data[0]['i_shdaow']) && !empty($edit_data[0]['i_shdaow']) ? $edit_data[0]['i_shdaow'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Logo</td>
                                                                <td><?php echo isset($edit_data[0]['i_logo']) && !empty($edit_data[0]['i_logo']) ? $edit_data[0]['i_logo'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Logo Location</td>
                                                                <td><?php echo isset($edit_data[0]['i_logo_location']) && !empty($edit_data[0]['i_logo_location']) ? $edit_data[0]['i_logo_location'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Frame Logo</td>
                                                                <td><?php echo isset($edit_data[0]['i_frame_logo']) && !empty($edit_data[0]['i_frame_logo']) ? $edit_data[0]['i_frame_logo'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gemstone Details</td>
                                                                <td><?php echo isset($edit_data[0]['i_gemstone_details']) && !empty($edit_data[0]['i_gemstone_details']) ? $edit_data[0]['i_gemstone_details'] : '';?></td>
                                                            </tr>

                                                            <tr>
                                                                <td>Image Output</td>
                                                                <td><?php echo isset($edit_data[0]['i_output']) && !empty($edit_data[0]['i_output']) ? $edit_data[0]['i_output'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Image Resolution</td>
                                                                <td><?php echo isset($edit_data[0]['i_resolution']) && !empty($edit_data[0]['i_resolution']) ? $edit_data[0]['i_resolution'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Image Size</td>
                                                                <td><?php echo isset($edit_data[0]['i_size']) && !empty($edit_data[0]['i_size']) ? $edit_data[0]['i_size'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Remark</td>
                                                                <td><?php echo isset($edit_data[0]['i_remarks']) && !empty($edit_data[0]['i_remarks']) ? $edit_data[0]['i_remarks'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>image text logo</td>
                                                                <td><?php echo isset($edit_data[0]['image_text_logo']) && !empty($edit_data[0]['image_text_logo']) ? $edit_data[0]['image_text_logo'] : '';?></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </div>       
                                            <?php
                                                }
                                                }
                                                if(in_array('Video', $order_type))
                                                {
                                                    if($edit_data[0]['only_RR_order'] != 'Yes'){
                                            ?>
                                                    <!--Video-->
                                                    <div class="col-lg-3">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td colspan="2"><h4>Video</h4></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gold Tone</td>
                                                                <td><?php echo isset($edit_data[0]['v_gold_tone']) && !empty($edit_data[0]['v_gold_tone']) ? $edit_data[0]['v_gold_tone'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Video Type</td>
                                                                <td><?php echo isset($edit_data[0]['video_type']) && !empty($edit_data[0]['video_type']) ? $edit_data[0]['video_type'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Video Rhodium Instruction</td>
                                                                <td><?php echo isset($edit_data[0]['v_rhodium_instruction']) && !empty($edit_data[0]['v_rhodium_instruction']) ? $edit_data[0]['v_rhodium_instruction'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Video Background</td>
                                                                <td><?php echo isset($edit_data[0]['v_bg_color']) && !empty($edit_data[0]['v_bg_color']) && $edit_data[0]['v_bg_color'] == 'MN' ? $edit_data[0]['v_bg_color_mn'] : $edit_data[0]['v_bg_color'];?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Video Shadow / Reflection</td>
                                                                <td><?php echo isset($edit_data[0]['v_shadow']) && !empty($edit_data[0]['v_shadow']) ? $edit_data[0]['v_shadow'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Logo</td>
                                                                <td><?php echo isset($edit_data[0]['v_logo']) && !empty($edit_data[0]['v_logo']) ? $edit_data[0]['v_logo'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Logo Location</td>
                                                                <td><?php echo isset($edit_data[0]['v_logo_location']) && !empty($edit_data[0]['v_logo_location']) ? $edit_data[0]['v_logo_location'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Frame logo Location</td>
                                                                <td><?php echo isset($edit_data[0]['v_frame_logo_location']) && !empty($edit_data[0]['v_frame_logo_location']) ? $edit_data[0]['v_frame_logo_location'] : '';?></td>
                                                            </tr>

                                                            <tr>
                                                                <td>Gemstone Details</td>
                                                                <td><?php echo isset($edit_data[0]['v_gemstone_details']) && !empty($edit_data[0]['v_gemstone_details']) ? $edit_data[0]['v_gemstone_details'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Video Output</td>
                                                                <td><?php echo isset($edit_data[0]['v_output']) && !empty($edit_data[0]['v_output']) ? $edit_data[0]['v_output'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Video Size</td>
                                                                <td><?php echo isset($edit_data[0]['v_size']) && !empty($edit_data[0]['v_size']) ? $edit_data[0]['v_size'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Video Resolution</td>
                                                                <td><?php echo isset($edit_data[0]['v_resolution']) && !empty($edit_data[0]['v_resolution']) ? $edit_data[0]['v_resolution'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Video Duration</td>
                                                                <td><?php echo isset($edit_data[0]['v_duration']) && !empty($edit_data[0]['v_duration']) && $edit_data[0]['v_duration'] == 'MN' ? $edit_data[0]['v_duration_mn'] : $edit_data[0]['v_duration'];?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Video Rotation</td>
                                                                <td><?php echo isset($edit_data[0]['v_rotation_type']) && !empty($edit_data[0]['v_rotation_type']) ? $edit_data[0]['v_rotation_type'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Remark</td>
                                                                <td><?php echo isset($edit_data[0]['v_remarks']) && !empty($edit_data[0]['v_remarks']) ? $edit_data[0]['v_remarks'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>video text logo</td>
                                                                <td><?php echo isset($edit_data[0]['video_text_logo']) && !empty($edit_data[0]['video_text_logo']) ? $edit_data[0]['video_text_logo'] : '';?></td>
                                                            </tr>
                                                            
                                                        </table>
                                                    </div>       
                                            <?php
                                                }
                                                }
                                                
                                                if(in_array('IV', $order_type))
                                                {
                                                    if($edit_data[0]['only_RR_order'] != 'Yes'){
                                            ?>
                                                    <!--Interactive Video-->
                                                    <div class="col-lg-3">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td colspan="2"><h4>Interactive Video</h4></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gold Tone</td>
                                                                <td><?php echo isset($edit_data[0]['iv_gold_tone']) && !empty($edit_data[0]['iv_gold_tone']) ? $edit_data[0]['iv_gold_tone'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>IV Type</td>
                                                                <td><?php echo isset($edit_data[0]['iv_type']) && !empty($edit_data[0]['iv_type']) ? $edit_data[0]['iv_type'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>iV Rhodium Instruction</td>
                                                                <td><?php echo isset($edit_data[0]['iv_rhodium_instruction']) && !empty($edit_data[0]['iv_rhodium_instruction']) ? $edit_data[0]['iv_rhodium_instruction'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>iV Background</td>
                                                                <td><?php echo isset($edit_data[0]['iv_bg_color']) && !empty($edit_data[0]['iv_bg_color']) && $edit_data[0]['iv_bg_color'] == 'MN' ? $edit_data[0]['iv_bg_color_mn'] : $edit_data[0]['iv_bg_color'];?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>IV Shadow / Reflection</td>
                                                                <td><?php echo isset($edit_data[0]['iv_shadow']) && !empty($edit_data[0]['iv_shadow']) ? $edit_data[0]['iv_shadow'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Logo</td>
                                                                <td><?php echo isset($edit_data[0]['iv_logo']) && !empty($edit_data[0]['iv_logo']) ? $edit_data[0]['iv_logo'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Logo Location</td>
                                                                <td><?php echo isset($edit_data[0]['iv_logo_location']) && !empty($edit_data[0]['iv_logo_location']) ? $edit_data[0]['iv_logo_location'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Frame logo</td>
                                                                <td><?php echo isset($edit_data[0]['iv_frame_logo']) && !empty($edit_data[0]['iv_frame_logo']) ? $edit_data[0]['iv_frame_logo'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gemstone Details</td>
                                                                <td><?php echo isset($edit_data[0]['iv_gemstone_details']) && !empty($edit_data[0]['iv_gemstone_details']) ? $edit_data[0]['iv_gemstone_details'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>iV Output</td>
                                                                <td><?php echo isset($edit_data[0]['iv_output']) && !empty($edit_data[0]['iv_output']) ? $edit_data[0]['iv_output'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>iV Frame</td>
                                                                <td><?php echo isset($edit_data[0]['iv_frame_size']) && !empty($edit_data[0]['iv_frame_size']) && $edit_data[0]['iv_frame_size'] == 'MN' ? $edit_data[0]['iv_frame_size_mn'] : $edit_data[0]['iv_frame_size'];?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>iV Rotation</td>
                                                                <td><?php echo isset($edit_data[0]['iv_rotation']) && !empty($edit_data[0]['iv_rotation']) ? $edit_data[0]['iv_rotation'] : '';?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Remark</td>
                                                                <td><?php echo isset($edit_data[0]['iv_remarks']) && !empty($edit_data[0]['iv_remarks']) ? $edit_data[0]['iv_remarks'] : '';?></td>
                                                            </tr>

                                                            <tr>
                                                                <td>IV Size</td>
                                                                <td><?php echo isset($edit_data[0]['iv_size']) && !empty($edit_data[0]['iv_size']) ? $edit_data[0]['iv_size'] : '';?></td>
                                                            </tr>

                                                            <tr>
                                                                <td>IV Resolution</td>
                                                                <td><?php echo isset($edit_data[0]['iv_resolution']) && !empty($edit_data[0]['iv_resolution']) ? $edit_data[0]['iv_resolution'] : '';?></td>
                                                            </tr>

                                                            <tr>
                                                                <td>IV text logo</td>
                                                                <td><?php echo isset($edit_data[0]['iv_text_logo']) && !empty($edit_data[0]['iv_text_logo']) ? $edit_data[0]['iv_text_logo'] : '';?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                            <?php
                                                }
                                                }
                                            ?>
                                            
                                        </div>

                                        
                                    </div>
                                </div>

                   	</div> 
                </div> 
           	</div><!-- end col -->
        </div>
               
                <!-- end row -->

    </div> <!-- container -->

    <!-- </div>  -->
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

    <!-- </div> -->

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
                                '</button>Copied Successfully!'+                                        
                                    '</div>');

      setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 4000); // <-- time in milliseconds
    }
</script>

<?php $this->load->view('common/change_password');?>
</body>
</html>