<?php
/*
* Template Name: Home Page
*/
get_header(); 
$generator_options = get_option( 'faster_theme_options' );  ?>
<div class="callbacks_container">
<?php if(get_theme_mod('hide_slider_section') == ''){ ?>
<div id="slider4" class="owl-carousel owl-theme">
        <?php for($generator_loop=1;$generator_loop<=3;$generator_loop++){ 
        $image_url = wp_get_attachment_url(get_theme_mod('slider_image_'.$generator_loop)); 
        if(get_theme_mod('slider_image_'.$generator_loop) != ''){
          $image_url = wp_get_attachment_url(get_theme_mod('slider_image_'.$generator_loop));
        }else{
          $image_url=$generator_options['slider-img-'.$generator_loop];
        }
        if($image_url != ""){ ;?>
        <div class="item">
           <?php if(get_theme_mod('slide_link_'.$generator_loop,isset($generator_options['slidelink-'.$generator_loop])?$generator_options['slidelink-'.$generator_loop]:'') != '') { ?>
          <a href="<?php echo esc_url(get_theme_mod('slide_link_'.$generator_loop,isset($generator_options['slidelink-'.$generator_loop])?$generator_options['slidelink-'.$generator_loop]:''));?>" target="_blank"><img src="<?php echo esc_url($image_url); ?>" alt="" /></a>
          <?php }else{?>
          <img src="<?php echo esc_url($image_url); ?>" alt="" />
          <?php } ?>
        </div>
        <?php } } ?>
    </div>
<?php } ?>
</div>
<?php 
if(get_theme_mod('hide_about_us_section') == ''){ ?>
<div class="generator-single-blog section-main front-main">
  <div class=" container-generator container homepage-theme-title">
  <div class="">
   <?php 
   if(get_theme_mod('about_us_image') != ""){
      $url = wp_get_attachment_url(get_theme_mod('about_us_image'));
      $image_col_cls="10"; ?>
      <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-center">
      <div class="about_us_img layout-set"><img src="<?php echo esc_url($url) ?>"></div>
      </div>
    <?php }else{ $image_col_cls="12"; } ?>
    <div class="col-xs-12 col-md-<?php echo esc_attr($image_col_cls) ?> col-lg-<?php echo esc_attr($image_col_cls) ?> col-sm-12">
      <h2>
        <?php if(get_theme_mod('about_us_title',isset($generator_options['home-title'])?$generator_options['home-title']:'Welcome To Generator - Clean, Elegant & Professional WordPress Theme') != '') { echo esc_html(get_theme_mod('about_us_title',isset($generator_options['home-title'])?$generator_options['home-title']:'Welcome To Generator - Clean, Elegant & Professional WordPress Theme')); } ?>
      </h2>
      <h3>
        <?php if(get_theme_mod('about_us_description',isset($generator_options['home-content'])?$generator_options['home-content']:'') != '') { echo esc_html(get_theme_mod('about_us_description',isset($generator_options['home-content'])?$generator_options['home-content']:'')); } ?>
      </h3>
    </div>
  </div>
  </div>
</div>
<?php } ?>
<div class="container container-generator">
<?php if(get_theme_mod('hide_key_features_section') == ''){ ?>
  <div class="col-md-12 generator-post no-padding">
    <?php get_template_part('front-content','generator'); ?>
  </div>
<?php } ?>
  <div class="clearfix"></div>
  <?php if(get_theme_mod('hide_recent_posts_section') == ''){
   if(get_theme_mod('our_recent_posts_section_category',isset($generator_options['post-category'])?$generator_options['post-category']:'') != ''){ ?>
  <div class="container container-generator generator-home-content no-padding">
    <div class="col-md-12 no-padding next-prev">
      <div class="back-radius"> <i class="fa fa-pencil project-icon-size"></i> </div>
      <span class="project-tag">
      <?php  echo esc_html(get_theme_mod('recent_posts_section_title',isset($generator_options['post-title'])?$generator_options['post-title']:'Recent Posts'));
	     ?>
      </span> 
    </div>
    <div class="project1-line"></div>
    <div class="row margin-top-8 text-center no-padding">
      <?php
	$generator_args = array(
	   'cat'  => get_theme_mod('recent_posts_section_category',isset($generator_options['post-category'])?$generator_options['post-category']:''),
		'meta_query' => array(
			array(
			 'key' => '_thumbnail_id',
			 'compare' => 'EXISTS'
			),
		)
	);	
$generator_query=new $wp_query($generator_args); ?>
      <?php if ( $generator_query->have_posts() ) { ?>
      <div class="owl-carousel" id="owl-demo" >
        <?php while($generator_query->have_posts()) {  $generator_query->the_post(); ?>
        <div id="hover-cap-4col" class="col-md-3 item">
          <div class="back-box">
            <div class="thumbnail">
              <div class="caption " style="display: none;"><a href="<?php echo esc_url(get_permalink(get_the_ID())) ?>"> <span class="back-radius-img-hover"> <i class="fa fa-plus back-plus-center "></i> </span> </a> </div>
              <?php $generator_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );?>
              <?php if($generator_image != "") { ?> <img src="<?php echo esc_url($generator_image); ?>" /> <?php } ?>
            </div>
            <h2 class="project-title"><a href="<?php echo esc_url(get_permalink(get_the_ID())) ?>"><?php echo get_the_title(); ?></a></h2>
            <span class="project-contan"><?php echo esc_html(get_the_excerpt()); ?></span>
            <div class="img-box-border-boottom"></div>
          </div>
        </div>
        <?php } ?>
      </div>
      <?php } else { ?>
	  <p><?php esc_html_e('No posts found','generator'); ?></p> 
	  <?php } ?>
    </div>
  </div>
   <?php } } ?>	
</div>
<?php 
get_footer(); ?>