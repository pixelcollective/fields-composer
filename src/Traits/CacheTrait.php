<?php

namespace TinyPixel\FieldsComposer\Traits;

trait CacheTrait
{
    /**
     * Define cache parameters
     *
     * @return object self
     */
    public function usingCache()
    {
        $this->cache = (object) [
            'id'     => $this->cacheId(),
            'expiry' => $this->cacheExpiry(),
        ];

        return $this;
    }

    /**
     * Returns unique cache id
     *
     * @return string
     */
    public function cacheId()
    {
        return "fields-{$this->post->post_type}-{$this->post->post_name}";
    }

    public function cacheExpiry()
    {
        return isset($this->cacheExpiry) ? $this->cacheExpiry : 0;
    }
}
