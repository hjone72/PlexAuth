<!DOCTYPE html>
<html lang="en">
	<head>
		<!--  Meta  -->
		<?php require_once 'inc/meta.php'; ?>
		<title>Secure Sign in - Your Tech Base</title>
		<!--  CSS  -->
		<?php require_once 'inc/css.php'; ?>
	</head>
	<body class="grey lighten-4">
		<main class="valign-wrapper">
			<div class="container valign">
				<div class="section">
					<div class="row">
						<div class="col col l6 offset-l3 m8 offset-m2 s12 z-depth-4 holding-box grey lighten-5">
							<div class="row">
								<div class="col s12 center">
									<h1 class="text-inset tooltipped" data-position="top" data-delay="50" data-tooltip="Use your Plex credentials">Sign in</h1>
								</div>
							</div>
							<form method="post">
								<div class="row">
									<div class="input-field col s12">
										<input id="email" name="PlexEmail" type="text" class="validate tooltipped" data-position="top" data-delay="50" data-tooltip="Use your Plex credentials">
										<label for="email">Username or Email</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12">
										<input id="password" name="PlexPassword" type="password" class="validate">
										<label for="password">Password</label>
									</div>
								<div class="row">
									<div class="input-field col s12">
										<input type="checkbox" id="indeterminate-checkbox" name="rememberme" value="true" checked>
										<label for="indeterminate-checkbox">Remember Me</label>
									</div>
								</div>
								</div>
								<div class="row right-align">
									<button class="btn waves-effect waves-light light-blue" type="submit" name="action">Submit
										<i class="material-icons right">send</i>
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</main>
		<!--  Scripts  -->
		<?php require_once 'inc/javascripts.php'; ?>
	</body>
</html>