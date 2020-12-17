# pdf_generation_php
Generate PDF using PHP with database

## Installing - 
NOTE :- Works Only For PHP 7.4v

-> Install Composer
-> Set the path for PHP and Composer
-> Install Mpdf library by using this command -
```bash
composer require mpdf/mpdf
```
-> Then, include -
  ```bash
  require_once __DIR__ . '/vendor/autoload.php';
  ```
  on your code.
-> The basic Syntax for generating the PDF is -
 ```bash
 $mpdf = new \Mpdf\Mpdf();
 $mpdf->WriteHTML('<p>Hello It\'s working</p>');
 $mpdf->Output();
 ```
