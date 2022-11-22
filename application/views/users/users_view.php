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
                        <div>
                                <a href="<?php echo base_url();?>users/form_view/add" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle mr-2"></i> Add User</a>
                        </div>
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
                            

                            <table class="table table-hover table-bordered m-0 table-centered nowrap w-100" id="tickets-table">
                                
                                <thead>
                                <tr>
                                    
                                    <th style="width: 20px;">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <!-- <th>Department</th> -->
                                    <th>Role</th>
                                    <th style="width: 75px;">Action</th>
                                    
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                
                                $sql = "SELECT * FROM users WHERE delete_flag = 0 ORDER BY id DESC";

                                $res = $this->db->query($sql);
                                $row = $res->result_array();
                               
                                $i = 0;
                                $row = $res->result_array();
                                foreach($row as $r)
                                {
                                    
                                    $i++;
                                    ?>
                                    <tr id="tr_<?php echo $r['id'];?>">
                                        
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ucwords($r['full_name']); ?></td>
                                        <td><?php echo $r['email_id']; ?></td>
                                        <td><?php echo $r['mobile_no']; ?></td>
                                        <!-- <td>
                                            <?php 
                                                $user_depts = $this->db->get_where('user_departments', ['user_id' => $r['id']]);
                                                if($user_depts->num_rows() > 0)
                                                {
                                                    $user_depts = array_column($user_depts->result_array(), 'dept_id');
                                                    
                                                    foreach ($user_depts as $key1 => $value1) 
                                                    {
                                                        $dept_str[] = ucwords($this->master_model->get_one_record('department', 'dept_name', $value1));
                                                    }

                                                    echo implode(',', $dept_str);
                                                    
                                                }
                                            ?>
                                        </td> -->
                                        <td><?php echo ucwords($this->master_model->get_one_record('role', 'role_name', $r['user_role'])); ?></td>
                                        <td>
                                            <a href="<?php echo base_url().'users/form_view/edit/'.$r['id'];?>" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;"> <span class="mdi mdi-pencil"></span></a>
                                            
                                            <button class="demo-delete-row btn btn-danger btn-xs btn-icon sa-warning" data-id="<?php echo $r['id']; ?>"><i class="fa fa-times"></i></button>
                                            <?php
                                                if($r['active'] == 1)
                                                {
                                            ?>
                                                    <button class="demo-delete-row btn btn-danger btn-xs btn-icon" onclick="change_status('Deactivate:<?php echo $r['id']; ?>')">Deactivate</button>
                                            <?php
                                                }
                                                else
                                                {
                                            ?>
                                                    <button class="demo-delete-row btn btn-success btn-xs btn-icon" onclick="change_status('Activate:<?php echo $r['id']; ?>')">Activate</button>
                                            <?php
                                                }
                                            ?>
                                            

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
<script src="<?php echo base_url();?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

<script>
    $(document).ready(function(){

    setTimeout(function() {
            $('.alert').fadeOut('slow');
    }, 3000); // <-- time in milliseconds

       
    $('#tickets-table').DataTable( {
        "scrollX": true
    } );

    });
</script>

<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>
<script type="text/javascript">

    function change_status(string)
    {
        
        var res = string.split(':');
        
        $.ajax({
                    url: '<?php echo base_url();?>users/change_status',
                    type: 'POST',
                    data:{'action':res[0], 'id':res[1]},
                    dataType:'json',
                    success: function(result){
                        console.log(result);
                        if(result.active == 1)
                        {
                            Swal.fire("Activated!","User has been activated.","success");
                        }
                        else if(result.active == 0)
                        {
                            
                            Swal.fire("Deactivated!","User has been deactivated.","error");
                        }


                        setTimeout(function() {
                            location.reload();
                        }, 4000); // <-- time in milliseconds
                        
                        
                    }
                });
    }


    $(".sa-warning").click(function()
    {
        var id = $(this).attr('data-id');
        $.ajax({
                    url: '<?php echo base_url();?>users/check_allocated_order',
                    type: 'POST',
                    data:{'id':id},
                    dataType:'json',
                    success: function(result){
                        if(result.status == 0)
                        {
                            Swal.fire("No!","Can not delete this user","error");
                        }
                        else
                        {
                            Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",type:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete it!"}).then(function(t)
                            {
                                if(t.value == true)
                                {
                                    $.ajax({
                                        url: '<?php echo base_url();?>users/remove',
                                        type: 'POST',
                                        data:{'id':id},
                                        dataType:'json',
                                        success: function(result){
                                            
                                            var table = $("#tickets-table").DataTable();
                                            Swal.fire("Deleted!","User has been deleted.","success");
                                            table.row('#tr_'+id).remove().draw( false );
                                        }
                                    });
                                }
                                else
                                {

                                }

                            });
                        }
                    }
                });
        
    });
</script>
<?php $this->load->view('common/change_password');?>
</body>
</html>