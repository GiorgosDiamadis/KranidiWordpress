<?php
get_header();
$id = get_option("page_on_front");
$images = get_post_meta($id, "kranidifrontpage_carousel");
$links = array();
$info = array();


for ($i = 0; $i < count($images); $i++) {

    $attachment = get_post($images[$i]);
    $alt = get_post_meta($attachment->ID, "_wp_attachment_image_alt", true);
    $caption = $attachment->post_excerpt;
    $color = $attachment->post_content;
    $title = $attachment->post_title;
    $link = wp_get_attachment_image_url($attachment->ID, "full");


    array_push($info, array("caption" => $caption, "color" => $color, 'title' => $title, "link" => $link));
}

?>
<div class="slider-container">
    <div class="left-slide">
        <?php
        for ($i = 0; $i < count($info); $i++) {
            $item_title = $info[$i]["title"];
            $item_caption = $info[$i]["caption"];
            $color = $info[$i]["color"];
            echo "<div style='background-color: $color'>
                                <h1 class='title'>$item_title</h1>
                                <h2 class='subtitle'>$item_caption</h2>
                        </div>";
        }
        ?>
    </div>

    <div class="right-slide">
        <?php

        for ($i = 0; $i < count($info); $i++) {
            $url = $info[$i]["link"];
            echo "<div style='background-image: url($url)'></div>";
//            echo "<img class='mt-0'  src='$url' alt='$alt'/>";
        }
        ?>
    </div>


    <div class="action-buttons">
        <button class="button is-responsive">
            Επόμενο
        </button>
        <button class="button is-responsive">
            Προηγούμενο
        </button>
    </div>
</div>
<?php
get_footer();
?>
