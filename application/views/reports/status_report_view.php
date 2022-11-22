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

                                    <li class="breadcrumb-item active"><button type="button" class="btn btn-danger mb-2 mr-1 waves-effect waves-light float-right" onclick="export_status_report_csv();">Export <i class="mdi mdi-file-excel"></i></button>
</li>
                                </ol>
                            </div>
                            <h4 class="page-title"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?></h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->



                <div class="row">

                    <div class="col-12">
                        
                        <div class="card-box">
                            <form action="" method="get" id="filter_form">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="order_no">Order No</label>
                                        <input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order No" value="<?php echo isset($_REQUEST['order_no']) && $_REQUEST['order_no'] != '' ? $_REQUEST['order_no'] : '';?>">

                                    </div>

                                    <div class="form-group col-4">
                                        <label for="filter_user_id">Designer</label>
                                        <select class="form-control" name="filter_user_id" id="filter_user_id" data-toggle="select2">
                                            <option value="">Select</option>
                                            <?php
                                            $users = $this->db->query('SELECT id, full_name FROM `users` WHERE user_role = (SELECT id FROM role WHERE role_name = "Cad Designer")');
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

                                    <div class="form-group col-4">
                                        <label for="client">Client Name</label>
                                        <select class="form-control" name="client" id="client" data-toggle="select2">
                                            <option value="">Select</option>
                                            <?php
                                            $client_name = $this->db->query('SELECT DISTINCT client_name FROM `production_order`');
                                            if($client_name->num_rows() > 0)
                                            {
                                                $client_name = $client_name->result_array();
                                                foreach($client_name as $c)
                                                {
                                                    $selected = isset($_REQUEST['client']) && $_REQUEST['client'] != '' && $_REQUEST['client'] == $c['client_name'] ? 'selected' : '';
                                                    echo '<option value="'.$c['client_name'].'" '.$selected.'>'.$c['client_name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="form-group col-4">
                                        <label for="status_name">Status</label>
                                        <select class="form-control" name="status_name" id="status_name" data-toggle="select2">
                                            <option value="">Select</option>
                                            <?php
                                            $status = $this->db->query('SELECT id, status_name FROM `status`');
                                            if($status->num_rows() > 0)
                                            {
                                                $status = $status->result_array();
                                                foreach($status as $s)
                                                {
                                                    $selected1 = isset($_REQUEST['status_name']) && $_REQUEST['status_name'] != '' && $_REQUEST['status_name'] == $s['id'] ? 'selected' : '';
                                                    echo '<option value="'.$s['id'].'" '.$selected1.'>'.$s['status_name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="difficulty_name">Difficulty</label>
                                        <select class="form-control" name="difficulty_name" id="difficulty_name" data-toggle="select2">
                                            <option value="">Select</option>
                                            <?php
                                            $difficulty = $this->db->query('SELECT id, difficulty_name FROM `difficulty`');
                                            if($difficulty->num_rows() > 0)
                                            {
                                                $difficulty = $difficulty->result_array();
                                                foreach($difficulty as $d)
                                                {
                                                    $selected = isset($_REQUEST['difficulty_name']) && $_REQUEST['difficulty_name'] != '' && $_REQUEST['difficulty_name'] == $d['difficulty_name'] ? 'selected' : '';
                                                    echo '<option value="'.$d['difficulty_name'].'" '.$selected.'>'.$d['difficulty_name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="order_no">PO No</label>
                                        <input type="text" class="form-control" name="po_no" id="po_no" placeholder="PO No" value="<?php echo isset($_REQUEST['po_no']) && $_REQUEST['po_no'] != '' ? $_REQUEST['po_no'] : '';?>">

                                    </div>
                                   
                                    
                                </div>

                                <div class="row">

                                    

                                    <div class="form-group col-4">

                                        <label for="basic-datepicker">From</label>
                                        <input type="text" id="basic-datepicker" name="from_date" class="form-control" placeholder="From Date" value="<?php echo isset($_REQUEST['from_date']) && $_REQUEST['from_date'] != '' ? $_REQUEST['from_date'] : '';?>">
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="basic-datepicker1">To</label>
                                        <input type="text" id="basic-datepicker1" name="to_date" class="form-control" placeholder="To Date" value="<?php echo isset($_REQUEST['to_date']) && $_REQUEST['to_date'] != '' ? $_REQUEST['to_date'] : '';?>">
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="text-right col-12">
                                        <button type="button" class="btn btn-success waves-effect waves-light" id="filter_btn">Filter</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light" id="clear_filter">Clear</button>
                                    </div>
                                </div>

                            </form>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <?php
                                        $pdw_sent = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "PDW Sent"')->result_array()[0]['id'];
                                    ?>
                                    <table class="table table-hover table-bordered m-0 table-centered nowrap w-100" id="tickets-table">
                                
                                        <thead>
                                        <tr>
                                            
                                            <th>
                                                Order Number
                                            </th>
                                            <th>
                                                PO No
                                            </th>
                                            <th>Category</th>
                                            <th>Client</th>
                                            <th>Date</th>                                                
                                            <th>Latest ACT</th>
                                            <th>Current Status</th>
                                            <th>Status</th>
                                            <th>Difficulty</th>
                                            <th>Current Designer</th>
                                            <th>Total Time</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        
                                        $today = date('Y-m-d');
                                        $completed_status = $this->db->query('SELECT id FROM status WHERE status_name = "Completed"')->result_array()[0]['id'];
                                        if(isset($_REQUEST['difficulty_id']) && $_REQUEST['difficulty_id'] != '')
                                        {
                                            $difficulty_name = $this->master_model->get_one_record('difficulty', 'difficulty_name', $_REQUEST['difficulty_id']);
                                        }
                                        
                                        if(!empty($_REQUEST))
                                        {
                                            $this->db->select('b.id, b.order_number, b.po_no, b.category, b.client_name, b.order_date, b.file_path, b.difficulty_id, b.assigned_to, b.password, b.deadline, b.status AS status, a.status AS log_status, a.created_date');
                                            $this->db->from('production_order as b');
                                            $this->db->join('order_log as a', 'a.job_id = b.id', 'LEFT');
                                            if(isset($_REQUEST['status_name']) && $_REQUEST['status_name'] != '')
                                            {
                                                $this->db->where('a.status', $_REQUEST['status_name']);
                                            }
                                            if(isset($_REQUEST['filter_user_id']) && $_REQUEST['filter_user_id'] != '')
                                            {
                                                $this->db->where('a.assigned_to', $_REQUEST['filter_user_id']);
                                            }
                                            if(isset($_REQUEST['client']) && $_REQUEST['client'] != '')
                                            {
                                                $this->db->where('b.client_name', $_REQUEST['client']);
                                            }
                                            
                                            if(isset($_REQUEST['difficulty_name']) && $_REQUEST['difficulty_name'] != '')
                                            {
                                                $this->db->where('b.initial_difficulty',$_REQUEST['difficulty_name']);
                                            }
                                            
                                            if(isset($_REQUEST['order_no']) && $_REQUEST['order_no'] != '')
                                            {
                                                $this->db->like('b.order_number', trim($_REQUEST['order_no']));
                                            }

                                            if(isset($_REQUEST['po_no']) && $_REQUEST['po_no'] != '')
                                            {
                                                $this->db->like('b.po_no', trim($_REQUEST['po_no']));
                                            }
                                            
                                            if(isset($_REQUEST['from_date']) && $_REQUEST['from_date'] != '')
                                            {
                                                $this->db->where('DATE_FORMAT(a.created_date, "%Y-%m-%d") >= ', $_REQUEST['from_date']);
                                                
                                            }
                                            if(isset($_REQUEST['to_date']) && $_REQUEST['to_date'] != '')
                                            {
                                                $this->db->where('DATE_FORMAT(a.created_date, "%Y-%m-%d") <= ', $_REQUEST['to_date']);
                                            }

                                            if(isset($_REQUEST['status_name']) && $_REQUEST['status_name'] == $pdw_sent)
                                            {
                                                $this->db->group_by('b.order_number');
                                            }
                                            $this->db->order_by('a.created_date', 'DESC');
                                            $res = $this->db->get();                                         
                                        
                                            #pre($this->db->last_query());

                                            $i = 1;
                                            $row = $res->result_array();
                                            foreach($row as $r)
                                            {
                                                $highlight_tr = '';
                                                $actual_time_query = $this->db->query('SELECT actual_time FROM `start_stop_action` WHERE `job_id` = '.$r['id'].' ORDER BY `id` DESC LIMIT 1');
                                                
                                                if($actual_time_query->num_rows() > 0)
                                                {

                                                    $actual_time = $actual_time_query->result_array()[0]['actual_time'];
                                                    $actual_time_in_minutes = isset($actual_time) ? floor(($actual_time / 60) % 60) : '';

                                                    $total_time_query = $this->db->query('SELECT total_time FROM `difficulty` WHERE id = '.$r['difficulty_id']);
                                                    if($total_time_query->num_rows() > 0)
                                                    {
                                                        $total_time = $total_time_query->result_array()[0]['total_time'];
                                                    }

                                                    $highlight_tr = isset($actual_time_in_minutes) && !empty($actual_time_in_minutes) && isset($total_time) && $actual_time_in_minutes > $total_time ? 'highlight_tr' : '';
                                                }

                                                
                                                $status_data = $this->db->get_where('status', ['id' =>  $r['status']])->result_array();
                                                $status_name = $status_data[0]['status_name'];
                                                $color = $status_data[0]['color'];

                                                $log_status_data = $this->db->get_where('status', ['id' =>  $r['log_status']])->result_array();
                                                $log_status_name = $log_status_data[0]['status_name'];
                                                $log_statuscolor = $log_status_data[0]['color'];
                                                $i++;
                                                ?>
                                                <tr id="order_id_"<?php echo $r['id'];?> class="<?php echo $highlight_tr;?>">

                                                    <td><?php echo $r['order_number']; ?></td>
                                                    <td><?php echo $r['po_no']; ?></td>
                                                    <td><?php echo $r['category']; ?></td>
                                                    <td><?php echo $r['client_name']; ?></td>
                                                    <?php
                                                        if(isset($_REQUEST['date_type']) && $_REQUEST['date_type'] == 'Status Date')
                                                        {
                                                            echo '<td>'.date('Y-m-d', strtotime($r['created_date'])).'</td>';
                                                        }
                                                        else if(!isset($_REQUEST['date_type']) || (isset($_REQUEST['date_type']) && $_REQUEST['date_type'] == 'Order Date'))
                                                        {
                                                            echo '<td>'.date('d-m-Y', strtotime($r['order_date'])).'</td>';
                                                        }
                                                    ?>
                                                    
                                                    <td><?php echo isset($r['created_date']) && !empty($r['created_date']) ? date('d-m-y', strtotime($r['created_date'])).'<br>'.date('H:i', strtotime($r['created_date'])) : '';?></td>
                                                    <td><?php echo '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$color.';border:1px solid '.$color.';">'.$status_name.'</span>';?></td>
                                                    <td><?php echo '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$log_statuscolor.';border:1px solid '.$log_statuscolor.';">'.$log_status_name.'</span>';?></td>
                                                    
                                                    <td><?php 
                                                        $difficulty_query = $this->db->query('SELECT difficulty_id FROM `order_log` WHERE `job_id` = '.$r['id'].' AND difficulty_id != 0 AND is_dealocated = 0');
                                                        // pre($this->db->last_query());
                                                        if($difficulty_query->num_rows() > 0)
                                                        {
                                                            $difficulties = [];
                                                            $difficulty_id_column = $difficulty_query->result_array();
                                                            
                                                            foreach ($difficulty_id_column as $k1 => $v1) {
                                                                $difficulty_name = $this->db->query('SELECT difficulty_name FROM difficulty WHERE id = '.$v1['difficulty_id'])->result_array()[0]['difficulty_name'];
                                                                array_push($difficulties, $difficulty_name);

                                                            }
                                                            
                                                            if(!empty($difficulties))
                                                            {
                                                                
                                                                $difficulties = implode(' / ', $difficulties);
                                                                echo $difficulties;
                                                            }

                                                        }
                                                        ?></td>
                                                    <td><?php echo $this->master_model->get_one_record('users', 'full_name', $r['assigned_to']);?></td>
                                                    <?php
                                                        $start_stop_time = $this->db->query('SELECT * FROM `start_stop_time` WHERE job_id = '.$r['id'].' ORDER BY id DESC LIMIT 1');
                                                        if($start_stop_time->num_rows() > 0)
                                                        {
                                                            $start_stop_time = $start_stop_time->result_array();
                                                            // pre($start_stop_time);
                                                            $type = $start_stop_time[0]['type'];
                                                            if($type == 'Start')
                                                            {
                                                                $created_date = $start_stop_time[0]['created_date'];
                                                                $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($created_date);
                                                            }
                                                            else
                                                            {
                                                                $diff = 0;
                                                            }
                                                            // pre($diff);

                                                            $start_stop_action = $this->db->query('SELECT * FROM `start_stop_action` WHERE job_id = '.$r['id'].' ORDER BY id DESC LIMIT 1');
                                                            if($start_stop_action->num_rows() > 0)
                                                            {
                                                                $actual_time = $diff + $start_stop_action->result_array()[0]['actual_time'];
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
                                                    <td><?php echo $finalhms;?></td>
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
<script type="text/javascript">
    $('#clear_filter').click(function(){

        window.location.href = '<?php echo base_url();?>reports/status_report';
    });

    
    $('#filter_btn').click(function(){

        
        if($('#order_no').val() == '' && $('#filter_user_id').val() == '' && $('#client').val() == '' && $('#status_name').val() == '' && $('#difficulty_name').val() == '' && $('#po_no').val() == '' && $('#basic-datepicker').val() == '' && $('#basic-datepicker1').val() == '')
        {
        	
            alert('Please select at least one filter option');
            return false;
           
        }
        else
        {
        	
            $('#filter_form').submit();
        }
        
    });

    function export_status_report_csv()
    {
       var order_no = '<?php echo isset($_REQUEST["order_no"]) ? $_REQUEST["order_no"] : "";?>'; 
       var client = '<?php echo isset($_REQUEST["client"]) ? $_REQUEST["client"] : "";?>'; 
       var user_id = '<?php echo isset($_REQUEST["filter_user_id"]) ? $_REQUEST["filter_user_id"] : "";?>'; 
       var difficulty_name = '<?php echo isset($_REQUEST["difficulty_name"]) ? $_REQUEST["difficulty_name"] : "";?>';
       var status_name = '<?php echo isset($_REQUEST["status_name"]) ? $_REQUEST["status_name"] : "";?>';
       var from_date = '<?php echo isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : "";?>'; 
       var to_date = '<?php echo isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : "";?>'; 
       var po_no = '<?php echo isset($_REQUEST["po_no"]) ? $_REQUEST["po_no"] : "";?>'; 

        window.open(
                "<?php echo base_url()?>reports/export_status_report_csv?order_no="+order_no+"&user_id="+user_id+"&status_name="+status_name+"&from_date="+from_date+"&to_date="+to_date+"&difficulty_name="+difficulty_name+"&client="+client+"&po_no="+po_no,
                "_self" // <- This is what makes it open in a new window.
            );
            return false;
    }


</script>
<?php $this->load->view('common/change_password');?>
</body>
</html>