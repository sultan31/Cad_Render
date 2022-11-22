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
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">

                                    <li class="breadcrumb-item active"><button type="button" class="btn btn-danger mb-2 mr-1 waves-effect waves-light float-right" onclick="export_csv();">Export <i class="mdi mdi-file-excel"></i></button>
</li>
                                </ol>
                            </div>
                            <h4 class="page-title"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?> (Order No: <?php echo $this->db->query('SELECT order_number FROM production_order WHERE id = '.$order_id)->result_array()[0]['order_number'];?>)</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->



                <div class="row">

                    <div class="col-12">
                        
                        <div class="card-box">
                            

                            <div class="row mt-2">
                                <div class="col-12">
                                    
                                    <table class="table table-hover table-bordered m-0 table-centered nowrap w-100" id="tickets-table">
                                
                                        <thead>
                                        <tr>
                                            
                                            <th>
                                                Designer
                                            </th>
                                            
                                            
                                            <th>Total Allocated Time</th>
                                            
                                            <th>Total Time Taken</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        
                                        
                                            $cad_action_time = $this->db->query('SELECT DISTINCT user_id FROM `cad_action_time` WHERE `job_id` = '.$order_id.' AND `user_id` IN (SELECT id FROM `users` WHERE `user_role` = (SELECT id FROM `role` WHERE `role_name` = "Cad Designer"))');
                                            
                                            
                                            #pre($this->db->last_query());

                                            $i = 1;
                                            if($cad_action_time->num_rows() > 0)
                                            {
                                               $row = $cad_action_time->result_array();
                                                foreach($row as $r)
                                                {                                                                                                     
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php 

                                                                $users = $this->db->query('SELECT full_name FROM `users` WHERE `id` = '.$r['user_id']);
                                                                if($users->num_rows() > 0)
                                                                {
                                                                    $full_name = $users->result_array()[0]['full_name'];
                                                                    echo strtoupper($full_name);
                                                                }
                                                                else
                                                                {
                                                                    $full_name = '';
                                                                    echo $full_name;
                                                                }                                                              
                                                            ?>
                                                                
                                                        </td>

                                                       <?php
                                                       $get_total_time = $this->db->query("SELECT SUM(`diff_time`) AS total_alloc_time FROM `cad_action_time` WHERE `user_id` = ".$r['user_id']." AND job_id = '".$order_id."'");

                                                     // pre($this->db->last_query());

                                                    if($get_total_time->num_rows() > 0){
                                                        $get_total_time = $get_total_time->result_array()[0]['total_alloc_time'];

                                                    }
                                                    else{
                                                        $get_total_time = 0;
                                                    }

                                                    
                                                    $get_total_work_time = $this->db->query("SELECT SUM(actual_time) AS working_time FROM cad_action_time WHERE user_id = ".$r['user_id']." AND job_id = '".$order_id."'");
                                                    if($get_total_work_time->num_rows() > 0)
                                                    {
                                                        $get_total_work_time = $get_total_work_time->result_array()[0]['working_time'];
                                                        
                                                    } 
                                                    else{
                                                       $get_total_work_time = 0; 
                                                    }

                                                   
                                                    ?>
                                                    
                                                    
                                                    <td><?php  
                                                            $init = $get_total_time;
                                                            $hours = floor($init / 60);
                                                            $minutes = floor($init % 60);
                                                            $seconds = 0;

                                                            echo( (sprintf("%02d", $hours)).':'.(sprintf("%02d", $minutes)).':'.(sprintf("%02d", $seconds)).' Hrs');
                                                     ?></td>
                                                    <td><?php 
                                                     
                                                            $init1 = $get_total_work_time; ;
                                                            $hours1 = floor($init1 / 3660);
                                                            $minutes1 = floor(($init1/60) % 60);
                                                            $seconds1 = $init1 % 60;

                                                            echo( (sprintf("%02d", $hours1)).':'.(sprintf("%02d", $minutes1)).':'.(sprintf("%02d", $seconds1)).' Hrs');                                                  

                                                        ?></td>
                                                        
                                                    </tr>
                                                    <?php
                                                } 
                                            }
                                            
                                        
                                            
                                        
                                        ?>

                                        </tbody>
                            </table>
                                </div>
                            </div>

                            
                          
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


<!-- Tickets js -->
<!--<script src="--><?php //echo base_url();?><!--assets/js/pages/tickets.js"></script>-->

<script>
    $(document).ready(function(){

        $('#tickets-table').DataTable( {
            // "scrollX": true
        } );
    });
</script>

<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>

<?php $this->load->view('common/change_password');?>

<script type="text/javascript">
    function export_csv()
    {
           var order_id = '<?php echo isset($order_id) ? $order_id : "";?>'; 
           var from_date = '<?php echo isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : "";?>'; 
           var to_date = '<?php echo isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : "";?>'; 
           
            window.open(
                    "<?php echo base_url()?>STL_Report/export_csv_details?order_id="+order_id+"&from_date="+from_date+"&to_date="+to_date,
                    "_self" // <- This is what makes it open in a new window.
                );
                return false;
    }
</script>
</body>
</html>