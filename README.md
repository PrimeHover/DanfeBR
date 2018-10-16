# DANFE.BR para Laravel/Lumen

[![Author](http://img.shields.io/badge/author-%40primehover-blue.svg?style=flat-square)](https://gufernandes.com.br)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/primehover/danfebr.svg?style=flat-square)](https://packagist.org/packages/primehover/danfebr)
[![Packagist](https://img.shields.io/packagist/dt/primehover/danfebr.svg?style=flat-square)](https://packagist.org/packages/primehover/danfebr)


### Funcionalidades

* Conecta com a API da [danfe.br.com](https://danfe.br.com)
* Gera uma DANFE com base em um XML de uma NF-e
* Gera um XML com base em um Captcha
* Gera uma DANFE com base em um Captcha
 
### Requisitos

* CURL precisa estar ativado. Certifique-se que a extensão `extension=php_curl.dll` está ativa em seu php.ini

### Instalação via Composer

	$ composer require primehover/danfebr
	
### Configuração

* Primeiramente, você deve criar uma conta em [danfe.br.com](https://danfe.br.com/app/cadastro)
* Você deve liberar que a API tenha acesso a sua conta. Por padrão, todas as contas vem bloqueadas para o acesso via API. Para liberar este acesso, acesse a sua conta e vá para o menu _(configurações > sistema)_, e marque a opção **"Permitir o uso da API em minha conta?"**.
* Agora, você precisa pegar a sua chave da API, pois ela garante que as NFes geradas via API caiam diretamente na sua conta. Para ter acesso a sua chave da API, acesse sua conta e vá para o menu _(configurações > api key)_.
* Com a sua chave da API, abra o seu arquivo **.env** e insira a seguinte variável:

```
DANFEBR_KEY=SUA_CHAVE_AQUI
```

* Caso queira usar a API como uma Facade, basta adicionar a classe à sua array ``aliases``:

```
'aliases' => [
  ...
  'DanfeBR' => Primehover\DanfeBR\DanfeBR::class,
],
```
	
### Exemplo de Uso

```php
// Capturando a DANFE com o XML da NF-e
$xml = file_get_contents('/path/to/xml'); // deve ser uma string
$api = new API();
$danfe = $api->getDanfeByXML($xml);

header("Content-type: application/pdf");
echo $danfe;
die;

// Usando a Facade
$danfe = DanfeBR::getDanfeByXML($xml);
header("Content-type: application/pdf");
echo $danfe;
die;
```

### Métodos
```php
// Captura uma DANFe com o XML da NF-e
$api->getDanfeByXML($xml);

// Captura um novo Captcha
$captcha = $api->getCaptcha();
$captcha->getCode(); // código de identificação do Captcha
$captcha->getImage(); // link da imagem do Captcha

// Captura o XML de acordo com o Captcha
$api->getXMLByCaptcha(Captcha $captcha, $key, $answer);

// Captura a DANFe de acordo com o Captcha
$api->getDanfeByCaptcha(Captcha $captcha, $key, $answer);
```
