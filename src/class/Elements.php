<?php

namespace Sites\Class;

class Elements
{
    private $elementTitle;
    private $elementType;
    private $elementId;

    public function __construct(
        $elementTitle,
        $elementType,
        $elementId,
    ) {
        $this->elementTitle = $elementTitle;
        $this->elementType = $elementType;
        $this->elementId = $elementId;
    }

    public function createInput()
    {
        return [
            'title' =>  $this->elementTitle,
            'type' => $this->elementType,
            'id' => $this->elementId,
            'name' => $this->elementId,
            'field' => $this->elementId,
        ];
    }

    public function createSelect(array $options)
    {
        return [
            'title' =>  $this->elementTitle,
            'type' => $this->elementType,
            'id' => $this->elementId,
            'name' => $this->elementId,
            'field' => $this->elementId,
            'options' => $options
        ];
    }
}
