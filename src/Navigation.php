<?php

namespace App;

class Navigation
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $link;

    /**
     * @var array
     */
    private $children = [];

    public function __construct(string $title = '', string $link = '')
    {
        $this->title = $title;
        $this->link = $link;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function addChild(Navigation $navigation): void
    {
        array_push($this->children, $navigation);
    }
}