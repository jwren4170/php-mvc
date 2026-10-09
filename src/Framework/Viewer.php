<?php

namespace Framework;

class Viewer
{
    public function render(string $view, array $data = []): string
    {
        extract($data, EXTR_SKIP);

        ob_start();

        require_once dirname(__DIR__, 2) . '/views/' . $view . '.php';

        return ob_get_clean();
    }
}
