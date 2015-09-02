<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/4/13
 * Time: 4:14 PM
 */

?>

            <footer id="footer">
        </footer>

        <!-- Load stylesheet -->
    <?php foreach($codeboxr_inject_css_after_footer as $key => $css_file_name): ?>
        <link rel="stylesheet" href="<?php echo base_url('resources/css/'.$css_file_name.'.css');?>">
    <?php endforeach; ?>

        <!-- Load Javascript -->
    <?php foreach($codeboxr_inject_js_after_footer as $key => $js_file_name): ?>
        <link rel="stylesheet" href="<?php echo base_url('resources/js/'.$js_file_name.'.js');?>">
    <?php endforeach; ?>

    </body>
</html>