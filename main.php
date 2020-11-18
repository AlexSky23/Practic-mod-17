<?php

include 'person.php';

function getFullnameFromParts($surname, $name, $patronomyc){

  $FIO = $surname . ' ' . $name . ' ' . $patronomyc;

  return $FIO;
}

function getPartsFromFullname($val){
    //$FIO_a = getFullnameFromParts();
    $FIO_a = $val;
    //print_r($FIO_a);
    $key = ['surname', 'name', 'patronomyc'];
        $FIO = explode(' ', $FIO_a);
        $FIO_2 = array_combine($key, $FIO);
  return $FIO_2;
}

function getShortName($FIO){
  $FIO_2 = getPartsFromFullname($FIO);
  
    $FIO = $FIO_2['name'] . ' ' . mb_substr($FIO_2['surname'], 0, 1) . '.';
 
  return $FIO;
}

function getGenderFromName($FIO_a){
  $FIO = getPartsFromFullname($FIO_a);
  //print_r($FIO);
  $gender = 0;
 
  if(mb_substr($FIO['name'], -1, 1) == 'й' || mb_substr($FIO['name'], -1, 1) == 'н' 
  || mb_substr($FIO['surname'], -1, 1) == 'в' || mb_substr($FIO['patronomyc'], -2, 2) == 'ич'){
    $gender = 1;
  }
  if(mb_substr($FIO['name'], -1, 1) == 'а' || mb_substr($FIO['surname'], -2, 2) == 'ва' 
  || mb_substr($FIO['patronomyc'], -3, 3) == 'вна'){
    $gender = -1;
  }

  if($gender > 0){return 'мужской пол';} 
  elseif ($gender < 0) {return 'женский пол';}
  else {return 'неопределенный пол';}
}

function getGenderDescription($FIO){
  $FIO_1 = $FIO;
  //print_r($FIO_1);
  $m = 0; //Мужчины 
  $f = 0; //Женщины 
  $n = 0; //Не удалось определить
  for($i=0; $i < count($FIO_1); $i++){
    if(getGenderFromName($FIO_1[$i]) == 'мужской пол'){$m++;}
    elseif(getGenderFromName($FIO_1[$i]) == 'женский пол'){$f++;}
    else{$n++;}
  }
echo 'Гендерный состав аудитории:' . '</br>';
echo '---------------------------' . '</br>';
echo 'Мужчины - '. round(100*$m/count($FIO_1), 1) . '%' . '</br>';
echo 'Женщины - '. round(100*$f/count($FIO_1), 1) . '%' . '</br>';
echo 'Не удалось определить - '. round(100*$n/count($FIO_1), 1) . '%';
}

function getPerfectPartner($surname, $name, $patronomyc, $arr){
  $surname1 = mb_convert_case($surname, MB_CASE_TITLE_SIMPLE);
  $name1 = mb_convert_case($name, MB_CASE_TITLE_SIMPLE);
  $patronomyc1 = mb_convert_case($patronomyc, MB_CASE_TITLE_SIMPLE);

  $FIO_1 = getFullnameFromParts($surname1, $name1, $patronomyc1);
  $FIO_gender1 = getGenderFromName($FIO_1);

  $FIO_gender2 = $FIO_gender1;

  while(($FIO_gender2 == $FIO_gender1) || ($FIO_gender2 == 'неопределенный пол')){
  $FIO_2 = $arr[rand(0, 10)]['fullname'];
  $FIO_gender2 = getGenderFromName($FIO_2);
  }

echo getShortName($FIO_1) . ' + ' . getShortName($FIO_2) . ' =' . '<br>';
echo '♡'. ' Идеально на '. rand(50, 100). '% ' .'♡';
}


print_r(getPerfectPartner('Шварцнегер','екатериНа','влаДИМИРОВна',$example_persons_array));
?>