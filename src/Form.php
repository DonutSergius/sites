<?php

class Form
{
    private $nameForm;
    private $action;
    private $inputs;

    public function __construct(
        $nameForm,
        $action,
        $inputs
    ) {
        $this->nameForm = $nameForm;
        $this->action = $action;
        $this->inputs = $inputs;
    }
    public function getNameForm()
    {
        return $this->nameForm;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getInputs()
    {
        return $this->inputs;
    }

    public function toArray()
    {
        return [
            'nameForm' => $this->getNameForm(),
            'action' => $this->getAction(),
            'inputs' => $this->getInputs()
        ];
    }
}
