<?php

namespace Sites\Class;

class Page
{
    private $title;
    private $content = [];
    private $sidebar;

    public function __construct($title, $content, $sidebar)
    {
        $this->title = $title;
        $this->content = $content;
        $this->sidebar = $sidebar;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getSidebar()
    {
        return $this->sidebar;
    }

    public function toArray()
    {
        return [
            'title' => $this->getTitle(),
            'content' => $this->getContent(),
            'sidebar' => $this->getSidebar(),
        ];
    }
}
