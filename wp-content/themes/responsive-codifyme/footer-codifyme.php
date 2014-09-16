<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Footer Template
 *
 *
 * @file           footer-codifyme.php
 * 
 */

/*
 * Globalize Theme options
 */
global $responsive_options;
$responsive_options = responsive_get_options();
?>
<?php responsive_wrapper_bottom(); // after wrapper content hook ?>
</div><!-- end of #wrapper -->
<?php responsive_wrapper_end(); // after wrapper hook ?>
</div><!-- end of #container -->
<?php responsive_container_end(); // after container hook ?>

<div id="footer" class="clearfix">
	<?php responsive_footer_top(); ?>

	<div id="footer-wrapper">

		<?php get_sidebar( 'footer' ); ?>

		<div class="grid col-940">

			<div class="grid col-540">
				<?php if( has_nav_menu( 'footer-menu', 'responsive' ) ) { ?>
				<?php wp_nav_menu( array(
					'container'      => '',
					'fallback_cb'    => false,
					'menu_class'     => 'footer-menu',
					'theme_location' => 'footer-menu'
					)
				);
				?>
				<?php } ?>
			</div>
			<!-- end of col-540 -->

			<div class="grid col-380 fit">
				<?php echo responsive_get_social_icons() ?>
			</div>
			<!-- end of col-380 fit -->

		</div>
		<!-- end of col-940 -->
		<!--?php get_sidebar( 'colophon' ); ?-->
		<div id="colophon-widget" class="grid col-940">
			<div id="text-2" class="colophon-widget widget-wrapper widget_text">			
				<div class="textwidget">
					<div id="mission-statement" class="full_background">
						<h1 style="text-align: center;">Our Mission</h1>
						<p style="text-align: center;">You are plowing through your project, coding away like a boss, but all of a sudden, you run into problems.  Internet searches lead you into a spiral of questionable answers and even more questions. You are stuck. We have all been there. </p>
						<p style="text-align: center;">Our mission is to get you going again.  Getting “unstuck” is a team effort.  At CodifyMe we work together by connecting you with a Code Mentor who can offer support in real time.</p>
						<p style="text-align: center;">By helping each other out, we all learn.  Getting stuck has never been so much fun. CodifyMe is the tool, but you are the coding community. </p>
						<form action="./preview">
    						<input type="submit" value="Preview">
						</form>
					</div>
				</div>
			</div>
			<div id="text-3" class="colophon-widget widget-wrapper widget_text">
				<div class="textwidget">
					<div id="become-a-mentor" class="full_background">
						<h1 style="text-align: center;">Become a Mentor</h1>
						<p>We need people like you to inspire the next generation of coders</p>
						<div class="landing_page_form">
							<?php echo do_shortcode( '[contact-form-7 id="64" title="Become a Mentor"]' ); ?>
						</div>
					</div>
				</div>
			</div>
			<div id="text-4" class="colophon-widget widget-wrapper widget_text">			
				<div class="textwidget">
					<div id="sign-up-for-beta" class="full_background">
						<p>We are working hard to bring CodifyMe to you asap. We're looking for beta users to help us develop CodifyMe. Interested? Sign up to receive an invitation when the private beta is available! We can't wait to hear your thoughts!</p>
						<div class="landing_page__beta_form">
							<?php echo do_shortcode( '[contact-form-7 id="30" title="SignUpForBetaRelease"]' ); ?>
						</div>
					</div>
				</div>
			</div>
			<div id="text-5" class="colophon-widget widget-wrapper widget_text">
				<div class="textwidget"><p class="social_icons"><a href="https://twitter.com/codify_me" target="_blank"><img src="/images/twitter_green50x50.png"></a>        <a href="https://www.facebook.com/pages/CodifyMe/263876173803559" target="_blank"><img src="/images/facebook_green50x50.png"></a></p>
					<p><a href="mailto:hello@codifyme.co">hello@codifyme.co</a></p>
					<p>copyright 2014 CodifyMe</p></div>
				</div>
			</div>
		</div>	

			<!-- end of .copyright -->

			<div class="scroll-top"><a href="#scroll-top" title="<?php esc_attr_e( 'scroll to top', 'responsive' ); ?>"><?php _e( '&uarr;', 'responsive' ); ?></a></div>

			<!-- end .powered -->

		</div>
		<!-- end #footer-wrapper -->

		<?php responsive_footer_bottom(); ?>
	</div><!-- end #footer -->
	<?php responsive_footer_after(); ?>

	<?php wp_footer(); ?>
</body>
</html>