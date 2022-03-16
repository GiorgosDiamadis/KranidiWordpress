<?php
get_header();

$params = array(
    'post_type' => 'post',
    'category_name' => "anakoinwseis",
    'orderby' => array
    (
        'date' => 'DESC',
        'menu_order' => 'ASC',
    ),
    'posts_per_page' => 5,

);
$query = new WP_Query($params);
$feed = array();
$feed = $query->posts;

$params = array(
    'post_type' => 'post',
    'category_name' => "anakoinwseis",

    'meta_key' => 'post_views_count',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    'posts_per_page' => 5,

);

$recent = new WP_Query($params);


?>

<section class="hero is-medium is-link" style="margin-top: -52px">
    <div class="hero-body">
        <img class="hero-img" src=" <?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), 'large') ?>" alt="">
        <div class="post-info">
            <h1 class="title hero-title">
                <?php echo $feed[0]->post_title ?>
            </h1>
            <h2 class="subtitle hero-subtitle">
                <?php the_excerpt() ?>
            </h2>
            <p class="date">
                <span><i class="fa-solid fa-calendar-day"></i></span>
                <?php echo get_the_date() ?>
            </p>
            <a href="<?php echo get_permalink($feed[0]->ID) ?>">
                <button class="button is-primary">
                    <span>Περισσότερα</span>
                    <span class="icon">
                        <i class="fa-solid fa-right-long"></i>
                    </span>
                </button>
            </a>
        </div>
    </div>

    <?php
    unset($feed[0]);
    $feed = array_values($feed);
    ?>
</section>

<div class="container is-fluid">

    <div class="columns">
        <div class="column">
            <h1 class="title mt-2">Δημοφιλέστερα</h1>
            <?php
            foreach ($recent->posts as $item) {
                $img = wp_get_attachment_image_url(get_post_thumbnail_id($item->ID), 'thumbnail');
                $link = get_permalink($item->ID);
                echo "
                        <div class='latest mt-4 mb-4'>
                            <a href='$link'>
                                <img src='$img' class='m-1' width='60px' alt=''>
                                <h1 class='title is-5'>$item->post_title</h1>
                            </a>
                        </div>
                        ";
            }
            ?>
        </div>
        <div class="column is-three-fifths">
            <div class="panel-block">
                <p class="control has-icons-left search">
                    <span class="icon is-left">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </span>
                    <input class="input" type="text" placeholder="Αναζήτηση">

                    <button class="button is-primary is-right" id="search" style="display: block;margin: auto">
                        Αναζήτηση
                    </button>
                    <button class="button is-danger" id="cancel" style="display: block;margin: auto">
                        Ακύρωση
                    </button>
                </p>
            </div>
            <div id="postsContainer">
                <?php
                $logoId = get_theme_mod('custom_logo');
                $logo = wp_get_attachment_image_src($logoId, 'full');
                $count = 0;
                foreach ($feed as $result) {
                    $title = $result->post_title;
                    $id = $result->ID;
                    $excerpt = get_the_excerpt($id);
                    $link = get_permalink($id);

                    $date = get_the_date('', $id);
                    $url = wp_get_attachment_image_url(get_post_thumbnail_id($id), "medium");
                    echo "<div class='post'>
                        <img class='post-thumbnail' src='$url' alt=''>
                       
                            <h1 class='title' style='margin-bottom: 0'>$title</h1>
                             <p class='date'>
                                <span><i class='fa-solid fa-calendar-day'></i>$date</span>
                            </p>
                            <h2 class='subtitle'>$excerpt</h2>
                            
                            <a href='$link'>
                                <button class='button is-primary'>
                                    <span>Περισσότερα</span>
                                    <span class='icon'>
                                            <i class='fa-solid fa-right-long'></i>
                                        </span>
                                </button>
                            </a>
                    </div>";
                }

                ?>
            </div>


            <button class="button is-primary" id="load-more" style="display: block;margin: auto">Φόρτωση</button>
        </div>
        <div class="column">
            <h1 class="title mt-2">Αρχείο</h1>

            <div id="post-<?php the_ID(); ?>">
                <ul>
                    <?php
                    global $wpdb;
                    $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE  post_status = 'publish' ORDER BY post_date desc");

                    foreach ($years as $year) : ?>

                        <h4 class="year-archive">
                            <li class="year-li">
                                <a class="year-a title is-4"
                                   onclick="this.nextSibling.nextSibling.classList.toggle('block')"><?php echo $year; ?><i class="fa-solid fa-angle-down"></i></a>
                                <ul class="year-ul">
                                    <?php $months = $wpdb->get_col("SELECT DISTINCT MONTH(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND YEAR(post_date) = '" . $year . "' ORDER BY post_date desc");

                                    foreach ($months as $month) :
                                        $greekMonths = array('Ιανουάριος','Φεβρουάριος','Μάρτιος','Απρίλιος','Μάϊος','Ιούνιος','Ιούλιος','Αυγουστος','Σεπτέμβριος','Οκτώβριος','Νοέμβριος','Δεκέμβριος'); ?>

                                        <h4 class="month-archive">
                                            <li class="month-li">
                                                <a class="month-a"
                                                   onclick="this.nextSibling.nextSibling.classList.toggle('block')"><?php echo $greekMonths[$month-1] ?> <i class="fa-solid fa-angle-down"></i></a>
                                                <ul class="month-ul">
                                                    <?php $theids = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'publish' AND MONTH(post_date)= '" . $month . "' AND YEAR(post_date) = '" . $year . "' ORDER BY post_date desc");

                                                    foreach ($theids as $theid):
                                                        $link = get_permalink($theid->ID)
                                                        ?>

                                                        <h4 style=font-style:italic;>
                                                            <li>
                                                                <a href="<?php echo $link?> "><?php echo $theid->post_title; ?></a>
                                                            </li>
                                                        </h4>

                                                    <?php endforeach; ?>

                                                </ul>
                                            </li>
                                        </h4>

                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </h4>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

</div>


<footer class="footer">
    <div class="content has-text-centered">
        <p>
            <strong>Bulma</strong> by <a href="https://jgthms.com">Jeremy Thomas</a>. The source code is licensed
            <a href="http://opensource.org/licenses/mit-license.php">MIT</a>. The website content
            is licensed <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY NC SA 4.0</a>.
        </p>
    </div>
</footer>

<?php
get_footer();
?>
