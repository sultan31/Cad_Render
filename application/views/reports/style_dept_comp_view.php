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

    <link href="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .highlight_tr{background-color:#ffefef;}
        .chk_order{opacity:1;z-index:5;}
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
                            <h4 class="page-title">Designer wise - Department wise - Completed</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->



                <div class="row">

                    <div class="col-12">
                        
                        <div class="card-box">
                            

                            
                            <button type="button" class="btn btn-danger mb-2 mr-1 waves-effect waves-light float-right" onclick="export_csv();">Export <i class="mdi mdi-file-excel"></i></button>

                            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" id="tickets-table1">
                                
                                <thead>
                                <tr>
                                    <th>Row Labels</th>
                                    
                                    <?php
                                        $department = $this->db->query('SELECT id, dept_name FROM department WHERE dept_name != "Final QC"');
                                        if($department->num_rows() > 0)
                                        {
                                            $department = $department->result_array();
                                            foreach ($department as $key => $value) 
                                            {
                                                echo '<th>'.$value['dept_name'].'</th>';
                                            }
                                            echo '<th>Grand Total</th>';
                                        }
                                    ?>                                    
                                </tr>
                                </thead>

                                <tbody>
                                <?php

                                $users = $this->db->query('SELECT DISTINCT order_number FROM render_production_order');
                                if($users->num_rows() > 0)
                                {
                                    $users = $users->result_array();
                                    foreach ($users as $key1 => $value1) 
                                    {
                                    	$sub_total = 0;
                                        echo '<tr>';
                                        echo '<td>'.$value1['order_number'].'</td>';
                                        
                                        foreach ($department as $key => $value) 
                                        {
                                            $completed_status = $this->db->get_where('ms_render_status', ['department_id' => $value['id'], 'name' => 'Completed'])->result_array()[0]['id'];
                                            
                                            $completed_orders = $this->db->get_where('render_production_order', ['department_id' => $value['id'], 'assigned_to' => $value1['id'], 'status' => $completed_status]);

                                            echo '<td>'.$completed_orders->num_rows().'</td>';
                                            $sub_total += $completed_orders->num_rows();
                                        }

                                        echo '<td>'.$sub_total.'</td>';
                                        echo '</tr>';
                                    }


                                }


                                ?>

                                </tbody>
                            </table>
                          
                        </div>
                    </div><!-- end col -->





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

    function export_csv()
    {
    
       // var user_id = '<?php echo isset($_REQUEST["user_id"]) ? $_REQUEST["user_id"] : "";?>'; 
       // var basic_datepicker = '<?php echo isset($_REQUEST["basic_datepicker"]) ? $_REQUEST["basic_datepicker"] : "";?>'; 
       // var basic_datepicker1 = '<?php echo isset($_REQUEST["basic_datepicker1"]) ? $_REQUEST["basic_datepicker1"] : "";?>'; 

       //  window.open(
       //          "<?php echo base_url()?>designer_dept_comp/export_csv?&user_id="+user_id+"&basic_datepicker="+basic_datepicker+"&basic_datepicker1="+basic_datepicker1,
       //          "_self" // <- This is what makes it open in a new window.
       //      );
       //      return false;
    }


</script>
</body>
</html>