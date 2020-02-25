<?php
/**
 * Blossom Coach Template Functions which enhance the theme by hooking into WordPress
 *
 * @package Blossom_Coach
 */

if( ! function_exists( 'blossom_coach_doctype' ) ) :
/**
 * Doctype Declaration
*/
function blossom_coach_doctype(){
    ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'blossom_coach_doctype', 'blossom_coach_doctype' );

if( ! function_exists( 'blossom_coach_head' ) ) :
/**
 * Before wp_head 
*/
function blossom_coach_head(){
    ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php
}
endif;
add_action( 'blossom_coach_before_wp_head', 'blossom_coach_head' );

if( ! function_exists( 'blossom_coach_page_start' ) ) :
/**
 * Page Start
*/
function blossom_coach_page_start(){
    ?>
    <div id="page" class="site"><a aria-label="skip to content" class="skip-link" href="#content"><?php esc_html_e( 'Skip to Content', 'blossom-coach' ); ?></a>
    <?php
}
endif;
add_action( 'blossom_coach_before_header', 'blossom_coach_page_start', 20 );

if( ! function_exists( 'blossom_coach_top_bar' ) ) :
/**
 * Top bar
*/
function blossom_coach_top_bar(){ 
    $newsletter_shortcode = get_theme_mod( 'header_newsletter' );
    if( blossom_coach_is_btnw_activated() && $newsletter_shortcode && has_shortcode( $newsletter_shortcode, 'BTEN' ) ){ ?>
    <div class="sticky-t-bar">
		<div class="sticky-bar-content">
			<div class="wrapper">
				<?php echo do_shortcode( wp_kses_post( $newsletter_shortcode ) ); ?>
			</div>
		</div>
        <button aria-label="sticky bar close" class="close"></button>
	</div>
    <?php
    }
}
endif;
add_action( 'blossom_coach_header', 'blossom_coach_top_bar', 15 );

