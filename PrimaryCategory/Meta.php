<?php
namespace PrimaryCategory;

class Meta
{
    public function configureMeta()
    {
        add_action('add_meta_boxes', array($this, 'addMeta'));
        add_action('save_post', array($this, 'save'));
    }

    /**
     * Adds a meta box, containing a primary category select box, to all posts in the admin panel.
     *
     * @return void
     */
    public function addMeta()
    {
        /**
         * Loads all post types, including Custom Post Types.
         */
        $postTypes = get_post_types();

        /**
         * Iterates over the post types.
         * Adds the meta box to each post type.
         * Excludes the "Page" post type.
         */
        foreach ($postTypes as $postType) {

            /**
             * Skips the page post type.
             */
            if ($postType === 'page') {
                continue;
            }

            /**
             * Adds the meta box.
             */
            add_meta_box(
            // Meta box key, should be unique.
                'rdbi_primary_category',

                // Meta box title.
                'Primary Category',

                // Callback that includes the content of the meta box.
                array($this, 'metaContent'),

                // Add the meta box to the current post type in the loop.
                $postType,

                // Add to the sidebar.
                'side',

                // High priority, which is still forced to the bottom.
                'high'
            );
        }
    }

    /**
     * Callback for addMetaBox().
     *
     * @return void
     */
    public function metaContent()
    {
        global $post;

        $primaryCategory = '';

        /**
         * Gets the primary category meta.
         */
        $selectedCategory = get_post_meta($post->ID, 'rdbi_primary_category', true);

        /**
         * If a primary category is selected, populate the select box appropriately.
         */
        if ($selectedCategory !== '') {
            $primaryCategory = $selectedCategory;
        }

        /**
         * Get all categories attached to this post.
         */
        $attachedCategories = get_the_category();

        /**
         * Start the output string.
         */
        $string = '<label for="rdbi_primary_category">';
        $string .= 'Select Primary Category';
        $string .= '</label>';
        $string .= '<select style="width: 100%;" name="rdbi_primary_category" id="rdbi_primary_category">';

        /**
         * Add default choice for "No Primary Category".
         */
        $string .= '<option value="">No Primary Category</option>';
        /**
         * Iterate over the post categories.
         * Add each one to the output string.
         * Mark the selected category as selected.
         */
        foreach ($attachedCategories as $category) :
            $string .= '<option value="';
            $string .= $category->name;
            $string .= '" ';
            $string .= selected($primaryCategory, $category->name, false);
            $string .= '>';
            $string .= $category->name;
            $string .= '</option>';
        endforeach;

        $string .= '</select>';

        /**
         * Echo the output string.
         */
        echo $string;
    }

    /**
     * Saves the primary category.
     *
     * @return void
     */
    public function save()
    {
        global $post;
        if (isset($_POST['rdbi_primary_category'])) {
            $primaryCategory = sanitize_text_field($_POST['rdbi_primary_category']);
            update_post_meta($post->ID, 'rdbi_primary_category', $primaryCategory);
        }
    }
}
