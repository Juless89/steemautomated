
<?php /* Template Name: Voting */ ?>

<script type='text/javascript' src='http://steemchain.eu/wp-content/plugins/maxbuttons/js/min/front.js?ver=7.3.1'></script>
<style type='text/css'>.maxbutton-1.maxbutton.maxbutton-steemconnect{position:relative;text-decoration:none;display:inline-block;vertical-align:middle;border-color:#505ac7;width:160px;height:50px;border-top-left-radius:4px;border-top-right-radius:4px;border-bottom-left-radius:4px;border-bottom-right-radius:4px;border-style:solid;border-width:2px;background-color:rgba(80, 90, 199, 1);-webkit-box-shadow:0px 0px 2px 0px #333;-moz-box-shadow:0px 0px 2px 0px #333;box-shadow:0px 0px 2px 0px #333}.maxbutton-1.maxbutton:hover.maxbutton-steemconnect{border-color:#505ac7;background-color:rgba(255, 255, 255, 1);-webkit-box-shadow:0px 0px 2px 0px #333;-moz-box-shadow:0px 0px 2px 0px #333;box-shadow:0px 0px 2px 0px #333}.maxbutton-1.maxbutton.maxbutton-steemconnect .mb-text{color:#fff;font-family:Tahoma;font-size:15px;text-align:center;font-style:normal;font-weight:normal;padding-top:18px;padding-right:0px;padding-bottom:0px;padding-left:0px;line-height:1em;box-sizing:border-box;display:block;background-color:unset}.maxbutton-1.maxbutton:hover.maxbutton-steemconnect .mb-text{color:#505ac7}
</style><!--/email_off--><!--/noptimize-->

<?php
/**
 * Template Name: Fullwidth Template
 *
 * The template for the full-width page.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

get_header();



/**
 * Don't display page header if header layout is set as classic blog.
 */
do_action( 'hestia_before_single_page_wrapper' ); ?>

<div class="<?php echo hestia_layout(); ?>">
	<?php
	$class_to_add = '';
	if ( class_exists( 'WooCommerce' ) && ! is_cart() ) {
		$class_to_add = 'blog-post-wrapper';
	}
	?>
	<div class="blog-post <?php echo esc_attr( $class_to_add ); ?>">
		<div class="container">
			<?php
			if ( class_exists( 'WooCommerce' ) && ( is_cart() || is_checkout() ) ) {
				?>
				<div class="row">
					<div class="col-sm-12">
						<h1 class="hestia-title"><?php single_post_title(); ?></h1>
					</div>
				</div>
				<?php
			}
			if ( have_posts() ) :

				// import steemconnet authentication
				include 'authenticate.php';

				// see if current user is logged in and has authenticated voting
				// permissions in the database
				global $wpdb;
				$current_user = wp_get_current_user();

				echo '<div>';
				if ($current_user->user_login == ''){
					echo '<div align="center"><br><h1>You need to <a href="https://ste' .
					'emautomated.eu/wp-login.php?action=wordpress_social_authenticate&' .
					'mode=login&provider=Steemconnect&redirect_to=' . get_permalink() .
					'">log in</a></h1></div>';
				} else {
					$results = $wpdb->get_results('SELECT * FROM `steem_authorization` ' .
					'WHERE `user_login` = "' . $current_user->user_login . '"');
							if (count($results) == 0){
								echo '<div align="center"><h1><br>Authorize <font color=' .
								'"blue">@steemautomated</font> to vote for you.</h1><br><a ' .
								'class="maxbutton-1 maxbutton maxbutton-steemconnect" href=' .
								'"https://steemconnect.com/oauth2/authorize?client_id=' .
								'steemautomated&redirect_uri=' . get_permalink() .'&response_' .
								'type=code&scope=offline,vote"><span class="mb-text">' .
								'Authorize</span></a></div><br>';
					}
				}
				echo '</div>';

				while ( have_posts() ) :
					the_post();
					// Show table only for logged in users
					if (count($results) != 0) {
						get_template_part( 'template-parts/content-fullwidth', 'page' );
					}
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile;
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
			?>
		</div>
	</div>

	<?php get_footer(); ?>
