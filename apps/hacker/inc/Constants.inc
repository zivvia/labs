<?php



define("ERROR_MYSQL_CONNECT",			"错误1:      无法连接到数据库");
define("ERROR_MYSQL_SQL",				"错误2:      在执行一个 SQL 出错");
define("ERROR_MODEL",					"错误3:      错误的 MODEL 参数");
define("ERROR_ACTION",					"错误3:      未知的命令");

define("QUERY_ACTION", "action");
define("QUERY_MODEL", "model");
define("QUERY_ID", "id");
define("QUERY_PAGER_SIZE", "size");
define("QUERY_PAGER_PAGE", "page");

define("ACTION_ADD", "add");
define("ACTION_EDIT", "edit");
define("ACTION_DELETE", "delete");

define("PAGE_ADMIN", "admin");


define("SESSION_USER", "SESSION_USER");
define("SESSION_CHECK_CODE", "CHECK_CODE");
define("COOKIES", "JSGLXT_COOKIES");
define("COOKIES_USER", "USER");
define("COOKIES_PWD", "PASSWORD");
define("COOKIES_PAGE", "PAGE");
define("COOKIES_PAGE_SIZE", "PAGE_SIZE");

define("PAGER_QUERY", "page");
define("PAGER_FIRST_PAGE", "首页");
define("PAGER_PREVIOUS_PAGE", "上一页");
define("PAGER_NEXT_PAGE", "下一页");
define("PAGER_LAST_PAGE", "尾页");
define("PAGER_WRAPERR_LEFT", "[");
define("PAGER_WRAPERR_RIGHT", "]");
define("PAGER_DEFAULT_PAGE_SIZE", 10);
define("PAGER_DEFAULT_PAGE", 1);

define("LOGIN_SUCCESS",					0);
define("LOGIN_CHECK_CODE_ERROR",		1);
define("LOGIN_CHECK_CODE_NULL",			2);
define("LOGIN_UNLOGGED",				3);
define("LOGIN_NOT_FOUND",				4);
define("LOGIN_PASSWORD_ERROR",			5);

define("REGISTER_SUCCESS",				0);
define("REGISTER_CHECK_CODE_ERROR",		1);
define("REGISTER_CHECK_CODE_NULL",		2);
define("REGISTER_INVALID",				3);
define("REGISTER_INVALID_PASSWORD",		4);
define("REGISTER_INVALID_NAME_LENGTH",	5);
define("REGISTER_INVALID_MEMBERS",		6);
define("REGISTER_INVALID_MAIL",			7);
define("REGISTER_INVALID_NAME",			8);

define("STATE_UNSTARTED",				0);
define("STATE_FINISHED",		1);
define("STATE_UNLOGIN",		2);
define("STATE_UNTAKED",				3);
define("STATE_UNUPLOADED",				4);


define("ROLE_RACER",					2);
define("ROLE_ADMIN",				    28);  //  4 | 8 | 16
define("ROLE_INFO",						4);
define("ROLE_MARKER",					12);       //  4 | 8

define("RESULT_PAGE_SIZE", 10);

?>