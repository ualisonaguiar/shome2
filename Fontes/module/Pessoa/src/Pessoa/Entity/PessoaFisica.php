<?php

namespace Pessoa\Entity;

use Application\Entity\PessoaFisica as PessoaFisicaEntity;

class PessoaFisica extends PessoaFisicaEntity
{
    const CO_TIPO_PESSOA_FISICA = 1;

    const CO_TIPO_PESSOA_JURIDICA = 2;
}
