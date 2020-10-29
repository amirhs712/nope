# Nope

[![Latest Stable Version](https://poser.pugx.org/amirhs712/rule-builder/v/stable)](https://packagist.org/packages/amirhs712/rule-builder) [![Total Downloads](https://poser.pugx.org/amirhs712/rule-builder/downloads)](https://packagist.org/packages/amirhs712/rule-builder) [![License](https://poser.pugx.org/amirhs712/rule-builder/license)](https://packagist.org/packages/amirhs712/rule-builder)

Nope is a validation rule builder for laravel inspired by `Yup` for javascript.

With `Nope` you can generate rules more fluently, I've also copied rules description from laravel official website and hard coded them into Nope,
so you can have access to documentations easily.

Some functionalities have been extended for validation rules, for example you can pass Carbon instances to date validation rules like `after`.

## Installation
Require this package with composer using the following command:

```
   composer require amirhs712/rule-builder
```

## Usage

I recommend using `nope()` global helper for warning-free and complete ide-inspection.
Also you can use `Amirhs712\RuleBuilder\Nope` class instead.

```php
   $rules = [
        'username' => nope()->required()->string()->max(30)->get(), //[required,string,max:30]

        'password' => Nope::required()->stringOf(30)->confirmed()->get() //[required,string,confirmed,max:30]
];
```

We use `get()` to get output as an array, alternatively you can use `toString()`
to return the output as a pipe separated string.

* `toString` and `get` support a required status ranging from `-2` to `1`. 
    * 1 => call `required` rule 
    * 0 => do nothing (default) 
    * -1 => call `sometimes` rule 
    * -2 => call `sometimes` & `nullable` rules

```php
    $rules = [
        'username' => nope()->stringOf(30)->toString(1), //string|max:30|required

        'password' => nope()->stringOf(30)->toString(-2) //string|max:30|sometimes|nullable
];
```

### Date Rules with Carbon

You can pass a carbon instance to the following date rules: `after`, `afterOrEqual`, `dateEquals`,`before`, `beforeOrEqual`

```php
    $rules = [
        'date' => nope()->after('today')->get(),

        'another_date' => nope()->afterOrEqual(now()->addMonth())->get(),
];
```

### Min / Max Helpers

These methods allow you to set min and / or max arguments manually.

```php
Rule::activeUrl($max)
    ->alpha($min, $max)
    ->alphaDash($min, $max)
    ->alphaNum($min, $max)
    ->array($min, $max)
    ->file($max)
    ->image($max)
    ->integer($min, $max)
    ->json($max)
    ->numeric($min, $max)
    ->string($min, $max)
    ->url($max);
```

### Raw rules

You can use `raw(string|array)` to add raw string rules or validation objects.

```php
    $rules=[
        'field1' => nope()->raw('string|max:30')->get(),
        'field2' => nope()->raw(['string', 'max:30'])->get(),
        'field3' => nope()->raw(new ValidationObject)->get(),
        'field4' => nope()->raw([new ValidationObject, new AnotherObject])->get(),
        'field5' => nope()->raw('string')->raw('max')->get(),
];
```

* Note: You cannot call `toString` method if you have validation objects. Doing so will result in an error.

### Conditional rules
You can use `when` method to add rules conditionally.

```php
nope()->when($conditionIsMet, function(Nope $nope){
    $nope->max(100); 
});
```

### Laravel constraint builders
`in`, `notIn`, `dimensions`, `exists`, `unique` methods support both their relative constraint builders and,
their default values.

```php
    
$rules = [
    'image1' => nope()->dimensions(['width' => 300, 'height' => 300])->get(),

    'image2' => nope()->dimensions(Rule::dimensions()->width(300)->height(300))->get(),
];
```
### Templates
You can build and define your own rule templates.

__Coming soon!__
### Undefined methods

Right now there are no limitations for method calls (I could not find a reason to do so), for example you can do 
```php
nope()->myCustomExtendedRule($arg1, $arg2,...)->get(); //Results in: ["my_custom_extended_rule:$arg1, $arg2,..."]
```

## Alternatives
You can check [this package](https://github.com/timacdonald/rule-builder) as an alternative, I've implemented some ideas from this package
and merged them into my own solution.

## Feedback

Please feel free to open up an issue, or a Pull Request if you have any suggestions.  

