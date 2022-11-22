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
    <!-- App css -->
    <link href="<?php echo base_url();?>assets/css/bootstrap-material.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?php echo base_url();?>assets/css/app-material.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="<?php echo base_url();?>assets/css/bootstrap-material-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="<?php echo base_url();?>assets/css/app-material-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="<?php echo base_url();?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />       

    <style type="text/css">
        
    /*.img-hover-zoom {
      height: 300px; 
      overflow: hidden; 
    }*/


    .img-hover-zoom img {
      transition: transform .5s ease;
    }

    .img-hover-zoom:hover img {
      transform: scale(1.9);
    }
    </style>


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
                            
                            <h4 class="page-title"><?php echo ucwords(str_replace('_', ' ', $this->uri->segment(1)));?></h4>
                        </div>
                        <?php
                               $role_name = $this->db->query('SELECT role_name FROM `role` WHERE id = '.$this->session->userdata('user_role'))->result_array()[0]['role_name'];

                               $delete_btn_show = ($role_name == 'Dept Manager' || $role_name == 'Render Designer') ? 'display:none;' : 'display:block;';
                            ?>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <h4 class="header-title">Images Uploaded</h4>
                                   
                                </div>

                                <div class="row mb-2">
                                            <div class="form-group mb-3 col-lg-12">
                                                <?php
                                                    $portal_order_images = $this->db->query('SELECT id, file_name FROM portal_order_images WHERE order_id = '.$id);
                                                    if($portal_order_images->num_rows() > 0)
                                                    {
                                                        $portal_order_images = $portal_order_images->result_array();
                                                        foreach ($portal_order_images as $key => $value) 
                                                        {
                                                ?>
                                                            <div class="col-lg-2" style="float:left;" id="img<?php echo $value['id'];?>">


                                                                <button class="demo-delete-row btn btn-danger btn-xs btn-icon" onclick="remove_file('img', <?php echo $value['id'];?>);" style="float:right;<?php echo $delete_btn_show;?>"><i class="fa fa-times"></i></button>

                                                                <!-- <a class="example-image-link" href="<?php //echo base_url();?>portal_order_images/<?php //echo $value['file_name'];?>" data-lightbox="example" data-title=""> -->
                                                                    
                                                                    <div class="img-hover-zoom">
                                                                        <a href="<?php echo base_url();?>portal_order_images/<?php echo $value['file_name'];?>">
                                                                <img src="<?php echo base_url().'portal_order_images/'.$value['file_name'];?>" class="example-image" style="max-width:100%;">
                                                                </a> 
                                                            </div>
                                                                
                                                            </div>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                              
                                                    
                                              
                                              
                                          </div>                                           
                                </div>

                                <div class="row mb-2">
                                    <h4 class="header-title">Videos Uploaded</h4>
                                   
                                </div>

                                <div class="row mb-2">
                                            <div class="form-group mb-3 col-lg-12">
                                                <?php
                                                    $portal_order_videos = $this->db->query('SELECT id, file_name FROM portal_order_videos WHERE order_id = '.$id);
                                                    if($portal_order_videos->num_rows() > 0)
                                                    {
                                                        $portal_order_videos = $portal_order_videos->result_array();
                                                        foreach ($portal_order_videos as $key => $value) 
                                                        {
                                                ?>
                                                            <div class="col-lg-2" style="float:left;" id="video<?php echo $value['id'];?>">
                                                                <button class="demo-delete-row btn btn-danger btn-xs btn-icon" onclick="remove_file('video', <?php echo $value['id'];?>);" style="float:right;"><i class="fa fa-times"></i></button>
                                                                <a href="<?php echo base_url();?>portal_order_videos/<?php echo $value['file_name'];?>" target="_blank">
                                                                <img src="<?php echo base_url();?>assets/images/video-icon.png" class="example-image" style="max-width:100%;">
                                                                </a>
                                                            </div>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                              
                                                    
                                              
                                              
                                          </div>                                           
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
<div id="confirmModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              
              <div class="modal-body">
                <p>Are you sure to delete?</p>
                <input type="hidden" name="type" id="type">
                <input type="hidden" name="id" id="id">
                
              </div>
              <div class="modal-footer">
                <button type="button" id="confirm_delete" class="btn btn-success">Yes</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
              </div>
              
            </div>

          </div>
        </div>
<!-- /.modal -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
<?php //$this->load->view('common/footer');?>

<script src="https://xprsweb.com/process/assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="<?php echo base_url();?>assets/js/app.min.js"></script>

<script type="text/javascript">
    function remove_file(type, id)
    {
        $('#confirmModal').modal('toggle');
        $('#type').val(type);
        $('#id').val(id);
        
    }

    $('#confirm_delete').click(function(){

        $('#confirmModal').modal('toggle');

        $.ajax({

            url:'<?php echo base_url();?>portal_orders/remove_file',
            type:'POST',
            data:{'type':$('#type').val(), 'id':$('#id').val()},
            success:function(){
                $('#'+$('#type').val()+$('#id').val()).remove();
                
                $('#type').val('');
                $('#id').val('');
            }
        });

    });
</script>


<?php $this->load->view('common/change_password');?>
</body>
</html>