<?php
/**
 * Template Name: Single Page
 * Description: A Template for displaying pages in a single page.
 *
 */
get_header();
?>
<main id="main" role="main">
<div id="<?php echo preg_replace('/\s+/', '', get_the_title());  ?>">
	<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
	<?php endwhile;  ?>
</div>
<?php
$pageid = get_the_ID();
$args = array(
	'sort_order' => 'ASC',
	'child_of' => $pageid,
	'sort_column' => 'menu_order', 
	'hierarchical' => 1,
	'exclude' => '',
	'exclude_tree' => '',
	'number' => '',
	'offset' => 0,
	'post_type' => 'page',
	'post_status' => 'publish'
);

$pages = get_pages($args);


foreach ($pages as $page_data) {
    $content = apply_filters('the_content', $page_data->post_content);
    $title = $page_data->post_title;
    $id = preg_replace('/\s+/', '', $title);
    $slug = $page_data->post_name;
    $bgcolor = get_post_meta( $page_data->ID, '_cmb_background_colorpicker', true );
    $bgimage = get_post_meta( $page_data->ID, '_cmb_background_image', true );
    $descriptiontext = get_post_meta( $page_data->ID, '_cmb_description_text', true );
    $headingstyle = get_post_meta( $page_data->ID, '_cmb_heading_style', true );

?>
<div id='<?php echo "$id"; ?>' class="page" style='background-color:<?php echo $bgcolor ?>;<?php  if (!empty($bgimage)) { echo "background-image:url($bgimage);"; } ?>' >
	<div class="grid">
		<div class="c12 end">
			<?php if($headingstyle == "dropcap"){
				echo "<p class='drop-cap zoo-page-title'>$title  - <span>$descriptiontext</span></p>";
			}
			elseif ($headingstyle == "standard") {
				echo "<h1>$title</h1>";
				echo "<p class='zoo-page-title'><span>$descriptiontext</span></p>";
			}
			elseif ($headingstyle == "noheading") {
				echo "<p class='zoo-page-title'><span>$descriptiontext</span></p>";
			}
			?>
		</div>
		<?php echo "$content"; ?>
	</div>
</div>

<?php } ?>

</main>
<?php get_footer(); ?>

