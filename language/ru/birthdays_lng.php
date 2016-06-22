<?php
/**
*
* @package phpBB Extension - My Test
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'BIRTHDAYS'			=> 'Дни рождения',
	'NUMBER_DESCRIPTION'=> 'Номер Хар-ка',
	'NAME_BIRTHDAY'		=> 'Имя, день рождения',
	'TOTAL_ITEMS'		=> 'Всего: <strong>%d</strong>',
	'SORT_BY_NAME'		=> 'по имени',
	'SORT_BY_PHONE'		=> 'по номеру телефона',
	'PHONE_OCCUPATION'	=> 'Телефон, професия ...',
	'DATEPAY'			=> 'Дата оплаты',
	'PRIM'				=> 'Примечание',
	'SUMPAYS'			=> 'Итого:',
	'ALLUSER'			=> 'показать всех',
	'DATEBEGIN'			=> 'Дата начала',
	'DATEEND'			=> 'Дата окончания',
	'USER'				=> 'Активные пользователи',
	'INSERT'			=> 'Записать.',
	'GO_INSERT'			=> 'Записать и посмотреть оплату.',
	'PAYFACT'			=> 'Оплачено',
	'PAYQUESTION'		=> 'Потвердить оплату',
	'GOUPDATE'			=> 'Записать',
	'GODELETE'			=> 'Удалить',
	'NOTLOGINUSER'		=> 'Вы не зарегистрированы',
	'CASHTOMONTH'		=> 'Внимание, Вы уже отправляли информацию об оплате в текущем месяце',
	'ON_CHEK'			=> 'Спасибо за поддержку',
	'NON_CHEK'			=> 'Оплата не подтверждена',
	'LOGIN_EXPLAIN_VIEW_CONTACTS'    => 'Вы должны быть авторизованы для просмотра этой страницы.',
	'NIC_NAME'			=> 'Поиск по нику',
));