     <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">SB Admin v2.0</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i><?php echo $accemail;?><i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                    <li><a href="<?php echo base_url()."index.php/dashboard/logout";?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
<!--
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                        </li>
-->
                        <li>
                        <a href="<?php echo base_url();?>" <?php echo $navbar==1?"class='active'":" "?>><i class="fa fa-dashboard fa-fw"></i>概况</a>
                        </li>
                        <li class="active">
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> 媒体商<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url();?>index.php/dashboard/statitic" <?php echo $navbar==2?"class='active'":" "?>>统计信息</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>index.php/dashboard/adpos"  <?php echo $navbar==3?"class='active'":" "?> >广告位置</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>index.php/dashboard/revenue" <?php echo $navbar==4?"class='active'":" "?>>收益优化</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>index.php/dashboard/payments" <?php echo $navbar==5?"class='active'":" "?>>付款记录</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url();?>index.php/dashboard/pidlist" <?php echo $navbar==6?"class='active'":" "?>>PID管理</a>
                                    <!--
                                    <a href="<?php echo base_url();?>index.php/dashboard/subagents" <?php echo $navbar==6?"class='active'":" "?>>二级渠道</a> 
                                    -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
<!--
                        <li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                        </li>
-->

                        <li>
                            <a href="<?php echo base_url();?>index.php/dashboard/agents" <?php echo $navbar==7?"class='active'":" "?>><i class="fa fa-sitemap fa-fw"></i> 代理商</span></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url();?>index.php/dashboard/settings" <?php echo $navbar==8?"class='active'":" "?>><i class="fa fa-wrench fa-fw"></i> 设置</span></a>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