if( ! function_exists( 'blossom_coach_header' ) ) :
/**
 * Header Start
*/
function blossom_coach_header(){     
    $ed_cart   = get_theme_mod( 'ed_shopping_cart', true ); 
    $ed_search = get_theme_mod( 'ed_header_search', false );
    $phone     = get_theme_mod( 'phone' );
    $email     = get_theme_mod( 'email' );
    ?>
    <header id="masthead" class="site-header" itemscope itemtype="http://schema.org/WPHeader">		
		<?php if( $phone || $email || blossom_coach_social_links( false ) || $ed_search ){ ?>
        <div class="header-t">
			<div class="wrapper">
			<?php
                if( $phone || $email ){ 
                    echo '<div class="top-left">';					
                    if( $phone ) echo '<span><i class="fa fa-phone"></i><a href="' . esc_url( 'tel:' . preg_replace( '/\D/', '', $phone ) ) . '"><span class="phone">' . esc_html( $phone ) . '</span></a></span>';
                    if( $email ) echo '<span><i class="fa fa-envelope"></i><a href="' . esc_url( 'mailto:' . sanitize_email( $email ) ) . '"><span class="email">' . esc_html( $email ) . '</span></a></span>';                    
				    echo '</div><!-- .top-left -->';
				} 
                
                if( blossom_coach_social_links( false ) || $ed_search ){
                    echo '<div class="top-right">';
                    if( blossom_coach_social_links( false ) ){
                        echo '<div class="header-social">';
                        blossom_coach_social_links();
                        echo '</div><!-- .header-social -->';
                    }
                    
                    if( $ed_search ){
                        echo '<div class="header-search"><button aria-label="search form toggle"><i class="fa fa-search"></i></button><div class="header-search-form"><button aria-label="search form close" class="close"></button>';
                        get_search_form();
                        echo '</div></div><!-- .header-seearch -->';
                    }	
				    echo '</div><!-- .top-right -->';
                } 
            ?>
			</div><!-- .wrapper -->            				 
		</div><!-- .header-t -->
        <?php } ?>
        
        <div class="main-header">
			<div class="wrapper">
                <?php 
                $site_title       = get_bloginfo( 'name' );
                $site_description = get_bloginfo( 'description', 'display' );
                $header_text    = get_theme_mod( 'header_text', 1 );
                if( has_custom_logo() || $site_title || $site_description || $header_text ) : 
                    if( has_custom_logo() && ( $site_title || $site_description ) && $header_text ) {
                        $branding_class = ' icon-text';
                    }else{
                        $branding_class = '';
                    } ?>
    				<div class="site-branding<?php echo esc_attr( $branding_class ); ?>" itemscope itemtype="http://schema.org/Organization">
                        <?php 
                        if( has_custom_logo() ){
                            echo '<div class="site-logo">';
                            the_custom_logo();
                            echo '</div><!-- .site-logo -->';
                        } 
                        ?>
                        <?php if( $site_title || $site_description ) :
    					    if( $branding_class ) echo '<div class="site-title-wrap">';
    						if ( is_front_page() ) : ?>
                                <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                            <?php else : ?>
                                <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                            <?php endif; 
                            $description = get_bloginfo( 'description', 'display' );
                            if ( $description || is_customize_preview() ){ ?>
                                <p class="site-description"><?php echo esc_html( $description ); ?></p>
                            <?php
                            }
                            if( $branding_class ) echo '</div>';
                        endif; ?>
                    </div><!-- .site-branding -->
                <?php endif; ?>
				<div class="menu-wrap">
					<nav id="site-navigation" class="main-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
                        <button type="button" class="toggle-button">
                            <span class="toggle-bar"></span>
                            <span class="toggle-bar"></span>
                            <span class="toggle-bar"></span>
                        </button>
                        <?php
            				wp_nav_menu( array(
            					'theme_location' => 'primary',
            					'menu_id'        => 'primary-menu',
                                'fallback_cb'    => 'blossom_coach_primary_menu_fallback',
            				) );
            			?>
                    </nav><!-- #site-navigation -->					
                    <?php if( blossom_coach_is_woocommerce_activated() && $ed_cart ) blossom_coach_wc_cart_count(); ?>
				</div><!-- .menu-wrap -->
			</div><!-- .wrapper -->
		</div><!-- .main-header -->				
	</header><!-- .site-header -->
    <?php 
}
endif;
add_action( 'blossom_coach_header', 'blossom_coach_header', 20 );

if( ! function_exists( 'blossom_coach_blog_banner' ) ) :
/**
 * Display Banner section in Blog Home Page
*/
function blossom_coach_blog_banner(){
    if( is_home() && is_front_page() )
    get_template_part( 'sections/banner' );
}
endif;
add_action( 'blossom_coach_after_header', 'blossom_coach_blog_banner' );

if( ! function_exists( 'blossom_coach_content_start' ) ) :
/**
 * Content Start
*/
function blossom_coach_content_start(){ 
    $home_sections = blossom_coach_get_home_sections(); 
    
    if ( ! is_front_page() && ! is_home() ) blossom_coach_breadcrumb();
    
    if( !( is_front_page() && ! is_home() && $home_sections ) ){ ?>
        <div id="content" class="site-content">        
            <?php if( is_archive() || is_search() ){ ?>
            <header class="page-header">
    			<div class="wrapper">
                <?php 
                    if( is_archive() ){ 
                        if( is_author() ){ ?>
                            <div class="author-img"><?php echo get_avatar( get_the_author_meta( 'ID' ), 120 ); ?></div>
        					<div class="author-content-wrap">
        						<h1 class="page-title">
        							<?php printf( esc_html__( 'All posts by %1$s%2$s%3$s', 'blossom-coach' ), '<span class="vcard">', esc_html( get_the_author_meta( 'display_name' ) ), '</span>' );?>
        						</h1>    						
        					</div>    
                            <?php
                        }else{
                            the_archive_title();
                            the_archive_description( '<div class="archive-description">', '</div>' );
                        }                                   
                    }
                    
                    if( is_search() ){ 
                        echo '<h1 class="page-title">' . esc_html__( 'You Are Looking For', 'blossom-coach' ) . '</h1>';
                        get_search_form();
                    }
                    ?>
                </div><!-- .wrapper -->
    		</header><!-- .page-header -->
                <?php
            } ?>
            <div class="wrapper">
            <?php
    }        
}
endif;
add_action( 'blossom_coach_content', 'blossom_coach_content_start' );

