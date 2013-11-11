<?php
/** 
 * ddGetMultipleField.php
 * @version 2.18 (2013-11-11)
 * 
 * A snippet for separated by delimiters data output.
 * The fields formed by the mm_ddMultipleFields widget values ooutput gets more convinient with the snippet.
 * 
 * @uses The library modx.ddTools 0.10.
 * @uses The snippet ddGetDocumentField 2.4 might be used if field getting is required.
 * @uses The snippet ddTypograph 1.4.3 (if typographing is required).
 * 
 * @param $field {separated string} - String contains values with delimeters. @required
 * @param $getField {string} - The document field name getting of which is required. Default: —.
 * @param $getId {integer} - ID of the document the field value of which is required to be obtained. Default: —.
 * @param $splY {string; regexp} - Input data rows delimiter. Default: '||'.
 * @param $splX {string; regexp} - Input data columns delimiter. Default: '::'.
 * @param $num {integer} - Row number to start. Default: 0.
 * @param $vals {separated string} - Filters to apply to columns values. Thus, if the parameter equals '0::a||0::b||1::1', only the rows containing 'a' or 'b' in the zero column and '1' in the first one will be return. Zero column index can be skipped, e.g. 'a||b||1::1' == '0::a||0::b||1::1'. Default: ''.
 * @param $count {integer; 'all'} - Number of rows to return. Default: 'all'.
 * @param $colNum {comma separated string; 'all'} - Numbers of columns to return. Default: 'all'.
 * @param $sortDir {'ASC'; 'DESC'; 'RAND'; 'REVERSE'; ''} - Sorting direction. Default: ''.
 * @param $sortBy {comma separated string} - Column number (enumeration starts from zero) to sort from. Values must be separated by commas if sorting is multiple (example: '0,1'). Default: '0'.
 * @param $glueY {string} - Output data rows delimiter. Default: ''.
 * @param $glueX {string} - Output data columns delimiter. Default: ''.
 * @param $removeEmptyRows {0; 1} - Rmoving empty rows status. Default: 1. 
 * @param $removeEmptyCols {0; 1} - Rmoving empty columns status. Default: 1.
 * @param $typographing {0; 1} - Typographing status. Default: 0.
 * @param $urlencode {0; 1} - URL encoding status. Default: 0.
 * @param $format {'JSON'; 'array'; 'html'} - Format being returned. Default: 'html'.
 * @param $tplY {string: chunkName} - Row output template (the format parameter must be empty). Available placeholders: [+row_number+] (returns row number starting from 1), [+total+] (the number of all rows), [+resultTotal+] (the number of outputted rows), [+val0+],[+val1+],…. Default: ''.
 * @param $tplX {comma separated string: chunkName; 'null'} - List of templates for columns output separated by comma. The last template would be applied to other rows if the number of templates was less than the number of columns. The 'null' value — without a template. Available placeholder: [+val+]. Default: ''.
 * @param $tplWrap {string: chunkName} - Wrapper template. Available placeholders: [+wrapper+], [+total+] (the number of all rows), [+resultTotal+] (the number of outputted rows). Default: ''.
 * @param $placeholders {separated string} - Additional data which has to be transferred (available only in tplWrap!). Format: string separated by '::' betweeb key-value pair and '||' between pairs. Default: ''.
 * @param $totalPlaceholder {string} - The name of an external placeholder to output the total number of rows into. The total number does not return if the parameter is empty. Default: ''.
 * @param $resultToPlaceholder {0; 1} - Add the obtained result to the placeholder 'ddGetMultipleField' instead of return. Default: 0.
 * 
 * @link http://code.divandesign.biz/modx/ddgetmultiplefield/2.18
 * 
 * @copyright 2013, DivanDesign
 * http://www.DivanDesign.biz
 */

//Если задано имя поля, которое необходимо получить
if (isset($getField)){
	$field = $modx->runSnippet('ddGetDocumentField', array(
		'id' => $getId,
		'field' => $getField
	));
}

