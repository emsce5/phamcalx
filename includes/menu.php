    <!-- Bootstrap core CSS -->
    <link href="bs/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="bs/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bs/css/theme.css" rel="stylesheet">

    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body role="document">

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
        <!--hamburger button: ie when on mobile app pulls the dropdown over-->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">TM Calc</a>
        </div>
        <!--Makes menu responsive to hamburger button, allows the menu to show up in the hamburger button-->
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            
            <li <?php if (basename ($_SERVER['SCRIPT_NAME'])== "pv_enter.php") 
				echo "class=\"active\""; ?>>
				<a href="pv_enter.php">Plasma Volume</a>
			</li>
				
            <li 
				<?php if (basename ($_SERVER['SCRIPT_NAME'])== "rce_post_tx_enter.php" || basename ($_SERVER['SCRIPT_NAME'])== "partial_manual_enter.php" || basename ($_SERVER['SCRIPT_NAME'])== "uab_partial_manual_enter.php" || basename ($_SERVER['SCRIPT_NAME'])=="rce_xchange_vol_calc_enter.php" || basename ($_SERVER['SCRIPT_NAME'])=="auto_rce_dilution_enter.php") echo "class=\"active\""; ?>>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Red Blood Cell Transfusion/Exchange <span class= "caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="rce_post_tx_enter.php">Post Simple Transfusion</a></li>
                  <li><a href="partial_manual_enter.php">Partial Manual Exchange</a></li>
                  <li><a href="rce_xchange_vol_calc_enter.php">Automated Red Cell Exchange</a></li>
                  <li><a href="auto_rce_dilution_enter.php">Automated Isovolemic Hemodilution</a></li>
                </ul>
            </li>
           
           <li
				<?php if (basename ($_SERVER['SCRIPT_NAME'])=="inr_enter.php" || basename ($_SERVER['SCRIPT_NAME'])=="vp_enter.php") echo "class=\"active\""; ?>>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Plasma Transfusion<span class= "caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="inr_enter.php">INR following Plasma Transfusion</a></li>
                  <li><a href="vp_enter.php">Volume of Plasma Required to Obtain a Goal INR</a></li>
                </ul>
            </li>

            <li <?php if (basename ($_SERVER['SCRIPT_NAME'])== "cci_enter.php") 
				echo "class=\"active\""; ?>>
				<a href="cci_enter.php">CCI Calculator</a>
			</li>

            <li><a href="#" data-toggle="modal" data-target="#under_const">Coagulation Factors</a></li>

            <li <?php if (basename ($_SERVER['SCRIPT_NAME'])== "contact.php") 
				echo "class=\"active\""; ?>><a href="contact.php">Contact</a>
			</li>

          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!--Under Construction Modal -->
    <div id="under_const" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class= "modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Coagulation Factor Calculations</h4>
          </div>
          <div class="modal-body">
          This site is under construction-please check back later!
          </div>
          <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
        </div>
      </div>
    </div>
