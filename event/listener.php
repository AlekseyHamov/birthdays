<?php
/**
*
* @package paywindow
* @copyright (c) 2014 aleksey
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace aleksey\birthdays\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
/**
* Assign functions defined in this class to event listeners in the core
*
* @return array
* @static
* @access public
*/
	/** @var \phpbb\db\driver\driver_interface */
    protected $db;	
	/** @var \phpbb\user */
	protected $user;
	/** @var \phpbb\config\config */
	protected $config;
	/** @var \phpbb\config\db_text */
	protected $config_text;
	/** @var \phpbb\template\template */
	protected $template;
	protected $phpbb_root_path;

	
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'load_language_on_setup',
			'core.page_footer'						=> 'content_footer',
		);
	}
	/**
	* Constructor
	*/
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\template\template $template, $phpbb_root_path, $table_prefix )
	{
		$this->db = $db;
        $this->user = $user;
		$this->config = $config;
		$this->text = $config_text;
		$this->template = $template;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->table_prefix = $table_prefix;
		define(__NAMESPACE__ . '\USER_TABLE', $this->table_prefix . 'users');

        
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'aleksey/birthdays',
			'lang_set' => 'birthdays_lng',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_page_header_link($event)
	{
		$this->template->assign_vars(array(
			'U_HOVER_BIRTHDAYS' => append_sid("{$this->phpbb_root_path}birthdays"),
		));
	}
   
    public function content_footer()
	{
		$countdayadd=$this->config['before_day'];
		$dayend=date('z',time()+((60*60*24*$countdayadd)));
		$daynow=date('z',time());
		$sql = 'SELECT user_id, username, user_avatar, user_avatar_type , STR_TO_DATE(user_birthday,"%d-%m-%Y") as user_birthday, NOW() 
            FROM ' . USER_TABLE .' 
			WHERE (UNIX_TIMESTAMP()- user_lastpost_time)<(60*60*24*'.$this->config['active_post_begin_day'].') 
            and DAYOFYEAR(STR_TO_DATE(user_birthday,"%d-%m-%Y")) between '.$daynow.' and '.$dayend .' 
			order by DAYOFYEAR(STR_TO_DATE(user_birthday,"%d-%m-%Y"))' ;
        $result = $this->db->sql_query($sql);
        $BIRTHDAYBOTTON='';
        while ($row = $this->db->sql_fetchrow($result))
        {		$birthday=date('m-d',strtotime($row['user_birthday']));
				$birthday=date('Y-',time()).$birthday;
				$birthday = date('z',strtotime($birthday))-$daynow;
				$birthdaystr=date('m-d',strtotime($row['user_birthday']));
				$birthdaystr=date('Y-',time()).$birthdaystr;
				$birthdaystr= (string)(date('z',strtotime($birthdaystr))-$daynow);
                $yarh=date('Y',time())-date('Y',strtotime($row['user_birthday']));

				$a=substr($birthday,strlen($birthday)-1,1); 
		        if($a==1) {$d="день"; }
        		if($a==2 || $a==3 || $a==4) {$d="дня"; }
        		if($a==5 || $a==6 || $a==7 || $a==8 || $a==9 || $a==0) {$d="дней";}
                if(strlen($birthday)>1 && substr($birthday,0,1)==1) {$d="дней";}

                $int=$yarh;
                if ( $int > 20 ) {
                    $int = substr( $int, -1 );
                   }
                switch ($int) {
                    case 0:
                        $y= ' лет';
                    break;
                    case 1:
                        $y= ' год';
                    break;
                    case ( $int >= 2 && $int <= 4 ):
                        $y= ' года';
                    break;
                    case ( $int >= 10 && $int <= 20 ):
                        $y= ' лет';
                    break;
                    default:
                        $y= ' лет';
                    break;
                  }
                  
			    if ($birthday>1)
				  {
						$this->template->assign_block_vars('rowbd', array(
							'ID' 				=> $row['user_id'],
							'NAME'				=> get_user_avatar($row['user_avatar'], $row['user_avatar_type'], 25, 'auto').'</br>'.$row['username'],
							'BIRTHDAY'				=>'Через '.($birthday).' '.$d.'  исполнится '.$yarh.$y,
						));
					}
			    if ($birthday==1)
				  {
						$this->template->assign_block_vars('rowbd', array(
							'ID' 				=> $row['user_id'],
							'NAME'				=> get_user_avatar($row['user_avatar'], $row['user_avatar_type'], 25, 'auto').'</br>'.$row['username'],
							'BIRTHDAY'				=>'Завтра исполнится '.$yarh.$y,
						));
					}
				if ($birthday==0)
				  {
						$this->template->assign_block_vars('rowbd', array(
							'ID' 				=> $row['user_id'],
							'NAME'				=> get_user_avatar($row['user_avatar'], $row['user_avatar_type'], 25, 'auto').'</br>'.$row['username'],
							'BIRTHDAY'			=>'Сегодня исполнилось '.$yarh.$y,
						));
                        $BIRTHDAYBOTTON=$row['username'].' сегодня исполнилось '.$yarh.$y;
						$url_avatar=get_user_avatar($row['user_avatar'], $row['user_avatar_type'], '', '');
						$BIRTHDAYUSER=$row['username'];
					}
                    	
        }
			$url_avatar=strstr($url_avatar, '"./download/file.php');
			$url_avatar=strstr($url_avatar, 'alt=', true);
			$height_image_logo=(isset($this->config['height_image_logo'])) ? $this->config['height_image_logo'] : '110px' ;	
			if ($height_image_logo=='')
			{
				$height_image_logo='110px';	
			}
			$scriptmenu="window.onload = function() {
	    	var style = document.getElementsByClassName('site_logo')[0].style;
			style.backgroundImage='url({$url_avatar})';
	   		style.backgroundSize='cover';
			style.height='{$height_image_logo}';
			style.width='{$height_image_logo}';
			style.backgroundPosition='center';
			var span = document.getElementsByClassName('site_logo')[0];
			span.innerHTML = '<strong>".$BIRTHDAYUSER." С днем родженья !</strong>';
			}";
        if ($BIRTHDAYBOTTON!='')
        {                        
            $this->template->assign_var('BIRTHDAYBOTTON', $BIRTHDAYBOTTON);
			if ($url_avatar!='')
			{
				$this->template->assign_var('SCRIPTMENU', $scriptmenu);					
			}
        }else
        {
            $this->template->assign_var('BIRTHDAYBOTTON', 'Дни рождения');
        }
		//$this->template->assign_var('ALLUSER', $sql.'  '.$day);
	}
	public function birthdays_botton()
	{
		echo('тест');
		if(isset($_POST['birthdaysbotton']))
		{
			header('Location: /cheklistpay');
 //           $cookietime = time() + (60*60*1); // освободим админа на час
 //           $this->user->set_cookie('admincookie', time(), $cookietime);      
		}
	}
}