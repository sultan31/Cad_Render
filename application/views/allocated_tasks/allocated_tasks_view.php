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
    <style type="text/css">
        .highlight_tr{background-color:#ffefef;}
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
                            <h4 class="page-title"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?></h4>
                        </div>


                    </div>
                </div>
                <!-- end page title -->

                <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div id="flash_msg">
                            <?php
                                if($this->session->flashdata('message'))
                                {
                                    ?>
                                        <div class="alert alert-<?php echo $this->session->flashdata('class');?> alert-dismissible bg-<?php echo $this->session->flashdata('class');?> text-white border-0 fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <?php echo $this->session->flashdata('message');?></div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="card-box">


                            <table class="table table-hover table-bordered m-0 table-centered dataTable no-footer" id="tickets-table">
                                <thead>
                                <tr>
                                     
                                    <th>#</th>
                                    <th>
                                        Order Number
                                    </th>
                                    <th>Category</th>
                                    <th>Start Date</th>
                                    <th>Type</th>
                                    <th>Latest Activity</th>
                                    <th style="width: 50px;">Remark</th>
                                    <th style="width: 50px;">Difficulty</th>
                                    <th style="width: 50px;">Status</th>
                                    <th>File Path</th>
                                    <th class="hidden-sm">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                

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

<!-- Modal -->
<div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="myCenterModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>allocated_tasks/pause_timer" method="post" class="parsley-examples">
                    <input type="hidden" id="order_id" name="order_id" value="">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="Password" required>

                    </div>

                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Reason" required>

                    </div>


                    <div class="text-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="reject_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="myCenterModalLabel1">Reject Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>allocated_tasks/reject_order" method="post" class="parsley-examples">
                    <input type="hidden" id="reject_order_id" name="reject_order_id" value="">
                    

                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Reason" required>

                    </div>


                    <div class="text-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Order Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>production_orders/edit" method="post" class="parsley-examples">
                    <input type="hidden" id="current_order_id" name="current_order_id" value="">
                    <input type="hidden" id="current_status" name="current_status" value="">
                    
                        <div class="form-group">
                            <label for="current_user_id">Designer</label>
                            <select class="form-control" name="current_user_id" id="current_user_id" data-toggle="select2" required>
                                <option value="">Select</option>
                                <?php
                                    
                                    $designer = $this->db->query('SELECT * FROM `users` WHERE user_role IN (SELECT id FROM role WHERE role_name = "Cad Designer") AND active = 1');
                                    if($designer->num_rows() > 0)
                                    {
                                        $designer = $designer->result_array();
                                        foreach($designer as $d)
                                        {
                                            echo '<option value="'.$d['id'].'">'.$d['full_name'].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="current_difficulty_id">Difficulty</label>
                            <select class="form-control" name="current_difficulty_id" id="current_difficulty_id" data-toggle="select2" required>
                                <option value="">Select</option>
                                <?php
                                $difficulty = $this->db->query('SELECT * FROM `difficulty` ORDER BY position ASC');
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

                        <div class="form-group">
                            <label for="file_path">File Path</label>
                            <input type="text" class="form-control" name="file_path" id="file_path" value="">
                                
                        </div>

                        <div class="form-group">
                            <label for="view_complet_file_path">Complete Path</label>
                            <input type="text" class="form-control" name="view_complet_file_path" id="view_complet_file_path" value="">
                                
                        </div>
                    

                    <div class="text-right">
                        
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Modal -->
<div class="modal fade" id="cancel-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Cancel Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>allocated_tasks/cancel_order" method="post" class="parsley-examples">
                    <input type="hidden" id="cancel_order_id" name="cancel_order_id" value="">
                    <input type="hidden" id="cancel_assigned_to" name="cancel_assigned_to" value="">
                    
                    <div class="form-group">
                        <label for="cancecl_remark">Remark</label>
                        <input type="text" name="cancecl_remark" id="cancecl_remark" class="form-control" required placeholder="Enter remark"/>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="action_buttons_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Action Button</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                
                    
                   
                    <div class="form-group" id="buttons_div">
                        
                    </div>
                    
                
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


<!-- Tickets js -->
<!-- <script src="<?php //echo base_url();?>assets/js/pages/tickets.js"></script> -->

<script>
    $(document).ready(function(){

        // $("#tickets-table").DataTable({language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}, "bSort" : false})
    $('#tickets-table').DataTable({
               
               processing: true,
               serverSide: true,
               //stateSave: true,
               ajax: {
                   url: "<?php echo base_url(); ?>allocated_tasks/fetch_orders",
                   type: "POST",
                   data : {
                        
                        "status_name" : "<?php echo isset($_REQUEST['status_name']) && !empty($_REQUEST['status_name']) ? $_REQUEST['status_name'] : ''?>"
                        
                    }
               },
               paging: true,
               searching: true,
               ordering: true,
               //order: [[0, "asc"]],
               scrollX: true,
               scroller: true,
               columns: [{data: "check"}, {data: "order_number"}, {data: "category"}, {data: "start_date"}, {data: "type"}, {data: "latest_activity"}, {data: "remark"}, {data: "difficulty_name"}, {data: "status"}, {data: "file_path"}, {data: "action"}]
               /** this will create datatable with above column data **/
           });
    });
</script>


<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>
<script>
    $(document).ready(function(){
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 4000);
    });

    function start_timer(order_id, user_id)
    {
    	$("#action_buttons_modal").modal("toggle");
        $.ajax({
            url: '<?php echo base_url();?>allocated_tasks/start_timer',
            type: 'POST',
            data:{'order_id':order_id, 'user_id':user_id},
            dataType:'json',
            success: function(result){

                $('#flash_msg').html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+result.message+'</div>');

                setTimeout(function() {
                    $('.alert').fadeOut('slow');

                }, 4000); // <-- time in milliseconds

                location.reload();

            }
        });
    }

    
    function stl_process(order_id, user_id)
    {
    	$("#action_buttons_modal").modal("toggle");
        $.ajax({
            url: '<?php echo base_url();?>allocated_tasks/stl_process',
            type: 'POST',
            data:{'order_id':order_id, 'user_id':user_id},
            dataType:'json',
            success: function(result){

                $('#flash_msg').html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+result.message+'</div>');

                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                }, 4000); // <-- time in milliseconds

                location.reload();

            }
        });
    }

    
    function stl(order_id, user_id, type)
    {
    	$("#action_buttons_modal").modal("toggle");
        $.ajax({
            url: '<?php echo base_url();?>allocated_tasks/stl',
            type: 'POST',
            data:{'order_id':order_id, 'user_id':user_id, 'type':type},
            dataType:'json',
            success: function(result){

                $('#flash_msg').html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+result.message+'</div>');

                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                }, 4000); // <-- time in milliseconds

                location.reload();

            }
        });
    }


    function pause_timer(order_id)
    {
    	$("#action_buttons_modal").modal("toggle");
        $('#myCenterModalLabel').text('Pause');
        $("#custom-modal").modal("toggle");
        $("#order_id").val(order_id);
    }

    function qc_check(order_id, user_id)
    {
    	$("#action_buttons_modal").modal("toggle");
        $.ajax({
            url: '<?php echo base_url();?>allocated_tasks/qc_check',
            type: 'POST',
            data:{'order_id':order_id, 'user_id':user_id},
            dataType:'json',
            success: function(result){

                $('#flash_msg').html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+result.message+'</div>');

                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                }, 4000); // <-- time in milliseconds
                location.reload();
            }
        });
    }

    
    function reject_order(order_id)
    {
    	$("#action_buttons_modal").modal("toggle");
        $('#reject_modal').modal('toggle');
        $('#reject_order_id').val(order_id);
    }

    function change_status(order_id, user_id, status)
    {
    	$("#action_buttons_modal").modal("toggle");
        $.ajax({
            url: '<?php echo base_url();?>allocated_tasks/change_status',
            type: 'POST',
            data:{'order_id':order_id, 'user_id':user_id, 'status': status},
            dataType:'json',
            success: function(result){

                $('#flash_msg').html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+result.message+'</div>');

                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                }, 4000); // <-- time in milliseconds
                location.reload();

            }
        });
    }

    function view_order(order_id, status)
    {
        $("#action_buttons_modal").modal("toggle");
        $.ajax({
            url: '<?php echo base_url();?>production_orders/view_order',
            type: 'POST',
            data:{'order_id':order_id},
            dataType:'json',
            async:false,
            success: function(result){
                
                $('#current_user_id').val(result.assigned_to).trigger('change');
                $('#current_user_id').prop('disabled', false);
                $('#current_difficulty_id').val(result.difficulty_id).trigger('change');
                $('#current_difficulty_id').prop('disabled', false);
                
                $('#file_path').prop('readonly', false);
                $('#view_complet_file_path').prop('readonly', false);
                
            }
        });
        $("#edit-modal").modal("toggle");
        $("#current_order_id").val(order_id);
        $("#current_status").val(status);

    }

    function cancel_order(order_id, assigned_to)
    {
    	$("#action_buttons_modal").modal("toggle");
        $("#cancel-modal").modal("toggle");
        $("#cancel_order_id").val(order_id);
        $("#cancel_assigned_to").val(assigned_to);
    }



    $('#clear_btn').click(function(){
        window.location.href = '<?php echo base_url();?>allocated_tasks';
    });
</script>

<script type="text/javascript">
   function copyToClipboard(element) {

      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($('#'+element).text()).select();
      document.execCommand("copy");
      $temp.remove();
      $('#flash_msg').html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                    '<span aria-hidden="true">×</span>'+
                                '</button>Copied!'+                                        
                                    '</div>');

      setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 4000); // <-- time in milliseconds
    }


    function action_buttons(order_id)
    {
        
        $.ajax({
            url: '<?php echo base_url();?>allocated_tasks/action_buttons',
            type: 'POST',
            data:{'order_id':order_id},
            dataType:'json',
            async:false,            
            success: function(result){
                //console.log(result);
                
                $("#action_buttons_modal").modal("toggle");
                $('#buttons_div').html(result.html);
            }
        });
    }
</script>
<?php $this->load->view('common/change_password');?>

</body>
</html>