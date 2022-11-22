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
                                    
                                    <table class="table table-hover table-bordered m-0 table-centered nowrap w-100" id="tickets-table">
                                
                                        <thead>
                                        <tr>
                                            
                                            <th>
                                                Order Number
                                            </th>
                                            
                                            
                                            <th>Status</th>
                                            
                                            <th>Total Time</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        
                                            $completed_status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Completed"')->result_array()[0]['id'];
                                        
                                            if(isset($_REQUEST['order_no']) && !empty($_REQUEST['order_no']))
                                            {
                                                $this->db->where('order_number', $_REQUEST['order_no']);
                                            }
                                            if(isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']))
                                            {
                                                $this->db->where('order_date >= ', $_REQUEST['from_date']." 00:00:00");
                                            }
                                            if(isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']))
                                            {
                                                $this->db->where('order_date <= ', $_REQUEST['to_date']." 23:59:59");
                                            }
                                            $production_order = $this->db->get('production_order');
                                            
                                            // pre($this->db->last_query());

                                            $i = 1;
                                            if($production_order->num_rows() > 0)
                                            {
                                               $row = $production_order->result_array();
                                            foreach($row as $r)
                                            {
                                                

                                                
                                                
                                                $i++;
                                                ?>
                                                <tr>

                                                    <td><a onclick="get_order_details(<?php echo $r['id']; ?>);" style="cursor:pointer;color:blue;"><?php echo $r['order_number']; ?></a></td>
                                                    
                                                    <td>
                                                        <?php 

                                                            $status_data = $this->db->get_where('status', ['id' =>  $r['status']])->result_array();
                                                            $status_name = $status_data[0]['status_name'];
                                                            $color = $status_data[0]['color'];
                                                            echo '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$color.';border:1px solid '.$color.';">'.$status_name.'</span>';
                                                            
                                                        ?>
                                                            
                                                    </td>
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

        window.location.href = '<?php echo base_url();?>STL_Report';
    });

    
    $('#filter_btn').click(function(){

        
        if($('#order_no').val() == '' && $('#basic-datepicker').val() == '' && $('#basic-datepicker1').val() == '')
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
       var from_date = '<?php echo isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : "";?>'; 
       var to_date = '<?php echo isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : "";?>'; 
       
        window.open(
                "<?php echo base_url()?>STL_Report/export_csv?order_no="+order_no+"&from_date="+from_date+"&to_date="+to_date,
                "_self" // <- This is what makes it open in a new window.
            );
            return false;
    }

    
    function get_order_details(order_id)
    {
       var order_no = '<?php echo isset($_REQUEST["order_no"]) ? $_REQUEST["order_no"] : "";?>'; 
       var from_date = '<?php echo isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : "";?>'; 
       var to_date = '<?php echo isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : "";?>'; 
       
        window.open(
                "<?php echo base_url()?>STL_Report/get_order_details?order_id="+order_id+"&order_no="+order_no+"&from_date="+from_date+"&to_date="+to_date,
                "_self" // <- This is what makes it open in a new window.
            );
            return false;
    }


</script>
<?php $this->load->view('common/change_password');?>
</body>
</html>