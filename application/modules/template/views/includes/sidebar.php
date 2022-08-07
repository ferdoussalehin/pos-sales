<nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <img alt="image" class="rounded-circle" src="<?php echo base_url(); ?>assets/admin/img/profile_small.jpg"/>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold">Admin</span>
                            <span class="text-muted text-xs block">Admin<b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                            <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                            <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo base_url()?>dashboard/logout">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li class="active">
                    <a href="<?php echo base_url();?>dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span> </a>
                    
                </li>
                
                <li>
                    <a href="#"><i class="fa fa-barcode"></i> <span class="nav-label">Product</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?php echo base_url();?>product">Products</a></li>
                        <li><a href="">Import Product</a></li>
                        <li><a href="">Categories</a></li>
                        <li><a href="">Units</a></li>
                        <li><a href="">Quantity Adjustment</a></li>
                        <li><a href="">Count Stock</a></li>
                        
                    </ul>
                </li>

                <li>
                    <a href="#"><i class="fa fa-heart"></i> <span class="nav-label">Sales</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?= base_url() ?>pos/add">New Sale</a></li>
                        <li><a href="<?php echo base_url();?>pos/sales">POS Sales</a></li>
                        <li><a href="<?php echo base_url();?>sales">List Sales</a></li>
                        
                                                
                    </ul>
                </li>

                <li>
                    <a href="#"><i class="fa fa-star"></i> <span class="nav-label">Purchases</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="">Add Purchases</a></li>
                        <li><a href="">List Purchases</a></li>
                                              
                    </ul>
                </li>

                <li>
                    <a href="#"><i class="fa fa-heart-o"></i> <span class="nav-label">Quotations</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="">Add Quotations</a></li>
                        <li><a href="">List Quotations</a></li>
                                              
                    </ul>
                </li>

                <li>
                    <a href="#"><i class="fa fa-random"></i> <span class="nav-label">Return</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="">Add Return</a></li>
                        <li><a href="">List Return</a></li>
                                              
                    </ul>
                </li>

                <li>
                    <a href="#"><i class="fa fa-star-o"></i> <span class="nav-label">Transfer</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="">Add Transfer</a></li>
                        <li><a href="">List Transfer</a></li>
                                              
                    </ul>
                </li>
                
                <li>
                    <a href="#"><i class="fa fa-users"></i> <span class="nav-label">CRM</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        
                        <li><a href="<?php echo base_url() ?>customers">Customers</a></li>
                        <li><a href="<?php echo base_url() ?>suppliers">Suppliers</a></li>     
                        <li><a href="<?php echo base_url() ?>billers">Billers</a></li>                    
                    </ul>
                </li>
                
                <li>
                    <a href=""><i class="fa fa-info-circle"></i> <span class="nav-label">Notifications</span></a>
                </li>
                <li>
                    <a href=""><i class="fa fa-calendar"></i> <span class="nav-label">Calender</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Report</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="">Sales Report</a></li>
                        <li><a href="">Product Report</a></li>
                        <li><a href="">Product Quantity Alert</a></li>     
                        <li><a href="">Category Report</a></li>     
                        <li><a href="">Brand Report</a></li>  
                        <li><a href="">Daily Sale</a></li>  
                        <li><a href="">Monthly Sale</a></li>  
                        <li><a href="">Purchase Report</a></li>      
                        <li><a href="">Customer Report</a></li>  
                        <li><a href="">Supplier Report</a></li>  
                        <li><a href="">Expense Report</a></li>  
                        <li><a href="">Profit and/or Loss</a></li>             
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-cog"></i> <span class="nav-label">Settings</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="">System Setting</a></li>
                        <li><a href="<?php echo base_url('users') ?>">Users</a></li>
                        <li><a href="">Print Setting</a></li>
                        <li><a href="">POS Setting</a></li>     
                        <li><a href="">Change Logo</a></li> 
                        <li><a href="">Currency</a></li>         
                        <li><a href="">Customer Group</a></li>  
                        <li><a href="">Price Group</a></li>   
                        <li><a href="">Brand</a></li>                  
                    </ul>
                </li>

            </ul>

        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <!-- <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form> -->
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">Welcome Admin!</span>
                </li>

                <li>
                    <a class="btn tip" title="Settings" href="<?php echo base_url()?>settings">
                        <i class="fa fa-cogs"></i> 
                    </a>
                </li>
                
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html" class="dropdown-item">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="float-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html" class="dropdown-item">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>

                
                <li>
                    <a href="<?php echo base_url()?>dashboard/auth/logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            