<?php
/**
 * Blog Section
 * 
 * @package Blossom_Coach
 */

$section_title    = get_theme_mod( 'blog_section_title', __( 'Latest Articles', 'blossom-coach' ) );
$readmore = get_theme_mod( 'blog_readmore', __( 'Read More', 'blossom-coach' ) );
$blog     = get_option( 'page_for_posts' );
$label    = get_theme_mod( 'blog_view_all', __( 'See More Posts', 'blossom-coach' ) );

$args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 3,
    'ignore_sticky_posts' => true
);

$qry = new WP_Query( $args );

if( $section_title || $qry->have_posts() ){ ?>
<section id="blog_section" class="blog-section">
	<div class="wrapper">    
        <?php 
        if( $section_title ) echo '<h2 class="section-title"><span>' . esc_html( $section_title ) . '</span></h2>'; 
        
        if( $qry->have_posts() ){ ?>
            <div class="article-wrap">
    			<?php 
                while( $qry->have_posts() ){
                    $qry->the_post(); ?>
                    <article class="post">
        				<figure class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                            <?php 
                                if( has_post_thumbnail() ){
                                    the_post_thumbnail( 'blossom-coach-latest', array( 'itemprop' => 'image' ) );
                                }else{ 
                                    blossom_coach_get_fallback_svg( 'blossom-coach-latest' );
                                }                            
                            ?>                        
                            </a>                            
                        </figure>
        				<header class="entry-header">
    						<div class="entry-meta"><?php blossom_coach_category(); ?></div>
    						<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    					</header>
                        <div class="entry-content">
   						   <?php the_excerpt(); ?>		
        				</div>
                        <?php if( $readmore ){ ?><a href="<?php the_permalink(); ?>" class="btn-link"><?php echo esc_html( $readmore ); ?></a><?php } ?>
        			</article>			
        			<?php 
                }
                wp_reset_postdata();
                ?>
    		</div>
    		
            <?php 
            if( $blog && $label ){ ?>
                <a href="<?php the_permalink( $blog ); ?>" class="btn-readmore"><?php echo esc_html( $label ); ?></a>
            <?php 
            } 
        } 
        ?>
	</div>
</section>
<?php 
}