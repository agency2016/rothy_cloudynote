<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/5/13
 * Time: 12:29 PM
 */


$this->load->view('include/doctype');
$this->load->view('include/header');
?>

<section class="blog-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="well blog-well">
                    <div class="blog">
                        <?php if($blog_post_success = $this->session->flashdata('blog_post_success')): ?>
                        <div class="single-blog">
                            <div class="alert alert-success"><?php echo $blog_post_success; ?></div>
                        </div>
                        <?php endif; ?>
                        <?php
                            if(isset($post_list) and is_array($post_list)):
                                foreach($post_list as $list):
                        ?>
                        <div class="single-blog">
                            <div class="blog-single-title"><h1><?php echo $list['title']; ?></h1></div>
                            <div class="blog-single-content"><?php echo $list['description']; ?></div>
                        </div>
                        <?php
                                endforeach;
                            endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>