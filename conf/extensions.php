<?php
// Make sure this file was not accessed directly and prevent register_globals configuration array attack
if (!defined('IN_VANILLA')) exit();
// Enabled Extensions
include($Configuration['EXTENSIONS_PATH']."PreviewPost/default.php");
include($Configuration['EXTENSIONS_PATH']."Quotations/default.php");
include($Configuration['EXTENSIONS_PATH']."215-improved-sidepanel/default.php");
include($Configuration['EXTENSIONS_PATH']."4-category-jumper/default.php");
include($Configuration['EXTENSIONS_PATH']."Markdown/default.php");
include($Configuration['EXTENSIONS_PATH']."TagThis/default.php");
include($Configuration['EXTENSIONS_PATH']."HtmlFormatter/default.php");
include($Configuration['EXTENSIONS_PATH']."7-discussion-filters/default.php");
