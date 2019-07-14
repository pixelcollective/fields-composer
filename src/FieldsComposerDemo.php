<?php

namespace App\Composers;

use \TinyPixel\FieldsComposer\FieldsComposer;
use \Illuminate\View\View;

class FieldsComposerDemo extends FieldComposer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        // 'partials.post-fields-*',
        // 'partials.header',
        // ...
    ];

    /**
     * Expiration time of cache in seconds
     *
     * @var int
     */
    public $cacheExpiry = 3600;

    /**
     * Data to be passed to view before rendering.
     *
     * @param  array $data
     * @param  \Illuminate\View\View $view
     * @return array
     */
    public function with($data, $view)
    {
        return $data = [
            'myFields' => $this->fields(),
            'myFieldGroup' => $this->fields('myFieldGroup'),
            'myFieldGroupItem' => $this->fields('myFieldGroup')->groupItem,
            'myFieldGroupSubItem' => $this->fields('myFieldGroup')->groupItem['subItem'],
        ];
    }
}