//Если задано значение поля
if (isset($field) && $field != ""){
	$splY = isset($splY) ? $splY : '||';
	$splX = isset($splX) ? $splX : '::';
	//Являются ли разделители регулярками
	$splYisRegexp = (filter_var($splY, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^\/.*\/[a-z]*$/'))) !== false) ? true : false;
	$splXisRegexp = (filter_var($splX, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^\/.*\/[a-z]*$/'))) !== false) ? true : false;
	$num = (!isset($num) || !is_numeric($num)) ? '0' : $num;
	
	//Если заданы условия фильтрации
	if (!empty($vals)){
		//Разбиваем по условиям
		$temp = explode('||', $vals);
		
		$vals = array();
		
		foreach ($temp as $val){
			//Разбиваем по колонке/значению
			$val = explode('::', $val);
			
			//Если указали просто значение (значит, это нулевая колонка)
			if (count($val) < 2){
				$val[1] = $val[0];
				$val[0] = '0';
			}
			
			//Если ни одно правило для этой колонки ещй не задано
			if (!isset($vals[$val[0]])){
				$vals[$val[0]] = array();
			}
			
			//Добавляем правило для соответствующей колонки
			$vals[$val[0]][] = $val[1];
		}
	}else{
		$vals = false;
	}
	
	$count = (!isset($count) || !is_numeric($count)) ? 'all' : $count;
	$colNum = isset($colNum) ? explode(',', $colNum) : 'all';
	//Хитро-мудро для array_intersect_key
	if (is_array($colNum)) $colNum = array_combine($colNum, $colNum);
	$sortDir = isset($sortDir) ? strtoupper($sortDir) : false;
	$sortBy = isset($sortBy) ? $sortBy : '0';
	$glueY = isset($glueY) ? $glueY : '';
	$glueX = isset($glueX) ? $glueX : '';
	$removeEmptyRows = (isset($removeEmptyRows) && $removeEmptyRows == '0') ? false : true;
	$removeEmptyCols = (isset($removeEmptyCols) && $removeEmptyCols == '0') ? false : true;
	$typographing = (isset($typographing) && $typographing == '1') ? true : false;
	$urlencode = (isset($urlencode) && $urlencode == '1') ? true : false;
	$format = isset($format) ? strtolower($format) : 'html';
	$tplX = isset($tplX) ? explode(',', $tplX) : false;
	$resultToPlaceholder = (isset($resultToPlaceholder) && $resultToPlaceholder == '1') ? true : false;
	
	//Разбиваем на строки
	$res = $splYisRegexp ? preg_split($splY, $field) : explode($splY, $field);

	//Общее количество строк
	$total = count($res);
	
	//Перебираем строки, разбиваем на колонки
	foreach ($res as $key => $val){
		$res[$key] = $splXisRegexp ? preg_split($splX, $val) : explode($splX, $val);
		
		//Если необходимо получить какие-то конкретные значения
		if ($vals){
			//Перебираем колонки для фильтрации
			foreach ($vals as $col_k => $col_v){
				//Если текущего значения в списке нет, сносим нафиг
				if (!in_array($res[$key][$col_k], $col_v)){
					unset($res[$key]);
					//Уходим (строку уже снесли, больше ничего не важно)
					break;
				}
			}
		}
		
		//Если нужно получить какую-то конкретную колонку (также проверяем на то, что строка вообще существует, т.к. она могла быть уже удалена ранее)
		if ($colNum != 'all' && isset($res[$key])){
			//Выбираем только необходимые колонки + Сбрасываем ключи массива
			$res[$key] = array_values(array_intersect_key($res[$key], $colNum));
		}
		
		//Если нужно удалять пустые строки (также проверяем на то, что строка вообще существует, т.к. она могла быть уже удалена ранее)
		if ($removeEmptyRows && isset($res[$key])){
			//Если строка пустая, удаляем
			if (strlen(implode('', $res[$key])) == 0) unset($res[$key]);
		}
	}
	
	//Сбрасываем ключи массива (пригодится для выборки конкретного значения)
	$res = array_values($res);
	
	//Если шаблоны колонок заданы, но их не хватает
	if ($tplX){
		if (($temp = count($res[0]) - count($tplX)) > 0){
			//Дозабьём недостающие последним
			$tplX = array_merge($tplX, array_fill($temp - 1, $temp, $tplX[count($tplX) - 1]));
		}
		
		$tplX = str_replace('null', '', $tplX);
	}
	
	$result = '';

	//Если что-то есть (могло ничего не остаться после удаления пустых и/или получения по значениям)
	if (count($res) > 0){
		//Если надо сортировать
		if ($sortDir){
			//Если надо в случайном порядке - шафлим
			if ($sortDir == 'RAND'){
				shuffle($res);
			//Если надо просто в обратном порядке
			}else if ($sortDir == 'REVERSE'){
				$res = array_reverse($res);
			}else{
				if(!function_exists('ddMasHoarSort')){
					/**
					 * ddMasHoarSort
					 * @version 1.1 (2013-07-11)
					 * 
					 * @desc Функция сортировки многомерного массива по методу Хоара (по нескольким полям одновременно).
					 * 
					 * @param $arr {array} - Исходный массив. @required
					 * @param $key {array} - Массив ключей. @required
					 * @param $direct {1; -1} - Направление сортировки. @required
					 * @param $i {integer} - Счётчик (внутренняя переменная для рекурсии). По умолчанию: 0.
					 * 
					 * @return {array}
					 */
					function ddMasHoarSort($arr, $key, $direct, $i = 0){
						//В качестве эталона получаем сортируемое значение (по первому условию сортировки) первого элемента
						$tek = $arr[0][$key[$i]];
						$tekIsNumeric = is_numeric($tek);
						
						$masLeft = array();
						$masRight = array();
						$masCent = array();
						
						//Перебираем массив
						foreach ($arr as $val){
							//Если эталон и текущее значение — числа
							if ($tekIsNumeric && is_numeric($val[$key[$i]])){
								//Получаем нужную циферку
								$cmpRes = ($val[$key[$i]] == $tek) ? 0 : (($val[$key[$i]] > $tek) ? 1 : -1);
							//Если они строки
							}else{
								//Сравниваем текущее значение со значением эталонного
								$cmpRes = strcmp($val[$key[$i]], $tek);
							}
					
							//Если меньше эталона, отбрасываем в массив меньших
							if ($cmpRes * $direct < 0){
								$masLeft[] = $val;
							//Если больше - в массив больших
							}else if ($cmpRes * $direct > 0){
								$masRight[] = $val;
							//Если раво - в центральный
							}else{
								$masCent[] = $val;
							}
						}
						
						//Массивы меньших и массивы больших прогоняем по тому же алгоритму (если в них что-то есть)
						$masLeft = (count($masLeft) > 1) ? ddMasHoarSort($masLeft, $key, $direct, $i) : $masLeft;
						$masRight = (count($masRight) > 1) ? ddMasHoarSort($masRight, $key, $direct, $i) : $masRight;
						//Массив одинаковых прогоняем по следующему условию сортировки (если есть условие и есть что сортировать)
						$masCent = ((count($masCent) > 1) && $key[$i + 1]) ? ddMasHoarSort($masCent, $key, $direct, $i + 1) : $masCent;
					
						//Склеиваем отсортированные меньшие, средние и большие
						return array_merge($masLeft, $masCent, $masRight);
					}
				}
				
				//Сортируем результаты
				$sortDir = ($sortDir == 'ASC') ? 1 : -1;
				$res = ddMasHoarSort($res, explode(',', $sortBy), $sortDir);
			}
		}
		
		//Обрабатываем слишком большой индекс
		if (!$res[$num]) $num = count($res) - 1;
		
		//Если нужны все элементы
		if ($count == 'all'){
			$res = array_slice($res, $num);
		}else{
			$res = array_slice($res, $num, $count);
		}
		
		//Общее количество возвращаемых строк
		$resultTotal = count($res);
		
		//Плэйсхолдер с общим количеством
		if (isset($totalPlaceholder) && strlen(trim($totalPlaceholder)) != ''){
			$modx->setPlaceholder($totalPlaceholder, $resultTotal);
		}
		
		//Если вывод в массив
		if ($format == 'array'){
			$result = $res;
		}else{
			$resTemp = array();
			
			//Если вывод просто в формате html
			if ($format == 'html'){
				/*//Если вывод в формате изображения
				 if ($format == 'img'){
				foreach ($res as $key => $val) $res[$key] = '<img src="'.$val['val1'].'" alt="'.$val['val0'].'" />';
				//Если вывод в формате ссылки
				}else if ($format == 'link'){
				foreach ($res as $key => $val) $res[$key] = '<a href="'.$val['val1'].'">'.$val['val0'].'</a>';
				//Если вывод по шаблону
				}else */
				if (isset($tplY)){
					//Перебираем строки
					foreach ($res as $key => $val){
						$resTemp[$key] = array();
						//Перебираем колонки
						foreach ($val as $k => $v){
							//Если нужно удалять пустые значения
							if ($removeEmptyCols && !strlen($v)){
								$resTemp[$key]['val'.$k] = '';
							}else{
								//Если есть шаблоны значений колонок
								if ($tplX && strlen($tplX[$k])){
									$resTemp[$key]['val'.$k] = $modx->parseChunk($tplX[$k], array('val' => $v), '[+', '+]');
								}else{
									$resTemp[$key]['val'.$k] = $v;
								}
							}
						}
						//Запишем номер строки
						$resTemp[$key]['row_number'] = $key + 1;
						//И общее количество элементов
						$resTemp[$key]['total'] = $total;
						$resTemp[$key]['resultTotal'] = $resultTotal;
						$resTemp[$key] = $modx->parseChunk($tplY, $resTemp[$key], '[+', '+]');
					}
				}else{
					foreach ($res as $key => $val){
						//Если есть шаблоны значений колонок
						if ($tplX){
							foreach ($val as $k => $v){
								if ($removeEmptyCols && !strlen($v)){
									unset($val[$k]);
								}else{
									if ($tplX && strlen($tplX[$k]))
										$val[$k] = $modx->parseChunk($tplX[$k], array('val' => $v), '[+', '+]');
								}
							}
						}
						$resTemp[$key] = implode($glueX, $val);
					}
				}
				
				$result = implode($glueY, $resTemp);
			//Если вывод в формате JSON
			}else if ($format == 'json'){
				//Добавляем 'val' к названиям колонок
	/* 			foreach ($res as $key => $val){
					$res[$key] = array();
					//Перебираем колонки
					foreach ($val as $k => $v) $res[$key]['val'.$k] = $v;
				} */
				
				$resTemp = $res;
				
				//Если нужно выводить только одну колонку
				if ($colNum != 'all' && count($colNum) == 1){
					$resTemp = array_map('implode', $resTemp);
				}
				
				//Если нужно получить какой-то конкретный элемент, а не все
				if ($count == '1'){
					$result = json_encode($resTemp[$num]);
				}else{
					$result = json_encode($resTemp);
				}
				
				//Это чтобы модекс не воспринимал как вызов сниппета
				$result = strtr($result, array('[[' => '[ [', ']]' => '] ]'));
			}
			
			//Если оборачивающий шаблон задан (и вывод не в массив), парсим его
			if (isset($tplWrap)){
				//Подключаем modx.ddTools
				require_once $modx->config['base_path'].'assets/snippets/ddTools/modx.ddtools.class.php';
				
				$resTemp = array();
				
				//Элемент массива 'wrapper' должен находиться самым первым, иначе дополнительные переданные плэйсхолдеры в тексте не найдутся! 
				$resTemp['wrapper'] = $result;
				
				//Преобразуем результат в одномерный массив
				$res = ddTools::unfoldArray($res);
				
				//Добавляем 'row' и 'val' к ключам
				foreach ($res as $key => $val){
					 $resTemp[preg_replace('/(\d)\.(\d)/', 'row$1.val$2', $key)] = $val;
				}
				
				//Если есть дополнительные данные
				if (isset($placeholders)){
					$resTemp = array_merge($resTemp, ddTools::explodeAssoc($placeholders));
				}
				
				$resTemp['total'] = $total;
				$resTemp['resultTotal'] = $resultTotal;
				$result = $modx->parseChunk($tplWrap, $resTemp, '[+','+]');
			}
	
			//Если нужно типографировать
			if ($typographing){
				$result = $modx->runSnippet('ddTypograph', array('text' => $result));
			}
			//Если нужно URL-кодировать строку
			if ($urlencode){
				$result = rawurlencode($result);
			}
		}
	}
	
	//Если надо, выводим в плэйсхолдер
	if ($resultToPlaceholder){
		$modx->setPlaceholder('ddGetMultipleField', $result);
	}else{
		return $result;
	}
}
?>