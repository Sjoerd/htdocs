<?php
/**
 * Ubb parser (by PropertyX (https://github.com/PropertyX))
 */

 namespace PropertyX\Ubb;
 include 'emojione/lib/php/autoload.php';
 use \Emojione\Client as EmojioneClient;
 use \Emojione\Emojione as EmojioneCore;
 use \Emojione\Ruleset as EmojioneRuleSet;

 class Ubb
 {
   public static $smileyIcon = [];

   public static function Parse($string, $nlbr = true)
   {
     self::getSmilies();
     $string = htmlspecialchars($string);
     $string = stripslashes($string);
     $string = (($nlbr) ? nl2br($string) : $string);
     $string = str_replace('bmdiv', 'div', $string);

     $string = self::BBCodes($string);
     $string = self::Images($string);
     $string = self::Smilies($string);
     $string = ((true) ? self::regSmilies($string) : $string);

     return $string;
   }

   public static function regSmilies($string)
    {
    	foreach(self::$smileyIcon as $key => $value)
		{
			$string = str_replace($key, '<img class="emojione" src="../img/emojione/'. $value. '.svg" alt="'. $key. '" title="'. $key. '" />', $string);
		}

		return $string;
    }

    public static function getSmilies()
    {
    	self::$smileyIcon = [
            '<3' => '2764',
            '</3' => '1f494',
            ':\')' => '1f602',
            ':\'-)' => '1f602',
            ':D' => '1f603',
            ':-D' => '1f603',
            '=D' => '1f603',
            ':)' => '1f642',
            ':-)' => '1f642',
            '=]' => '1f642',
            '=)' => '1f642',
            ':]' => '1f642',
            '\':)' => '1f605',
            '\':-)' => '1f605',
            '\'=)' => '1f605',
            '\':D' => '1f605',
            '\':-D' => '1f605',
            '\'=D' => '1f605',
            '>:)' => '1f606',
            '>;)' => '1f606',
            '>:-)' => '1f606',
            '>=)' => '1f606',
            ';)' => '1f609',
            ';-)' => '1f609',
            '*-)' => '1f609',
            '*)' => '1f609',
            ';-]' => '1f609',
            ';]' => '1f609',
            ';D' => '1f609',
            ';^)' => '1f609',
            '\':(' => '1f613',
            '\':-(' => '1f613',
            '\'=(' => '1f613',
            ':*' => '1f618',
            ':-*' => '1f618',
            '=*' => '1f618',
            ':^*' => '1f618',
            '>:P' => '1f61c',
            'X-P' => '1f61c',
            'x-p' => '1f61c',
            '>:[' => '1f61e',
            ':-(' => '1f61e',
            ':(' => '1f61e',
            ':-[' => '1f61e',
            ':[' => '1f61e',
            '=(' => '1f61e',
            '>:(' => '1f620',
            '>:-(' => '1f620',
            ':@' => '1f620',
            ':\'(' => '1f622',
            ':\'-(' => '1f622',
            ';(' => '1f622',
            ';-(' => '1f622',
            '>.<' => '1f623',
            'D:' => '1f628',
            ':$' => '1f633',
            '=$' => '1f633',
            '#-)' => '1f635',
            '#)' => '1f635',
            '%-)' => '1f635',
            '%)' => '1f635',
            'X)' => '1f635',
            'X-)' => '1f635',
            '*\\0/*' => '1f646',
            '\\0/' => '1f646',
            '*\\O/*' => '1f646',
            '\\O/' => '1f646',
            'O:-)' => '1f607',
            '0:-3' => '1f607',
            '0:3' => '1f607',
            '0:-)' => '1f607',
            '0:)' => '1f607',
            '0;^)' => '1f607',
            'O:)' => '1f607',
            'O;-)' => '1f607',
            'O=)' => '1f607',
            '0;-)' => '1f607',
            'O:-3' => '1f607',
            'O:3' => '1f607',
            'B-)' => '1f60e',
            'B)' => '1f60e',
            '8)' => '1f60e',
            '8-)' => '1f60e',
            'B-D' => '1f60e',
            '8-D' => '1f60e',
            '-_-' => '1f611',
            '-__-' => '1f611',
            '-___-' => '1f611',
            '>:\\' => '1f615',
            '>:/' => '1f615',
            ':-/' => '1f615',
            ':-.' => '1f615',
            ':/' => '1f615',
            ':\\' => '1f615',
            '=/' => '1f615',
            '=\\' => '1f615',
            ':L' => '1f615',
            '=L' => '1f615',
            ':P' => '1f61b',
            ':-P' => '1f61b',
            '=P' => '1f61b',
            ':-p' => '1f61b',
            ':p' => '1f61b',
            '=p' => '1f61b',
            ':-Þ' => '1f61b',
            ':Þ' => '1f61b',
            ':þ' => '1f61b',
            ':-þ' => '1f61b',
            ':-b' => '1f61b',
            ':b' => '1f61b',
            'd:' => '1f61b',
            ':-O' => '1f62e',
            ':O' => '1f62e',
            ':-o' => '1f62e',
            ':o' => '1f62e',
            'O_O' => '1f62e',
            '>:O' => '1f62e',
            ':-X' => '1f636',
            ':X' => '1f636',
            ':-#' => '1f636',
            ':#' => '1f636',
            '=X' => '1f636',
            '=x' => '1f636',
            ':x' => '1f636',
            ':-x' => '1f636',
            '=#' => '1f636'
        ];
    }

    public static function Smilies($smiley)
    {
    	$client = new EmojioneClient(new EmojioneRuleSet());
        $client->imageType = 'svg';
        $client->imagePathSVG = 'img/emojione/';

        return $client->shortnameToImage($smiley);
    }

   public static function BBCodes($bbcode)
   {
     $bbcode = preg_replace("_\[b\](.*?)\[/b\]_si", '<b>$1</b>', $bbcode);
		 $bbcode = preg_replace('_\[i\](.*?)\[/i\]_si', '<i>$1</i>', $bbcode);
		 $bbcode = str_replace("[hr]", '<hr />', $bbcode);
		 $bbcode = preg_replace("_\[h3\](.*?)\[/h3\]_si", '<h3>$1</h3>', $bbcode);
		 $bbcode = preg_replace("_\[u\](.*?)\[/u\]_si", '<u>$1</u>', $bbcode);
		 $bbcode = preg_replace("_\[center\](.*?)\[/center\]_si", '<center>$1</center>', $bbcode);
		 $bbcode = preg_replace("_\[list\](.*?)\[/list\]_si", '<ul>$1</ul>', $bbcode);
		 $bbcode = preg_replace("_\[item\](.*?)\[/item\]_si", '<li>$1</li>', $bbcode);
		 $bbcode = preg_replace("_\[s\](.*?)\[/s\]_si", '<strike>$1</strike>', $bbcode);
		 $bbcode = preg_replace("_\[size=(.*?)\](.*?)\[/size\]_si", '<span style="font-size: $1px">$2</span>', $bbcode);
		 $bbcode = preg_replace("_\[color=(.*?)\](.*?)\[/color\]_si", '<span style="color: $1;">$2</span>', $bbcode);
	   $bbcode = preg_replace("_\[font=(.*?)\](.*?)\[/font\]_si", '<span style="font-family: $1">$2</span>', $bbcode);
		 $bbcode = preg_replace("_\[hl=(.*?)\](.*?)\[/hl\]_si", '<span style="background: $1">$2</span>', $bbcode);
		 $bbcode = preg_replace("_\[url\]http://(.*?)\[/url\]_si", '<a href="http://$1" target="_blank">$1</a>', $bbcode);
		 $bbcode = preg_replace("_\[url\](.*?)\[/url\]_si", '<a href="http://$1" target="_blank">$1</a>', $bbcode);
		 $bbcode = preg_replace("_\[url=http://(.*?)\](.*?)\[/url\]_si", '<a href="http://$1" target="_blank">$2</a>', $bbcode);
		 $bbcode = preg_replace("_\[url=(.*?)\](.*?)\[/url\]_si", '<a href="http://$1" target="_blank">$2</a>', $bbcode);
     $bbcode = preg_replace("_\[youtube\](.*?)\[/youtube\]_si", '<iframe src="$1" id="block-yt"></iframe>', $bbcode);
     $bbcode = preg_replace("_\[yt\](.*?)\[/yt\]_si", '<iframe src="$1" id="block-yt"></iframe>', $bbcode);
     $bbcode = preg_replace("_\[video\](.*?)\[/video\]_si", '<iframe src="$1" id="block-yt"></iframe>', $bbcode);
     $bbcode = preg_replace("_\[quote\](.*?)\[/quote\]_si", '<blockquote><p>$1</p></blockquote>', $bbcode);
     $bbcode = preg_replace("_\[sup\](.*?)\[/sup\]_si", '<sup>$1</sup>', $bbcode);
     $bbcode = preg_replace("_\[sub\](.*?)\[/sub\]_si", '<sub>$1</sub>', $bbcode);

     return $bbcode;
   }

   public static function Images($img)
  {
    $img = preg_replace("_\[img\](.*?)\[/img\]_si", '<img src="$1" style="max-width: 100%;" />', $img);
    $img = preg_replace("_\[imgr\](.*?)\[/imgr\]_si", '<img style="float: right" src="$1" />', $img);
    $img = preg_replace("_\[imgl\](.*?)\[/imgl\]_si", '<img style="float: left" src="$1" />', $img);

    return $img;
  }
 }

 $propertyUbb = new Ubb();
