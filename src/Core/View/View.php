<?php

namespace Core\View;

use Core\Support\Config;

class View
{
    protected static string $layout = 'layouts/layout';

    /**
     * Змінити layout
     */
    public static function setLayout(string $layout): void
    {
        self::$layout = $layout;
    }

    /**
     * @throws \RuntimeException
     */
    public static function render(string $view, array $params = []): string
    {
        $viewPath   = Config::getInstance()->get('app.view_path');
        $viewFile   = "{$viewPath}/{$view}.php";
        $layoutFile = "{$viewPath}/" . self::$layout . ".php";

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View not found: {$viewFile}");
        }

        if (!file_exists($layoutFile)) {
            throw new \RuntimeException("Layout not found: {$layoutFile}");
        }

        extract($params, EXTR_SKIP);

        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        ob_start();
        include $layoutFile;
        return ob_get_clean();
    }
}
