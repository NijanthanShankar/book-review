<?php
/**
 * Template Name: Review Template
 */

get_header();

$book_name    = get_post_meta(get_the_ID(), '_book_name', true);
$book_author  = get_post_meta(get_the_ID(), '_book_author', true);
$book_rating  = get_post_meta(get_the_ID(), '_book_rating', true);
$book_excerpt = get_post_meta(get_the_ID(), '_book_excerpt', true);
?>

<div class="modern-post-container">
    <div class="book-review-card">
        <div class="book-thumbnail">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('full'); ?>
            <?php endif; ?>

            <?php if ($book_name) : ?>
                <h3 class="book-title"><?php echo esc_html($book_name); ?></h3>
            <?php endif; ?>

            <?php if ($book_author) : ?>
                <p class="book-author"><?php echo esc_html($book_author); ?></p>
            <?php endif; ?>
        </div>

        <div class="book-card-content">
            <div class="book-header">
                <h1 class="book-title"><?php the_title(); ?></h1>
                <p class="book-author"><?php the_author(); ?></p>
            </div>

            <div class="book-rating">
                <div class="stars">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        $is_filled = $i <= intval($book_rating);
                        echo '<span class="star ' . ($is_filled ? 'filled' : 'empty') . '">'
                            . ($is_filled ? '★' : '☆') . '</span>';
                    }
                    ?>
                </div>
                <span class="rating-text"><?php echo esc_html($book_rating); ?>/5</span>
            </div>

            <div class="book-excerpt">
                <?php
                if (!empty($book_excerpt)) {
                    echo wp_kses_post(wpautop($book_excerpt));
                } else {
                    the_content();
                }
                ?>
            </div>

            <div class="book-footer">
                <div class="review-date"><?php echo get_the_date(); ?></div>
                <a href="<?php echo esc_url(site_url('/book-reviews')); ?>" class="read-more-btn">
                    Back to Reviews
                </a>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
