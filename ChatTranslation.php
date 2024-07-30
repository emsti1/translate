<?php
	
	$domain = $_GET['domain'];
	$text = $_GET['text'];
	$langFrom = $_GET['sl'];
	$langTo = $_GET['tl'];
	
	// Debug
	/*
	$domain = ".com";
	$text = "Testing one two three.";
	$langFrom = "en";
	$langTo = "bg";
	*/
	
	$text = str_replace(' ', '%20', $text);
	
	$fp = @fsockopen("translate.google$domain", 80, $errno, $errstr, 1);
	if(!$fp)
	{
		echo "Use this url for <b>sv_translatefile</b>";
		exit;
	}
	
	$out = "GET /translate_a/t?client=t&text=$text&sl=$langFrom&tl=$langTo HTTP/1.1\r\n";
	$out .= "Host: translate.google$domain\r\n";
	$out .= "Connection: Close\r\n\r\n";
	
	fwrite($fp, $out);
	$return = "";
	stream_set_timeout($fp, 2);
	while(!feof($fp))
	{
		$info = stream_get_meta_data($fp);
		if($info['timed_out'])
			exit;
		$return .= fgets($fp, 128);
	}
	fclose($fp);
	
	if(!preg_match("~\"(.+?)\"~", $return, $match))
		exit;
	
	$result = $match[1];
	//echo "\"$result\"<br />\n"; // For finding correct language chars
	
	if(strcasecmp($langTo, 'de') == 0)
	{
		// German
		$result = str_replace('Ä', 'Ae', $result);
		$result = str_replace('ä', 'ae', $result);
		$result = str_replace('Ö', 'Oe', $result);
		$result = str_replace('ö', 'oe', $result);
		$result = str_replace('Ü', 'Ue', $result);
		$result = str_replace('ü', 'ue', $result);
		$result = str_replace('ß', 'ss', $result);
	}
	else if(strcasecmp($langTo, 'tr') == 0)
	{
		// Turkish
		$result = str_replace('I', 'I', $result);
		$result = str_replace('i', 'i', $result);
		$result = str_replace('Ö', 'O', $result);
		$result = str_replace('ö', 'o', $result);
		$result = str_replace('Ü', 'U', $result);
		$result = str_replace('ü', 'u', $result);
		$result = str_replace('Ç', 'C', $result);
		$result = str_replace('ç', 'c', $result);
		$result = str_replace('G', 'G', $result);
		$result = str_replace('g', 'g', $result);
		$result = str_replace('S', 'S', $result);
		$result = str_replace('s', 's', $result);
		$result = str_replace('ý', 'y', $result);
		$result = str_replace('þ', 'p', $result);
	}
	else if(strcasecmp($langTo, 'fr') == 0)
	{
		// French
		$result = str_replace('à', 'a', $result);
		$result = str_replace('è', 'e', $result);
		$result = str_replace('ô', 'o', $result);
		$result = str_replace('ù', 'u', $result);
		$result = str_replace('Ç', 'C', $result);
		$result = str_replace('Œ', 'CE', $result);
		$result = str_replace('â', 'a', $result);
		$result = str_replace('ê', 'e', $result);
		$result = str_replace('î', 'i', $result);
		$result = str_replace('û', 'u', $result);
		$result = str_replace('é', 'e', $result);
		$result = str_replace('ë', 'e', $result);
		$result = str_replace('ï', 'i', $result);
		$result = str_replace('ç', 'c', $result);
	}
	else if(strcasecmp($langTo, 'sv') == 0)
	{
		// Swedish
		$result = str_replace('ö', 'o', $result);
		$result = str_replace('å', 'a', $result);
		$result = str_replace('ä', 'a', $result);
		$result = str_replace('Ö', 'O', $result);
		$result = str_replace('Å', 'A', $result);
		$result = str_replace('Ä', 'A', $result);
	}
	else if(strcasecmp($langTo, 'da') == 0)
	{
		// Danish
		$result = str_replace('å', 'aa', $result);
		$result = str_replace('ø', 'o', $result);
		$result = str_replace('æ', 'ae', $result);
		$result = str_replace('Å', 'Aa', $result);
		$result = str_replace('Æ', 'Ae', $result);
		$result = str_replace('Ø', 'Oe', $result);
	}
	else if(strcasecmp($langTo, 'pl') == 0)
	{
		// Polish
	}
	else if(strcasecmp($langTo, 'nl') == 0)
	{
		// Dutch
		$result = str_replace('ë', 'e', $result);
		$result = str_replace('ï', 'i', $result);
	}
	else if(strcasecmp($langTo, 'es') == 0)
	{
		// Spanish
		$result = str_replace('á', 'a', $result);
		$result = str_replace('é', 'e', $result);
		$result = str_replace('í', 'i', $result);
		$result = str_replace('ó', 'o', $result);
		$result = str_replace('ú', 'u', $result);
		$result = str_replace('É', 'E', $result);
		$result = str_replace('¿', '?', $result);
		$result = str_replace('¡', 'i', $result);
		$result = str_replace('ª', 'a', $result);
		$result = str_replace('º', 'o', $result);
		$result = str_replace('Ñ', 'Ni', $result);
		$result = str_replace('ñ', 'ni', $result);
	}
	else if(strcasecmp($langTo, 'pt') == 0)
	{
		// Brazil Portuguese
	}
	else if(strcasecmp($langTo, 'cs') == 0)
	{
		// Czech
	}
	else if(strcasecmp($langTo, 'fi') == 0)
	{
		// Finnish
		$result = str_replace('Ä', 'A', $result);
		$result = str_replace('Ö', 'O', $result);
		$result = str_replace('ä', 'a', $result);
		$result = str_replace('ö', 'o', $result);
	}
	else if(strcasecmp($langTo, 'bg') == 0)
	{
		// Bulgarian
		$replace_chars = Array(
			'b0'=>'A', // А-A
			'd0'=>'a', // а-a
			'b1'=>'B', // Б-B
			'd1'=>'b', // б-b
			'b2'=>'V', // В-V
			'd2'=>'v', // в-v
			'b3'=>'G', // Г-G
			'd3'=>'g', // г-g
			'b4'=>'D', // Д-D
			'd4'=>'d', // д-d
			'b5'=>'E', // Е-E
			'd5'=>'e', // е-e
			'b6'=>'Zh', // Ж-Zh
			'd6'=>'zh', // ж-zh
			'b7'=>'Z', // З-Z
			'd7'=>'z', // з-z
			'b8'=>'I', // И-I
			'd8'=>'i', // и-i
			'b9'=>'Y', // Й-Y
			'd9'=>'y', // й-y
			'ba'=>'K', // К-K
			'da'=>'k', // к-k
			'bb'=>'L', // Л-L
			'db'=>'l', // л-l
			'bc'=>'M', // М-M
			'dc'=>'m', // м-m
			'bd'=>'N', // Н-N
			'dd'=>'n', // н-n
			'be'=>'O', // О-O
			'de'=>'o', // о-o
			'bf'=>'P', // П-P
			'df'=>'p', // п-p
			'c0'=>'R', // Р-R
			'e0'=>'r', // р-r
			'c1'=>'S', // С-S
			'e1'=>'s', // с-s
			'c2'=>'T', // Т-T
			'e2'=>'t', // т-t
			'c3'=>'U', // У-U
			'e3'=>'u', // у-u
			'c4'=>'F', // Ф-F
			'e4'=>'f', // ф-f
			'c5'=>'H', // Х-H
			'e5'=>'h', // х-h
			'c6'=>'Ts', // Ц-Ts
			'e6'=>'ts', // ц-ts
			'c7'=>'Ch', // Ч-Ch
			'e7'=>'ch', // ч-ch
			'c8'=>'Sh', // Ш-Sh
			'e8'=>'sh', // ш-sh
			'c9'=>'Sht', // Щ-Sht
			'd9'=>'sht', // щ-sht
			'da'=>'A', // Ъ-A
			'ea'=>'a', // ъ-a
			'dc'=>'Y', // Ь-Y
			'ec'=>'y', // ь-y
			'de'=>'Yu', // Ю-Yu
			'ee'=>'yu', // ю-yu
			'df'=>'Ya', // Я-Ya
			'ef'=>'ya' // я-ya
		);
		
		$result = strToHex($result);
		$result = strtr($result, $replace_chars);
		$result = hexToEnglish($result);
	}
	else if(strcasecmp($langTo, 'ro') == 0)
	{
		// Romanian
		$result = str_replace('A', 'A', $result);
		$result = str_replace('Î', 'I', $result);
		$result = str_replace('S', 'S', $result);
		$result = str_replace('T', 'T', $result);
		$result = str_replace('Â', 'A', $result);
		$result = str_replace('a', 'a', $result);
		$result = str_replace('î', 'i', $result);
		$result = str_replace('s', 's', $result);
		$result = str_replace('t', 't', $result);
		$result = str_replace('â', 'a', $result);
	}
	else if(strcasecmp($langTo, 'hu') == 0)
	{
		// Hungarian
	}
	else if(strcasecmp($langTo, 'lt') == 0)
	{
		// Lithuania
		$result = str_replace('Ą', 'A', $result);
		$result = str_replace('ą', 'a', $result);
		$result = str_replace('Č', 'C', $result);
		$result = str_replace('č', 'c', $result);
		$result = str_replace('Ę', 'E', $result);
		$result = str_replace('ę', 'e', $result);
		$result = str_replace('Ė', 'E', $result);
		$result = str_replace('ė', 'e', $result);
		$result = str_replace('Į', 'I', $result);
		$result = str_replace('į', 'i', $result);
		$result = str_replace('Š', 'S', $result);
		$result = str_replace('š', 's', $result);
		$result = str_replace('Ų', 'U', $result);
		$result = str_replace('ų', 'u', $result);
		$result = str_replace('Ū', 'U', $result);
		$result = str_replace('ū', 'u', $result);
		$result = str_replace('Ž', 'Z', $result);
		$result = str_replace('ž', 'z', $result);
	}
	else if(strcasecmp($langTo, 'sk') == 0)
	{
		// Slovak
	}
	
	
	echo "\"$result\"";
	
	
	/* Functions start */
	function strToHex($string)
	{
		$hex='';
		for($i=0; $i<strlen($string); $i++)
		{
			if($string[$i] == ' ' || $string[$i] == ',' || $string[$i] == '?' || $string[$i] == '!' || $string[$i] == '.')
			{
				$hex .= $string[$i];
				continue;
			}
			$hex .= dechex(ord($string[$i]))."|";
		}
		return $hex;
	}
	
	function hexToEnglish($string)
	{
		$replace_chars = Array(
			'41'=>'A',
			'61'=>'a',
			'42'=>'B',
			'62'=>'b',
			'43'=>'C',
			'63'=>'c',
			'44'=>'D',
			'64'=>'d',
			'45'=>'E',
			'65'=>'e',
			'46'=>'F',
			'66'=>'f',
			'47'=>'G',
			'67'=>'g',
			'48'=>'H',
			'68'=>'h',
			'49'=>'I',
			'69'=>'i',
			'4a'=>'J',
			'6a'=>'j',
			'4b'=>'K',
			'6b'=>'k',
			'4c'=>'L',
			'6c'=>'l',
			'4d'=>'M',
			'6d'=>'m',
			'4e'=>'N',
			'6e'=>'n',
			'4f'=>'O',
			'6f'=>'o',
			'50'=>'P',
			'70'=>'p',
			'51'=>'Q',
			'71'=>'q',
			'52'=>'R',
			'72'=>'r',
			'53'=>'S',
			'73'=>'s',
			'74'=>'T',
			'74'=>'t',
			'75'=>'U',
			'75'=>'u',
			'76'=>'V',
			'76'=>'v',
			'77'=>'W',
			'77'=>'w',
			'78'=>'X',
			'78'=>'x',
			'79'=>'Y',
			'79'=>'y',
			'5a'=>'Z',
			'7a'=>'z',
			'|'=>''
		);
		
		$string = strtr($string, $replace_chars);
		return $string;
	}
?>