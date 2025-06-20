<?php
/**
 * Plugin Name:       Book Reviews Manager
 * Plugin URI:        https://github.com/NijanthanShankar/book-review
 * Description:       Manage and display book reviews with ratings. Use "[book-reviews]" shortcode to display it in frontend.
 * Version:           1.0.0
 * Requires at least: 5.6
 * Requires PHP:      7.4
 * Author:            Nijanthan Shankar
 * Author URI:        https://github.com/NijanthanShankar
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       book-reviews
 * Domain Path:       /languages
 */


if (!defined('ABSPATH')) exit;

class BookReviewsPlugin {

    public function __construct() {
        add_action('init', [$this, 'init']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_meta_boxes']);
        add_shortcode('book_reviews', [$this, 'display_reviews_shortcode']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
    }

    public function init() {
        $this->register_post_type();
    }

    public function register_post_type() {
        $labels = [
            'name' => __('Book Reviews', 'book-reviews'),
            'singular_name' => __('Book Review', 'book-reviews'),
            'menu_name' => __('Book Reviews', 'book-reviews'),
            'add_new' => __('Add New Review', 'book-reviews'),
            'add_new_item' => __('Add New Book Review', 'book-reviews'),
            'edit_item' => __('Edit Book Review', 'book-reviews'),
            'new_item' => __('New Book Review', 'book-reviews'),
            'view_item' => __('View Book Review', 'book-reviews'),
            'search_items' => __('Search Book Reviews', 'book-reviews'),
            'not_found' => __('No book reviews found', 'book-reviews'),
            'not_found_in_trash' => __('No book reviews found in trash', 'book-reviews'),
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'book-review'],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-book-alt',
            'supports' => ['title', 'editor', 'thumbnail'],
        ];

        register_post_type('book_review', $args);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'book_review_details',
            __('Book Details', 'book-reviews'),
            [$this, 'render_meta_box'],
            'book_review',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post) {
        wp_nonce_field('book_review_meta_box', 'book_review_nonce');

        $book_name = get_post_meta($post->ID, '_book_name', true);
        $book_author = get_post_meta($post->ID, '_book_author', true);
        $book_rating = get_post_meta($post->ID, '_book_rating', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="book_name"><?php _e('Book Name', 'book-reviews'); ?></label></th>
                <td><input type="text" id="book_name" name="book_name" value="<?php echo esc_attr($book_name); ?>" class="regular-text" required></td>
            </tr>
            <tr>
                <th><label for="book_author"><?php _e('Author', 'book-reviews'); ?></label></th>
                <td><input type="text" id="book_author" name="book_author" value="<?php echo esc_attr($book_author); ?>" class="regular-text" required></td>
            </tr>
            <tr>
                <th><label for="book_rating"><?php _e('Rating (1-5)', 'book-reviews'); ?></label></th>
                <td>
                    <select id="book_rating" name="book_rating" required>
                        <option value=""><?php _e('Select Rating', 'book-reviews'); ?></option>
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <option value="<?php echo $i; ?>" <?php selected($book_rating, $i); ?>><?php echo $i . ' ' . str_repeat('★', $i); ?></option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php
    }

    public function save_meta_boxes($post_id) {
        if (!isset($_POST['book_review_nonce']) || !wp_verify_nonce($_POST['book_review_nonce'], 'book_review_meta_box')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;
        if (get_post_type($post_id) !== 'book_review') return;

        $fields = ['book_name', 'book_author', 'book_rating'];

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $value = sanitize_text_field($_POST[$field]);

                if ($field === 'book_rating') {
                    $value = intval($value);
                    if ($value < 1 || $value > 5) continue;
                }

                update_post_meta($post_id, '_' . $field, $value);
            }
        }
    }

    public function display_reviews_shortcode($atts) {
        $atts = shortcode_atts([
            'limit' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
            'columns' => 3,
        ], $atts);

        $query = new WP_Query([
            'post_type' => 'book_review',
            'posts_per_page' => intval($atts['limit']),
            'orderby' => sanitize_text_field($atts['orderby']),
            'order' => sanitize_text_field($atts['order']),
            'post_status' => 'publish',
        ]);

        if (!$query->have_posts()) return '<p class="no-reviews">' . __('No book reviews found.', 'book-reviews') . '</p>';

        $columns = max(1, min(4, intval($atts['columns'])));

        ob_start();
        ?>
        <div class="book-reviews-grid" data-columns="<?php echo $columns; ?>">
            <?php while ($query->have_posts()) : $query->the_post();
                $book_name = get_post_meta(get_the_ID(), '_book_name', true);
                $book_author = get_post_meta(get_the_ID(), '_book_author', true);
                $book_rating = get_post_meta(get_the_ID(), '_book_rating', true);
                $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            ?>
                <div class="book-review-card">
                    <?php if ($thumbnail) : ?>
                        <div class="book-thumbnail">
                            <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($book_name); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="book-card-content">
                        <div class="book-header">
                            <h3 class="book-title"><?php echo esc_html($book_name); ?></h3>
                            <p class="book-author"><?php echo esc_html($book_author); ?></p>
                            <div class="book-rating">
                                <div class="stars">
                                    <?php for ($i = 1; $i <= 5; $i++) {
                                        echo '<span class="star ' . ($i <= intval($book_rating) ? 'filled' : 'empty') . '">' . ($i <= intval($book_rating) ? '★' : '☆') . '</span>';
                                    } ?>
                                </div>
                                <span class="rating-text"><?php echo $book_rating; ?>/5</span>
                            </div>
                        </div>

                        <div class="book-excerpt">
                            <?php echo wp_kses_post(wp_trim_words(get_the_content(), 20, '...')); ?>
                        </div>

                        <div class="review-by">
                            <p class="review-author"><?php the_author(); ?></p>
                        </div>

                        <div class="book-footer">
                            <div class="review-date"><?php echo get_the_date(); ?></div>
                            <a href="<?php echo get_permalink(); ?>" class="read-more-btn"><?php _e('Read Full Review', 'book-reviews'); ?></a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
        return ob_get_clean();
    }

    public function enqueue_styles() {
        global $post;
        $should_load = is_singular('book_review') || ($post && has_shortcode($post->post_content, 'book_reviews'));

        if ($should_load) {
            wp_enqueue_style(
                'book-reviews-style',
                plugin_dir_url(__FILE__) . 'assets/css/book-review.css',
                [],
                '1.0.0'
            );
        }
    }
}

add_filter('template_include', function($template) {
    if (is_singular('book_review')) {
        $custom = plugin_dir_path(__FILE__) . 'templates/single-book-review.php';
        if (file_exists($custom)) return $custom;
    }
    return $template;
});

new BookReviewsPlugin();

register_activation_hook(__FILE__, function() {
    (new BookReviewsPlugin())->register_post_type();
    flush_rewrite_rules();
});

register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
