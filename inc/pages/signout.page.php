<!DOCTYPE html>
<html lang="en">
	<head>
		<!--  Meta  -->
		<?php require_once 'inc/meta.php'; ?>
		<title>TEMPLATE - Your Tech Base</title>
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
								<div class="col s12">
									<h1>Sign out of YTB</h1>
								</div>
								<?php
									$rememberMe->clearCookie();
									$_SESSION = array();
									if (ini_get("session.use_cookies")) {
										$params = session_get_cookie_params();
										setcookie(session_name(), '', time() - 42000,
											$params["path"], $params["domain"],
											$params["secure"], $params["httponly"]
										);
									}
									session_destroy();
									session_regenerate_id();
									header("Location: https://secure.domain.com");
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<!--  Scripts  -->
		<?php require_once 'inc/javascripts.php'; ?>
	</body>
</html>