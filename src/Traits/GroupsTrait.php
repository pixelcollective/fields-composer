<?php

namespace TinyPixel\FieldsComposer\Traits;

use \WP_Post;
use \Illuminate\Support\Arr;
use \Illuminate\Support\Collection;
use \Illuminate\Support\Facades\Cache;

use function \get_fields;
use function \get_field_objects;

trait GroupsTrait
{
    use CacheTrait;

    /**
     * Custom field values for post from group name
     *
     * @return \Illuminate\Support\Collection
     */
    public function raw()
    {
        if ($this->fieldData) {
            return $this->fieldData->get('raw');
        }
    }

    /**
     * Returns post custom fields
     *
     * @param string subset
     */
    public function fields($subset = null)
    {
        if ($this->fieldData) {
            $results = !$subset
                ? (object) $this->fieldData
                : (object) collect($this->fieldData->get($subset));

            return (object) collect($results)->recursive()->toArray();
        }
    }

    /**
     * Collection of post's custom fields
     *
     * @param \WP_Post $post
     * @return \Illuminate\Support\Collection
     */
    public function withFields()
    {
        if (!function_exists('get_field_objects') || !$this->post) {
            return;
        }

        $this->fieldData = $this->collectFieldsFromCache();
    }

    public function collectFieldsFromCache()
    {
        return Cache::remember($this->cache->id, $this->cache->expiry, function () {
            return $this->collectAllFields($this->post);
        });
    }

    /**
     * Collects fields
     *
     * @return \Illuminate\Support\Collection
     */
    public function collectAllFields(WP_Post $post)
    {
        return collect(\get_fields($post->ID));
    }
}
