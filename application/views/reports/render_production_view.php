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

if(isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])){
    $from_date = $_REQUEST['from_date'];
}
else{
    $from_date = date("Y-m-d");
}


if(isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])){
    $to_date = $_REQUEST['to_date'];
}
else{
    // $from_date = date(Y-m-d);
    $to_date = date("Y-m-d");
}

if(isset($_REQUEST['filter_user_id']) && !empty($_REQUEST['filter_user_id'])){
    $filter_user_id = " AND id = ".$_REQUEST['filter_user_id'];
    // pre($filter_user_id);exit();
}
else{
    // $from_date = date(Y-m-d);
    $filter_user_id = '';
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

                                     <button type="button" class="btn btn-danger mb-2 mr-1 waves-effect waves-light float-right" onclick="export_csv();">Export <i class="mdi mdi-file-excel"></i></button>
                                    
                                    <button type="button" class="btn btn-blue waves-effect waves-light mb-2 mr-1 float-right" data-toggle="modal" data-target="#myModal" style="margin:0 5px;">
                                <i class="mdi mdi-filter"></i> Filter
                            </button>

                            
                                </ol>
                            </div>
                            <h4 class="page-title"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(2)));?></h4>
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
                                            
                                            <th>Designer</th>
                                            <th>Total Difficulty Time</th>
                                            <th>Total Time</th>
                                            <?php
                                                $department = $this->db->query('SELECT id,dept_name FROM `department` WHERE show_in_report = 1  ORDER BY report_position ASC');
                                                if($department->num_rows() > 0)
                                                {
                                                    $department = $department->result_array();
                                                    foreach($department as $d)
                                                    {
                                                        echo '<th>'.$d['dept_name'].'</th>';
                                                    }
                                                }
                                            ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            
                                            $users = $this->db->query('SELECT id,full_name FROM `users` WHERE user_role = 7'.$filter_user_id);
                                            if($users->num_rows() > 0)
                                            {
                                                $users = $users->result_array();
                                                foreach($users as $u)
                                                {
                                                    
                                                    // $get_total_time = $this->db->query("SELECT SUM(`total_time`) AS total_alloc_time FROM `difficulty` WHERE id IN (SELECT `difficulty_id` FROM `render_order_log` WHERE `assigned_to` = ".$u['id']." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59' AND `difficulty_id` > 0)")->result_array();

                                                    $get_total_time = $this->db->query("SELECT SUM(`diff_time`) AS total_alloc_time FROM `render_action_time` WHERE `user_id` = ".$u['id']." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59'" );

                                                    if($get_total_time->num_rows() > 0){
                                                        $get_total_time = $get_total_time->result_array()[0]['total_alloc_time'];

                                                    }
                                                    else{
                                                        $get_total_time = 0;
                                                    }

                                                    // pre($this->db->last_query());

                                                    // pre($u['full_name']);

                                                    // pre($get_total_time);

                                                    $get_total_work_time = $this->db->query("SELECT SUM(actual_time) AS working_time FROM render_action_time WHERE user_id = ".$u['id']." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59'");
                                                    if($get_total_work_time->num_rows() > 0)
                                                    {
                                                        $get_total_work_time = $get_total_work_time->result_array()[0]['working_time'];
                                                        // $get_total_work_time = round($get_total_work_time / 60);
                                                    } 
                                                    else{
                                                       $get_total_work_time = 0; 
                                                    }

                                                    // pre($get_total_work_time);  
                                                    ?>
                                                    
                                                    <tr>
                                                    
                                                    <td><?php echo '<a href="'.base_url().'render_reports/detailed_report/'.$u['id'].'/'.$from_date.'/'.$to_date.' ">'.$u['full_name'].'</a>'; ?></td>
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

                                                    <?php

                                                        foreach($department as $d)
                                                        {
                                                            $get_dept_count = $this->db->query("SELECT COUNT(DISTINCT(job_id)) as dept_ord_count FROM render_action_time WHERE user_id = ".$u['id']." AND department_id=".$d['id']." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59'"); 
                                                            if($get_dept_count->num_rows() > 0)
                                                            {
                                                                $get_dept_count1 = $get_dept_count->result_array()[0]['dept_ord_count'];
                                                            }
                                                            else
                                                            {
                                                                $get_dept_count1 = 0;
                                                            }

                                                            ?>
                                                            <td><?php echo $get_dept_count1; ?></td>
                                                        <?php
                                                            // echo '<th>'.$d['dept_name'].'</th>';
                                                        }
                                                    ?>

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
                        <label for="filter_user_id">Designer</label>
                        <select class="form-control" name="filter_user_id" id="filter_user_id" data-toggle="select2">
                            <option value="">Select</option>
                            <?php
                            $users = $this->db->query('SELECT * FROM `users` WHERE user_role IN (SELECT associated FROM dropdown_options WHERE role_id = '.$this->session->userdata('user_role').' AND type = "RENDER") AND active = 1');
                            if($users->num_rows() > 0)
                            {
                                $users = $users->result_array();
                                foreach($users as $c)
                                {
                                    $selected = isset($_REQUEST['filter_user_id']) && $_REQUEST['filter_user_id'] != '' && $_REQUEST['filter_user_id'] == $c['id'] ? 'selected' : '';
                                    echo '<option value="'.$c['id'].'" '.$selected.'>'.$c['full_name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
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


<!-- Tickets js -->
<!--<script src="--><?php //echo base_url();?><!--assets/js/pages/tickets.js"></script>-->

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
       
       var user_id = '<?php echo isset($_REQUEST["filter_user_id"]) ? $_REQUEST["filter_user_id"] : "";?>'; 
       var from_date = '<?php echo isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : "";?>'; 
       var to_date = '<?php echo isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : "";?>'; 
       
        window.open(
                "<?php echo base_url()?>render_reports/export_csv_render_production?user_id="+user_id+"&from_date="+from_date+"&to_date="+to_date,
                "_self" // <- This is what makes it open in a new window.
            );
            return false;
    }


</script>
<?php $this->load->view('common/change_password');?>
</body>
</html>