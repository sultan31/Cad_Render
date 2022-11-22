    <!-- Topbar Start -->
    <div class="navbar-custom">
        <?php
            $role_name = $this->db->query('SELECT role_name FROM role WHERE id = '.$this->session->userdata('user_role'))->result_array()[0]['role_name'];
            $style = ($role_name == 'Dept Manager' || $role_name == 'CAD Manager' || $role_name == 'General Manager' || $role_name == 'Floor Manager' || $role_name == 'Customer Service Manager') ? 'background:#b1aeae;' : '';
        ?>
        <div class="container-fluid" style="<?php echo $style;?>">
            <ul class="list-unstyled topnav-menu float-right mb-0">

               

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
                <!-- <a href="<?php echo base_url().$dashboard;?>" class="logo logo-dark text-center">
                            <span class="logo-sm">
                                <img src="<?php echo base_url();?>assets/images/logo-sm.png" alt="" height="22">
                                
                            </span>
                    <span class="logo-lg">
                                <img src="<?php echo base_url();?>assets/images/logo-dark.png" alt="" height="50">
                        
                            </span>
                </a> -->

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
    
