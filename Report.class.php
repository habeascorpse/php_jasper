<?php

if (!class_exists("Report"))
{
	/**
	 * Class Report
	 *
	**/
	class Report
	{
		
		
		public function execute($parameters,$file) 
                {
		
		    $param = "";
		    if (is_array($parameters))
		    {
			foreach ($parameters as $pn => $pv)
			{
			  $param .= '&' . $pn . "<-" . $pv;
			}
		    }
		    
		    $filein = "PATH_FILE_IN".$file.".jasper";
		    $filetype = 'PDF';
		    $uniqid = uniqid(md5(uniqid("")));        
		    $fileout= $uniqid . "." . strtolower($filetype);
		    $pathout = "PATH_OUT ".$fileout;
		    $param = "report<-$filein".$param."&fileout<-".$pathout."&filetype<-".$filetype;
		    
		
		    $pathMJasper = "";
		    $pathJava = "/usr/lib/jvm/java-7-openjdk";
		    $classPath = "$pathMJasper/lib/jasperreports-4.7.0.jar:$pathMJasper/lib/jasperreports-fonts-4.7.0.jar:$pathMJasper/lib/jasperreports-javaflow-4.7.0.jar:$pathMJasper/lib/commons-beanutils-1.7.jar:$pathMJasper/lib/commons-collections-2.1.jar:$pathMJasper/lib/commons-digester-1.7.jar:$pathMJasper/lib/commons-javaflow-20060411.jar:$pathMJasper/lib/commons-logging-api-1.0.2.jar:$pathMJasper/lib/itext-1.3.1.jar:$pathMJasper/lib/ojdbc14.jar:$pathMJasper/lib/iReport.jar:$pathMJasper/lib/jxl-2.6.3.jar:$pathMJasper/lib/mysql-connector-java-5.0.6-bin.jar:$pathMJasper/";
		    
		    $jdbcDriver = "com.mysql.jdbc.Driver";
		    $jdbcDb = "jdbc:mysql://localhost/db";
		    $dbUser = "root";
		    $dbPass = "123";
		    
		
		
		    $cmd = $pathJava  . "/bin/java -Djava.awt.headless=true -classpath $classPath MJasper \"{$pathMJasper}\" \"{$param}\" \"{$dbUser}\" \"{$dbPass}\" \"{$jdbcDriver}\" \"{$jdbcDb}\"";
		    $cmd .= " 2> ../reports/log/log.txt";
		    
		    exec($cmd,$output);
		    
		    
                    $fp = fopen("../reports/log/log1.txt", "a");
		    $write_file = fwrite($fp, "\n\n".$cmd."\n".$output);
		    
                    fclose($fp);
			
			
		    
		    if (trim($output[0])=="end") {
		    
		      header("location: ../reports/temp/$fileout");
		    }
		
		}

        }
}


?>
