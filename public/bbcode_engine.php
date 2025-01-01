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
 * File: bbcode_engine.php
 * Signature: d34c12616ac9beca032b0eb80ba92a98
 * Date: Fri, 20 Apr 12 08:50:30 +0000
 */

class bbcode_engine
{
    var $parsings = array();
    var $htmls = array();

    function simple_bbcode_tag($tag = "")
    {

        if (!$tag)
        {
            break;
        }
        $this->parsings[] = "/\[" . $tag . "\](.+?)\[\/" . $tag . "\]/";
        $this->htmls[] = "<" . $tag . ">\\1</" . $tag . ">";
    }

    function adv_bbcode_tag($tag = "", $reptag = "")
    {

        if (!$tag)
        {
            break;
        }

        $this->parsings[] = "/\[" . $tag . "\](.+?)\[\/" . $tag . "\]/";
        $this->htmls[] = "<" . $reptag . ">\\1</" . $reptag . ">";
    }

    function simple_option_tag($tag = "", $optionval = "")
    {

        if ($tag == "" || $optionval == "")
        {
            break;
        }
        $this->parsings[] =
                "/\[" . $tag . "=(.+?)\](.+?)\[\/" . $tag . "\]/";
        $this->htmls[] =
                "<" . $tag . " " . $optionval . "='\\1'>\\2</" . $tag . ">";
    }

    function adv_option_tag($tag = "", $reptag = "", $optionval = "")
    {

        if ($tag == "" || $optionval == "" || $reptag == "")
        {
            break;
        }
        $this->parsings[] =
                "/\[" . $tag . "=(.+?)\](.+?)\[\/" . $tag . "\]/";
        $this->htmls[] =
                "<" . $reptag . " " . $optionval . "='\\1'>\\2</" . $reptag
                        . ">";
    }

    function adv_option_tag_em($tag = "", $reptag = "", $optionval = "")
    {

        if ($tag == "" || $optionval == "" || $reptag == "")
        {
            break;
        }
        $this->parsings[] =
                "/\[" . $tag . "=(.+?)\](.+?)\[\/" . $tag . "\]/";
        $this->htmls[] =
                "<" . $reptag . " " . $optionval . "='mailto:\\1'>\\2</"
                        . $reptag . ">";
    }

    function simp_option_notext($tag = "", $optionval = "")
    {

        if ($tag == "" || $optionval == "")
        {
            break;
        }
        $this->parsings[] = "/\[" . $tag . "=(.+?)\]/";
        $this->htmls[] = "<" . $tag . " " . $optionval . "='\\1' />";
    }

    function adv_option_notext($tag = "", $reptag = "", $optionval = "")
    {

        if ($tag == "" || $optionval == "" || $reptag == "")
        {
            break;
        }
        $this->parsings[] = "/\[" . $tag . "=(.+?)\]/";
        $this->htmls[] = "<" . $reptag . " " . $optionval . "='\\1' />";
    }

    function adv_option_notext_em($tag = "", $reptag = "", $optionval = "")
    {

        if ($tag == "" || $optionval == "" || $reptag == "")
        {
            break;
        }
        $this->parsings[] = "/\[" . $tag . "=(.+?)\]/";
        $this->htmls[] =
                "<" . $reptag . " " . $optionval . "='mailto:\\1' >\\1</"
                        . $reptag . ">";
    }

    function simp_bbcode_att($tag = "", $optionval = "")
    {

        if ($tag == "" || $optionval == "")
        {
            break;
        }
        $this->parsings[] = "/\[" . $tag . "\](.+?)\[\/" . $tag . "\]/";
        $this->htmls[] = "<" . $tag . " " . $optionval . "='\\1' />";
    }

    function adv_bbcode_att($tag = "", $reptag = "", $optionval = "")
    {

        if ($tag == "" || $optionval == "" || $reptag == "")
        {
            break;
        }
        $this->parsings[] = "/\[" . $tag . "\](.+?)\[\/" . $tag . "\]/";
        $this->htmls[] = "<" . $reptag . " " . $optionval . "='\\1' />";
    }

    function adv_bbcode_att_em($tag = "", $reptag = "", $optionval = "")
    {

        if ($tag == "" || $optionval == "" || $reptag == "")
        {
            break;
        }
        $this->parsings[] = "/\[" . $tag . "\](.+?)\[\/" . $tag . "\]/";
        $this->htmls[] =
                "<" . $reptag . " " . $optionval . "='mailto:\\1'>\\1</"
                        . $reptag . ">";
    }

    function cust_tag($bbcode = "", $html = "")
    {

        if ($bbcode == "" || $html == "")
        {
            break;
        }
        $this->parsings[] = $bbcode;
        $this->htmls[] = $html;
    }

    function parse_bbcode($text)
    {

        $i = 0;
        while (isset($this->parsings[$i]))
        {

            $text =
                    preg_replace($this->parsings[$i], $this->htmls[$i], $text);
            $i++;
        }
        return $text;
    }

    function export_parsings()
    {
        return $this->parsings;
    }

    function export_htmls()
    {
        return $this->htmls;
    }
}

