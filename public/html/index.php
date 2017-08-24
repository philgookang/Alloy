<!DOCTYPE html>
<html lang="en">
	<head>
        <!-- Page Encoding -->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta charset="UTF-8"/>

        <!-- Page Title -->
        <title>Hello</title>

        <!--Page Style-->
        <link href="https://fonts.googleapis.com/css?family=Architects+Daughter" rel="stylesheet"/>
        <style>
            @charset "utf-8";
            *{
                margin:0;
                padding:0
            }
            html, body {
                font-family: 'Architects Daughter', cursive;
                margin:0;
                padding:0;
                border:0;
                width:100%;
                height:100%;
                text-align: center;
                background-color: #FF851B;
            }
            center {
                display: block;
                padding-top: 200px;
            }
            .happy {
                display: block;
                text-align: center;
                font-size: 120px;
                color: #fff;
                vertical-align: middle;
                -webkit-transform: rotate(90deg);
                -moz-transform: rotate(90deg);
                -ms-transform: rotate(90deg);
                -o-transform: rotate(90deg);
                transform: rotate(90deg);
                height: 120px;
                width: 115px;
                box-sizing: border-box;
            }
            .name {
                margin: 0 auto;
                display: inline-block;
                text-align: center;
                font-size: 40px;
                color: #fff;
            }
        </style>
	</head>
	<body>
		<div id="root">
		</div>

		<!-- render server content here -->
		<?php /* ?>
		<?php foreach($layout_data as $layout) { ?>
			<?php echo $layout['markup']; ?>
		<?php } ?>
		<?php */ ?>

		<!-- load react and app code -->
        <?php /*
        <script src="./public/js/generate/react.min.js"></script>
        */ ?>
        <script src="./public/js/generate/react-bundle.min.js"></script>
        <?php foreach($layout_data as $layout) { ?>
            <script src="<?php echo $layout['src']; ?>"></script>
        <?php } ?>


        <!-- render server content here -->
        <?php foreach($layout_data as $layout) { ?>
            <?php echo $layout['js']; ?>
        <?php } ?>
    </body>
</html>
