<?php

namespace Primehover\DanfeBR\Objects;

use Primehover\DanfeBR\Exceptions\EmptyResponseException;

class XML {

    /**
     * Armazena o conteúdo do XML
     *
     * @var string
     */
    protected $content;

    public function __construct($content) {
        if (empty($content)) {
            throw new EmptyResponseException('XML vazio');
        }

        $xml = simplexml_load_string($content);
        if ($xml === false) {
            throw new EmptyResponseException('XML com formato inválido e/ou desconhecido');
        }
        
        $this->content = $content;
    }

    /**
     * Retorna o conteúdo do XML
     *
     * @author Gustavo Fernandes
     * @since 15/10/2018
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

}