<?php get_header(); ?>
	<?php if( is_home() && ! is_paged() ) : ?>
		<?php if( fortran_get_option( 'slider' ) ) : ?>
			<?php get_template_part( 'slider' ); ?>
		<?php endif; ?>
		<?php get_sidebar( 'wide' ); ?>
		<?php get_sidebar( 'boxes' ); ?>
	<?php elseif( ( is_home() && is_paged() ) || ( ! is_home() && fortran_get_option( 'location' ) ) ) : ?>
		<?php fortran_current_location(); ?>
	<?php endif; ?>
	<div id="container">
		<section id="content" <?php fortran_content_class(); ?>>
			<?php if( is_category( fortran_get_option( 'portfolio_cat' ) ) || ( is_category() && cat_is_ancestor_of( fortran_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
				<?php fortran_category_filter( fortran_get_option( 'portfolio_cat' ) ); ?>
			<?php endif; ?>
			<?php if( have_posts() ) : ?>
				<div class="entries">
					<?php while( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
				</div><!-- .entries -->
				<?php fortran_posts_nav(); ?>
			<?php else : ?>
				<?php fortran_404(); ?>
			<?php endif; ?>
		</section><!-- #content -->
		<?php if( 'no-sidebars' != fortran_get_option( 'layout' ) && 'full-width' != fortran_get_option( 'layout' ) && ! is_category( fortran_get_option( 'portfolio_cat' ) ) && ! ( is_category() && cat_is_ancestor_of( fortran_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<div class="clear"></div>
	</div><!-- #container -->
<?php get_footer(); ?>