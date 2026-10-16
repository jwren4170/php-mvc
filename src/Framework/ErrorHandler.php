<?php declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\PageNotFoundException;
use ErrorException;

class ErrorHandler
{
    public static function handleError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

    public static function handleException(\Throwable $exception): void
    {
        $showErrors = filter_var($_ENV['SHOW_ERRORS'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if ($exception instanceof PageNotFoundException) {
            http_response_code(404);
            $template = '404.php';
        } else {
            http_response_code(500);
            $template = '500.php';
        }

        if ($showErrors) {
            ini_set('display_errors', '1');
            echo '<pre>' . htmlspecialchars((string) $exception, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</pre>';
        } else {
            ini_set('display_errors', '0');
            ini_set('log_errors', '1');
            require dirname(__DIR__, 2) . "/views/$template";
        }
    }
}
