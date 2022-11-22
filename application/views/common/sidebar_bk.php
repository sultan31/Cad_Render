    <?php
            $role_name = $this->db->query('SELECT role_name FROM role WHERE id = '.$this->session->userdata('user_role'))->result_array()[0]['role_name'];
            $style = ($role_name == 'Dept Manager' || $role_name == 'CAD Manager' || $role_name == 'General Manager' || $role_name == 'Floor Manager' || $role_name == 'Customer Service Manager') ? 'background:#b1aeae;' : '';
    ?>
    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu" style="<?php echo $style;?>">

        <div class="h-100" data-simplebar>

            <!-- User box -->
            <div class="user-box text-center">
                <img src="<?php echo base_url();?>assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                     class="rounded-circle avatar-md">
                <div class="dropdown">
                    <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                       data-toggle="dropdown">Geneva Kennedy</a>
                    <div class="dropdown-menu user-pro-dropdown">

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-user mr-1"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-settings mr-1"></i>
                            <span>Settings</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-log-out mr-1"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </div>
                <p class="text-muted">Admin Head</p>
            </div>

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul id="side-menu">

                    <li class="menu-title">Navigation</li>

                    <?php
                        if(array_key_exists('DB', $this->role_permissions) && $this->role_permissions['DB']['view_perm'] == 1)
                        {
                    ?>
                            <li>
                                <a href="<?php echo base_url();?>dashboard"><i class="mdi mdi-view-dashboard-outline"></i> Dashboard</a>
                            </li>
                    <?php
                        }
                        if(array_key_exists('DDB', $this->role_permissions) && $this->role_permissions['DDB']['view_perm'] == 1)
                        {
                    ?>
                            <li>
                                <a href="<?php echo base_url();?>designer_dashboard"><i class="mdi mdi-view-dashboard-outline"></i> Dashboard</a>
                            </li>
                    <?php
                        }
                        if(array_key_exists('RDB', $this->role_permissions) && $this->role_permissions['RDB']['view_perm'] == 1)
                        {
                    ?>
                            <li>
                                <a href="<?php echo base_url();?>render_dashboard"><i class="mdi mdi-view-dashboard-outline"></i>Render Dashboard</a>
                            </li>
                    <?php
                        }
                        if(array_key_exists('PO', $this->role_permissions) && $this->role_permissions['PO']['view_perm'] == 1)
                        {
                    ?>
                            <li class="<?php echo $this->uri->segment(1) == 'portal_orders' ? 'menuitem-active' : '';?>">
                                <a href="<?php echo base_url();?>portal_orders">
                                    <i class="mdi mdi-cart-outline"></i>
                                    <span> Portal Orders </span>
                                </a>
                            </li>
                    <?php
                        }
                        if(array_key_exists('PR', $this->role_permissions) && $this->role_permissions['PR']['view_perm'] == 1)
                        {
                    ?>
                            <li class="<?php echo $this->uri->segment(1) == 'production_orders' ? 'menuitem-active' : '';?>">
                                <a href="<?php echo base_url();?>production_orders">
                                    <i class="mdi mdi-cart-outline"></i>
                                    <span>CAD Production Orders </span>
                                </a>
                            </li>
                    <?php
                        }
                        if(array_key_exists('RE', $this->role_permissions) && $this->role_permissions['RE']['view_perm'] == 1)
                        {
                    ?>
                            <li class="<?php echo $this->uri->segment(1) == 'render_production_orders' ? 'menuitem-active' : '';?>">
                                <a href="<?php echo base_url();?>render_production_orders">
                                    <i class="mdi mdi-cart-outline"></i>
                                    <span>Render Production Orders </span>
                                </a>
                            </li>
                    <?php
                        }
                        if(array_key_exists('AT', $this->role_permissions) && $this->role_permissions['AT']['view_perm'] == 1)
                        {
                    ?>
                            <li class="<?php echo $this->uri->segment(1) == 'allocated_tasks' ? 'menuitem-active' : '';?>">
                                <a href="<?php echo base_url();?>allocated_tasks">
                                    <i class="mdi mdi-cart-outline"></i>
                                    <span> Allocated Tasks </span>
                                </a>
                            </li>
                    <?php
                        }
                        if(array_key_exists('MS', $this->role_permissions) && $this->role_permissions['MS']['view_perm'] == 1)
                        {
                    ?>
                            <li>
                                <a href="#sidebarMaster" data-toggle="collapse">
                                    <i class="mdi mdi-database"></i>
                                    <span> Masters </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarMaster">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="<?php echo base_url();?>role">Role</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>status">Status</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url();?>difficulty">Difficulty</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo base_url();?>department">Department</a>
                                        </li>
                                        
                                        <li>
                                            <a href="<?php echo base_url();?>render_status">Render Status</a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                    <?php
                        }
                        if(array_key_exists('USR', $this->role_permissions) && $this->role_permissions['USR']['view_perm'] == 1)
                        {
                    ?>
                            <li class="<?php echo $this->uri->segment(1) == 'users' ? 'menuitem-active' : '';?>">
                                <a href="<?php echo base_url();?>users">
                                    <i class="mdi mdi-account-multiple-outline"></i>
                                    <span>Users</span>
                                </a>
                            </li>
                    <?php
                        }
                        if(array_key_exists('RP', $this->role_permissions) && $this->role_permissions['RP']['view_perm'] == 1)
                        {
                            ?>
                            <li>
                                <a href="#sidebarReport" data-toggle="collapse">
                                    <i class="mdi mdi-chart-bar"></i>
                                    <span> Reports </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarReport">
                                    <ul class="nav-second-level">
                                        <?php
                                            if(array_key_exists('CADRP', $this->role_permissions) && $this->role_permissions['CADRP']['view_perm'] == 1)
                                            {
                                        ?>
                                                <li class="<?php echo $this->uri->segment(1) == 'reports' && $this->uri->segment(2) == '' ? 'menuitem-active' : '';?>">
                                                    <a href="<?php echo base_url();?>reports">CAD Report</a>
                                                </li>   
                                                <li class="<?php echo $this->uri->segment(2) == 'status_report' ? 'menuitem-active' : '';?>">
                                                    <a href="<?php echo base_url();?>reports/status_report">CAD Status Report</a>
                                                </li> 


                                                <li class="<?php echo $this->uri->segment(1) == 'design_no_report' ? 'menuitem-active' : '';?>">
                                                    <a href="<?php echo base_url();?>design_no_report">CAD Design Report</a>
                                                </li>  

                                                <li class="<?php echo $this->uri->segment(2) == 'cad_production' ? 'menuitem-active' : '';?>">
                                                    <a href="<?php echo base_url();?>reports/cad_production">CAD Production Report</a>
                                                </li>     

                                                <li class="<?php echo $this->uri->segment(1) == 'STL_Report' ? 'menuitem-active' : '';?>">
                                                    <a href="<?php echo base_url();?>STL_Report">STL Report</a>
                                                </li> 
                                          
                                        <?php
                                            }

                                            if(array_key_exists('RERP', $this->role_permissions) && $this->role_permissions['RERP']['view_perm'] == 1)
                                            {
                                        ?>
                                                <li class="<?php echo $this->uri->segment(1) == 'render_reports' && $this->uri->segment(2) == '' ? 'menuitem-active' : '';?>">
                                                    <a href="<?php echo base_url();?>render_reports">Render Report</a>
                                                </li> 
                                                <li class="<?php echo $this->uri->segment(2) == 'render_status_report' ? 'menuitem-active' : '';?>">
                                                    <a href="<?php echo base_url();?>render_reports/render_status_report">Render Status Report</a>
                                                </li>    
                                                <li class="<?php echo $this->uri->segment(2) == 'render_production' || $this->uri->segment(2) == 'detailed_report' ? 'menuitem-active' : '';?>">
                                                    <a href="<?php echo base_url();?>render_reports/render_production">Render Production Report</a>
                                                </li> 
                                        <?php
                                            }
                                            
                                            
                                        ?>

                                        <!-- <li class="<?php echo $this->uri->segment(1) == 'style_designer_timing' ? 'menuitem-active' : '';?>">
                                            <a href="<?php echo base_url();?>style_designer_timing">Style - Designer Wise Timing</a>
                                        </li>

                                        <li class="<?php echo $this->uri->segment(1) == 'designer_dept_comp' ? 'menuitem-active' : '';?>">
                                            <a href="<?php echo base_url();?>designer_dept_comp">Designer wise - Department wise</a>
                                        </li>

                                        <li class="<?php echo $this->uri->segment(1) == 'style_dep_comp' ? 'menuitem-active' : '';?>">
                                            <a href="<?php echo base_url();?>style_dep_comp">Style Wise  - Department wise - Timing report</a>
                                        </li> -->                                       

                                    </ul>
                                </div>
                            </li>
                    <?php
                        }
                    ?>
                </ul>

            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->
