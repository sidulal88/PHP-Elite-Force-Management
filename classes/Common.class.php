<?php
class Common
{
	public static function errorHandler($message2Display, $displayMsgOnScreen, $message2WriteInFile, $scriptName = '', $lineNumber = '')
	{
		if($message2WriteInFile!='')
		{
			//write original error message to the file
			$fileHandler = fopen(ROOT_DIR.'/'.LOG_DIR.'/'.ERROR_LOG, 'a');
			fwrite($fileHandler, $message2WriteInFile.' in '.$scriptName.' on line # '.$lineNumber."\r\n\r\n");
			fclose($fileHandler);
		}
			
		if(($message2Display!='' && $displayMsgOnScreen==1) || PROJECT_IN_DEVELOPMENT == TRUE)
		{
			return $message2Display.' in '.$scriptName.' on line # '.$lineNumber;
		}		
	}
	
	public static function isLogedIn()
	{
		if(@$_SESSION['adminId']=='') {
				
		$_SESSION['PrevPage'] = CURRENT_FILE_NAME;
		echo "<script type=\"text/javascript\">location.replace(\"../index.php?msg=Opp! You are logged out.Please login First.\");</script>";
		} else {
			$sql = "SELECT id FROM ".TABLE_PREFIX."admin WHERE id='".$_SESSION['adminId']."' AND email='".$_SESSION['adminEmail']."'";
			$result = Database::query($sql, 2, __FILE__, __LINE__);
			if($result->num_rows <1) {
				exit('Sorry, you are not signed in.<br />Please click <a href="../index.php">here</a> to login.');
			}
		}
	}
	
	public static function logout()
	{
		session_unset();
		$path = LOGGED_OUT_PATH;
		echo "<script type=\"text/javascript\">location.replace(\"index.php?msg=log_out\");</script>";
	}
	
	public static function processStatus($action, $curStatus, $dbTable, $tabField, $tabKey, $keyValue, $container)
	{
		/*
			$action could be display/edit
			$curStatus is current status
			$container is, where ajax will be loaded while change status
		*/
		
		if($action=='display') {
			if($curStatus=='active' || $curStatus=='yes') {
				$disMSG = INACTIVE;
				$setStatus = 'inactive';
				$icon = '../images/active.jpg';
			} else if($curStatus=="inactive" || $curStatus=="no") {
				$disMSG = ACTIVE;
				$setStatus = 'active';
				$icon = '../images/inactive.jpg';
			}
			
			if(@$setStatus!='') {
				$icon = '<a href="#" onclick="conf=window.confirm(\''.STATUS_CHANGE_MSG.' '.strtoupper(str_replace("e", '', $disMSG)).' '.STATUS_CHANGE_MSG_LAST.'\'); if(conf==true) { ajaxLoader(\'ajaxLoaderAdmin.php?action=changeStatus&setStatus='.$setStatus.'&dbTable='.$dbTable.'&tabField='.$tabField.'&tabKey='.$tabKey.'&keyValue='.$keyValue.'&container='.$container.'\', \''.$container.'\', \'Loading...\'); return false; }"><img title="Click here to change it to '.$setStatus.'" border="0" src="'.$icon.'" width="22" height="22" /></a>';
			
				//echo "hhhh".$icon;
			//	die();
			} else {
				$icon = '<img title="Pending" border="0" src="../images/pending.jpg" width="22" height="22" />';
			}
			return $icon;
		} else if($action=='edit') {
			$sql = "UPDATE {$dbTable} SET {$tabField}='$curStatus' WHERE {$tabKey}='$keyValue'";
			$result = Database::query($sql, 2, __FILE__, __LINE__);
			if($result) {
				echo self::processStatus("display", $curStatus, $dbTable, $tabField, $tabKey, $keyValue, $container);
			} else {
				echo "Functional error.";
			}
		}
	}//activeStatus
	
		
	public static function converToMysqlDateTime($postDate)
	{
		$mysql_date = date("Y-m-d H:i:s", strtotime($postDate));
		return $mysql_date;
	}
	
		
	public static function converToMysqlDate($postDate)
	{
		$mysql_date = date("Y-m-d", strtotime($postDate));
		return $mysql_date;
	}
	
	
	
