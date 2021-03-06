<?php

class vendor extends controller {

    function __construct($module) {
        auth::handleLogin();
        parent::__construct($module);
    }

    function index() {

        $login_model = $this->loadModel('vendor');
        $this->view->vendors = $login_model->getAllVendors();
        $this->view->render('vendor/vendor', true, true, $this->module);
    }

    function addNewVendor() {
        $valid = true;
        $data = array();
        $vendor = array();
        $login_model = $this->loadModel('vendor');

        if (!$vendor_name = $this->read->get("vendor_name", "POST", '', 250, true))
            $valid = false;
        if (!$vendor_email = $this->read->get("vendor_email", "POST", 'EMAIL', 150, true))
            $valid = false;
        if (!$vendor_address = $this->read->get("vendor_address", "POST", '', 250, true))
            $valid = false;
        if (!$vendor_cno = $this->read->get("vendor_cno", "POST", '', 15, true))
            $valid = false;
        if (!$vendor_typ = $this->read->get("vendor_typ", "POST", 'STRING', 1, true))
            $valid = false;
        if (!$vendor_remark = $this->read->get("vendor_remark", "POST", '', 1500, false))
            $valid = false;
        if (!$vendor_id = $this->read->get("vendor_id", "POST", '', 20, false))
            $valid = false;
        $vendor_id = (is_bool($vendor_id) ? '' : ($vendor_id));


        if ($valid) {
            array_push($vendor, $vendor_name);
            array_push($vendor, $vendor_email);
            array_push($vendor, $vendor_address);
            array_push($vendor, $vendor_cno);
            array_push($vendor, $vendor_typ);
            array_push($vendor, 'A');
            array_push($vendor, is_bool($vendor_remark) ? '' : $vendor_remark);
            if ($vendor_id) {
                $res = $login_model->modifyVendor($vendor_id, $vendor);
            } else {
                $res = $login_model->saveNewVendor($vendor);
            }
            if ($res) {
                $data = array('success' => true, 'data' => '', 'error' => '');
            } else {
                $data = array('success' => false, 'data' => '', 'error' => $this->view->renderFeedbackMessagesForJson());
            }
        } else {
            $data = array('success' => false, 'data' => '', 'error' => FEEDBACK_REQUIRED_FIELDS);
        }

        echo json_encode($data);
    }

    function jsonVendor($vendor = null) {
        if ($vendor) {
            $login_model = $this->loadModel('vendor');
            $res = $login_model->getEachVendor($vendor);
            if ($res) {
                $data = array('success' => true, 'data' => $res, 'error' => '');
            } else {
                $data = array('success' => false, 'data' => '', 'error' => $this->view->renderFeedbackMessagesForJson());
            }
        } else {
            $data = array('success' => false, 'data' => '', 'error' => FEEDBACK_EMPTY_VENDOR_ID);
        }
        echo json_encode($data);
    }

    function jsonStatus($vendor_id = null, $stsus = null) {
        $data = '';
        if ($vendor_id && ($stsus == 'D' OR $stsus == 'A' OR $stsus == 'I')) {
            $login_model = $this->loadModel('vendor');
            $count = $login_model->vendorUsed($vendor_id);
            if ($count > 0 && $stsus == 'D') {
                 $data = array('success' => false, 'data' => '', 'error' => FEEDBACK_VENDOR_DELETE_FAILED);
            } else {
                $item = $login_model->modifyStatus($vendor_id, $stsus);
                if ($item) {
                    $data = array('success' => true, 'data' => $item, 'error' => '');
                } else {
                    $data = array('success' => false, 'data' => '', 'error' => $this->view->renderFeedbackMessagesForJson());
                }
            }
        } else {
            $data = array('success' => false, 'data' => '', 'error' => FEEDBACK_EMPTY_VENDOR_ID);
        }
        echo json_encode($data);
    }

}

?>