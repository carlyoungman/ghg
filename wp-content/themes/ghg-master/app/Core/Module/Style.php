<?php

namespace BOILERPLATE_THEME\Core\Module;

use BOILERPLATE_THEME\Concerns\FileUtil;

class Style
{
	use FileUtil;

	private const STYLES = [
		'frontend' => [
			'frontend-theme' => '/dist/css/style.css',
		],
		'backend' => [
			'backend-theme' => '/dist/css/admin.css',
		],
	];

	private const BASE_PATH = BOILERPLATE_THEME_PATH;
	private const BASE_URL = BOILERPLATE_THEME_URL;

	public static function register(): void
	{
		self::enqueue_styles('frontend');
	}

	private static function enqueue_styles(string $type): void
	{
		foreach (self::STYLES[$type] as $handle => $uri) {
			self::enqueue_style($handle, $uri);
		}
	}

	private static function enqueue_style(string $handle, string $uri): void
	{
		$path = self::BASE_PATH . $uri;
		if (!file_exists($path)) {
			// Optionally log error or handle missing file scenario
			return;
		}
		$url = self::BASE_URL . $uri;
		$version = filemtime($path);
		wp_enqueue_style(
			BOILERPLATE_NAMESPACE . '_' . $handle,
			$url,
			[], // dependencies could be added here
			$version
		);
		wp_style_add_data($handle, 'rtl', 'replace');
	}

	public static function register_backend(): void
	{
		wp_enqueue_style(
			'admin-stylesheet',
			get_template_directory_uri() . '/dist/css/admin.css',
			[],
			'1.0',
			'all'
		);
	}
}
