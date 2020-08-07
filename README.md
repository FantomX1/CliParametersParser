Parses command line parameters into an array , eg . -p=value --directory=value -c=value --option valueOption

```
php script.php  -p=value --directory=valueDir -c=value --option valueOption
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
