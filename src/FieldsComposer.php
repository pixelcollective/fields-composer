<?php

namespace TinyPixel\FieldsComposer;

use \TinyPixel\FieldsComposer\Traits\{
    CacheTrait,
    GroupsTrait,
};

use function \get_post;
use function \get_the_ID;

use \Roots\Acorn\View\Composer;

class FieldsComposer extends Composer
{
    use Traits\GroupsTrait;

    public function __construct()
    {
        $this->useGroups();
    }

    /**
     * Construct
     */
    public function useGroups()
    {
        $this
            ->setupPost()
            ->usingCache()
            ->withFields();
    }

    /**
     * Setup post
     *
     * @return object self
     */
    public function setupPost()
    {
        $this->post = get_post(get_the_ID());

        return $this;
    }
}
