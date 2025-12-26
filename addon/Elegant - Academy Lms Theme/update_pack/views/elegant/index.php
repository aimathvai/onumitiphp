<!DOCTYPE html>
<html lang="en">

<head>
	<?php include 'metas.php'; ?>
	<title><?php echo get_settings('system_title'); ?> | <?php echo $page_title; ?></title>
	<?php include 'includes_top.php'; ?>
</head>

<body <?php if ($page_name == 'login' || $page_name == 'sign_up' || $page_name == 'forgot_password' || $page_name == "change_password_from_forgot_password"): ?> id="login_bg" <?php endif; ?>>
	<?php if ($page_name != 'login' && $page_name != 'sign_up' && $page_name != 'forgot_password' && $page_name != "change_password_from_forgot_password"): ?>
		<div id="page">
			<!-- Header -->
			<?php include 'header.php'; ?>
			<!-- Main content starts from here -->
			<main>
				<?php include $page_name.'.php'; ?>
			</main>
			<!-- footer -->
			<?php include 'footer.php'; ?>
		</div>
		<!-- end of page -->
	<?php elseif ($page_name == 'login' || $page_name == 'sign_up' || $page_name == 'forgot_password' || $page_name == "change_password_from_forgot_password"):?>
		<nav id="menu" class="fake_menu"></nav>
		<div id="preloader">
			<div data-loader="circle-side"></div>
		</div>
		<div id="login">
			<?php include $page_name.'.php'; ?>
		</div>
	<?php endif; ?>
	<!-- COMMON SCRIPTS -->
	<?php include 'includes_bottom.php'; ?>
	<?php include 'common_scripts.php'; ?>
	<?php include 'modal.php'; ?>
</body>
</html>