if( ! function_exists( 'blossom_coach_post_count' ) ) :
/**
 * Post counts in search and archive page.
*/
function blossom_coach_post_count(){
    if( is_search() || is_archive() ){
        global $wp_query;
        printf( esc_html__( '%1$sShowing %2$s%3$s Result(s)%4$s', 'blossom-coach' ), '<span class="showing-result">', '<span class="result">', number_format_i18n( $wp_query->found_posts ), '</span></span>' );
    }        
}
endif;
add_action( 'blossom_coach_before_posts_content', 'blossom_coach_post_count' );

if ( ! function_exists( 'blossom_coach_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function blossom_coach_post_thumbnail(){
	global $wp_query;
    $image_size  = 'thumbnail';
    $ed_featured = get_theme_mod( 'ed_featured_image', true );
    $blog_layout = get_theme_mod( 'blog_page_layout', 'grid' );
    $sidebar     = blossom_coach_sidebar(); ?>
    <figure class="post-thumbnail">
    <?php
    if( is_home() ){
        if( $blog_layout == 'classic' ){
            $image_size = ( $sidebar ) ? 'blossom-coach-with-sidebar' : 'blossom-coach-fullwidth';
        }else{
            $image_size = 'blossom-coach-blog';
        }
        echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="thumbnailUrl">';
        if( has_post_thumbnail() ){
            the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
        }else{
            blossom_coach_get_fallback_svg( $image_size );
        }
        echo '</a>';
    }elseif( is_archive() || is_search() ){
        echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="thumbnailUrl">';
        if( has_post_thumbnail() ){
            the_post_thumbnail( 'blossom-coach-blog', array( 'itemprop' => 'image' ) );    
        }else{
            blossom_coach_get_fallback_svg( 'blossom-coach-blog' );
        }
        echo '</a>';
    }elseif( is_singular() ){
        $image_size = ( $sidebar ) ? 'blossom-coach-with-sidebar' : 'blossom-coach-fullwidth';
        if( is_single() ){
            if( $ed_featured ) the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
        }else{
            the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
        }
    }
    ?>
    </figure><!-- .post-thumbnail -->
    <?php
}
endif;
add_action( 'blossom_coach_before_posts_entry_content', 'blossom_coach_post_thumbnail' );
add_action( 'blossom_coach_before_post_entry_content', 'blossom_coach_post_thumbnail', 15 );
add_action( 'blossom_coach_before_page_entry_content', 'blossom_coach_post_thumbnail', 20 );

if( ! function_exists( 'blossom_coach_entry_header' ) ) :
/**
 * Entry Header
*/
function blossom_coach_entry_header(){ 
    $class = is_page() ? 'page-header' : 'entry-header';
    ?>
    <header class="<?php echo esc_attr( $class ); ?>">
		<?php             
            if( is_singular() ){
                blossom_coach_category();
            }else{
                echo '<div class="entry-meta">';
                blossom_coach_category();    
                echo '</div>';
            }
            
            if ( is_singular() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
    		else :
    			the_title( '<h3 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
    		endif; 
        
            if( is_single() && 'post' === get_post_type() ){
                echo '<div class="entry-meta">';                
                blossom_coach_posted_on();
                blossom_coach_posted_by();
                blossom_coach_comment_count();
                echo '</div>';
            }		
		?>
	</header>         
    <?php    
}
endif;
add_action( 'blossom_coach_posts_entry_content', 'blossom_coach_entry_header', 15 );
add_action( 'blossom_coach_before_post_entry_content', 'blossom_coach_entry_header', 20 );
add_action( 'blossom_coach_before_page_entry_content', 'blossom_coach_entry_header', 15 );

if( ! function_exists( 'blossom_coach_entry_content' ) ) :
/**
 * Entry Content
*/
function blossom_coach_entry_content(){ 
    $ed_excerpt = get_theme_mod( 'ed_excerpt', true ); ?>
    <div class="entry-content" itemprop="text">
		<?php
			if( is_singular() || ! $ed_excerpt || ( get_post_format() != false ) ){
                the_content();    
    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blossom-coach' ),
    				'after'  => '</div>',
    			) );
            }else{
                the_excerpt();
            }
		?>
	</div><!-- .entry-content -->
    <?php
}
endif;
add_action( 'blossom_coach_posts_entry_content', 'blossom_coach_entry_content', 20 );
add_action( 'blossom_coach_post_entry_content', 'blossom_coach_entry_content', 15 );
add_action( 'blossom_coach_page_entry_content', 'blossom_coach_entry_content', 15 );

if( ! function_exists( 'blossom_coach_entry_footer' ) ) :
/**
 * Entry Footer
*/
function blossom_coach_entry_footer(){ 
    $readmore = get_theme_mod( 'read_more_text', __( 'Continue Reading', 'blossom-coach' ) ); ?>
	<footer class="entry-footer">
		<?php
			if( is_singular() ){
			    blossom_coach_tag();
			}else{
			    echo '<a href="' . esc_url( get_the_permalink() ) . '" class="btn-link">' . esc_html( $readmore ) . '</a>';    
            }
            
            if( get_edit_post_link() ){
                edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'blossom-coach' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
            }
		?>
	</footer><!-- .entry-footer -->
	<?php 
}
endif;
add_action( 'blossom_coach_posts_entry_content', 'blossom_coach_entry_footer', 25 );
add_action( 'blossom_coach_post_entry_content', 'blossom_coach_entry_footer', 20 );
add_action( 'blossom_coach_page_entry_content', 'blossom_coach_entry_footer', 20 );

if( ! function_exists( 'blossom_coach_author' ) ) :
/**
 * Author Section
*/
function blossom_coach_author(){ 
    $ed_author = get_theme_mod( 'ed_post_author', false );
    
    if( ! $ed_author && get_the_author_meta( 'description' ) ){ ?>
    <div class="author-profile">
		<div class="author-img"><?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?></div>
		<div class="author-content-wrap">
			<?php 
                printf( esc_html__( '%1$sAbout %2$s%3$s%4$s', 'blossom-coach' ), '<h1 class="author-name">', '<span class="vcard">', esc_html( get_the_author_meta( 'display_name' ) ), '</span></h1>' );                
                echo '<div class="author-desc">' . wp_kses_post( get_the_author_meta( 'description' ) ) . '</div>';
            ?>		
		</div><!-- .author-content-wrap -->
	</div><!-- .author-profile -->
    <?php
    }
}
endif;
add_action( 'blossom_coach_after_post_content', 'blossom_coach_author', 15 );

if( ! function_exists( 'blossom_coach_newsletter_block' ) ) :
/**
 * Newsletter Section
*/
function blossom_coach_newsletter_block(){ 
    $ed_newsletter = get_theme_mod( 'ed_newsletter', false );
    $newsletter    = get_theme_mod( 'newsletter_shortcode' ); 
    if( $ed_newsletter && $newsletter ){ ?>
    <div class="newsletter-block">
		<?php echo do_shortcode( wp_kses_post( $newsletter ) ); ?>
	</div>    
    <?php
    }
}
endif;
add_action( 'blossom_coach_after_post_content', 'blossom_coach_newsletter_block', 20 );

if( ! function_exists( 'blossom_coach_navigation' ) ) :
/**
 * Navigation
*/
function blossom_coach_navigation(){
    if( is_single() ){
        $next_post = get_next_post();
        $prev_post = get_previous_post();
        
        if( $prev_post || $next_post ){?>            
            <nav class="navigation pagination" role="navigation">
    			<h2 class="screen-reader-text"><?php esc_html_e( 'Post Navigation', 'blossom-coach' ); ?></h2>
    			<div class="nav-links">
    				<?php if( $prev_post ){ ?>
                    <div class="nav-previous">
						<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" rel="prev">
							<span class="meta-nav"><i class="fa fa-angle-left"></i></span>
							<figure>
                                <?php
                                $prev_img = get_post_thumbnail_id( $prev_post->ID );
                                if( $prev_img ){
                                    $prev_url = wp_get_attachment_image_url( $prev_img, 'thumbnail' );
                                    echo '<img src="' . esc_url( $prev_url ) . '" alt="' . esc_attr( strip_tags( get_the_title( $prev_post->ID ) ) ) . '">';                                        
                                }else{
                                    blossom_coach_get_fallback_svg( 'thumbnail' ); //fallback
                                }
                                ?>
                            </figure>
							<span class="post-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></span>
						</a>
					</div>
					<?php } ?>
                    <?php if( $next_post ){ ?>
                    <div class="nav-next">
						<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" rel="next">
							<span class="meta-nav"><i class="fa fa-angle-right"></i></span>
							<figure>
                                <?php
                                $next_img = get_post_thumbnail_id( $next_post->ID );
                                if( $next_img ){
                                    $next_url = wp_get_attachment_image_url( $next_img, 'thumbnail' );
                                    echo '<img src="' . esc_url( $next_url ) . '" alt="' . esc_attr( strip_tags( get_the_title( $next_post->ID ) ) ) . '">';                                        
                                }else{
                                    blossom_coach_get_fallback_svg( 'thumbnail' ); //fallback
                                }
                                ?>
                            </figure>
							<span class="post-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></span>
						</a>
					</div>
                    <?php } ?>
    			</div>
    		</nav>        
            <?php
        }
    }else{
        the_posts_pagination( array(
            'prev_text'          => __( 'Previous', 'blossom-coach' ),
            'next_text'          => __( 'Next', 'blossom-coach' ),
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'blossom-coach' ) . ' </span>',
        ) );
    }
}
endif;
add_action( 'blossom_coach_after_post_content', 'blossom_coach_navigation', 25 );
add_action( 'blossom_coach_after_posts_content', 'blossom_coach_navigation' );

