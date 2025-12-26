<?php
isset($layout) ? "": $layout = "list";
isset($selected_category_id) ? "": $selected_category_id = "all";
isset($selected_level) ? "": $selected_level = "all";
isset($selected_language) ? "": $selected_language = "all";
isset($selected_rating) ? "": $selected_rating = "all";
isset($selected_price) ? "": $selected_price = "all";
// echo $selected_category_id.'-'.$selected_level.'-'.$selected_language.'-'.$selected_rating.'-'.$selected_price;
$number_of_visible_categories = 10;
if (isset($sub_category_id)) {
	$sub_category_details = $this->crud_model->get_category_details_by_id($sub_category_id)->row_array();
	$category_details     = $this->crud_model->get_categories($sub_category_details['parent'])->row_array();
	$category_name        = $category_details['name'];
	$sub_category_name    = $sub_category_details['name'];
}
	$banners = themeConfiguration(get_frontend_settings('theme'), 'banners');
	$courses_banner = $banners['courses_banner'];
?>


<section id="hero_in" class="courses">
	<div class="banner-img" style="background: url(<?php echo base_url($courses_banner); ?>) center center no-repeat;"></div>
	<div class="wrapper">
		<div class="container">
			<h1 class="fadeInUp"><span></span><?php echo site_phrase('online_courses'); ?></h1>
		</div>
	</div>
</section>
<!--/hero_in-->

<div class="filters_listing sticky_horizontal">
	<div class="container">
		<ul class="clearfix">
			<li>

			</li>
			<li>
				<div class="layout_view">
					<a href="javascript::" <?php if($layout == 'grid'): ?> class="active" <?php endif;?> onclick="toggleLayout('grid')"><i class="icon-th"></i></a>
					<a href="javascript::" <?php if($layout == 'list'): ?> class="active" <?php endif;?> onclick="toggleLayout('list')"><i class="icon-th-list"></i></a>
					<a href="<?php echo site_url('home/courses'); ?>"><i class="icon-arrows-cw"></i></a>
				</div>
			</li>
			<li>

			</li>
		</ul>
	</div>
	<!-- /container -->
</div>
<!-- /filters -->

<div class="container margin_60_35">
	<div class="row">
		<!-- Filter Page -->
		<?php include 'filters.php'; ?>
		<!-- Filtered Courses -->
		<?php include 'category_wise_course_'.$layout.'_layout.php'; ?>
	</div>
</div>

<script type="text/javascript">
function get_url() {
	var urlPrefix 	= '<?php echo site_url('home/courses?'); ?>'
	var urlSuffix = "";
	var slectedCategory = "";
	var selectedPrice = "";
	var selectedLevel = "";
	var selectedLanguage = "";
	var selectedRating = "";

	// Get selected category
	$('.categories:checked').each(function() {
		slectedCategory = $(this).attr('value');
	});

	// Get selected price
	$('.prices:checked').each(function() {
		selectedPrice = $(this).attr('value');
	});

	// Get selected difficulty Level
	$('.level:checked').each(function() {
		selectedLevel = $(this).attr('value');
	});

	// Get selected difficulty Level
	$('.languages:checked').each(function() {
		selectedLanguage = $(this).attr('value');
	});

	// Get selected rating
	$('.ratings:checked').each(function() {
		selectedRating = $(this).attr('value');
	});

	urlSuffix = "category="+slectedCategory+"&&price="+selectedPrice+"&&level="+selectedLevel+"&&language="+selectedLanguage+"&&rating="+selectedRating;
	var url = urlPrefix+urlSuffix;
	return url;
}
function filter() {
	var url = get_url();
	setTimeout(
		function()
		{
			window.location.replace(url);
		}, 500);
		//console.log(url);
	}

	function toggleLayout(layout) {
		$.ajax({
			type : 'POST',
			url : '<?php echo site_url('home/set_layout_to_session'); ?>',
			data : {layout : layout},
			success : function(response){
				location.reload();
			}
		});
	}

	function showToggle(elem, selector) {
		$('.'+selector).slideToggle(20);
		if($(elem).text() === "<?php echo site_phrase('show_more'); ?>")
		{
			$(elem).text('<?php echo site_phrase('show_less'); ?>');
		}
		else
		{
			$(elem).text('<?php echo site_phrase('show_more'); ?>');
		}
	}
</script>
