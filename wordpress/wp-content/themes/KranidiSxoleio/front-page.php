<?php
require_once __DIR__ . "/classes/Helper.php";
get_header();
$helper = Helper::GetConnect();

$posts = $helper->Fetch();
$id = get_option('page_on_front');
$img = wp_get_attachment_image_url(get_post_thumbnail_id($id),'full')

?>

<section class="section section-header-offset container hero">
    <h1 >Πρώτο Δημοτικό Σχολείο Κρανιδίου</h1>
    <img src="<?= $img ?>" alt="">
    <p >Στην ιστοσελίδα μας θα βρείτε χρήσιμες πληροφορίες για τη λειτουργία του καθώς και για εκδηλώσεις και δραστηριότητες που πραγματοποιούνται από μαθητές και εκπαιδευτικούς.</p>
</section>

<!-- Featured articles -->
<section class="featured-articles section section-header-offset container">

    <?php
    for ($i = 0; $i < 1; $i++) {
        $posts[$i]->Loose();
    }
    ?>

</section>

<!-- Older posts -->
<section class="older-posts section">

    <div class="container">

        <h2 class="title section-title">Παλαιότερα</h2>

        <div id="posts-container" class="older-posts-grid-wrapper d-grid">
            <?php
            for ($i = 1; $i < count($posts); $i++) {
                $posts[$i]->Feed();
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
