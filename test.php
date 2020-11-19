<?php


echo IntlChar::charName('!') . PHP_EOL; // EXCLAMATION MARK

echo (IntlChar::isWhitespace(' ') ? 'Yes' : 'No') . PHP_EOL; // Yes




/*

$varName = 'name';

$name = 'Khaled Alam';


echo ${$varName};




// declare(strict_types = 1);


function age(int $age)
{
    return $age;
}


echo age(10) . PHP_EOL;   // 10
echo age(10.5) . PHP_EOL; // 10




$myName = new class('Khaled Alam') {
    public function __construct(string $name)
    {
        echo $name;
    }
};

function sort1($a, $b) : int
{
    if( $a == $b )
    return 0;
    
    if( $a < $b )
        return -1;

    return 1;
}



function sort2($a, $b) : int
{
    return $a <=> $b;
}


echo(sort1(10, 15));
echo(sort1(15, 10));
echo(sort1(10, 10));


echo(sort2(10, 15));
echo(sort2(15, 10));
echo(sort2(10, 10));
*/
