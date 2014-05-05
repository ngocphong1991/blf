<?PHP
/*
Written and contributed by
Alex Stapleton,
Andy Doctorow,
Tarakan,
Bill Zeller,
Vijay "Cyberax" Bhatter
traB
This code is released into the public domain
*/

define('GOOGLE_MAGIC', 0xE6359A60);

class google_checksum{

var $checksum;

function google_checksum(){
$this->checksum='';
}

//unsigned shift right
function zeroFill($a, $b){
$z = hexdec(80000000);
if ($z & $a)
{
$a = ($a>>1);
$a &= (~$z);
$a |= 0x40000000;
$a = ($a>>($b-1));
}
else
{
$a = ($a>>$b);
}
return $a;
}

function mixOld($a,$b,$c) {
$a -= $b; $a -= $c; $a ^= ($this->zeroFill($c,13));
$b -= $c; $b -= $a; $b ^= ($a<<8);
$c -= $a; $c -= $b; $c ^= ($this->zeroFill($b,13));
$a -= $b; $a -= $c; $a ^= ($this->zeroFill($c,12));
$b -= $c; $b -= $a; $b ^= ($a<<16);
$c -= $a; $c -= $b; $c ^= ($this->zeroFill($b,5));
$a -= $b; $a -= $c; $a ^= ($this->zeroFill($c,3));
$b -= $c; $b -= $a; $b ^= ($a<<10);
$c -= $a; $c -= $b; $c ^= ($this->zeroFill($b,15));

return array($a,$b,$c);
}

function mix($a,$b,$c) {
$a -= $b; $a -= $c; $this->toInt32($a); $a = (int)($a ^ ($this->zeroFill($c,13)));
$b -= $c; $b -= $a; $this->toInt32($b); $b = (int)($b ^ ($a<<8));
$c -= $a; $c -= $b; $this->toInt32($c); $c = (int)($c ^ ($this->zeroFill($b,13)));
$a -= $b; $a -= $c; $this->toInt32($a); $a = (int)($a ^ ($this->zeroFill($c,12)));
$b -= $c; $b -= $a; $this->toInt32($b); $b = (int)($b ^ ($a<<16));
$c -= $a; $c -= $b; $this->toInt32($c); $c = (int)($c ^ ($this->zeroFill($b,5)));
$a -= $b; $a -= $c; $this->toInt32($a); $a = (int)($a ^ ($this->zeroFill($c,3)));
$b -= $c; $b -= $a; $this->toInt32($b); $b = (int)($b ^ ($a<<10));
$c -= $a; $c -= $b; $this->toInt32($c); $c = (int)($c ^ ($this->zeroFill($b,15)));
return array($a,$b,$c);
}

//converts a string into an array of integers containing the numeric value of the char
function strord($string){
for($i=0;$i<strlen($string);$i++) {
$result[$i] = ord($string{$i});
}
return $result;
}

// calculates the google checksum
function GoogleCH($url, $length=null, $init=GOOGLE_MAGIC){

if(is_null($length)) {
$length = sizeof($url);
}
$a = $b = 0x9E3779B9;
$c = $init;
$k = 0;
$len = $length;
while($len >= 12) {
$a += ($url[$k+0] +($url[$k+1]<<8) +($url[$k+2]<<16) +($url[$k+3]<<24));
$b += ($url[$k+4] +($url[$k+5]<<8) +($url[$k+6]<<16) +($url[$k+7]<<24));
$c += ($url[$k+8] +($url[$k+9]<<8) +($url[$k+10]<<16)+($url[$k+11]<<24));
$mix = $this->mix($a,$b,$c);
$a = $mix[0]; $b = $mix[1]; $c = $mix[2];
$k += 12;
$len -= 12;
}

$c += $length;
switch($len) /* all the case statements fall through */
{
case 11: $c+=($url[$k+10]<<24);
case 10: $c+=($url[$k+9]<<16);
case 9 : $c+=($url[$k+8]<<8);
/* the first byte of c is reserved for the length */
case 8 : $b+=($url[$k+7]<<24);
case 7 : $b+=($url[$k+6]<<16);
case 6 : $b+=($url[$k+5]<<8);
case 5 : $b+=($url[$k+4]);
case 4 : $a+=($url[$k+3]<<24);
case 3 : $a+=($url[$k+2]<<16);
case 2 : $a+=($url[$k+1]<<8);
case 1 : $a+=($url[$k+0]);
/* case 0: nothing left to add */
}
$mix = $this->mix($a,$b,$c);
/*-------------------------------------------- report the result */

return $mix[2];
}

// converts an array of 32 bit integers into an array with 8 bit values. Equivalent to (BYTE *)arr32
function c32to8bit($arr32){
for($i=0;$i<count($arr32);$i++) {
for ($bitOrder=$i*4;$bitOrder<=$i*4+3;$bitOrder++) {
$arr8[$bitOrder]=$arr32[$i]&255;
$arr32[$i]=zeroFill($arr32[$i], 8);
}
}
return $arr8;
}

// gets the google checksum!
function getGoogleChecksum($url){

$url="info:"."http://".str_replace('http://','',$url);

$tmp_ch=$this->strord($url);

$this->checksum=sprintf("%u", $this->GoogleCH($tmp_ch));

return $this->checksum;
}

// converts 64 bit 2 32 bit
function toInt32(& $x){
$z = hexdec(80000000);
$y = (int)$x;
// on 64bit OSs if $x is double, negative ,will return -$z in $y
// which means 32th bit set (the sign bit)
if($y==-$z&&$x<-$z){
$y = (int)((-1)*$x);// this is the hack, make it positive before
$y = (-1)*$y; // switch back the sign
//echo "int hack <br>";
}
$x = $y;
}

}

?>


<?
$checksum= new google_checksum();

$ch="6".$checksum->getGoogleChecksum('yahoo.com');
echo $ch;
?>