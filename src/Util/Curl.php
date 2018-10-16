<?php

namespace Primehover\DanfeBR\Util;

use Primehover\DanfeBR\Exceptions\EmptyResponseException;

trait Curl {

    /**
     * Realiza uma conexão via CURL
     *
     * @author Gustavo Fernandes
     * @since 15/10/2018
     * @param string $url
     * @param array $get
     * @param null|string $post
     * @return array
     */
    protected function curl($url, $get = [], $post = null) {

        $url .= '?apikey=' . env('DANFEBR_KEY', '');
        if (!empty($get)) {
            $url .= '&' . http_build_query($get);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        if (empty($response)) {
            throw new EmptyResponseException('A URL ' . $url . ' não retornou nenhum resultado');
        }

        $response = json_decode($response, true);
        if ($response === false) {
            throw new EmptyResponseException('O retorno da URL não é um JSON válido');
        }

        return $response;
    }

}