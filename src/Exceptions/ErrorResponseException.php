<?php

namespace Primehover\DanfeBR\Exceptions;

use Throwable;

class ErrorResponseException extends \RuntimeException {

    /**
     * Armazena os ENUMs de erros da API
     *
     * @var array
     */
    protected $errors = [
        'ERRO_APIKEY_INVALIDA'      => 'A API Key é inválida, ela deve ter 32 caracteres, somente letras e números',
        'ERRO_APIKEY_INEXISTENTE'   => 'A API Key não existe, verifique se você mudou a chave da sua API.',
        'ERRO_API_ACESSO'           => 'Conta sem liberar o acesso da API. Verifique no menu (configurações > sistema).',
        'ERRO_KEY_INVALIDA'         => 'A Key é inválida, ela deve ter 32 caracteres, somente letras e números.',
        'ERRO_KEY_INEXISTENTE'      => 'A Key não existe, verifique se vou gerou a Key.',
        'ERRO_CHAVE_INVALIDA'       => 'Verifique a chave de acesso da NFe.',
        'ERRO_CAPTCHA_INVALIDO'     => 'O captcha digitado não confere com a imagem.',
        'ERRO_RECEITA'              => 'Erro receita.',
        'ERRO_RECEITA_OBTER_DADOS'  => 'Portal da NFe temporariamente offline.',
        'ERRO_XML_INVALIDO'         => 'XML inválido.'
    ];

    public function __construct($error = [], int $code = 0, Throwable $previous = null) {
        if (empty($error)) {
            $message = 'Retorno da mensagem de erro vazio';
        }

        /* Formatando a mensagem de erro */
        if (isset($error['error']) && !empty($error['error'])) {
            if (isset($this->errors[$error['error']])) {
                $message = $this->errors[$error['error']];
            } else {
                $message = $error['error'];
            }

            if (isset($error['message']) && !empty($error['message'])) {
                $message .= ' | ' . $error['message'];
            }
        } else {
            $message = 'Nenhuma mensagem de erro foi encontrada';
        }

        parent::__construct($message, $code, $previous);
    }

}