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

        #pageloader
        {
          background: rgba( 0, 0, 0, 0.8 );
          display: none;
          height: 100%;
          position: fixed;
          width: 100%;
          z-index: 9999;
        }

        #pageloader img
        {
          left: 50%;
          margin-left: -32px;
          margin-top: -32px;
          position: absolute;
          top: 50%;
        }
    </style>


</head>

<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": false}'>

    <div id="pageloader">
       <img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />
    </div>

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



                <div class="row">

                    <div class="col-12">
                        <div id="flash_msg" style="min-height:46px;">
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
                        <div class="card-box">
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
                                                if(isset($_REQUEST['client_name']) && $_REQUEST['client_name'] != '')
                                                {
                                                    ?>
                                                    <div class="form-group col-md-4">
                                                        <label for="role_name">Client:</label>
                                                        <?php echo $_REQUEST['client_name'];?>
                                                    </div>
                                                    <?php
                                                }
                                                if(isset($_REQUEST['category']) && $_REQUEST['category'] != '')
                                                {
                                                    ?>
                                                    <div class="form-group col-md-4">
                                                        <label for="role_name">Category:</label>
                                                        <?php echo $_REQUEST['category'];?>
                                                    </div>
                                                    <?php
                                                }
                                                if(isset($_REQUEST['status_name']) && $_REQUEST['status_name'] != '')
                                                {
                                                    ?>
                                                    <div class="form-group col-md-4">
                                                        <label for="role_name">Status:</label>
                                                        <?php echo $this->master_model->get_one_record('status', 'status_name', $_REQUEST['status_name']);?>
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

                                                if(isset($_REQUEST['order_date']) && $_REQUEST['order_date'] != '')
                                                {
                                                    ?>
                                                    <div class="form-group col-md-4">
                                                        <label>Order Date:</label>
                                                        <?php

                                                        echo date('d F Y', strtotime($_REQUEST['order_date']));
                                                        ?>
                                                    </div>
                                                    <?php
                                                }
                                            ?>

                                        </div>
                            <?php
                                }
                            ?>



                            <button type="button" class="btn btn-md btn-blue waves-effect waves-light float-right" data-toggle="modal" data-target="#filter-modal" style="margin:0 5px;">
                                <i class="mdi mdi-filter"></i> Filter
                            </button>

                            <?php
                                if(array_key_exists('Delete', $this->btn_permissions) && $this->btn_permissions['Delete']['view_perm'] == 1)
                                {
                                    
                            ?>
                                    <button type="button" id="delete_btn" class="btn btn-md btn-danger waves-effect waves-light float-right" disabled>
                                        <i class="mdi mdi-trash-can-outline"></i> Delete
                                    </button>
                            <?php
                                }
                            ?>

                            <button type="button" class="btn btn-md btn-success mr-1 waves-effect waves-light float-right" onclick="export_csv();">Export <i class="mdi mdi-file-excel"></i></button>

                            <form action="<?php echo base_url();?>production_orders/remove" id="list_form" method="post">
                                <input type="hidden" name="order_ids" id="order_ids" value="">
                            <table class="table table-hover table-bordered m-0 table-centered nowrap w-100" id="tickets-table">
                                <?php
                                    if(isset($_REQUEST['status_name']) && $_REQUEST['status_name'] != '')
                                    {
                                       $filterd_status = $this->master_model->get_one_record('status', 'status_name', $_REQUEST['status_name']); 
                                   } 


                                   $role_name = $this->db->query('SELECT role_name FROM role WHERE id = '.$this->session->userdata('user_role'))->result_array()[0]['role_name']; 

                                ?>
                                <thead>
                                <tr>
                                    <th>
                                        Chk
                                    </th>
                                    <th>
                                        Order Number
                                    </th>
                                    <th>
                                        Client Design No
                                    </th>
                                    <th>
                                        PO No
                                    </th>
                                    <th>Category</th>
                                    <th>Client</th>
                                    <th>Order Date</th>
                                    <th>Latest Activity</th>
                                    <th>Status</th>
                                    <?php
                                        // if($role_name == 'admin')
                                        // {
                                            ?>
                                                <th>File Path</th>
                                            <?php
                                        // }
                                    ?>
                                    
                                    <th>Difficulty</th>
                                    <th>Current Designer</th>
                                    <?php echo isset($filterd_status) && $filterd_status == 'Paused' ? '<th>Reason</th>' : '';?>
                                    <!-- <th>Password</th> -->
                                    <th class="hidden-sm">Action</th>
                                </tr>
                                </thead>

                                <tbody>                               

                                </tbody>
                            </table>
                            </form>
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
                <form action="<?php echo base_url();?>production_orders/assign" method="post" class="parsley-examples edit_form">
                    <input type="hidden" id="order_id" name="order_id" value="">
                    <div class="form-group">
                        <label for="user_id">Designer</label>
                        
                        <select class="form-control" name="user_id" id="user_id" data-toggle="select2" required>
                            <option value="">Select</option>
                            <?php
                                
                                $designer = $this->db->query('SELECT * FROM `users` WHERE user_role IN (SELECT associated FROM dropdown_options WHERE role_id = '.$this->session->userdata('user_role').' AND type = "CAD") AND active = 1'); 
                                                              
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
                        <label for="difficulty_id">Difficulty</label>
                        <select class="form-control" name="difficulty_id" id="difficulty_id" data-toggle="select2" required>
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

                    <!-- <div class="form-group">
                            <label for="assign_file_path">File Path</label>
                            <input type="text" class="form-control" name="assign_file_path" id="assign_file_path" value="" required>
                                
                        </div> -->

                    

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

