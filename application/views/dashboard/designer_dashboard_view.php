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

    <style>
        .avatar-title{
            display: flex !important;
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
                    <div class="col-md-6 col-xl-3">
                        <a href="<?php echo base_url();?>allocated_tasks">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-primary">
                                        <i class="fas  fas fa-shopping-basket font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS total_orders FROM production_order WHERE assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['total_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">Total Orders</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                         <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "Pending"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-warning">
                                        <i class="fas fa-hourglass-start font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS pending_orders FROM cad_view WHERE assigned_to = '.$this->session->userdata('user_id').' AND status = (SELECT id FROM status WHERE status_name = "Pending")')->result_array()[0]['pending_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">Pending Tasks</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "Allocated"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-success">
                                        <i class="fas fa-user-plus font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS allocated_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "Allocated") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['allocated_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">Allocated Tasks</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "In Process"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-warning">
                                        <i class="fas fa-play font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS allocated_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "In Process") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['allocated_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">In Process</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->
                </div>
                <!-- end row -->


                <div class="row">
                    <div class="col-md-6 col-xl-3">
                         <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "Paused"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-warning">
                                        <i class="fas fa-pause font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS pending_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "Paused") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['pending_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">Paused Tasks</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "QC Pending"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-warning">
                                        <i class="fas fa-hourglass-half font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS qc_pending_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "QC Pending") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['qc_pending_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">QC Pending</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "Ready To Deliver"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-success">
                                        <i class="fas fa-user-check font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS allocated_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "Ready To Deliver") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['allocated_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate"><?php echo $this->master_model->get_one_record('status', 'status_name', $status_id);?></p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->


                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "Completed"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-success">
                                        <i class="fas fa-check font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS completed_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "Completed") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['completed_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">Completed Tasks</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "Modification"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-warning">
                                        <i class="fas fa-pencil-alt font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS rejected_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "Modification") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['rejected_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">Modification</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "Repair"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-success">
                                        <i class="fas fa-wrench font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS rejected_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "Repair") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['rejected_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">Repair</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "STL Requested"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-danger">
                                        <i class="fas fa-question font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS rejected_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "STL Requested") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['rejected_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">STL Requested</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "STL QC"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-warning">
                                        <i class="fas fa-hourglass-half font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS rejected_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "STL QC") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['rejected_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">STL QC</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "STL Ready"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-success">
                                        <i class="fas fa-user-check font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS rejected_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "STL Ready") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['rejected_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">STL Ready</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "STL Process"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-danger">
                                        <i class="fas fa-times font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS rejected_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "STL Process") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['rejected_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">STL Process</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "STL Reject"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-danger">
                                        <i class="fas fa-times font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS rejected_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "STL Reject") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['rejected_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">STL Reject</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "STL Accept"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-danger">
                                        <i class="fas fa-times font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS rejected_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "STL Accept") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['rejected_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">STL Accept</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "PDW Sent"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-danger">
                                        <i class="fas fa-times font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS rejected_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "PDW Sent") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['rejected_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">PDW Sent</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <?php
                        $query = $this->db->query('SELECT id, status_name FROM status WHERE status_name = "QC Reject"');
                        if($query->num_rows() > 0)
                        {
                            $result = $query->result_array()[0];
                            $status_id = $result['id'];
                        }
                        ?>
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=<?php echo $result['id'];?>">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-danger">
                                        <i class="fas fa-times font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $this->db->query('SELECT COUNT(id) AS rejected_orders FROM cad_view WHERE status = (SELECT id FROM status WHERE status_name = "QC Reject") AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['rejected_orders'];?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">QC Reject</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <a href="<?php echo base_url();?>allocated_tasks?status_name=0">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle bg-danger">
                                        <i class="fas fa-exclamation font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <?php 
                                            $today = date('Y-m-d');
                                            $overdue = $this->db->query('SELECT COUNT(id) AS overdue FROM cad_view WHERE status IN (SELECT id FROM status WHERE status_name != "Completed") AND deadline < "'.$today.'" AND assigned_to = '.$this->session->userdata('user_id'))->result_array()[0]['overdue'];

                                            
                                        ?>
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $overdue;?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">Overdue</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                        </a>
                    </div> <!-- end col-->

                    
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


<!-- Tickets js -->
<script src="<?php echo base_url();?>assets/js/pages/tickets.js"></script>

<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>

<?php $this->load->view('common/change_password');?>
</body>
</html>