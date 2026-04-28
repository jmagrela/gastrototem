<?php
/**
 * Gastrototem Astra Child — functions.php
 */

// Enqueue parent + child styles, plus our custom CSS & JS
add_action('wp_enqueue_scripts', function () {
    // Astra parent
    wp_enqueue_style('astra-parent', get_template_directory_uri() . '/style.css');

    // Child base (required by WP)
    wp_enqueue_style(
        'gastrototem-child',
        get_stylesheet_uri(),
        ['astra-parent'],
        wp_get_theme()->get('Version')
    );

    // Google Fonts
    wp_enqueue_style(
        'gastrototem-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500;600;700;900&display=swap',
        [],
        null
    );

    // Custom CSS
    wp_enqueue_style(
        'gastrototem-main',
        get_stylesheet_directory_uri() . '/assets/css/gastrototem.css',
        ['gastrototem-fonts'],
        wp_get_theme()->get('Version')
    );

    // Custom JS (footer)
    wp_enqueue_script(
        'gastrototem-main',
        get_stylesheet_directory_uri() . '/assets/js/gastrototem.js',
        [],
        wp_get_theme()->get('Version'),
        true
    );

    // Pass data to JS
    wp_localize_script('gastrototem-main', 'gastrototem', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('gastrototem_nonce'),
    ]);
});

// Note: Astra header/footer disable filters are at the bottom of this file
// (they handle both custom page templates and single posts).

// Register nav menus
register_nav_menus([
    'gastrototem_main' => __('Gastrototem — Menú principal', 'gastrototem-astra-child'),
]);

// Override Astra global colors so they don't conflict with our templates
add_action('customize_register', function ($wp_customize) {
    // Set Astra heading color to inherit (let our CSS control it)
    $wp_customize->get_setting('astra-settings[heading-base-color]')?->default;
});

// Force Astra heading color to 'inherit' via dynamic CSS
add_filter('astra_dynamic_theme_css', function ($css) {
    $css .= '
    /* Gastrototem: neutralize Astra heading colors on custom templates */
    .gt-page h1, .gt-page h2, .gt-page h3,
    .gt-page h4, .gt-page h5, .gt-page h6 {
        color: inherit;
    }
    ';
    return $css;
});

// Helper: logo URL
function gt_logo_url($variant = 'white') {
    return get_stylesheet_directory_uri() . '/assets/img/logo-gastrototem-' . $variant . '.svg';
}

// Helper: asset URL
function gt_asset($path) {
    return get_stylesheet_directory_uri() . '/assets/' . ltrim($path, '/');
}

// ─── Blog / Criterio ────────────────────────────────────────────────

// Reading time estimate (Spanish average: ~220 wpm)
function gt_reading_time($content) {
    $word_count = str_word_count(wp_strip_all_tags($content));
    $minutes = max(1, round($word_count / 220));
    return $minutes;
}

// Get the first category of a post (used as "primary category")
function gt_post_primary_category() {
    $cats = get_the_category();
    if (empty($cats)) {
        return null;
    }
    // Skip "Uncategorized" if there's something better
    foreach ($cats as $cat) {
        if ($cat->slug !== 'uncategorized' && $cat->slug !== 'sin-categoria') {
            return $cat;
        }
    }
    return $cats[0];
}

// Register default blog categories on theme activation
add_action('after_switch_theme', function () {
    $categories = ['Cocina', 'Sala', 'Experiencia', 'Método', 'Cultura'];
    foreach ($categories as $name) {
        if (!term_exists($name, 'category')) {
            wp_insert_term($name, 'category');
        }
    }
});

// Set blog posts permalink to /criterio/slug/
add_action('init', function () {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/criterio/%postname%/');
});

// Disable Astra header/footer on single posts too (uses our custom header/footer)
add_filter('astra_header_disable', function ($disable) {
    if (is_page_template() && str_starts_with(get_page_template_slug(), 'templates/')) {
        return true;
    }
    if (is_single()) {
        return true;
    }
    return $disable;
});

add_filter('astra_footer_disable', function ($disable) {
    if (is_page_template() && str_starts_with(get_page_template_slug(), 'templates/')) {
        return true;
    }
    if (is_single()) {
        return true;
    }
    return $disable;
});
