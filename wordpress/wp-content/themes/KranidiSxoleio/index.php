<?php
get_header();
require_once __DIR__ . "/classes/Post.php";
?>

<section class="older-posts section">

    <div class="container">

        <h2 class="title" style="text-align: center;margin: 5rem 0" data-name="Παλαιοτερα">Ολα τα άρθρα</h2>

        <div id="posts-container" class="older-posts-grid-wrapper d-grid">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    $categories = get_the_category(get_the_ID());
                    $flag = false;
                    foreach ($categories as $category) {

                        if ($category->slug == "ekpaideutikoi") {
                            $flag = true;
                            break;
                        }
                    }

                    if ($flag == true) {
                        continue;
                    }
                    $post = new Post(get_the_ID());
                    $post->Feed();

                }
            }
            ?>
        </div>
        <?php the_posts_pagination(); ?>
    </div>
</section>

<?php get_footer() ?>
