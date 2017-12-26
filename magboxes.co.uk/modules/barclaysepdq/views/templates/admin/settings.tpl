{**
 * Accept payment by Barclays ePDQ Payment Gateway
 * 
 * Barclays ePDQ Payment Gateway by Kahanit(http://www.kahanit.com) is licensed under a
 * Creative Creative Commons Attribution-NoDerivatives 4.0 International License.
 * Based on a work at http://www.kahanit.com.
 * Permissions beyond the scope of this license may be available at http://www.kahanit.com.
 * To view a copy of this license, visit http://creativecommons.org/licenses/by-nd/4.0/.
 * 
 * @author    Amit Sidhpura <amit@kahanit.com>
 * @copyright 2015 Kahanit
 * @license   http://creativecommons.org/licenses/by-nd/4.0/
 *}

<div class="row">
    <div class="col-md-12">
        <form action="{$request_uri|escape:'UTF-8'}" method="post" class="form-horizontal">
            <div class="panel  panel-default">
                <div class="panel-heading"><i class="icon-cogs"></i> <span>{l s='Settings' mod='barclaysepdq'}</span></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="modetest" class="col-md-3 control-label">{l s='Transaction mode' mod='barclaysepdq'}</label>
                        <div class="col-md-5">
                            <div class="radio">
                                <label><input id="modetest" type="radio" name="mode" value="test"{if $mode == 'test'} checked{/if}/> Test&nbsp;&nbsp;</label>
                                <label><input id="modelive" type="radio" name="mode" value="live"{if $mode == 'live'} checked{/if}/> Live</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pspid" class="col-md-3 control-label">{l s='PSPID' mod='barclaysepdq'}</label>
                        <div class="col-md-5"><input id="pspid" type="text" name="pspid" value="{$pspid}" class="form-control"/></div>
                    </div>
                    <div class="form-group">
                        <label for="sha_in_pp" class="col-md-3 control-label">{l s='SHA-IN pass phrase' mod='barclaysepdq'}</label>
                        <div class="col-md-5"><input id="sha_in_pp" type="text" name="sha_in_pp" value="{$sha_in_pp}" class="form-control"/></div>
                    </div>
                    <div class="form-group">
                        <label for="sha_out_pp" class="col-md-3 control-label">{l s='SHA-OUT pass phrase' mod='barclaysepdq'}</label>
                        <div class="col-md-5"><input id="sha_out_pp" type="text" name="sha_out_pp" value="{$sha_out_pp}" class="form-control"/></div>
                    </div>
                    <div class="form-group">
                        <label for="hashalgo" class="col-md-3 control-label">{l s='Hash algorithm' mod='barclaysepdq'}</label>
                        <div class="col-md-5">
                            <select id="hashalgo" name="hashalgo" class="form-control">
                                <option value="sha1"{if $mode == 'sha1'} selected{/if}>SHA-1</option>
                                <option value="sha256"{if $mode == 'sha256'} selected{/if}>SHA-256</option>
                                <option value="sha512"{if $mode == 'sha512'} selected{/if}>SHA-512</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="order_prefix" class="col-md-3 control-label">{l s='Order prefix' mod='barclaysepdq'}</label>
                        <div class="col-md-5"><input id="order_prefix" type="text" name="order_prefix" value="{$order_prefix}" class="form-control"/></div>
                    </div>
                    <div class="form-group">
                        <label for="status_payment_pending" class="col-md-3 control-label">{l s='Status payment pending' mod='barclaysepdq'}</label>
                        <div class="col-md-5">{$status_payment_pending|escape:'UTF-8'}</div>
                    </div>
                    <div class="form-group">
                        <label for="status_payment_success" class="col-md-3 control-label">{l s='Status payment success' mod='barclaysepdq'}</label>
                        <div class="col-md-5">{$status_payment_success|escape:'UTF-8'}</div>
                    </div>
                    <div class="form-group">
                        <label for="status_payment_aborted" class="col-md-3 control-label">{l s='Status payment aborted' mod='barclaysepdq'}</label>
                        <div class="col-md-5">{$status_payment_aborted|escape:'UTF-8'}</div>
                    </div>
                    <div class="form-group">
                        <label for="status_payment_error" class="col-md-3 control-label">{l s='Status payment error' mod='barclaysepdq'}</label>
                        <div class="col-md-5">{$status_payment_error|escape:'UTF-8'}</div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-md-3 control-label">{l s='Title' mod='barclaysepdq'}</label>
                        <div class="col-md-5"><input id="title" type="text" name="title" value="{$title}" class="form-control"/></div>
                    </div>
                    <div class="form-group">
                        <label for="font" class="col-md-3 control-label">{l s='Font family' mod='barclaysepdq'}</label>
                        <div class="col-md-5">
                            <select id="font" name="font" class="form-control">
                                <option value="Arial, Helvetica, sans-serif"{if $font == 'Arial, Helvetica, sans-serif'} selected{/if}>Arial, Helvetica, sans-serif</option>
                                <option value="Verdana, Geneva, sans-serif"{if $font == 'Verdana, Geneva, sans-serif'} selected{/if}>Verdana, Geneva, sans-serif</option>
                                <option value="Tahoma, Geneva, sans-serif"{if $font == 'Tahoma, Geneva, sans-serif'} selected{/if}>Tahoma, Geneva, sans-serif</option>
                                <option value="'Comic Sans MS', cursive, sans-serif"{if $font == "'Comic Sans MS', cursive, sans-serif"} selected{/if}>'Comic Sans MS', cursive, sans-serif</option>
                                <option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif"{if $font == "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"} selected{/if}>'Lucida Sans Unicode', 'Lucida Grande', sans-serif</option>
                                <option value="'Trebuchet MS', Helvetica, sans-serif"{if $font == "'Trebuchet MS', Helvetica, sans-serif"} selected{/if}>'Trebuchet MS', Helvetica, sans-serif</option>
                                <option value="'Arial Black', Gadget, sans-serif"{if $font == "'Arial Black', Gadget, sans-serif"} selected{/if}>'Arial Black', Gadget, sans-serif</option>
                                <option value="Impact, Charcoal, sans-serif"{if $font == 'Impact, Charcoal, sans-serif'} selected{/if}>Impact, Charcoal, sans-serif</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txt_color" class="col-md-3 control-label">{l s='Text color' mod='barclaysepdq'}</label>
                        <div class="col-md-5">
                            <div class="input-group"><input id="txt_color" type="color" data-hex="true" class="color mColorPickerInput" name="txt_color" value="{$txt_color}"/></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bg_color" class="col-md-3 control-label">{l s='Background color' mod='barclaysepdq'}</label>
                        <div class="col-md-5">
                            <div class="input-group"><input id="bg_color" type="color" data-hex="true" class="color mColorPickerInput" name="bg_color" value="{$bg_color}"/></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="btn_txt_color" class="col-md-3 control-label">{l s='Button text color' mod='barclaysepdq'}</label>
                        <div class="col-md-5">
                            <div class="input-group"><input id="btn_txt_color" type="color" data-hex="true" class="color mColorPickerInput" name="btn_txt_color" value="{$btn_txt_color}"/></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="btn_bg_color" class="col-md-3 control-label">{l s='Button background color' mod='barclaysepdq'}</label>
                        <div class="col-md-5">
                            <div class="input-group"><input id="btn_bg_color" type="color" data-hex="true" class="color mColorPickerInput" name="btn_bg_color" value="{$btn_bg_color}"/></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tbl_txt_color" class="col-md-3 control-label">{l s='Table text color' mod='barclaysepdq'}</label>
                        <div class="col-md-5">
                            <div class="input-group"><input id="tbl_txt_color" type="color" data-hex="true" class="color mColorPickerInput" name="tbl_txt_color" value="{$tbl_txt_color}"/></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tbl_bg_color" class="col-md-3 control-label">{l s='Table background color' mod='barclaysepdq'}</label>
                        <div class="col-md-5">
                            <div class="input-group"><input id="tbl_bg_color" type="color" data-hex="true" class="color mColorPickerInput" name="tbl_bg_color" value="{$tbl_bg_color}"/></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" name="btnSubmit" value="1" class="btn btn-default pull-right">
                        <i class="process-icon-save"></i>{l s='Update settings' mod='barclaysepdq'}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
