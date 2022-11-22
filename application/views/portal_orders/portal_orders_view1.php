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


</head>

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": false}'>

<!-- Begin page -->
<div id="wrapper">

    <!-- Topbar Start -->
    <?php $this->load->view('common/header');?>
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->
    <?php $this->load->view('common/sidebar');?>
    <!-- Left Sidebar End -->

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
                        <?php
                        if($this->session->flashdata('message'))
                        {
                            ?>
                            <div class="alert alert-<?php echo $this->session->flashdata('class');?> alert-dismissible bg-<?php echo $this->session->flashdata('class');?> text-white border-0 fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <?php echo $this->session->flashdata('message');?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                if(!empty($_REQUEST))
                                {
                                    ?>
                                        <div class="row">
                                            <?php
                                                if(isset($_REQUEST['order_no']) && $_REQUEST['order_no'] != '')
                                                {
                                                ?>
                                                    <div class="form-group col-md-4">
                                                        <label for="role_name">Order No:</label>
                                                        <?php echo $_REQUEST['order_no'];?>
                                                    </div>
                                            <?php
                                                }
                                                if(isset($_REQUEST['client_name']) && $_REQUEST['client_name'] != '' && $_REQUEST['client_name'] != 'Select')
                                                {
                                                    ?>
                                                    <div class="form-group  col-md-4">
                                                        <label for="role_name">Client:</label>
                                                        <?php echo $_REQUEST['client_name'];?>
                                                    </div>
                                                    <?php
                                                }
                                                if(isset($_REQUEST['category']) && $_REQUEST['category'] != '' && $_REQUEST['category'] != 'Select')
                                                {
                                                    ?>
                                                    <div class="form-group  col-md-4">
                                                        <label for="role_name">Category:</label>
                                                        <?php echo $_REQUEST['category'];?>
                                                    </div>
                                                    <?php
                                                }

                                                
                                                if(isset($_REQUEST['from_date']) && $_REQUEST['from_date'] != '')
                                                {
                                                    ?>
                                                    <div class="form-group col-md-4">
                                                        <label>From Date:</label>
                                                        <?php

                                                        echo date('d F Y', strtotime($_REQUEST['from_date']));
                                                        ?>
                                                    </div>
                                                    <?php
                                                }

                                                if(isset($_REQUEST['to_date']) && $_REQUEST['to_date'] != '')
                                                {
                                                    ?>
                                                    <div class="form-group col-md-4">
                                                        <label>To Date:</label>
                                                        <?php

                                                        echo date('d F Y', strtotime($_REQUEST['to_date']));
                                                        ?>
                                                    </div>
                                                    <?php
                                                }
                                            ?>

                                        </div>
                            <?php
                                }
                            ?>

                                <div class="row mb-2">
                                    <div class="col-sm-4">
<!--                                        <a href="javascript:void(0);" class="btn btn-danger mb-2" data-toggle="modal" data-target="#custom-modal"><i class="mdi mdi-plus-circle mr-2"></i> Add Role</a>-->
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="text-sm-right">
<!--                                            <button type="button" class="btn btn-success mb-2 mr-1"><i class="mdi mdi-cog"></i></button>-->

                                            <a href="<?php echo base_url();?>portal_orders/bulk_media_upload" class="btn btn-danger mb-2"> Bulk Media Upload <i class="mdi mdi-file-upload-outline mr-2"></i></a>
                                            
                                            <a href="<?php echo base_url();?>portal_orders/form_view/add" class="btn btn-danger mb-2"> Add Order <i class="mdi mdi-plus-circle mr-2"></i></a>
                                            <button type="button" class="btn btn-success mb-2 mr-1" id="send_btn">Send To Production <i class="mdi mdi-arrow-right-bold-circle"></i></button>
                                            <button type="button" class="btn btn-danger mb-2 mr-1 import_btn" id="cad">CAD Import <i class="mdi mdi-file-excel"></i></button>
                                            <button type="button" class="btn btn-danger mb-2 mr-1 import_btn" id="render">Render Import <i class="mdi mdi-file-excel"></i></button>
                                            <button type="button" id="delete_btn" class="btn btn-danger mb-2 mr-1">Delete <i class="mdi mdi-trash-can-outline"></i></button>
                                        </div>
                                    </div><!-- end col-->
                                </div>

                                <div class="table-responsive" style="overflow-x:hidden;">
                                    <form action="<?php echo base_url();?>portal_orders/move_to_production" id="list_form" method="post">
                                        <input type="hidden" name="ids" id="ids" value="">
                                        <input type="hidden" name="flag" id="flag" value="">
                                      <button type="button" class="btn btn-sm btn-blue waves-effect waves-light float-right" data-toggle="modal" data-target="#filter-modal">
                                        <i class="mdi mdi-filter"></i> Filter
                                    </button>
  
                                    <table class="table table-hover table-bordered m-0 table-centered " id="tickets-table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th style="width: 20px;">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck0">
                                                    <label class="custom-control-label" for="customCheck0">&nbsp;</label>
                                                </div>
                                            </th>
                                            <!-- <th>#</th> -->
                                            <th>Order Number</th>
                                            <th>Client Design No</th>
                                            <th>Category</th>
                                            <th>Client</th>
                                            <th>Order Date</th>
                                            <th>Type</th>
                                            <th>Remark</th>
                                            <th>File Path</th>
                                        </tr>
                                        </thead>
                                        <tbody>                                       

                                        </tbody>
                                    </table>
                                    </form>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
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

<!-- Modal -->
<div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="myCenterModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>portal_orders/move_to_production" method="post" class="parsley-examples">
                    <input type="hidden" id="portal_order_id" name="portal_order_id" value="">
                    <div class="form-group">
                        <label for="role_name">Difficulty</label>
                        <select class="form-control" name="difficulty_id" id="difficulty_id" data-toggle="select2">
                            <option>Select</option>
                            <?php
                                $difficulty = $this->db->query('SELECT * FROM `difficulty`');
                                if($difficulty->num_rows() > 0)
                                {
                                    $difficulty = $difficulty->result_array();
                                    foreach($difficulty as $d)
                                    {
                                        echo '<option value="'.$d['id'].'">'.$d['difficulty_name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>


                    <div class="text-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- /.modal -->

<div class="modal fade" id="filter-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="modal_title">Filter</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="get" class="parsley-examples">
                    <div class="form-group">
                        <label for="order_no">Order No</label>
                        <input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order No" value="<?php echo isset($_REQUEST['order_no']) && !empty($_REQUEST['order_no']) ? $_REQUEST['order_no'] : '';?>">

                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" name="category" id="category" data-toggle="select2">
                            <option value="">Select</option>
                            <?php
                            $category = $this->db->query('SELECT distinct category FROM `production_order`');
                            if($category->num_rows() > 0)
                            {
                                $category = $category->result_array();
                                foreach($category as $c)
                                {
                                    $selected = isset($_REQUEST['category']) && !empty($_REQUEST['category']) ? $_REQUEST['category'] : '';
                                    echo '<option value="'.$c['category'].'" '.$selected.'>'.$c['category'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="client_name">Client</label>
                        <select class="form-control" name="client_name" id="client_name" data-toggle="select2">
                            <option value="">Select</option>
                            <?php
                            $client_name = $this->db->query('SELECT distinct client_name FROM `production_order`');
                            if($client_name->num_rows() > 0)
                            {
                                $client_name = $client_name->result_array();
                                foreach($client_name as $c)
                                {
                                    $selected = isset($_REQUEST['client_name']) && !empty($_REQUEST['client_name']) ? $_REQUEST['client_name'] : '';
                                    echo '<option value="'.$c['client_name'].'" '.$selected.'>'.$c['client_name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                  
                    <div class="form-group">
                        <label>From</label>
                        <input type="text" id="basic-datepicker" name="from_date" class="form-control" placeholder="From Date" value="<?php echo isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']) ? $_REQUEST['from_date'] : '';?>">
                    </div>

                    <div class="form-group">
                        <label>To</label>
                        <input type="text" id="basic-datepicker1" name="to_date" class="form-control" placeholder="To Date" value="<?php echo isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']) ? $_REQUEST['to_date'] : '';?>">
                    </div>


                    <div class="text-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Filter</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!-- Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Path Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>portal_orders/edit" method="post" class="parsley-examples">
                    <input type="hidden" id="current_order_id" name="current_order_id" value="">
                    
                        <div class="form-group">
                            <label for="file_path">File Path</label>
                            <input type="text" class="form-control" name="file_path" id="file_path" value="" placeholder="File Path" required>
                            <!-- <span id="file_path_span"></span> -->
                        </div>
                    <div class="text-right">
                        <!-- <button type="button" onclick="copyToClipboard('#file_path_span')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">Copy <span class="mdi mdi-content-copy"></span></button></td> -->
                        <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

 <div id="confirmModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          
          <div class="modal-body">
            <p>Are you sure to delete?</p>
            
          </div>
          <div class="modal-footer">
            <button type="button" id="confirm_delete" class="btn btn-success">Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
          </div>
          
        </div>

      </div>
    </div>



<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
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

<script>

    $('.import_btn').click(function(){
        
        
        window.location.href = '<?php echo base_url();?>portal_orders/import/'+$(this).attr('id');
        
       
    });

    var target_ids = [];
    function move_to_production(order_id)
    {
        $('#myCenterModalLabel').text('Move Order To Production');
        $("#custom-modal").modal("toggle");
        $("#portal_order_id").val(order_id);
        
    }

    function file_path(id)
    {
        $.ajax({
            url: '<?php echo base_url();?>portal_orders/view_order',
            type: 'POST',
            data:{'id':id},
            dataType:'json',
            async:false,
            success: function(result){
                $("#current_order_id").val(id);
                $('#file_path').val(result.file_path);
                // $('#file_path_span').text(result.file_path);                
                $("#edit-modal").modal("toggle");
            }
        });

        
        

    }

    $(document).ready(function() {

       
        $('#tickets-table').DataTable({
               
               processing: true,
               stateSave: true,
               serverSide: true,
               ajax: {
                   url: "<?php echo base_url(); ?>portal_orders/fetch_orders",
                   type: "POST",
                   data : {
                        "order_no" : "<?php echo isset($_REQUEST['order_no']) && !empty($_REQUEST['order_no']) ? $_REQUEST['order_no'] : ''?>",
                        "category" : "<?php echo isset($_REQUEST['category']) && !empty($_REQUEST['category']) ? $_REQUEST['category'] : ''?>",
                        "client_name" : "<?php echo isset($_REQUEST['client_name']) && !empty($_REQUEST['client_name']) ? $_REQUEST['client_name'] : ''?>",
                        "from_date" : "<?php echo isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']) ? $_REQUEST['from_date'] : ''?>",
                        "to_date" : "<?php echo isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']) ? $_REQUEST['to_date'] : ''?>",
                    }
               },
               paging: true,
               searching: true,
               ordering: true,
               //order: [[0, "asc"]],
               scrollX: true,
               scroller: true,
               columns: [{data: "check"}, {data: "order_number"}, {data: "client_design_no"}, {data: "category"}, {data: "client_name"}, {data: "order_date"}, {data: "type"}, {data: "remark"}, {data: "file_path"}],
               columnDefs: [
                  { "width": "20px", "targets": 0 },
                  { "width": "40px", "targets": 1 },
                  { "width": "150px", "targets": 2 },
                  { "width": "120px", "targets": 3 },
                  { "width": "120px", "targets": 4 },
                  { "width": "120px", "targets": 5 },
                  { "width": "100px", "targets": 6 },
                  { "width": "300px", "targets": 7 },
                  { "width": "100px", "targets": 8 }
                ],
               /** this will create datatable with above column data **/
           });


        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000); // <-- time in milliseconds

        
    });


    $(document).on('change', '.custom-control-input', function(){
        // var order_id = $(this).parents('td').next().find('input[type=hidden]').val();
        
        if($(this).attr('id') == 'customCheck0')
        {
            if($(this).is(":checked"))
            {
                // target_ids.push(order_id);
                $('.sub_checks').prop('checked', true);

            }
            else
            {
                // var index = target_ids.indexOf(order_id);
                // if (index > -1) {
                //     target_ids.splice(index, 1);
                // }
                $('.sub_checks').prop('checked', false);
            }
        }
        

    });

    $('#send_btn').click(function(){
        var selected = [];
        $('.sub_checks:checked').each(function() {
            selected.push($(this).val());
        });

        var strr = selected.join(',');
        
        if(strr == '')
        {
            alert('Please select order');
            return false;
        }
        else
        {
            $('#flag').val(1);
            $('#ids').val(strr);
            
            $('#list_form').submit();
        }

    });

    $('#delete_btn').click(function(){
        
        var selected = [];
        $('.sub_checks:checked').each(function() {
            selected.push($(this).val());
        });

        var strr = selected.join(',');
        
        if(strr == '')
        {
            alert('Please select order');
            return false;
        }
        else
        {
            $('#confirmModal').modal('toggle');
        }

    });

    
    $('#confirm_delete').click(function(){
        
        var selected = [];
        $('.sub_checks:checked').each(function() {
            selected.push($(this).val());
        });

        var strr = selected.join(',');
        
        $('#flag').val(2);
        $('#ids').val(strr);
        
        $('#list_form').submit();

    });
</script>
<script type="text/javascript">
   function copyToClipboard(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      alert('textt = '+$(element).text());
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
    }
</script>
<?php $this->load->view('common/change_password');?>
</body>
</html>