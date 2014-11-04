<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the main and #page div elements.
 *
 * @since 1.0.0
 */
$bavotasan_theme_options = bavotasan_theme_options();
?>
	</main><!-- main -->
	<footer id="footer" role="contentinfo">

		<div id="footer-content" class="container">
			<div class="row">
				<div class="copyright col-lg-12">
					<span class="pull-left"><?php printf( __( 'Copyright &copy; %s %s. All Rights Reserved.', 'arcade' ), date( 'Y' ), ' <a href="' . home_url() . '">' . get_bloginfo( 'name' ) .'</a>' ); ?></span>
					<span id="codifyme-footer">
						<span><a href="https://twitter.com/codify_me" target="_blank"><img src="/images/twitter_green50x50.png"></a><a href="https://www.facebook.com/pages/CodifyMe/263876173803559" target="_blank"><img src="/images/facebook_green50x50.png"></a>
						</span>
						<span><a href="mailto:hello@codifyme.co">hello@codifyme.co</a></span>
					</span>
					<span class="credit-link pull-right"><?php printf( __( 'Designed by %s.', 'arcade' ), '<a href="http://codifyme.co/">codifyme.co</a>' ); ?></span>
				</div><!-- .col-lg-12 -->
			</div><!-- .row -->
		</div><!-- #footer-content.container -->
	</footer><!-- #footer -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>