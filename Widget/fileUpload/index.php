<?php
	require_once(dirname(__FILE__)."/../../App.class.php");
	require_once(dirname(__FILE__)."/../../User/User.class.php");
	$app = new App();
	$user = new User();
	if (!$user->isLogin())
		die("<center>Please loginf first!</center>");
	include("upload.php");
	$myclass=new upload_file;
	empty($_GET['curl'])?$myclass->flash_directory="":$myclass->flash_directory=urldecode($_GET['curl']);
	
	//删除文件
	if(isset($_GET["del"])){
		$delfilename=iconv("UTF-8","gb2312",urldecode($_GET["del"]));
		//print($delfilename);
		$myclass->del_files($delfilename);
	}
	
	//删除文件夹
	if (isset($_GET["deldir"]))
		if("yes"==$_GET["deldir"]){
			$myclass->rm_dir();
			$myclass->flash_directory="";
		}
	
	//创建文件夹
	if(!empty($_POST['dirname'])){
		$myclass->mk_dir($_POST['dirname']);
		$myclass->flash_directory=$_GET['curl'];
	}
?>
<html>
<head>
    <meta charset="utf-8" />
    <title>文件上传实例</title>
    <script language="javascript" type="text/javascript">
        function returnvalue(ivalue){
            window.returnValue=ivalue;
            window.close();
        }
    </script>
    <style type="text/css">
        body,td,div,form{font-size:12px;}
        body,div,form{margin:2px;padding:0px;}
    </style>
</head>
<body>
<form action="?curl=<?php echo($myclass->flash_directory); ?>" method="post">
	<input type="text" name="dirname" id="dirname"/>
    <input type="submit" value="创建目录"/>
</form>
<form action="save.php?curl=<?php echo($myclass->flash_directory); ?>" method="post" enctype="multipart/form-data">
<table border=0 cellPadding=3 cellSpacing=0>
<tr>
<td><input name="src" type="file"/></td><td width="70"><input type="submit" value="上传"/></td>
</tr>
<tr>

</tr>
</table>
</form>
<hr size="1"/>

<table cellpadding="4" cellspacing="0">
<tr><td><b>文件名</b></td><td><b>修改日期</b></td><td><b>文件大小</b></td><td><b>操作</b></td></tr>

<?php
$dirlist=$myclass->get_dir_list();
print("<tr><td><a href='?curl=' target='_self'>返回根目录</a>&gt;".$myclass->flash_directory);
print("</td><td></td><td></td><td></td></tr>\r\n");
foreach($dirlist as $key=>$value){
	$mybasename=iconv("gb2312","UTF-8",basename($value[0]));	
	if($mybasename!="." && $mybasename!=".."){
		$myurl=empty($myclass->flash_directory)?$mybasename:$myclass->flash_directory."\\".$mybasename;
		print("<tr><td><a href='?curl=".urlencode($myurl)."' target='_self'>$mybasename</a></td><td>$value[1]</td><td>".round($value[2]/1024)."KB</td><td><a href='?curl=".urlencode($myurl)."&deldir=yes' target='_self'>删除</a></td></tr>\r\n");
		
	}
}

//print($myclass->base_directory);
$filelist=$myclass->get_files_list();
foreach($filelist as $key=>$value){
	$mybasename=iconv("gb2312","UTF-8",basename($value[0]));
	$mybase_url=empty($myclass->flash_directory)?$mybasename:$myclass->flash_directory."/".$mybasename;
	print("<tr><td><a href='#' onclick='javascript:callback(\"".substr($_SERVER["REQUEST_URI"], 0, strpos($_SERVER["REQUEST_URI"], "/index.php"))."/uploadFiles/$mybasename\");'>$mybasename</a></td><td>$value[1]</td><td>".round($value[2]/1024)."KB</td><td><a href='?curl=".$myclass->flash_directory."&del=".urlencode($mybasename)."' target='_self'>删除</a>&nbsp;<a href='' target='_self' onclick='javascript:returnvalue(\"$mybase_url\")'>选择</a></td></tr>\r\n");
}
//print_r($aaaa);

?>
</table>
<hr size="1"/>
</body>
</html>
