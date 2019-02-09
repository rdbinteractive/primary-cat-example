<?php

namespace PrimaryCategory;


class Display
{
    public $queryArgs;

    public function __construct($args)
    {
        $this->queryArgs = [
            'post_type' => $args['post_type'],
            'meta_query' => array(
                array(
                    'key' => 'rdbi_primary_category',
                    'value' => $args['primary_category'],
                ),
            ),

        ];
    }

    public function WPQueryObject()
    {
        $query = new \WP_Query($this->queryArgs);
        return $query;
    }
}
