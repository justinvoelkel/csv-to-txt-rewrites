<?php

$dir = new DirectoryIterator(__DIR__.'/csv');
$output = __DIR__.'/output/'.substr(md5(rand()), 0, 7).'.txt';
fopen($output, "w");
foreach($dir as $file)
{
	if(!$file->isDot() && ($csv = fopen(__DIR__.'/csv/'.$file->getFilename(),"r")))
	{
		while($data = fgetcsv($csv))
		{
			$data[0] = 'RewriteRule ^'.$data[0].'$';
			$data[1].= ' [R=301,L]';

			$current = file_get_contents($output);
			$current.= (string) $data[0].'		'.$data[1]."\r\n";

			file_put_contents($output,$current);
		}

		fclose($csv);
	}
}