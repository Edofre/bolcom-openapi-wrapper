<?php

namespace Edofre\BolCom\Responses;

/**
 * Class Product
 * @package Edofre\BolCom\Responses
 */
class Product
{
    /** @var string */
    private $id;
    /** @var string */
    private $title;
    /** @var string */
    private $price;
    /** @var string */
    private $description;
    /** @var string */
    private $thumbnailUrl;
    /** @var string */
    private $url;
    /** @var array */
    private $offers;

    /**
     * Product constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        // Make sure attributes exist before assigning them
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['shortDescription'] ?? null;

        // Do we have offerData
        if (isset($data['offerData'])) {
            $offerData = $data['offerData'];
            $this->offers = $offerData ?? [];
            // Do we have offers?
            if (isset($offerData['offers'])) {
                // Fetch price for the first one
                $this->price = $offerData['offers'][0]['price'];
            }
        }

        // Do we have images
        if (isset($data['images'])) {
            $this->thumbnailUrl = $data['images'][1]['url'];
        }

        // Do we have urls
        if (isset($data['urls'])) {
            $this->url = (string)$data['urls'][0]['value'];
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getFirstAvailablePrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getThumbnailUrl()
    {
        // TODO, set default image
        return !empty($this->thumbnailUrl) ? $this->thumbnailUrl : '..defaultimageplaceholder';
    }

    /**
     * @return string
     */
    public function getExternalUrl()
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getOffers()
    {
        return $this->offers;
    }
}