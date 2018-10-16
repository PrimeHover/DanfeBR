<?php

namespace Primehover\DanfeBR\Objects;

use Primehover\DanfeBR\Exceptions\ErrorResponseException;
use Primehover\DanfeBR\Util\Curl;

class Captcha {

    use Curl;

    /**
     * Armazena o código que será utilizado para recuperar a imagem do captcha
     *
     * @var string
     */
    protected $code;

    /**
     * Armazena a URL da imagem a ser consultada como captcha
     *
     * @var string
     */
    protected $image;

    
    /**
     * Captcha constructor
     *
     * @author Gustavo Fernandes
     * @since 15/10/2018
     */
    public function __construct() {
        parent::__construct();

        $captcha = $this->curl('https://danfe.br.com/api/nfe/captcha.json');
        if (isset($captcha['status']) && (bool)$captcha['status'] === true && isset($captcha['key']) && !empty($captcha['key'])) {
            $this->code = $captcha['key'];

            $image = $this->curl('https://danfe.br.com/api/nfe/imagem.json', [ 'key' => $this->code ]);
            if (isset($image['status']) && (bool)$image['status'] === true && isset($image['captcha']) && !empty($image['captcha'])) {
                $this->image = $image['captcha'];
            } else {
                throw new ErrorResponseException($image);
            }
        } else {
            throw new ErrorResponseException($captcha);
        }
    }

    /**
     * Retorna o código da chave da imagem
     *
     * @author Gustavo Fernandes
     * @since 15/10/2018
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Retorna a imagem
     *
     * @author Gustavo Fernandes
     * @since 15/10/2018
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

}