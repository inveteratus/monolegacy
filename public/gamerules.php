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
 * File: gamerules.php
 * Signature: cd1183b02c609885bf54f5cef57b1430
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

require_once('globals.php');
print
        <<<EOF
<h1>{$set['game_name']} Rules and Regulations</h1>
<ol>
<li>Players are only allowed to have one account, owning two or more accounts
 will result in all accounts being jailed, if you are on the same IP as another
 player, mail staff and let them know.</li>
<li>You are responsible for whatever happens on your account, don't give out
 your password to anyone.</li>
<li>Children play this game, so keep it PG-13. Mild swearing will be
 permitted, but F-bombing, sexual vulgarities or excessive swearing will result
 in some time in Fed until you clean up your act.</li>
<li>Profile images with nudity, profanity, or otherwise offensive images will
 be removed, and may result in jail time.</li>
<li>We understand that you play other games, but do not advertise them here.
 You get 1 warning, afterwards its Fed time.</li>
<li>Do not spam the staff's mailbox, if you have a problem, message one of us
 once. They will deal with your problem in a timely manner, but do not mail
 them repeatedly, or mail multiple staff members.</li>
<li>Do not harrass other players, use common sense on this one, if you don't
 know when your crossing the line from fantasy into harrassment, assume that
 you are harrassing the other player. This will not be tolerated and will
 result in a stiff punishment.</li>
<li>Scamming will not be tolerated in any manner. Any attempt to scam anyone
 will result in being jailed for a long long time.</li>
<li>If a member of staff is bothering you for any unfair or just plain, weird
 reason, mail an administrator.</li>
<li>Common sense rules are not posted here, if you can't determine the
 difference between what is ok, and what is not, you should consider not
 interacting with other people until you do understand.</li>
<li>These rules are subject to change without notice, check them from time
 to time, as ignorance will not be accepted as an excuse.</li>
</ol>
EOF;
$h->endpage();