	public static function converToDisplayDate($mysqlDate)
	{
		if($mysqlDate!='')
		{
			$display_date = date("d-m-Y", strtotime($mysqlDate));
		}
		return $display_date;
	}
	
	
	public static function converToDisplayDateTime($mysqlDate)
	{
		if($mysqlDate!='')
		{
			$display_date = date("d-m-Y H:i:s", strtotime($mysqlDate));
		}
		return $display_date;
	}
	
	
	
	public static function banglaDay($dayOfWeek)
	{
		$bangla_days = array("Sun"=>SUN, "Mon"=>MON, "Tue"=>TUE, "Wed"=>WED, "Thu"=>THU, "Fri"=>FRI, "Sat"=>SAT);
		$return = $bangla_days[$dayOfWeek]; 
		return $return;
	}
	
	
	public static function displayMsg()
	{
		if(isset($_GET['msg'])) {
			echo $_GET['msg'];
		}
	}
		
	public static function simpleListBox($name, $content, $recSelected, $label)
	{
		echo '<select id="'.$name.'" name="'.$name.'">
			<option value="">'.$label.'</option>';
			foreach($content as $key => $value) {
				echo '<option value="'.$key.'"';
				if($recSelected==$key) {
					echo ' selected="selected"';
				}
				echo '>'.$value.'</option>';
			}
        echo '</select>';
	}
	
 
	public static function systemStatus()
	{

		$arrayList = array('active' => 'Active', 'inactive' => 'Inactive');
		return $arrayList;
	}
	
 
 
   public function pagination($query, $total, $per_page = 10,$page = 1, $url = '?'){        
/*    	$query = "SELECT COUNT(*) as `num` FROM {$query}";
    	$row = mysql_fetch_array(mysql_query($query));
    	$total = $row['num'];
*/        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		$firstPage = 1;
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                   $pagination .= "<li class='details'></li>";
				   //Page $page of $lastpage</li>

    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
				if ($page == 1)
				{
				$pagination.= "<li><a class='current'>".FIRST_PAGE."</a></li>";
				$pagination.= "<li><a class='current'>".PREV_PAGE."</a></li>";
				}
				else
				{
				$pagination.= "<li><a href='{$url}page=$firstPage'>".FIRST_PAGE."</a></li>";
				$pagination.= "<li><a href='{$url}page=$prev'>".PREV_PAGE."</a></li>";
				}			
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='current'>".self::convertToBanglaNumber($counter)."</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}page=$counter'>".self::convertToBanglaNumber($counter)."</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>".self::convertToBanglaNumber($counter)."</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>".self::convertToBanglaNumber($counter)."</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>".self::convertToBanglaNumber($lpm1)."</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>".self::convertToBanglaNumber($lastpage)."</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}page=1'>".self::convertToBanglaNumber(1)."</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>".self::convertToBanglaNumber(2)."</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>".self::convertToBanglaNumber($counter)."</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>".self::convertToBanglaNumber($counter)."</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>".self::convertToBanglaNumber($lpm1)."</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>".self::convertToBanglaNumber($lastpage)."</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}page=1'>".self::convertToBanglaNumber(1)."</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>".self::convertToBanglaNumber(2)."</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>".self::convertToBanglaNumber($counter)."</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>".self::convertToBanglaNumber($counter)."</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}page=$next'>".NEXT_PAGE."</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>".LAST_PAGE."</a></li>";
    		}else{
    			$pagination.= "<li><a class='current'>".NEXT_PAGE."</a></li>";
                $pagination.= "<li><a class='current'>".LAST_PAGE."</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
    } 
	
	

