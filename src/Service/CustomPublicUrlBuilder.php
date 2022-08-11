<?php

namespace App\Service;

use Twig\Environment;

class CustomPublicUrlBuilder
{

    public function __construct(private Environment $twig)
    {
    }

    public function build(string $repoUrl, string $packageName, string $template): string
    {
        $parts = parse_url($repoUrl);
        $parts['path_items'] = explode('/', substr($parts['path'], 1));
        $parts['package_name'] = $packageName;

        return $this->twig->createTemplate($template)->render($parts);
    }
}
