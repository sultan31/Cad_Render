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
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Notification Center</a></li>
                                            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Extras</a></li> -->
                                            <li class="breadcrumb-item active">View</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"></h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 


                        <div class="row">
                            <div class="col-4">
                            	<!-- <div class="card-box">
                                    <h4 class="header-title mb-3">Order Details</h4>
                                    <?php
                                            $order_details //= $this->db->query('SELECT * FROM production_order WHERE id = '.$order_id);
                                           // if($order_details->num_rows() > 0)
                                            {
                                                $order_details //= $order_details->result_array();
                                            }
                                    ?>
                                    <div class="text-center" dir="ltr">
                                        
                                        <div class="table-responsive">
                                        <table class="table mb-0">
                                            
                                            <tbody>
                                            <tr>
                                                <td>Order No</td>
                                                <td><?php //echo isset($order_details[0]['order_number']) ? $order_details[0]['order_number'] : '';?></td>
                                            </tr>
                                            <tr>
                                                <td>Start Date</td>
                                                <?php
                                                    $start_date_query //= $this->db->query('SELECT * FROM `start_stop_time` WHERE `job_id` = '.$order_details[0]['id'].' AND type = "Start" ORDER BY id ASC LIMIT 1');
                                                    //if($start_date_query->num_rows() > 0)
                                                    {
                                                        $start_date// = $start_date_query->result_array()[0]['created_date'];
                                                    }
                                                    //else{
                                                        $start_date// = '';
                                                    }
                                                ?>
                                                <td><?php //echo isset($start_date) && $start_date != '' ? date('d F Y', strtotime($start_date)) : '';?></td>
                                            </tr>
                                            <tr>
                                                <td>Est. End Date</td>
                                                
                                                <td>1 March 2020</td>
                                            </tr>
                                            <tr>
                                                <td>Completed On</td>
                                                <?php
                                                    $complete_date_query// = $this->db->query('SELECT * FROM `order_log` WHERE `job_id` = '.$order_details[0]['id'].' AND status = (SELECT id FROM status WHERE status_name = "Completed")');
                                                    //if($complete_date_query->num_rows() > 0)
                                                    {
                                                      //  $complete_date = $complete_date_query->result_array()[0]['created_date'];
                                                    }
                                                    //else{
                                                      //  $complete_date = '';
                                                    }
                                                ?>
                                                <td><?php// echo isset($complete_date) && $complete_date != '' ? date('d F Y', strtotime($complete_date)) : '';?></td>
                                            </tr>
                                            <tr>
                                                <td>Current Status</td>
                                                <?php
                                                    $status//_data = $this->db->query('SELECT status_name,color FROM status WHERE id = (SELECT status FROM order_log WHERE job_id = '.$order_id.' ORDER BY id DESC LIMIT 1)')->result_array();
                                                    $status_n//ame = $status_data[0]['status_name'];
                                                    //$color = $status_data[0]['color'];
                                                ?>
                                                <td><?//php echo '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$color.';border:1px solid '.$color.';">'.$status_name.'</span>';?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>

                                </div> -->
                            </div> <!-- end col -->
                            <div class="col-8">
                            	<div class="card">
	 								<div class="card-body">
		                                <div class="col">
                                            <h5 class="mb-2 font-size-16">Detail</h5>
                                            <?php
                                                $detail = $this->db->query('SELECT * FROM order_log WHERE user_id = '.$designer_id);
                                                if($detail->num_rows() > 0)
                                                {
                                                    $detail = $detail->result_array();
                                                    foreach($detail as $d)
                                                    {
                                                        $status_name = $this->master_model->get_one_record('status', 'status_name', $d['status']);
                                                        ?>
                                                            <div class="media mt-3 p-1">
                                                                <div class="media-body">
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
                                            <div class="media mt-3 p-1">
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-0 font-size-14">
                                                        <span class="float-right text-muted font-12">1 March 2021 4:30am</span>
                                                        Arya Stark
                                                    </h5>
                                                    <p class="mt-1 mb-0 text-muted">
                                                        Order moved to production<br>STATUS BADGE
                                                    </p>
                                                </div>
                                            </div> <!-- end comment -->

                                            <hr>

                                            <div class="media mt-3 p-1">
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-0 font-size-14">
                                                        <span class="float-right text-muted font-12">2 March 2021 4:30am</span>
                                                        Arya Stark
                                                    </h5>
                                                    <p class="mt-1 mb-0 text-muted">
                                                        Order Allocated to Designer1<br>STATUS BADGE
                                                    </p>
                                                </div>
                                            </div> <!-- end comment -->

                                            <hr>

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
                                2015 - <script>document.write(new Date().getFullYear())</script> &copy; UBold theme by <a href="">Coderthemes</a> 
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">About Us</a>
                                    <a href="javascript:void(0);">Help</a>
                                    <a href="javascript:void(0);">Contact Us</a>
                                </div>
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