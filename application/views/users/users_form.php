<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo ucwords($this->uri->segment(1)). ' | ';?><?php echo isset($edit_data[0]['id']) ? 'Edit' : 'Add';?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">
    <link href="<?php echo base_url();?>assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />

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
    <link href="<?php echo base_url();?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #000000;
            border: 1px solid #aaa;
            border-radius: 4px;
            cursor: default;
            float: left;
            margin-right: 5px;
            margin-top: 5px;
            padding: 0 5px;
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

                                    <li class="breadcrumb-item active"><?php echo ucwords($this->uri->segment(1));?></li>
                                </ol>
                            </div> -->
                            <h4 class="page-title"><?php echo ucwords($this->uri->segment(1));?></h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

               
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-box">
                            
                            <form action="<?php echo isset($edit_data[0]['id']) ? base_url().'users/form_action/'.$edit_data[0]['id'] : base_url().'users/form_action';?>" method="post" class="parsley-examples">
                                <div class="form-group">
                                    <label for="role_name">Role</label>
                                    <select class="form-control" name="user_role" id="user_role" data-toggle="select2" required>
                                        <option value="">Select</option>
                                        <?php
                                        $role = $this->db->query('SELECT * FROM `role`');
                                        if($role->num_rows() > 0)
                                        {
                                            $role = $role->result_array();
                                            foreach($role as $r)
                                            {
                                                $selected = isset($edit_data[0]['user_role']) && ($edit_data[0]['user_role'] == $r['id']) ? 'selected' : '';
                                                echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['role_name'].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                
                                <div class="form-group">
                                    <label for="dept_id">Department</label>
                                    <?php

                                    ?>
                                    <select class="form-control select2-multiple" data-toggle="select2" multiple="multiple" data-placeholder="Choose ..." name="dept_id[]" id="dept_id">
                                        
                                        <?php

                                        if(isset($edit_data[0]['id']))
                                        {
                                            $user_departments = $this->db->query('SELECT dept_id FROM `user_departments` WHERE user_id = '.$edit_data[0]['id'])->result_array();
                                            $dept_id = array_column($user_departments, 'dept_id');
                                        }                                           
                                        

                                        $department = $this->db->query('SELECT id, dept_name FROM department');
                                        
                                        if($department->num_rows() > 0)
                                        {
                                            $department = $department->result_array();
                                            foreach($department as $d)
                                            {
                                                $selected = '';
                                                if(isset($dept_id) && !empty($dept_id) && in_array($d['id'], $dept_id))
                                                {
                                                    $selected = 'selected';
                                                } 

                                                echo '<option value="'.$d['id'].'" '.$selected.'>'.$d['dept_name'].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input data-parsley-pattern="^[a-zA-Z ]+$" type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name" value="<?php echo isset($edit_data[0]['full_name']) ? $edit_data[0]['full_name'] : '';?>" required>

                                </div>

                                <div class="form-group">
                                    <label for="mobile_no">Mobile No</label>
                                    <input data-parsley-type="digits" data-parsley-maxlength="10" data-parsley-minlength="10" type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile No" value="<?php echo isset($edit_data[0]['mobile_no']) ? $edit_data[0]['mobile_no'] : '';?>" data-parsley-trigger="focusout" data-parsley-checkmobile data-parsley-checkmobile-message="Mobile No Already Exists" required>
                                    <div class="mobile_noError errorClass" style="color:red;"></div>

                                </div>

                                <div class="form-group">
                                    <label for="email_id">Email Id</label>
                                    <input parsley-type="email" type="email" class="form-control" id="email_id" name="email_id" placeholder="Email Id" value="<?php echo isset($edit_data[0]['email_id']) ? $edit_data[0]['email_id'] : '';?>" onblur="check_duplicate('email', this.value);" required>
                                    <div class="emailError errorClass" style="color:red;"></div>

                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo isset($edit_data[0]['password']) ? $edit_data[0]['password'] : '';?>" required>

                                </div>

                                <?php
                                    if(!isset($edit_data[0]['id']))
                                    {
                                ?>
                                        <div class="form-group">
                                            <label for="c_password">Confirm Password</label>
                                            <input data-parsley-equalto="#password" type="password" class="form-control" id="c_password" name="c_password" placeholder="Confirm Password" required>

                                        </div>
                                <?php
                                    }
                                ?>



                                <div class="form-group mb-0">
                                    <div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                                            Submit
                                        </button>
                                        
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end card-box -->
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

<!-- Vendor js -->
<script src="<?php echo base_url();?>assets/js/vendor.min.js"></script>

<!-- Plugin js-->
<script src="<?php echo base_url();?>assets/libs/parsleyjs/parsley.min.js"></script>

<!-- Validation init js-->
<script src="<?php echo base_url();?>assets/js/pages/form-validation.init.js"></script>

<script src="<?php echo base_url();?>assets/libs/selectize/js/standalone/selectize.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/mohithg-switchery/switchery.min.js"></script>

<script src="<?php echo base_url();?>assets/libs/multiselect/js/jquery.multi-select.js"></script>
<script src="<?php echo base_url();?>assets/libs/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/jquery-mockjax/jquery.mockjax.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url();?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>

<script src="<?php echo base_url();?>assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

<!-- Init js-->
<script src="<?php echo base_url();?>assets/js/pages/form-advanced.init.js"></script>


<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>

<script type="text/javascript">
    function check_duplicate(type, value)
    {
        if(value != '')
        {
            $.ajax({
                  url:'<?php echo base_url();?>users/check_duplicate',
                  method:"POST",
                  data:{'type':type, 'value':value},
                  dataType:"json",
                  success:function(data)
                  {
                    if(data.status == 0)
                    {
                        if(type == 'email')
                        {
                            $('.'+type+'Error').text('Email Already Exists');
                        }
                        else if(type == 'mobile_no')
                        {
                            $('.'+type+'Error').text('Mobile No Already Exists');
                        }
                    }
                    else
                    {
                        $('.errorClass').text('');
                    }
                  }
                });   
        }
        
    }

</script>
<?php $this->load->view('common/change_password');?>
</body>
</html>