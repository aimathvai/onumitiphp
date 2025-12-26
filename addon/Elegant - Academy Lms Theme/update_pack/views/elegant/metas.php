<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="author" content="<?php echo get_settings('author') ?>" />

<?php
$seo_pages = array('course_page');
if (in_array($page_name, $seo_pages)):
	$course_details = $this->crud_model->get_course_by_id($course_id)->row_array();?>
	<meta name="keywords" content="<?php echo $course_details['meta_keywords']; ?>"/>
	<meta name="description" content="<?php echo $course_details['meta_description']; ?>" />
<?php elseif($page_name == 'blog_details'): ?>
	<meta name="keywords" content="<?php echo $blog_details['keywords']; ?>"/>
	<meta name="description" content="<?php echo ellipsis(strip_tags(htmlspecialchars_decode($blog_details['description'])), 140); ?>" />
<?php elseif($page_name == 'blogs'): ?>
	<meta name="keywords" content="<?php echo get_settings('website_keywords'); ?>"/>
	<meta name="description" content="<?php echo get_frontend_settings('blog_page_subtitle'); ?>" />
<?php else: ?>
	<meta name="keywords" content="<?php echo get_settings('website_keywords'); ?>"/>
	<meta name="description" content="<?php echo get_settings('website_description'); ?>" />
<?php endif; ?>

<!--Social sharing content-->
<?php if($page_name == "course_page"): ?>
	<meta property="og:title" content="<?php echo $course_details['title']; ?>" />
	<meta property="og:image" content="<?php echo $this->crud_model->get_course_thumbnail_url($course_id); ?>">
<?php elseif($page_name == 'blog_details'): ?>
	<meta property="og:title" content="<?php echo $blog_details['title']; ?>" />
	<?php $blog_banner = 'uploads/blog/banner/'.$blog_details['banner']; ?>
    <?php if(!file_exists($blog_banner) || !is_file($blog_banner)): ?>
        <?php $blog_banner = 'uploads/blog/banner/placeholder.png'; ?>
    <?php endif; ?>
	<meta property="og:image" content="<?php echo base_url($blog_banner); ?>">
<?php elseif($page_name == 'blogs'): ?>
	<meta property="og:title" content="<?php echo get_frontend_settings('blog_page_title'); ?>" />
	<meta property="og:image" content="<?php echo site_url('uploads/blog/page-banner/'.get_frontend_settings('blog_page_banner')); ?>">
<?php else: ?>
	<meta property="og:title" content="<?php echo $page_title; ?>" />
	<meta property="og:image" content="<?= base_url("uploads/system/".get_frontend_settings('banner_image')); ?>">
<?php endif; ?>
<meta property="og:url" content="<?php echo current_url(); ?>" />
<!--Social sharing content-->