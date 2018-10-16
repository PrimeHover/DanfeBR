<?php

namespace Primehover\DanfeBR;

use Primehover\DanfeBR\Exceptions\EmptyResponseException;
use Primehover\DanfeBR\Exceptions\ErrorResponseException;
use Primehover\DanfeBR\Objects\Captcha;
use Primehover\DanfeBR\Objects\XML;
use Primehover\DanfeBR\Util\Curl;

class API {

    use Curl;

    /**
     * Retorna a DANFe de um XML de uma nota fiscal
     *
     * @author Gustavo Fernandes
     * @since 15/10/2018
     * @param string $content
     * @return string
     */
    public function getDanfeByXML($content) {
        $xml = new XML($content);

        $response = $this->curl('https://danfe.br.com/api/nfe/danfe.json', [], $xml->getContent());
        if (isset($response['status']) && (bool)$response['status'] === true && isset($response['pdf']) && !empty($response['pdf'])) {

            $file = file_get_contents($response['pdf']);
            if (empty($file) || $file === false) {
                throw new EmptyResponseException('Não foi possível recuperar a DANFE');
            }

            return $file;
        } else {
            throw new ErrorResponseException($response);
        }
    }

    /**
     * Retorna o objeto de um novo captcha
     *
     * @author Gustavo Fernandes
     * @since 15/10/2018
     * @return Captcha
     */
    public function getCaptcha() {
        return new Captcha();
    }

    /**
     * Retorna um XML de acordo com um CAPTCHA digitado
     *
     * @author Gustavo Fernandes
     * @since 15/10/2018
     * @param string $code
     * @param string $key
     * @param string $answer
     * @return string
     */
    public function getXMLByCaptcha($code, $key, $answer) {
        $response = $this->getCaptchaResponse($code, $key, $answer);

        if (isset($response['status']) && (bool)$response['status'] === true && isset($response['xml']) && !empty($response['xml'])) {
            $file = file_get_contents($response['xml']);
            if (empty($file) || $file === false) {
                throw new EmptyResponseException('Não foi possível recuperar o XML');
            }

            return $file;
        } else {
            throw new ErrorResponseException($response);
        }
    }

    /**
     * Retorna uma DANFE de acordo com um CAPTCHA digitado
     *
     * @author Gustavo Fernandes
     * @since 15/10/2018
     * @param string $code
     * @param string $key
     * @param string $answer
     * @return string
     */
    public function getDanfeByCaptcha($code, $key, $answer) {
        $response = $this->getCaptchaResponse($code, $key, $answer);

        if (isset($response['status']) && (bool)$response['status'] === true && isset($response['pdf']) && !empty($response['pdf'])) {
            $file = file_get_contents($response['pdf']);
            if (empty($file) || $file === false) {
                throw new EmptyResponseException('Não foi possível recuperar a DANFe');
            }

            return $file;
        } else {
            throw new ErrorResponseException($response);
        }
    }


    /**
     * Realiza uma chamada genérica com a resposta de um captcha
     *
     * @author Gustavo Fernandes
     * @since 15/10/2018
     * @param $code
     * @param string $key
     * @param string $answer
     * @return array
     */
    public function getCaptchaResponse($code, $key, $answer) {
        if (mb_strlen(preg_replace("/[^0-9]/","", trim($key))) !== 44) {
            throw new EmptyResponseException('A chave deve possuir 44 dígitos!');
        }
        if (empty($answer)) {
            throw new EmptyResponseException('A resposta do CAPTCHA não pode ser vazia!');
        }

        return $this->curl('https://danfe.br.com/api/nfe/nfe_captcha.json', [
            'key'     => trim($code),
            'captcha' => trim($answer),
            'chave'   => trim($key)
        ]);
    }

}