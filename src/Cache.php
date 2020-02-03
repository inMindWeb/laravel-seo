<?php
namespace IMW\LaravelMeta;

use Illuminate\Support\Facades\Cache;

class Cache
{

	/**
	 * Get or cache item based on context
	 *
	 * @param  object|string $context
	 * @return string
	 */
	public static function get($context): string
	{
		$key = 'meta_'. (is_object($context) ? get_class($context) : $context);

		return Cache::driver(config('metacache.driver'))
					->tags('laravel_meta')
					->remember($key, config('metacache.ttl'), function() use ($context)
					{
						return Meta::generate($context, true);
					});
	}

	/**
	 * Flush cache
	 *
	 * @return void
	 */
	public static function flush(): void
	{
		Cache::driver(config('metacache.driver'))->tags('laravel_meta')->flush();
	}

}
