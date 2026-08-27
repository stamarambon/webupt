<?php get_header(); ?>
	<div id="container">
		<section id="content" <?php fortran_content_class(); ?>>
			<?php fortran_404(); ?>
		</section><!-- #content -->
		<?php if( ( 'no-sidebars' != fortran_get_option( 'layout' ) ) && ( 'full-width' != fortran_get_option( 'layout' ) ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
	</div><!-- #container -->
<?php get_footer(); ?>