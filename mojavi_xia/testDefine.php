<?php
//require_once 'index.php';
echo '<br/>'.'test'.'<br/>';

//��ȡphp.ini�ĳ�ʹֵ
echo ini_get('file_uploads')."<br>";
echo ini_get('max_input_time')."<br>";
echo ini_get('max_execution_time')."<br>";
echo ini_get('post_max_size')."<br>";
echo ini_get('upload_max_filesize')."<br>";
echo ini_get('memory_limit')."<br>";

//�޿�php.ini����
ini_set('file_uploads','ON');//Http�ϴ��ļ��Ŀ��أ�Ĭ��Ϊ��
ini_set('max_input_time','90');//ͨ��post,�Լ�put��������ʱ�䣬Ĭ��Ϊ60��
ini_set('max_execution_time','180');//Ĭ��Ϊ30�룬�ű�ִ��ʱ���޸�Ϊ180��
ini_set('post_max_size','10M');//�޸�post������2m���1om,Ҫ��upload_max_filesize��
ini_set('upload_max_filesize','8M');//�ļ��ϴ����
ini_set('memory_limit','90M');//�ڴ�ʹ�����⣬��ñ�post_max_size��1.5��
 
//�޸ĺ������
echo "<hr>";
echo ini_get('file_uploads')."<br>";
echo ini_get('max_input_time')."<br>";
echo ini_get('max_execution_time')."<br>";
echo ini_get('post_max_size')."<br>";
echo ini_get('upload_max_filesize')."<br>";
echo ini_get('memory_limit')."<br>";

set_include_path('D:/MyProgramAndDocument/php/axb/mojavi' . PATH_SEPARATOR .'/axb/mojavi');
//ini_set("MO_APP_DIR", "D:/MyProgramAndDocument/php/axb/mojavi");����������
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