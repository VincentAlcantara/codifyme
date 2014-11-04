<?php
/**
 * Template Name: Login Page
 *
 * This template is for the login page for CodifyMe
 *
 * @since 1.0.0
 */
get_header();
?>

	<div class="container">
		<div class="row">
			<div id="primary" <?php bavotasan_primary_attr(); ?>>
				<?php
				wp_login_form();

				?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>