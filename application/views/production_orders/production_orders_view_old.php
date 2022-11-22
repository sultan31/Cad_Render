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
                        <div id="flash_msg">
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
                                <?php
                                // pre($_REQUEST);
                                $today = date('Y-m-d');
                                $conditions = [];
                                $completed_status = $this->db->query('SELECT id FROM status WHERE status_name = "Completed"')->result_array()[0]['id'];
                               
                                
                                    $this->db->select('*');
                                    $this->db->from('production_order');
                                    if(isset($_REQUEST['status_name']) && $_REQUEST['status_name'] != '')
                                    {
                                        $this->db->where('status', $_REQUEST['status_name']);
                                    }
                                    // if(isset($_REQUEST['status_name']) && $_REQUEST['status_name'] == '')
                                    // {
                                    //     $this->db->where("status !=", $completed_status);
                                    //     $this->db->where('deadline < ', $today);
                                    // }
                                    if(isset($_REQUEST['order_no']) && $_REQUEST['order_no'] != '')
                                    {
                                        $this->db->where('order_number', $_REQUEST['order_no']);
                                    }
                                    if(isset($_REQUEST['po_no']) && $_REQUEST['po_no'] != '')
                                    {
                                        $this->db->where('po_no', $_REQUEST['po_no']);
                                    }
                                    if(isset($_REQUEST['client_name']) && $_REQUEST['client_name'] != '')
                                    {
                                        $this->db->where('client_name', $_REQUEST['client_name']);
                                    }
                                    if(isset($_REQUEST['category']) && $_REQUEST['category'] != '')
                                    {
                                        $this->db->where('category', $_REQUEST['category']);
                                    }
                                    
                                    if(isset($_REQUEST['from_date']) && $_REQUEST['from_date'] != '')
                                    {
                                        $this->db->where('DATE_FORMAT(updated_date, "%Y-%m-%d") >= ', $_REQUEST['from_date']);
                                        
                                    }
                                    if(isset($_REQUEST['to_date']) && $_REQUEST['to_date'] != '')
                                    {
                                        $this->db->where('DATE_FORMAT(updated_date, "%Y-%m-%d") <= ', $_REQUEST['to_date']);
                                    }
                                    if(isset($_REQUEST['order_date']) && $_REQUEST['order_date'] != '')
                                    {
                                        $this->db->where('DATE_FORMAT(order_date, "%Y-%m-%d") = ', $_REQUEST['order_date']);
                                        
                                    }
                                    $this->db->order_by('updated_date', 'DESC');
                                    $this->db->where('delete_flag', 0);
                                    $res = $this->db->get();
                                
                                
                                pre($this->db->last_query());
                                $i = 1;
                                $row = $res->result_array();
                                foreach($row as $r)
                                {
                                    $highlight_tr = '';
                                    $actual_time_query = $this->db->query('SELECT actual_time FROM `start_stop_action` WHERE `job_id` = '.$r['id'].' ORDER BY `id` DESC LIMIT 1');
                                    // pre($this->db->last_query());

                                    if($actual_time_query->num_rows() > 0)
                                    {

                                        $actual_time = $actual_time_query->result_array()[0]['actual_time'];
                                        $actual_time_in_minutes = isset($actual_time) ? floor(($actual_time / 60) % 60) : '';

                                        $actual_time_query = $this->db->query('SELECT total_time FROM `difficulty` WHERE id = '.$r['difficulty_id']);
                                        if($actual_time_query->num_rows() > 0)
                                        {
                                            $total_time = $actual_time_query->result_array()[0]['total_time'];
                                        }
                                        else
                                        {
                                            $total_time = 0;
                                        }

                                        $highlight_tr = isset($actual_time_in_minutes) && !empty($actual_time_in_minutes) && isset($total_time) && $actual_time_in_minutes > $total_time ? 'highlight_tr' : '';
                                    }

                                    
                                    $status_data = $this->db->get_where('status', ['id' =>  $r['status']])->result_array();
                                    $status_name = $status_data[0]['status_name'];
                                    $color = $status_data[0]['color'];
                                    $i++;
                                    ?>
                                    <tr id="order_id_"<?php echo $r['id'];?> class="<?php echo $highlight_tr;?>">

                                        
                                        <td><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input dt-checkboxes chk_order" id="customCheck<?php echo $i;?>" value="<?php echo $r['id'];?>"><label class="custom-control-label">&nbsp;</label></div></td>
                                        
                                        <td style="font-weight:bold;"><?php echo '<a target="_blank" href="'.base_url().'production_orders/form_view/prod/'.$r['id'].'">'.$r['order_number'].'</a>'; ?></td>
                                        <td><?php echo $r['client_design_no']; ?></td>
                                        <td><?php echo $r['po_no']; ?></td>
                                        <td><?php echo $r['category']; ?></td>
                                        <td><?php echo $r['client_name']; ?></td>
                                        <td><?php echo date('d-m-y', strtotime($r['order_date']));?></td>
                                        <?php
                                            $created_date = $this->db->query('SELECT created_date FROM order_log WHERE job_id = '.$r['id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['created_date'];
                                        ?>
                                        <td><?php echo isset($created_date) && !empty($created_date) ? date('d-m-y', strtotime($created_date)).'<br>'.date('H:i', strtotime($created_date)) : '';?></td>
                                        <td><?php echo '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$color.';border:1px solid '.$color.';">'.$status_name.'</span>';?><br> 
                                            <?php 
                                                if(isset($r['rejected_flag']) && $r['rejected_flag'] != 0 && $status_name == 'Pending')
                                                {
                                                   $rejected_by = $this->db->query('SELECT full_name FROM users WHERE id = (SELECT created_by FROM order_log WHERE rejected_flag = 1 AND job_id = '.$r['id'].' ORDER BY id DESC LIMIT 1)')->result_array()[0]['full_name'];
                                                   
                                                   $reason = $this->db->query('SELECT reason FROM order_log WHERE rejected_flag = 1 AND job_id = '.$r['id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['reason'];
                                            ?>
                                                    <a href="javascript:void(0);" onclick="check_rejected('<?php echo $reason;?>', '<?php echo $rejected_by;?>');">Rejected Order</a>
                                            <?php
                                                } 
                                            ?>
                                        </td>
                                        <?php
                                        // if($role_name == 'admin')
                                        // {
                                        //     ?>
                                                <td>
                                                    <?php if(isset($r['file_path']) && $r['file_path'] != '')
                                                    {
                                                    ?>
                                                        <span id="file_path_span<?php echo $r['id'];?>" style="display:none;"><?php echo isset($r['file_path']) && $r['file_path'] != '' ? $r['file_path'] : '';?></span>
                                                        <button type="button" onclick="copyToClipboard('#file_path_span<?php echo $r['id'];?>')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">File Path</button>    
                                                    <?php
                                                    } else{ echo '';}?>
                                                </td>
                                                <?php
                                        // }
                                        ?>
                                        <!-- <td><?php 
                                            $difficulty_query = $this->db->query('SELECT difficulty_id FROM `order_log` WHERE `job_id` = '.$r['id'].' AND difficulty_id != 0 AND is_dealocated = 0');
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
                                            ?>
                                                
                                        </td> -->
                                        <td><?php echo $this->master_model->get_one_record('difficulty', 'difficulty_name', $r['difficulty_id']);?></td>
                                        <td><?php echo $this->master_model->get_one_record('users', 'full_name', $r['assigned_to']);?></td>
                                        <?php echo isset($filterd_status) && $filterd_status == 'Paused' ? '<td>'.$this->db->order_by('id', 'DESC')->limit(1)->get_where('order_log', ['job_id' => $r['id'], 'status' => $r['status']])->result_array()[0]['reason'].'</td>' : '';?>
                                        <!-- <td><?php echo $r['password']; ?></td> -->
                                        <td>
                                            <!-- <div class="btn-group dropdown">
                                                <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right"> -->
                                                    <?php
                                                        if($status_name == 'Pending')
                                                    {
                                                        if(array_key_exists('Assign', $this->btn_permissions) && $this->btn_permissions['Assign']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                            <a class="dropdown-item" href="javascript:assign_order(<?php echo $r['id']; ?>, 'A');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Assign</a>
                                                    <?php
                                                        }
                                                    }
                                                    if($status_name == 'Allocated')
                                                    {
                                                        if(array_key_exists('De-allocate', $this->btn_permissions) && $this->btn_permissions['De-allocate']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                            <a class="dropdown-item" href="javascript:assign_order(<?php echo $r['id']; ?>, 'D');"><i class="mdi mdi-close-circle mr-2 text-muted font-18 vertical-middle"></i>De-allocate</a>
                                                    <?php
                                                        }
                                                    }
                                                    if($status_name == 'In Process')
                                                    {
                                                        if(array_key_exists('Pause', $this->btn_permissions) && $this->btn_permissions['Pause']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                            <a class="dropdown-item" href="javascript:pause_timer(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>);"><i class="fe-clock mr-2 text-muted font-18 vertical-middle"></i>Pause</a>
                                                    <?php
                                                        }
                                                    }
                                                    else if($status_name == 'QC Pending')
                                                    {
                                                        if(array_key_exists('QC Accept', $this->btn_permissions) && $this->btn_permissions['QC Accept']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                            <a class="dropdown-item" href="javascript:qc_accept(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>);"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>QC Accept</a>
                                                        <?php
                                                        }
                                                        if(array_key_exists('QC Reject', $this->btn_permissions) && $this->btn_permissions['QC Reject']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                            <a class="dropdown-item" href="javascript:qc_reject(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>);"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>QC Reject</a>
                                                        <?php
                                                        }
                                                    }
                                                    else if($status_name == 'Ready To Deliver')
                                                    {
                                                        if(array_key_exists('PDW Sent', $this->btn_permissions) && $this->btn_permissions['PDW Sent']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                            <a class="dropdown-item" href="javascript:pdw_sent(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>, 'PDW Sent');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>PDW Sent</a>
                                                        <?php
                                                        }
                                                    }
                                                    else if($status_name == 'PDW Sent')
                                                    {
                                                        if(array_key_exists('Modification', $this->btn_permissions) && $this->btn_permissions['Modification']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                            <a class="dropdown-item" href="javascript:client_fb(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>, 'Modification');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Modification</a>
                                                        <?php
                                                        }
                                                        if(array_key_exists('Repair', $this->btn_permissions) && $this->btn_permissions['Repair']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                            <a class="dropdown-item" href="javascript:client_fb(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>, 'Repair');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Repair</a>
                                                        <?php
                                                        }
                                                        if(array_key_exists('STL Requested', $this->btn_permissions) && $this->btn_permissions['STL Requested']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                            <a class="dropdown-item" href="javascript:change_status(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>, 'STL Requested');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>STL Requested</a>
                                                        <?php
                                                        }
                                                    }
                                                    else if($status_name == 'Modification' || $status_name == 'Repair')
                                                    {
                                                        if(array_key_exists('Complete', $this->btn_permissions) && $this->btn_permissions['Complete']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                        
                                                            <a class="dropdown-item" href="javascript:complete(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>);"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Complete</a>
                                                        <?php
                                                        }
                                                    }
                                                    else if($status_name == 'STL QC')
                                                    {
                                                        if(array_key_exists('STL Accept', $this->btn_permissions) && $this->btn_permissions['STL Accept']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                        
                                                            <a class="dropdown-item" href="javascript:stl_accept(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>, 'Modification');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>STL Accept</a>
                                                        <?php
                                                        }
                                                        if(array_key_exists('STL Reject', $this->btn_permissions) && $this->btn_permissions['STL Reject']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                            <a class="dropdown-item" href="javascript:stl_reject(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>, 'Repair');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>STL Reject</a>

                                                        <?php
                                                        }
                                                    }
                                                    else if($status_name == 'STL Accept')
                                                    {
                                                        if(array_key_exists('Complete', $this->btn_permissions) && $this->btn_permissions['Complete']['view_perm'] == 1)
                                                        {
                                                        ?>
                                                        
                                                            <a class="dropdown-item" href="javascript:complete(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>);"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Complete</a>                                                        
                                                        <?php
                                                        }
                                                    }

                                                    ?>
                                                    <?php
                                                        if(array_key_exists('Timeline', $this->btn_permissions) && $this->btn_permissions['Timeline']['view_perm'] == 1)
                                                        {
                                                    ?>
                                                            <a class="dropdown-item" href="<?php echo base_url();?>timeline/index/<?php echo $r['id'];?>"><i class="fe-clock font-18 text-muted mr-2 vertical-middle"></i>Timeline</a>
                                                    

                                                    <?php
                                                        }
                                                        if(array_key_exists('Cancel', $this->btn_permissions) && $this->btn_permissions['Cancel']['view_perm'] == 1 && $status_name != 'Canceled' && $status_name != 'Completed')
                                                        {
                                                    ?>
                                                            <a class="dropdown-item" href="javascript:cancel_order(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>);"><i class="mdi mdi-close-circle mr-2 text-muted font-18 vertical-middle"></i>Cancel</a>
                                                    

                                                    <?php
                                                        }
                                                        if(array_key_exists('Edit', $this->btn_permissions) && $this->btn_permissions['Edit']['view_perm'] == 1 && $status_name != 'Canceled')
                                                        {
                                                    ?>
                                                            <a class="dropdown-item" href="<?php echo base_url();?>production_orders/form_view/edit/<?php echo $r['id'];?>"><i class="fe-edit font-18 text-muted mr-2 vertical-middle"></i>Edit</a>
                                                    <?php
                                                        }
                                                        if($status_name != 'Pending')
                                                        {
                                                            if(array_key_exists('View', $this->btn_permissions) && $this->btn_permissions['View']['view_perm'] == 1 && $status_name != 'Canceled')
                                                            {
                                                    ?>
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="view_order(<?php echo $r['id'];?>, <?php echo $r['status'];?>);"><i class="fe-eye font-18 text-muted mr-2 vertical-middle"></i>View</a>
                                                    <?php
                                                            }
                                                        }
                                                        if($status_name == 'Completed')
                                                        {
                                                            if(array_key_exists('Modification', $this->btn_permissions) && $this->btn_permissions['Modification']['view_perm'] == 1)
                                                            {
                                                    ?>
                                                                <a class="dropdown-item" href="javascript:client_fb(<?php echo $r['id']; ?>, <?php echo $r['assigned_to']; ?>, 'Modification');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Modification</a>
                                                    <?php
                                                            }

                                                            if(array_key_exists('Move To Render', $this->btn_permissions) && $this->btn_permissions['Move To Render']['view_perm'] == 1 && $r['move_to_render'] == 0)
                                                            {
                                                    ?>
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="move_to_render(<?php echo $r['id'];?>);"><i class="fe-arrow-right font-18 text-muted mr-2 vertical-middle"></i>Move To Render</a>
                                                    <?php
                                                            }

                                                            if(array_key_exists('Delivered', $this->btn_permissions) && $this->btn_permissions['Delivered']['view_perm'] == 1)
                                                                {
                                                    ?>
                                                                    <a class="dropdown-item" href="javascript:delivered(<?php echo $r['id'];?>);"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Delivered</a>
                                                    <?php
                                                                }
                                                        }

                                                        if($status_name == 'Delivered')
                                                        {
                                                            if(array_key_exists('Move To Render', $this->btn_permissions) && $this->btn_permissions['Move To Render']['view_perm'] == 1 && $r['move_to_render'] == 0)
                                                            {
                                                    ?>
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="move_to_render(<?php echo $r['id'];?>);"><i class="fe-arrow-right font-18 text-muted mr-2 vertical-middle"></i>Move To Render</a>
                                                    <?php
                                                            }
                                                        }

                                                        
                                                    ?>

                                                <!-- </div> -->
                                            <!-- </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

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
    $('#tickets-table').DataTable( {
        "scrollX": true
    } );

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
        $('#pauseModalLabel').text('Pause');
        $("#pause-modal").modal("toggle");
        $("#pause_order_id").val(order_id);
    }

    function view_order(order_id, status)
    {
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
        $("#complete-modal").modal("toggle");
        $("#complete_order_id").val(order_id);
        $("#complete_assigned_to").val(assigned_to);
    }

    function qc_accept(order_id, user_id)
    {
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
        $("#cancel-modal").modal("toggle");
        $("#cancel_order_id").val(order_id);
        $("#cancel_assigned_to").val(assigned_to);
    }

    function stl_accept(order_id, user_id)
    {
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
        $('#confirmModal').modal('toggle');
        $('#stl_order_id').val(order_id);
        $('#stl_user_id').val(user_id);
        $('#stl_status').val(status);
    }

    function pdw_sent(order_id, user_id, status)
    {
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
      $temp.val($(element).text()).select();
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
  </script>
<?php $this->load->view('common/change_password');?>
</body>
</html>