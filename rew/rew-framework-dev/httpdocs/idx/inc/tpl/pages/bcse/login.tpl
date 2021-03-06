<?=(!empty($success) ? '<div class="msg positive"><p>' . implode('</p><p>', $success) . '</p></div>' : ''); ?>
<?=(!empty($errors) ? '<div class="msg negative"><p>' . implode('</p><p>', $errors) . '</p></div>' : ''); ?>

<?php if (!empty($show_form)) { ?>

	<?=!empty(Settings::getInstance()->SETTINGS['copy_login']) ? '<div class="copy hidden-phone">' . Settings::getInstance()->SETTINGS['copy_login'] . '</div>' : ''; ?>

	<div class="grid_12">
		<div<?=!empty($networks) ? ' class="x8"' : ' class="x12"'; ?>>
			<h3>Sign In</h3>
			<form action="?login" method="post" id="bcse_tpl_login">
				<div class="field x12">
					<input type="email" name="email" value="<?=htmlentities($email); ?>" placeholder="Email Address" required>
				</div>
				<?php if (!empty(Settings::getInstance()->SETTINGS['registration_password'])) { ?>
					<div class="field x12">
						<input type="password" name="password" placeholder="Password" required>
					</div>
				<?php } ?>
				<div class="btnset">

					<button class="strong" type="submit">Sign In</button>
					<?php if (!empty(Settings::getInstance()->SETTINGS['registration_password'])) { ?>
						<a href="<?=Settings::getInstance()->SETTINGS['URL_IDX_REMIND']; ?>" class="forgot-password">Forgot your password?</a>
					<?php } ?>
				</div>
			</form>
			<h3 class="login-register">
				<span>Don&#39;t have an account? </span>
				<a class="buttonstyle mini" href="<?=Settings::getInstance()->SETTINGS['URL_IDX_REGISTER']; ?>">Register Now</a>
			</h3>
		</div>
		<?php if (!empty($networks)) { ?>
			<div class="x4 last">
				<h3>Or &hellip;</h3>
				<div class="networks">
					<ul>
						<?php foreach ($networks as $id => $network) { ?>
							<li>
								<a class="network-login <?=$id; ?>" href="javascript:var w = window.open('<?=$network['connect']; ?>', 'socialconnect', 'toolbar=0,status=0,scrollbars=1,width=600,height=450,left='+(screen.availWidth/2-225)+',top='+(screen.availHeight/2-250)); w.focus();">Login with <?=$network['title']; ?></a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		<?php } ?>
	</div>

<?php

} else {

	// Trigger Save Listing
	if (!empty($_SESSION['bookmarkListing'])) {
		$page->writeJS("window.parent.IDX.Favorite({'mls':'" . $_SESSION['bookmarkListing'] . "','force':true,'feed':'" . $_SESSION['bookmarkFeed'] . "'});");
		unset($_SESSION['bookmarkListing'], $_SESSION['bookmarkFeed']);
	}

	// Trigger Save Search
	if (!empty($_SESSION['saveSearch'])) {
		$page->writeJS('window.parent.saveSearch(' . $_SESSION['saveSearch'] . ');');
		unset($_SESSION['saveSearch']);
	} else {

		// Get & Reset Redirect URL
		$url_redirect = $user->url_redirect();
		$user->setRedirectUrl('');

		// Require Verification
		if (!empty(Settings::getInstance()->SETTINGS['registration_verify']) && $user->info('verified') != 'yes') {
			$url_redirect = sprintf(Settings::getInstance()->SETTINGS['URL_IDX_VERIFY'], '');
		}

		// Default to IDX
		$url_redirect = !empty($url_redirect) ? $url_redirect : Settings::getInstance()->SETTINGS['URL_IDX'];

		// Javascript Callback
		$page->writeJS("setTimeout(function () {
			if (window == window.top) {
				window.location = '" . $url_redirect . "';
			} else {
				window.parent.location.reload();
				window.parent.$.Window('close');
			}
		}, 2000);");

	}

}

?>