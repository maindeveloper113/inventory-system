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
	
	<script>
	var validator = new FormValidator('add_user', [{
    name: 'email',
    rules: 'valid_email',
    depends: function() {
        return Math.random() > .5;
    }
	}, {
    name: 'alphanumeric',
    rules: 'alpha_numeric'
	}, {
    name: 'password',
    rules: 'required'
	}, {
    name: 'confirm_password',
    display: 'password confirmation',
    rules: 'required|matches[password]'
	}, {
    name: 'full_name',
    display: 'required',
    rules: 'required'
}], function(errors, event) {
    if (errors.length > 0) {
        // Show the errors
    }
});
	</script>
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
						<!--
                        <li><a class="ajax-link" href="form.html"><i
                                    class="glyphicon glyphicon-edit"></i><span> Forms</span></a></li>
                        <li><a class="ajax-link" href="chart.html"><i class="glyphicon glyphicon-list-alt"></i><span> Charts</span></a>
                        </li>
                        <li><a class="ajax-link" href="typography.html"><i class="glyphicon glyphicon-font"></i><span> Typography</span></a>
                        </li>
                        <li><a class="ajax-link" href="gallery.html"><i class="glyphicon glyphicon-picture"></i><span> Gallery</span></a>
                        </li>
                        <li class="nav-header hidden-md">Sample Section</li>
                        <li><a class="ajax-link" href="table.html"><i
                                    class="glyphicon glyphicon-align-justify"></i><span> Tables</span></a></li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-plus"></i><span> Accordion Menu</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Child Menu 1</a></li>
                                <li><a href="#">Child Menu 2</a></li>
                            </ul>
                        </li>
                        <li><a class="ajax-link" href="calendar.html"><i class="glyphicon glyphicon-calendar"></i><span> Calendar</span></a>
                        </li>
                        <li><a class="ajax-link" href="grid.html"><i
                                    class="glyphicon glyphicon-th"></i><span> Grid</span></a></li>
                        <li><a href="tour.html"><i class="glyphicon glyphicon-globe"></i><span> Tour</span></a></li>
                        <li><a class="ajax-link" href="icon.html"><i
                                    class="glyphicon glyphicon-star"></i><span> Icons</span></a></li>
                        <li><a href="error.html"><i class="glyphicon glyphicon-ban-circle"></i><span> Error Page</span></a>
                        </li>
                        <li><a href="login.html"><i class="glyphicon glyphicon-lock"></i><span> Login Page</span></a>
                        </li>
						-->
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
        <h2><i class="glyphicon glyphicon-user"></i> add new user</h2>
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
	
		<form name="add_user" action="<?php echo base_url('index.php/admin/add_new_user'); ?>" method="post">
			<div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input name="email" type="email" class="form-control" id="email" placeholder="Enter email" required >
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="Password" required>
                    </div>
					<!--
					<div class="form-group">
                        <label for="exampleInputPassword1">ConfirmPassword</label>
                        <input name="confirm_password" type="password" class="form-control" id="confirm_password" placeholder="ConfirmPassword" matches[password]>
                    </div>
					-->
					<div class="form-group">
                        <label for="exampleInputEmail1">Full Name</label>
                        <input name="full_name" type="text" class="form-control" id="full_name" placeholder="Enter Full name" required>
                    </div>
                    <div class="control-group">
                    <label class="control-label" for="selectError">Level Select</label>

                    <div class="controls">
                        <select name= "user_level" id="selectError" data-rel="chosen">
                            <option value=0>user</option>
                            <option value=1>admin</option>
                           
                        </select>
                    </div>
                </div>
                    <button type="submit" class="btn btn-default" style="margin-top:20px" onclick="check_validation()">Submit</button>
		</form>
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

<script src="<?php echo base_url('bower_components/bootstrap/dist/js/jquery.validate.min'); ?>"></script>
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
