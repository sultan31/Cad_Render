    <!-- Topbar Start -->
    <div class="navbar-custom">
        <?php
            $role_name = $this->db->query('SELECT role_name FROM role WHERE id = '.$this->session->userdata('user_role'))->result_array()[0]['role_name'];
            $style = ($role_name == 'Dept Manager' || $role_name == 'CAD Manager' || $role_name == 'General Manager' || $role_name == 'Floor Manager' || $role_name == 'Customer Service Manager') ? 'background:#b1aeae;' : '';
        ?>
        <div class="container-fluid" style="<?php echo $style;?>">
            <ul class="list-unstyled topnav-menu float-right mb-0">

                <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="fe-bell noti-icon"></i>
                                <span class="badge badge-danger rounded-circle noti-icon-badge" id="noti_count">
                                    <?php
                                        
                                        // 1,3,5,6,8
                                        if($role_name == 'Admin' || $role_name == 'Customer Service' || $role_name == 'Floor Manager' || $role_name == 'General Manager' || $role_name == 'Customer Service Manager')
                                        {
                                            $notify_last_seen = $this->db->query('SELECT notify_last_seen FROM users WHERE id = '.$this->session->userdata('user_id'))->result_array()[0]['notify_last_seen'];
                                            if(isset($notify_last_seen) && $notify_last_seen != '')
                                            {
                                                $order_log_rows = $this->db->query('SELECT * FROM order_log WHERE DATE_FORMAT(created_date, "%Y-%m-%d %H:%i:%s") >= "'.$notify_last_seen.'"')->num_rows();  

                                                $render_order_log_rows = $this->db->query('SELECT * FROM render_order_log WHERE DATE_FORMAT(created_date, "%Y-%m-%d %H:%i:%s") >= "'.$notify_last_seen.'"')->num_rows(); 

                                                echo  $order_log_rows + $render_order_log_rows;                                    
                                            }
                                            else
                                            {
                                               $order_log_rows = $this->db->query('SELECT * FROM order_log')->num_rows(); 
                                               $render_order_log_rows = $this->db->query('SELECT * FROM render_order_log')->num_rows(); 
                                               echo  $order_log_rows + $render_order_log_rows;                                    
                                            }
                                        }
                                        else if($role_name == 'Dept Manager')
                                        {
                                            $notify_last_seen = $this->db->query('SELECT notify_last_seen FROM users WHERE id = '.$this->session->userdata('user_id'))->result_array()[0]['notify_last_seen'];
                                            if(isset($notify_last_seen) && $notify_last_seen != '')
                                            {
                                                $render_order_log_rows = $this->db->query('SELECT * FROM render_order_log WHERE DATE_FORMAT(created_date, "%Y-%m-%d %H:%i:%s") >= "'.$notify_last_seen.'"')->num_rows(); 

                                                echo $render_order_log_rows;                                    
                                            }
                                            else
                                            {
                                               $render_order_log_rows = $this->db->query('SELECT * FROM render_order_log')->num_rows(); 
                                               echo $render_order_log_rows;                                    
                                            }
                                        }
                                        else if($role_name == 'CAD Manager')
                                        {
                                            $notify_last_seen = $this->db->query('SELECT notify_last_seen FROM users WHERE id = '.$this->session->userdata('user_id'))->result_array()[0]['notify_last_seen'];
                                            if(isset($notify_last_seen) && $notify_last_seen != '')
                                            {
                                                $order_log_rows = $this->db->query('SELECT * FROM order_log WHERE DATE_FORMAT(created_date, "%Y-%m-%d %H:%i:%s") >= "'.$notify_last_seen.'"')->num_rows();   

                                                echo $order_log_rows;                                    
                                            }
                                            else
                                            {
                                               $order_log_rows = $this->db->query('SELECT * FROM order_log')->num_rows(); 
                                               echo  $order_log_rows;                                    
                                            }
                                        }
                                        
                                        else if($role_name == 'Cad Designer')
                                        {
                                            $notify_last_seen = $this->db->query('SELECT notify_last_seen FROM users WHERE id = '.$this->session->userdata('user_id'))->result_array()[0]['notify_last_seen'];
                                            if(isset($notify_last_seen) && $notify_last_seen != '')
                                            {
                                                echo $this->db->query('SELECT * FROM order_log WHERE assigned_to = '.$this->session->userdata('user_id').' AND DATE_FORMAT(created_date, "%Y-%m-%d %H:%i:%s") >= "'.$notify_last_seen.'"')->num_rows();

                                                // pre($this->db->last_query());                                               
                                            }
                                            else
                                            {
                                                echo '0';
                                            }
                                        } 

                                        else if($role_name == 'Render Designer')
                                        {
                                            $notify_last_seen = $this->db->query('SELECT notify_last_seen FROM users WHERE id = '.$this->session->userdata('user_id'))->result_array()[0]['notify_last_seen'];
                                            if(isset($notify_last_seen) && $notify_last_seen != '')
                                            {
                                                echo $this->db->query('SELECT * FROM render_order_log WHERE assigned_to = '.$this->session->userdata('user_id').' AND DATE_FORMAT(created_date, "%Y-%m-%d %H:%i:%s") >= "'.$notify_last_seen.'"')->num_rows();

                                                // pre($this->db->last_query());                                               
                                            }
                                            else
                                            {
                                                echo '0';
                                            }
                                        } 


                                        
                                    ?>
                                        
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-lg">
    
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="m-0">
                                        <span class="float-right">
                                            <!-- <a href="" class="text-dark">
                                                <small>Clear All</small>
                                            </a> -->
                                        </span>Notification Center
                                    </h5>
                                </div>
    
                                <div class="noti-scroll" data-simplebar>

                                    <?php
                                        if($role_name == 'Admin'|| $role_name == 'Customer Service' || $role_name == 'Floor Manager' || $role_name == 'General Manager' || $role_name == 'Customer Service Manager')
                                        {
                                            $noti = $this->db->query('SELECT * FROM order_log ORDER BY id DESC LIMIT 5');
                                        }
                                        else if($role_name == 'Cad Designer' || $role_name == 'CAD Manager')
                                        {
                                            $noti = $this->db->query('SELECT * FROM order_log WHERE assigned_to = '.$this->session->userdata('user_id').' ORDER BY id DESC LIMIT 5 ');
                                        }
                                        else if($role_name == 'Render Designer' || $role_name == 'Dept Manager')
                                        {
                                            $noti = $this->db->query('SELECT * FROM render_order_log WHERE assigned_to = '.$this->session->userdata('user_id').' ORDER BY id DESC LIMIT 5 ');
                                        }

                                        if(isset($noti))
                                        {
                                        
                                            if($noti->num_rows() > 0)
                                            {
                                               $noti_result = $noti->result_array();
                                               foreach ($noti_result as $value) 
                                               {
                                    ?>
                                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                    <div class="notify-icon bg-primary">
                                                        <i class="mdi mdi-comment-account-outline"></i>
                                                    </div>
                                                    <p class="notify-details"><div><?php echo $this->db->query('SELECT order_number FROM production_order WHERE id = '.$value['job_id'])->result_array()[0]['order_number'];?></div><?php echo $value['description'];?>
                                                        <small class="text-muted"><?php echo date('d F Y', strtotime($value['created_date']));?></small>
                                                    </p>
                                                </a>            
                                    <?php
                                                } 
                                            }
                                        }
                                    ?>

    
                                    
                                </div>
    
                                <!-- All-->
                                <a href="<?php echo base_url();?>notification_center/" class="dropdown-item text-center text-primary notify-item notify-all">
                                    View all
                                    <i class="fe-arrow-right"></i>
                                </a>
    
                            </div>
                        </li>

                <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="<?php echo base_url();?>assets/images/avatar.png" alt="user-image" class="rounded-circle">
                                <span class="pro-user-name ml-1">
                                    <?php echo $this->session->userdata('full_name');?> <i class="mdi mdi-chevron-down"></i> 
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
    
                                <!-- item-->
                                <a href="<?php echo base_url();?>profile" class="dropdown-item notify-item">
                                    <i class="fe-user"></i>
                                    <span>Profile</span>
                                </a>  
                                
    
                                <div class="dropdown-divider"></div>

                                <a href="#" data-toggle="modal" data-target="#change-pwd-modal" class="dropdown-item notify-item">
                                    <i class="fe-user"></i>
                                    <span>Change Password</span>
                                </a>  
                                
    
                                <div class="dropdown-divider"></div>
    
                                <!-- item-->
                                <a href="<?php echo base_url();?>login/logout" class="dropdown-item notify-item">
                                    <i class="fe-log-out"></i>
                                    <span>Logout</span>
                                </a>
    
                            </div>
                        </li>
            </ul>

            <!-- LOGO -->
            <div class="logo-box">
                <?php
                
                    if($this->session->userdata('user_role') == 4 || $this->session->userdata('user_role') == 7)
                    {
                        $dashboard = 'render_dashboard';
                    }
                    else
                    {
                        $dashboard = 'dashboard';
                    }
                    
                ?>
                <a href="<?php echo base_url().$dashboard;?>" class="logo logo-dark text-center">
                            <span class="logo-sm">
                                <img src="<?php echo base_url();?>assets/images/logo-sm.png" alt="" height="22">
                                <!-- <span class="logo-lg-text-light">UBold</span> -->
                            </span>
                    <span class="logo-lg">
                                <img src="<?php echo base_url();?>assets/images/logo-dark.png" alt="" height="50">
                        <!-- <span class="logo-lg-text-light">U</span> -->
                            </span>
                </a>

                <a href="<?php echo base_url();?>dashboard" class="logo logo-light text-center">
                            <span class="logo-sm">
                                <img src="<?php echo base_url();?>assets/images/logo-sm.png" alt="" height="22">
                            </span>
                    <span class="logo-lg">
                                <img src="<?php echo base_url();?>assets/images/logo-light.png" alt="" height="20">
                            </span>
                </a>
            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                
                <li>
                    <!-- Mobile menu toggle (Horizontal Layout)-->
                    <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </li>


            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- end Topbar -->
    
