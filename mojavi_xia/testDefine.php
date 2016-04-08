<?php
//require_once 'index.php';
echo '<br/>'.'test'.'<br/>';

//读取php.ini的初使值
echo ini_get('file_uploads')."<br>";
echo ini_get('max_input_time')."<br>";
echo ini_get('max_execution_time')."<br>";
echo ini_get('post_max_size')."<br>";
echo ini_get('upload_max_filesize')."<br>";
echo ini_get('memory_limit')."<br>";

//修开php.ini配置
ini_set('file_uploads','ON');//Http上传文件的开关，默认为开
ini_set('max_input_time','90');//通过post,以及put接收数据时间，默认为60秒
ini_set('max_execution_time','180');//默认为30秒，脚本执行时间修改为180秒
ini_set('post_max_size','10M');//修改post变量由2m变成1om,要比upload_max_filesize大
ini_set('upload_max_filesize','8M');//文件上传最大
ini_set('memory_limit','90M');//内存使用问题，最好比post_max_size大1.5倍
 
//修改后的数据
echo "<hr>";
echo ini_get('file_uploads')."<br>";
echo ini_get('max_input_time')."<br>";
echo ini_get('max_execution_time')."<br>";
echo ini_get('post_max_size')."<br>";
echo ini_get('upload_max_filesize')."<br>";
echo ini_get('memory_limit')."<br>";

set_include_path('D:/MyProgramAndDocument/php/axb/mojavi' . PATH_SEPARATOR .'/axb/mojavi');
//ini_set("MO_APP_DIR", "D:/MyProgramAndDocument/php/axb/mojavi");　　　　　
echo  MO_APP_DIR;
?>

D:\Program\WAMP\PHP\;C:\watcom-1.3\binnt;C:\watcom-1.3\binw
;%SystemRoot%\system32;%SystemRoot%;%SystemRoot%\System32\Wbem;%SYSTEMROOT%\System32\WindowsPowerShell\v1.0\;
D:\Program\Matlab2014a\runtime\win32;D:\Program\MSYS-Update\MSYS\mingw\bin;D:\Program\Matlab2014a\bin;
D:\Program\Matlab2014a\polyspace\bin;C:\Program Files\Microsoft SQL Server\100\Tools\Binn\;
C:\Program Files\Microsoft SQL Server\100\DTS\Binn\;
C:\Program Files\Microsoft SQL Server\100\Tools\Binn\VSShell\Common7\IDE\;
C:\Program Files\Microsoft Visual Studio 9.0\Common7\IDE\PrivateAssemblies\;
C:\Program Files\MySQL\MySQL Fabric 1.5.2 & MySQL Utilities 1.5.2 1.5\;
C:\Program Files\MySQL\MySQL Fabric 1.5.2 & MySQL Utilities 1.5.2 1.5\Doctrine extensions for PHP\;
D:\Program\MinGW\bin;D:\Application\skype\Phone\;C:\Program Files\Microsoft ASP.NET\ASP.NET Web Pages\v1.0\;
C:\Program Files\Microsoft\Web Platform Installer\;D:\Program\NodeJs\;
C:\Program Files\Windows Kits\8.1\Windows Performance Toolkit\;C:\Program Files\Microsoft SQL Server\110\Tools\Binn\;
C:\Program Files\Microsoft SDKs\TypeScript\1.0\;D:\Program\Git\cmd;%JAVA_HOME%\bin;D:\Program\SVN\bin