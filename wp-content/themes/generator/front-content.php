<?php $generator_options = get_option( 'faster_theme_options' ); ?>
<div class="col-md-12 generator-post no-padding">
<?php for($generator_section_i=1; $generator_section_i <=4 ;$generator_section_i++ ):  ?>
		<div class="col-md-3 generator-sidebar">
		<aside class="sidebar-widget widget widget_generator_widget" id="generator_widget-3">
			<?php if(get_theme_mod('key_features_section_tab_icon'.$generator_section_i,'fa fa-cog') != '') 
			{ ?>
			<div class="font-icon-size ">
			        <i class="fa icon-center <?php echo esc_attr(get_theme_mod('key_features_section_tab_icon'.$generator_section_i,'fa fa-cog')); ?>"></i>
			</div>
			<?php } ?>
		    <h3 class="theme-title-14"><?php if(get_theme_mod('key_features_section_tab_title'.$generator_section_i,isset($generator_options['section-title-'.$generator_section_i])?$generator_options['section-title-'.$generator_section_i]:'Lorem Ispum') != '') { echo esc_html(get_theme_mod('key_features_section_tab_title'.$generator_section_i,isset($generator_options['section-title-'.$generator_section_i])?$generator_options['section-title-'.$generator_section_i]:'Lorem Ispum')); } ?></h3>       
		    <p class="theme-text"><?php if(get_theme_mod('key_features_section_tab_description'.$generator_section_i,isset($generator_options['section-content-'.$generator_section_i])?$generator_options['section-content-'.$generator_section_i]:'') != '') { echo esc_html(get_theme_mod('key_features_section_tab_description'.$generator_section_i,isset($generator_options['section-content-'.$generator_section_i])?$generator_options['section-content-'.$generator_section_i]:'')); } ?></p>      
		</aside>
		<div class="clearfix"></div>
		</div>
		<?php endfor; ?>
		</div>