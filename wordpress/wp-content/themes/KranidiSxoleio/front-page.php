<?php
require_once __DIR__ . "/classes/Helper.php";
get_header();
$helper = Helper::GetConnect();

$popular = $helper->GetPopular();
$oldest = $popular[count($popular) - 1]->post;

?>

<!-- Featured articles -->
<section class="featured-articles section section-header-offset">

    <div class="featured-articles-container container d-grid">

        <div class="featured-content d-grid">

            <?php
            for ($i = 0; $i < 3; $i++) {
                $popular[$i]->Featured($i + 1);
            }
            ?>
        </div>

        <div class="sidebar d-grid">

            <h3 class="title featured-content-title">Δημοφιλέστερα</h3>
            <?php
            for (; $i < count($popular); $i++) {
                $popular[$i]->Trending($i - 2);
            }
            ?>
        </div>

    </div>

</section>

<!-- Older posts -->
<section class="older-posts section">

    <div class="container">

        <h2 class="title section-title" data-name="Παλαιοτερα">Παλαιότερα</h2>

        <div id="posts-container" class="older-posts-grid-wrapper d-grid">
            <?php
            $older = $helper->Fetch($oldest->ID);
            foreach ($older as $item) {
                $item->Feed();
            }
            ?>


        </div>

        <div class="see-more-container">
            <a href="/arthra" class="btn see-more-btn place-items-center">Περισσοτερα <i class="ri-arrow-right-s-line"></i></i>
            </a>
        </div>

    </div>

</section>

<?php
get_footer()
?>
