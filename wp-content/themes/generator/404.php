<?php 
/**
 * 404 page template file
**/
get_header(); ?>
<div class="container container-generator">
    <div class="col-md-12 generator-post no-padding">
            <div class="jumbotron">
			    <h1><?php esc_html_e('Epic 404 - Article Not Found','generator'); ?></h1>
				<p><?php esc_html_e('This is embarrassing. We could not find what you were looking for.','generator'); ?></p>
            <section class="post_content">
              	<p><?php esc_html_e('Whatever you were looking for was not found, but maybe try looking again or search using the form below.','generator'); ?></p>
                <div class="row">
                    <div class="col-sm-12">
                    <form action="<?php echo esc_url(home_url()); ?>/" class="search-form" method="get" role="search">
                    <?php get_search_form(); ?>
                    </form>								
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php get_footer(); ?>