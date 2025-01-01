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
 * File: global_func.php
 * Signature: 6db71cd2fad46dab5005b26743f48811
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

/**
 * Return the difference between the current time and a given time, formatted in appropriate units so the number is not too big or small.
 * @param int $time_stamp The timestamp to find the difference to.
 * @return string The difference formatted in units so that the numerical component is not less than 1 or absurdly large.
 */
function DateTime_Parse($time_stamp)
{
    $time_difference = ($_SERVER['REQUEST_TIME'] - $time_stamp);
    $unit =
            array('second', 'minute', 'hour', 'day', 'week', 'month', 'year');
    $lengths = array(60, 60, 24, 7, 4.35, 12);
    for ($i = 0; $time_difference >= $lengths[$i]; $i++)
    {
        $time_difference = $time_difference / $lengths[$i];
    }
    $time_difference = round($time_difference);
    $date =
            $time_difference . ' ' . $unit[$i]
                    . (($time_difference > 1 OR $time_difference < 1) ? 's'
                            : '') . ' ago';
    return $date;
}

/**
 * Format money in the way humans expect to read it.
 * @param int $muny The amount of money to display
 * @param string $symb The money unit symbol to use, e.g. $
 */
function money_formatter($muny, $symb = '$')
{
    return $symb . number_format($muny);
}

/**
 * Constructs a drop-down listbox of all the item types in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the item type which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first item type alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function itemtype_dropdown($connection, $ddname = "item_type", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `itmtypeid`, `itmtypename`
    				 FROM `itemtypes`
    				 ORDER BY `itmtypename` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['itmtypeid']}'";
        if ($selected == $r['itmtypeid'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['itmtypename']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the items in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the item which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first item alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function item_dropdown($connection, $ddname = "item", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `itmid`, `itmname`
    				 FROM `items`
    				 ORDER BY `itmname` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['itmid']}'";
        if ($selected == $r['itmid'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['itmname']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the items in the game to let the user select one, including a "None" option.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the item which should be selected by default.<br />
 * Not specifying this or setting it to a number less than 1 makes "None" selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function item2_dropdown($connection, $ddname = "item", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `itmid`, `itmname`
    				 FROM `items`
    				 ORDER BY `itmname` ASC");
    if ($selected < 1)
    {
        $ret .= "<option value='0' selected='selected'>-- None --</option>";
    }
    else
    {
        $ret .= "<option value='0'>-- None --</option>";
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['itmid']}'";
        if ($selected == $r['itmid'])
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['itmname']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the locations in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the location which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first item alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function location_dropdown($connection, $ddname = "location", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `cityid`, `cityname`
    				 FROM `cities`
    				 ORDER BY `cityname` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['cityid']}'";
        if ($selected == $r['cityid'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['cityname']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the shops in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the shop which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first shop alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function shop_dropdown($connection, $ddname = "shop", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `shopID`, `shopNAME`
    				 FROM `shops`
    				 ORDER BY `shopNAME` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['shopID']}'";
        if ($selected == $r['shopID'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['shopNAME']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the registered users in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the user who should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first user alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function user_dropdown($connection, $ddname = "user", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `userid`, `username`
    				 FROM `users`
    				 ORDER BY `username` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['userid']}'";
        if ($selected == $r['userid'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['username']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the challenge bot NPC users in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the bot who should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first bot alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function challengebot_dropdown($connection, $ddname = "bot", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `u`.`userid`, `u`.`username`
                     FROM `challengebots` AS `cb`
                     INNER JOIN `users` AS `u`
                     ON `cb`.`cb_npcid` = `u`.`userid`
                     ORDER BY `u`.`username` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['userid']}'";
        if ($selected == $r['userid'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['username']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the users in federal jail in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the user who should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first user alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function fed_user_dropdown($connection, $ddname = "user", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `userid`, `username`
                     FROM `users`
                     WHERE `fedjail` = 1
                     ORDER BY `username` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['userid']}'";
        if ($selected == $r['userid'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['username']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the mail banned users in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the user who should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first user alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function mailb_user_dropdown($connection, $ddname = "user", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `userid`, `username`
                     FROM `users`
                     WHERE `mailban` > 0
                     ORDER BY `username` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['userid']}'";
        if ($selected == $r['userid'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['username']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the forum banned users in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the user who should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first user alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function forumb_user_dropdown($connection, $ddname = "user", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `userid`, `username`
                     FROM `users`
                     WHERE `forumban` > 0
                     ORDER BY `username` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['userid']}'";
        if ($selected == $r['userid'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['username']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the jobs in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the job which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first job alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function job_dropdown($connection, $ddname = "job", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `jID`, `jNAME`
    				 FROM `jobs`
    				 ORDER BY `jNAME` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['jID']}'";
        if ($selected == $r['jID'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['jNAME']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the job ranks in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the job rank which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first job's first job rank alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function jobrank_dropdown($connection, $ddname = "jobrank", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `jrID`, `jNAME`, `jrNAME`
                     FROM `jobranks` AS `jr`
                     INNER JOIN `jobs` AS `j`
                     ON `jr`.`jrJOB` = `j`.`jID`
                     ORDER BY `j`.`jNAME` ASC, `jr`.`jrNAME` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['jrID']}'";
        if ($selected == $r['jrID'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['jNAME']} - {$r['jrNAME']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the houses in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the house which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first house alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function house_dropdown($connection, $ddname = "house", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `hID`, `hNAME`
    				 FROM houses
    				 ORDER BY `hNAME` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['hID']}'";
        if ($selected == $r['hID'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['hNAME']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the houses in the game to let the user select one.<br />
 * However, the values in the list box return the house's maximum will value instead of its ID.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the house which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first house alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function house2_dropdown($connection, $ddname = "house", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `hWILL`, `hNAME`
    				 FROM houses
    				 ORDER BY `hNAME` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['hWILL']}'";
        if ($selected == $r['hWILL'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['hNAME']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the courses in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the course which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first course alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function course_dropdown($connection, $ddname = "course", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `crID`, `crNAME`
    				 FROM `courses`
    				 ORDER BY `crNAME` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['crID']}'";
        if ($selected == $r['crID'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['crNAME']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the crimes in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the crime which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first crime alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function crime_dropdown($connection, $ddname = "crime", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `crimeID`, `crimeNAME`
    				 FROM `crimes`
    				 ORDER BY `crimeNAME` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['crimeID']}'";
        if ($selected == $r['crimeID'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['crimeNAME']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the crime groups in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the crime group which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first crime group alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function crimegroup_dropdown($connection, $ddname = "crimegroup",
        $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `cgID`, `cgNAME`
    				 FROM `crimegroups`
    				 ORDER BY `cgNAME` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['cgID']}'";
        if ($selected == $r['cgID'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['cgNAME']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Sends a user an event, given their ID and the text.
 * @param int $userid The user ID to be sent the event
 * @param string $text The event's text. This should be fully sanitized for HTML, but not pre-escaped for database insertion.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @return int 1
 */
