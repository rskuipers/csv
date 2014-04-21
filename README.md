# csv

[![Build Status](https://travis-ci.org/rskuipers/csv.png?branch=master)](https://travis-ci.org/rskuipers/csv)

## What is it

This is yet another CSV library, it's made to give you an easy start on reading CSV files.
This library allows you to set a row to use as your column titles and access the values using its column title.
You can also setup column formatters to parse (localized) currencies, decimals or create your own column formatter. 

## Installation

Add the following line to your composer require 
```json
"rskuipers/csv": "~1.0.0"
```

## Examples

### Mapping Modes

```csv
ID,Name,Age
1,John,19
2,Doe,21
3,Foo,31
4,Bar,52
```

```php
use RSKuipers\CSV\File;

$file = new File($this->getCSVFile(), 0);
$file->setMappingMode(File::COLUMN_TITLES);
$row = $file->fetch();
echo $row['Name'];
```

```php
use RSKuipers\CSV\File;

$file = new File($this->getCSVFile(), 0);
$file->setMappingMode(File::INDEX);
$row = $file->fetch();
echo $row[1];
```

```php
use RSKuipers\CSV\File;

$file = new File($this->getCSVFile(), 0);
$file->setMappingMode(File::CUSTOM);
$file->setMapping(array(
    'ID',
    'Product Name',
    'Price',
));
$row = $file->fetch();
echo $row['Product Name'];
```

### Column Formatters

```csv
ID,Name,Price,Stock
1,Lighter,"€ 15,95","2.093.230"
2,Chair,"€ 17","3.230"
3,Table,"€ 19,91","530",
4,Book,"€ 1","76.126"
```

```php
use RSKuipers\CSV\File;
use RSKuipers\CSV\Formatter\Currency as CurrencyFormatter;
use RSKuipers\CSV\Formatter\Decimal as DecimalFormatter;

$priceFormatter = new CurrencyFormatter('nl_NL');
$decimalFormatter = new DecimalFormatter('nl_NL');
$csv = new File($this->getCSVFile(), 0);
$csv->setMappingMode(File::COLUMN_TITLES);
$csv->setFormatter('Price', $priceFormatter);
$csv->setFormatter('Stock', $decimalFormatter);
$row = $csv->fetch();
echo $row['Price']; // 15.95
echo $row['Stock']; // 2093230
```


## Tests

Run Phing to execute PHPLint, PHPCS, PHPMD and PHPUnit.
Make sure you used composer install/update with the dev dependencies.

```sh
$ ./vendor/bin/phing
```
