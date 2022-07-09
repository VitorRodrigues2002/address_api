<?php

    if (!function_exists('serializePath')) {
        function serializePath(string $path): string
        {
            return str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);
        }
    }
