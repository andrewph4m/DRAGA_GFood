<?php
/**
 * The Header template for our theme
 */
 $generator_options = get_option( 'faster_theme_options' ); ?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
  <div class="container container-generator ">
    <div class="col-md-12 margin-top-8 font-color no-padding">
      <div class="col-md-6 col-sm-6 col-xs-12 margin-top-8 no-padding header-icon">
        <div class="col-md-4 col-sm-4 col-xs-12 no-padding header-icon"><?php if(get_theme_mod('email', isset($generator_options['email'])?$generator_options['email']:'') != '') { ?> <i class="<?php echo esc_attr(get_theme_mod('email_icon','fa fa-envelope')); ?>"></i> <span class="icon-email-phone"> <?php echo esc_attr(get_theme_mod('email', isset($generator_options['email'])?$generator_options['email']:''));?> </span> <?php } ?> </div>
        <div class="col-md-7 col-sm-7 col-xs-12 no-padding header-icon"><?php if(get_theme_mod('phone', isset($generator_options['phone'])?$generator_options['phone']:'') != '') { ?> <i class="<?php echo esc_attr(get_theme_mod('phone_icon','fa fa-phone')); ?>"></i> <span class="icon-email-phone"><?php echo esc_attr(get_theme_mod('phone', isset($generator_options['phone'])?$generator_options['phone']:''));?></span> <?php } ?> </div>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12 text-right no-padding">
        <div class="col-md-8 col-sm-6 col-xs-12  icon-menu  margin-top-8 no-padding  ">
          <ul class="list-inline padding-right-10 no-padding-right" >
          <?php if(get_theme_mod('social_link_1', isset($generator_options['twitter'])?$generator_options['twitter']:'') != ''){ ?><li><a href="<?php echo esc_url(get_theme_mod('social_link_1', isset($generator_options['twitter'])?$generator_options['twitter']:''));?>"><i class="<?php echo esc_attr(get_theme_mod('social_link_icon_1','fa fa-twitter-square')); ?>"></i></a></li> <?php } ?>
          <?php if(get_theme_mod('social_link_2', isset($generator_options['fburl'])?$generator_options['fburl']:'') != ''){ ?><li><a href="<?php echo esc_url(get_theme_mod('social_link_2', isset($generator_options['fburl'])?$generator_options['fburl']:''));?>"><i class="<?php echo esc_attr(get_theme_mod('social_link_icon_2','fa fa-facebook-square')); ?>"></i></a></li> <?php } ?>
          <?php if(get_theme_mod('social_link_3', isset($generator_options['dribbble'])?$generator_options['dribbble']:'') != ''){ ?><li><a href="<?php echo esc_url(get_theme_mod('social_link_3', isset($generator_options['dribbble'])?$generator_options['dribbble']:''));?>"><i class="<?php echo esc_attr(get_theme_mod('social_link_icon_3','fa fa-dribbble')); ?>"></i></a></li> <?php } ?>
          <?php if(get_theme_mod('social_link_4', isset($generator_options['linkedin'])?$generator_options['linkedin']:'') != ''){ ?><li><a href="<?php echo esc_url(get_theme_mod('social_link_4', isset($generator_options['linkedin'])?$generator_options['linkedin']:''));?>" ><i class="<?php echo esc_attr(get_theme_mod('social_link_icon_4','fa fa-linkedin')); ?>"></i></a></li> <?php } ?>
          <?php if(get_theme_mod('social_link_5', isset($generator_options['rss'])?$generator_options['rss']:'') != ''){ ?><li><a href="<?php echo esc_url(get_theme_mod('social_link_5', isset($generator_options['rss'])?$generator_options['rss']:''));?>" ><i class="<?php echo esc_attr(get_theme_mod('social_link_icon_5','fa fa-rss')); ?>"></i></a></li> <?php }?>
          </ul>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 no-padding center-search ">
           <form method="get" id="searchform" action="<?php  echo esc_url(home_url()); ?>/">
                <input type="text" value="<?php the_search_query(); ?>" class="search-box" name="s" id="s"  placeholder="<?php esc_html_e('Search the site','generator'); ?>" />
                <input type="submit" id="searchsubmit" value="" class="search-button" />
            </form>
           </div>
      </div>
    </div>  
  </div>
<div class="separator">
<div class="">
<div id="main_header_bg" class="no-padding header-bg-color"> 
   
      <div class="container-generator container">
        <div class="col-md-3 no-padding menu-left">
          <?php
            if(has_custom_logo() ): 
              the_custom_logo();
            endif; 
            if(display_header_text()){ ?>
              <a href="<?php echo esc_url(get_site_url()); ?>"><h1 class="generator-site-name"><?php echo esc_html(get_bloginfo('name')); ?></h1>
              <p class="top-mag-tagline"><?php echo esc_html(get_bloginfo('description')); ?></p></a>
            <?php }
            ?> 
        </div>
        <div class="navbar-header">
          <button type="button" class="navbar-toggle navbar-toggle-top sort-menu-icon" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only"><?php esc_html_e('Toggle navigation','generator') ?></span> <span class="icon-bar icon-color"></span> <span class="icon-bar icon-color"></span> <span class="icon-bar icon-color"></span> </button>
        </div>
         <?php $generator_defaults = array(
              'theme_location'  => 'primary',
              'container'       => 'div',
              'container_class' => 'navbar-collapse collapse no-padding pull-right',
              'container_id'    => 'bs-example-navbar-collapse-1',
              'menu_class'      => 'navbar-collapse no-padding pull-right collapse',
              'menu_id'         => '',
              'echo'            => true,
              'fallback_cb'     => 'wp_page_menu',
              'before'          => '',
              'after'           => '',
              'link_before'     => '',
              'link_after'      => '',
              'items_wrap'      => '<ul class="nav navbar-nav generator-menu">%3$s</ul>',
              'depth'           => 0,
              'walker'          => ''
            );
      wp_nav_menu($generator_defaults); ?>
      </div>
      <div class="clearfix"></div>
    </div>
</div>
</div>

  <?php if(get_header_image()){ ?>
        <div class="custom-header-img">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        	<img src="<?php header_image(); ?>" width="<?php echo esc_attr(get_custom_header()->width); ?>" height="<?php echo esc_attr(get_custom_header()->height); ?>" alt="">
        </a>
        </div>
    <?php } ?>   
</header>