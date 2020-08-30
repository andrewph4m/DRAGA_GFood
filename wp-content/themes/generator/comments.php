<?php
/**
 * The template for displaying Comments.
 *
 */
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return; ?>
<div class="clearfix"></div>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
    <h1 class="comments-title">
	<?php
	 /* translators: 1: comment count number */
     printf(esc_html(_n('%1$s Comment', '%1$s Comments', get_comments_number(), 'generator')), esc_attr(number_format_i18n(get_comments_number())), get_the_title()); ?></span></h2>
	</h1>
    <ul>
    <?php	
	wp_list_comments( array( 'callback' => 'generator_comment', 'short_ping' => true) ); ?>
    </ul>
       <?php paginate_comments_links(); ?>     
	<?php endif; // have_comments() ?>
	<?php comment_form(); ?>
</div><!-- #comments .comments-area -->