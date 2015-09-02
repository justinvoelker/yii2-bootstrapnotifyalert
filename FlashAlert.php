<?php

namespace justinvoelker\bootstrapnotifyalert;

use Yii;
use yii\base\Widget;

/**
 * Setting various properties will change the behavior of the FlashAlert widget.  With the no properties specified,
 * the widget will display all flash data using the key as the alert class (success, info, warning, or danger) and
 * value as the message. If a message is provided, no flash data is used and only that message is used (you will also
 * need to specify the type or else the default "info" will be used). Finally, if registerAsDefaults is set to true,
 * no flash data or message will be used but the properties you specified will be used as defaults for future widgets.
 *
 * See {@link http://bootstrap-notify.remabledesigns.com/ Bootstrap Notify} for descriptions of each option and setting.
 *
 * @author Justin Voelker <justin@justinvoelker.com>
 */
class FlashAlert extends Widget
{

    private $_options = [];
    private $_settings = [];

    public $registerAsDefaults = false;

    public $icon;
    public $title;
    public $message;
    public $url;
    public $target;

    public $element;
    public $position;
    public $type;
    public $allow_dismiss;
    public $newest_on_top;
    public $showProgressbar;
    public $placement_from;
    public $placement_align;
    public $offset;
    public $offset_x;
    public $offset_y;
    public $spacing;
    public $z_index;
    public $delay;
    public $timer;
    public $url_target;
    public $mouse_over;
    public $animate_enter;
    public $animate_exit;
    public $onShow;
    public $onShown;
    public $onClose;
    public $onClosed;
    public $icon_type;
    public $template;

    public function run()
    {
        if ($this->message || $this->registerAsDefaults) {
            $this->register();
        } elseif (!empty(Yii::$app->session->allFlashes)) {
            foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                $this->flash($key, $message);
            }
        }
    }

    protected function flash($type, $message)
    {
        $this->message = $message;
        $this->type = $type;
        $this->register();
    }

    protected function register()
    {
        $this->setOptions();
        $this->setSettings();

        if ($this->registerAsDefaults) {
            $js = '$.notifyDefaults({' . implode(',', $this->_settings) . '});';
        } elseif (count($this->_settings)) {
            $js = '$.notify({' . implode(',', $this->_options) . '}, {' . implode(',', $this->_settings) . '});';
        } else {
            $js = '$.notify({' . implode(',', $this->_options) . '});';
        }

        $view = $this->getView();
        $view->registerJs($js, $view::POS_READY);
    }

    protected function setOptions()
    {
        if (isset($this->icon)) {
            array_push($this->_options, "icon:'$this->icon'");
        }
        if (isset($this->title)) {
            array_push($this->_options, "title:'$this->title'");
        }
        if (isset($this->message)) {
            array_push($this->_options, "message:'$this->message'");
        }
        if (isset($this->url)) {
            array_push($this->_options, "url:'$this->url'");
        }
        if (isset($this->target)) {
            array_push($this->_options, "target:'$this->target'");
        }
    }

    protected function setSettings()
    {
        if (isset($this->element)) {
            array_push($this->_settings, "element:'$this->element'");
        }
        if (isset($this->position)) {
            array_push($this->_settings, "position:'$this->position'");
        }
        if (isset($this->type)) {
            array_push($this->_settings, "type:'$this->type'");
        }
        if (isset($this->allow_dismiss)) {
            array_push($this->_settings, "allow_dismiss:$this->allow_dismiss");
        }
        if (isset($this->newest_on_top)) {
            array_push($this->_settings, "newest_on_top:$this->newest_on_top");
        }
        if (isset($this->showProgressbar)) {
            array_push($this->_settings, "showProgressbar:$this->showProgressbar");
        }
        if (isset($this->placement_from) || isset($this->placement_align)) {
            $placement = [];
            if (isset($this->placement_from)) {
                array_push($placement, "from:'$this->placement_from'");
            }
            if (isset($this->placement_align)) {
                array_push($placement, "align:'$this->placement_align'");
            }
            $placementJs = implode(',', $placement);
            array_push($this->_settings, "placement:{" . $placementJs . "}");
        }
        if (isset($this->offset)) {
            array_push($this->_settings, "offset:$this->offset");
        }
        if (isset($this->offset_x) || isset($this->offset_y)) {
            $offset = [];
            if (isset($this->offset_x)) {
                array_push($offset, "x:'$this->offset_x'");
            }
            if (isset($this->offset_y)) {
                array_push($offset, "y:'$this->offset_y'");
            }
            $offsetJs = implode(',', $offset);
            array_push($this->_settings, "offset:{" . $offsetJs . "}");
        }
        if (isset($this->spacing)) {
            array_push($this->_settings, "spacing:$this->spacing");
        }
        if (isset($this->z_index)) {
            array_push($this->_settings, "z_index:$this->z_index");
        }
        if (isset($this->delay)) {
            array_push($this->_settings, "delay:$this->delay");
        }
        if (isset($this->timer)) {
            array_push($this->_settings, "timer:$this->timer");
        }
        if (isset($this->url_target)) {
            array_push($this->_settings, "url_target:'$this->url_target'");
        }
        if (isset($this->mouse_over)) {
            array_push($this->_settings, "mouse_over:'$this->mouse_over'");
        }
        if (isset($this->animate_enter) || isset($this->animate_exit)) {
            $animate = [];
            if (isset($this->animate_enter)) {
                array_push($animate, "enter:'$this->animate_enter'");
            }
            if (isset($this->animate_exit)) {
                array_push($animate, "exit:'$this->animate_exit'");
            }
            $animateJs = implode(',', $animate);
            array_push($this->_settings, "animate:{" . $animateJs . "}");
        }
        if (isset($this->onShow)) {
            array_push($this->_settings, "onShow:'$this->onShow'");
        }
        if (isset($this->onShown)) {
            array_push($this->_settings, "onShown:'$this->onShown'");
        }
        if (isset($this->onClose)) {
            array_push($this->_settings, "onClose:'$this->onClose'");
        }
        if (isset($this->onClosed)) {
            array_push($this->_settings, "onClosed:'$this->onClosed'");
        }
        if (isset($this->icon_type)) {
            array_push($this->_settings, "icon_type:'$this->icon_type'");
        }
        if (isset($this->template)) {
            array_push($this->_settings, "template:'$this->template'");
        }
    }

}
