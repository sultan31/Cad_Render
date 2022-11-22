<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(2)));?></title>
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

<?php

if(isset($_REQUEST['department_id']) && !empty($_REQUEST['department_id'])){
    $dept_filter = ' AND department_id = '.$_REQUEST['department_id'];
}
else{
    $dept_filter = '';
}




?>

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

                                     <button type="button" class="btn btn-danger mb-2 mr-1 waves-effect waves-light float-right" onclick="view_detail();">Detail <i class="fe-eye"></i></button>

                                     <button type="button" class="btn btn-danger mb-2 mr-1 waves-effect waves-light float-right" onclick="export_csv();">Export <i class="mdi mdi-file-excel"></i></button>
                                    
                                    <!-- <button type="button" class="btn btn-blue waves-effect waves-light mb-2 mr-1 float-right" data-toggle="modal" data-target="#myModal" style="margin:0 5px;">
                                        <i class="mdi mdi-filter"></i> Filter
                                    </button> -->

                            
                                </ol>
                            </div>
                            <h4 class="page-title"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(2)));?> (<?php echo $this->master_model->get_one_record('users', 'full_name', $id);?>)</h4>


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
                                            <th>Order Number</th>
                                            <th>Total Difficulty Time</th>
                                            <th>Total Time</th>
                                            <th>Dept</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                            // $jobs_data = $this->db->query("SELECT * FROM `render_action_time` WHERE `user_id` = ".$id." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59' ".$dept_filter." ORDER BY job_id ASC");
                                        $jobs_data =  $this->db->query("SELECT id, SUM(`diff_time`) as t_diff_time, SUM(`actual_time`) as t_actual_time, job_id, department_id  FROM `render_action_time` WHERE `user_id` = ".$id." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59' ".$dept_filter." GROUP BY `department_id`, `job_id` ORDER BY job_id ASC");

                                            if($jobs_data->num_rows() > 0){
                                                $jobs_data = $jobs_data->result_array();
                                                // pre($jobs_data);
                                                foreach ($jobs_data as $key => $value) {
                                                    // code...
                                                // pre(gmdate("H:i:s", $value['t_actual_time']));
                                                    // $init = $value['t_diff_time'];
                                                    //         $hours = floor($init / 60);
                                                    //         $minutes = floor($init % 60);
                                                    //         $seconds = $init % 60;
                                                


                                        ?>
                                                    <tr>
                                                        <td><?php echo $this->master_model->get_one_record('render_production_order', 'order_number', $value['job_id']); ?></td>
                                                        <td><?php
                                                            // echo($value['t_diff_time']); 
                                                            $init = $value['t_diff_time'];
                                                            $hours = floor($init / 60);
                                                            $minutes = floor($init % 60);
                                                            $seconds = 0;

                                                            echo( (sprintf("%02d", $hours)).':'.(sprintf("%02d", $minutes)).':'.(sprintf("%02d", $seconds)).' Hrs');
                                                     ?></td>
                                                        <td><?php 
                                                            $init1 = $value['t_actual_time'];
                                                            $hours1 = floor($init1 / 3660);
                                                            $minutes1 = floor(($init1/60) % 60);
                                                            $seconds1 = $init1 % 60;

                                                            echo( (sprintf("%02d", $hours1)).':'.(sprintf("%02d", $minutes1)).':'.(sprintf("%02d", $seconds1)).' Hrs');
                                                         ?></td>
                                                        <td><?php echo $this->master_model->get_one_record('department', 'dept_name', $value['department_id']);?></td>
                                                                                                        
                                                    </tr>
                                                    <?php
                                                }    
                                            }
                                            else{?>
                                                <tr>
                                                    <td colspan="4" style="text-align: center;">No Data Found</td>
                                                </tr>
                                            <?php }    
                                            
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Apply Filter</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="get">
                    
                    <div class="form-group">

                        <label for="basic-datepicker">From</label>
                        <input type="text" id="basic-datepicker" name="from_date" class="form-control" placeholder="From Date" value="<?php echo isset($_REQUEST['from_date']) && $_REQUEST['from_date'] != '' ? $_REQUEST['from_date'] : '';?>">
                    </div>

                    <div class="form-group">
                        <label for="basic-datepicker1">To</label>
                        <input type="text" id="basic-datepicker1" name="to_date" class="form-control" placeholder="To Date" value="<?php echo isset($_REQUEST['to_date']) && $_REQUEST['to_date'] != '' ? $_REQUEST['to_date'] : '';?>">
                    </div>
                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" id="clear_filter">Clear</button>
                        
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
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



<script>
    $(document).ready(function(){

        $('#tickets-table').DataTable( {
             "scrollX": true
        } );
    });
</script>

<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>
<script type="text/javascript">
    $('#clear_filter').click(function(){

        window.location.href = '<?php echo base_url();?>render_reports/render_production';
    });

    function export_csv()
    {
       var user_id = '<?php echo !empty($this->uri->segment(3)) ? $this->uri->segment(3) : '' ;?>';
       var from_date = '<?php echo !empty($this->uri->segment(4)) ? $this->uri->segment(4) : '' ;?>'; 
       var to_date = '<?php echo !empty($this->uri->segment(5)) ? $this->uri->segment(5) : '' ;?>';
       
        window.open(
                "<?php echo base_url()?>render_reports/export_csv_details?user_id="+user_id+"&from_date="+from_date+"&to_date="+to_date,
                "_self" // <- This is what makes it open in a new window.
            );
            return false;
    }

    function view_detail()
    {
       var user_id = '<?php echo !empty($this->uri->segment(3)) ? $this->uri->segment(3) : '' ;?>';
       var from_date = '<?php echo !empty($this->uri->segment(4)) ? $this->uri->segment(4) : '' ;?>'; 
       var to_date = '<?php echo !empty($this->uri->segment(5)) ? $this->uri->segment(5) : '' ;?>';
       
        window.open(
                "<?php echo base_url()?>render_reports/view_detail?user_id="+user_id+"&from_date="+from_date+"&to_date="+to_date,
                "_self" // <- This is what makes it open in a new window.
            );
            return false;
    }


</script>
<?php $this->load->view('common/change_password');?>
</body>
</html>