<?php
/**
 * Template Name: No Header Image
 *
 * This template is based on page.php, but it does not contain a sidebar, or Header Image
 *
 * @since 1.0.0
 */
get_header('no-image');
?>

	<div class="container">
		<div class="row">
			<div id="primary" <?php bavotasan_primary_attr(); ?>>
				<?php
				while ( have_posts() ) : the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h1 class="entry-title"><?php the_title(); ?></h1>

					    <div class="entry-content description clearfix">
						    <?php the_content( __( 'Read more', 'arcade') ); ?>
					    </div><!-- .entry-content -->

					    <?php get_template_part( 'content', 'footer' ); ?>
					</article><!-- #post-<?php the_ID(); ?> -->

					<?php
					comments_template( '', true );
				endwhile;
				?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>