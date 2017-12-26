<?php
/**
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
 */

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');

if (Tools::substr(Tools::encrypt('barclaysepdq/return'), 0, 10) != Tools::getValue('Merchant_Param')
	|| !Module::isInstalled('barclaysepdq'))
	die('Bad token'); ?>

<form action='<?php echo Context::getContext()->link->getModuleLink('barclaysepdq', 'confirm') ?>' method='post' name='return'>
	<?php
	foreach (array_keys($_POST) as $key)
		echo "<input type='hidden' name='".$key."' value='".Tools::getValue($key)."'>";
	?>
</form>
<script language="JavaScript">
	document.return.submit();
</script>