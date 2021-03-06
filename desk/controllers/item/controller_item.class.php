<?php

class item extends controller {

    function __construct($module) {
        auth::handleLogin();
        parent::__construct($module);
    }

    /**
     * Display the company dashbord sccreen
     */
    function index() {
        $login_model = $this->loadModel('item');
        $this->view->items = $login_model->getAllItem();
        $this->view->render('item/item', true, true, $this->module);
    }

    function newItem() {
        $login_model = $this->loadModel('item');
        $login_model_setting = $this->loadModel('setting');
        $this->view->cat = $login_model_setting->getAllActiveCat();
        $this->view->unit = $login_model->getAllActiveUnit();
        $this->view->render('item/add_item', true, true, $this->module);
    }

    function viewItem($item_id) {
        $login_model = $this->loadModel('item');
        $login_model_setting = $this->loadModel('setting');
        $this->view->cat = $login_model_setting->getAllActiveCat();
        $this->view->sub_cat = $login_model_setting->getAllSubCat();
        $this->view->unit = $login_model->getAllActiveUnit();
        $this->view->item = $login_model->getSelectItem(base64_decode($item_id));
        $this->view->history = $login_model->history(base64_decode($item_id));
        $this->view->render('item/view_item', true, true, $this->module);
    }

    function addNewItem() {

        $valid = true;
        $data = array();
        $item = array();
        $login_model = $this->loadModel('item');

        if (!$item_code = $this->read->get("itm_code", "POST", 'NUMERIC', 50, false))
            $valid = false;
        if (!$item_name = $this->read->get("item_name", "POST", '', 250, true))
            $valid = false;
        if (!$item_cat = $this->read->get("item_cat", "POST", 'NUMERIC', 6, true))
            $valid = false;
        if (!$item_sub_cat = $this->read->get("item_sub_cat", "POST", 'NUMERIC', 6, false))
            $valid = false;
        if (!$item_stock_unit = $this->read->get("item_stock_unit", "POST", 'NUMERIC', 6, true))
            $valid = false;
        if (!$item_ratio = $this->read->get("item_ratio", "POST", 'DOUBLE', '', true))
            $valid = false;
        if (!$item_issue_unit = $this->read->get("issue_unit", "POST", 'NUMERIC', 6, true))
            $valid = false;
        if (!$item_ord_lvl = $this->read->get("item_ord_lvl", "POST", 'DOUBLE', '', true))
            $valid = false;
        if (!$item_n_ord_lvl = $this->read->get("item_n_ord_lvl", "POST", 'DOUBLE', '', true))
            $valid = false;
        if (!$item_loc = $this->read->get("item_loc", "POST", '', 50, true))
            $valid = false;
        if (!$item_remark = $this->read->get("item_remark", "POST", '', 1500, false))
            $valid = false;
        if (!$old_item_id = $this->read->get("old_item_id", "POST", '', '', false))
            $valid = false;

        $old_item_id = (is_bool($old_item_id) ? '' : ($old_item_id));

        if ($valid) {
            array_push($item, $item_code);
            array_push($item, $item_name);
            array_push($item, $item_cat);
            array_push($item, (is_bool($item_sub_cat) ? '' : $item_sub_cat));
            array_push($item, $item_stock_unit);
            array_push($item, $item_ratio);
            array_push($item, $item_issue_unit);
            array_push($item, $item_ord_lvl);
            array_push($item, $item_n_ord_lvl);
            array_push($item, $item_loc);
            array_push($item, (is_bool($item_remark) ? '' : $item_remark));
            array_push($item, 'A');
            if ($old_item_id) {
                $status = $login_model->getSelectItem($old_item_id);
                if ($status->ITEM_MODE == 'S' OR $status->ITEM_MODE == 'P') {//Status save  or submit 
                    $res = $login_model->modifyItem($old_item_id, $item);
                    if ($res) {
                        $data = array('success' => true, 'data' => '', 'error' => '');
                    } else {
                        $data = array('success' => false, 'data' => '', 'error' => $this->view->renderFeedbackMessagesForJson());
                    }
                } else {
                    $data = array('success' => false, 'data' => '', 'error' => FEEDBACK_ITEM_UPDATE_FAILED);
                    exit(json_encode($data));
                }
            } else {
                $res = $login_model->saveNewItem($item);
                if ($res) {
                    $data = array('success' => true, 'data' => '', 'error' => '');
                } else {
                    $data = array('success' => false, 'data' => '', 'error' => FEEDBACK_ITEM_CREATE_FAILED);
                }
            }
        } else {
            $data = array('success' => false, 'data' => '', 'error' => $this->view->renderFeedbackMessagesForJson());
        }
        echo json_encode($data);
    }

    function jsonGetItemStockUnit() {
        $data = array();
        $valid = true;
        if (!$itemId = $this->read->get("item_id", "POST", 'NUMERIC', 6, true)) {
            $valid = false;
        }
        if ($valid) {
            $login_model = $this->loadModel('item');
            $data = array('success' => true, 'data' => $login_model->getItemStockUnit($itemId), 'error' => '');
        } else {
            $data = array('success' => false, 'data' => '', 'error' => $this->view->renderFeedbackMessagesForJson());
        }
        echo json_encode($data);
    }
    function jsonGetItemIssueUnit() {
        $data = array();
        $valid = true;
        if (!$itemId = $this->read->get("item_id", "POST", 'NUMERIC', 6, true)) {
            $valid = false;
        }
        if ($valid) {
            $login_model = $this->loadModel('item');
            $data = array('success' => true, 'data' => $login_model->getItemIssueUnit($itemId), 'error' => '');
        } else {
            $data = array('success' => false, 'data' => '', 'error' => $this->view->renderFeedbackMessagesForJson());
        }
        echo json_encode($data);
    }

    function jsonStatus($item_id = null, $stsus = null) {
        $data = '';
        if ($item_id && ($stsus == 'D' OR $stsus == 'A' OR $stsus == 'I')) {
            $login_model = $this->loadModel('item');
            $count = $login_model->itemUsed($item_id);
            if ($count > 0 && $stsus == 'D') {
               $data = array('success' => false, 'data' => '', 'error' => FEEDBACK_ITEM_DELETE_FAILED); 
            } else {
                $item = $login_model->modifyStatus($item_id, $stsus);
                if ($item) {
                    $data = array('success' => true, 'data' => $item, 'error' => '');
                } else {
                    $data = array('success' => false, 'data' => '', 'error' => $this->view->renderFeedbackMessagesForJson());
                }
            }
        } else {
            $data = array('success' => false, 'data' => '', 'error' => FEEDBACK_EMPTY_RECIPE_ID);
        }
        echo json_encode($data);
    }

    function jsonMode($item_id = null, $stsus = null) {
        $data = '';
        $login_model = $this->loadModel('item');
        $mode = $login_model->getSelectItem($item_id);
        if ($mode->ITEM_MODE == 'A' && $stsus == 'P') {
            $data = array('success' => false, 'data' => '', 'error' => FEEDBACK_INVALID_ACTION);
        } else {
            if ($item_id && ($stsus == 'P' OR $stsus == 'A')) {
                $item = $login_model->modifyMode($item_id, $stsus);
                if ($item) {
                    $data = array('success' => true, 'data' => $item, 'error' => '');
                } else {
                    $data = array('success' => false, 'data' => '', 'error' => $this->view->renderFeedbackMessagesForJson());
                }
            } else {
                $data = array('success' => false, 'data' => '', 'error' => FEEDBACK_EMPTY_RECIPE_ID);
            }
        }

        echo json_encode($data);
    }

}

?>