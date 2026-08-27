		<?php if( is_front_page() || is_page_template( 'template-landing-page.php' ) || ( is_home() && ! is_paged() ) ) : ?>
			<?php get_sidebar( 'footer-wide' ); ?>
		<?php endif; ?>
		<div id="footer">
			<?php get_sidebar( 'footer' ); ?>
			<div id="copyright">
				<p class="copyright twocol"><?php fortran_copyright_notice(); ?></p>
				<?php if( fortran_get_option( 'theme_credit_link' ) || fortran_get_option( 'author_credit_link' )  || fortran_get_option( 'wordpress_credit_link' ) ) : ?>
					<p class="credits twocol">
						
					</p>
				<?php endif; ?>
				<div class="clear"></div>
			</div><!-- #copyright -->
		</div><!-- #footer -->
	</div><!-- #wrapper -->
<?php wp_footer(); ?>
</body>
</html>