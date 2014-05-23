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