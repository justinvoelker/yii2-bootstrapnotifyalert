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

###Really Advanced Usage

Using the `registerAsDefaults` above really comes in handy when you need to trigger alerts from multiple places but only want to set the defaults once. For example, most alerts are triggers by setting flash messages inside a controller. However, alerts can also be trigger directly via JavaScript in a view. By default, all of the assets in Bootstrap Notify Alerts are loaded after page ready. This works for alerts set in the controller but is too late for alerts inside some custom, page-specific JavaScript. Using the `registerPosition` parameter allows us to dictate where the Flash Alert logic is inserted into the page.

A practical example of this is as follows. Nearly every page on a website only displays alerts that were set inside a controller and can load after the page is ready. However, one page of the website needs to set some alerts in some custom JavaScript in the view. On that one page we need the assets and Flash Alert defaults to be registered earlier so that the are available for use later in the page inside the custom JavaScript. To have our normal pages load everything at the end but still be able to user them earlier on some pages we can do the following.

In the view reguiring early registration, set a parameter that can be read from the layout (this can go right below the title and breadcrumb declarations):

```php
$this->params['bootstrapNotifyAlertAssetInHead'] = true;
```

Then, in the main layout, register the assets only if that parameter is set (this needs to go before the call to beginPage()):

```php
if (isset($this->params['bootstrapNotifyAlertAssetInHead'])) {
    $this->registerAssetBundle(justinvoelker\bootstrapnotifyalert\BootstrapNotifyAlertAsset::className(), $this::POS_HEAD);
}
```

Finally, also on the main layout, set the `registerPosition` of the FlashAlert widget that is also setting `registerAsDefaults`:

```php
<?= FlashAlert::widget([
    'registerAsDefaults' => true,
    'registerPosition' => (isset($this->params['bootstrapNotifyAlertAssetInHead'])) ? $this::POS_BEGIN : null,
    ...
]) ?>
<?= FlashAlert::widget() ?>
```

Together, the previous snippets of code will set a custom parameter inside a view which will be used inside the layout to register the BootstrapNotifyAlertAsset in the head rather than document ready position. Finally, the FlashAlert sets defaults and will do so at the beginning of the body rather than the document ready position. The last `FlashAlert::widget()` will display all alerts set within a controller. At this point, everything will work the same except in the view we can add `$.notify('User invited',{ type: 'success' });` and have an alert display without reloading the page.

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
