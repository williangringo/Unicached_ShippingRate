Unicached_ShippingRate
=====================

Provides a particular shipping rate webserver using Inchoo_Unicache extension.
For a simple usage, update your request client URI to http://www.yourdomain.com/unicachedrate/standard/.

It's a requirement to have installed Inchoo_Unicache, and not configured the extension for other purposes.


Requirements:
-------------

Install Inchoo_Unicache extension: https://github.com/srka/Inchoo-Unicache


Installation:
-------------

Copy all files to your Magento root directory.


Usage:
------

In `System > Configuration > Sales > Shipping Settings`

In Webserver URL field, paste the gateway url of your active shipping method. (ex.: `http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx`)

In `System > Configuration > Sales > Shipping Methods`

Replace the gateway url of your active method by: `http://www.yourdomain.com/unicachedrate/standard/`

If you know Regular Expressions, you can change the cache identifier according to your request uri format.
The cache won't work as expected until you remove some special characters of the identifier.




Dica de Configuração para o método PedroTeixeira_Correios:
----------------------------------------------------------

Link da Extensão: https://github.com/r-martins/magento-pedroteixeira-correios

1. A extensão do Pedro já envia o peso cubado. Logo não é necessário guardar as dimensões em cache. O resultado da cotação dos Correios será provavelmente o mesmo para inúmeras dimensões, de mesmo peso cubado.
2. A diferença de preço do frete pode ser considerada irrelevante nas seguintes situações:
	1. Peso Inferior a 100 gramas
	2. Valor Declarado Baixo
	3. Mesma Faixa de CEP

De acordo com a descrição acima, as alterações a seguir podem otimizar muito o armazenamento e a chance de acerto da cache.

Abra o arquivo `/app/code/community/PedroTeixeira/Correios/etc/config.xml`

Localize a tag `<url_ws_correios>` e substitua o url dos Correios pelo url a seguir:
`http://www.yourdomain.com/unicachedrate/standard/`

Em `Sistema > Configurações > Vendas > Configurações de Entrega` substitua o campo URI Pattern pela expressão a seguir:

`/\??([[:alpha:]]+=[^&]*)&([[:alpha:]]+=[^&]*)&[[:alpha:]]+=([0-9]+\.[0-9])[0-9]*&([[:alpha:]]+=[^&]*)&([[:alpha:]]+=[0-9]{5})[0-9]{3}&([[:alpha:]]+=[^&]*)&([[:alpha:]]+=[^&]*)&([[:alpha:]]+=[^&]*)&([[:alpha:]]+=[^&]*)&([[:alpha:]]+=[^&]*)&([[:alpha:]]+=[^&]*)&([[:alpha:]]+=[^&]*)/`

Em seguida substitua o campo URI Replacement pelo seguinte texto:

`$2|nVlPeso=$3|$5`

As chaves de identificação do cache deverão aparecer da seguinte forma:

`nCdServico=40436,41068,81019|nVlPeso=0.2|sCepDestino=51030&nCdEmpresa=11111111&sDsSenha=11111111`