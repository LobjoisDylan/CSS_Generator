<?php 

function recursive($int)
{
	while($int <= 10)
	{
		echo recursive($int++);
	}
}

recursive(5); 

function my_recursive_readdir($dir)
{
    $tree = glob(rtrim($dir, '/') . '/*');
    if (is_array($tree)) 
    {
        foreach($tree as $file) 
        {
            if (is_dir($file))
            {
                print_r($file . PHP_EOL);
                my_recursive_readdir($file);
            }
            elseif (is_file($file)) {
                print_r($file . PHP_EOL);
            }
        }
    }
}
my_recursive_readdir("./pictures");

/*function my_glob($array)
{
	$files = glob($array . "*.png");
  
	foreach($files as $array)
	{ 
  		echo $array . "\n";
	}
}
my_glob("./pictures/"); */