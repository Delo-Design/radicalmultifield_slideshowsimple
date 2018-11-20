<?php

/**
 * @package    Radical MultiField
 *
 * @author     delo-design.ru <info@delo-design.ru>
 * @copyright  Copyright (C) 2018 "Delo Design". All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://delo-design.ru
 */

use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;

if (!$field->value)
{
    return;
}

$values = json_decode($field->value, JSON_OBJECT_AS_ARRAY);
$listtype = $this->getListTypeFromField($field);


HTMLHelper::stylesheet('plg_radicalmultifield_slideshowsimple/style.css', [
    'version' => filemtime ( __FILE__ ),
    'relative' => true,
]);

HTMLHelper::script('plg_radicalmultifield_slideshowsimple/jssor.slider-27.5.0.min.js', [
    'version' => filemtime ( __FILE__ ),
    'relative' => true,
]);

$id = rand(11111, 99999);
?>

<script type="text/javascript">

    jssor_<?= $id ?>_slider_init = function() {

        var jssor_<?= $id ?>_SlideshowTransitions = [
            {$Duration:800,$Opacity:2}
        ];

        var jssor_<?= $id ?>_options = {
            $AutoPlay: 1,
            $SlideshowOptions: {
                $Class: $JssorSlideshowRunner$,
                $Transitions: jssor_<?= $id ?>_SlideshowTransitions,
                $TransitionsOrder: 1
            },
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
            },
            $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
            }
        };

        var jssor_<?= $id ?>_slider = new $JssorSlider$("jssor_<?= $id ?>", jssor_<?= $id ?>_options);

        /*#region responsive code begin*/

        var MAX_WIDTH = <?= $field->fieldparams->get('maxWidth', '980') ?>;
        var parent, containerWidth;

        function ScaleSlider() {

            if(parent === undefined) {
                parent = jQuery('#jssor_<?= $id ?>').parent();
            }


            if(parent.width() > 0) {
                containerWidth = parent.width();
            } else {
                parent = parent.parent();
            }

            if (containerWidth) {

                var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                jssor_<?= $id ?>_slider.$ScaleWidth(expectedWidth);
            }
            else {
                window.setTimeout(ScaleSlider, 30);
            }

        }

        ScaleSlider();

        $Jssor$.$AddEvent(window, "load", ScaleSlider);
        $Jssor$.$AddEvent(window, "resize", ScaleSlider);
        $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
        /*#endregion responsive code end*/
    };

</script>

<div id="jssor_<?= $id ?>" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:380px;overflow:hidden;visibility:hidden;">

    <!-- Loading Screen -->
    <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
        <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="/media/plg_radicalmultifield_slideshowsimple/img/spin.svg" />
    </div>
    <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:380px;overflow:hidden;">

        <?php foreach ($values as $key => $row): ?>
            <div>
                <img data-u="image" src="<?= $row['image']?>" alt="<?= $row['alt'] ?>" />
            </div>
        <?php endforeach; ?>

    </div>
    <!-- Bullet Navigator -->
    <div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
        <div data-u="prototype" class="i" style="width:16px;height:16px;">
            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <circle class="b" cx="8000" cy="8000" r="5800"></circle>
            </svg>
        </div>
    </div>
    <!-- Arrow Navigator -->
    <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
        <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
            <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
        </svg>
    </div>
    <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
        <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
            <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
        </svg>
    </div>

</div>
<script type="text/javascript">jssor_<?= $id ?>_slider_init();</script>
<!-- #endregion Jssor Slider End -->

