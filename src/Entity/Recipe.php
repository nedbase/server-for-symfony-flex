<?php

/*
 * This file is part of the moay server-for-symfony-flex package.
 *
 * (c) moay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\RecipeRepo\RecipeRepo;

class Recipe implements \JsonSerializable
{
    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $package;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $localPath;

    /**
     * @var RecipeRepo
     */
    private $repo;

    /** @var string */
    private $publicUrl;

    /**
     * @var string
     */
    private $repoSlug;

    /**
     * @var array
     */
    private $manifest;

    /**
     * @var bool
     */
    private $manifestValid;

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getPackage()
    {
        return $this->package;
    }

    public function setPackage(string $package)
    {
        $this->package = $package;
    }

    /**
     * @return string
     */
    public function getOfficialPackageName()
    {
        return implode('/', [$this->author, $this->package]);
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getLocalPath()
    {
        return $this->localPath;
    }

    public function setLocalPath(string $localPath)
    {
        $this->localPath = $localPath;
    }

    /**
     * @return RecipeRepo
     */
    public function getRepo()
    {
        return $this->repo;
    }

    public function setRepo(RecipeRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return string
     */
    public function getRepoSlug()
    {
        return $this->repoSlug;
    }

    public function setRepoSlug(string $repoSlug)
    {
        $this->repoSlug = $repoSlug;
    }

    /**
     * @return array
     */
    public function getManifest()
    {
        return $this->manifest;
    }

    public function setManifest(array $manifest)
    {
        $this->manifest = $manifest;
    }

    /**
     * @return bool
     */
    public function isManifestValid()
    {
        return $this->manifestValid;
    }

    public function setManifestValid(bool $manifestValid)
    {
        $this->manifestValid = $manifestValid;
    }

    public function getPublicUrl(): string
    {
        return $this->publicUrl;
    }

    public function setPublicUrl(string $publicUrl): void
    {
        $this->publicUrl = $publicUrl;
    }

    public function jsonSerialize(): array
    {
        return [
            'author' => $this->getAuthor(),
            'package' => $this->getPackage(),
            'officialPackageName' => $this->getOfficialPackageName(),
            'version' => $this->getVersion(),
            'manifest' => $this->getManifest(),
            'manifestValid' => $this->isManifestValid(),
            'repo' => $this->getRepo(),
            'publicUrl' => $this->getPublicUrl(),
        ];
    }
}
