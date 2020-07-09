<?php 
/*
Template Name: page-template-trangchu
*/
get_header(); 
?>	
<div class="page-wrapper">
	<div id="content">
		<div class="g_content">
			<div class="container">
				<div class="wrap_list_idx">
					<?php    
					$parent  = get_categories(array('parent'=>0)); 
					foreach ( $parent as $category ) {
						//print_r($category);
						$args = array(
							'cat' => $category->term_id,
							'post_type' => 'post',
							'posts_per_page' => 3,
						);
						$query = new WP_Query( $args );

						if ( $query->have_posts() ) { ?>
							<div class="<?php echo $category->name; ?> tg_listing">
								<?php  $catgory_id = get_cat_ID($category->name);
								$category_link = get_category_link( $catgory_id );
								?>
								<div class="list_subcat">
									<h2><a href="<?php echo esc_url( $category_link ); ?>" ><?php echo $category->name; ?></a></h2>
								</div>
								<?php  
								$get_children_cats = array(
                    'child_of' => $catgory_id  //get children of this parent using the catID variable from earlier
                );
                $child_cats = get_categories( $get_children_cats );//get children of parent category
                ?>
                <ul class="list_post_category row">
                <?php
                foreach( $child_cats as $child_cat ){
                        //for each child category, get the ID
                	$childID = $child_cat->cat_ID;

                	?>
                	
                		<?php
                		$query_child = new WP_Query( array( 'cat'=> $childID, 'posts_per_page'=>4 ) );
                		?>
                		<?php while ( $query_child->have_posts() ) {
                			$query_child->the_post();
                			?>
                			<li class="list_post_category_item col-sm-4 pw">
                				<?php if ( has_post_thumbnail() ) { ?>
                					<div class="wrap_thumb">
                						<?php  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );  ?>
                						<figure class="bg_figure" style="background:url('<?php echo $image[0]; ?>');"> 
                							<a href="<?php the_permalink();?>"></a>
                						</figure>
                					</div>
                				<?php } ?>
                				<div class="post_wrap_content">

                					<div class="post_meta">

                						<?php echo get_cat_name($childID); ?>
                						<p><?php the_time('d/m/Y');?> </p>
                					</div>
                					<h2 class="post_title">
                						<a href="<?php the_permalink(); ?>">
                							<?php the_title(); ?>
                						</a>
                					</h2>
                					<div class="excerpt">
                						<p><?php echo excerpt(30); ?></p>
                					</div>
                				</div>
                			</li>
                		<?php } // end while ?>
                	
                	
                <?php  } ?>
                </ul>
            </div>
                     <?php } // end if
                        // Use reset to restore original query.
                     wp_reset_postdata();
                 }
                 ?>
             </div>
         </div>

     </div>

 </div>
</div>
<?php get_footer(); ?>