if( ! function_exists( 'blossom_coach_related_posts' ) ) :
/**
 * Related Posts 
*/
function blossom_coach_related_posts(){ 
    $ed_related_post = get_theme_mod( 'ed_related', true );
    if( $ed_related_post ){
        blossom_coach_get_posts_list( 'related' );
    }
}
endif;                                                                               
add_action( 'blossom_coach_after_post_content', 'blossom_coach_related_posts', 30 );

if( ! function_exists( 'blossom_coach_latest_posts' ) ) :
/**
 * Latest Posts
*/
function blossom_coach_latest_posts(){ 
    blossom_coach_get_posts_list( 'latest' );
}
endif;
add_action( 'blossom_coach_latest_posts', 'blossom_coach_latest_posts' );

if( ! function_exists( 'blossom_coach_comment' ) ) :
/**
 * Comments Template 
*/
function blossom_coach_comment(){
    // If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
}
endif;
add_action( 'blossom_coach_after_post_content', 'blossom_coach_comment', 35 );
add_action( 'blossom_coach_after_page_content', 'blossom_coach_comment' );

if( ! function_exists( 'blossom_coach_content_end' ) ) :
/**
 * Content End
*/
function blossom_coach_content_end(){ 
    $home_sections = blossom_coach_get_home_sections();
    
    if( !( is_front_page() && ! is_home() && $home_sections ) ){ ?>            
        </div><!-- .wrapper -->        
    </div><!-- .site-content -->
    <?php
    }
}
endif;
add_action( 'blossom_coach_before_footer', 'blossom_coach_content_end', 20 );

