<?php
/**
 * MCCodes Version 2.0.5b
 * Copyright (C) 2005-2012 Dabomstew
 * All rights reserved.
 *
 * Redistribution of this code in any form is prohibited, except in
 * the specific cases set out in the MCCodes Customer License.
 *
 * This code license may be used to run one (1) game.
 * A game is defined as the set of users and other game database data,
 * so you are permitted to create alternative clients for your game.
 *
 * If you did not obtain this code from MCCodes.com, you are in all likelihood
 * using it illegally. Please contact MCCodes to discuss licensing options
 * in this case.
 *
 * File: willpotion.php
 * Signature: 360700a3db81f331ff1db557fd9b3e49
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('globals.php');
print
        <<<EOF
<h3>Will Potions</h3>

Buy will potions today! They restore 100% will.<br />
<b>Buy One:</b> (\$1)<br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="{$set['paypal']}" />
<input type="hidden" name="item_name" value="{$domain}|WP|1|{$userid}" />
<input type="hidden" name="amount" value="1.00" />
<input type="hidden" name="no_shipping" value="1" />
<input type="hidden" name="return"
	value="http://{$domain}/willpdone.php?action=done" />
<input type="hidden" name="cancel_return"
	value="http://{$domain}/willpdone.php?action=cancel" />
<input type="hidden" name="notify_url"
	value="http://{$domain}/ipn_wp.php" />
<input type="hidden" name="cn" value="Your Player ID" />
<input type="hidden" name="currency_code" value="USD" />
<input type="hidden" name="tax" value="0" />
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif"
	border="0" name="submit"
	alt="Make payments with PayPal - it's fast, free and secure!" />
</form>
<b>Buy Five:</b> (\$4.50)<br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="{$set['paypal']}" />
<input type="hidden" name="item_name" value="{$domain}|WP|5|{$userid}" />
<input type="hidden" name="amount" value="4.50" />
<input type="hidden" name="no_shipping" value="1" />
<input type="hidden" name="return"
	value="http://{$domain}/willpdone.php?action=done" />
<input type="hidden" name="cancel_return"
	value="http://{$domain}/willpdone.php?action=cancel" />
<input type="hidden" name="notify_url"
	value="http://{$domain}/ipn_wp.php" />
<input type="hidden" name="cn" value="Your Player ID" />
<input type="hidden" name="currency_code" value="USD" />
<input type="hidden" name="tax" value="0" />
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif"
	border="0" name="submit"
	alt="Make payments with PayPal - it's fast, free and secure!" />
</form>
EOF;
$h->endpage();
