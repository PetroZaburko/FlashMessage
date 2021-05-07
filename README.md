# Simple Flash Message based on PHP SESSION


## Usage
```php 
require_once('FlashMessage.php');
```

## Typical Use
```php
session_start();
$message = new FlashMessage();
```
You can use default CSS general message class ('alert'), or you may set your own message class:

```php
$message->setMessageCssClass('my_own_class');
``` 

Also you can set you own CSS class to each type instead existing (alert-info, alert-success, alert-warning, alert-danger):

```php
$message->setCssClass('info', 'other_info');
$message->setCssClass('success', 'other_success');
$message->setCssClass('warning', 'other_warning');
$message->setCssClass('danger', 'other_danger');
```

To set message text you must call one of this methods:

```php
$message->info('some info message');
$message->success('some success message');
$message->warning('some warning message');
$message->danger('some error message');
```

Wherever you want to display the messages simply call:

```php
$message->display();
```

If you don't want to display all types, you can pass argument like this:

```php
$message->display(['info', 'danger']);
```

## Simple Use

```php
session_start();
$message = new FlashMessage();
$message->setMessageCssClass('my_own_class')
        ->setCssClass('info', 'other_info_class')
        ->setCssClass('success', 'other_success_class')
        ->info('some info message')
        ->success('some success message');

$message->dispaly();
```