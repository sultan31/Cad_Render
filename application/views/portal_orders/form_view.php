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

        .gallery1 img {
          width: 200px;
        }
        .gallery img {
          width: 200px;
        }
        .pip {
            display: inline-block;
            float: left;
            position: relative;
            margin: 5px;
            height: 200px;
        }    
        .pip img {
            max-width: 200px;
            max-height: 200px;
        }
        .remove{
            position: absolute;
            top: 0px;
            right: 0px;
        }
       
        input[type="checkbox"]
        {
            display:none;
        }
        label.btn.btn-primary.active {
    background-color: #f5a831 !important;
    border-color: #e08800 !important;
}


label.btn.btn-primary {
    margin-right: 10px;
    background: transparent;
    color: #6c757d;
    border: 1px solid #ced4da;
    box-shadow : 0 0 0 0 rgb(0 0 0 / 50%);
    border-radius:3px!important;
}

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

                
                <form action="<?php echo isset($edit_data[0]['id']) ? base_url().'portal_orders/form_action/'.$edit_data[0]['id'] : base_url().'portal_orders/form_action';?>" method="post" enctype="multipart/form-data" class="parsley-examples" id="myform">

                <input type="hidden" name="portal_order_id" id="portal_order_id" value="<?php echo isset($edit_data[0]['id']) ? $edit_data[0]['id'] : '0';?>">
                <div class="row">
                    <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-sm-12 text-right">
                                                <?php 
                                                    if(isset($edit_data[0]['id']) && $edit_data[0]['id'] != 0)
                                                        {
                                                ?>
                                                            <a href="<?php echo base_url().'portal_orders/upload_media/'.$edit_data[0]['id'];?>" class="btn btn-danger mb-2">Upload Media Bulk</a>
                                                            <a href="<?php echo base_url().'portal_orders/media_uploded/'.$edit_data[0]['id'];?>" class="btn btn-danger mb-2"><i class="fe-eye vertical-middle mr-2"></i> View Media</a>
                                                            <a href="<?php echo base_url().'portal_orders/view_log/'.$edit_data[0]['id'];?>" class="btn btn-success mb-2"><i class="fe-eye vertical-middle mr-2"></i> View Log</a>
                                                <?php
                                                        }
                                                ?>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                          <div class="form-group mb-3 col-lg-12">
                                              <div class="col-lg-6" style="float:left;">
                                                <label for="client_design_no">Client Design No <span style="color:red;">*</span></label>
                                                <input type="text" id="client_design_no" name="client_design_no" class="form-control" placeholder="Client Design No" value="<?php echo isset($edit_data[0]['client_design_no']) ? $edit_data[0]['client_design_no'] : '';?>" required>
                                              </div>
                                              <div class="col-lg-6" style="float:left;">
                                                  <label for="tcc_style_no">TCC Style No <span style="color:red;">*</span></label>
                                                  <input type="text" id="tcc_style_no" name="tcc_style_no" placeholder="TCC Style No" class="form-control" value="<?php echo isset($edit_data[0]['order_number']) ? $edit_data[0]['order_number'] : '';?>" data-parsley-maxlength="22" data-parsley-trigger="focusout" required  onblur="check_duplicate(this.value);" <?php echo isset($edit_data[0]['tcc_style_no']) ? 'readonly' : '';?>>
                                                  <div class="tcc_error" style="color:red;"></div>
                                              </div>
                                              
                                          </div>
                                          <div class="form-group mb-3 col-lg-12">
                                              <div class="col-lg-6" style="float:left;">
                                                <label for="po_no">PO No</label>
                                                <input type="text" id="po_no" name="po_no" class="form-control" placeholder="PO No" value="<?php echo isset($edit_data[0]['po_no']) ? $edit_data[0]['po_no'] : '';?>">
                                              </div>
                                              <div class="col-lg-6" style="float:left;">
                                                  <label for="ref_img">Reference Image</label>
                                                  <input type="file" id="ref_img" name="ref_img[]" class="form-control-file" accept=".png, .jpg, .jpeg" multiple>
                                                  
                                              </div>
                                              <div class="col-lg-12" style="float:left;">
                                                <div class="gallery"></div>
                                              </div>
                                              
                                          </div>
                                          <div class="form-group mb-3 col-lg-12">
                                              <code id="ref_img_code" style="width: 100%;"></code>
                                          </div>
                                          <div class="form-group mb-3 col-lg-12">
                                              
                                              <div class="col-lg-6" style="float:left;">
                                                <label for="order_description">Order Desc</label>
                                                <input type="text" id="order_description" name="order_description" class="form-control" placeholder="Order Desc" value="<?php echo isset($edit_data[0]['order_description']) ? $edit_data[0]['order_description'] : '';?>">
                                              </div>
                                              <div class="col-lg-6" style="float:left;">
                                                  <label>File Type <span style="color:red;">*</span></label>
                                                  <input type="text" id="file_type" name="file_type" class="form-control" placeholder="File Type" value="<?php echo isset($edit_data[0]['file_type']) ? $edit_data[0]['file_type'] : '';?>" required>
                                                  
                                              </div>
                                          </div>

                                          <div class="form-group mb-3 col-lg-12">
                                              
                                              <div class="col-lg-6" style="float:left;">
                                                <label for="prod_type">Product Type <span style="color:red;">*</span></label>                                                
                                                <select class="form-control" name="prod_type" id="prod_type" data-toggle="select2" required>
                                                    <option value="">Select</option>                                                    
                                                    <option value="Ring" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Ring' ? 'selected' : '';?>>Ring</option>
                                                    <option value="Earring" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Earring' ? 'selected' : '';?>>Earring</option>
                                                    <option value="Pendant" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Pendant' ? 'selected' : '';?>>Pendant</option>
                                                    <option value="Necklace" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Necklace' ? 'selected' : '';?>>Necklace</option>
                                                    <option value="Bangle" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Bangle' ? 'selected' : '';?>>Bangle</option>
                                                    <option value="Bracelet" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Bracelet' ? 'selected' : '';?>>Bracelet</option>
                                                    <option value="Tiepin" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Tiepin' ? 'selected' : '';?>>Tiepin</option>
                                                    <option value="Cufflink" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Cufflink' ? 'selected' : '';?>>Cufflink</option>
                                                    <option value="Brooch" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Brooch' ? 'selected' : '';?>>Brooch</option>
                                                    <option value="Chain" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Chain' ? 'selected' : '';?>>Chain</option>  
                                                    <option value="Charm" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Charm' ? 'selected' : '';?>>Charm</option>
                                                    <option value="Nose pin" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Nose pin' ? 'selected' : '';?>>Nose pin</option>
                                                    <option value="Nose ring" <?php echo isset($edit_data[0]['category']) && $edit_data[0]['category'] == 'Nose ring' ? 'selected' : '';?>>Nose ring</option>
                                                </select>
                                                
                                              </div>
                                              <div class="col-lg-6" style="float:left;">
                                                  
                                                  <label for="findings">Findings <span style="color:red;">*</span></label>
                                                  <input type="text" id="findings" name="findings" class="form-control" placeholder="Findings" value="<?php echo isset($edit_data[0]['findings']) ? $edit_data[0]['findings'] : '';?>" required>
                                              </div>
                                          </div>

                                          <div class="form-group mb-3 col-lg-12">
                                              
                                              <div class="col-lg-6" style="float:left;">
                                                  <label>Rhodium Instructions</label>
                                                  <?php
                                                    if(!isset($edit_data[0]['rhodium_instructions']))
                                                    {
                                                        $default_rhodium_instructions = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['rhodium_instructions']))
                                                    {
                                                        if(empty($edit_data[0]['rhodium_instructions']) || $edit_data[0]['rhodium_instructions'] == 'Yes')
                                                        {
                                                            $default_rhodium_instructions = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_rhodium_instructions = '';
                                                        }
                                                    }
                                                  ?>
                                                  <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-primary active">
                                                      <input type="radio" id="rhodium_instructions1" name="rhodium_instructions" class="custom-control-input" value="Yes" <?php echo $default_rhodium_instructions;?>> Yes
                                                    </label>
                                                    <label class="btn btn-primary">
                                                      <input type="radio" id="rhodium_instructions2" name="rhodium_instructions" class="custom-control-input" value="No" <?php echo isset($edit_data[0]['rhodium_instructions']) && $edit_data[0]['rhodium_instructions'] == 'No' ? 'checked' : '';?>> No 
                                                    </label>
                                                  </div>
                                              </div>
                                              <div class="col-lg-3" style="float:left;">
                                                <label>Order Type</label>
                                                <?php
                                                    $order_type = isset($edit_data[0]['order_type']) && !empty($edit_data[0]['order_type']) ? explode(',', $edit_data[0]['order_type']) : [];
                                                ?>
                                                <div class="btn-group" data-toggle="buttons">
                                                  <label class="btn btn-primary <?php echo in_array('Image', $order_type) ? 'active' : ''; ?>">
                                                    <input type="checkbox" name="order_type[]" class="order_type" autocomplete="off" value="Image" <?php echo in_array('Image', $order_type) ? 'checked' : ''; ?>> Image
                                                  </label>
                                                  <label class="btn btn-primary <?php echo in_array('Video', $order_type) ? 'active' : ''; ?>">
                                                    <input type="checkbox" name="order_type[]" class="order_type" autocomplete="off" value="Video" <?php echo in_array('Video', $order_type) ? 'checked' : ''; ?>> Video
                                                  </label>
                                                  <label class="btn btn-primary <?php echo in_array('IV', $order_type) ? 'active' : ''; ?>">
                                                    <input type="checkbox" name="order_type[]" class="order_type" autocomplete="off" value="IV" <?php echo in_array('IV', $order_type) ? 'checked' : ''; ?>> IV
                                                  </label>
                                                </div>
                                              </div>


                                              <div class="col-lg-3" style="float:left;">
                                                <label>Is RR Order?</label>
                                                <?php
                                                    if(!isset($edit_data[0]['only_RR_order']))
                                                    {
                                                        $default_only_RR_order = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['only_RR_order']))
                                                    {
                                                        if(empty($edit_data[0]['only_RR_order']) || $edit_data[0]['only_RR_order'] == 'No')
                                                        {
                                                            $default_only_RR_order = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_only_RR_order = '';
                                                        }
                                                    }
                                                  ?>
                                                  <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-primary active">
                                                      <input type="radio" id="only_RR_order1" name="only_RR_order" class="custom-control-input" value="Yes"  <?php echo isset($edit_data[0]['only_RR_order']) && $edit_data[0]['only_RR_order'] == 'Yes' ? 'checked' : '';?>> Yes
                                                    </label>
                                                    <label class="btn btn-primary">
                                                      <input type="radio" id="only_RR_order2" name="only_RR_order" class="custom-control-input" value="No" <?php echo $default_only_RR_order;?>> No 
                                                    </label>
                                                  </div>
                                              </div>
                                          </div>


                                          <div class="form-group mb-3 col-lg-12">
                                              
                                              <div class="col-lg-6" style="float:left;">
                                                <label for="file_path">File Path <span style="color:red;">*</span></label>
                                                <input type="text" id="file_path" name="file_path" class="form-control" placeholder="File Path" value="<?php echo isset($edit_data[0]['file_path']) ? $edit_data[0]['file_path'] : '';?>" required>
                                              </div>

                                              <div class="col-lg-6" style="float:left;">
                                                <label for="remark">Remark</label>
                                                <input type="text" id="remark" name="remark" class="form-control" placeholder="Remark" value="<?php echo isset($edit_data[0]['remark']) ? $edit_data[0]['remark'] : '';?>">
                                              </div>
                                              
                                          </div>

                                          <div class="form-group mb-3 col-lg-12">
                                              
                                              
                                              <div class="col-lg-6" style="float:left;">
                                                  
                                                  <label for="center_prong_type">Center prong type <span style="color:red;">*</span></label>
                                                  <input type="text" id="center_prong_type" name="center_prong_type" class="form-control" placeholder="Center prong type" value="<?php echo isset($edit_data[0]['center_prong_type']) ? $edit_data[0]['center_prong_type'] : '';?>" required>
                                              </div>

                                              <div class="col-lg-6" style="float:left;">
                                                  
                                                  <label for="master_location">Master Location</label>
                                                  <input type="text" id="master_location" name="master_location" class="form-control" placeholder="Master Location" value="<?php echo isset($edit_data[0]['master_location']) ? $edit_data[0]['master_location'] : '';?>">
                                              </div>

                                          </div>


                                        </div>

                                        <hr style="border-top:1px solid black;<?php echo in_array('Image', $order_type) ? 'display:flex;' : 'display:none;';?>" class="img_section">
                                        <h4 class="img_section" style="<?php echo in_array('Image', $order_type) ? 'display:flex;' : 'display:none;';?>">Image</h4>

                                        <div class="row img_section" style="<?php echo in_array('Image', $order_type) ? 'display:flex;' : 'display:none;';?>">
                                                
                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                    <label>Gold Tone</label>
                                                    <?php
                                                        $i_gold_tone = isset($edit_data[0]['i_gold_tone']) && !empty($edit_data[0]['i_gold_tone']) ? explode(',', $edit_data[0]['i_gold_tone']) : [];
                                                    ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary <?php echo in_array('YG', $i_gold_tone) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_gold_tone[]" value="YG" <?php echo in_array('YG', $i_gold_tone) ? 'checked' : ''; ?>> YG
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('RG', $i_gold_tone) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_gold_tone[]" value="RG" <?php echo in_array('RG', $i_gold_tone) ? 'checked' : ''; ?>> RG
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('WG', $i_gold_tone) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_gold_tone[]" value="WG" <?php echo in_array('WG', $i_gold_tone) ? 'checked' : ''; ?>> WG
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('TT', $i_gold_tone) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_gold_tone[]" value="TT" <?php echo in_array('TT', $i_gold_tone) ? 'checked' : ''; ?>> TT
                                                      </label>
                                                      
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                    <label for="i_angles">Image Angles</label>
                                                    <?php
                                                        $i_angles = isset($edit_data[0]['i_angles']) && !empty($edit_data[0]['i_angles']) ? explode(',', $edit_data[0]['i_angles']) : [];
                                                    ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary <?php echo in_array('PV', $i_gold_tone) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_angles[]" value="PV" <?php echo in_array('PV', $i_angles) ? 'checked' : ''; ?>> PV
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('TV', $i_angles) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_angles[]" value="TV" <?php echo in_array('TV', $i_angles) ? 'checked' : ''; ?>> TV
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('RV', $i_angles) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_angles[]" value="RV" <?php echo in_array('RV', $i_angles) ? 'checked' : ''; ?>> RV
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('FV', $i_angles) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_angles[]" value="FV" <?php echo in_array('FV', $i_angles) ? 'checked' : ''; ?>> FV
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('T2V', $i_angles) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_angles[]" value="T2V" <?php echo in_array('T2V', $i_angles) ? 'checked' : ''; ?>> T2V
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('SV', $i_angles) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_angles[]" value="SV" <?php echo in_array('SV', $i_angles) ? 'checked' : ''; ?>> SV
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('MV', $i_angles) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_angles[]" value="MV" <?php echo in_array('MV', $i_angles) ? 'checked' : ''; ?>> MV
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('BV', $i_angles) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_angles[]" value="BV" <?php echo in_array('BV', $i_angles) ? 'checked' : ''; ?>> BV
                                                      </label>
                                                      <!-- <label class="btn btn-primary <?php echo in_array('MN', $i_angles) ? 'active' : ''; ?>">
                                                        <input type="checkbox" autocomplete="off" name="i_angles[]" value="MN" <?php echo in_array('MN', $i_angles) ? 'checked' : ''; ?>> MN
                                                      </label> -->
                                                      
                                                    </div>

                                                    <!-- <input type="text" class="form-control" name="i_angles_mn" id="i_angles_mn" placeholder="Image Angles" style="<?php echo isset($edit_data[0]['i_angles']) && $edit_data[0]['i_angles'] == 'MN' ? 'display:block;' : 'display:none;';?>" value="<?php echo isset($edit_data[0]['i_angles_mn']) ? $edit_data[0]['i_angles_mn'] : '';?>" <?php echo isset($edit_data[0]['i_angles']) && $edit_data[0]['i_angles'] == 'MN' ? 'required' : '';?>> -->
                                                  
                                                </div>
                                                    
                                            </div>

                                            
                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                    <label for="i_bg_color">Background</label>
                                                    <input type="text" id="i_bg_color" name="i_bg_color" class="form-control" placeholder="Background" value="<?php echo isset($edit_data[0]['i_bg_color']) ? $edit_data[0]['i_bg_color'] : '';?>">
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                    <label>Image</label>
                                                    <?php
                                                    if(!isset($edit_data[0]['i_shdaow']))
                                                    {
                                                        $default_i_shdaow = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['i_shdaow']))
                                                    {
                                                        if(empty($edit_data[0]['i_shdaow']) || $edit_data[0]['i_shdaow'] == 'Shadow')
                                                        {
                                                            $default_i_shdaow = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_i_shdaow = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="i_shdaow5" name="i_shdaow" class="custom-control-input" value="Shadow" <?php echo $default_i_shdaow;?>> Shadow
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="i_shdaow6" name="i_shdaow" class="custom-control-input" value="Reflection" <?php echo isset($edit_data[0]['i_shdaow']) && $edit_data[0]['i_shdaow'] == 'Reflection' ? 'checked' : '';?>> Reflection
                                                      </label>

                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                    <label>Logo</label>
                                                    <?php
                                                    if(!isset($edit_data[0]['i_logo']))
                                                    {
                                                        $default_i_logo = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['i_logo']))
                                                    {
                                                        if(empty($edit_data[0]['i_logo']) || $edit_data[0]['i_logo'] == 'Yes')
                                                        {
                                                            $default_i_logo = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_i_logo = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="i_logo1" name="i_logo" class="custom-control-input" value="Yes" <?php echo $default_i_logo;?>> Yes
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="i_logo2" name="i_logo" class="custom-control-input" value="No" <?php echo isset($edit_data[0]['i_logo']) && $edit_data[0]['i_logo'] == 'No' ? 'checked' : '';?>> No
                                                      </label>
                                                      
                                                    </div>
                                                </div>

                                                <div class="col-lg-6" style="float:left;">
                                                  <label for="i_ref_img">Reference Image</label>
                                                  <input type="file" id="i_ref_img" name="i_ref_img[]" class="form-control-file" accept=".png, .jpg, .jpeg" multiple>
                                                  <code id="i_ref_img_code">JPG, PNG</code>

                                                  
                                                </div>
                                                 <div class="col-lg-12" style="float:left;">
                                                    <div class="gallery1"></div>
                                                  </div>


                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                    <label for="i_logo_location">Logo Location</label>
                                                    <input type="text" id="i_logo_location" name="i_logo_location" class="form-control" placeholder="Logo Location" value="<?php echo isset($edit_data[0]['i_logo_location']) ? $edit_data[0]['i_logo_location'] : '';?>">
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                    <label for="i_frame_logo">Frame Logo</label>
                                                    <input type="text" id="i_frame_logo" name="i_frame_logo" class="form-control" placeholder="Frame Logo" value="<?php echo isset($edit_data[0]['i_frame_logo']) ? $edit_data[0]['i_frame_logo'] : '';?>">
                                                </div>
                                            </div>

                                            
                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                    <label for="i_gemstone_details">Gemstone Details</label>
                                                    <input type="text" id="i_gemstone_details" name="i_gemstone_details" class="form-control" placeholder="Gemstone Details" value="<?php echo isset($edit_data[0]['i_gemstone_details']) ? $edit_data[0]['i_gemstone_details'] : '';?>">
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                    <label>Image Output</label>
                                                    <?php
                                                    if(!isset($edit_data[0]['i_output']))
                                                    {
                                                        $default_i_output = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['i_output']))
                                                    {
                                                        if(empty($edit_data[0]['i_output']) || $edit_data[0]['i_output'] == 'PNG')
                                                        {

                                                            $default_i_output = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_i_output = '';
                                                        }
                                                    }


                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="i_output2" name="i_output" class="custom-control-input" value="PNG" <?php echo $default_i_output;?>> PNG
                                                      </label>
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="i_output1" name="i_output" class="custom-control-input" value="JPG" <?php echo isset($edit_data[0]['i_output']) && $edit_data[0]['i_output'] == 'JPG' ? 'checked' : '';?>> JPG
                                                      </label>
                                                      
                                                      
                                                      
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                    <label for="i_resolution">Image Resolution <span style="color:red;">*</span></label>
                                                    <input type="text" id="i_resolution" name="i_resolution" class="form-control" placeholder="Image Resolution" value="<?php echo isset($edit_data[0]['i_resolution']) ? $edit_data[0]['i_resolution'] : '';?>">
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                    <label for="i_size">Image Size <span style="color:red;">*</span></label>
                                                    <input type="text" id="i_size" name="i_size" class="form-control" placeholder="Image Size" value="<?php echo isset($edit_data[0]['i_size']) ? $edit_data[0]['i_size'] : '';?>">
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                    <label for="i_remarks">Remark</label>
                                                    <input type="text" id="i_remarks" name="i_remarks" class="form-control" placeholder="Remark" value="<?php echo isset($edit_data[0]['i_remarks']) ? $edit_data[0]['i_remarks'] : '';?>">
                                                </div>
                                                
                                                <div class="col-lg-6" style="float:left;">
                                                    <label for="image_text_logo">Image text logo</label>
                                                    <input type="text" id="image_text_logo" name="image_text_logo" class="form-control" placeholder="Image text logo" value="<?php echo isset($edit_data[0]['image_text_logo']) ? $edit_data[0]['image_text_logo'] : '';?>">
                                                </div>
                                            </div>
                                          
                                            
                                        </div>

                                        <hr style="border-top:1px solid black;<?php echo in_array('Video', $order_type) ? 'display:flex;' : 'display:none;';?>" class="video_section">
                                        <h4 class="video_section" style="<?php echo in_array('Video', $order_type) ? 'display:flex;' : 'display:none;';?>">Video</h4>

                                        <div class="row video_section" style="<?php echo in_array('Video', $order_type) ? 'display:flex;' : 'display:none;';?>">
                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                    <label>Gold Tone</label>
                                                    <?php
                                                        $v_gold_tone = isset($edit_data[0]['v_gold_tone']) && !empty($edit_data[0]['v_gold_tone']) ? explode(',', $edit_data[0]['v_gold_tone']) : [];
                                                    ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary <?php echo in_array('YG', $v_gold_tone) ? 'active' : ''; ?>">

                                                        <input type="checkbox" name="v_gold_tone[]" autocomplete="off" value="YG" <?php echo in_array('YG', $v_gold_tone) ? 'checked' : ''; ?>> YG
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('WG', $v_gold_tone) ? 'active' : ''; ?>">
                                                        <input type="checkbox" name="v_gold_tone[]" autocomplete="off" value="WG" <?php echo in_array('WG', $v_gold_tone) ? 'checked' : ''; ?>> WG
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('RG', $v_gold_tone) ? 'active' : ''; ?>">
                                                        <input type="checkbox" name="v_gold_tone[]" autocomplete="off" value="RG" <?php echo in_array('RG', $v_gold_tone) ? 'checked' : ''; ?>> RG
                                                      </label>
                                                      <label class="btn btn-primary <?php echo in_array('TT', $v_gold_tone) ? 'active' : ''; ?>">
                                                        <input type="checkbox" name="v_gold_tone[]" autocomplete="off" value="TT" <?php echo in_array('TT', $v_gold_tone) ? 'checked' : ''; ?>> TT
                                                      </label>
                                                      
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                    <label>Video Type</label>
                                                    <?php
                                                    if(!isset($edit_data[0]['video_type']))
                                                    {
                                                        $default_video_type = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['video_type']))
                                                    {
                                                        if(empty($edit_data[0]['video_type']) || $edit_data[0]['video_type'] == 'TP1')
                                                        {
                                                            $default_video_type = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_video_type = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="video_type1" name="video_type" class="custom-control-input" value="TP1" <?php echo $default_video_type;?>> TP1
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="video_type2" name="video_type" class="custom-control-input" value="TP2" <?php echo isset($edit_data[0]['video_type']) && $edit_data[0]['video_type'] == 'TP2' ? 'checked' : '';?>> TP2
                                                      </label>

                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="video_type3" name="video_type" class="custom-control-input" value="TP3" <?php echo isset($edit_data[0]['video_type']) && $edit_data[0]['video_type'] == 'TP3' ? 'checked' : '';?>> TP3
                                                      </label>

                                                       <label class="btn btn-primary">
                                                        <input type="radio" id="video_type4" name="video_type" class="custom-control-input" value="TP4" <?php echo isset($edit_data[0]['video_type']) && $edit_data[0]['video_type'] == 'TP4' ? 'checked' : '';?>> TP4
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="video_type4" name="video_type" class="custom-control-input" value="TP5" <?php echo isset($edit_data[0]['video_type']) && $edit_data[0]['video_type'] == 'TP5' ? 'checked' : '';?>> TP5
                                                      </label>

                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="video_type4" name="video_type" class="custom-control-input" value="TP6" <?php echo isset($edit_data[0]['video_type']) && $edit_data[0]['video_type'] == 'TP6' ? 'checked' : '';?>> TP6
                                                      </label>

                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="video_type4" name="video_type" class="custom-control-input" value="TP6" <?php echo isset($edit_data[0]['video_type']) && $edit_data[0]['video_type'] == 'TP7' ? 'checked' : '';?>> TP7
                                                      </label>

                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="video_type4" name="video_type" class="custom-control-input" value="TP6" <?php echo isset($edit_data[0]['video_type']) && $edit_data[0]['video_type'] == 'TP8' ? 'checked' : '';?>> TP8
                                                      </label>

                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="video_type4" name="video_type" class="custom-control-input" value="CM" <?php echo isset($edit_data[0]['video_type']) && $edit_data[0]['video_type'] == 'CM' ? 'checked' : '';?>> CM
                                                      </label>
                                                      
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                	<label>Video Rhodium Instruction</label>
                                                  <?php
                                                    if(!isset($edit_data[0]['v_rhodium_instruction']))
                                                    {
                                                        $default_v_rhodium_instruction = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['v_rhodium_instruction']))
                                                    {
                                                        if(empty($edit_data[0]['v_rhodium_instruction']) || $edit_data[0]['v_rhodium_instruction'] == 'Yes')
                                                        {
                                                            $default_v_rhodium_instruction = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_v_rhodium_instruction = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="v_rhodium_instruction1" name="v_rhodium_instruction" class="custom-control-input" value="Yes" <?php echo $default_v_rhodium_instruction;?>> Yes
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="v_rhodium_instruction2" name="v_rhodium_instruction" class="custom-control-input" value="No" <?php echo isset($edit_data[0]['v_rhodium_instruction']) && $edit_data[0]['v_rhodium_instruction'] == 'No' ? 'checked' : '';?>> No
                                                      </label>
                                                      
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="v_bg_color">Video Background</label>
                                                  <?php
                                                    if(!isset($edit_data[0]['v_bg_color']))
                                                    {
                                                        $default_v_bg_color = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['v_bg_color']))
                                                    {
                                                        if(empty($edit_data[0]['v_bg_color']) || $edit_data[0]['v_bg_color'] == 'White')
                                                        {
                                                            $default_v_bg_color = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_v_bg_color = '';
                                                        }
                                                    }
                                                  ?>
                                                  <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="v_bg_color1" name="v_bg_color" class="custom-control-input v_bg_color" value="White" <?php echo $default_v_bg_color;?>> White
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="v_bg_color2" name="v_bg_color" class="custom-control-input v_bg_color" value="Black" <?php echo isset($edit_data[0]['v_bg_color']) && $edit_data[0]['v_bg_color'] == 'Black' ? 'checked' : '';?>> Black
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="v_b_color3" name="v_bg_color" class="custom-control-input v_bg_color" value="MN" <?php echo isset($edit_data[0]['v_bg_color']) && $edit_data[0]['v_bg_color'] == 'MN' ? 'checked' : '';?>> MN
                                                      </label>                                                      
                                                    </div>

                                                    <input type="text" class="form-control" name="v_bg_color_mn" id="v_bg_color_mn" placeholder="Video Background" style="<?php echo isset($edit_data[0]['v_bg_color']) && $edit_data[0]['v_bg_color'] == 'MN' ? 'display:block;' : 'display:none;';?>" value="<?php echo isset($edit_data[0]['v_bg_color_mn']) ? $edit_data[0]['v_bg_color_mn'] : '';?>" <?php echo isset($edit_data[0]['v_bg_color']) && $edit_data[0]['v_bg_color'] == 'MN' ? 'required' : '';?>>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                	<label>Video Shadow / Reflection</label>
                                                  <?php
                                                    if(!isset($edit_data[0]['v_shadow']))
                                                    {
                                                        $default_v_shadow = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['v_shadow']))
                                                    {
                                                        if(empty($edit_data[0]['v_shadow']) || $edit_data[0]['v_shadow'] == 'Shadow')
                                                        {
                                                            $default_v_shadow = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_v_shadow = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="v_shadow1" name="v_shadow" class="custom-control-input" value="Shadow" <?php echo $default_v_shadow;?>> Shadow
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="v_shadow2" name="v_shadow" class="custom-control-input" value="Reflection" <?php echo isset($edit_data[0]['v_shadow']) && $edit_data[0]['v_shadow'] == 'Reflection' ? 'checked' : '';?>> Reflection
                                                      </label> 
                                                      
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                            		<label>Logo</label>
                                                <?php
                                                    if(!isset($edit_data[0]['v_logo']))
                                                    {
                                                        $default_v_logo = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['v_logo']))
                                                    {
                                                        if(empty($edit_data[0]['v_logo']) || $edit_data[0]['v_logo'] == 'Yes')
                                                        {
                                                            $default_v_logo = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_v_logo = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="v_logo1" name="v_logo" class="custom-control-input" value="Yes" <?php echo $default_v_logo;?>> Yes
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="v_logo2" name="v_logo" class="custom-control-input" value="No" <?php echo isset($edit_data[0]['v_logo']) && $edit_data[0]['v_logo'] == 'No' ? 'checked' : '';?>> No
                                                      </label>
                                                      
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="v_logo_location">Logo Location</label>

                                                    <input type="text" id="v_logo_location" name="v_logo_location" class="form-control" placeholder="Logo Location" value="<?php echo isset($edit_data[0]['v_logo_location']) ? $edit_data[0]['v_logo_location'] : '';?>">
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="v_frame_logo_location">Frame logo Location</label>
                                                    <input type="text" id="v_frame_logo_location " name="v_frame_logo_location" class="form-control" placeholder="Frame logo Location" value="<?php echo isset($edit_data[0]['v_frame_logo_location']) ? $edit_data[0]['v_frame_logo_location'] : '';?>">
                                                </div>
                                            </div>


                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                    <label for="ref_video">Reference Video</label>
                                                    <input type="file" id="ref_video" name="ref_video[]" class="form-control-file" accept=".mp4, .mov" multiple>
                                                    <code>MP4, MOV</code>

                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                  <label for="v_gemstone_details">Gemstone Details</label>

                                                    <input type="text" id="v_gemstone_details" name="v_gemstone_details" class="form-control" placeholder="Gemstone Details" value="<?php echo isset($edit_data[0]['v_gemstone_details']) ? $edit_data[0]['v_gemstone_details'] : '';?>">
                                                </div>
                                                
                                            </div>
                                            

                                            

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                	<label>Video Output</label>
                                                  <?php
                                                    if(!isset($edit_data[0]['v_output']))
                                                    {
                                                        $default_v_output = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['v_output']))
                                                    {
                                                        if(empty($edit_data[0]['v_output']) || $edit_data[0]['v_output'] == 'MP4')
                                                        {
                                                            $default_v_output = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_v_output = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="v_output1" name="v_output" class="custom-control-input" value="MP4" <?php echo $default_v_output;?>> MP4
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="v_output2" name="v_output" class="custom-control-input" value="MOV" <?php echo isset($edit_data[0]['v_output']) && $edit_data[0]['v_output'] == 'MOV' ? 'checked' : '';?>> MOV 
                                                      </label>
                                                      
                                                    </div>
                                                </div>

                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="v_size">Video Size <span style="color:red;">*</span></label>
                                                    <input type="text" id="v_size" name="v_size" class="form-control" placeholder="Video Size" value="<?php echo isset($edit_data[0]['v_size']) ? $edit_data[0]['v_size'] : '';?>">
                                                </div>                                                
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">                                               

                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="v_resolution">Video Resolution</label>
                                                  <input type="text" class="form-control" name="v_resolution" id="v_resolution" placeholder="Video Resolution" value="<?php echo isset($edit_data[0]['v_resolution']) ? $edit_data[0]['v_resolution'] : '';?>">

                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="v_duration">Video Duration</label>
                                                  <?php
                                                    if(!isset($edit_data[0]['v_duration']))
                                                    {
                                                        $default_v_duration = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['v_duration']))
                                                    {
                                                        if(empty($edit_data[0]['v_duration']) || $edit_data[0]['v_duration'] == '10sec')
                                                        {
                                                            $default_v_duration = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_v_duration = '';
                                                        }
                                                    }
                                                  ?>
                                                  <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="v_duration1" name="v_duration" class="custom-control-input v_duration" value="10sec" <?php echo $default_v_duration;?>> 10sec
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="v_duration2" name="v_duration" class="custom-control-input v_duration" value="15sec" <?php echo isset($edit_data[0]['v_duration']) && $edit_data[0]['v_duration'] == '15sec' ? 'checked' : '';?>> 15sec
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="v_duration3" name="v_duration" class="custom-control-input v_duration" value="MN" <?php echo isset($edit_data[0]['v_duration']) && $edit_data[0]['v_duration'] == 'MN' ? 'checked' : '';?>> MN
                                                      </label>
                                                      
                                                  </div>

                                                    <input type="text" class="form-control" name="v_duration_mn" id="v_duration_mn" placeholder="Video Duration" style="<?php echo isset($edit_data[0]['v_duration']) && $edit_data[0]['v_duration'] == 'MN' ? 'display:block;' : 'display:none;';?>" value="<?php echo isset($edit_data[0]['v_duration_mn']) ? $edit_data[0]['v_duration_mn'] : '';?>" <?php echo isset($edit_data[0]['v_duration']) && $edit_data[0]['v_duration'] == 'MN' ? 'required' : '';?>>
                                                </div>
                                                  
                                                                                              
                                            </div>

                                            <div class="form-group mb-3 col-lg-12"> 
                                             	<div class="col-lg-6" style="float:left;">
                                                	<label>Video Rotation</label>
                                                  <?php
                                                    if(!isset($edit_data[0]['v_rotation_type']))
                                                    {
                                                        $default_v_rotation_type = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['v_rotation_type']))
                                                    {
                                                        if(empty($edit_data[0]['v_rotation_type']) || $edit_data[0]['v_rotation_type'] == 'Anticlock')
                                                        {
                                                            $default_v_rotation_type = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_v_rotation_type = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="v_rotation_type1" name="v_rotation_type" class="custom-control-input" value="Anticlock" <?php echo $default_v_rotation_type;?>> Anticlock
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="v_rotation_type2" name="v_rotation_type" class="custom-control-input" value="Clockwise" <?php echo isset($edit_data[0]['v_rotation_type']) && $edit_data[0]['v_rotation_type'] == 'Clockwise' ? 'checked' : '';?>> Clockwise 
                                                      </label>
                                                      
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="v_remarks">Remark</label>
                                                    <input type="text" id="v_remarks" name="v_remarks" class="form-control" placeholder="Remark" value="<?php echo isset($edit_data[0]['v_remarks']) ? $edit_data[0]['v_remarks'] : '';?>">
                                                </div>


                                                                                                
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                              <div class="col-lg-6" style="float:left;">
                                                    <label for="video_text_logo">Video text logo</label>
                                                    <input type="text" id="video_text_logo" name="video_text_logo" class="form-control" placeholder="Video text logo" value="<?php echo isset($edit_data[0]['video_text_logo']) ? $edit_data[0]['video_text_logo'] : '';?>">
                                                </div>
                                            </div>

                                        </div>

                                        <hr style="border-top:1px solid black;<?php echo in_array('IV', $order_type) ? 'display:flex;' : 'display:none;';?>" class="iv_section">
                                        <h4 class="iv_section" style="<?php echo in_array('IV', $order_type) ? 'display:flex;' : 'display:none;';?>">Interactive Video</h4>

                                        <div class="row iv_section" style="<?php echo in_array('IV', $order_type) ? 'display:flex;' : 'display:none;';?>">

                                        	<div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                	<label>Gold Tone</label>
                                                  <?php 
                                                      $iv_gold_tone = isset($edit_data[0]['iv_gold_tone']) && !empty($edit_data[0]['iv_gold_tone']) ? explode(',', $edit_data[0]['iv_gold_tone']) : [];
                                                      
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      
                          													  <label class="btn btn-primary <?php echo (in_array('YG', $iv_gold_tone)) ? "active" : ""; ?>">
                          													    <input type="checkbox" autocomplete="off" name="iv_gold_tone[]" value="YG" <?php echo (in_array('YG', $iv_gold_tone)) ? "checked" : "";  ?>> YG
                          													  </label>
                                                      
                          													  <label class="btn btn-primary <?php echo (in_array('WG', $iv_gold_tone)) ? "active" : ""; ?>">
                          													    <input type="checkbox" autocomplete="off" name="iv_gold_tone[]" value="WG" <?php echo (in_array('WG', $iv_gold_tone)) ? "checked" : "";  ?>> WG
                          													  </label>
                                                      <?php
                                                        
                                                      ?>
                          													  <label class="btn btn-primary <?php echo (in_array('RG', $iv_gold_tone)) ? "active" : ""; ?> ">
                          													    <input type="checkbox" autocomplete="off" name="iv_gold_tone[]" value="RG" <?php echo (in_array('RG', $iv_gold_tone)) ? "checked" : "";  ?>> RG
                          													  </label>
                                                      
                          													  <label class="btn btn-primary <?php echo (in_array('TT', $iv_gold_tone)) ? "active" : ""; ?>">
                          													    <input type="checkbox" autocomplete="off" name="iv_gold_tone[]" value="TT" <?php echo (in_array('TT', $iv_gold_tone)) ? "checked" : "";  ?>> TT
                          													  </label>
                          													  
                          													</div>
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="customRadio1">IV Type</label>
                                                  <?php
                                                    if(!isset($edit_data[0]['iv_type']))
                                                    {
                                                        $default_iv_type = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['iv_type']))
                                                    {
                                                        if(empty($edit_data[0]['iv_type']) || $edit_data[0]['iv_type'] == 'Turntable')
                                                        {
                                                            $default_iv_type = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_iv_type = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="iv_type1" name="iv_type" class="custom-control-input" value="Turntable" <?php echo $default_iv_type;?>> Turntable
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="iv_type2" name="iv_type" class="custom-control-input" value="Tumble" <?php echo isset($edit_data[0]['iv_type']) && $edit_data[0]['iv_type'] == 'Tumble' ? 'checked' : '';?>> Tumble
                                                      </label>
                                                      
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                	<label>iV Rhodium Instruction</label>
                                                  <?php
                                                    if(!isset($edit_data[0]['iv_rhodium_instruction']))
                                                    {
                                                        $default_iv_rhodium_instruction = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['iv_rhodium_instruction']))
                                                    {
                                                        if(empty($edit_data[0]['iv_rhodium_instruction']) || $edit_data[0]['iv_rhodium_instruction'] == 'Yes')
                                                        {
                                                            $default_iv_rhodium_instruction = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_iv_rhodium_instruction = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="iv_rhodium_instruction1" name="iv_rhodium_instruction" class="custom-control-input" value="Yes" <?php echo $default_iv_rhodium_instruction;?>> Yes
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="iv_rhodium_instruction2" name="iv_rhodium_instruction" class="custom-control-input" value="No" <?php echo isset($edit_data[0]['iv_rhodium_instruction']) && $edit_data[0]['iv_rhodium_instruction'] == 'No' ? 'checked' : '';?>> No
                                                      </label>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                	<label>iV Background</label>
                                                  <?php
                                                    if(!isset($edit_data[0]['iv_bg_color']))
                                                    {
                                                        $default_iv_bg_color = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['iv_bg_color']))
                                                    {
                                                        if(empty($edit_data[0]['iv_bg_color']) || $edit_data[0]['iv_bg_color'] == 'White')
                                                        {
                                                            $default_iv_bg_color = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_iv_bg_color = '';
                                                        }
                                                    }
                                                  ?>
                                                  <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="iv_bg_color1" name="iv_bg_color" class="custom-control-input iv_bg_color" value="White" <?php echo $default_iv_bg_color;?>> White
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="iv_bg_color2" name="iv_bg_color" class="custom-control-input iv_bg_color" value="Black" <?php echo isset($edit_data[0]['iv_bg_color']) && $edit_data[0]['iv_bg_color'] == 'Black' ? 'checked' : '';?>> Black
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="iv_bg_color3" name="iv_bg_color" class="custom-control-input iv_bg_color" value="MN" <?php echo isset($edit_data[0]['iv_bg_color']) && $edit_data[0]['iv_bg_color'] == 'MN' ? 'checked' : '';?>> MN
                                                      </label>
                                                      
                                                    </div>

                                                    <input type="text" class="form-control" name="iv_bg_color_mn" id="iv_bg_color_mn" placeholder="iV Background" style="<?php echo isset($edit_data[0]['iv_bg_color']) && $edit_data[0]['iv_bg_color'] == 'MN' ? 'display:block;' : 'display:none;';?>" value="<?php echo isset($edit_data[0]['iv_bg_color_mn']) ? $edit_data[0]['iv_bg_color_mn'] : '';?>" <?php echo isset($edit_data[0]['iv_bg_color']) && $edit_data[0]['iv_bg_color'] == 'MN' ? 'required' : '';?>>
                                                  
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                	<label>IV Shadow / Reflection</label>
                                                        <?php
                                                            if(!isset($edit_data[0]['iv_shadow']))
                                                            {
                                                                $default_iv_shadow = 'checked';
                                                            }
                                                            elseif(isset($edit_data[0]['iv_shadow']))
                                                            {
                                                                if(empty($edit_data[0]['iv_shadow']) || $edit_data[0]['iv_shadow'] == 'Shadow')
                                                                {
                                                                    $default_iv_shadow = 'checked';
                                                                }
                                                                else
                                                                {
                                                                    $default_iv_shadow = '';
                                                                }
                                                            }
                                                        ?>
                                                        <div class="btn-group" data-toggle="buttons">
                                                          <label class="btn btn-primary active">
                                                            <input type="radio" id="iv_shadow1" name="iv_shadow" class="custom-control-input" value="Shadow" <?php echo $default_iv_shadow;?>> Shadow
                                                          </label>
                                                          <label class="btn btn-primary">
                                                            <input type="radio" id="iv_shadow2" name="iv_shadow" class="custom-control-input" value="Reflection" <?php echo isset($edit_data[0]['iv_shadow']) && $edit_data[0]['iv_shadow'] == 'Reflection' ? 'checked' : '';?>> Reflection
                                                          </label>

                                                        </div>
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                	<label>Logo</label>
                                                  <?php
                                                    if(!isset($edit_data[0]['iv_logo']))
                                                    {
                                                        $default_iv_logo = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['iv_logo']))
                                                    {
                                                        if(empty($edit_data[0]['iv_logo']) || $edit_data[0]['iv_logo'] == 'Yes')
                                                        {
                                                            $default_iv_logo = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_iv_logo = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="iv_logo1" name="iv_logo" class="custom-control-input" value="Yes" <?php echo $default_iv_logo;?>> Yes
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="iv_logo2" name="iv_logo" class="custom-control-input" value="No" <?php echo isset($edit_data[0]['iv_logo']) && $edit_data[0]['iv_logo'] == 'No' ? 'checked' : '';?>> No
                                                      </label>
                                                      
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="iv_logo_location">Logo Location</label>
                                                    <input type="text" id="iv_logo_location" name="iv_logo_location" class="form-control" placeholder="Logo Location" value="<?php echo isset($edit_data[0]['iv_logo_location']) ? $edit_data[0]['iv_logo_location'] : '';?>">
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="iv_frame_logo">Frame logo</label>
                                                    <input type="text" id="iv_frame_logo " name="iv_frame_logo" class="form-control" placeholder="Frame logo Location" value="<?php echo isset($edit_data[0]['iv_frame_logo']) ? $edit_data[0]['iv_frame_logo'] : '';?>">
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="iv_gemstone_details">Gemstone Details</label>
                                                    <input type="text" id="iv_gemstone_details" name="iv_gemstone_details" class="form-control" placeholder="Gemstone Details" value="<?php echo isset($edit_data[0]['iv_gemstone_details']) ? $edit_data[0]['iv_gemstone_details'] : '';?>">
                                                </div>
                                                <div class="col-lg-6" style="float:left;">
                                                	<label>iV Output</label>
                                                  <?php
                                                    if(!isset($edit_data[0]['iv_output']))
                                                    {
                                                        $default_iv_output = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['iv_output']))
                                                    {
                                                        if(empty($edit_data[0]['iv_output']) || $edit_data[0]['iv_output'] == 'PNG')
                                                        {
                                                            $default_iv_output = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_iv_output = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="iv_output1" name="iv_output" class="custom-control-input" value="PNG" <?php echo $default_iv_output;?>> PNG
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="iv_output2" name="iv_output" class="custom-control-input" value="JPG" <?php echo isset($edit_data[0]['iv_output']) && $edit_data[0]['iv_output'] == 'JPG' ? 'checked' : '';?>> JPG
                                                      </label>
                                                      
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">                                                
                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="iv_frame_size">iV Frame</label>

                                                  <?php
                                                    if(!isset($edit_data[0]['iv_frame_size']))
                                                    {
                                                        $default_iv_frame_size = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['iv_frame_size']))
                                                    {
                                                        if(empty($edit_data[0]['iv_frame_size']) || $edit_data[0]['iv_frame_size'] == '30')
                                                        {
                                                            $default_iv_frame_size = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_iv_frame_size = '';
                                                        }
                                                    }
                                                  ?>
                                                  <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="iv_frame_size1" name="iv_frame_size" class="custom-control-input iv_frame_size" value="30" <?php echo $default_iv_frame_size;?>> 30
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="iv_frame_size2" name="iv_frame_size" class="custom-control-input iv_frame_size" value="Black" <?php echo isset($edit_data[0]['iv_frame_size']) && $edit_data[0]['iv_frame_size'] == '36' ? 'checked' : '';?>> 36
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="iv_frame_size3" name="iv_frame_size" class="custom-control-input iv_frame_size" value="54" <?php echo isset($edit_data[0]['iv_frame_size']) && $edit_data[0]['iv_frame_size'] == '54' ? 'checked' : '';?>> 54
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="iv_frame_size3" name="iv_frame_size" class="custom-control-input iv_frame_size" value="60" <?php echo isset($edit_data[0]['iv_frame_size']) && $edit_data[0]['iv_frame_size'] == '60' ? 'checked' : '';?>> 60
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="iv_frame_size3" name="iv_frame_size" class="custom-control-input iv_frame_size" value="OTHR" <?php echo isset($edit_data[0]['iv_frame_size']) && $edit_data[0]['iv_frame_size'] == 'OTHR' ? 'checked' : '';?>> OTHR
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="iv_frame_size3" name="iv_frame_size" class="custom-control-input iv_frame_size" value="MN" <?php echo isset($edit_data[0]['iv_frame_size']) && $edit_data[0]['iv_frame_size'] == 'MN' ? 'checked' : '';?>> MN
                                                      </label>
                                                      
                                                  </div>

                                                  <input type="text" class="form-control" name="iv_frame_size_mn" id="iv_frame_size_mn" placeholder="iV Frame" style="<?php echo isset($edit_data[0]['iv_frame_size']) && $edit_data[0]['iv_frame_size'] == 'MN' ? 'display:block;' : 'display:none;';?>" value="<?php echo isset($edit_data[0]['iv_frame_size_mn']) ? $edit_data[0]['iv_frame_size_mn'] : '';?>" <?php echo isset($edit_data[0]['iv_frame_size']) && $edit_data[0]['iv_frame_size'] == 'MN' ? 'required' : '';?>>
                                                  
                                                </div>

                                                <div class="col-lg-6" style="float:left;">
                                                	

                                                    <label for="iv_rotation">iV Rotation</label>
                                                    <?php
                                                    if(!isset($edit_data[0]['iv_rotation']))
                                                    {
                                                        $default_iv_rotation = 'checked';
                                                    }
                                                    elseif(isset($edit_data[0]['iv_rotation']))
                                                    {
                                                        if(empty($edit_data[0]['iv_rotation']) || $edit_data[0]['iv_rotation'] == 'Anticlock')
                                                        {
                                                            $default_iv_rotation = 'checked';
                                                        }
                                                        else
                                                        {
                                                            $default_iv_rotation = '';
                                                        }
                                                    }
                                                  ?>
                                                    <div class="btn-group" data-toggle="buttons">
                                                      <label class="btn btn-primary active">
                                                        <input type="radio" id="iv_rotation1" name="iv_rotation" class="custom-control-input" value="Anticlock" <?php echo $default_iv_rotation;?>> Anticlock
                                                      </label>
                                                      <label class="btn btn-primary">
                                                        <input type="radio" id="iv_rotation2" name="iv_rotation" class="custom-control-input" value="Clockwise" <?php echo isset($edit_data[0]['iv_rotation']) && $edit_data[0]['iv_rotation'] == 'Clockwise' ? 'checked' : '';?>> Clockwise 
                                                      </label>
                                                      
                                                    </div>
                                                    
                                                </div>
                                            </div>


                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                    <label for="iv_size">IV Size</label>
                                                    <input type="text" id="iv_size" name="iv_size" class="form-control" placeholder="IV Size" value="<?php echo isset($edit_data[0]['iv_size']) ? $edit_data[0]['iv_size'] : '';?>">
                                                </div>

                                                <div class="col-lg-6" style="float:left;">
                                                  <label for="iv_resolution">IV Resolution</label>
                                                  <input type="text" id="iv_resolution" name="iv_resolution" class="form-control" placeholder="IV Resolution" value="<?php echo isset($edit_data[0]['iv_resolution']) ? $edit_data[0]['iv_resolution'] : '';?>">
                                                </div>

                                                
                                            </div>

                                            <div class="form-group mb-3 col-lg-12">
                                                <div class="col-lg-6" style="float:left;">
                                                	<label for="iv_remarks">Remark</label>
	                                                <input type="text" id="iv_remarks" name="iv_remarks" class="form-control" placeholder="Remark" value="<?php echo isset($edit_data[0]['iv_remarks']) ? $edit_data[0]['iv_remarks'] : '';?>">
                                                </div>

                                                <div class="col-lg-6" style="float:left;">
                                                    <label for="iv_text_logo">IV text logo</label>
                                                    <input type="text" id="iv_text_logo" name="iv_text_logo" class="form-control" placeholder="IV text logo" value="<?php echo isset($edit_data[0]['iv_text_logo']) ? $edit_data[0]['iv_text_logo'] : '';?>">
                                                </div>
                                            </div>

                                            
                                        </div>

                                        <div class="row" style="width:100%;padding-top:20px;">
                                          <div class="form-group mb-3 col-lg-12">
                                              <div class="col-lg-6" style="float:left;">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="submit_btn">Submit</button>
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

<script type="text/javascript">
    $('.i_angles').change(function(){
        if($(this).val() == 'MN')
        {
            $('#i_angles_mn').show();
            $('#i_angles_mn').prop('required', true);
        }
        else
        {
            $('#i_angles_mn').hide();
            $('#i_angles_mn').prop('required', false);
        }
    });


    $('.v_bg_color').change(function(){
        if($(this).val() == 'MN')
        {
            $('#v_bg_color_mn').show();
            $('#v_bg_color_mn').prop('required', true);
        }
        else
        {
            $('#v_bg_color_mn').hide();
            $('#v_bg_color_mn').prop('required', false);
        }
    });

    $('.v_duration').change(function(){
        if($(this).val() == 'MN')
        {
            $('#v_duration_mn').show();
            $('#v_duration_mn').prop('required', true);
        }
        else
        {
            $('#v_duration_mn').hide();
            $('#v_duration_mn').prop('required', false);
        }
    });

    $('.iv_bg_color').change(function(){
        if($(this).val() == 'MN')
        {
            $('#iv_bg_color_mn').show();
            $('#iv_bg_color_mn').prop('required', true);
        }
        else
        {
            $('#iv_bg_color_mn').hide();
            $('#iv_bg_color_mn').prop('required', false);
        }
    });

    $('.iv_frame_size').change(function(){
        if($(this).val() == 'MN')
        {
            $('#iv_frame_size_mn').show();
            $('#iv_frame_size_mn').prop('required', true);
        }
        else
        {
            $('#iv_frame_size_mn').hide();
            $('#iv_frame_size_mn').prop('required', false);
        }
    });

    
    $('.order_type').change(function(){
      var val = [];
      $('.order_type:checked').each(function(i){

        val[i] = $(this).val();
      });

      if(val.includes("Image"))
      {
          $('.img_section').show();
          $('#i_resolution').prop('required', true);
          $('#i_size').prop('required', true);
          
      }
      else
      {
          $('.img_section').hide();
          $('#i_resolution').prop('required', false);
          $('#i_size').prop('required', false);
      }


      if(val.includes("Video"))
      {
          $('.video_section').show();
          $('#v_size').prop('required', true);
      }
      else
      {
          $('.video_section').hide();
          $('#v_size').prop('required', false);
      }


      if(val.includes("IV"))
      {
          $('.iv_section').show();
      }
      else
      {
          $('.iv_section').hide();
      }

    });



    function check_duplicate(tcc_style_no)
    {
        var portal_order_id = $('#portal_order_id').val();
        $.ajax({
            url: "<?php echo base_url();?>portal_orders/check_duplicate", 
            type: "POST",             
            data: {'tcc_style_no':tcc_style_no,'portal_order_id':portal_order_id},      
            success: function(data) {
                
                var json = JSON.parse(data);
                if(json.status == 1)
                {
                    $('.tcc_error').text('Order No Already Exists.');
                    $('#submit_btn').prop('disabled', true);
                }
                else
                {
                    $('.tcc_error').text('');
                    $('#submit_btn').prop('disabled', false);
                }
            }
        });
    }

    $(function() {
    // Multiple images preview in browser
      var imagesPreview = function(input, placeToInsertImagePreview) {

          if (input.files) {
              var filesAmount = input.files.length;

              for (i = 0; i < filesAmount; i++) {
                  var reader = new FileReader();

                  reader.onload = function(event) {
                      $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                  }

                  reader.readAsDataURL(input.files[i]);
              }
          }

      };

      $('#ref_img').on('change', function() {
          imagesPreview(this, 'div.gallery');
      });

      
      $('#i_ref_img').on('change', function() {
          imagesPreview(this, 'div.gallery1');
      });
});
</script>
<?php $this->load->view('common/change_password');?>
</body>
</html>