<?php

namespace Sites\Class;

class Form
{
    private $nameForm;
    private $action;
    private $inputs;
    private $scripts;

    public function __construct(
        $nameForm,
        $action,
        $inputs,
        $scripts
    ) {
        $this->nameForm = $nameForm;
        $this->action = $action;
        $this->inputs = $inputs;
        $this->scripts = $scripts;
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

    public function getScripts()
    {
        return $this->scripts;
    }

    public function toArray()
    {
        return [
            'nameForm' => $this->getNameForm(),
            'action' => $this->getAction(),
            'inputs' => $this->getInputs(),
            'scripts' => $this->getScripts(),
        ];
    }
}
