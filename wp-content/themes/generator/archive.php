<?php 
/**
 * Archive Page template file
**/
get_header(); 
?>
<div class="generator-single-blog section-main">
  <div class=" container-generator container">
    <h1>
	<?php if ( have_posts() ) : ?> 
	    <p class="generator-post-title">
		<?php esc_html_e('Archives','generator'); echo ": ". get_the_date('M-Y'); ?>
		</p>
		<?php endif; ?>
	</h1>
    <div class="header-breadcrumb">
      <ol>
        <?php if (function_exists('generator_custom_breadcrumbs')) generator_custom_breadcrumbs(); ?>
      </ol>
    </div>
  </div>
</div>
<div class="container container-generator">
  <div class="col-md-12 generator-post no-padding">
  <?php $custom_class = (get_theme_mod('post_sidebar_layout', 'right') == 'left') ? "8" : ((get_theme_mod('post_sidebar_layout', 'right') == 'right') ? "8" : "12");  
     if ( get_theme_mod( 'post_sidebar_layout','right'  ) == "left" ) { ?>
          <div class="left-side-cls">
         <?php get_sidebar(); ?>
       </div>
    <?php } ?>
    <div class="col-md-<?php echo esc_attr($custom_class); ?> no-padding-left">
      <?php 
    $generator_args = array( 
            'orderby'      => 'post_date', 
            'order'        => 'DESC',
            'post_type'    => 'post',
            'paged' => $paged,
            'post_status'    => 'publish' 
            );
     $generator_query = new WP_Query($generator_args); ?>
      <?php if ($generator_query->have_posts() ) : while ($generator_query->have_posts()) : $generator_query->the_post(); ?>
      <div class="blog-post-list">
        <div class="col-md-12 no-padding">

          <div class="col-md-10 no-padding">
            <h2 class="generator-head-title"><a href="<?php echo esc_url(get_permalink()); ?>" class="generator-link"><?php the_title(); ?></a></h2>
          </div>
          <div class="col-md-2 comments-icon"> <i class="fa fa-comments"></i> <?php comments_number( '0', '1', '%' ); ?> </div>
        </div>
        <?php if ( get_theme_mod( 'hide_post_meta_tag' ) == "" ) {  ?>
        <div class="col-md-12 breadcrumb">
          <?php generator_entry_meta(); ?>
          <ol>
            <?php the_tags('<li>', '</li><li>', '</li>'); ?>
          </ol>
        </div>
        <?php } ?>
        <div class="col-md-12 generator-post-content no-padding">
       <?php 
        if ( get_theme_mod( 'hide_post_image' ) == "" ) {
        $generator_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
         if($generator_image != "") { ?><img src="<?php echo esc_url($generator_image); ?>" class="img-responsive generator-featured-image" /><?php } }
          the_excerpt(); ?>
          <?php if ( get_theme_mod( 'hide_post_readmore_button' ) == "" ) {  ?>
          <a href="<?php echo esc_url(get_permalink()); ?>" class="generator-readmore"><button class="blog-readmore-button"><?php echo esc_html(get_theme_mod('post_button_text','READ MORE')); ?></button></a>
          <?php } ?>
        </div>
      </div>
     <?php endwhile; endif; // end of the loop. ?>
      <!--Pagination Start-->
        <?php if (function_exists('faster_pagination') ) {
          faster_pagination();
        }else {
        if(get_option('posts_per_page ') < $wp_query->found_posts) { ?>
        <div class="col-md-12 generator-default-pagination">
            <span class="generator-previous-link"><?php previous_posts_link(); ?></span>
            <span class="generator-next-link"><?php next_posts_link(); ?></span>
        </div>
        <?php }
          }//is plugin active ?>
    <!--Pagination End-->
    </div>
  <?php 
    if ( get_theme_mod( 'post_sidebar_layout','right'  ) == "right" ) {
         get_sidebar();
    } ?>
  </div>
</div>
<?php get_footer(); ?>