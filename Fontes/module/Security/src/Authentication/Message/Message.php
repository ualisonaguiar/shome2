<?php

namespace Authentication\Message;

trait Message
{
    /**
     * <strong>Nome usuario ultrapassou o tamanho definido.</strong>
     * @var type
     */
    protected $strMsgError01 = 'Nome usuário ultrapassou o tamanho definido.';

    /**
     * <strong>Nome usuario ultrapassou o tamanho definido.</strong>
     * @var type
     */
    protected $strMsgError02 = 'Senha ultrapassou o tamanho definido.';

    /**
     * <strong>Usuario nao cadastrado no sistema.</strong>
     * @var type
     */
    protected $strMsgError03 = 'Usuário nao cadastrado no sistema.';

    /**
     * <strong>Usuario ou senha invalida.</strong>
     * @var type
     */
    protected $strMsgError04 = 'Usuário ou senha inválida.';

    /**
     * <strong>Nao foi possivel realizar o login.</strong>
     * @var type
     */
    protected $strMsgES01 = 'Não foi possível realizar o login.';
}
