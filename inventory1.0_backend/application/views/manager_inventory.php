<!DOCTYPE html>
<html lang="en">
<head>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <meta charset="utf-8">
    <title>inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Muhammad Usman">

    <!-- The styles -->
    <link id="bs-css" href="<?php echo base_url('css/bootstrap-cerulean.min.css'); ?>" rel="stylesheet">

    <link href="<?php echo base_url('css/charisma-app.css'); ?>" rel="stylesheet">
    <link href='<?php echo base_url("bower_components/fullcalendar/dist/fullcalendar.css"); ?>' rel='stylesheet'>
    <link href='<?php echo base_url("bower_components/fullcalendar/dist/fullcalendar.print.css"); ?>' rel='stylesheet' media='print'>
    <link href='<?php echo base_url("bower_components/chosen/chosen.min.css"); ?>' rel='stylesheet'>
    <link href='<?php echo base_url("bower_components/colorbox/example3/colorbox.css"); ?>' rel='stylesheet'>
    <link href='<?php echo base_url("bower_components/responsive-tables/responsive-tables.css"); ?>' rel='stylesheet'>
    <link href='<?php echo base_url("bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css"); ?>' rel='stylesheet'>
    <link href='<?php echo base_url("css/jquery.noty.css"); ?>' rel='stylesheet'>
    <link href='<?php echo base_url("css/noty_theme_default.css"); ?>' rel='stylesheet'>
    <link href='<?php echo base_url("css/elfinder.min.css"); ?>' rel='stylesheet'>
    <link href='<?php echo base_url("css/elfinder.theme.css"); ?>' rel='stylesheet'>
    <link href='<?php echo base_url("css/jquery.iphone.toggle.css"); ?>' rel='stylesheet'>
    <link href='<?php echo base_url("css/uploadify.css"); ?>' rel='stylesheet'>
    <link href='<?php echo base_url("css/animate.min.css"); ?>' rel='stylesheet'>

    <!-- jQuery -->
    <script src="<?php echo base_url('bower_components/jquery/jquery.min.js'); ?>"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="<?php echo base_url('img/favicon.ico'); ?>">

</head>

<body>
    <!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">

        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img alt="Charisma Logo" src="<?php echo base_url('img/itsupport.png'); ?>" width="100" height="40" style="margin-left:20px; margin-top:10px" />

            

            

            

        </div>
    </div>
    <!-- topbar ends -->
<div class="ch-container">
    <div class="row">
        
        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">Main</li>
                        <li><a class="ajax-link" href="<?php echo base_url('index.php/admin/users'); ?>"><i class="glyphicon glyphicon-home"></i><span> manager users</span></a>
                        </li>
                        <li><a class="ajax-link" href="<?php echo base_url('index.php/admin/invantories'); ?>"><i class="glyphicon glyphicon-eye-open"></i><span> manager inventory</span></a>
                        </li>
						<li><a class="ajax-link" href="<?php echo base_url('index.php/login/logout'); ?>"><i class="glyphicon glyphicon-eye-close"></i><span> logout</span></a>
                        </li>
						
                    </ul>
					<!--
                    <label id="for-is-ajax" for="is-ajax"><input id="is-ajax" type="checkbox"> Ajax on menu</label>
					-->
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <div>
	<!--
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Dashboard</a>
        </li>
    </ul>
	-->
