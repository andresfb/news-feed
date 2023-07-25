<?php

namespace App\DataObjects;

use App\Models\Feed;
use DOMDocument;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use SimplePie\Item;

final class ArticleInfo implements Arrayable
{
    private int $index;
    private string $hash;
    private string $title;
    private string $permalink;
    private string $content;
    private string $description;
    private string $thumbnail;
    private string $data;
    private array $tags = [];
    private ?Feed $feed = null;

    /**
     * @throws Exception
     */
    public static function create(Item $item, Feed $feed, int $index): self
    {
        $info = new self();
        $info->setIndex($index)
            ->setFeed($feed)
            ->parseItem($item);

        return $info;
    }

    public function setIndex(int $index): ArticleInfo
    {
        $this->index = $index;
        return $this;
    }

    private function setFeed(Feed $feed): ArticleInfo
    {
        $this->feed = $feed;
        return $this;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'permalink' => $this->permalink,
            'content' => $this->content,
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'data' => $this->data,
        ];
    }

    /**
     * @throws Exception
     */
    private function parseItem(Item $item): void
    {
        // TODO: add a method to check if the content and the description are html string and if they have an img or href tag, return empty string and a true $skip flag

        $this->hash = md5("{$this->feed->id}|{$item->get_permalink()}");
        $this->title = $this->parseTitle($item);
        $this->permalink = $item->get_permalink();
        $this->content = $item->get_content() ?? '';
        $this->description = $item->get_description() ?? '';
        $this->thumbnail = $this->parseThumbnail($item);
        $this->data = json_encode($item->data, JSON_THROW_ON_ERROR);

        if (!empty($item->get_categories())) {
            $this->tags = collect($item->get_categories())
                ->pluck('term')
                ->toArray();
        }
    }

    private function parseThumbnail(Item $item): string
    {
        if (empty($item->get_thumbnail())) {
            return $this->thumbnailFromDescription($item);
        }

        return collect($item->get_thumbnail())->first();
    }

    private function thumbnailFromDescription(Item $item): string
    {
        $html = $this->getHtmlValue($item);
        if ($html === strip_tags($html)) {
            return '';
        }

        try {
            $doc = new DOMDocument();
            $doc->loadHTML($html, LIBXML_NOERROR);
            $tags = $doc->getElementsByTagName('img');
            if ($tags->count() === 0) {
                return '';
            }

            return $tags[0]->getAttribute('src');
        } catch (Exception) {
            return '';
        }
    }

    private function getHtmlValue(Item $item): string
    {
        $html = $item->get_content() ?? '';
        if (empty($html)) {
            $html = $item->get_description() ?? '';
        }

        return $html;
    }

    private function parseTitle(Item $item): string
    {
        if (!empty($item->get_title())) {
            return $item->get_title();
        }

        return "{$this->feed->provider->name} - {$this->feed->title} - #{$this->index}";
    }
}
