<?php

namespace App\DataObjects;

use App\Models\Feed;
use DOMDocument;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;
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
    private ?Carbon $publishedAt = null;

    private function __construct()
    {
    }

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
            'feed_id' => $this->feed->id,
            'hash' => $this->hash,
            'title' => $this->title,
            'permalink' => str_replace('amp;', '', $this->permalink),
            'content' => $this->content,
            'description' => $this->description,
            'thumbnail' => str_replace('amp;', '', $this->thumbnail),
            'data' => $this->data,
            'published_at' => $this->publishedAt,
        ];
    }

    /**
     * @throws Exception
     */
    private function parseItem(Item $item): void
    {
        $this->hash = md5("{$this->feed->id}|{$item->get_permalink()}");
        $this->title = $this->parseTitle($item);
        $this->permalink = $item->get_permalink();
        $this->content = $this->parseText($item->get_content());
        $this->description = $this->parseText($item->get_description());
        $this->thumbnail = $this->parseThumbnail($item);
        $this->data = json_encode($item->data, JSON_THROW_ON_ERROR);
        try {
            $this->publishedAt = Carbon::parse($item->get_date('Y-m-d H:i:s'));
        } catch (Exception) {
            $this->publishedAt = now();
        }

        if (!empty($item->get_categories())) {
            $this->tags = collect($item->get_categories())
                ->pluck('term')
                ->filter()
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
            return $this->feed->logo;
        }

        try {
            $doc = new DOMDocument();
            $doc->loadHTML($html, LIBXML_NOERROR);
            $tags = $doc->getElementsByTagName('img');
            if ($tags->count() === 0) {
                return $this->feed->logo;
            }

            if (empty($tags[0]->getAttribute('src'))) {
                return $this->feed->logo;
            }

            return $tags[0]->getAttribute('src');
        } catch (Exception) {
            return $this->feed->logo;
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

    /**
     * parseText Method.
     *
     * Checks if the text has html tags and if it does locks for <img> tags
     * or <a> tags with 'href' attribute. If it finds any of those, it
     * returns an empty string.
     *
     * @param string|null $text
     * @return string
     */
    private function parseText(?string $text): string
    {
        if (empty($text)) {
            return '';
        }

        // if the text is not html, return it
        if ($text === strip_tags($text)) {
            return $text;
        }

        try {
            $doc = new DOMDocument();
            $doc->loadHTML($text, LIBXML_NOERROR);

            // if the text has an img tag, return empty string
            $tags = $doc->getElementsByTagName('img');
            if ($tags->count() > 0) {
                return '';
            }

            // if the text has doesn't have an <a> tag, return it
            $tags = $doc->getElementsByTagName('a');
            if ($tags->count() === 0) {
                return $text;
            }

            foreach ($tags as $tag) {
                if ($tag->getAttribute('href') === '') {
                    continue;
                }

                // if the <a> tag has a href attribute, return empty string
                return '';
            }

            return $text;
        } catch (Exception) {
            return '';
        }
    }
}
