<?php
/**
 * Created by PhpStorm.
 * User: Shancept
 * Date: 09.03.19
 * Time: 18:12
 */

namespace app\assets;



class VueAsset extends AssetBundle
{
    public $js = [
        YII_DEBUG ? 'js/vue.js' : 'js/vue.min.js',
        'js/axios.min.js',
    ];
}