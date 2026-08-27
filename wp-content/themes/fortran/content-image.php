<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<div class="entry">
		<?php if( ( 'full-width' != fortran_get_option( 'layout' ) && ! is_category( fortran_get_option( 'portfolio_cat' ) ) && ! ( is_category() && cat_is_ancestor_of( fortran_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) || fortran_is_teaser() ) : ?>
			<?php fortran_post_image(); ?>
		<?php endif; ?>
		<div class="entry-container">
			<header class="entry-header">
				<<?php fortran_title_tag( 'post' ); ?> class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></<?php fortran_title_tag( 'post' ); ?>>
				<?php if( 'full-width' == fortran_get_option( 'layout' ) || is_category( fortran_get_option( 'portfolio_cat' ) ) || ( is_category() && cat_is_ancestor_of( fortran_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
					<?php fortran_entry_meta(); ?>
				<?php endif; ?>
			</header><!-- .entry-header -->
			<?php if( ( 'full-width' == fortran_get_option( 'layout' ) || is_category( fortran_get_option( 'portfolio_cat' ) ) || ( is_category() && cat_is_ancestor_of( fortran_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) && ! fortran_is_teaser() ) : ?>
				<?php fortran_post_image(); ?>
			<?php endif; ?>
			<?php if( ! is_category( fortran_get_option( 'portfolio_cat' ) ) && ! ( is_category() && cat_is_ancestor_of( fortran_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			<?php endif; ?>
			<div class="clear"></div>
		</div><!-- .entry-container -->
		<?php if( 'full-width' != fortran_get_option( 'layout' ) && ! is_category( fortran_get_option( 'portfolio_cat' ) ) && ! ( is_category() && cat_is_ancestor_of( fortran_get_option( 'portfolio_cat' ), get_queried_object() ) ) ) : ?>
			<?php fortran_entry_meta(); ?>
		<?php endif; ?>
	</div><!-- .entry -->
</article><!-- .post -->