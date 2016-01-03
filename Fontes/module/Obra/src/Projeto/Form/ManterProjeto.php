<?php

namespace Projeto\Form;

use CoreZend\Form\FormGenerator;

class ManterProjeto extends FormGenerator
{
    public function prepareElementSearch()
    {
        $this->setAttribute('name', 'formSearchProjeto');
    }
}
