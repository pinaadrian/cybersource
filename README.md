# CyberSource PHP Client (Laravel port)

Laravel port of the [CyberSource SOAP Toolkit API](http://www.cybersource.com/developers/getting_started/integration_methods/soap_toolkit_api).

The CyberSource library can be found [here](https://github.com/CyberSource/cybersource-sdk-php)


## Install with composer
The code is available at [Packagist](https://packagist.org/packages/adrianxplay/cybersource).
If you want to install SDK from Packagist, use the following command to add the
dependency to your app.
```
composer require adrianxplay/cybersource
```

## Prerequisites

- Laravel 5.6 or above
- PHP 7.1 or above
   - [curl](http://php.net/manual/en/book.curl.php), [openssl](http://php.net/manual/en/book.openssl.php), [soap](http://php.net/manual/en/book.soap.php) extensions must be enabled
- A CyberSource account. You can create an evaluation account [here](http://www.cybersource.com/register/).
- A CyberSource transaction key. You will need to set your merchant ID and transaction key in the ````cybersource.php```` file in ````config/cybersource.php````. Instructions on obtaining a transaction key can be found [here](http://www.cybersource.com/developers/integration_methods/simple_order_and_soap_toolkit_api/soap_api/html/wwhelp/wwhimpl/js/html/wwhelp.htm#href=Intro.04.3.html).

## Configuration

### Publishing vendor files

To publish the `cybersource.php` file to the `config` dir, run the following command:

```php
php artisan vendor:publish --tag=cybersource
```

 Before making any request, make sure to configure the merchant ID, transaction key, and the appropriate WSDL file URL in ````config/cybersource.php````.

 By default, the WSDL file for the client is for API version 1.120. Available WSDL file URLs can be browsed at the following locations:

- [test](https://ics2wstest.ic3.com/commerce/1.x/transactionProcessor/)
- [live](https://ics2ws.ic3.com/commerce/1.x/transactionProcessor/)

## Examples

The PHP client will generate the request message headers for you, and will contain the methods specified by the WSDL file.

### Creating a simple request
The main method you'll use is ````runTransaction()````. To run a transaction, you'll first need to construct a client to generate a request object, which you can populate with the necessary fields (see [documentation](http://www.cybersource.com/developers/integration_methods/simple_order_and_soap_toolkit_api/soap_api/html/wwhelp/wwhimpl/js/html/wwhelp.htm#href=Intro.04.4.html) for sample requests). The object will be converted into XML, so the properties of the object will need to correspond to the correct XML format.

```php
use Adrianxplay\Cybersource\CybsSoapClient;

$referenceCode = 'reference_code';
$client = new CybsSoapClient();
$request = $client->createRequest($referenceCode);

$card = new stdClass();
$card->accountNumber = '4111111111111111';
$card->expirationMonth = '12';
$card->expirationYear = '2020';
$request->card = $card;

// Populate $request here with other necessary properties

$response = $client->runTransaction($request);
```

### Creating a request from XML
You can create a request from XML either in a file or from an XML string. The XML request format is described in the **Using XML** section [here](http://apps.cybersource.com/library/documentation/dev_guides/Simple_Order_API_Clients/Client_SDK_SO_API.pdf). Here's how to run a transaction from an XML file:

```php
use Adrianxplay\Cybersource\CybsSoapClient;

$referenceCode = 'your_merchant_reference_code';
$client = new CybsSoapClient();
$reply = $client->runTransactionFromFile('path/to/my.xml', $referenceCode);
```

Or, you can create your own XML string and use that instead:

```php
use Adrianxplay\Cybersource\CybsSoapClient;

$xml = "";
// Populate $xml
$client = new CybsSoapClient();
$client->runTransactionFromXml($xml);
```

### Using name-value pairs
In order to run transactions using name-value pairs, make sure to set the value for the WSDL for the NVP transaction processor in ````cybs.ini````. Then use the ````CybsNameValuePairClient```` as so:

```php
use Adrianxplay\Cybersource\CybsNameValuePairClient;

$client = new CybsNameValuePairClient();
$request = array();
$request['ccAuthService_run'] = 'true';
$request['merchantID'] = 'my_merchant_id';
$request['merchantReferenceCode'] = 'my_reference_code';
// Populate $request
$reply = $client->runTransaction($request);
```

## Documentation

For more information about CyberSource services, see <http://www.cybersource.com/developers/documentation>
