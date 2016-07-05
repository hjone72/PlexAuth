<!DOCTYPE html>
<html lang="en">
	<head>
		<!--  Meta  -->
		<?php require_once 'inc/meta.php'; ?>
		<title>Your Tech Base</title>
		<!--  CSS  -->
		<?php require_once 'inc/css.php'; ?>
	</head>
	<body class="grey lighten-4">
		<!--  Nav  -->
		<?php require_once 'inc/nav.php'; ?>
		<main>
			<div class="container">
				<div class="section">
					<div class="row">
						<div class="col s12">
							<h1>Welcome <?php echo $User->getName()[0]; ?></h1>
						</div>
						<?php
						?>
					</div>
				</div>
			</div>
		</main>
		<!--  Footer  -->
		<?php require_once 'inc/footer.php'; ?>
		<!--  Scripts  -->
		<?php require_once 'inc/javascripts.php'; ?>
	</body>
</html>