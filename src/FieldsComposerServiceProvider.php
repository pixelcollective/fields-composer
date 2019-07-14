<?php

namespace TinyPixel\FieldsComposer;

use \Roots\Acorn\ServiceProvider;

use function \add_action;
use function \Roots\base_path;
use function \Roots\config_path;

use \Illuminate\Support\Collection;
use \Illuminate\Support\Facades\Cache;

class FieldsComposerServiceProvider extends ServiceProvider
{
    /**
      * Register any application services.
      *
      * @return void
      */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $files = collect([
            'cacheConfig' => "./config/cache.php",
            'demo' => "./Composers/FieldsComposerDemo.php",
        ]);

        $this->publishes([
            "FieldsComposerDemo.php" => base_path('app/Composers/FieldsComposerDemo.php'),

            !file_exists(config_path('cache.php')) ??
                "./config/cache.php" => config_path('cache.php'),
        ]);

        Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }
                return $value;
            });
        });

        add_action('transition_post_status', [
            $this, 'onStatusTransition'
        ], 10, 3);
    }

    /**
     * On Status Transition
     *
     * @param WP_Post $post
     */
    public function onStatusTransition($new_status, $old_status, $post)
    {
        Cache::flush();
    }
}
