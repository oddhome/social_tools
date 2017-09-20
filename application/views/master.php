<?php
    $asset_url = base_url(). 'assets/startbootstrap-sb-admin-2-gh-pages';
    if (!isset($options['top_bar']))
    {
        $options['top_bar'] = true;
    }

    if (!isset($options['left_side_bar']))
    {
        $options['left_side_bar'] = true;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo $asset_url; ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo $asset_url; ?>/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo $asset_url; ?>/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo $asset_url; ?>/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo $asset_url; ?>/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script src="<?php echo $asset_url; ?>/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $asset_url; ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php if ($options['left_side_bar']==true) { ?>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Social Tools</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- Top Menu -->
            </ul>
            <?php } ?>
            <!-- /.navbar-top-links -->
            <?php if ($options['left_side_bar']==true) { ?>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <?php 
                            $data = array();
                            echo $this->load->view('left_menu',$data,true); 
                        ?>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <?php } ?>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php if (isset($title)) { echo $title; } else { echo "Social Tools"; } ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <?php if (isset($content)) { echo $content; } ?>

            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo $asset_url; ?>/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo $asset_url; ?>/vendor/raphael/raphael.min.js"></script>
    <script src="<?php echo $asset_url; ?>/vendor/morrisjs/morris.min.js"></script>
    <script src="<?php echo $asset_url; ?>/data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo $asset_url; ?>/dist/js/sb-admin-2.js"></script>

</body>

</html>