<!-- Modal -->
<div class="modal fade" id="reject-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="modal_heading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>production_orders/reject" method="post" class="parsley-examples" id="change_status_form">
                    <input type="hidden" id="rej_order_id" name="rej_order_id" value="">
                    <input type="hidden" id="assigned_to" name="assigned_to" value="">
                    <input type="hidden" id="status_val" name="status_val" value="">


                    <div id="designer_difficulty_div" style="display:none;">
                        <div class="form-group">
                            <label for="modi_rep_user_id">Designer</label>
                            <select class="form-control" name="modi_rep_user_id" id="modi_rep_user_id" data-toggle="select2" required>
                                <option value="">Select</option>
                                <?php

                                    $designer = $this->db->query('SELECT * FROM `users` WHERE user_role IN (SELECT associated FROM dropdown_options WHERE role_id = '.$this->session->userdata('user_role').' AND type = "CAD") AND active = 1');
                                
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
                            <label for="modi_rep_difficulty_id">Difficulty</label>
                            <select class="form-control" name="modi_rep_difficulty_id" id="modi_rep_difficulty_id" data-toggle="select2" required>
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
                    </div>

                    <div>
                    <div class="form-group">
                        <label for="remark">Remark</label>
                        <input type="text" name="remark" id="remark" class="form-control" required placeholder="Enter remark"/>
                    </div>
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

<!-- Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Order Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>production_orders/edit" method="post" class="parsley-examples edit_form">
                    <input type="hidden" id="current_order_id" name="current_order_id" value="">
                    <input type="hidden" id="current_status" name="current_status" value="">
                    
                        <div class="form-group">
                            <label for="current_user_id">Designer</label>
                            <select class="form-control" name="current_user_id" id="current_user_id" data-toggle="select2" required>
                                <option value="">Select</option>
                                <?php
                                    
                                    $designer = $this->db->query('SELECT * FROM `users` WHERE user_role IN (SELECT associated FROM dropdown_options WHERE role_id = '.$this->session->userdata('user_role').' AND type = "CAD") AND active = 1');
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
                        
                        <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Modal -->
<div class="modal fade" id="complete-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="modal_heading">Complete Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>production_orders/complete" method="post" class="parsley-examples">
                    <input type="hidden" id="complete_order_id" name="complete_order_id" value="">
                    <input type="hidden" id="complete_assigned_to" name="complete_assigned_to" value="">

                    <div class="form-group">
                        <label for="complet_file_path">Complete File</label>
                        <input type="text" name="complet_file_path" id="complet_file_path" class="form-control" required placeholder="Enter Path"/>
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