if( ! function_exists( 'blossom_coach_newsletter_section' ) ) :
/**
 * Newsletter Section
*/
function blossom_coach_newsletter_section(){ 
    $ed_newsletter = get_theme_mod( 'ed_newsletter', false );
    $newsletter    = get_theme_mod( 'newsletter_shortcode' );
    if( blossom_coach_is_btnw_activated() && $ed_newsletter && $newsletter && has_shortcode( $newsletter, 'BTEN' ) && ! is_single() ){ ?>
    <section class="newsletter-section">
		<div class="wrapper">
			<?php echo do_shortcode( wp_kses_post( $newsletter ) ); ?>
		</div>
	</section> <!-- .newsletter-section -->
    <?php    
    }
}
endif;
add_action( 'blossom_coach_before_footer', 'blossom_coach_newsletter_section', 25 );

if( ! function_exists( 'blossom_coach_footer_start' ) ) :
/**
 * Footer Start
*/
function blossom_coach_footer_start(){
    ?>
    <footer id="colophon" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
    <?php
}
endif;
add_action( 'blossom_coach_footer', 'blossom_coach_footer_start', 20 );

if( ! function_exists( 'blossom_coach_footer_top' ) ) :
/**
 * Footer Top
*/
function blossom_coach_footer_top(){    
    $footer_sidebars = array( 'footer-one', 'footer-two', 'footer-three', 'footer-four' );
    $active_sidebars = array();
    $sidebar_count   = 0;
    
    foreach ( $footer_sidebars as $sidebar ) {
        if( is_active_sidebar( $sidebar ) ){
            array_push( $active_sidebars, $sidebar );
            $sidebar_count++ ;
        }
    } 
    
    if( $active_sidebars ){ ?>
        <div class="top-footer">
    		<div class="wrapper">
    			<div class="grid column-<?php echo esc_attr( $sidebar_count ); ?>">
                <?php foreach( $active_sidebars as $active ){ ?>
                    <div class="col">
                       <?php dynamic_sidebar( $active ); ?> 
                    </div>
                <?php } ?>
                </div>
    		</div><!-- .wrapper -->
    	</div><!-- .top-footer -->
        <?php 
    }   
}
endif;
add_action( 'blossom_coach_footer', 'blossom_coach_footer_top', 30 );

