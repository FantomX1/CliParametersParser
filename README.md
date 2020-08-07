Parses command line parameters into an array , eg . -p=value --directory=value -c=value --option valueOption

#### Usage:
```
php script.php  -p=value --directory=valueDir -c=value --option valueOption
```

```
// script.php

$params = (new fantomx1\CliParamsParser())->parse();

var_dump($params);
```

Result:

```
[
    'p' => 'value',
    'directory' = > 'valueDir',
    'd' => 'valueDir',
    'c' => 'value',
    'option' => 'valueOption'
    'o' => 'valueOption'
];
```
