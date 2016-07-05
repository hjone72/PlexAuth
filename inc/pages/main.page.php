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
							if (isset($_GET['dev'])){
								if ($_GET['dev']){
									if ($User->authURI($_GET['uri'])){
										print 'Authorized';
									} else {
										print 'Unauthorized';
									}
									print_r(explode('/',$_GET['uri']));
									if ($_GET['groups']){
										$User->printGroups();
									}
									if ($_GET['emails']){
										if ($User->authURI('/emails')){
											printPlexEmails();
										}
									}
								}
							}
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