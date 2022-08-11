<?php

namespace App\Service\Decoder;

use App\Service\Cache;
use Http\Client\Exception\NetworkException;
use Http\Client\HttpClient;
use Nyholm\Psr7\Request;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class JsonResponseDecoder
{
    /** @var bool */
    private $cacheEndpoint;

    /** @var HttpClient */
    private $client;

    /** @var FilesystemAdapter */
    private $cache;

    public function __construct(bool $cacheEndpoint, HttpClient $client, Cache $cache)
    {
        $this->cacheEndpoint = $cacheEndpoint;
        $this->client = $client;
        $this->cache = $cache();
    }

    /**
     * @return array|mixed|\Psr\Http\Message\StreamInterface
     *
     * @throws \Http\Client\Exception
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getDecodedResponse(Request $request)
    {
        try {
            $response = $this->client->sendRequest($request);
            $decodedResponse = json_decode($response->getBody()->getContents(), true);

            if (!in_array($response->getStatusCode(), range(200, 299))) {
                if ($this->cacheEndpoint && $this->cache->hasItem($this->getCacheId($request))) {
                    return $this->cache->getItem($this->getCacheId($request));
                }

                return [];
            }

            if (JSON_ERROR_NONE !== json_last_error()) {
                return $response->getBody()->getContents();
            }

            if ($this->cacheEndpoint) {
                $this->cache->delete($this->getCacheId($request));
                $this->cache->get($this->getCacheId($request), function (ItemInterface $item) use ($decodedResponse) {
                    return $decodedResponse;
                });
            }

            return $decodedResponse;
        } catch (NetworkException $e) {
            if ($this->cacheEndpoint && $this->cache->has($this->getCacheId($request))) {
                return $this->cache->get($this->getCacheId($request));
            }
            throw $e;
        }
    }

    /**
     * @return string
     */
    private function getCacheId(Request $request)
    {
        return sha1(
            preg_replace(
                '/[^A-Za-z0-9\.\- ]/',
                '',
                $request->getMethod().$request->getUri()
            )
        );
    }
}