if( ! function_exists( 'blossom_coach_footer_bottom' ) ) :
/**
 * Footer Bottom
*/
function blossom_coach_footer_bottom(){ ?>
    <div class="bottom-footer">
		<div class="wrapper">
			<div class="copyright">            
            <?php
                blossom_coach_get_footer_copyright();
                echo esc_html__( ' Blossom Coach | Developed By ', 'blossom-coach' );                
                echo '<a href="' . esc_url( 'https://blossomthemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Blossom Themes', 'blossom-coach' ) . '</a>.' ;                
                printf( esc_html__( ' Powered by %s', 'blossom-coach' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'blossom-coach' ) ) .'" target="_blank">WordPress</a>.' );
                if ( function_exists( 'the_privacy_policy_link' ) ) {
                    the_privacy_policy_link();
                }
            ?>               
            </div>
		</div><!-- .wrapper -->
	</div><!-- .bottom-footer -->
    <?php
}
endif;
add_action( 'blossom_coach_footer', 'blossom_coach_footer_bottom', 40 );

if( ! function_exists( 'blossom_coach_back_to_top' ) ) :
/**
 * Back To Top
*/
function blossom_coach_back_to_top(){ ?>
    <button aria-label="go to top" class="back-to-top">
		<span><?php esc_html_e( '&#10140;', 'blossom-coach' ); ?></span>
	</button>
    <?php
}
endif;
add_action( 'blossom_coach_footer', 'blossom_coach_back_to_top', 45 );

if( ! function_exists( 'blossom_coach_footer_end' ) ) :
/**
 * Footer End 
*/
function blossom_coach_footer_end(){ ?>
    </footer><!-- #colophon -->
    <?php
}
endif;
add_action( 'blossom_coach_footer', 'blossom_coach_footer_end', 50 );

if( ! function_exists( 'blossom_coach_page_end' ) ) :
/**
 * Page End
*/
function blossom_coach_page_end(){ ?>
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'blossom_coach_after_footer', 'blossom_coach_page_end', 20 );