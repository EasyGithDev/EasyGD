<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ipct
 *
 * @author florent
 */

namespace Easy;

/* * **********************************************************\

  IPTC EASY 1.0 - IPTC data manipulator for JPEG images

  All reserved www.image-host-script.com

  Sep 15, 2008

  \*********************************************************** */

class Iptc {

    const IPTC_OBJECT_NAME = '005';
    const IPTC_EDIT_STATUS = '007';
    const IPTC_PRIORITY = '010';
    const IPTC_CATEGORY = '015';
    const IPTC_SUPPLEMENTAL_CATEGORY = '020';
    const IPTC_FIXTURE_IDENTIFIER = '022';
    const IPTC_KEYWORDS = '025';
    const IPTC_RELEASE_DATE = '030';
    const IPTC_RELEASE_TIME = '035';
    const IPTC_SPECIAL_INSTRUCTIONS = '040';
    const IPTC_REFERENCE_SERVICE = '045';
    const IPTC_REFERENCE_DATE = '047';
    const IPTC_REFERENCE_NUMBER = '050';
    const IPTC_CREATED_DATE = '055';
    const IPTC_CREATED_TIME = '060';
    const IPTC_ORIGINATING_PROGRAM = '065';
    const IPTC_PROGRAM_VERSION = '070';
    const IPTC_OBJECT_CYCLE = '075';
    const IPTC_BYLINE = '080';
    const IPTC_BYLINE_TITLE = '085';
    const IPTC_CITY = '090';
    const IPTC_PROVINCE_STATE = '095';
    const IPTC_COUNTRY_CODE = '100';
    const IPTC_COUNTRY = '101';
    const IPTC_ORIGINAL_TRANSMISSION_REFERENCE = '103';
    const IPTC_HEADLINE = '105';
    const IPTC_CREDIT = '110';
    const IPTC_SOURCE = '115';
    const IPTC_COPYRIGHT_STRING = '116';
    const IPTC_CAPTION = '120';
    const IPTC_LOCAL_CAPTION = '121';

    private $metas = array();

    public function __construct($app13) {
	$this->metas = iptcparse($app13);
    }

    public function addTag($tag, $data) {
	$this->metas["2#$tag"][0] = $data;
    }

    public function getTag($tag) {
	return isset($this->metas["2#$tag"]) ? $this->metas["2#$tag"][0] : FALSE;
    }

    public function __toString() {
	$iptc_new = '';
	foreach ($this->metas as $k => $v) {
	    $iptc_new .= "
	    $k : $v[0]";
	}
	return $iptc_new;
    }

    // Fonction iptc_make_tag() par Thies C. Arntzen
    private function iptc_maketag($rec, $data, $value) {
	$length = strlen($value);
	$retval = chr(0x1C) . chr($rec) . chr($data);

	if ($length < 0x8000) {
	    $retval .= chr($length >> 8) . chr($length & 0xFF);
	} else {
	    $retval .= chr(0x80) .
		    chr(0x04) .
		    chr(($length >> 24) & 0xFF) .
		    chr(($length >> 16) & 0xFF) .
		    chr(($length >> 8) & 0xFF) .
		    chr($length & 0xFF);
	}

	return $retval . $value;
    }

    public function write($fileSrc, $fileDest) {
	if (!function_exists('iptcembed'))
	    return FALSE;

	$iptc_new = '';
	foreach ($this->metas as $tag => $val) {
	    $tag = substr($tag, 2);
	    $iptc_new .= $this->iptc_maketag(2, $tag, $val[0]);
	}

	if (($content = @iptcembed($iptc_new, $fileSrc)) === FALSE)
	    return FALSE;

	$handle = fopen($fileDest, "w");
	if (!$handle)
	    return FALSE;
	fwrite($handle, $content);
	fclose($handle);

	return TRUE;
    }

}

?>