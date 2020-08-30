<?php
/**
* Customization options
**/
$generator_options = get_option( 'faster_theme_options' );
if( class_exists( 'WP_Customize_Control' ) ):
/* Class for icon selector */
class Generator_Fontawesome_Icon_Chooser extends WP_Customize_Control{
    public $type = 'icon';
    public function render_content(){ ?>
      <label>
          <span class="customize-control-title">
          <?php echo esc_html( $this->label ); ?>
          </span>
          <?php if($this->description){ ?>
          <span class="description customize-control-description">
              <?php echo wp_kses_post($this->description); ?>
          </span>
          <?php } ?>
          <div class="generator-selected-icon">
              <i class="fa <?php echo esc_attr($this->value()); ?>"></i>
              <span><i class="fa fa-angle-down"></i></span>
          </div>
          <ul class="generator-icon-list clearfix">
              <?php
              $Generator_font_awesome_icon_array = Generator_font_awesome_icon_array();
              foreach ($Generator_font_awesome_icon_array as $Generator_font_awesome_icon) {
                      $icon_class = $this->value() == $Generator_font_awesome_icon ? 'icon-active' : '';
                      echo '<li class='.esc_attr( $icon_class ).'><i class="'.esc_attr( $Generator_font_awesome_icon ).'"></i></li>';
                } ?>
          </ul>
          <input type="hidden" value="<?php echo esc_attr($this->value()); ?>" <?php echo esc_url($this->link()); ?> />
      </label>
  <?php }
}
endif;
// post category list
function generator_post_category(){
  $cats = array();
  $cats['']='Select Category';
  foreach ( get_categories() as $categories => $category ){
      $cats[$category->term_id] = $category->name;
  }
  return $cats;
}
function generator_sanitize_checkbox( $checked ) {
  return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
//select sanitization function
function generator_sanitize_select( $input, $setting ){         
//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
$input = sanitize_key($input); 
//get the list of possible select options 
$choices = $setting->manager->get_control( $setting->id )->choices;                            
return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
}
//URL
function generator_sanitize_url( $url ) {
  return esc_url_raw( $url );
}
//Get Image ID by image URL
function generator_get_image_id($image_url) {
  global $wpdb;
  if($image_url != ""){
  $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
    if(!empty($attachment)){
        return $attachment[0]; 
      }
  }
}
function generator_customize_register( $wp_customize ) {
  $generator_options = get_option( 'faster_theme_options' );
  $wp_customize->add_panel(
  'general',
    array(
      'title'       => esc_html__( 'General Settings', 'generator' ),
      'description' => esc_html__('General Settings','generator'),
      'priority'    => 20, 
  ));
  $wp_customize->get_section('title_tagline')->panel = 'general';
  $wp_customize->get_section('header_image')->panel = 'general';
  $wp_customize->get_section('static_front_page')->panel = 'general';   
  $wp_customize->get_section('title_tagline')->title = esc_html__( 'Header & Logo', 'generator'); 
  /* --------------------------- Start General Panel -------------------- */
  // Start Top Header Section
  $wp_customize->add_section( 'top_header', array(
    'priority'            => 10,
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Top Header', 'generator'),
    'panel'               => 'general'
  ) );
  // Email 
  $wp_customize->add_setting( 'email', array(
    'default'             => isset($generator_options['email'])?$generator_options['email']:'',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'email', array(
    'type'                => 'text',
    'priority'            => 10,
    'section'             => 'top_header',
    'label'               => esc_html__( 'Email', 'generator' ),
    'input_attrs'         => array(
            'placeholder' => esc_html__( 'youremail@youremail.com', 'generator' ),
      )
  ) );
  // Email Icon
  $wp_customize->add_setting('email_icon',array(
    'default'             => 'fa fa-envelope',
    'sanitize_callback'   => 'sanitize_text_field',
    'transport'           => 'postMessage'
  ) );
  $wp_customize->add_control(new Generator_Fontawesome_Icon_Chooser(
    $wp_customize,
    'email_icon',
      array(
        'settings'        => 'email_icon',
        'section'         => 'top_header',        
        'label'           => esc_html__( 'Icon', 'generator' ),
      )
  ) );
  // Phone Number
  $wp_customize->add_setting( 'phone', array(
    'default'             => isset($generator_options['phone'])?$generator_options['phone']:'',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'phone', array(
    'type'                => 'text',
    'priority'            => 10,
    'section'             => 'top_header',
    'label'               => esc_html__( 'Phone', 'generator' ),
    'input_attrs'         => array(
            'placeholder' => esc_html__( '123 456 7890', 'generator' ),
      )
  ) );
  // Phone Icon
  $wp_customize->add_setting('phone_icon',array(
    'default'             => 'fa fa-phone',
    'sanitize_callback'   => 'sanitize_text_field',
    'transport'           => 'postMessage'
  ) );
  $wp_customize->add_control(new Generator_Fontawesome_Icon_Chooser(
    $wp_customize,
    'phone_icon',
      array(
        'settings'        => 'phone_icon',
        'section'         => 'top_header',        
        'label'           => esc_html__( 'Icon', 'generator' ),
      )
  ) );
  // Social Link URL 1
  $wp_customize->add_setting( 'social_link_1', array(
    'default'             => isset($generator_options['twitter'])?$generator_options['twitter']:'',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_url',
  ) );
  $wp_customize->add_control( 'social_link_1', array(
    'type'                => 'url',
    'priority'            => 10,
    'section'             => 'top_header',
    'label'               => esc_html__( 'Social Icon 1', 'generator'),
    'input_attrs'         => array(
          'placeholder'   => esc_html__( 'http://www.twitter.com/username/', 'generator' ),
    )
  ) );
  // Social Icon 1
  $wp_customize->add_setting('social_link_icon_1',array(
    'default'             => 'fa fa-twitter-square',
    'sanitize_callback'   => 'sanitize_text_field',
    'transport'           => 'postMessage'
  ) );
  $wp_customize->add_control(new Generator_Fontawesome_Icon_Chooser(
    $wp_customize,
    'social_link_icon_1',
      array(
        'settings'        => 'social_link_icon_1',
        'section'         => 'top_header',        
      )
  ) );
  // Social Link URL 2
  $wp_customize->add_setting( 'social_link_2', array(
    'default'             => isset($generator_options['fburl'])?$generator_options['fburl']:'',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_url',
  ) );
  $wp_customize->add_control( 'social_link_2', array(
    'type'                => 'url',
    'priority'            => 10,
    'section'             => 'top_header',
    'label'               => esc_html__( 'Social Icon 2', 'generator'),
    'input_attrs'         => array(
          'placeholder'   => esc_html__( 'http://www.twitter.com/username/', 'generator' ),
    )
  ) );
  // Social Icon 2
  $wp_customize->add_setting('social_link_icon_2',array(
    'default'             => 'fa fa-facebook-square',
    'sanitize_callback'   => 'sanitize_text_field',
    'transport'           => 'postMessage'
  ) );
  $wp_customize->add_control(new Generator_Fontawesome_Icon_Chooser(
    $wp_customize,
    'social_link_icon_2',
      array(
        'settings'        => 'social_link_icon_2',
        'section'         => 'top_header',        
      )
  ) );
  // Social Link URL 3
  $wp_customize->add_setting( 'social_link_3', array(
    'default'             => isset($generator_options['dribbble'])?$generator_options['dribbble']:'',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_url',
  ) );
  $wp_customize->add_control( 'social_link_3', array(
    'type'                => 'url',
    'priority'            => 10,
    'section'             => 'top_header',
    'label'               => esc_html__( 'Social Icon 3', 'generator'),
    'input_attrs'         => array(
          'placeholder'   => esc_html__( 'http://www.twitter.com/username/', 'generator' ),
    )
  ) );
  // Social Icon 3
  $wp_customize->add_setting('social_link_icon_3',array(
    'default'             => 'fa fa-dribbble',
    'sanitize_callback'   => 'sanitize_text_field',
    'transport'           => 'postMessage'
  ) );
  $wp_customize->add_control(new Generator_Fontawesome_Icon_Chooser(
    $wp_customize,
    'social_link_icon_3',
      array(
        'settings'        => 'social_link_icon_3',
        'section'         => 'top_header',        
      )
  ) );
  // Social Link URL 4
  $wp_customize->add_setting( 'social_link_4', array(
    'default'             => isset($generator_options['linkedin'])?$generator_options['linkedin']:'',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_url',
  ) );
  $wp_customize->add_control( 'social_link_4', array(
    'type'                => 'url',
    'priority'            => 10,
    'section'             => 'top_header',
    'label'               => esc_html__( 'Social Icon 4', 'generator'),
    'input_attrs'         => array(
          'placeholder'   => esc_html__( 'http://www.twitter.com/username/', 'generator' ),
    )
  ) );
  // Social Icon 4
  $wp_customize->add_setting('social_link_icon_4',array(
    'default'             => 'fa fa-linkedin',
    'sanitize_callback'   => 'sanitize_text_field',
    'transport'           => 'postMessage'
  ) );
  $wp_customize->add_control(new Generator_Fontawesome_Icon_Chooser(
    $wp_customize,
    'social_link_icon_4',
      array(
        'settings'        => 'social_link_icon_4',
        'section'         => 'top_header',        
      )
  ) );
  // Social Link URL 5
  $wp_customize->add_setting( 'social_link_5', array(
    'default'             => isset($generator_options['rss'])?$generator_options['rss']:'',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_url',
  ) );
  $wp_customize->add_control( 'social_link_5', array(
    'type'                => 'url',
    'priority'            => 10,
    'section'             => 'top_header',
    'label'               => esc_html__( 'Social Icon 5', 'generator'),
    'input_attrs'         => array(
          'placeholder'   => esc_html__( 'http://www.twitter.com/username/', 'generator' ),
    )
  ) );
  // Social Icon 5
  $wp_customize->add_setting('social_link_icon_5',array(
    'default'             => 'fa fa-rss',
    'sanitize_callback'   => 'sanitize_text_field',
    'transport'           => 'postMessage'
  ) );
  $wp_customize->add_control(new Generator_Fontawesome_Icon_Chooser(
    $wp_customize,
    'social_link_icon_5',
      array(
        'settings'        => 'social_link_icon_5',
        'section'         => 'top_header',               
      )
  ) );
  // End Top Header Section 
  // Start Blog Listing Section 
  $wp_customize->add_section( 'blog_page_section', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Blog(Archive) Page', 'generator'),
    'panel'               => 'general'
  ) );
  // Meta Tag Checkbox
  $wp_customize->add_setting( 'hide_post_meta_tag', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_post_meta_tag', array(
    'type'                => 'checkbox',
    'section'             => 'blog_page_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide post meta tag', 'generator' ),
  ) );
  // Blog Image Checkbox
  $wp_customize->add_setting( 'hide_post_image', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_post_image', array(
    'type'                => 'checkbox',
    'section'             => 'blog_page_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide post image', 'generator' ),
  ) );
  // Read More Link
  $wp_customize->add_setting( 'hide_post_readmore_button', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_post_readmore_button', array(
    'type'                => 'checkbox',
    'section'             => 'blog_page_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide read more link', 'generator' ),
  ) );
  // Post Content Limit
  $wp_customize->add_setting( 'post_content_limit', array(
    'default'             => '25',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'post_content_limit', array(
    'type'                => 'text',
    'priority'            => 10,
    'section'             => 'blog_page_section',
    'label'               => esc_html__( 'Post Content Limit', 'generator' ),
  ) );
  // Post Button text
  $wp_customize->add_setting( 'post_button_text', array(
    'default'             => 'Read More',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'post_button_text', array(
    'type'                => 'text',
    'priority'            => 10,
    'section'             => 'blog_page_section',
    'label'               => esc_html__( 'Post Button Text', 'generator' ),
  ) );
  // Blog sidebar setting 
  $wp_customize->add_setting( 'post_sidebar_layout', array(
    'default'             => 'right',
    'sanitize_callback'   => 'generator_sanitize_select',
  ) );
  $wp_customize->add_control( 'post_sidebar_layout', array(
    'type'                => 'select',
    'section'             => 'blog_page_section',
    'label'               => esc_html__( 'Display Sidebar', 'generator' ),
    'choices'             => array(
      'right'             => 'Right',
      'left'              => 'Left',
      'full'              => 'Full',
      )
  ) );
  // End Blog Listing Section
  // Start Single Post Page Section
  $wp_customize->add_section( 'single_post_page_section', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Single Post Page', 'generator'),
    'panel'               => 'general'
  ) );
  // Single Post Meta Tag Checkbox 
  $wp_customize->add_setting( 'hide_single_post_meta_tag', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_single_post_meta_tag', array(
    'type'                => 'checkbox',
    'section'             => 'single_post_page_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide post meta tag', 'generator' ),      
  ) );
  // Comment Form 
  $wp_customize->add_setting( 'hide_single_post_comment_form', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_single_post_comment_form', array(
    'type'                => 'checkbox',
    'section'             => 'single_post_page_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide comment form', 'generator' ),
  ) );
  // Single Post Image Checkbox 
  $wp_customize->add_setting( 'hide_single_post_image', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_single_post_image', array(
    'type'                => 'checkbox',
    'section'             => 'single_post_page_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide post image', 'generator' ),
  ) );
  // Single Post Page Sidebar
  $wp_customize->add_setting( 'single_post_sidebar_layout', array(
    'default'             => 'right',
    'sanitize_callback'   => 'generator_sanitize_select',
  ) );
  $wp_customize->add_control( 'single_post_sidebar_layout', array(
    'type'                => 'select',
    'section'             => 'single_post_page_section',
    'label'               => esc_html__( 'Display Sidebar', 'generator' ),
    'choices'             => array(
      'right'             => 'Right',
      'left'              => 'Left',
      'full'              => 'Full',
    )
  ) );
  // End Single Posts Page Section
  /* --------------------------- End General Panel -------------------- */
  /* --------------------------- Start Front Page Panel -------------------- */
  $wp_customize->add_panel(
    'homepage_setting',
    array(
    'title'               => esc_html__( 'Front Page Settings', 'generator' ),
    'description'         => esc_html__('Front Page Settings','generator'),
    'priority'            => 20, 
    )
  );
  // Start Slider Section 
  $wp_customize->add_section( 'slider_setting', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Slider Section', 'generator'),
    'panel'               => 'homepage_setting'
  ) );
  // Checkbox
  $wp_customize->add_setting( 'hide_slider_section', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_slider_section', array(
    'type'                => 'checkbox',
    'section'             => 'slider_setting', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide this section.', 'generator' ),
  ) );
  // Image
  for($i=1;$i<=5;$i++)
  {
    $image_url=isset($generator_options['slider-img-'.$i])?$generator_options['slider-img-'.$i]:'';
    $image_id = generator_get_image_id($image_url);
    $wp_customize->add_setting( 'slider_image_'.$i, array(
      'default'           => $image_id,
      'type'              => 'theme_mod',
      'capability'        => 'edit_theme_options',
      'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control(
      new WP_Customize_Cropped_Image_Control(
      $wp_customize,
      'slider_image_'.$i,
      array(
      'label'             => esc_html( 'Slide '.$i ),
      'section'           => 'slider_setting',
      'settings'          => 'slider_image_'.$i,
      'description'       => esc_html__('Upload Image Size : 1299 x 455', 'generator'),
      'height'            => 455,
      'width'             => 1299,
      'flex_width'        => false,
      'flex_height'       => false,
      )
    ) ); 
    // Slide Link 
    $wp_customize->add_setting( 'slide_link_'.$i, array(   
      'default'           => isset($generator_options['slidelink-'.$i])?$generator_options['slidelink-'.$i]:'',
      'type'              => 'theme_mod',
      'capability'        => 'edit_theme_options',
      'sanitize_callback' => 'generator_sanitize_url',
    ) );
    $wp_customize->add_control( 'slide_link_'.$i, array(
      'type'              => 'url',
      'priority'          => 10,
      'section'           => 'slider_setting',      
      'input_attrs'       => array(
            'placeholder' => esc_html__( 'Slide Link', 'generator' ),
      )
    ) );
  }
  // End Slider Section 
  // Start About Us Section
  $wp_customize->add_section( 'about_us', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('About Us Section', 'generator'),
    'panel'               => 'homepage_setting'
  ) );
  // Checkbox Field 
  $wp_customize->add_setting( 'hide_about_us_section', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_about_us_section', array(
    'type'                => 'checkbox',
    'section'             => 'about_us', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide this section.', 'generator' ),
  ) );
  // Title
  $wp_customize->add_setting( 'about_us_title', array(
    'default'             => isset($generator_options['home-title'])?$generator_options['home-title']:'Welcome To Generator - Clean, Elegant & Professional WordPress Theme',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'about_us_title', array(
    'type'                => 'text',
    'section'             => 'about_us',
    'label'               => esc_html__('Title','generator'),
    'input_attrs'         => array(
          'placeholder'   => esc_html__( 'Enter title', 'generator' ),
    )
  ) );
  // Description
  $wp_customize->add_setting( 'about_us_description', array(
    'default'             => isset($generator_options['home-content'])?$generator_options['home-content']:'',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'wp_kses_post',
  ) );
  $wp_customize->add_control( 'about_us_description', array(
    'type'                => 'textarea',
    'priority'            => 10,
    'label'               => esc_html__( 'Short Description', 'generator' ),
    'section'             => 'about_us',
    'input_attrs'         => array(
          'placeholder'   => esc_html__( 'Enter Short Description', 'generator' ),
    )
  ) );
  // About Us image
  $wp_customize->add_setting('about_us_image', array(
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'absint',
    ));
  $wp_customize->add_control(
    new WP_Customize_Cropped_Image_Control(
    $wp_customize,
    'about_us_image',
    array(
    'label'               => esc_html( 'Image' ),
    'section'             => 'about_us',
    'settings'            => 'about_us_image',
    'description'         => esc_html__('Upload Image Size : 181 x 181', 'generator'),
    'height'              => 181,
    'width'               => 181,
    'flex_width'          => false,
    'flex_height'         => false,
    )
  ) ); 
  // About Us Background image
  $wp_customize->add_setting( 'about_us_background_image', array(
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'absint',
  ) );
  $wp_customize->add_control(
    new WP_Customize_Cropped_Image_Control(
    $wp_customize,
    'about_us_background_image',
    array(
    'label'               => esc_html( 'Background Image ', 'generator' ),
    'section'             => 'about_us',
    'settings'            => 'about_us_background_image',
    'description'         => esc_html__('Upload Image Size : 1350 x 92', 'generator'),
    'height'              => 92,
    'width'               => 1350,
    'flex_width'          => false,
    'flex_height'         => false,
    )
  ) ); 
  // End About Us Section
  // Start Key Features Section
  $wp_customize->add_section( 'key_features_section', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Key Features Section', 'generator'),
    'panel'               => 'homepage_setting'
  ) );
  // Checkbox Field 
  $wp_customize->add_setting( 'hide_key_features_section', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_key_features_section', array(
    'type'                => 'checkbox',
    'section'             => 'key_features_section',
    'label'               => esc_html__( 'Please check this box, if you want to hide this section.', 'generator' ),
  ) );
  // Title
  for($i=1;$i<=4;$i++)
  {
    // Key Feature Title
    $wp_customize->add_setting( 'key_features_section_tab_title'.$i, array(
      'default'             => isset($generator_options['section-title-'.$i])?$generator_options['section-title-'.$i]:'Lorem Ispum',
      'type'                => 'theme_mod',
      'capability'          => 'edit_theme_options',
      'sanitize_callback'   => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'key_features_section_tab_title'.$i, array(
      'type'                => 'text',
      'section'             => 'key_features_section',
      'label'               => esc_html__('Tab ','generator').$i,
      'input_attrs'         => array(
            'placeholder'   => esc_html__( 'Enter title', 'generator' ),
      )
    ) );
    // Key Feature Description
    $wp_customize->add_setting( 'key_features_section_tab_description'.$i, array(
      'default'             => isset($generator_options['section-content-'.$i])?$generator_options['section-content-'.$i]:'',
      'type'                => 'theme_mod',
      'capability'          => 'edit_theme_options',
      'sanitize_callback'   => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'key_features_section_tab_description'.$i, array(
      'type'                => 'textarea',
      'priority'            => 10,
      'section'             => 'key_features_section',
      'input_attrs'         => array(
            'placeholder'   => esc_html__( 'Enter Description', 'generator' ),
      )
    ) );
    // Key Feature Icon
    $wp_customize->add_setting('key_features_section_tab_icon'.$i,array(
      'default'             => 'fa fa-cog',
      'sanitize_callback'   => 'sanitize_text_field',
      'transport'           => 'postMessage'
    ) );
    $wp_customize->add_control(new Generator_Fontawesome_Icon_Chooser(
      $wp_customize,
      'key_features_section_tab_icon'.$i,
        array(
          'settings'        => 'key_features_section_tab_icon'.$i,
          'section'         => 'key_features_section',        
        )
    ) );
  
  }
  // End Key Features Section
  // Start Recent Posts Section
  $wp_customize->add_section( 'recent_posts_section', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Recent Posts Section', 'generator'),
    'panel'               => 'homepage_setting'
  ) );
  // Checkbox Field 
  $wp_customize->add_setting( 'hide_recent_posts_section', array(
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'generator_sanitize_checkbox',
  ) );
  $wp_customize->add_control( 'hide_recent_posts_section', array(
    'type'                => 'checkbox',
    'section'             => 'recent_posts_section', // Add a default or your own section
    'label'               => esc_html__( 'Please check this box, if you want to hide this section.', 'generator' ),
  ) );
  // Title
  $wp_customize->add_setting( 'recent_posts_section_title', array(
    'default'             => isset($generator_options['post-title'])?$generator_options['post-title']:'Recent Posts',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'recent_posts_section_title', array(
    'type'                => 'text',
    'section'             => 'recent_posts_section',
    'label'               => esc_html__('Title','generator'),
    'input_attrs'         => array(
            'placeholder' => esc_html__( 'Enter Title', 'generator' ),
      )
  ) );
  // Post Category select box
  $wp_customize->add_setting( 'our_recent_posts_section_category', array(
    'default'             => isset($generator_options['post-category'])?$generator_options['post-category']:'',
    'sanitize_callback'   => 'generator_sanitize_select',
  ) );
  $wp_customize->add_control( 'our_recent_posts_section_category', array(
    'type'                => 'select',
    'choices'             => generator_post_category(),
    'section'             => 'recent_posts_section',
    'label'               => esc_html__( 'Category', 'generator' ),
  ) );
  // End Recent Posts Section
  /* --------------------------- End Front Page Panel -------------------- */
  /* --------------------------- Start Footer Settings Panel ------------- */
  $wp_customize->add_section( 'footer_setting', array(
    'capability'          => 'edit_theme_options',
    'title'               => esc_html__('Footer Settings', 'generator'),
  ) );
  $wp_customize->add_setting( 'footerCopyright', array(
    'default'             => isset($generator_options['footertext'])?$generator_options['footertext']:'',
    'type'                => 'theme_mod',
    'capability'          => 'edit_theme_options',
    'sanitize_callback'   => 'wp_kses_post',
  ) );
  $wp_customize->add_control( 'footerCopyright', array(
    'type'                => 'textarea',
    'section'             => 'footer_setting',
    'label'               => esc_html__('Copyright Text','generator'),
    'description'         => esc_html__('Some text regarding copyright of your site, you would like to display in the footer.', 'generator'),
  ) );
  /* --------------------------- End Footer Settings Panel ------------------ */
}
add_action( 'customize_register', 'generator_customize_register' );
function generator_custom_css(){
$theme_color=get_theme_mod('generator_theme_color','#a31a1e'); 
if(get_theme_mod('about_us_background_image') != ''){
  $about_us_image=wp_get_attachment_url(get_theme_mod('about_us_background_image'));
}else{
  $about_us_image=get_template_directory_uri().'/images/single-blog-banner.png';
} ?>
<style type="text/css">
.generator-single-blog
{
  background-image: url("<?php echo esc_url($about_us_image); ?>");
} 

<?php if( get_theme_mod('hide_top_header') != '' ){ ?>
.margin-top-bottom-3{
  margin-top: 32px;
}
<?php } ?>
</style>
<?php }
add_action('wp_head','generator_custom_css',900); 

// Theme customizer Font Icon - admin css,js
function generator_customize_scripts() {
  wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/css/font-awesome.css');   
  wp_enqueue_style( 'generator-admin-style',get_template_directory_uri().'/css/admin.css', array(),'', '' );    
  wp_enqueue_script( 'generator-admin-js', get_template_directory_uri().'/js/admin.js', array( 'jquery' ), '', true );
}
add_action( 'customize_controls_enqueue_scripts', 'generator_customize_scripts' );
?>