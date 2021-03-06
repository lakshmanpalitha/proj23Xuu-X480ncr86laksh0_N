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

                    <a href="<?php echo MOD_ADMIN_URL ?>item/">Items</a>
                </li>
                <li>

                    <a href="<?php echo MOD_ADMIN_URL ?>item/newItem/">Add items</a>
                </li>
            </ol>

            <h2>Add item</h2>
            <br />
            <form role="form" id="form1" method="post" action="<?php echo MOD_ADMIN_URL ?>item/addNewItem" class="validate_sp_form">
                <div class="row">
                    <div class="col-md-12">
                        <div style="border:none !important;text-align:right;" class="panel panel-primary">
                            <button name="item_save" value="itm_save" class="btn btn-green btn-sm" type="submit">Save</button>           
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Add New Item&nbsp; &nbsp;
                            <button class="btn btn-gold  btn-icon icon-left  btn-xs" type="button">New<i class="entypo-info"></i></button>
                        </div>
                    </div>

                    <div class="panel-body">            
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Item Reference No</label>
                                    <input type="text" class="form-control" name="itm_code"  placeholder="Require Field" />
                                </div>	
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input type="text" class="form-control" name="item_name" data-validate="required" placeholder="Require Field" />
                                </div>	
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-6" class="control-label">Category</label>
                                    <select name="item_cat" onchange="getSubCat(this)" class="select2" data-allow-clear="true" data-placeholder="Select category">
                                        <option></option>
                                        <?php
                                        if (!empty($this->cat)) {
                                            foreach ($this->cat as $cat) {
                                                ?>
                                                <option value="<?php echo $cat->ITEM_CAT_ID ?>"><?php echo $cat->ITEM_CAT_NAME ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>	
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-6" class="control-label">Sub category</label>
                                    <select name="item_sub_cat" id="sub_category" class="form-control">

                                    </select>
                                </div>	
                            </div>             
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="field-6" class="control-label">Stock Unit</label>
                                    <select name="item_stock_unit"  class="form-control">
                                        <option value="">-Select-</option>
                                        <?php
                                        if (!empty($this->unit)) {
                                            foreach ($this->unit as $unit) {
                                                ?>
                                                <option value="<?php echo $unit->UNIT_CODE ?>"><?php echo $unit->UNIT_NAME ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>	
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="field-6" class="control-label">Issue Unit</label>
                                    <select name="issue_unit"  class="form-control">
                                        <option value="">-Select-</option>
                                        <?php
                                        if (!empty($this->unit)) {
                                            foreach ($this->unit as $unit) {
                                                ?>
                                                <option value="<?php echo $unit->UNIT_CODE ?>"><?php echo $unit->UNIT_NAME ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>	
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="field-6" class="control-label">Ratio (Stock unit to Issue unit)</label>
                                    <select name="item_ratio"  class="form-control">
                                        <option value="">-Select-</option>
                                        <option value="1">1X</option> 
                                        <option  value="1000">1000X</option>
                                        <option  value="1000000">1000000X</option>
                                    </select>                                   
                                </div>	
                            </div>              
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="field-6" class="control-label">Order Level</label>
                                    <input type="text" class="form-control" name="item_ord_lvl" data-validate="required,number" placeholder="Required Numeric Field" />
                                </div>	
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="field-6" class="control-label">Near Order Level</label>
                                    <input type="text" class="form-control" name="item_n_ord_lvl" data-validate="required,number" placeholder="Required Numeric Field" />
                                </div>	
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="field-6" class="control-label">Location</label>
                                    <input type="text" class="form-control" name="item_loc" data-validate="required" placeholder="Required Field" />
                                </div>	
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group no-margin">
                                    <label for="field-7" class="control-label">Remark</label>
                                    <textarea name="item_remark" class="form-control autogrow" id="field-7" placeholder="Item Remark"></textarea>
                                </div>	
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--Add footer-->
            <?php require_once MOD_ADMIN_DOC . 'views/_templates/sub_footer.php'; ?>
            <!--############-->
        </div>
    </div>
    <script type="text/javascript">
                                        function getSubCat(e)
                                        {
                                            try {
                                                var param = "cat=" + e.value;
                                                ajaxRequest('<?php echo MOD_ADMIN_URL ?>setting/jsonGetSubCatByCat', param, function(jsonData) {
                                                    var option = '<option value="">-Select-</option>';
                                                    if (jsonData) {
                                                        if (jsonData.success == true) {
                                                            for (var i in jsonData.data) {
                                                                option = option + "<option value='" + jsonData.data[i]['ITEM_SUB_CAT_ID'] + "'>" + jsonData.data[i]['ITEM_SUB_CAT_NAME'] + "</option>";
                                                            }
                                                            document.getElementById('sub_category').innerHTML = option;
                                                        } else {
                                                            errorModal(jsonData.error);
                                                            return false;
                                                        }
                                                    }
                                                });
                                            } catch (err) {
                                                alert(err.message);
                                                return false;
                                            }
                                        }
                                        function submitFrom(form) {
                                            try {
                                                ajaxRequest(form.action, jQuery('#' + form.id).serialize(), function(jsonData) {
                                                    if (jsonData) {
                                                        if (jsonData.success == true) {
                                                            jQuery(location).attr('href', '<?php echo MOD_ADMIN_URL ?>item');
                                                        } else {
                                                            errorModal(jsonData.error);
                                                            return false;
                                                        }
                                                    }
                                                });
                                            } catch (err) {
                                                alert(err.message);
                                                return false;
                                            }
                                        }
    </script>
    <link rel="stylesheet" href="<?php echo JS_PATH ?>select2/select2-bootstrap.css">
    <link rel="stylesheet" href="<?php echo JS_PATH ?>select2/select2.css">
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