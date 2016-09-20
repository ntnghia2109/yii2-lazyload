<?php
/**
 * Created by PhpStorm.
 * User: cluster
 * Date: 9/20/16
 * Time: 6:54 PM
 */

namespace yiidoc\lazyload;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

class LazyWidget extends Widget
{
    public $url;
    public $blank = null;
    public $lazyCssClass = 'img-lazy';
    public $options = [];

    public function init()
    {
        $this->registerAssetBundle();
        $this->registerScript();
        $this->options['id'] = ArrayHelper::getValue($this->options, 'id', $this->id);
        Html::addCssClass($this->options, $this->lazyCssClass);
        Html::addCssClass($this->options, 'img-responsive');
        $this->options['data-src'] = $this->url;
        return $this->renderImages();
    }

    protected function renderImages()
    {
        return Html::img($this->blank, $this->options);
    }

    protected function registerScript()
    {
        $js = "jQuery('img.{$this->lazyCssClass}').lazyload();";
        $this->getView()->registerJs($js, View::POS_READY, 'lazyload');
    }

    protected function registerAssetBundle()
    {
        LazyAsset::register($this->getView());
    }
}