<?php
class TblPagignationClass
{
	var  $Limit;                  // int(11)  not_null primary_key auto_increment
    var  $Offset;               // int(11)  not_null
	var  $NumofRows ;
    var  $FileName;            //
	var  $IdentifierVariable ; // parent=$Template_Parent
	var  $Previous ;
	var  $Next ;
    var  $Get;
	
	function TblPagignationClass($Previous,$Next,$Limit,$Get = array())
		{
			$this->Limit=$Limit ;
			$this->Previous=$Previous ;
			$this->Next=$Next ;
            $this->Get=$Get ;
		}
    function SetOffset($Offset)
		{
			$this->Offset=$Offset ;
		}
	function SetNumofRows($NumofRows)
		{
			$this->NumofRows=$NumofRows ;
		}
	function SetFileName($FileName)
		{
			$this->FileName=$FileName ;
		}
	function SetIdentifierVariable($IdentifierVariable)
		{
			if($IdentifierVariable=="")
				$this->IdentifierVariable="1=1" ;
			else
				$this->IdentifierVariable=$IdentifierVariable ;
		}

	function CreatePagignationData()
		{
			$navigation="" ;
			if($this->Offset!=0)
				{
					$prevoffset=$this->Offset-$this->Limit;
					$navigation.= "<a href='".$this->FileName."?offset=$prevoffset&numrows=$this->NumofRows&$this->IdentifierVariable' class='adminmenu'><i class='icon-prev'></i></a> &nbsp;";
				}
			$pages=floor($this->NumofRows/$this->Limit);
			if($this->NumofRows%$this->Limit)
				{
					$pages++;
				}
			if($this->NumofRows>$this->Limit)
				{
					$pgoffset=0;
					$pg=$this->Offset/$this->Limit;
					for($j=1;$j<=$pages;$j++)
						{
								if($j>1)$pgoffset=$pgoffset+$this->Limit;
								if($j==$pg+1) 
									{
										 $navigation.= "<span>".$j."</span>&nbsp;&nbsp;";
									}
								else{
                                        $get_link = '';
                                        if(count($this->Get)){
                                            foreach($this->Get as $key => $val)
                                                if($key != 'offset' && $key != 'numrows')$get_link .= "&$key=$val";
                                        }
                                        $navigation.="<a href='".$this->FileName."?offset=$pgoffset&numrows=$this->NumofRows&$this->IdentifierVariable".$get_link."' class='adminmenu'>".$j."</a> &nbsp;";
									}
						}
								
				}
			if(($this->Offset+$this->Limit)<$this->NumofRows)
				{
					$newoffset=$this->Offset+$this->Limit;
					$navigation.= "<a href='".$this->FileName."?offset=$newoffset&numrows=$this->NumofRows&$this->IdentifierVariable' class='adminmenu' ><i class='icon-next'></i></a>";
				}
				return $navigation ;
		}
}


/* How to Use it  

// Set the offset 
if(isset($_GET['offset']))
$offset=$_GET['offset'];
else
$offset=0;
// Set limit record per page
$limit=5 ;

/// ininiatially  find out the total no of records 
 $sql="select * from gridnews ";
 $rs= mysql_query($sql) or die(mysql_error());
  $num=mysql_num_rows($rs) or die(mysql_error());
  						// Initialise the pagination class 
 						$TblPagignationClass = new  TblPagignationClass('Previous','Next',$limit);
						$TblPagignationClass->SetOffset($offset) ;
						$TblPagignationClass->SetNumofRows($num) ;
						$TblPagignationClass->SetFileName($_SERVER['PHP_SELF']) ;
						$TblPagignationClass->SetIdentifierVariable("orderby=news_id") ;
						$Template_Pagignation_Data=$TblPagignationClass->CreatePagignationData() ;
 // now fetch the record you wish to display 
 $sql="select * from gridnews limit $offset,$limit";
 $rs= mysql_query($sql) or die(mysql_error());


// Display the pagination 
echo "$Template_Pagignation_Data" ; ?></td>

*/

?>