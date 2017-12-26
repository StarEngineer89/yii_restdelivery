<?php /* Smarty version Smarty-3.1.19, created on 2017-11-04 18:24:06
         compiled from "/home4/yummytak/public_html/magboxes.co.uk/modules/ybc_megamenu/views/templates/hook/menu_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2481525259fe05c6cfc648-60101164%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a99628fda46e8cda104cb481f4f2a2893c41a66' => 
    array (
      0 => '/home4/yummytak/public_html/magboxes.co.uk/modules/ybc_megamenu/views/templates/hook/menu_list.tpl',
      1 => 1497861880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2481525259fe05c6cfc648-60101164',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'menus' => 0,
    'menu' => 0,
    'active_id_menu' => 0,
    'admin_path' => 0,
    'column' => 0,
    'active_id_column' => 0,
    'block' => 0,
    'active_id_block' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_59fe05c6d7b929_36458427',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59fe05c6d7b929_36458427')) {function content_59fe05c6d7b929_36458427($_smarty_tpl) {?>

<div class="panel col-lg-12">
    <div class="panel-heading">
        <i class="icon-list-ul"></i> <?php echo smartyTranslate(array('s'=>'Menu structure','mod'=>'ybc_megamenu'),$_smarty_tpl);?>

        <span class="panel-heading-action">            
            <a class="list-toolbar-btn" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminModules');?>
&configure=ybc_megamenu&add_new_menu=true&control=menu">
    			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="<?php echo smartyTranslate(array('s'=>'Add new menu','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
" data-html="true">
    				<i style="color: #f0227e;" class="process-icon-new "></i>
    			</span>
    		</a>
        </span>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['menus']->value) {?>
	<div class="table-responsive clearfix ybc-mm-menu-tree">
		<ol class="sortable ui-sortable ybc-mm-ol-lv1">  
    			<?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menus']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value) {
$_smarty_tpl->tpl_vars['menu']->_loop = true;
?>
    				<li class="ybc-menu-item" rel="<?php echo $_smarty_tpl->tpl_vars['menu']->value['id_menu'];?>
" id="menu_<?php echo $_smarty_tpl->tpl_vars['menu']->value['id_menu'];?>
">	
                            <!-- level 1 -->
                        	<div class="ybc-mm-level1 ybc-mm-item">			
        						<div class="ybc-mm-level1-heading ybc-mm-heading <?php if ($_smarty_tpl->tpl_vars['active_id_menu']->value==$_smarty_tpl->tpl_vars['menu']->value['id_menu']) {?>ybc-mm-active<?php }?>" style="text-transform: uppercase; padding: 5px 0;"><i  title="<?php echo smartyTranslate(array('s'=>'Menu item','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
"  style="background: none repeat scroll 0 0 #2ba8e3;color: #fff;font-size: 12px;margin-right: 5px;padding: 3px;" class="icon-book"></i><a href="<?php echo $_smarty_tpl->tpl_vars['admin_path']->value;?>
&id_menu=<?php echo $_smarty_tpl->tpl_vars['menu']->value['id_menu'];?>
&control=menu&configure=ybc_megamenu"><?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
</a></div>
                                <div class="ybc-mm-toolbox">
                                    <a onclick="return confirm('<?php echo smartyTranslate(array('s'=>'When you delete this menu, all columns/blocks inside this menu will be deleted. Do you confirm?','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
');" style="text-decoration: none!important; margin-right: 10px;" href="<?php echo $_smarty_tpl->tpl_vars['admin_path']->value;?>
&id_menu=<?php echo $_smarty_tpl->tpl_vars['menu']->value['id_menu'];?>
&control=menu&configure=ybc_megamenu&delmenu=true">
                                        <span  class="label-tooltip" data-toggle="tooltip" data-html="true" data-original-title="<?php echo smartyTranslate(array('s'=>'Delete this menu','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
">
                                            <i style="font-size: 14px; color: #2ba8e3; display: inline; " class="icon-trash"></i>
                                        </span>
                                    </a>
                                    <a  style="text-decoration: none!important;"  href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminModules');?>
&add_new_column=true&id_menu=<?php echo $_smarty_tpl->tpl_vars['menu']->value['id_menu'];?>
&control=column&configure=ybc_megamenu" class="list-toolbar-btn">
                            			<span data-html="true" data-original-title="<?php echo smartyTranslate(array('s'=>'Add new column to this menu','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
" class="label-tooltip" data-toggle="tooltip" title="">
                            				<i class="process-icon-new " style="color: #2ba8e3; font-size: 14px; display: inline;"></i>
                            			</span>
                            		</a>    
                                </div>
                            </div>
                            <!-- /leve 1 -->
                            <!-- Columns -->
                            <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['columns'])&&$_smarty_tpl->tpl_vars['menu']->value['columns']) {?>
                                <ol class="ybc-mm-ol-lv2 sortable">
                                    <?php  $_smarty_tpl->tpl_vars['column'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['column']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu']->value['columns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['column']->key => $_smarty_tpl->tpl_vars['column']->value) {
$_smarty_tpl->tpl_vars['column']->_loop = true;
?>
                        				<li class="ybc-column-item" rel="<?php echo $_smarty_tpl->tpl_vars['column']->value['id_column'];?>
" id="column_<?php echo $_smarty_tpl->tpl_vars['column']->value['id_column'];?>
" >
                                            <!-- level 2 -->
                                            <div class="ybc-level2 ybc-mm-item">					
                        						<div class="ybc-mm-level2-heading ybc-mm-heading <?php if ($_smarty_tpl->tpl_vars['active_id_column']->value==$_smarty_tpl->tpl_vars['column']->value['id_column']) {?>ybc-mm-active<?php }?>" style="padding: 5px 0;"><i  title="<?php echo smartyTranslate(array('s'=>'Column item','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
" style="background: none repeat scroll 0 0 #e27c79;color: #fff;font-size: 12px;margin-right: 5px;padding: 3px;" class="icon-sitemap"></i><a href="<?php echo $_smarty_tpl->tpl_vars['admin_path']->value;?>
&id_column=<?php echo $_smarty_tpl->tpl_vars['column']->value['id_column'];?>
&control=column&configure=ybc_megamenu" style="color: #e27c79;"><?php echo $_smarty_tpl->tpl_vars['column']->value['title'];?>
</a></div>
                                                <div class="ybc-mm-toolbox">
                                                    <a onclick="return confirm('<?php echo smartyTranslate(array('s'=>'When you delete this column, all blocks inside this column will be deleted. Do you confirm?','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
');" style="text-decoration: none!important; margin-right: 10px;" href="<?php echo $_smarty_tpl->tpl_vars['admin_path']->value;?>
&id_column=<?php echo $_smarty_tpl->tpl_vars['column']->value['id_column'];?>
&control=column&configure=ybc_megamenu&delcolumn=true">
                                                        <span  class="label-tooltip" data-toggle="tooltip" data-html="true" data-original-title="<?php echo smartyTranslate(array('s'=>'Delete this column','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
">
                                                            <i style="font-size: 14px; color: #e27c79; display: inline;" class="icon-trash"></i>
                                                        </span>
                                                    </a>
                                                    <a  style="text-decoration: none!important;"  href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminModules');?>
&add_new_column=true&id_column=<?php echo $_smarty_tpl->tpl_vars['column']->value['id_column'];?>
&control=block&configure=ybc_megamenu" class="list-toolbar-btn">
                                            			<span data-html="true" data-original-title="<?php echo smartyTranslate(array('s'=>'Add new block to this column','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
" class="label-tooltip" data-toggle="tooltip" title="">
                                            				<i class="process-icon-new " style="color: #e27c79; font-size: 14px; display: inline;"></i>
                                            			</span>
                                            		</a>    
                                                </div>
                                            </div>
                                            <!-- /level 2 -->	
                                            <!-- Blocks -->
                                            <?php if (isset($_smarty_tpl->tpl_vars['column']->value['blocks'])&&$_smarty_tpl->tpl_vars['column']->value['blocks']) {?>
                                                <ol class="ybc-mm-ol-lv3 sortable">
                                                    <?php  $_smarty_tpl->tpl_vars['block'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['block']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['column']->value['blocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['block']->key => $_smarty_tpl->tpl_vars['block']->value) {
$_smarty_tpl->tpl_vars['block']->_loop = true;
?>
                                        				<li class="ybc-block-item" rel="<?php echo $_smarty_tpl->tpl_vars['block']->value['id_block'];?>
" id="block_<?php echo $_smarty_tpl->tpl_vars['block']->value['id_block'];?>
" >
                                                            <!-- Level 3 -->
                                                                <div class="ybc-level3 ybc-mm-item">					
                                            						<div class="ybc-mm-level3-heading ybc-mm-heading <?php if ($_smarty_tpl->tpl_vars['active_id_block']->value==$_smarty_tpl->tpl_vars['block']->value['id_block']) {?>ybc-mm-active<?php }?>" style="padding: 5px 0;"><i title="<?php echo smartyTranslate(array('s'=>'Block item','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
" style="background: none repeat scroll 0 0 #9e5ba1;color: #fff;font-size: 12px;margin-right: 5px;padding: 2px;" class="icon-calendar-empty"></i><a style="color: #9e5ba1;" href="<?php echo $_smarty_tpl->tpl_vars['admin_path']->value;?>
&id_block=<?php echo $_smarty_tpl->tpl_vars['block']->value['id_block'];?>
&control=block&configure=ybc_megamenu"><?php echo $_smarty_tpl->tpl_vars['block']->value['title'];?>
</a></div>
                                                                    <div class="ybc-mm-toolbox">
                                                                        <a onclick="return confirm('<?php echo smartyTranslate(array('s'=>'This block will be deleted. Do you confirm?','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
');" style="text-decoration: none!important;" href="<?php echo $_smarty_tpl->tpl_vars['admin_path']->value;?>
&id_block=<?php echo $_smarty_tpl->tpl_vars['block']->value['id_block'];?>
&control=block&configure=ybc_megamenu&delblock=true">
                                                                            <span  class="label-tooltip" data-toggle="tooltip" data-html="true" data-original-title="<?php echo smartyTranslate(array('s'=>'Delete this block','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
">
                                                                                <i style="font-size: 14px; color: #9e5ba1; display: inline;" class="icon-trash"></i>
                                                                            </span>
                                                                        </a>                                                
                                                                    </div>
                                                                </div>	
                                                            <!-- /Level 3 -->	
                                        				</li>
                                        			<?php } ?>
                                                </ol>
                                            <?php }?>
                                            <!-- /Blocks -->	
                        				</li>                                        
                        			<?php } ?>
                                </ol>
                            <?php }?>
                            <!-- /Columns  -->		
    				</li>                    
    			<?php } ?>
		</ol>
	</div>
    <?php } else { ?>
        <p class="alert alert-warning row-margin-top"><?php echo smartyTranslate(array('s'=>'Please add new menus. You have no menus at the moment','mod'=>'ybc_megamenu'),$_smarty_tpl);?>
</p>
    <?php }?>
</div><?php }} ?>
