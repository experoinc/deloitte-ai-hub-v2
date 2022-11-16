<?php

/*
Template Name: PillarTemplate
*/

get_header(); ?>

<?php
function cats($cats)
{
    $payload = array();
    foreach ($cats as $cat) {
        // echo var_dump($cat);
        $payload[] = $cat;
    }
    return $payload;
}
function tags($tags)
{
    $payload = array();
    foreach ($tags as $tag) {
        $payload[] = '<span class="tag text-xs border mr-1">' . $tag->name . '</span>';
    }
    return $payload;
}
function getHeroTexts($id)
{
    // 21 = learn 
    // 527 = explore 
    // 24 = apply
    // 17 = connect
    switch ($id) {
        case 21:
            $hero = (object) [
                'title' => 'Learn',
                'desc' => 'Trainings & other resources that enable you to develop technical skills aournd AI.',
                'hero' => '/wordpress/wp-content/uploads/2022/11/Learn-1.png'
            ];
            return $hero;
        case 527:
            $hero = (object) [
                'title' => 'Explore',
                'desc' => "Find resources that enable you to advance your understanding of Deloitte's approach to AI and learn about our current work.",
                'hero' => '/wordpress/wp-content/uploads/2022/11/Explore-1.png'
            ];
            return $hero;
        case 24:
            $hero = (object) [
                'title' => 'Apply',
                'desc' => 'Links to resources and forums that enable you to explore opportunities to apply you AI skill and connect to others in the firm who are working in AI.',
                'hero' => '/wordpress/wp-content/uploads/2022/11/Advance-1.png'
            ];
            return $hero;
        case 17:
            $hero = (object) [
                'title' => 'Connect',
                'desc' => "Discover platforms where you can share what you've learned through mentorship, teaching, and eminence opportunities",
                'hero' => '/wordpress/wp-content/uploads/2022/11/Contribute-1.png'
            ];
            return $hero;
    };
}
$heroData = getHeroTexts($post->ID);
$mainCategory = get_category_by_slug($pagename);
$subCategoriesIds = get_term_children($mainCategory->term_id, 'category');
$subCategories = get_categories(array(
    'orderby' => 'name',
    'order'   => 'ASC',
    'hide_empty' => false,
    'term_taxonomy_id' => $subCategoriesIds
));
$postsKey = array_filter($subCategories, function ($c) {
    return str_contains($c->slug, "key-resource");
});
$postsArgs = array('category' => array_shift(array_values($postsKey))->term_id);
$topPosts = get_posts($postsArgs);
?>
<?php echo '<div class="relative overflow-hidden bg-no-repeat bg-cover" style="
    background-position: 50%;
    background-image: url(' . $heroData->hero . ');
    height: 350px;
  >' ?>
<div class="absolute top-0 right-0 bottom-0 left-0 w-full h-full overflow-hidden bg-fixed" style="background-color: rgba(0, 0, 0, 0.75)">
    <div class="gm-container flex items-center h-full">
        <div class="text-white md:px-12 !pl-0">
            <h1 class="text-5xl font-medium mt-0 mb-6"><?php echo $heroData->title ?></h1>
            <h3 class="text-3xl font-light mb-8"><?php echo $heroData->desc ?></h3>
        </div>
    </div>
</div>
</div>
<section class="pillar-top">
    <?php if (count($topPosts) > 0) echo '<h2 class="text-2xl capitalize gm-container mt-12 mb-5">Key resources to get you started</h2><hr class="gm-container">' ?>
    <div class="pillar-post-container gm-container mb-5">
        <ul class="wp-block-post-template font-sans space-between">
            <?php foreach ($topPosts as $top) {
                $meta = get_post_meta($top->ID);
                $tags = wp_get_post_tags($top->ID);
                $cats = wp_get_post_categories($top->ID, array('fields' => 'names'));
                $r = '<li class="wp-block-post-template min-w-[300px] search-item shadow-none flex-nowrap overflow-hidden overflow-ellipsis"><div class="post-tags-container">
                ' . implode("", tags($tags)) . '</div>
                <h2 class="text-lg font-semibold wp-block-post-title">
                  <a href="' . $meta['_links_to'][0] . '">' . $top->post_title . '</a>
                </h2>
                <div class="wp-block-post-terms">' . implode(',', cats($cats)) . '</div>
                <div class="wp-block-post-excerpt__excerpt overflow-hidden whitespace-nowrap overflow-ellipsis !mb-0">' . $top->post_excerpt . '</div>
              </li>';
                echo $r;
            } ?>
        </ul>
        <?php if (count($topPosts) > 3) echo '<button type="button" class="car-btn-right z-[1000]"><i class="fa fa-chevron-circle-right"></i></button>' ?>
    </div>
</section>
<div class="page-search flex flex-col mx-auto bg-white font-roboto pt-10 pb-20 gm-container">
    <h2 class="text-2xl capitalize mb-5">Browse resources for <?php echo $pagename ?></h2>
    <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-0" id="tabs-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a cat-id="-1" href="#tabs-all" class="
                nav-link
                block
                font-medium
                text-xs
                leading-tight
                uppercase
                border-x-0 border-t-0 border-b-2 border-transparent
                px-6
                py-3
                my-2
                hover:border-transparent hover:bg-gray-100
                focus:border-transparent
                " id="tabs-all-tab" data-bs-toggle="pill" data-bs-target="#tabs-all" role="tab" aria-controls="tabs-all" aria-selected="true">All</a>
        </li>
        <?php
        foreach ($subCategories as $key => $categoryTerm) {
            if (str_contains($categoryTerm->slug, "key-resource")) continue;
            $currTab = '<li class="nav-item" role="presentation"><a cat-id="' . $categoryTerm->cat_ID . '" href="#tabs-' . str_replace(" ", "", $categoryTerm->cat_name) . '" class="
            nav-link
            block
            font-medium
            text-xs
            leading-tight
            uppercase
            border-x-0 border-t-0 border-b-2 border-transparent
            px-6
            py-3
            my-2
            hover:border-transparent hover:bg-gray-100
            focus:border-transparent" id="tabs-' . preg_replace('/&(amp;)/', '', str_replace(" ", "", $categoryTerm->cat_name)) . '-tab" 
            data-bs-toggle="pill" data-bs-target="#tabs-' . preg_replace('/&(amp;)/', '', str_replace(" ", "", $categoryTerm->cat_name)) . '" role="tab" 
            aria-controls="tabs-' . preg_replace('/&(amp;)/', '', str_replace(" ", "", $categoryTerm->cat_name)) . '" 
            aria-selected="' . ($key > 0 ? "false" : "true") . '">' . $categoryTerm->cat_name . '</a></li>';
            echo $currTab;
        }
        ?>
    </ul>

    <?php echo '<div class="tab-content" id="tabs-tabContent">
  <div class="tab-pane fade show active" id="tabs-' . $pagename . '" role="tabpanel" aria-labelledby="tabs-' . $pagename . '-tab">
  <ul id="ajax-posts" class="wp-block-post-template font-sans space-between !mt-0">
      </ul>
  </div>' ?>
</div>
</main>

<?php
get_footer(); ?>