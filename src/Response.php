<?php

namespace Cian\Shopify;

class Response
{
    /**
     * @var \GuzzleHttp\Psr7\Response $response
     */
    protected $response;

    /**
     * @var array|null $body
     */
    protected $body = null;

    /**
     * @var string|null $nextLink
     */
    protected $nextLink = null;

    /**
     * @var string|null $nextLink
     */
    protected $previousLink = null;

    const LINK_PATTERNS = [
        'next' => '/<(.*)>; rel="next"/',
        'previous' => '/<(.*)>; rel="previous"/'
    ];

    public function __construct($response)
    {
        $this->response = $response;
        
        $this->handleHeaders();
    }

    protected function handleHeaders()
    {
        $linkHeader = $this->response->getHeader('Link');

        if (!$linkHeader) {
            return $this;
        }

        $links = explode(', ', $linkHeader[0]);

        foreach ($links as $link) {
            if (preg_match(self::LINK_PATTERNS['next'], $link, $matches)) {
                if (count($matches)) {
                    $this->nextLink = $matches[1];
                }
            } elseif (preg_match(self::LINK_PATTERNS['previous'], $link, $matches)) {
                if (count($matches)) {
                    $this->previousLink = $matches[1];
                }
            }
        }

        return $this;
    }

    /**
     * @return \GuzzleHttp\Psr7\Response
     */
    public function getOriginalResponse()
    {
        return $this->response;
    }

    /**
     * @return array|null
     */
    public function getBody($assoc = true, $depth = 512, $options = 0)
    {
        $contents = (clone $this->response)->getBody()->getContents();

        return json_decode($contents, $assoc, $depth, $options);
    }

    /**
     * @return bool
     */
    public function hasNextLink()
    {
        return !is_null($this->nextLink);
    }

    /**
     * @return bool
     */
    public function hasPreviousLink()
    {
        return !is_null($this->previousLink);
    }

    public function getNextLink()
    {
        return $this->nextLink;
    }

    public function getPreviousLink()
    {
        return $this->previousLink;
    }

    /**
     * @return bool
     */
    public function isLastPage()
    {
        return is_null($this->nextLink);
    }
}