function event_add($userid, $text, $connection = 0)
{
    global $db;
    $text = $db->escape($text);
    $db->query(
            "INSERT INTO `events`
             VALUES(NULL, $userid, " . time() . ", 0, '$text')");
    $db->query(
            "UPDATE `users`
             SET `new_events` = `new_events` + 1
             WHERE `userid` = {$userid}");
    return 1;
}

/**
 * Internal function: used to see if a user is due to level up, and if so, perform that levelup.
 */
function check_level()
{
    global $db;
    global $ir, $c, $userid;
    $ir['exp_needed'] =
            (int) (($ir['level'] + 1) * ($ir['level'] + 1)
                    * ($ir['level'] + 1) * 2.2);
    if ($ir['exp'] >= $ir['exp_needed'])
    {
        $expu = $ir['exp'] - $ir['exp_needed'];
        $ir['level'] += 1;
        $ir['exp'] = $expu;
        $ir['energy'] += 2;
        $ir['brave'] += 2;
        $ir['maxenergy'] += 2;
        $ir['maxbrave'] += 2;
        $ir['hp'] += 50;
        $ir['maxhp'] += 50;
        $ir['exp_needed'] =
                (int) (($ir['level'] + 1) * ($ir['level'] + 1)
                        * ($ir['level'] + 1) * 2.2);
        $db->query(
                "UPDATE `users`
                 SET `level` = `level` + 1, exp = {$expu},
                 `energy` = `energy` + 2, `brave` = `brave` + 2,
                 `maxenergy` = `maxenergy` + 2, `maxbrave` = `maxbrave` + 2,
                 `hp` = `hp` + 50, `maxhp` = `maxhp` + 50
                 WHERE `userid` = {$userid}");
    }
}

/**
 * Get the "rank" a user has for a particular stat - if the return is n, then the user has the n'th highest value for that stat.
 * @param int $stat The value of the current user's stat.
 * @param string $mykey The stat to be ranked in. Must be a valid column name in the userstats table
 * @return integer The user's rank in the stat
 */
function get_rank($stat, $mykey)
{
    global $db;
    global $ir, $userid, $c;
    $q =
            $db->query(
                    "SELECT count(`u`.`userid`)
                    FROM `userstats` AS `us`
                    LEFT JOIN `users` AS `u`
                    ON `us`.`userid` = `u`.`userid`
                    WHERE {$mykey} > {$stat}
                    AND `us`.`userid` != {$userid} AND `u`.`user_level` != 0");
    $result = $db->fetch_single($q) + 1;
    $db->free_result($q);
    return $result;
}

/**
 * Give a particular user a particular quantity of some item.
 * @param int $user The user ID who is to be given the item
 * @param int $itemid The item ID which is to be given
 * @param int $qty The item quantity to be given
 * @param int $notid [optional] If specified and greater than zero, prevents the item given's<br />
 * database entry combining with inventory id $notid.
 */
function item_add($user, $itemid, $qty, $notid = 0)
{
    global $db;
    if ($notid > 0)
    {
        $q =
                $db->query(
                        "SELECT `inv_id`
                         FROM `inventory`
                         WHERE `inv_userid` = {$user}
                         AND `inv_itemid` = {$itemid}
                         AND `inv_id` != {$notid}
                         LIMIT 1");
    }
    else
    {
        $q =
                $db->query(
                        "SELECT `inv_id`
                         FROM `inventory`
                         WHERE `inv_userid` = {$user}
                         AND `inv_itemid` = {$itemid}
                         LIMIT 1");
    }
    if ($db->num_rows($q) > 0)
    {
        $r = $db->fetch_row($q);
        $db->query(
                "UPDATE `inventory`
                SET `inv_qty` = `inv_qty` + {$qty}
                WHERE `inv_id` = {$r['inv_id']}");
    }
    else
    {
        $db->query(
                "INSERT INTO `inventory`
                 (`inv_itemid`, `inv_userid`, `inv_qty`)
                 VALUES ({$itemid}, {$user}, {$qty})");
    }
    $db->free_result($q);
}

/**
 * Take away from a particular user a particular quantity of some item.<br />
 * If they don't have enough of that item to be taken, takes away any that they do have.
 * @param int $user The user ID who is to lose the item
 * @param int $itemid The item ID which is to be taken
 * @param int $qty The item quantity to be taken
 */
function item_remove($user, $itemid, $qty)
{
    global $db;
    $q =
            $db->query(
                    "SELECT `inv_id`, `inv_qty`
                     FROM `inventory`
                     WHERE `inv_userid` = {$user}
                     AND `inv_itemid` = {$itemid}
                     LIMIT 1");
    if ($db->num_rows($q) > 0)
    {
        $r = $db->fetch_row($q);
        if ($r['inv_qty'] > $qty)
        {
            $db->query(
                    "UPDATE `inventory`
                     SET `inv_qty` = `inv_qty` - {$qty}
                     WHERE `inv_id` = {$r['inv_id']}");
        }
        else
        {
            $db->query(
                    "DELETE FROM `inventory`
            		 WHERE `inv_id` = {$r['inv_id']}");
        }
    }
    $db->free_result($q);
}

/**
 * Constructs a drop-down listbox of all the forums in the game to let the user select one.
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the forum which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first forum alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function forum_dropdown($connection, $ddname = "forum", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `ff_id`, `ff_name`
    				 FROM `forum_forums`
    				 ORDER BY `ff_name` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['ff_id']}'";
        if ($selected == $r['ff_id'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['ff_name']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Constructs a drop-down listbox of all the forums in the game, except gang forums, to let the user select one.<br />
 * @param mysql $connection Redundant (legacy from v1) - use NULL
 * @param string $ddname The "name" attribute the &lt;select&gt; attribute should have
 * @param int $selected [optional] The <i>ID number</i> of the forum which should be selected by default.<br />
 * Not specifying this or setting it to -1 makes the first forum alphabetically be selected.
 * @return string The HTML code for the listbox, to be inserted in a form.
 */
function forum2_dropdown($connection, $ddname = "forum", $selected = -1)
{
    global $db;
    $ret = "<select name='$ddname' type='dropdown'>";
    $q =
            $db->query(
                    "SELECT `ff_id`, `ff_name`
                     FROM `forum_forums`
                     WHERE `ff_auth` != 'gang'
                     ORDER BY `ff_name` ASC");
    if ($selected == -1)
    {
        $first = 0;
    }
    else
    {
        $first = 1;
    }
    while ($r = $db->fetch_row($q))
    {
        $ret .= "\n<option value='{$r['ff_id']}'";
        if ($selected == $r['ff_id'] || $first == 0)
        {
            $ret .= " selected='selected'";
            $first = 1;
        }
        $ret .= ">{$r['ff_name']}</option>";
    }
    $db->free_result($q);
    $ret .= "\n</select>";
    return $ret;
}

/**
 * Attempt to parse the given string as an arbritrary-length integer, returning the result.
 * @param string $str The input string
 * @param int $positive Whether the resulting number must be positive or not.
 * @param string The resulting integer as a string, or "0" if the input string was not able to be parsed as an integer.
 */
function make_bigint($str, $positive = 1)
{
    $str = (string) $str;
    $ret = "";
    for ($i = 0; $i < strlen($str); $i++)
    {
        if ((ord($str[$i]) > 47 && ord($str[$i]) < 58)
                or ($str[$i] == "-" && $positive == 0))
        {
            $ret .= $str[$i];
        }
    }
    if (strlen($ret) == 0)
    {
        return "0";
    }
    return $ret;
}

/**
 * Records an action by a member of staff in the central staff log.
 * @param string $text The log's text. This should be fully sanitized for HTML, but not pre-escaped for database insertion.
 */
function stafflog_add($text)
{
    global $db, $ir;
    $IP = $db->escape($_SERVER['REMOTE_ADDR']);
    $text = $db->escape($text);
    $db->query(
            "INSERT INTO `stafflog`
             VALUES(NULL, {$ir['userid']}, " . time() . ", '$text', '$IP')");
}

/**
 * Request that an anti-CSRF verification code be issued for a particular form in the game.
 * @param string $formid A unique string used to identify this form to match up its submission with the right token.
 * @return string The code issued to be added to the form.
 */
function request_csrf_code($formid)
{
    // Generate the token
    $token = md5(mt_rand());
    // Insert/Update it
    $issue_time = time();
    $_SESSION["csrf_{$formid}"] =
            array('token' => $token, 'issued' => $issue_time);
    return $token;
}

/**
 * Request that an anti-CSRF verification code be issued for a particular form in the game, and return the HTML to be placed in the form.
 * @param string $formid A unique string used to identify this form to match up its submission with the right token.
 * @return string The HTML for the code issued to be added to the form.
 */
function request_csrf_html($formid)
{
    return "<input type='hidden' name='verf' value='"
            . request_csrf_code($formid) . "' />";
}

/**
 * Check the CSRF code we received against the one that was registered for the form - return false if the request shouldn't be processed...
 * @param string $formid A unique string used to identify this form to match up its submission with the right token.
 * @param string $code The code the user's form input returned.
 * @return boolean Whether the user provided a valid code or not
 */
function verify_csrf_code($formid, $code)
{
    // Lookup the token entry
    // Is there a token in existence?
    if (!isset($_SESSION["csrf_{$formid}"])
            || !is_array($_SESSION["csrf_{$formid}"]))
    {
        // Obviously verification fails
        return false;
    }
    else
    {
        // From here on out we always want to remove the token when we're done - so don't return immediately
        $verified = false;
        $token = $_SESSION["csrf_{$formid}"];
        // Expiry time on a form?
        $expiry = 900; // hacky lol
        if ($token['issued'] + $expiry > time())
        {
            // It's ok, check the contents
            $verified = ($token['token'] === $code);
        } // don't need an else case - verified = false
        // Remove the token before finishing
        unset($_SESSION["csrf_{$formid}"]);
        return $verified;
    }
}

/**
 * Given a password input given by the user and their actual details,
 * determine whether the password entered was correct.
 *
 * Note that password-salt systems don't require the extra md5() on the $input.
 * This is only here to ensure backwards compatibility - that is,
 * a v2 game can be upgraded to use the password salt system without having
 * previously used it, without resetting every user's password.
 *
 * @param string $input The input password given by the user.
 * 						Should be without slashes.
 * @param string $salt 	The user's unique pass salt
 * @param string $pass	The user's encrypted password
 *
 * @return boolean	true for equal, false for not (login failed etc)
 *
 */
function verify_user_password($input, $salt, $pass)
{
    return ($pass === encode_password($input, $salt));
}

/**
 * Given a password and a salt, encode them to the form which is stored in
 * the game's database.
 *
 * @param string $password 		The password to be encoded
 * @param string $salt			The user's unique pass salt
 * @param boolean $already_md5	Whether the specified password is already
 * 								a md5 hash. This would be true for legacy
 * 								v2 passwords.
 *
 * @return string	The resulting encoded password.
 */
function encode_password($password, $salt, $already_md5 = false)
{
    if (!$already_md5)
    {
        $password = md5($password);
    }
    return md5($salt . $password);
}

/**
 * Generate a salt to use to secure a user's password
 * from rainbow table attacks.
 *
 * @return string	The generated salt, 8 alphanumeric characters
 */
function generate_pass_salt()
{
    return substr(md5(microtime(true)), 0, 8);
}

/**
 *
 * @return string The URL of the game.
 */
function determine_game_urlbase()
{
    $domain = $_SERVER['HTTP_HOST'];
    $turi = $_SERVER['REQUEST_URI'];
    $turiq = '';
    for ($t = strlen($turi) - 1; $t >= 0; $t--)
    {
        if ($turi[$t] != '/')
        {
            $turiq = $turi[$t] . $turiq;
        }
        else
        {
            break;
        }
    }
    $turiq = '/' . $turiq;
    if ($turiq == '/')
    {
        $domain .= substr($turi, 0, -1);
    }
    else
    {
        $domain .= str_replace($turiq, '', $turi);
    }
    return $domain;
}

/**
 * Check to see if this request was made via XMLHttpRequest.
 * Uses variables supported by most JS frameworks.
 *
 * @return boolean Whether the request was made via AJAX or not.
 **/

function is_ajax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && is_string($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])
                    === 'xmlhttprequest';
}

/**
 * Get the file size in bytes of a remote file, if we can.
 *
 * @param string $url	The url to the file
 *
 * @return int			The file's size in bytes, or 0 if we could
 * 						not determine its size.
 */

function get_filesize_remote($url)
{
    // Retrieve headers
    if (strlen($url) < 8)
    {
        return 0; // no file
    }
    $is_ssl = false;
    if (substr($url, 0, 7) == 'http://')
    {
        $port = 80;
    }
    else if (substr($url, 0, 8) == 'https://' && extension_loaded('openssl'))
    {
        $port = 443;
        $is_ssl = true;
    }
    else
    {
        return 0; // bad protocol
    }
    // Break up url
    $url_parts = explode('/', $url);
    $host = $url_parts[2];
    unset($url_parts[2]);
    unset($url_parts[1]);
    unset($url_parts[0]);
    $path = '/' . implode('/', $url_parts);
    if (strpos($host, ':') !== false)
    {
        $host_parts = explode(':', $host);
        if (count($host_parts) == 2 && ctype_digit($host_parts[1]))
        {
            $port = (int) $host_parts[1];
            $host = $host_parts[0];
        }
        else
        {
            return 0; // malformed host
        }
    }
    $request =
            "HEAD {$path} HTTP/1.1\r\n" . "Host: {$host}\r\n"
                    . "Connection: Close\r\n\r\n";
    $fh = fsockopen(($is_ssl ? 'ssl://' : '') . $host, $port);
    if ($fh === false)
    {
        return 0;
    }
    fwrite($fh, $request);
    $headers = array();
    $total_loaded = 0;
    while (!feof($fh) && $line = fgets($fh, 1024))
    {
        if ($line == "\r\n")
        {
            break;
        }
        if (strpos($line, ':') !== false)
        {
            list($key, $val) = explode(':', $line, 2);
            $headers[strtolower($key)] = trim($val);
        }
        else
        {
            $headers[] = strtolower($line);
        }
        $total_loaded += strlen($line);
        if ($total_loaded > 50000)
        {
            // Stop loading garbage!
            break;
        }
    }
    fclose($fh);
    if (!isset($headers['content-length']))
    {
        return 0;
    }
    return (int) $headers['content-length'];
}
