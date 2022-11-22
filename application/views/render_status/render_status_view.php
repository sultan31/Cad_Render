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
    <link href="<?php echo base_url();?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />


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
                            <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
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
                                
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <a href="javascript:void(0);" onclick="open_modal();" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle mr-2"></i> Add Render Status</a>
                                    </div>
                                    
                                </div>

                                <div class="table-responsive">
                                    
                                    <table class="table table-bordered table-hover" id="products-datatable">
                                        <thead class="thead-light">
                                        <tr>
                                            <th style="width: 20px;">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck0">
                                                    <label class="custom-control-label" for="customCheck0">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Label</th>
                                            <th>Department</th>
                                            <th>Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                         $this->db->select('*');
                                        $this->db->from('ms_render_status');
                                        
                                        $i = 0;
                                        $this->db->order_by('id', 'DESC');
                                        $res = $this->db->get();
                                        // pre($this->db->last_query());
                                        $row = $res->result_array();
                                        foreach($row as $r)
                                        {
                                            $i++;
                                            ?>
                                            <tr id="tr_<?php echo $r['id'];?>">
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck<?php echo $i;?>" value="<?php echo $r['id'];?>">
                                                        <label class="custom-control-label" for="customCheck<?php echo $i;?>">ABC</label>
                                                    </div>
                                                </td>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $r['name']; ?></td>
                                                <td><?php echo $r['label']; ?></td>
                                                <td><?php echo $this->master_model->get_one_record('department', 'dept_name', $r['department_id']); ?></td>
                                                <td>
                                                    
                                                    <button type="button" onclick="edit_record(<?php echo $r['id']; ?>);" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;"><span class="mdi mdi-pencil"></span></button>
                                                    <button class="demo-delete-row btn btn-danger btn-xs btn-icon sa-warning" data-id="<?php echo $r['id']; ?>"><i class="fa fa-times"></i></button>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                        ?>

                                        </tbody>
                                    </table>
                                    
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
                <form action="<?php echo base_url();?>render_status/form_action" method="post" class="parsley-examples" id="myform">
                    <input type="hidden" id="status_id" name="status_id" value="">
                    <div class="form-group">
                        <label for="department_id">Department</label>
                        <select class="form-control" name="department_id" id="department_id" data-toggle="select2" required="">
                            <option value="">Select</option>
                            <?php
                                $department = $this->db->query('SELECT * FROM `department`');
                                if($department->num_rows() > 0)
                                {
                                    $department = $department->result_array();
                                    foreach($department as $d)
                                    {
                                        echo '<option value="'.$d['id'].'">'.$d['dept_name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input data-parsley-pattern="^[a-zA-Z ]+$" type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                    </div>

                    <div class="form-group">
                        <label for="label">Label</label>
                        <input data-parsley-pattern="^[a-zA-Z ]+$" type="text" class="form-control" id="label" name="label" placeholder="Enter Label" required>
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
<script src="<?php echo base_url();?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>

<script>

    function open_modal()
    {
        $("#custom-modal").modal("toggle");
        $('#myform').parsley().reset();
        $('#status_id').val('');
        $('#department_id').val('').trigger('change');

    }

    function edit_record(id) {
        $.ajax({
            url: '<?php echo base_url();?>render_status/fetch_record?id='+id,
            type: 'GET',
            dataType:'json',
            success: function(result){

                $("#status_id").val(result.data.id);
                $("#name").val(result.data.name);
                $("#label").val(result.data.label);
                $('#department_id').val(result.data.department_id).trigger('change');
                $('#myCenterModalLabel').text('Edit Status');
                $('#myform').parsley().reset();
                $("#custom-modal").modal("toggle");
            }
        });
    }

   
    $(document).ready(function() {


        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000); // <-- time in milliseconds

        "use strict";
        $("#products-datatable").DataTable({
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                },
                info: "Showing entries _START_ to _END_ of _TOTAL_",
                lengthMenu: 'Display <select class=\'custom-select custom-select-sm ml-1 mr-1\'><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> entries'
            },
            pageLength: 10,
            columns: [
                {
                orderable: !1,
                render: function(e, o, l, t) {
                    return "display" === o && (e = '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input dt-checkboxes" id="chk_all"><label class="custom-control-label">&nbsp;</label></div>'), e
                },
                checkboxes: {
                    selectRow: !0,
                    selectAllRender: '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input dt-checkboxes"><label class="custom-control-label">&nbsp;</label></div>'
                }
            }
            , {
                orderable: !0
            },{
                orderable: !0
            },{
                orderable: !0
            }, {
                orderable: !0
            },{
                orderable: !0
            }],
            select: {
                style: "multi"
            },
            order: [
                [0, "asc"]
            ],
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            }
        })
    });

    $(".sa-warning").click(function()
    {
        var id = $(this).attr('data-id');
        Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete it!"}).then(function(t)
        {
            if(t.value == true)
            {
                $.ajax({
                    url: '<?php echo base_url();?>render_status/remove',
                    type: 'POST',
                    data:{'id':id},
                    dataType:'json',
                    success: function(result){
                        var table = $("#products-datatable").DataTable();
                        Swal.fire("Deleted!","Status has been deleted.","success");
                        table.row('#tr_'+id).remove().draw( false );
                    }
                });
            }
            else
            {

            }

        });
    });

</script>
</body>
</html>