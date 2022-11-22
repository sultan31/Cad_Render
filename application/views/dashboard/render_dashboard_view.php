<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?></title>
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

    <style>
        .avatar-title{
            display: flex !important;
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

                                    <li class="breadcrumb-item active"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?></li>
                                </ol>
                            </div> -->
                            <h4 class="page-title"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?></h4>
                        </div>


                    </div>
                </div>
                <!-- end page title -->


                <div class="row">
                    <?php
                            
                    	   if($role_name == 'Dept Manager' || $role_name == 'Render Designer')
                           {
                                $department = $this->db->query('SELECT * FROM `department` WHERE id IN (SELECT dept_id FROM user_departments WHERE user_id = '.$this->session->userdata('user_id').')');
                           }
                           else
                           {
                                $department = $this->db->query('SELECT * FROM `department`');
                           }

                            
                            if($department->num_rows() > 0)
                            {
                                $department = $department->result_array();
                                foreach ($department as $key => $value)
                                {
                            ?>
                                    <div class="col-md-6 col-xl-3">
                                        <a href="<?php echo base_url();?>render_production_orders?department_id=<?php echo $value['id'];?>">
                                        <div class="widget-rounded-circle card-box">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="avatar-lg rounded-circle bg-primary">
                                                        <i class=" fas  fas fa-shopping-basket font-22 avatar-title text-white"></i>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-right">
                                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">
                                                            <?php 

                                                            if($role_name == 'Render Designer')
                                                            {
                                                                
                                                                $total_orders = $this->db->query('SELECT COUNT(id) AS total_orders FROM render_production_order WHERE delete_flag = 0 AND department_id = '.$value['id'].' AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['total_orders'];
                                                            }
                                                            else if($role_name == 'Dept Manager')
                                                            {
                                                                $total_orders = $this->db->query('SELECT COUNT(id) AS total_orders FROM render_production_order WHERE delete_flag = 0 AND department_id = '.$value['id'])->result_array()[0]['total_orders'];
                                                            }
                                                            else
                                                            {
                                                                // select count from production order where detp_id IN (Select child id from dept_paretn_child where paretid  = 24 )

                                                                $total_orders = $this->db->query('SELECT COUNT(id) AS total_orders FROM render_production_order WHERE delete_flag = 0 AND department_id = '.$value['id'])->result_array()[0]['total_orders'];
                                                            }
                                                            echo $total_orders;
                                                            ?></span></h3>
                                                        <p class="text-muted mb-1 text-truncate"><?php echo $value['dept_name'];?></p>
                                                    </div>
                                                </div>
                                            </div> <!-- end row-->
                                        </div> <!-- end widget-rounded-circle-->
                                        </a>
                                    </div> <!-- end col-->
                    <?php
                                }

                            }
                        
                    ?>
                    


                    

                    

                    
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


<!-- Tickets js -->
<!--<script src="--><?php //echo base_url();?><!--assets/js/pages/tickets.js"></script>-->

<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>
<?php $this->load->view('common/change_password');?>

</body>
</html>