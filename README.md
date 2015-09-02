#Bootstrap Notify Alerts for Yii2

[Bootstrap Notify](http://bootstrap-notify.remabledesigns.com/) flash messages for Yii2.

This extension is nothing more than the Bootstrap Notify javascript and the [Animate.css](http://daneden.github.io/animate.css/) styles wrapped in a tiny extension. This extension aims to bring the power of Bootstrap Notify to Yii2 without additional enhancements or overhead. Simply add `use justinvoelker\bootstrapnotifyalert\FlashAlert;` to your layout and call the widget with `<?= FlashAlert::widget() ?>` to get started. Of course, there are options that can be specified as well to tweak the settings as desired.   

##Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist justinvoelker/yii2-bootstrapnotifyalert "*"
```

or add

```
"justinvoelker/yii2-bootstrapnotifyalert": "*"
```

to the require section of your `composer.json` file.

##Setup

Add `justinvoelker\bootstrapnotifyalert\BootstrapNotifyAlertAsset` as a dependency in your `assets\AppAsset` file. It should look similar to the following:

```php
...
public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap\BootstrapAsset',
    'justinvoelker\bootstrapnotifyalert\BootstrapNotifyAlertAsset',
];
...
```

##Usage

###Basic Usage

Simply add the necessary `use justinvoelker\bootstrapnotifyalert\FlashAlert;` statement to your layout file then call the widget:

```php
<?= FlashAlert::widget() ?>
```

###Advanced Usage

Rather than accept the defaults specified by Bootstrap Notify, any property can be set through the widget.  Here are just a few of the usual options I like to use:

```php
<?= FlashAlert::widget([
    'showProgressbar' => true,
    'delay' => 10000,
    'mouse_over' => 'pause',
    'placement_from' => 'bottom',
    'placement_align' => 'right',
    'animate_enter' => 'animated fadeInUp',
    'animate_exit' => 'animated fadeOutDown',
]) ?>
```

If a single message is needed without using flash data, just specify the message and optional `type` (type will be 'info' if not specified):

```php
<?= FlashAlert::widget([
    'message' => 'You cannot do that!',
    'type' => 'danger',
    'delay' => 10000,
]) ?>
```

Perhaps there is a very specific need to echo `FlashAlert::widget()` multiple times but each will have the same options. Use the `registerAsDefaults` parameter to set the notify options without a message or flash data:

```php
<?= FlashAlert::widget([
    'registerAsDefaults' => true,
    'delay' => 10000,
    'mouse_over' => 'pause',
]) ?>
<?= FlashAlert::widget() ?>
```

When setting `registerAsDefaults` to `true`, be sure to always include `<?= FlashAlert::widget() ?>` afterward or there will be no alerts, just default options.

##Optional

Additional CSS can be specified in your site stylesheet to further define the look and feel of the alerts. To use either of the following progressbar styles, the `showProgressbar` option needs to be set to `true`.

The [Bootstrap Notify](http://bootstrap-notify.remabledesigns.com/) documentation includes a specific example to change the size and position of the progress bars to match their appearance in the demos:

```css
[data-notify="progressbar"] { margin-bottom: 0px; position: absolute; bottom: 0px; left: 0px; width: 100%; height: 5px; }
```

Another style that I frequently use adjusts the progress bar so that is has a smooth continuous animation rather than start-stop movements:

```css
[data-notify="progressbar"] .progress-bar { -webkit-transition: width 1s linear; -o-transition: width 1s linear; transition: width 1s linear; }
```