</div>
<div class=" row">
    <div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-user"></i> manager inventory</h2>
		<!--
        <div class="box-icon">
            <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
		-->
    </div>
    <div class="box-content">
    <!--
	<div class="alert alert-info">For help with such table please check <a href="http://datatables.net/" target="_blank">http://datatables.net/</a></div>
	-->
	<div style="margin-bottom:60px;">
	<form class="navbar-search pull-left" style="margin-left:400px;" action="<?php echo base_url('index.php/admin/invantories'); ?>" method="get">
                        <input name="searchkey" placeholder="Search" class="search-query form-control col-md-10" name="query"
                               type="text">
					
    </form>
	

                    
       
                   
    </div>
				

    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
		<th>photo</th>
        <!--<th>name</th>-->
		<th>serial_number</th>
        <th>description</th>
		<th>location</th>
		<th>quantity</th>
		<th>remark</th>
        <th>part_number</th>
		<th>register_time</th>
		<th>register_username</th>
		<th>remove_time</th>
		<th>remove_username</th>
		<th>action</th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($inventories as $item) { ?>
    <tr>
		<td><img src="<?php echo base_url('img/inventory/'.$item->inventory_id.'.jpg'); ?>" style="width:50px;"></td>
		<td class="center"><?php echo $item->serial_number; ?></td>
		<td ><?php echo $item->description; ?></td>
        <td class="center"><?php echo $item->location; ?></td>
		<td class="center"><?php echo $item->inventory_count; ?></td> 
		<td class="center"><?php echo $item->remark; ?></td>
        <td class="center"><?php echo $item->part_number; ?></td>
		<td><?php echo $item->register_time; ?></td>
		<td><?php echo $item->register_username; ?></td>
		<td><?php echo $item->remove_time; ?></td>
		<td><?php echo $item->remove_username; ?></td>
        <td class="center">
			<a class="btn btn-info" href="<?php echo base_url('index.php/admin/edit_inventory/'.$item->inventory_id); ?>">
                <i class="glyphicon glyphicon-edit icon-white"></i>
                Edit
            </a>
            <a class="btn btn-danger" href="<?php echo base_url('index.php/admin/delete_inventory/'.$item->inventory_id); ?>" onclick="return confirm('Are you sure want to delete?')">
                <i class="glyphicon glyphicon-trash icon-white"></i>
                Delete
            </a>
        </td>
    </tr>
	<?php } ?>
	
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->

</div>


    <footer class="row">
        <p class="col-md-9 col-sm-9 col-xs-12 copyright">&copy; <a href="http://usman.it" target="_blank"></a> 2016</p>
		<!--
        <p class="col-md-3 col-sm-3 col-xs-12 powered-by">Powered by: <a
                href="http://usman.it/free-responsive-admin-template"></a></p>
		-->
    </footer>

</div><!--/.fluid-container-->

<!-- external javascript -->

<script src="<?php echo base_url('bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>

<!-- library for cookie management -->
<script src="<?php echo base_url('js/jquery.cookie.js'); ?>"></script>

<!-- calender plugin -->
<script src='<?php echo base_url("bower_components/moment/min/moment.min.js"); ?>'></script>
<script src='<?php echo base_url("bower_components/fullcalendar/dist/fullcalendar.min.js"); ?>'></script>
<!-- data table plugin -->
<script src='<?php echo base_url("js/jquery.dataTables.min.js"); ?>'></script>

<!-- select or dropdown enhancer -->
<script src="<?php echo base_url('bower_components/chosen/chosen.jquery.min.js'); ?>"></script>
<!-- plugin for gallery image view -->
<script src="<?php echo base_url('bower_components/colorbox/jquery.colorbox-min.js'); ?>"></script>
<!-- notification plugin -->
<script src="<?php echo base_url('js/jquery.noty.js'); ?>"></script>
<!-- library for making tables responsive -->
<script src="<?php echo base_url('bower_components/responsive-tables/responsive-tables.js'); ?>"></script>
<!-- tour plugin -->
<script src="<?php echo base_url('bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js'); ?>"></script>

<!-- star rating plugin -->
<script src="<?php echo base_url('js/jquery.raty.min.js'); ?>"></script>
<!-- for iOS style toggle switch -->
<script src="<?php echo base_url('js/jquery.iphone.toggle.js'); ?>"></script>
<!-- autogrowing textarea plugin -->
<script src="<?php echo base_url('js/jquery.autogrow-textarea.js'); ?>"></script>
<!-- multiple file upload plugin -->
<script src="<?php echo base_url('js/jquery.uploadify-3.1.min.js'); ?>"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="<?php echo base_url('js/jquery.history.js'); ?>"></script>
<!-- application script for Charisma demo -->
<!-- <script src="<?php echo base_url('js/charisma.js'); ?>"></script> -->


</body>
</html>
