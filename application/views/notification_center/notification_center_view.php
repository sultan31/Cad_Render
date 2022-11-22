 <!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title><?php echo ucwords($this->uri->segment(1));?></title>
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
                                            
                                            <li class="breadcrumb-item active">Notification Center</li>
                                        </ol>
                                    </div> -->
                                    <h4 class="page-title">Notification Center</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 


                        <div class="row">
                            
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                    	<?php
                                    		$role_name = $this->db->query('SELECT role_name FROM role WHERE id = '.$this->session->userdata('user_role'))->result_array()[0]['role_name'];
                                                if($role_name == 'Admin' || $role_name == 'Customer Service' || $role_name == 'Floor Manager' || $role_name == 'General Manager' || $role_name == 'Customer Service Manager')
                                                {
                                                    $detail = $this->db->query('SELECT * FROM order_log ORDER BY id DESC');
                                                    $detail2 = $this->db->query('SELECT * FROM render_order_log ORDER BY id DESC');
                                                }
                                                else if($role_name == 'Cad Designer' || $role_name == 'CAD Manager')
                                                {
                                                    $detail = $this->db->query('SELECT * FROM order_log  WHERE assigned_to = '.$this->session->userdata('user_id').' ORDER BY id DESC');
                                                }
                                                else if($role_name == 'Render Designer' || $role_name == 'Dept Manager')
                                                {
                                                    $detail = $this->db->query('SELECT * FROM render_order_log  WHERE assigned_to = '.$this->session->userdata('user_id').' ORDER BY id DESC');
                                                }
                                    	?>
                                    	<ul class="nav nav-pills navtab-bg nav-justified">
	                                        <li class="nav-item">
	                                            <a href="#home1" data-toggle="tab" aria-expanded="false" class="nav-link active">
	                                                CAD
	                                            </a>
	                                        </li>
	                                        <li class="nav-item">
	                                            <a href="#profile1" data-toggle="tab" aria-expanded="true" class="nav-link">
	                                                RENDER
	                                            </a>
	                                        </li>
	                                        
	                                    </ul>
	                                    <div class="tab-content">
                                        <div class="col tab-pane show active" id="home1">
                                            <!-- <h5 class="mb-2 font-size-16">Detail</h5> -->
                                            <?php
                                                
                                                if(isset($detail) && $detail->num_rows() > 0)
                                                {
                                                    $detail = $detail->result_array();
                                                    foreach($detail as $d)
                                                    {
                                                        $status_name = $this->master_model->get_one_record('status', 'status_name', $d['status']);
                                                        ?>
                                                            <div class="media mt-3 p-1">
                                                                <div class="media-body">
                                                                    <h4>
                                                                        <?php  echo $this->master_model->get_one_record('production_order', 'order_number', $d['job_id']);?>
                                                                    </h4>
                                                                    <h5 class="mt-0 mb-0 font-size-14">
                                                                        <span class="float-right text-muted font-12"><?php echo date('d M Y', strtotime($d['created_date']));?> <?php echo date('h:i A', strtotime($d['created_date']));?></span>
                                                                        <?php echo $this->master_model->get_one_record('users', 'full_name', $d['created_by']);?>
                                                                    </h5>
                                                                    <p class="mt-1 mb-0 text-muted">
                                                                        <?php
                                                                            if($status_name == 'Allocated')
                                                                            {
                                                                                $designer = $this->master_model->get_one_record('users', 'full_name', $d['assigned_to']);
                                                                                $description = $d['description'].' '.$designer;
                                                                            }
                                                                            else if($status_name == 'Paused')
                                                                            {
                                                                                $description = $d['description'].'<br>'.$d['reason'];
                                                                            }
                                                                            else{
                                                                                $description = $d['description'];
                                                                            }
                                                                            echo $description;


                                                                            ?><br><?php 

                                                                            $status_data = $this->db->get_where('status', ['id' =>  $d['status']])->result_array();
                                                                            $status_name = $status_data[0]['status_name'];
                                                                            $color = $status_data[0]['color'];


                                                                            echo '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$color.';border:1px solid '.$color.';">'.$status_name.'</span>';?>

                                                                            
                                                                            <?php
                                                                                echo $d['remark'] != '' ? '<br>'.$d['remark'] : '';
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
                                        <div class="col tab-pane" id="profile1">
                                        	<?php
                                        		if(isset($detail2) && $detail2->num_rows() > 0)
                                                {
                                                    $detail2 = $detail2->result_array();
                                                    foreach($detail2 as $d)
                                                    {
                                                        $status_name = $this->master_model->get_one_record('ms_render_status', 'label', $d['status']);
                                                        ?>
                                                            <div class="media mt-3 p-1">
                                                                <div class="media-body">
                                                                    <h4>
                                                                        <?php  echo $this->master_model->get_one_record('render_production_order', 'order_number', $d['job_id']);?>
                                                                    </h4>
                                                                    <h5 class="mt-0 mb-0 font-size-14">
                                                                        <span class="float-right text-muted font-12"><?php echo date('d M Y', strtotime($d['created_date']));?> <?php echo date('h:i A', strtotime($d['created_date']));?></span>
                                                                        <?php echo $this->master_model->get_one_record('users', 'full_name', $d['created_by']);?>
                                                                    </h5>
                                                                    <p class="mt-1 mb-0 text-muted">
                                                                        <?php
                                                                            if($status_name == 'Allocated')
                                                                            {
                                                                                $designer = $this->master_model->get_one_record('users', 'full_name', $d['assigned_to']);
                                                                                $description = $d['description'].' '.$designer;
                                                                            }
                                                                            else if($status_name == 'Paused')
                                                                            {
                                                                                $description = $d['description'].'<br>'.$d['reason'];
                                                                            }
                                                                            else{
                                                                                $description = $d['description'];
                                                                            }
                                                                            echo $description;


                                                                            ?><br><?php 

                                                                            $status_data = $this->db->get_where('ms_render_status', ['id' =>  $d['status']])->result_array();
                                                                            $status_name = $status_data[0]['label'];
                                                                            $color = $status_data[0]['color'];


                                                                            echo '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$color.';border:1px solid '.$color.';">'.$status_name.'</span>';?>

                                                                            
                                                                            <?php
                                                                                echo $d['remark'] != '' ? '<br>'.$d['remark'] : '';
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
<?php $this->load->view('common/change_password');?>
</body>
</html>