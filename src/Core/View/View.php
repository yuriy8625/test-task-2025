<?php

namespace Core\View;

use Core\Support\Config;

class View
{
    /**
     * @throws \Exception
     */
    public static function render(string $view, array $params = []): string
    {
        extract($params);

        $file = Config::getInstance()->get('app.view_path') . "/{$view}.php";
        if (!file_exists($file)) {
            throw new \Exception("View {$view} not found");
        }

        ob_start();
        include $file;
        $content = ob_get_clean();

        return include Config::getInstance()->get('app.view_path') . '/layouts/layout.php';
    }
}