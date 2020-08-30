<?php  $generator_options = get_option( 'faster_theme_options' ); ?>
<footer class="footer-menu">
<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ){ ?>
  <div class="container footer-menu no-padding">
	<div class="footer-div"><?php if ( is_active_sidebar( 'footer-1' ) ) {  dynamic_sidebar( 'footer-1' ); } ?></div>
    <div class="footer-div"><?php if ( is_active_sidebar( 'footer-2' ) ) {  dynamic_sidebar( 'footer-2' ); } ?></div>
    <div class="footer-div"> <?php if ( is_active_sidebar( 'footer-3' ) ) {  dynamic_sidebar( 'footer-3' ); } ?></div>
    <div class="footer-div"><?php if ( is_active_sidebar( 'footer-4' ) ) {  dynamic_sidebar( 'footer-4' ); } ?></div>
  </div>
<?php } ?>
  <div class="copyright col-lg-12">
    <div class="container container-generator">
      <div class="col-md-12 footer-margin-top text-center">
	  	<?php if(get_theme_mod('footerCopyright',isset($generator_options['footertext'])?$generator_options['footertext']:'') != '') {
         echo wp_kses_post(get_theme_mod('footerCopyright',isset($generator_options['footertext'])?$generator_options['footertext']:'')).' '; 
			  }
		?>
		<span class='generator-poweredby'>
   <?php esc_html_e('Powered By ','generator'); ?><a href="<?php echo esc_url('https://fasterthemes.com/wordpress-themes/generator'); ?>"><?php esc_html_e(' Generator WordPress Theme','generator'); ?></a>
		</span>
      </div>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>