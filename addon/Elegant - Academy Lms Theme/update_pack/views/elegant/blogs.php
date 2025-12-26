<section id="hero_in" class="courses start_bg_zoom">
    <div style="background: url(<?php echo site_url('uploads/blog/page-banner/'.get_frontend_settings('blog_page_banner')); ?>) center center no-repeat;" class="banner-img"></div>
    <div class="wrapper">
        <div class="container">
            <h1 class="fadeInUp animated"><span></span><?php echo get_frontend_settings('blog_page_title'); ?></h1>
            <p class="w-100">
                <small style="color: #d3d3d3;"><?php echo get_frontend_settings('blog_page_subtitle'); ?></small>
            </p>
        </div>
    </div>
</section>

<?php include $included_page; ?>