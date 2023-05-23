<?php 
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => ' ВладимПащенкоир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

                                                            //Разбиение и объединение ФИО//

//getFullnameFromParts принимает как аргумент три строки — фамилию, имя и отчество. Возвращает как результат их же, но склеенные через пробел.

function getFullnameFromParts($surName, $name, $patronomyc) {
    return $surName." ".$name." ".$patronomyc;
  }

//getPartsFromFullname принимает как аргумент одну строку — склеенное ФИО. Возвращает как результат массив из трёх элементов с ключами ‘name’, ‘surname’ и ‘patronomyc’
//Пример:  [‘surname’ => ‘Иванов’ ,‘name’ => ‘Иван’, ‘patronomyc’ => ‘Иванович’]. 

function getPartsFromFullname($fullName) {
    $array_keys = ['surname', 'name', 'patronomyc'];
    $array_values = explode(' ', $fullName);
    return array_combine($array_keys, $array_values);
}

                                                            //Сокращение ФИО//
//Разработайте функцию getShortName, принимающую как аргумент строку, содержащую ФИО и возвращающую строку вида «Иван И.». Для разбиения строки на составляющие используйте функцию getPartsFromFullname.

function getShortName($fullName) {
    $curPartsName = getPartsFromFullname($fullName); 
    return $curPartsName['name']." ".mb_substr($curPartsName['surname'], 0, 1).".";
  }

                                 //Функция определения пола по ФИО//

//Разработайте функцию getGenderFromName, принимающую как аргумент строку, содержащую ФИО (вида «Иванов Иван Иванович»). 
//внутри функции делим ФИО на составляющие с помощью функции getPartsFromFullname;

function getGenderFromName($fullName) {
    $parts = getPartsFromFullname($fullName);
    $genderFlag = 0;

    //Признаки женского пола
    //отчество заканчивается на «вна»;
    if(mb_substr($parts['patronomyc'], -3, 3) == 'вна')
        --$genderFlag;
    //имя заканчивается на «а»;
    if(mb_substr($parts['name'], -1, 1) == 'а')
        --$genderFlag;
    //фамилия заканчивается на «ва»;
    if(mb_substr($parts['surname'], -2, 2) == 'ва')
        --$genderFlag;  

    //Признаки мужского пола:
    //отчество заканчивается на «ич»;
    if(mb_substr($parts['patronomyc'], -2, 2) == 'ич')
        ++$genderFlag;  
    //имя заканчивается на «й» или «н»;
    if(mb_substr($parts['name'], -1, 1) == 'й' || mb_substr($parts['name'], -1, 1) == 'н')
        ++$genderFlag;

    //фамилия заканчивается на «в».
    if(mb_substr($parts['surname'], -1, 1) == 'в')
        ++$genderFlag;

    //изначально «суммарный признак пола» считаем равным 0; 1 (мужской пол); -1 (женский пол); 0 (неопределенный пол). 
    switch($genderFlag <=> 0){
        case 1:
            return 'male';
            break;
        case -1:
            return 'female';
            break;
        default:
            return'undefined';
    }
}



                                                          //Определение возрастно-полового состава//
//Напишите функцию getGenderDescription для определения полового состава аудитории. 
//Как аргумент в функцию передается массив, схожий по структуре с массивом $example_persons_array. Как результат функции возвращается информация в следующем виде:
//Напишите функцию getGenderDescription для определения полового состава аудитории.

function getGenderDescription($array)
{
    $male_array = array_filter($array, function ($arr) {
        if (getGenderFromName($arr['fullname']) == 1) {
            return true;
        } else return false;
    });

    $female_array = array_filter($array, function ($arr) {
        if (getGenderFromName($arr['fullname']) == -1) {
            return true;
        } else return false;
    });

    $undefined_array = array_filter($array, function ($arr) {
        if (getGenderFromName($arr['fullname']) == 0) {
            return true;
        } else return false;
    });

    $male_amount = count($male_array);
    $female_amount = count($female_array);
    $undefined_amount = count($undefined_array);
    $total_amount = $male_amount + $female_amount + $undefined_amount;
    $male_percent = round($male_amount / $total_amount * 100);
    $female_percent = round($female_amount / $total_amount * 100);
    $undefined_percent = round($undefined_amount / $total_amount * 100);
    $output = <<<MYHEREDOCTEXT

Гендерный состав аудитории:

Мужчины - $male_percent%
Женщины - $female_percent%
Не удалось определить - $undefined_percent%
MYHEREDOCTEXT;
    echo $output;
}


?>