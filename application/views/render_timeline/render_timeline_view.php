<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>Timeline</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">

    <!-- Plugins css -->
    <link href="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="<?php echo base_url();?>assets/css/bootstrap-material.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?php echo base_url();?>assets/css/app-material.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="<?php echo base_url();?>assets/css/bootstrap-material-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="<?php echo base_url();?>assets/css/app-material-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="<?php echo base_url();?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Production Orders</a></li>
                                            
                                            <li class="breadcrumb-item active">Timeline</li>
                                        </ol>
                                    </div> -->
                                    <h4 class="page-title">Timeline</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 


                        <div class="row">
                            <div class="col-12">
                                <div id="flash_msg">
                                   
                                    
                                    
                                </div>
                            </div>

                            <div class="col-5">
                            	<div class="card-box">
                                    <h4 class="header-title mb-3">Order Details</h4>
                                    <?php
                                            $order_details = $this->db->query('SELECT * FROM render_production_order WHERE id = '.$order_id);
                                            if($order_details->num_rows() > 0)
                                            {
                                                $order_details = $order_details->result_array();
                                            }
                                    ?>
                                    <div class="text-center" dir="ltr">
                                        
                                        <div class="table-responsive">
                                        <table class="table mb-0">
                                            
                                            <tbody>
                                            <tr>
                                                <td>Order No</td>
                                                <td><?php echo isset($order_details[0]['order_number']) ? $order_details[0]['order_number'] : '';?></td>
                                            </tr>
                                            <tr>
                                                <td>Start Date</td>
                                                <?php
                                                    $start_date_query = $this->db->query('SELECT * FROM `start_stop_time` WHERE `job_id` = '.$order_details[0]['id'].' AND type = "Start" ORDER BY id ASC LIMIT 1');
                                                    if($start_date_query->num_rows() > 0)
                                                    {
                                                        $start_date = $start_date_query->result_array()[0]['created_date'];
                                                    }
                                                    else{
                                                        $start_date = '';
                                                    }
                                                ?>
                                                <td><?php echo isset($start_date) && $start_date != '' ? date('d F Y', strtotime($start_date)) : '';?></td>
                                            </tr>
                                            <tr>
                                                <td>Est. End Date</td>
                                                
                                                
                                                <td><?php echo isset($order_details[0]['deadline']) && !empty($order_details[0]['deadline']) ? date('d F Y', strtotime($order_details[0]['deadline'])) : '';?></td>
                                            </tr>
                                            <tr>
                                                <td>Completed On</td>
                                                <?php
                                                    $complete_date_query = $this->db->query('SELECT * FROM `render_order_log` WHERE `job_id` = '.$order_details[0]['id'].' AND status = (SELECT id FROM ms_render_status WHERE label = "Completed" AND department_id = '.$order_details[0]['department_id'].')');
                                                    if($complete_date_query->num_rows() > 0)
                                                    {
                                                        $complete_date = $complete_date_query->result_array()[0]['created_date'];
                                                    }
                                                    else{
                                                        $complete_date = '';
                                                    }
                                                ?>
                                                <td><?php echo isset($complete_date) && $complete_date != '' ? date('d F Y', strtotime($complete_date)) : '';?></td>
                                            </tr>
                                            <tr>
                                                <td>Current Status</td>
                                                <?php
                                                    $status_data = $this->db->query('SELECT label,color FROM ms_render_status WHERE id = (SELECT status FROM render_order_log WHERE job_id = '.$order_id.' ORDER BY id DESC LIMIT 1)')->result_array();
                                                    $name = $status_data[0]['label'];
                                                    $color = $status_data[0]['color'];
                                                ?>
                                                <td><?php echo '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$color.';border:1px solid '.$color.';">'.$name.'</span>';?></td>
                                            </tr>
                                            <tr>
                                                <td>File Path</td>
                                                
                                                <td><span id="file_path"><?php echo $order_details[0]['file_path'];?></span> 

                                                    <button type="button" onclick="copyToClipboard('#file_path')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">Copy <span class="mdi mdi-content-copy"></span></button></td>
                                            </tr>
                                            <?php
                                                if(isset($order_details[0]['complet_file_path']) && $order_details[0]['complet_file_path'] != '')
                                                {
                                            ?>
                                                <tr>
                                                    <td>Complet File Path</td>
                                                    
                                                    <td><span id="complet_file_path"><?php echo $order_details[0]['complet_file_path'];?></span> 

                                                    <button type="button" onclick="copyToClipboard('#complet_file_path')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">Copy <span class="mdi mdi-content-copy"></span></button></td>
                                                </tr>
                                            <?php
                                                }

                                                if(isset($order_details[0]['video_file_path']) && $order_details[0]['video_file_path'] != '')
                                                {
                                            ?>
                                                <tr>
                                                    <td>Video File Path</td>
                                                    
                                                    <td><span id="video_file_path"><?php echo $order_details[0]['video_file_path'];?></span> 

                                                    <button type="button" onclick="copyToClipboard('#video_file_path')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">Copy <span class="mdi mdi-content-copy"></span></button></td>
                                                </tr>
                                            <?php
                                                }   
                                            
                                                $role_name = $this->db->query('SELECT role_name FROM role WHERE id = (SELECT user_role FROM users WHERE id = '.$this->session->userdata('user_id').')')->result_array()[0]['role_name']; 

                                                if($role_name != 'Render Designer' && isset($order_details[0]['password']) && $order_details[0]['password'] != 0)
                                                {
                                            ?>
                                                <tr>
                                                    <td>Password</td>
                                                    
                                                    <td><?php echo $order_details[0]['password'];?></td>
                                                </tr>
                                            <?php
                                                }   
                                            ?>


                                            <?php
                                                    $render_start_stop_time = $this->db->query('SELECT * FROM `render_start_stop_time` WHERE job_id = '.$order_details[0]['id'].' ORDER BY id DESC LIMIT 1');
                                                    if($render_start_stop_time->num_rows() > 0)
                                                    {
                                                        $render_start_stop_time = $render_start_stop_time->result_array();
                                                        // pre($render_start_stop_time);
                                                        $type = $render_start_stop_time[0]['type'];
                                                        if($type == 'Start')
                                                        {
                                                            $created_date = $render_start_stop_time[0]['created_date'];
                                                            $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($created_date);
                                                        }
                                                        else
                                                        {
                                                            $diff = 0;
                                                        }
                                                        // pre($diff);

                                                        $render_start_stop_action = $this->db->query('SELECT * FROM `render_start_stop_action` WHERE job_id = '.$order_details[0]['id'].' ORDER BY id DESC LIMIT 1');
                                                        if($render_start_stop_action->num_rows() > 0)
                                                        {
                                                            $actual_time = $diff + $render_start_stop_action->result_array()[0]['actual_time'];
                                                            // pre($actual_time);
                                                            // $actual_time = date('H:i:s', $actual_time); 
                                                            
                                                        }
                                                        else
                                                        {
                                                            $actual_time = $diff;
                                                            // $actual_time = date('H:i:s', $diff); 
                                                            
                                                        }

                                                        $hours = floor($actual_time / 3600);
                                                        $min = floor(($actual_time - ($hours * 3600))/60);
                                                        $sec = $actual_time - (($hours*3600)+($min * 60));
                                                        $hms = $hours.":".$min.":".$sec;
                                                        $finalhms = date('H:i:s', strtotime($hms)); 
                                                    }
                                                    else
                                                    {
                                                        $actual_time = '';
                                                        $finalhms = '';
                                                    }


                                                    
                                                ?>
                                                
                                                <tr><td>Total Time</td>
                                                    <td><?php echo $finalhms;?></td>
                                                </tr>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>

                                </div>
                            </div> <!-- end col -->
                            <div class="col-7">
                            	<div class="card">
	 								<div class="card-body">
		                                <div class="col">
		                                                        <h5 class="mb-2 font-size-16">Detail</h5>
                                                                <?php
                                                                    $detail = $this->db->query('SELECT * FROM render_order_log WHERE job_id = '.$order_id);
                                                                    if($detail->num_rows() > 0)
                                                                    {
                                                                        $detail = $detail->result_array();
                                                                        foreach($detail as $d)
                                                                        {
                                                                            $name = $this->master_model->get_one_record('ms_render_status', 'label', $d['status']);
                                                                            ?>
                                                                                <div class="media mt-3 p-1">
                                                                                    <div class="media-body">
                                                                                        <h5 class="mt-0 mb-0 font-size-14">
                                                                                            <span class="float-right text-muted font-12"><?php echo date('d M Y', strtotime($d['created_date']));?> <?php echo date('h:i A', strtotime($d['created_date']));?></span>
                                                                                            <?php echo $this->master_model->get_one_record('users', 'full_name', $d['created_by']);?>
                                                                                        </h5>
                                                                                        <h5 class="mt-1 mb-0 text-muted">
                                                                                            
                                                                                            <?php echo $this->master_model->get_one_record('department', 'dept_name', $d['department_id']);?>
                                                                                        </h5>
                                                                                        <p class="mt-1 mb-0 text-muted">
                                                                                            <?php
                                                                                                if($name == 'Allocated')
                                                                                                {
                                                                                                    $designer = $this->master_model->get_one_record('users', 'full_name', $d['assigned_to']);
                                                                                                    $description = $d['description'].' '.$designer;
                                                                                                }
                                                                                                else if($name == 'Pause')
                                                                                                {
                                                                                                    $description = $d['description'].'<br><span style="color:red;">'.$d['reason'].'</span>';
                                                                                                }
                                                                                                else if($name == 'Pending')
                                                                                                {
                                                                                                   
                                                                                                    if(isset($d['rejected_flag']) && $d['rejected_flag'] > 0)
                                                                                                    {
                                                                                                        $description = 'Order Rejected!';
                                                                                                    }
                                                                                                    if(isset($d['prev_dept_flag']) && $d['prev_dept_flag'] > 0)
                                                                                                    {
                                                                                                        $description = 'Order Returned!';
                                                                                                    }
                                                                                                    if($d['rejected_flag'] == 0 && $d['prev_dept_flag'] == 0)
                                                                                                    {
                                                                                                       $description = $d['description']; 
                                                                                                    }
                                                                                                    
                                                                                                }
                                                                                                else{
                                                                                                    $description = $d['description'];
                                                                                                }
                                                                                                echo $description;


                                                                                                ?><br><?php 

                                                                                                $status_data = $this->db->get_where('ms_render_status', ['id' =>  $d['status']])->result_array();
                                                                                                // pre($this->db->last_query());
                                                                                                $name = $status_data[0]['label'];
                                                                                                $color = $status_data[0]['color'];


                                                                                                echo '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$color.';border:1px solid '.$color.';">'.$name.'</span>';?>

                                                                                                
                                                                                                <?php
                                                                                                    $strr = '';
                                                                                                    if($name == 'QC Reject')
                                                                                                    {
                                                                                                        $style = 'color:red;font-weight:bold;';
                                                                                                    }
                                                                                                    else if(isset($d['rejected_flag']) && $d['rejected_flag'] > 1)
                                                                                                    {
                                                                                                        $strr = '(Rejected)';
                                                                                                        $style = 'color:red;font-weight:bold;';
                                                                                                    } 
                                                                                                    else if(isset($d['prev_dept_flag']) && $d['prev_dept_flag'] > 0)
                                                                                                    {
                                                                                                        $strr = '(Returned)';
                                                                                                        $style = 'color:red;font-weight:bold;';
                                                                                                    } 
                                                                                                    else if($name == 'Canceled')
                                                                                                    {
                                                                                                        
                                                                                                        $style = 'color:red;font-weight:bold;';
                                                                                                        
                                                                                                    } 
                                                                                                    else
                                                                                                    {

                                                                                                        $style = '';
                                                                                                    }

                                                                                                    echo $d['remark'] != '' ? '<br><span style="'.$style.'">'.$d['remark'].'</span> '.$strr : '';
                                                                                                ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div> <!-- end comment -->

                                                                                <hr>
                                                                            <?php
                                                                        }
                                                                    }
                                                                ?>
		                                                          
	                                                        

		                                </div>
	                            	</div>
	                            </div>
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
                        <script>document.write(new Date().getFullYear())</script> &copy; The CAD CO.
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
<!-- END wrapper -->s

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
<script src="<?php echo base_url();?>assets/js/vendor.min.js"></script>

<!-- Plugins js-->
<script src="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.js"></script>
<!-- <script src="<?php echo base_url();?>assets/libs/apexcharts/apexcharts.min.js"></script> -->

<script src="<?php echo base_url();?>assets/libs/selectize/js/standalone/selectize.min.js"></script>

<!-- Dashboar 1 init js-->
<script src="<?php echo base_url();?>assets/js/pages/dashboard-1.init.js"></script>

<!-- App js-->
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