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

/**
 * Class BarclaysEPDQHelper
 */
class BarclaysEPDQHelper
{
    public static function redirectTop($url, $base_uri = __PS_BASE_URI__, $context = null)
    {
        if ($context == null) {
            $context = Context::getContext();
        }

        if (strpos($url, 'http://') === false && strpos($url, 'https://') === false && $context->link) {
            if (strpos($url, $base_uri) === 0) {
                $url = substr($url, strlen($base_uri));
            }
            if (strpos($url, 'index.php?controller=') !== false && strpos($url, 'index.php/') == 0) {
                $url = substr($url, strlen('index.php?controller='));
                if (Configuration::get('PS_REWRITING_SETTINGS')) {
                    $url = Tools::strReplaceFirst('&', '?', $url);
                }
            }

            $explode = explode('?', $url);
            // don't use ssl if url is home page
            // used when logout for example
            $use_ssl = !empty($url);
            $url = $context->link->getPageLink($explode[0], $use_ssl);
            if (isset($explode[1])) {
                $url .= '?' . $explode[1];
            }
        }

        echo '<script>window.top.location.href = "' . $url . '";</script>';
        exit;
    }
}
