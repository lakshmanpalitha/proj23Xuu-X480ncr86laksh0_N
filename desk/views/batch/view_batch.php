<script>
    var batch_items = new Array();
</script>
<body class="page-body  page-fade">
    <div class="page-container">
        <!--Add side bar-->
        <?php require_once MOD_ADMIN_DOC . 'views/_templates/sidebar.php'; ?>
        <!--############-->
        <div class="main-content">
            <!--Add profile bar-->
            <?php require_once MOD_ADMIN_DOC . 'views/_templates/profile.php'; ?>
            <!--############-->
            <ol class="breadcrumb bc-3" >
                <li>
                    <a href="<?php echo MOD_ADMIN_URL ?>"><i class="fa-home"></i>Home</a>
                </li>
                <li>

                    <a href="<?php echo MOD_ADMIN_URL ?>batch/">Batch</a>
                </li>
                <li>

                    <a href="<?php echo MOD_ADMIN_URL ?>batch/viewBatch/<?php echo (isset($this->batch->BATCH_ID) ? base64_encode($this->batch->BATCH_ID) : '') ?>">View Batch</a>
                </li>
            </ol>

            <h2>Add Batch</h2>
            <br />
            <?php if (!empty($this->batch)) { ?>
                <form role="form" id="form1" method="post"  action="<?php echo MOD_ADMIN_URL ?>batch/addNewBatch"  class="validate_sp_form">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="border:none !important;text-align:right;" class="panel panel-primary">
                                <div style="border:none !important;text-align:right;" class="panel panel-primary">
                                    <?php echo (($this->batch->BATCH_MODE == 'S' OR $this->batch->BATCH_MODE == 'P') ? '<button class="btn btn-green btn-sm" type="submit" type="button">Modify</button>' : '') ?>
                                    <?php echo ($this->batch->BATCH_MODE == 'S' ? '<button onclick=modifytBatchMode("' . $this->batch->BATCH_ID . '","P") class="btn btn-gold btn-sm"  type="button">Submit</button>' : '') ?>
                                    <?php echo ($this->batch->BATCH_MODE == 'P' ? '<button onclick=modifytBatchMode("' . $this->batch->BATCH_ID . '","A") class="btn btn-blue btn-sm"  type="button">Accept</button>' : '') ?>
                                    <input type="hidden" name="old_batch_id" value="<?php echo ($this->batch->BATCH_ID) ?>" name=""/>
                                </div>                           
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Add New Batch &nbsp; &nbsp;
                                <?php
                                if ($this->batch->BATCH_MODE == 'S') {
                                    echo '
                                            <button class="btn btn-gold  btn-icon icon-left  btn-xs" type="button">
                                            Draft<i class="entypo-info"></i>
                                            </button>';
                                } else if ($this->batch->BATCH_MODE == 'P') {
                                    echo '
                                            <button class="btn btn-blue btn-icon icon-left  btn-xs" type="button">
                                                Submit<i class="entypo-info"></i>
                                            </button>';
                                } else if ($this->batch->BATCH_MODE == 'A') {
                                    echo '
                                            <button class="btn btn-green  btn-icon icon-left  btn-xs" type="button">
                                                Accept<i class="entypo-info"></i>
                                            </button>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Batch Code</label>

                                        <input value="<?php echo $this->batch->BATCH_CODE ?>" type="text" class="form-control" name="batch_code" data-validate="required" data-message-required="Batch code is required field." placeholder="Required Field" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Batch Name</label>
                                        <input value="<?php echo $this->batch->BATCH_NAME ?>" type="text" class="form-control" name="batch_name" data-validate="required" data-message-required="Batch name is required field." placeholder="Required Field" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Expire Date</label>
                                        <div class="input-group">
                                            <input value="<?php echo $this->batch->BATCH_EXPIRE_DATE ?>" name="exp_date" id="exp_date" type="text" class="form-control datepicker" placeholder="Required Field" data-format="yyyy-mm-dd">
                                            <div class="input-group-addon">
                                                <a href="#"><i class="entypo-calendar"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Product</label>
                                        <select onchange="getProductUnit(this)" id="batch_product" name="batch_product" class="select2" data-allow-clear="true" data-placeholder="Select product">
                                            <?php
                                            if (!empty($this->products)) {
                                                foreach ($this->products as $product) {
                                                    ?>
                                                    <option myTag='<?php echo base64_encode($product->PRODUCT_ID) ?>' <?php echo ($this->batch->PRODUCT_ID == $product->PRODUCT_ID ? 'selected' : '') ?> value="<?php echo $product->PRODUCT_ID ?>" ><?php echo $product->PRODUCT_NAME ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span id='product_url' style=" float: right;margin: 10px 0 0;"><a href="<?php echo MOD_ADMIN_URL ?>product/viewProduct/<?php echo base64_encode($this->batch->PRODUCT_ID) ?>" target="_blank"><u>View Product</u></a></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Batch Quantity (<span id="product_unit"></span>)</label>
                                        <input value="<?php echo $this->batch->BATCH_QUANTITY ?>" type="text" class="form-control" id="batch_qty" name="batch_qty" data-validate="required,number" placeholder="Required Numeric Field" />
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-gray" data-collapsed="0">

                                        <!-- panel head -->
                                        <div class="panel-heading">
                                            <div class="panel-title">Batch Material</div>
                                        </div>

                                        <!-- panel body -->
                                        <div class="panel-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered datatable" id="table-1">
                                                        <thead>
                                                            <tr>
                                                                <th>Material name</th>
                                                                <th>Quantity</th>
                                                                <th>Remark</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (!empty($this->batch_mats)) {
                                                                foreach ($this->batch_mats as $batch_mat) {
                                                                    ?>
                                                                <script>
            try {
            var item_id = '<?php echo $batch_mat->ITEM_ID ?>';
            batch_items[item_id] = new Array();
            batch_items[item_id] = {
            item_id: '<?php echo $batch_mat->ITEM_ID ?>',
            item_qty: '<?php echo $batch_mat->BATCH_ITEM_QUANTITY ?>',
            item_remark: '<?php echo $batch_mat->BATCH_ITEM_REMARK ?>',
            };
            }
            catch (err) {
            alert(err.message);
            }
                                                                </script>
                                                                <tr>
                                                                    <td><?php echo $batch_mat->ITEM_NAME ?></td>
                                                                    <td><?php echo $batch_mat->BATCH_ITEM_QUANTITY ?>&nbsp(<?php echo $batch_mat->UNIT_NAME ?>)</td>
                                                                    <?php echo $batch_mat->BATCH_ITEM_REMARK ?>
                                                                    <td>
            <!--                                                                        <a href="javascript:;" onclick="viewItem('<?php echo $batch_mat->ITEM_ID ?>', this)" class="btn btn-gold btn-xs btn-icon icon-left">
                                                                            <i class="entypo-pencil"></i>View
                                                                        </a>  -->
                                                                        <a href="javascript:;" onclick="deleteItemRow('<?php echo $batch_mat->ITEM_ID ?>', this)" class="btn btn-danger btn-xs btn-icon icon-left">
                                                                            <i class="entypo-pencil"></i>Delete
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a class="btn btn-blue" href="javascript:;" onclick="jQuery('#modal-6').modal('show', {backdrop: 'static'});">
                                                        <i class="entypo-plus"></i>
                                                        Add New
                                                    </a>                                                 
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="about">Batch Remark</label>
                                        <textarea style="border-radius:0 !important;height:70px !important" class="form-control autogrow" name="batch_remark" id="batch_remark" data-validate="" rows="5" placeholder="Batch Remark"><?php echo $this->batch->BATCH_REMARK ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-gray" data-collapsed="0">

                            <!-- panel head -->
                            <div class="panel-heading">
                                <div class="panel-title">Batch History</div>
                            </div>

                            <!-- panel body -->
                            <div class="panel-body">
                                <ul class="cbp_tmtimeline">
                                    <ul class="cbp_tmtimeline">
                                        <?php
                                        if (!empty($this->history)) {
                                            foreach ($this->history as $his) {
                                                $dateTime = explode(" ", $his->LOG_DATE);
                                                $time = date('h:i:s A', strtotime($dateTime[1]));
                                                $date = date('Y-M-d', strtotime($dateTime[0]));
                                                ?>
                                                <li>
                                                    <time class="cbp_tmtime" datetime="2014-12-09T03:45"><span><?php echo $time ?></span> <span><?php echo $date ?></span></time>
                                                    <div class="cbp_tmicon">
                                                        <i class="entypo-user"></i>
                                                    </div>

                                                    <div class="cbp_tmlabel">
                                                        <h2><a href="#"><?php echo $his->LOG_USER ?></a></h2>
                                                        <p><?php echo $his->LOG_TASK ?></p>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger"><strong>Oh snap!</strong> Selected Batch not longer used.</div>
                    </div>
                </div>
            <?php } ?>
            <!--Add footer-->
            <?php require_once MOD_ADMIN_DOC . 'views/_templates/sub_footer.php'; ?>
            <!--############-->
        </div>
    </div>
    <!-- Modal 6 (Long Modal)-->
    <div class="modal fade" id="modal-6">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">New Item</h4>
                </div>
                <form role="form" id="form1" method="post" class="validate">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="control-label">Item Code</label>
                                    <select name="batch_item" id="batch_item" onchange="getItemIssueUnit(this)" class="select2" data-allow-clear="true" data-placeholder="Select item">
                                        <?php
                                        if (!empty($this->items)) {
                                            foreach ($this->items as $item) {
                                                ?>
                                                <option myTag='<?php echo base64_encode($item->ITEM_ID) ?>' value="<?php echo $item->ITEM_ID ?>" ><?php echo $item->ITEM_NAME ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>                                   
                                </div>	

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-6" class="control-label">Quantity (<span id="stock_unit"></span>)</label>
                                    <input name="batch_item_qty" id="batch_item_qty" type="text" class="form-control"  data-validate="required,number" placeholder="Required Numeric Field" />
                                </div>	
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="about">Recipe Item Remark</label>
                                    <textarea style="border-radius:0 !important;height:70px !important" class="form-control autogrow" name="batch_item_remark" id="batch_item_remark"  rows="5" placeholder="Item Remark"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    function getItemIssueUnit(e)
    {
        try {
            var param = "item_id=" + e.value;
            ajaxRequest('<?php echo MOD_ADMIN_URL ?>item/jsonGetItemIssueUnit', param, function(jsonData) {

                if (jsonData) {
                    if (jsonData.success == true) {
                        document.getElementById('stock_unit').innerHTML = "<b>" + jsonData.data + "</b>";

                    } else {
                        errorModal(jsonData.error);
                        return false;
                    }
                }
            });
        }
        catch (err) {
            alert(err.message);
            return false;
        }

    }
    function getProductUnit(e) {
        try {
            var param = "product_id=" + e.value;
            var myTag = jQuery('#batch_product option:selected').attr('myTag');
            var html = "<a href='<?php echo MOD_ADMIN_URL ?>product/viewProduct/" + myTag + "' target='_blank'><u>View Product</u></a>";
            jQuery('#product_url').html(html);
            ajaxRequest('<?php echo MOD_ADMIN_URL ?>product/jsonGetProductUnit', param, function(jsonData) {

                if (jsonData) {
                    if (jsonData.success == true) {
                        document.getElementById('product_unit').innerHTML = "<b>" + jsonData.data + "</b>";

                    } else {
                        errorModal(jsonData.error);
                        return false;
                    }
                }
            });
        }
        catch (err) {
            alert(err.message);
            return false;
        }

    }
    function recall(form) {

        try {
            var item_id = jQuery('#batch_item').val();
            var myTag = jQuery('#batch_item option:selected').attr('myTag');
            if (typeof batch_items[item_id] === 'undefined') {
                batch_items[item_id] = new Array();
                batch_items[item_id] = {
                    item_id: item_id,
                    item_qty: jQuery('#batch_item_qty').val(),
                    item_remark: jQuery('#batch_item_remark').val()
                };
                var row = '<tr id="' + item_id + '">';
                row = row + '<td><a target="_blank" href="<?php echo MOD_ADMIN_URL ?>item/viewItem/' + myTag + '"><u>' + jQuery('#batch_item option:selected').text() + '</u></a></td>';
                row = row + '<td>' + jQuery('#batch_item_qty').val() + '</td>';
                row = row + '<td>' + jQuery('#batch_item_remark').val() + '</td>';
                //<a href="javascript:;" onclick=viewItem("' + item_id + '",this) class="btn btn-gold btn-xs btn-icon icon-left"><i class="entypo-pencil"></i>View</a> &nbsp 
                row = row + '<td><a href="javascript:;" onclick=deleteItemRow("' + item_id + '",this) class="btn btn-danger btn-xs btn-icon icon-left"><i class="entypo-pencil"></i>Delete</a></td>';
                row = row + '</tr>';
                jQuery("#table-1 tbody").prepend(row);


            }
            else {
                alert("Item is allredy exist!");
            }
        }
        catch (err) {
            alert(err.message);
            return false;

        }

        return false;
    }
    function deleteItemRow(id, e) {
        try {
            if (typeof batch_items[id] === 'undefined') {

            } else {
                delete batch_items[id];
                var tr = jQuery(e).closest('tr');
                tr.remove();
            }
        }
        catch (err) {
            alert(err.message);
            return false;
        }
    }
    function viewItem() {
        try {
            jQuery('#modal-6').modal('show', {backdrop: 'static'});
        }
        catch (err) {
            alert(err.message);
            return false;
        }

    }
    function submitFrom(form) {
        try {
            var data = new Array();
            for (var key in batch_items) {
                var value = batch_items[key];
                data.push(value);
            }
            var param = jQuery('#' + form.id).serialize() + "&items=" + (JSON.stringify(data));
            ajaxRequest(form.action, param, function(jsonData) {
                if (jsonData) {
                    if (jsonData.success == true) {
                        jQuery(location).attr('href', '<?php echo MOD_ADMIN_URL ?>batch');
                    } else {
                        errorModal(jsonData.error);
                        return false;
                    }
                }
            });
        }
        catch (err) {
            alert(err.message);
            return false;
        }
        return false;
    }
    function modifytBatchMode(val, ststus) {
        try {
            if (doConfirm('Are you confirm to ' + (ststus == 'P' ? 'submit' : 'accept') + ' batch?')) {
                ajaxRequest('<?php echo MOD_ADMIN_URL ?>batch/jsonMode/' + val + '/' + ststus + '/', '', function(jsonData) {
                    if (jsonData) {
                        if (jsonData.success == true) {
                            jQuery(location).attr('href', '<?php echo MOD_ADMIN_URL ?>batch');
                        } else {
                            errorModal(jsonData.error);
                            return false;
                        }
                    }
                });
            }
        }
        catch (err) {
            alert(err.message);
            return false;
        }
    }
    </script>
    <link rel="stylesheet" href="<?php echo JS_PATH ?>select2/select2-bootstrap.css">
    <link rel="stylesheet" href="<?php echo JS_PATH ?>select2/select2.css">
    <link rel="stylesheet" href="<?php echo JS_PATH ?>vertical-timeline/css/component.css">
    <!-- Bottom scripts (common) -->
    <script src="<?php echo JS_PATH ?>gsap/main-gsap.js"></script>
    <script src="<?php echo JS_PATH ?>jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
    <script src="<?php echo JS_PATH ?>bootstrap.js"></script>
    <script src="<?php echo JS_PATH ?>joinable.js"></script>
    <script src="<?php echo JS_PATH ?>resizeable.js"></script>
    <script src="<?php echo JS_PATH ?>neon-api.js"></script>


    <!-- Imported scripts on this page -->
    <script src="<?php echo JS_PATH ?>select2/select2.min.js"></script>
    <script src="<?php echo JS_PATH ?>jquery.validate.min.js"></script>
    <script src="<?php echo JS_PATH ?>neon-chat.js"></script>
    <script src="<?php echo JS_PATH ?>bootstrap-datepicker.js"></script>


    <!-- JavaScripts initializations and stuff -->
    <script src="<?php echo JS_PATH ?>neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="<?php echo JS_PATH ?>neon-demo.js"></script>