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
                       
                        <li><a class="ajax-link" href="<?php echo base_url('index.php/user/invantories'); ?>"><i class="glyphicon glyphicon-eye-open"></i><span> manager inventory</span></a>
                        </li>
						<li><a class="ajax-link" href="<?php echo base_url('index.php/login/logout'); ?>"><i class="glyphicon glyphicon-eye-close"></i><span> logout</span></a>
                        </li>
						
                    </ul>
					
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
	
</div>
<div class=" row">
    <div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class=" glyphicon glyphicon-pencil"></i> update inventory</h2>
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
		<img src="<?php echo (base_url('img/inventory/'.$inventory->inventory_id.'.jpg')); ?>" style="margin-bottom:30px;">
		<form name="add_user" action="<?php echo base_url('index.php/user/update_inventory/'.$inventory->inventory_id); ?>" method="post">
					
                    <div class="form-group">
                        <label for="exampleInputPassword1">Serial number</label>
                        <input name="serial_number"  class="form-control" id="serial_number" placeholder="Enter serial number" value="<?php echo $inventory->serial_number; ?>" readonly>
                    </div>

					<div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <input name="description" type="text" class="form-control" id="description" list="descriptionname"  value="<?php echo $inventory->description; ?>" required>
						<datalist id="descriptionname">
						<?php foreach ($descriptions as $item) { ?>
						  <option value="<?php echo $item->description; ?>" >
						  <?php } ?>
						</datalist>		
					</div>

					<div class="form-group">
                        <label for="exampleInputEmail1">Location</label>
                        <input name="location" type="text" class="form-control" id="location" list="locationname"  value="<?php echo $inventory->location; ?>" required>
						<datalist id="locationname">
						<?php foreach ($locations as $item) { ?>
						  <option value="<?php echo $item->location; ?>" >
						  <?php } ?>
						</datalist>		
					</div>
					
					<div class="form-group">
                        <label for="exampleInputEmail1">Quantity</label>
                        <input name="quantity"  class="form-control" id="quantity" placeholder="" value="<?php echo $inventory->quantity; ?>"  readonly>
                    </div>
					
					<div class="form-group">
                        <label for="exampleInputEmail1">Remark</label>
                        <input name="remark" type="text" class="form-control" id="remark" list="remarkname"  value="<?php echo $inventory->remark; ?>" >
								
					</div>
					<div class="form-group">
                        <label for="exampleInputEmail1">Part number</label>
                        <input name="part_number"  class="form-control" id="part_number" placeholder="Enter part number" value="<?php echo $inventory->part_number; ?>"  readonly>
                    </div>
					

					
					
					 <div class="form-group">
                        <label for="exampleInputPassword1">Registered time</label>
                        <input name="register_time"  class="form-control" id="regiister_time"  value="<?php echo $inventory->register_time; ?>" readonly>
                    </div>
		
					<div class="form-group">
                        <label for="exampleInputEmail1">Registered user</label>
                         <input name="register_username"  class="form-control" id="regiister_username"  value="<?php echo $inventory->register_username; ?>" readonly>
						 <input type="hidden" name="register_userid"  class="form-control" id="regiister_userid"  value="<?php echo $inventory->register_userid; ?>" >
					</div>

					 	 <input type="hidden" name="remove_userid"  class="form-control" id="remove_userid"  value="<?php echo $inventory->remove_userid; ?>" >

					

                   
                    <button type="submit" class="btn btn-default" style="margin-top:10px" onclick="check_validation()">Submit</button>
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
