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
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">

                                    <li class="breadcrumb-item active"><button type="button" class="btn btn-danger mb-2 mr-1 waves-effect waves-light float-right" onclick="export_csv();">Export <i class="mdi mdi-file-excel"></i></button>
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
                            <form action="" method="get">
                                <div class="row">
                                    <div class="form-group col-2">
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
                                    <div class="form-group col-2">
                                        <label for="order_no">Design No</label>
                                        <input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order No" value="<?php echo isset($_REQUEST['order_no']) && $_REQUEST['order_no'] != '' ? $_REQUEST['order_no'] : '';?>">

                                    </div>
                                    <div class="form-group col-2">
                                        <label for="po_no">PO No</label>
                                        <input type="text" class="form-control" name="po_no" id="po_no" placeholder="PO No" value="<?php echo isset($_REQUEST['po_no']) && $_REQUEST['po_no'] != '' ? $_REQUEST['po_no'] : '';?>">

                                    </div>
                                    <div class="form-group col-3">
                                        <label>From</label>
                                        <input type="text" id="basic-datepicker" name="from_date" class="form-control" placeholder="From Date" value="<?php echo isset($_REQUEST['from_date']) && $_REQUEST['from_date'] != '' ? $_REQUEST['from_date'] : '';?>">
                                    </div>

                                    <div class="form-group col-3">
                                        <label>To</label>
                                        <input type="text" id="basic-datepicker1" name="to_date" class="form-control" placeholder="To Date" value="<?php echo isset($_REQUEST['to_date']) && $_REQUEST['to_date'] != '' ? $_REQUEST['to_date'] : '';?>">
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="text-right col-12">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">Filter</button>
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
                                        Sr No
                                    </th>
                                    <th>
                                        Design No
                                    </th>
                                    <th>
                                        PO No
                                    </th>
                                    <th>Client</th>
                                    <th>
                                        Modification
                                    </th>
                                    <th>Repair</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                    
                                $mod_status = $this->db->query('SELECT id FROM status WHERE status_name = "Modification"')->result_array()[0]['id'];
                                $rep_status = $this->db->query('SELECT id FROM status WHERE status_name = "Repair"')->result_array()[0]['id'];
                                $today = date('Y-m-d');
                                $conditions = [];
                                
                                $this->db->select('id, order_number, po_no, client_name, (SELECT COUNT(id) FROM order_log WHERE production_order.id = order_log.job_id AND status = '.$mod_status.') AS modification, (SELECT COUNT(id) FROM order_log WHERE production_order.id = order_log.job_id AND status = '.$rep_status.') AS repair');
                                
                                if(isset($_REQUEST['client']) && !empty($_REQUEST['client']))
                                {
                                    
                                    $this->db->where('client_name', $_REQUEST['client']);
                                }
                                
                                if(isset($_REQUEST['order_no']) && $_REQUEST['order_no'] != '')
                                {

                                    $this->db->where('order_number', $_REQUEST['order_no']);
                                }

                                if(isset($_REQUEST['po_no']) && $_REQUEST['po_no'] != '')
                                {

                                    $this->db->where('po_no', $_REQUEST['po_no']);
                                }
                                
                                
                                if(isset($_REQUEST['from_date']) && $_REQUEST['from_date'] != '')
                                {
                                    $this->db->where('DATE_FORMAT(updated_date, "%Y-%m-%d") >= ', $_REQUEST['from_date']);
                                    
                                }
                                if(isset($_REQUEST['to_date']) && $_REQUEST['to_date'] != '')
                                {
                                    $this->db->where('DATE_FORMAT(updated_date, "%Y-%m-%d") <= ', $_REQUEST['to_date']);
                                }
                                $this->db->order_by('id', 'ASC');
                                $query = $this->db->get('production_order');
                               //pre($this->db->last_query());
                                $i = 1;

                                if($query->num_rows() > 0)
                                {
                                    $row = $query->result_array();
                                    foreach($row as $r)
                                    {           
                                        
                                        if($r['modification'] > 0 || $r['repair'] > 0)
                                        {


                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><a href="javascript:void(0);" onclick="view_record(<?php echo $r['id'];?>);"><?php echo $r['order_number'];?></a></td>
                                                <td><?php echo $r['po_no'];?></td>
                                                <td><?php echo $r['client_name'];?></td>
                                                <td><?php 
                                                        echo $r['modification'];
                                                    ?>                                                    
                                                </td>
                                                <td><?php 
                                                        echo $r['repair'];
                                                    ?>                                                   
                                                </td>
                                            </tr>
                                        <?php
                                            $i++;
                                        }
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
<div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Design Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4" id="modal_body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Close</button>
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
            // "scrollX": true
        } );
    });
</script>

<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>
<script>

    
    function view_record(order_id)
    {
        
        $.ajax({
                    url: '<?php echo base_url();?>design_no_report/view_record',
                    type: 'POST',
                    data:{'order_id':order_id},
                    success: function(result){
                        // console.log(result);
                        $("#view_modal").modal("toggle");
                        $('#modal_body').html(result);
                    }
                });
    }

    function export_csv()
    {
        
       var order_no = '<?php echo isset($_REQUEST["order_no"]) ? $_REQUEST["order_no"] : "";?>'; 
       var po_no = '<?php echo isset($_REQUEST["po_no"]) ? $_REQUEST["po_no"] : "";?>'; 
       var client = '<?php echo isset($_REQUEST["client"]) ? $_REQUEST["client"] : "";?>'; 
       var from_date = '<?php echo isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : "";?>'; 
       var to_date = '<?php echo isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : "";?>'; 

        window.open(
                "<?php echo base_url()?>design_no_report/export_csv?order_no="+order_no+"&from_date="+from_date+"&to_date="+to_date+"&client="+client+"&po_no="+po_no,
                "_self" // <- This is what makes it open in a new window.
            );
            return false;
    }


    $('#clear_filter').click(function(){
        window.location.href = '<?php echo base_url();?>design_no_report';
    });

</script>
<?php $this->load->view('common/change_password');?>
</body>
</html>