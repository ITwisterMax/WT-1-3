<link rel="stylesheet" href="style.css">

<?
function draw_calendar($month, $year) 
{
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar_tb">';

	// выводим дни недели
	$headings = array('Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс');
	$calendar .= '<tr class="calendar_row">';
	for($head_day = 0; $head_day <= 6; $head_day++)
    {
		$calendar .= '<th class="calendar_head';
		// выделяем выходные дни
		if ($head_day != 0)
			if (($head_day % 5 == 0) || ($head_day % 6 == 0))
				$calendar .= ' calendar_weekend';
		$calendar .= '">';
		$calendar .= '<div class="calendar_number">' . $headings[$head_day] . '</div>';
		$calendar .= '</th>';
	}
	$calendar .= '</tr>';

	// выставляем начало недели на понедельник
	$running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
	$running_day = $running_day - 1;
	if ($running_day == -1)
		$running_day = 6;
	
    // выставляем количество дней в месяце
	$days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
	$day_counter = 0;
	$days_in_this_week = 1;
	$dates_array = array();

	// первая строка календаря
	$calendar .= '<tr class="calendar_row">';

	// вывод пустых ячеек
	for ($x = 0; $x < $running_day; $x++)
    {
		$calendar .= '<td class="calendar_np"></td>';
		$days_in_this_week++;
	}

	// дошли до чисел, будем их писать в первую строку
	for($list_day = 1; $list_day <= $days_in_month; $list_day++)
    {
		$calendar .= '<td class="calendar_day';

		// выделяем выходные дни
		if ($running_day != 0)
			if (($running_day % 5 == 0) || ($running_day % 6 == 0))
				$calendar .= ' calendar_weekend';
		$calendar .= '">';

		// пишем номер в ячейку
		$calendar .= '<div class="calendar_number">' . $list_day . '</div>';
		$calendar .= '</td>';

		// дошли до последнего дня недели
		if ($running_day == 6)
        {
			// закрываем строку
			$calendar .= '</tr>';
			// если день не последний в месяце, начинаем следующую строку
			if (($day_counter + 1) != $days_in_month)
				$calendar .= '<tr class="calendar_row">';
			// сбрасываем счетчики
			$running_day = -1;
			$days_in_this_week = 0;
		}

		$days_in_this_week++;
		$running_day++;
		$day_counter++;
	}

	// выводим пустые ячейки в конце последней недели
	if ($days_in_this_week < 8)
		for($x = 1; $x <= (8 - $days_in_this_week); $x++)
		    $calendar .= '<td class="calendar_np"> </td>';
	$calendar .= '</tr>';
	$calendar .= '</table>';

	return $calendar;
}
?>

<h1>Календарь на год</h1>
<?
if (isset($_POST) and is_numeric($_POST["year"]))
{
    $months = Array(
		0 => 'Январь',
		1 => 'Февраль',
		2 => 'Март',
		3 => 'Апрель',
		4 => 'Май',
		5 => 'Июнь',
		6 => 'Июль',
		7 => 'Август',
		8 => 'Сентябрь',
		9 => 'Октябрь',
		10 => 'Ноябрь',
		11 => 'Декабрь'
	);

	for ($month = 1; $month <= 12; $month++)
    {?>
		<div class="calendar">
			<div class="calendar_title"><span class="calendar_month"><?= $months[$month - 1]?>,</span> <span class="calendar_year"> <?= $_POST["year"]?></span></div>
			<?
				echo draw_calendar($month, intval($_POST["year"]));
			?>
		</div>
	<?}
}
else
    echo 'Проверьте введенные данные!';
?>