<!-- Modal -->
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
                        <input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order No">

                    </div>
                    <div class="form-group">
                        <label>Order Date</label>
                        <input type="text" id="basic-datepicker2" name="order_date" class="form-control" placeholder="Order Date">
                    </div>
                    <div class="form-group">
                        <label for="po_no">PO No</label>
                        <input type="text" class="form-control" name="po_no" id="po_no" placeholder="PO No">

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
                                    echo '<option value="'.$c['category'].'">'.$c['category'].'</option>';
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
                                foreach($client_name as $cl)
                                {
                                    echo '<option value="'.$cl['client_name'].'">'.$cl['client_name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
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
                                    echo '<option value="'.$s['id'].'">'.$s['status_name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>From</label>
                        <input type="text" id="basic-datepicker" name="from_date" class="form-control" placeholder="From Date">
                    </div>

                    <div class="form-group">
                        <label>To</label>
                        <input type="text" id="basic-datepicker1" name="to_date" class="form-control" placeholder="To Date">
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
<div class="modal fade" id="pause-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="pauseModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>production_orders/pause_timer" method="post" class="parsley-examples">
                    <input type="hidden" id="pause_order_id" name="pause_order_id" value="">
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

<!-- /.modal -->

<!-- Modal -->
    <div id="confirmModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <form action="<?php echo base_url();?>production_orders/change_status" method="post">         
          <div class="modal-body">
            <p>Are you sure send STL request?</p>
            
                <input type="hidden" name="stl_order_id" id="stl_order_id">
                <input type="hidden" name="stl_user_id" id="stl_user_id">
                <input type="hidden" name="stl_status" id="stl_status">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
          </div>
          </form>
        </div>

      </div>
    </div>

    <div id="confirmModal2" class="modal fade" role="dialog">
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

    <!-- Modal -->
<div class="modal fade" id="cancel-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Cancel Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>production_orders/cancel_order" method="post" class="parsley-examples">
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

<div class="modal fade" id="rejected_info_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title">Reject</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">

                    <p>
                        <strong>Rejected By:</strong> <span id="rejected_by"></span>
                                
                    </p>
                    <p>
                        <strong>Remark:</strong> <span id="rejected_ramerk"></span>
                                
                    </p>  
 
            </div>
            <div class="modal-footer text-right">

                <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Close</button>
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



<div class="modal fade" id="send_to_manager_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class="modal-title" id="modal_heading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <form action="<?php echo base_url();?>production_orders/send_to_manager" method="post" class="parsley-examples" id="send_to_manager_form">
                    <input type="hidden" id="send_to_order_id" name="send_to_order_id" value="">
                    <input type="hidden" id="send_to_assigned_id" name="send_to_assigned_id" value="">                   

                    
                    <div class="form-group">
                        <label for="send_to_manager_id">Designer</label>
                        <select class="form-control" name="send_to_manager_id" id="send_to_manager_id" data-toggle="select2" required>
                            <option value="">Select</option>
                            <?php

                                $designer = $this->db->query('SELECT * FROM `users` WHERE user_role IN (SELECT id FROM role WHERE role_name = "CAD Manager")');
                            
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

                    <div class="form-group row">
                    <div class="col-lg-3" style="float:left;">
                            <label>Stage</label>
                            
                              <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                  <input type="radio" id="stage1" name="stage" class="custom-control-input" value="Modification" checked> Modification
                                </label>
                                <label class="btn btn-primary">
                                  <input type="radio" id="stage2" name="stage" class="custom-control-input" value="Repair"> Repair 
                                </label>
                              </div>
                          </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="send_to_manager_remark">Remark</label>
                        <input type="text" name="send_to_manager_remark" id="send_to_manager_remark" class="form-control" required placeholder="Enter remark"/>
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

        // $("#tickets-table").DataTable({language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",next:"<i class='mdi mdi-chevron-right'>"}},drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded")}, "bSort" : false})
    // $('#tickets-table').DataTable( {
    //     "scrollX": true
    // } );

    $('#tickets-table').DataTable({
               
               processing: true,
               serverSide: true,
               //stateSave: true,
               ajax: {
                   url: "<?php echo base_url(); ?>production_orders/fetch_orders",
                   type: "POST",
                   data : {
                        "order_no" : "<?php echo isset($_REQUEST['order_no']) && !empty($_REQUEST['order_no']) ? $_REQUEST['order_no'] : ''?>",
                        "category" : "<?php echo isset($_REQUEST['category']) && !empty($_REQUEST['category']) ? $_REQUEST['category'] : ''?>",
                        "client_name" : "<?php echo isset($_REQUEST['client_name']) && !empty($_REQUEST['client_name']) ? $_REQUEST['client_name'] : ''?>",
                        "from_date" : "<?php echo isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']) ? $_REQUEST['from_date'] : ''?>",
                        "to_date" : "<?php echo isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']) ? $_REQUEST['to_date'] : ''?>",
                        "order_date" : "<?php echo isset($_REQUEST['order_date']) && !empty($_REQUEST['order_date']) ? $_REQUEST['order_date'] : ''?>",
                        "status_name" : "<?php echo isset($_REQUEST['status_name']) && !empty($_REQUEST['status_name']) ? $_REQUEST['status_name'] : ''?>",
                        "po_no" : "<?php echo isset($_REQUEST['po_no']) && !empty($_REQUEST['po_no']) ? $_REQUEST['po_no'] : ''?>",
                        
                    }
               },
               paging: true,
               searching: true,
               ordering: true,
               //order: [[0, "asc"]],
               scrollX: true,
               scroller: true,
               columns: [{data: "check"}, {data: "order_number"}, {data: "client_design_no"}, {data: "po_no"}, {data: "category"}, {data: "client_name"}, {data: "order_date"}, {data: "created_date"}, {data: "status"}, {data: "file_path"}, {data: "difficulty_name"}, {data: "designer"}, {data: "action"}]
               /** this will create datatable with above column data **/
           });

    });
</script>

<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>
<script>

    var target_ids = [];

    $(document).ready(function(){
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 4000); // <-- time in milliseconds
    });

    function pause_timer(order_id)
    {
        $("#action_buttons_modal").modal("toggle");
        $('#pauseModalLabel').text('Pause');
        $("#pause-modal").modal("toggle");
        $("#pause_order_id").val(order_id);
    }

    function view_order(order_id, status)
    {
        $("#action_buttons_modal").modal("toggle");
        var role_name = '<?php echo $role_name;?>';
        $.ajax({
            url: '<?php echo base_url();?>production_orders/view_order',
            type: 'POST',
            data:{'order_id':order_id},
            dataType:'json',
            async:false,
            success: function(result){
                 
                $('#current_user_id').val(result.assigned_to).trigger('change');
                $('#current_difficulty_id').val(result.difficulty_id).trigger('change');
                $('#file_path').val(result.file_path);
                $('#view_complet_file_path').val(result.complet_file_path);

                

                if(role_name != 'Cad Designer')
                {
                    $('#current_user_id').prop('disabled', false);
                    $('#current_user_id').val(result.assigned_to).trigger('change');
                    $('#current_difficulty_id').prop('disabled', false);
                    $('#current_difficulty_id').val(result.difficulty_id).trigger('change');
                    $('#file_path').prop('readonly', false);
                    $('#view_complet_file_path').prop('readonly', false);
                }
                


            }
        });
        $("#edit-modal").modal("toggle");
        $("#current_order_id").val(order_id);
        $("#current_status").val(status);

    }

    function assign_order(order_id, flag)
    {
        $("#action_buttons_modal").modal("toggle");
        if(flag == 'A')
        {
            $('#myCenterModalLabel').text('Assign');
            $("#custom-modal").modal("toggle");
            $("#order_id").val(order_id);
        }
        else
        {
            $.ajax({
                    url: '<?php echo base_url();?>production_orders/de_allocate',
                    type: 'POST',
                    data:{'order_id':order_id},
                    dataType:'json',
                    success: function(result){

                        $('#flash_msg').html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+result.message+'</div>');

                        setTimeout(function() {
                            $('.flash_msg').fadeOut('slow');
                            location.reload();
                        }, 4000); // <-- time in milliseconds

                    }
                });
        }
        
    }

    function qc_reject(order_id, assigned_to)
    {
        $("#action_buttons_modal").modal("toggle");
        $('#modal_heading').text('Reject');
        $("#reject-modal").modal("toggle");
        $('#designer_difficulty_div').css('display', 'none');
        $('#modi_rep_user_id').removeAttr('required');
        $('#modi_rep_difficulty_id').removeAttr('required');
        $('#change_status_form').attr('action', '<?php echo base_url();?>production_orders/reject');
        $("#rej_order_id").val(order_id);
        $("#assigned_to").val(assigned_to);
    }

    function complete(order_id, assigned_to)
    {
        $("#action_buttons_modal").modal("toggle");
        $("#complete-modal").modal("toggle");
        $("#complete_order_id").val(order_id);
        $("#complete_assigned_to").val(assigned_to);
    }

    function qc_accept(order_id, user_id)
    {
        $("#action_buttons_modal").modal("toggle");
        $.ajax({
            url: '<?php echo base_url();?>production_orders/qc_accept',
            type: 'POST',
            data:{'order_id':order_id, 'user_id':user_id},
            dataType:'json',
            success: function(result){

                $('#flash_msg').html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+result.message+'</div>');

                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                    location.reload();
                }, 4000); // <-- time in milliseconds

            }
        });
    }

    function stl_reject(order_id, assigned_to)
    {
        $("#action_buttons_modal").modal("toggle");
        $('#modal_heading').text('STL Reject');
        $("#reject-modal").modal("toggle");
        $('#designer_difficulty_div').css('display', 'none');
        $('#modi_rep_user_id').removeAttr('required');
        $('#modi_rep_difficulty_id').removeAttr('required');
        $('#change_status_form').attr('action', '<?php echo base_url();?>production_orders/stl_reject');
        $("#rej_order_id").val(order_id);
        $("#assigned_to").val(assigned_to);
    }

    
    function cancel_order(order_id, assigned_to)
    {
        $("#action_buttons_modal").modal("toggle");
        $("#cancel-modal").modal("toggle");
        $("#cancel_order_id").val(order_id);
        $("#cancel_assigned_to").val(assigned_to);
    }

    function stl_accept(order_id, user_id)
    {
        $("#action_buttons_modal").modal("toggle");
        $.ajax({
            url: '<?php echo base_url();?>production_orders/stl_accept',
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

    function client_fb(order_id, user_id, status)
    {
        $("#action_buttons_modal").modal("toggle");
        $('#modal_heading').text(status);
        $("#reject-modal").modal("toggle");
        $('#designer_difficulty_div').css('display', 'block');
        $('#remark').removeAttr('required');
        $('#change_status_form').attr('action', '<?php echo base_url();?>production_orders/client_fb');
        $("#rej_order_id").val(order_id);
        $("#assigned_to").val(user_id);
        $('#status_val').val(status);
    }

    
    function change_status(order_id, user_id, status)
    {
        $("#action_buttons_modal").modal("toggle");
        $('#confirmModal').modal('toggle');
        $('#stl_order_id').val(order_id);
        $('#stl_user_id').val(user_id);
        $('#stl_status').val(status);
    }

    function pdw_sent(order_id, user_id, status)
    {
        $("#action_buttons_modal").modal("toggle");
        $.ajax({
            url: '<?php echo base_url();?>production_orders/pdw_sent',
            type: 'POST',
            data:{'order_id':order_id, 'user_id':user_id, 'status':status},
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

    function move_to_render(order_id)
    {
        $("#action_buttons_modal").modal("toggle");
        $.ajax({
            url: '<?php echo base_url();?>production_orders/move_to_render',
            type: 'POST',
            data:{'order_id':order_id},
            dataType:'json',
            async:false,
            beforeSend: function() { 

                $("#pageloader").show();

            },
        complete: function() { setTimeout(function() {
                    $("#pageloader").hide(); 
                    
                }, 4000); },
            success: function(result){
                console.log(result);
                $('#flash_msg').html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                    '<span aria-hidden="true">×</span>'+
                                '</button>Moved To Render Successfully!'+                                        
                                    '</div>');
                // return;

              setTimeout(function() {
                    $('.alert').fadeOut('slow');
                    location.reload();
                }, 4000); // <-- time in milliseconds
            }
        });
    }


    $('#clear_btn').click(function(){
        window.location.href = '<?php echo base_url();?>production_orders';
    });

    $(document).on('change', '.chk_order', function(){

        var order_id = $(this).val();
        
        if($(this).is(":checked"))
        {
            target_ids.push(order_id);

            total_count();

        }
        else
        {
            var index = target_ids.indexOf(order_id);
            if (index > -1) {
                target_ids.splice(index, 1);
            }
            total_count();
        }

    });

    function total_count()
    {
        if(target_ids.length > 0)
        {
            $('#delete_btn').prop('disabled', false);
        }
        else
        {
            $('#delete_btn').prop('disabled', true);
        }
    }

    $('#delete_btn').click(function(){
        $('#confirmModal2').modal('toggle');

    });


    $('#confirm_delete').click(function(){
        var strr = target_ids.join(',');
        $('#order_ids').val(strr);
        $('#list_form').submit();

    });

    function check_rejected(reason, rejected_by)
    {

        $('#rejected_info_modal').modal('toggle');
        $('#rejected_ramerk').text(reason);
        $('#rejected_by').text(rejected_by);
    }

    function delivered(order_id)
    {
        $("#action_buttons_modal").modal("toggle");
        $.ajax({
            url: '<?php echo base_url();?>production_orders/delivered',
            type: 'POST',
            data:{'order_id':order_id},
            dataType:'json',
            async:false,
            beforeSend: function() { 

                $("#pageloader").show();

            },
            complete: function() { setTimeout(function() {
                    $("#pageloader").hide(); 
                    
                }, 4000); },
            success: function(result){

                $('#flash_msg').html('<div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+result.message+'</div>');

                setTimeout(function() {
                    location.reload()
                }, 8000); // <-- time in milliseconds
                 
            }
        });
    }
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
</script>

<script type="text/javascript">
    $(document).ready(function(){
       
        
        $(".edit_form").on("submit", function(){
            $("#pageloader").fadeIn();
        });//submit
        
    });


    function export_csv()
    {
       
       var order_no = '<?php echo isset($_REQUEST["order_no"]) ? $_REQUEST["order_no"] : "";?>'; 
       var po_no = '<?php echo isset($_REQUEST["po_no"]) ? $_REQUEST["po_no"] : "";?>'; 
       var category = '<?php echo isset($_REQUEST["category"]) ? $_REQUEST["category"] : "";?>';
       var client_name = '<?php echo isset($_REQUEST["client_name"]) ? $_REQUEST["client_name"] : "";?>';
       var status_name = '<?php echo isset($_REQUEST["status_name"]) ? $_REQUEST["status_name"] : "";?>';
       var from_date = '<?php echo isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : "";?>'; 
       var to_date = '<?php echo isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : "";?>'; 
       var order_date = '<?php echo isset($_REQUEST["order_date"]) ? $_REQUEST["order_date"] : "";?>';
       

        window.open(
                "<?php echo base_url()?>production_orders/export_csv?order_no="+order_no+"&category="+category+"&status_name="+status_name+"&from_date="+from_date+"&to_date="+to_date+"&po_no="+po_no+"&client_name="+client_name+"&order_date="+order_date,
                "_self" // <- This is what makes it open in a new window.
            );
            return false;
    }

    function action_buttons(order_id)
    {
        
        $.ajax({
            url: '<?php echo base_url();?>production_orders/action_buttons',
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

    function send_to_manager(order_id, assigned_to)
    {
        $("#action_buttons_modal").modal("toggle");
        $("#send_to_manager_modal").modal("toggle");
        $('#send_to_order_id').val(order_id);
        $('#send_to_assigned_id').val(assigned_to);
    }
  </script>
<?php $this->load->view('common/change_password');?>
</body>
</html>