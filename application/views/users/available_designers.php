<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Available Deigners</title>
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

                                    
                                    <li class="breadcrumb-item active">Available Deigners</li>
                                </ol>
                            </div> -->
                            <h4 class="page-title">Available Deigners</h4>
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
                                <!-- <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <a href="<?php echo base_url();?>users/form_view/add" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle mr-2"></i> Add User</a>
                                    </div>
                                    <div class="col-sm-8">
                                        
                                    </div>
                                </div> -->

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="products-datatable">
                                        <thead class="thead-light">
                                        <tr>
                                            <!-- <th style="width: 20px;">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck0">
                                                    <label class="custom-control-label" for="customCheck0">&nbsp;</label>
                                                </div>
                                            </th> -->
                                            <th style="width: 20px;">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile No</th>
                                            <!-- <th style="width: 75px;">Action</th> -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $res = $this->db->query('SELECT * FROM last_login WHERE user_role = (SELECT id FROM role WHERE role_name = "designer") AND last_login_date = "'.date('Y-m-d').'"');

                                        if($res->num_rows() > 0)
                                        {
                                            $i = 0;
                                            $row = $res->result_array();
                                            foreach($row as $r)
                                            {
                                                $i++;
                                                ?>
                                                <tr id="tr_<?php echo $r['id'];?>">
                                                    <!-- <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck<?php echo $i;?>">
                                                            <label class="custom-control-label" for="customCheck<?php echo $i;?>">ABC</label>
                                                        </div>
                                                    </td> -->
                                                     <td><?php echo $i; ?></td>
                                                    <td><?php echo ucwords($this->master_model->get_one_record('users', 'full_name', $r['user_id'])); ?></td>
                                                    <td><?php echo ucwords($this->master_model->get_one_record('users', 'email_id', $r['user_id'])); ?></td>
                                                    <td><?php echo ucwords($this->master_model->get_one_record('users', 'mobile_no', $r['user_id'])); ?></td>
                                                    
                                                    <!-- <td>
                                                        <a href="<?php echo base_url().'users/form_view/edit/'.$r['id'];?>" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                        <a href="javascript:void(0);" class="action-icon sa-warning" data-id="<?php echo $r['id']; ?>"> <i class="mdi mdi-delete"></i></a>

                                                    </td> -->
                                                </tr>
                                                <?php
                                            }
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

<!-- Vendor js -->
<?php $this->load->view('common/footer');?>

<!-- Plugin js-->
<script src="<?php echo base_url();?>assets/libs/parsleyjs/parsley.min.js"></script>

<!-- Validation init js-->
<script src="<?php echo base_url();?>assets/js/pages/form-validation.init.js"></script>

<script src="<?php echo base_url();?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>

<script>


    $(document).ready(function() {
        
        "use strict";
        $("#products-datatable").DataTable({
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                },
                info: "Showing customers _START_ to _END_ of _TOTAL_",
                lengthMenu: 'Display <select class=\'custom-select custom-select-sm ml-1 mr-1\'><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> entries'
            },
            pageLength: 10,
            columns: [
            // {
            //     orderable: !1,
            //     render: function(e, o, l, t) {
            //         return "display" === o && (e = '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input dt-checkboxes"><label class="custom-control-label">&nbsp;</label></div>'), e
            //     },
            //     checkboxes: {
            //         selectRow: !0,
            //         selectAllRender: '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input dt-checkboxes"><label class="custom-control-label">&nbsp;</label></div>'
            //     }
            // }, 
            {
                orderable: !0,
                width: '27px'
            }, 
            {
                orderable: !0
            }, {
                orderable: !0
            }, {
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

    
</script>
</body>
</html>