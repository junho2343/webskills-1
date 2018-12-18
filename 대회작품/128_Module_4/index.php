<?php


	define("_ROOT",__dir__);

	define("_APP",_ROOT."/app");
	define("_PUBLIC",_ROOT."/public");

	define("_CONTROLLER",_APP."/Controller");
	define("_CORE",_APP."/Core");
	define("_CONFIG",_APP."/Config");
	define("_VIEW",_APP."/View");

	define("_UPLOAD",_PUBLIC."/upload");


	require _CONFIG."/autoload.php";
	require _CONFIG."/lib.php";
	require "web.php";

	app\Core\Router::run();