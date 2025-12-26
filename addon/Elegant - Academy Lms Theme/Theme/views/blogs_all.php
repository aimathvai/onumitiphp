<section class="mt-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 g-4">
                    <div class="col-12 d-flex mb-2">
                        <div class="text-right pt-1 w-100">
                            <?php if(isset($search_string) || isset($_GET['category'])):
                                echo site_phrase('total').' '.$total_rows.' '.site_phrase('results');
                            else:
                                echo site_phrase('total').' '.$total_rows.' '.site_phrase('blogs');
                            endif; ?>
                        </div>
                    </div>
                    <?php foreach($blogs->result_array() as $blog): ?>
                        <?php $user_details = $this->user_model->get_all_user($blog['user_id'])->row_array(); ?>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                            <div class="box_list card radius-10" style="margin-bottom: 30px;">
                                <?php $blog_thumbnail = 'uploads/blog/thumbnail/'.$blog['thumbnail']; ?>
                                <?php if(file_exists($blog_thumbnail) && is_file($blog_thumbnail)): ?>
                                    <img src="<?php echo base_url($blog_thumbnail); ?>" class="card-img-top radius-top-10" alt="<?php echo $blog['title']; ?>">
                                <?php else: ?>
                                    <img src="<?php echo base_url('uploads/blog/thumbnail/placeholder.png'); ?>" class="card-img-top radius-top-10" alt="<?php echo $blog['title']; ?>">
                                <?php endif; ?>
                                <div class="card-body pt-4">
                                    <p class="card-text">
                                        <small class="text-muted"><?php echo site_phrase('created_by'); ?> - <a href="<?php echo site_url('home/instructor_page/'.$blog['user_id']); ?>"><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></a></small>
                                    </p>
                                    <h5 class="card-title"><a href="<?php echo site_url('blog/details/'.slugify($blog['title']).'/'.$blog['blog_id']); ?>"><?php echo $blog['title']; ?></a></h5>
                                    <p class="card-text ellipsis-line-3">
                                        <?php echo strip_tags(htmlspecialchars_decode($blog['description'])); ?>
                                    </p>
                                    
                                    <a class="fw-600" href="<?php echo site_url('blog/details/'.slugify($blog['title']).'/'.$blog['blog_id']); ?>"><?php echo site_phrase('more_details'); ?></a>
                                    
                                    <p class="card-text mt-2 mb-0">
                                        <small class="text-muted text-12px"><?php echo site_phrase('published'); ?> - <?php echo get_past_time($blog['added_date']); ?></small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if(!$total_rows): ?>
                        <div class="col-md-12 py-5 my-5 text-center">
                            <h5 class="text-muted"><?php echo site_phrase('no_data_found'); ?>!</h5>
                            <p class="text-13px text-muted"><?php echo site_phrase('search_again_with_something_else'); ?></p>
                        </div>
                    <?php endif; ?>
                    <div class="col-12">
                        <div class="col-12">
                            <nav><?php echo $this->pagination->create_links(); ?></nav>
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="col-lg-3 py-3 radius-10 bg-white" style="box-shadow: 0px 3px 8px 0px rgb(0 0 0 / 10%);">
                <?php include "blog_sidebar.php"; ?>
            </div>
        </div>
    </div>
</section>