public static function generateMenuArray($id=0, &$output, &$child, $maxlevel=10, $level=0,$previous_level=0,$level_separator='===' )
{
		$level_str = '';
		for($i=0;$i<$level;$i++)
		  $level_str .= $level_separator;
			
	   if ($child[$id] && $level <= $maxlevel)
		{
			
			foreach ($child[$id] as $v)
			{
			
				$id = $v['unit_id'];
				$v['level'] = $level;
				$v['level_str'] = $level_str;
        		if(count($child[$id]))
        		{
        			$v['has_child'] = 1;
        			$output[]= $v;
        		}
				else
				{
					$v['has_child'] = 0;
					$output[]= $v;
				}
				 self::generateMenuArray( $id, $output, $child, $maxlevel, $level+1,$level,&$level_separator );
			}
		}
		return $output;
}


function buildChild($symtemMenu,$parent_id='sub_under')
{
		$child = array();
		foreach ( $symtemMenu as $v )
		{
			$pt = $v[$parent_id];
			$list = @$child[$pt] ? $child[$pt] : array();
			array_push( $list, $v );
			$child[$pt] = $list;
		}

		return array_filter($child);
}
//function buildNav($parent, &$parent_list, $table_name, $primaryKey, $ForeignKey)

function buildParent($parent, &$parent_list, $tableName, $primaryKey, $ForeignKey)
{
	$sql = "SELECT * from $tableName WHERE $primaryKey='$parent'";
	$show = Database::query($sql, 1, __FILE__, __LINE__);
	$ct = $show[$primaryKey];
	$pt = $show[$ForeignKey];
	$parent_list[$ct] =  $show;
 	if($pt)
	{
		self::buildParent($pt, $parent_list, $tableName, $primaryKey, $ForeignKey);
	}
	return $parent_list;
	
}


//main_catid
function buildSingleChild($parent, &$child_list, $tableName, $ForeignKey, $primaryKey)
{
	$sql = "SELECT * from $tableName WHERE $ForeignKey='$parent' AND status='active'";
	$show = Database::query($sql, 1, __FILE__, __LINE__);
	$ct = $show[$ForeignKey];
	$pt = $show[$primaryKey];
	$child_list[$ct] =  $show;
 	if($pt)
	{
		self::buildSingleChild($pt, $child_list, $tableName, $ForeignKey, $primaryKey);
	}
	//return $child_list;
	
	foreach($child_list as $mdata):
			echo $mdata['name'].'<br />';
	endforeach;
	
}


function userType($userType)
{
	$Type = array('admin' => ADMIN, 'user' => GEN_USER);
	return $Type[$userType]; 
}

function Eng2BanStatus($engStatus)
{
	$statusList = array('active' => ACTIVE, 'inactive' => INACTIVE);
	
	return $statusList[$engStatus]; 
}


function BanPosition()
{
	$positionList = array('top' => TOP_POSITION, 'left' => LEFT_POSITION, 'bottom' => BOTTOM_POSITION, 'right' => RIGHT_POSITION);
	
	return $positionList; 
}


function ArticlePosition()
{
	$positionList = array('middle' => MIDLE_POSITION, 'right' => RIGHT_POSITION);
	
	return $positionList; 
}


function convertToBanglaNumber($englishNumber)
{
	$englishNumber = (string) $englishNumber;
	$banglaNumber = '';
	$indexLimit = strlen($englishNumber);
	for($i=0; $i<$indexLimit; $i++)
	{
		switch($englishNumber[$i])
		{
			case "0":
			$banglaNumber .= '&#2534;';
			break;
			case "1":
			$banglaNumber .= '&#2535;';
			break;
			case "2":
			$banglaNumber .= '&#2536;';
			break;
			case "3":
			$banglaNumber .= '&#2537;';
			break;
			case "4":
			$banglaNumber .= '&#2538;';
			break;
			case "5":
			$banglaNumber .= '&#2539;';
			break;
			case "6":
			$banglaNumber .= '&#2540;';
			break;
			case "7":
			$banglaNumber .= '&#2541;';
			break;
			case "8":
			$banglaNumber .= '&#2542;';
			break;
			case "9":
			$banglaNumber .= '&#2543;';
			break;
			default:
			$banglaNumber .= $englishNumber[$i];
			break;
		}
	}
	return $englishNumber;
}


