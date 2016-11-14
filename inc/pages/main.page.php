<!DOCTYPE html>
<html lang="en">
	<head>
		<!--  Meta  -->
		<?php require_once 'inc/meta.php'; ?>
		<title>PlexAuth | Secure</title>
		<!--  CSS  -->
		<?php require_once 'inc/css.php'; ?>
		<?php require_once('muximux.module.php'); ?>
	</head>
	<body class="grey lighten-5">
		<!--  Nav  -->
		<?php require_once 'inc/nav.php'; ?>
		<main class="valign-wrapper">
			<ul class="iframe-content" style="margin: 0px; width: 100%">
				<?php
					echo frameContent($menu_items_F);
					echo frameContent($menu_items_HaS);
					echo frameContent($management_items);
				?>
			</ul>
		</main>
		<!--  Footer  -->
		<?php #require_once 'inc/footer.php'; ?>
		<!--  Scripts  -->
		<?php require_once 'inc/javascripts.php'; ?>
	</body>
</html>
