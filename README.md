# php-rss2wml_rss2hdml
Two codesamples about my very first mobile development

## Background ##
Originally based from "RSSmanip PHP 1.0"

http://code.iamcal.com/php/rss_manip/

I updated my code to work with latest PHP versions and generate HDML and WAP compatible output

## Requeriments ##
- PHP 5.1+
- PHP cURL module enabled
- Lot of Valid RSS 

## Known Issues about WML / HDML browsers ##
- Doesn't support 30x redirects related to DirectoryIndex. ex: http://wap.example.com/ doesnt works but http://wap.example.com/index.php yes
- More than 4 Kb. output can bring problems