//---------------------------Bangla Month-----------------------------------

function convertToBanglaDate($engDate)
{
	$date = explode("-", $engDate);
	$day_number=self::convertToBanglaNumber($date[2]);
	$bangla_month=self::bangla_month($date[1]);
	$bangla_year=self::convertToBanglaNumber($date[0]);
	$bangla_date=$day_number.' '.$bangla_month.' '.$bangla_year;
	return $engDate;
	
}
//---------------------------Bangla Month-----------------------------------

function bangla_month($int)
{
	if(count($int) > 2 && ($int<10))
	{
		$int	=	"0".$int;
	}
				
	$bangMonths = array(''=>'', '01'=>JANUARY,'02'=>FEBRUARY,'03'=>MARCH,'04'=>APRIL,'05'=>MAY,'06'=>JUNE,'07'=>JULY,'08'=>AUGUST,'09'=>SEPTEMBER,'10'=>OCTOBER,'11'=>NOVEMBER,'12'=>DECEMBER);
		
	return $bangMonths[$int];
}
//---------------------------Bangla Month-----------------------------------

function bangla_madrasah_type()
{
	$typeList = array(1 => EVETADAYE, 2 => DAKHIL, 3 => ALIM, 4 => FAZIL, 5 => KAMIL, 6 => HIFZZ, 7 => KAOMI);
	
	return $typeList; 
}

function bangla_institution_type()
{
	$typeList = array(1 => GOVERNMENT, 2 => PRIVATE_TYPE, 3 => SEMI_GOVERNMENT);
	
	return $typeList; 
}


function bangla_designations()
{
	$typeList = array(1 => PRINCIPALE, 2 => HEAD_MASTER, 3 => SUPERIONDENT, 4=>OTHERS);
	
	return $typeList; 
}


function bangla_campus_facility()
{
	$typeList = array(1 => LIBRARY, 2 => FIELD);
	
	return $typeList; 
}


function co_education_activities()
{
	$typeList = array(1 => LANGUAGE_CLUB, 2 => DEBATE_CLUB, 3 => ABBRITI, 4 => CULTURAL, 5 => PHYSICAL, 6 => SCOUT, 7 => SCIENCE_CLUB, 8 => MATH_CLUB, 9 => OTHERS);
	
	return $typeList; 
}

//---------------------------Bangla Day-----------------------------------

function displayRecordStatus($totalRec, $ViewStart, $ViewEnd)
{
	$status = ($totalRec >= 1)?TOTAL_RECORD.'&nbsp;'.self::convertToBanglaNumber($totalRec).".&nbsp;&nbsp;".VIEW.'&nbsp;&nbsp;FROM&nbsp;&nbsp;'.self::convertToBanglaNumber($ViewStart).'&nbsp;'.TO.'&nbsp;'.self::convertToBanglaNumber($ViewEnd).'.&nbsp;':'<p class="alert">'.NO_RECORD_FOUND.'</p>';
	return $status;
}

function getDesiredLengthString($str,$desiredNumber)
{
	$array_str = explode(" ", $str); 
	if(isset($array_str[$desiredNumber])) 
	{ 
		return implode(" ",array_slice($array_str, 0, $desiredNumber)); 
	} 
}

function str_word_count_utf8($str) {
	
	$array_str = explode(" ", $str); 
	return count($array_str); 
	
  //return count(preg_split('~[^\p{L}\p{N}\']+~u',$str));
}


	public function last_update_on($table){
	
		$sql = "SELECT _modified FROM $table ORDER BY _modified DESC LIMIT 1";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['_modified'];
	
	}



}
?>
