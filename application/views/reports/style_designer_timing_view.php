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
                            <h4 class="page-title">Style Wise - Designer Wise -Timing Report (completed Orders)</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->



                <div class="row">

                    <div class="col-12">
                        
                        <div class="card-box">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>From</label>
                                        <input type="text" id="basic-datepicker" name="basic_datepicker" class="form-control" placeholder="From Date" value="<?php echo isset($_REQUEST['basic_datepicker']) && $_REQUEST['basic_datepicker'] != '' ? $_REQUEST['basic_datepicker'] : '';?>">
                                    </div>

                                    <div class="form-group col-6">
                                        <label>To</label>
                                        <input type="text" id="basic-datepicker1" name="basic_datepicker1" class="form-control" placeholder="To Date" value="<?php echo isset($_REQUEST['basic_datepicker1']) && $_REQUEST['basic_datepicker1'] != '' ? $_REQUEST['basic_datepicker1'] : '';?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="user_id">Designer</label>
                                        <select class="form-control" name="user_id" id="user_id" data-toggle="select2">
                                            <option value="">Select</option>
                                            <?php
                                            $users = $this->db->query('SELECT id, full_name FROM `users` WHERE user_role IN (SELECT id FROM role WHERE `role_name` = "designer" OR `role_name` = "manager")');
                                            if($users->num_rows() > 0)
                                            {
                                                $users = $users->result_array();
                                                foreach($users as $c)
                                                {
                                                    $selected = isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '' && $_REQUEST['user_id'] != 'Select' && $_REQUEST['user_id'] == $c['id'] ? 'selected' : '';
                                                    echo '<option value="'.$c['id'].'" '.$selected.'>'.$c['full_name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>                               

                                <div class="row">

                                    <div class="text-right col-6">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">Filter</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light" id="clear_filter">Clear</button>
                                    </div>
                                </div>

                            </form>

                            
                            <button type="button" class="btn btn-danger mb-2 mr-1 waves-effect waves-light float-right" onclick="export_csv();">Export <i class="mdi mdi-file-excel"></i></button>

                            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" id="tickets-table">
                                
                                <thead>
                                <tr>
                                    <th>
                                        Sr.No
                                    </th>
                                    <th>
                                        Order ID
                                    </th>
                                    <th>Designer</th>
                                    <th>Diffculty</th>
                                    <th>Allocated Time <br>(as per diffculty level)</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Total Time Taken</th>                                    
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $completed_status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Completed"')->result_array()[0]['id'];
                                $today = date('Y-m-d');
                                $conditions = [];
                                $this->db->select('*');
                                $this->db->from('production_order');
                                
                                if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '')
                                {
                                    $this->db->where('assigned_to', $_REQUEST['user_id']);
                                }
                                
                                if(isset($_REQUEST['basic_datepicker']) && $_REQUEST['basic_datepicker'] != '')
                                {
                                    $this->db->where('DATE_FORMAT(order_date, "%Y-%m-%d") >= ', $_REQUEST['basic_datepicker']);
                                    
                                }
                                if(isset($_REQUEST['basic_datepicker1']) && $_REQUEST['basic_datepicker1'] != '')
                                {
                                    $this->db->where('DATE_FORMAT(order_date, "%Y-%m-%d") <= ', $_REQUEST['basic_datepicker1']);
                                }
                                $this->db->where('status', $completed_status);
                                $this->db->order_by('id', 'DESC');
                                $res = $this->db->get();
                               // pre($this->db->last_query());
                                $i = 0;
                                $row = $res->result_array();
                                foreach($row as $r)
                                {
                                    $highlight_tr = '';
                                    
                                    $i++;
                                    ?>
                                    <tr id="order_id_"<?php echo $r['id'];?> class="<?php echo $highlight_tr;?>">

                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $r['order_number']; ?></td>
                                        <td><?php echo $this->master_model->get_one_record('users', 'full_name', $r['assigned_to']);?></td>
                                        <td><?php echo $this->master_model->get_one_record('difficulty', 'difficulty_name', $r['difficulty_id']);?></td>
                                        <td><?php echo $this->master_model->get_one_record('difficulty', 'total_time', $r['difficulty_id']);?></td>
                                        <td>
                                        <?php
                                            $start_time = '';
                                            $start_time_query = $this->db->query('SELECT time FROM `start_stop_time` WHERE `job_id` = '.$r['id'].' AND  `type` = "Start" ORDER BY `id` ASC LIMIT 1');
                                            
                                            if($start_time_query->num_rows() > 0)
                                            {
                                                $start_time = date('H:i', strtotime($start_time_query->result_array()[0]['time']));
                                            }
                                            echo $start_time;

                                        ?>
                                        
                                        </td>
                                        <td>
                                        <?php
                                            $stop_time = '';
                                            $stop_time_query = $this->db->query('SELECT time FROM `start_stop_time` WHERE `job_id` = '.$r['id'].' AND  `type` = "Stop" ORDER BY `id` DESC LIMIT 1');
                                            
                                            if($stop_time_query->num_rows() > 0)
                                            {
                                                $stop_time = date('H:i', strtotime($stop_time_query->result_array()[0]['time']));
                                            }
                                            echo $stop_time;

                                        ?>
                                        
                                        </td>
                                        <td>
                                        <?php
                                            $actual_time = '';
                                            $actual_time_query = $this->db->query('SELECT actual_time FROM `start_stop_action` WHERE `job_id` = '.$r['id'].' ORDER BY `id` DESC LIMIT 1');
                                            
                                            if($actual_time_query->num_rows() > 0)
                                            {
                                                $actual_time = date('H:i', $actual_time_query->result_array()[0]['actual_time']);
                                            }

                                            echo $actual_time;
                                        ?>
                                        
                                        </td>
                                    </tr>
                                    <?php
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


<!-- Tickets js -->
<!--<script src="--><?php //echo base_url();?><!--assets/js/pages/tickets.js"></script>-->

<script>
    $(document).ready(function(){

        $("#tickets-table").DataTable({language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}, "bSort" : false})
    });
</script>

<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>
<script type="text/javascript">
    $('#clear_filter').click(function(){

        window.location.href = '<?php echo base_url();?>style_designer_timing';
    });

    function export_csv()
    {
    
       var user_id = '<?php echo isset($_REQUEST["user_id"]) ? $_REQUEST["user_id"] : "";?>'; 
       var basic_datepicker = '<?php echo isset($_REQUEST["basic_datepicker"]) ? $_REQUEST["basic_datepicker"] : "";?>'; 
       var basic_datepicker1 = '<?php echo isset($_REQUEST["basic_datepicker1"]) ? $_REQUEST["basic_datepicker1"] : "";?>'; 

        window.open(
                "<?php echo base_url()?>style_designer_timing/export_csv?&user_id="+user_id+"&basic_datepicker="+basic_datepicker+"&basic_datepicker1="+basic_datepicker1,
                "_self" // <- This is what makes it open in a new window.
            );
            return false;
    }


</script>
</body>
</html>