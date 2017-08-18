<!doctype html>
<html>
    <head>
        <title>First Page</title>
    </head>
    <body>
        <!-- render server content here -->
        <?php foreach($layout_data as $layout) { ?>
            <?php echo $layout['markup']; ?>
        <?php } ?>

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
