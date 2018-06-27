<?php
namespace Catalog;

class CatalogChecker
{
    public static function check(?string $dir, string $appDir): bool
    {
        if (!$dir) {
            throw new \Exception('Catalog not specified. Script usage example: php run.php -d=/var/www/files');
        }

        $path = self::getFullPath($dir, $appDir);

        if (is_dir($path)) {
            return true;
        }

        return false;
    }

    public static function getFullPath(string $dir, string $appDir): string
    {
        if (preg_match("/^..\//", $dir)) {
            return $appDir . '/' . $dir;
        }

        if (preg_match("/^.\//", $dir)) {
            return $appDir . substr($dir, 1, mb_strlen($dir) - 1);
        }

        if (preg_match("/^\//", $dir)) {
            return $dir;
        }

        return $appDir . '/' . $dir;
    }
}