<?php 
/**
 * Attechment template file
**/
get_header(); ?>
<div class="generator-single-blog section-main">
  <div class=" container-generator container">
    <h1><?php the_title(); ?></h1>
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
      <?php while ( have_posts() ) : the_post(); ?>
      <?php $generator_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); ?>
      <div class="col-md-12 no-padding">
        <div class="col-md-10 no-padding">
          <h2 class="generator-head-title"><?php the_title(); ?></h2>
        </div>
        <div class="col-md-2 comments-icon"> 
          <!--<img src="images/comment-icon.png" />--> 
          <i class="fa fa-comments"></i><?php comments_number( '0', '1', '%' ); ?></div>
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
        <a href="<?php echo esc_url(wp_get_attachment_url($post->ID)); ?>">
		      <?php  if ( get_theme_mod( 'hide_post_image' ) == "" ) { 
            $generator_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); 
			      if ($generator_image) : ?>
			        <img src="<?php echo esc_url($generator_image[0]); ?>" alt="" />
			      <?php endif; } ?>
		      </a>
      </div>
      <?php endwhile; ?> 
      <div class="col-md-12 generator-post-comment no-padding">
     	 <?php comments_template( '', true ); ?>
      </div>
    </div>
    <?php if ( get_theme_mod( 'post_sidebar_layout','right'  ) == "right" ) {
         get_sidebar();
    } ?>
  </div>
</div>
<?php get_footer(); ?>