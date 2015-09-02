<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/4/13
 * Time: 4:11 PM
 */


?>

<!DOCTYPE html>
<html>

    <head>
        <title><?php echo $title; ?></title>
        <!-- meta data -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="description" content="<?php echo $description ?>" />
        <meta name="viewport" content="width=device-width">
        <meta name="keywords" content="<?php echo $keywords ?>" />
        <meta name="author" content="<?php echo $author ?>" />
        <link rel="shortcut icon" href="<?php echo base_url('resources/images/favicon.ico');?>" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url('resources/images/favicon.ico');?>" type="image/x-icon">
        <!-- end meta data -->

        <!-- Load font -->
    <?php foreach($codeboxr_font as $key => $font_name): ?>
        <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=<?php echo $font_name; ?>'>
    <?php endforeach; ?>

        <!-- Load stylesheet -->
    <?php foreach($codeboxr_css as $key => $css_file_name): ?>
        <link rel="stylesheet" href="<?php echo base_url('resources/css/'.$css_file_name.'.css');?>" />

    <?php endforeach; ?>
        <link rel="stylesheet" href="<?php echo base_url('resources/css/template.css');?>" />

            <script type="text/javascript">
                var site_url = '<?php echo $home_url; ?>';
                <?php if( isset( $set_tab_to_send_note ) ): ?>
                    var set_tab_to_send_note = <?php echo $set_tab_to_send_note; ?>;
                <?php endif; ?>
                <?php if( isset( $draggable_item ) and !empty( $draggable_item ) ): ?>
                    var draggableItem = <?php echo ($draggable_item); ?>;
                <?php endif; ?>

                <?php if( isset( $public_preview ) and $public_preview == true ): ?>
                    var public_preview = <?php echo ($public_preview); ?>;
                <?php endif; ?>

                <?php if( isset( $reply_preview ) and $reply_preview == true ): ?>
                    var reply_preview = <?php echo ($reply_preview); ?>;
                <?php endif; ?>

                <?php if( isset( $state_list ) and !empty( $state_list ) ): ?>
                    var json_state_list = <?php echo $state_list; ?>;
                <?php endif; ?>

                <?php if( isset( $edit_note_preview ) and $edit_note_preview == true ): ?>
                var edit_note_preview = <?php echo ($edit_note_preview); ?>;
                <?php endif; ?>
                <?php if( isset( $set_tab_to_preview_note ) and $set_tab_to_preview_note == true ): ?>
                var set_tab_to_preview_note = <?php echo ($set_tab_to_preview_note); ?>;
                <?php endif; ?>




                <?php if( isset($note_json_form_options) and $note_json_form_options != '' ): ?>
                    var cnote_info = <?php echo ($note_json_form_options); ?>;
                <?php else: ?>
                    var cnote_info = {};
                    cnote_info.last_group_id = 1;
                ////console.log(cnote_info);
                <?php endif; ?>
            </script>

        <!-- Load Javascript -->
        <?php foreach($codeboxr_js as $key => $js_file_name): ?>
            <script type="text/javascript" src="<?php echo base_url('resources/js/'.$js_file_name.'.js');?>"></script>
        <?php endforeach; ?>
        <!--link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"-->
    </head>

    <body>
        <?php echo $codeboxr_main_body; ?>
    </body>

</html>