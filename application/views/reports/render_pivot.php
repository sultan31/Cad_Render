<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Pivot</title>
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

if(isset($_REQUEST['status']) && !empty($_REQUEST['status'])){
    $dept_filter = ' AND status = '.$_REQUEST['status'];
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

                                     
                                     <button type="button" class="btn btn-info mb-2 mr-1 waves-effect waves-light float-right" onclick="export_csv();">Export <i class="mdi mdi-file-excel"></i></button>                                   
                                    
                                </ol>
                            </div>
                            <h4 class="page-title">Details</h4>


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
                                            <th>DIFF</th>
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

                                            
                                        $diff_name =  $this->db->query("SELECT DISTINCT `diff_name` FROM `render_action_time` WHERE `user_id` = ".$user_id);

                                            if($diff_name->num_rows() > 0){
                                                $diff_name = $diff_name->result_array();
                                               
                                                foreach ($diff_name as $key => $value) {                                                    
                                        ?>
                                                    <tr>
                                                        <td><?php echo $value['diff_name']; ?></td>
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

        window.location.href = '<?php echo base_url();?>render_reports/cad_production';
    });

    function export_csv()
    {
       var user_id = '<?php echo isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '' ;?>';
       var from_date = '<?php echo isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']) ? $_REQUEST['from_date'] : '' ;?>'; 
       var to_date = '<?php echo isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']) ? $_REQUEST['to_date'] : '' ;?>';
       
        window.open(
                "<?php echo base_url()?>cad_production_report/export_cad_production_pivot?user_id="+user_id+"&from_date="+from_date+"&to_date="+to_date,
                "_self" // <- This is what makes it open in a new window.
            );
            return false;
    }

    
    

</script>
<?php $this->load->view('common/change_password');?>
</body>
</html>