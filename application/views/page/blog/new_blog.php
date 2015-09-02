<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 11/5/13
 * Time: 1:37 PM
 */

$this->load->view('include/doctype');
$this->load->view('include/header');

?>

<section class="new-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="well blog-well">
                    <div class="blog">
                        <form role="form" action="" method="post">
                            <div class="new-blog">
                                <?php if(isset($blog_post_error) and !empty($blog_post_error)): ?>
                                <div class="new-blog-error"><div class="alert alert-danger"><?php echo $blog_post_error; ?></div></div>
                                <?php endif; ?>
                                <?php echo form_error('blog_title', '<div class="new-blog-error"><div class="alert alert-danger">', '</div></div>'); ?>
                                <?php echo form_error('blog_description', '<div class="new-blog-error"><div class="alert alert-danger">', '</div></div>'); ?>
                                <div class="new-blog-area">

                                    <div class="form-group">
                                        <label for="blog-title">Blog Title</label>
                                        <input type="text" name="blog_title" value="<?php echo set_value('blog_title'); ?>" class="form-control input-lg" id="blog-title" placeholder="Blog Title">
                                    </div>

                                    <div class="form-group">
                                        <label for="blog-description">Blog Content</label>
                                        <textarea name="blog_description" class="form-control input-lg" id="blog-description" rows="7"><?php echo set_value('blog_description'); ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Publish</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>