<?php
/**
 * Connector database to MySQL
 * 
 * борьба с говнокодом началась 8фев2014 12:30
 */

/*
 * MySQLi
 */
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($db->connect_errno) {
    echo $this->mysqli->connect_error;
}

if (! $db->query('SET NAMES ' . DB_CHARSET)) {
    // $this->error = $this->mysqli->connect_error;
    return;
}

function check_admin ($s_item)
{
    // Задаем список user_id админов:
    $array = array(
        1 => 1018); // это 5552850 , а если два и более - $array
                    // = array(1 => 1018, 2 => 1);
                    
    // Ищем переданный в процедуру номер пользователя:
    $key = array_search($s_item, $array);
    
    if ($key == NULL) {
        // echo "Нет совпадений!";
        return false;
    } else {
        // echo "Надено!";
        return true;
    }
}

function get_user_info ($link, $uid)
{
    $zapros = "SELECT * FROM tbl_users WHERE id='" . (int) $uid . "'";
    $res = mysql_query($zapros, $link); // $kolvo=$res->num_rows;
    if (($ar = $res->fetch_assoc()) == true) {
        $s = '';
        $s .= 'id=' . $ar['id'] . ', ';
        $s .= $ar['name'];
        $s .= ' (' . $ar['nickname'] . '), ';
        if ($ar['prefix'] == 1) {
            // Городской телефон
            $s .= '(8162)' . $ar['phone'];
        } elseif ($ar['prefix'] == 2) {
            // Мобильный телефон
            $s .= '+7' . $ar['phone'];
        } else {
            // Неверный префикс в базе данных (такого вообще не должно быть)
            $s .= '_!префикс_не_тот!_';
        }
        return $s;
    } else {
        return "";
    }
}

function printselect ($link, $tname)
{
    $zapros = "SELECT * FROM " . $tname . " ORDER BY sort ASC";
    $res = mysql_query($zapros, $link); // $kolvo=$res->num_rows;
    while (($ar = $res->fetch_assoc()) == true) {
        echo "<option value=" . $ar['id'] . ">" . $ar['title'] . "</option>\n";
    }
}

// То же самое, только с предустановкой $def
function printselectdef ($link, $tname, $def)
{
    $zapros = "SELECT * FROM " . $tname . " ORDER BY sort ASC";
    $res = $link->query($zapros); // $kolvo=$res->num_rows;
    while (($ar = $res->fetch_assoc()) == true) {
        if ($ar['id'] == $def) {
            echo "<option value=" . $ar['id'] . " selected>" . $ar['title'] .
                     "</option>\n";
        } else {
            echo "<option value=" . $ar['id'] . ">" . $ar['title'] .
                     "</option>\n";
        }
    }
}

// То же самое, только с предустановкой $sort
function printselectsort ($link, $tname, $sort, $sort_type)
{
    $zapros = "SELECT * FROM " . $tname . " ORDER BY " . $sort . " " . $sort_type .
             ", title ASC";
    $res = mysql_query($zapros, $link); // $kolvo=$res->num_rows;
    while (($ar = $res->fetch_assoc()) == true) {
        echo "<option value=" . $ar['id'] . ">" . $ar['title'] . "</option>\n";
    }
}

// То же самое, только с предустановкой $sort + def
function printselectsortdef ($link, $tname, $sort, $sort_type, $def)
{
    $zapros = "SELECT * FROM " . $tname . " ORDER BY " . $sort . " " . $sort_type .
             ", title ASC";
    $res = $link->query($zapros); // $kolvo=$res->num_rows;
    while (($ar = $res->fetch_assoc()) == true) {
        if ($ar['id'] == $def) {
            echo "<option value=" . $ar['id'] . " selected>" . $ar['title'] .
                     "</option>\n";
        } else {
            echo "<option value=" . $ar['id'] . ">" . $ar['title'] .
                     "</option>\n";
        }
    }
}

// вывод списка (с полем title_d) + сортировка
function printselectsort_title_d ($link, $tname, $def)
{
    $zapros = "SELECT * FROM " . $tname . " ORDER BY sort, title ASC";
    $res = mysql_query($zapros, $link); // $kolvo=$res->num_rows;
    while (($ar = $res->fetch_assoc()) == true) {
        if ($ar['id'] == $def) {
            echo "<option value=" . $ar['id'] . " selected>" . $ar['title_d'] .
                     "</option>\n";
        } else {
            echo "<option value=" . $ar['id'] . ">" . $ar['title_d'] .
                     "</option>\n";
        }
    }
}

// =============================================================================
function gettitle ($link, $tname, $value)
{
    $zapros = "SELECT title FROM " . $tname . " WHERE id='" . ($value) . "'";
    $res = $link->query($zapros); // $kolvo=$res->num_rows;
    if (($ar = $res->fetch_assoc()) == true) {
        return $ar['title'];
    } else {
        return "";
    }
}

function gettitle_d ($link, $tname, $value)
{
    $zapros = "SELECT title_d FROM " . $tname . " WHERE id='" . ($value) . "'";
    $res = $link->query($zapros); // $kolvo=$res->num_rows;
    if (($ar = $res->fetch_assoc()) == true) {
        return $ar['title_d'];
    } else {
        return "";
    }
}

// Проверка существования в базе записи по email
function exist_db_email ($db, $email)
{
    $sql = "SELECT * FROM tbl_users WHERE email='" .
             mysql_real_escape_string($email) . "' LIMIT 1;";
    $result = mysql_query($sql, $db) or die(mysql_error());
    if ($result) {
        // если существует запись то возвращаем истину иначе ложь
        if (mysql_num_rows($result) == 1) {
            return true;
        }
    }
    
    return false;
}

// Проверка существования в базе записи по номеру телефона
function exist_db_phone ($db, $phone)
{
    $sql = "SELECT * FROM tbl_users WHERE phone='" .
             mysql_real_escape_string($phone) . "' LIMIT 1;";
    $result = mysql_query($sql, $db) or die(mysql_error());
    if ($result) {
        // если существует запись то возвращаем истину иначе ложь
        if (mysql_num_rows($result) == 1) {
            return true;
        }
    }
    
    return false;
}

// Проверка существования в базе агента с таким id
function exist_db_agent ($db, $user_id)
{
    $sql = "SELECT * FROM spr_realty_agent WHERE id='" .
             mysql_real_escape_string($user_id) . "' LIMIT 1;";
    $result = mysql_query($sql, $db) or die(mysql_error());
    if ($result) {
        // если существует запись то возвращаем истину иначе ложь
        if (mysql_num_rows($result) == 1) {
            return true;
        }
    }
    
    return false;
}

// Проверка существования в базе АКТИВИРОВАННОЙ записи с данным $id
function active_db_id ($db, $id)
{
    $sql = "SELECT * FROM tbl_users WHERE id='" . (int) ($id) .
             "' AND status='1' LIMIT 1;";
    $result = $db->query($sql) or die(mysql_error());
    if (isset($result) && $result->num_rows == 1) {
        return true;
    }
    return false;
}

// Проверка принадлежности пользователю объявления с заданным $id
function owner_of ($tbl, $db, $user, $id)
{
    $sql = "SELECT * FROM " . $tbl . " WHERE id='" . (int) ($id) .
             "' AND usr_id='" . (int) ($user) . "' LIMIT 1;";
    $result = $db->query($sql) or die(mysql_error());
    if ($result) {
        // если существует запись то возвращаем истину иначе ложь
        if ($result->num_rows == 1) {
            return true;
        }
    }
    
    return false;
}

// =============================================================================

// Функция защиты email-адреса от сбора СПАМ-роботами
function mprotected ($email)
{
    $pos_at = 0;
    $pos_dot = 0;
    $str1 = "";
    $str2 = "";
    $str3 = "";
    
    $pos_at = stripos($email, '@');
    $pos_dot = strripos($email, '.');
    
    $str1 = substr($email, 0, $pos_at);
    $str2 = substr($email, $pos_at + 1, $pos_dot - $pos_at - 1);
    $str3 = substr($email, $pos_dot + 1);
    
    // echo $str1."+".$str2."+".$str3;
    
    echo "<script language=\"JavaScript\">var name=\"" . $str1 .
             "\";var server=\"" . $str2 . "\";var domain=\"" . $str3 .
             "\";document.write('<a class=\"link\" href=\"' + 'mail' + 'to:' + name + '@' + server + '.' + domain + '\">'+ name + '@' + server + '.' + domain + '</a>');</script><noscript><b style=\"color:red;\">Включите поддержку JavaScript</b></noscript>";
}

// =============================================================================

// Возвращает количество СВОИХ активных (статус = 0) записей в таблице tbl
function my_counter_tbl ($tbl, $db, $user_id)
{
    $sql = "SELECT COUNT(*) FROM " . $tbl . " WHERE status='0' AND usr_id='" .
             $user_id . "' LIMIT 1;";
    $result = $db->query($sql) or die(mysql_error());
    $row = $result->fetch_row();
    if ($result) {
        return $row[0];
    }
    
    return 0;
}

// Возвращает количество активных (статус = 0) записей в таблице tbl
function counter_tbl ($tbl, $db)
{
    $sql = "SELECT COUNT(*) FROM " . $tbl . " WHERE status='0' LIMIT 1;";
    $result = $db->query($sql) or die(mysql_error());
    $row = mysqli_fetch_row($result);
    if ($result) {
        return $row[0];
    }
    
    return 0;
}

// Возвращает количество активных (статус = 0) записей в таблице tbl + УСЛОВИЕ
function counter_tbl_usl ($tbl, $db, $usl)
{
    $sql = "SELECT COUNT(*) FROM " . $tbl . " WHERE status='0' AND " . $usl .
             " LIMIT 1;";
    $result = $db->query($sql) or die(mysql_error());
    $row = $result->fetch_row();
    if ($result) {
        return $row[0];
    }
    
    return 0;
}

// Возвращает количество записей в таблице tbl_objects с данным type_id
function count_typed ($db, $type_id)
{
    $sql = "SELECT COUNT(*) FROM tbl_objects WHERE status='0' AND obj_type_id='" .
             mysql_real_escape_string($type_id) . "' LIMIT 1;";
    $result = mysql_query($sql, $db) or die(mysql_error());
    $row = mysql_fetch_row($result);
    if ($result) {
        return $row[0];
    }
    
    return 0;
}

// Возвращает количество записей в таблице tbl_objects с данным type_id +
// kv_rooms
function count_typed_roomed ($db, $type_id, $kv_rooms)
{
    $sql = "SELECT COUNT(*) FROM tbl_objects WHERE status='0' AND obj_type_id='" .
             mysql_real_escape_string($type_id) . "' AND kv_rooms='" .
             mysql_real_escape_string($kv_rooms) . "' LIMIT 1;";
    if ($kv_rooms >= 4) {
        $sql = "SELECT COUNT(*) FROM tbl_objects WHERE status='0' AND obj_type_id='" .
                 mysql_real_escape_string($type_id) .
                 "' AND kv_rooms>='4' LIMIT 1;";
    }
    
    $result = mysql_query($sql, $db) or die(mysql_error());
    $row = mysql_fetch_row($result);
    if ($result) {
        return $row[0];
    }
    
    return 0;
}

// Возвращает количество объявлений у пользователя
function count_objects ($db, $user_id)
{
    $sql = "SELECT COUNT(*) FROM tbl_objects WHERE status='0' AND usr_id='" .
             mysql_real_escape_string($user_id) . "' LIMIT 1;";
    $result = mysql_query($sql, $db) or die(mysql_error());
    $row = mysql_fetch_row($result);
    if ($result) {
        return $row[0];
    }
    
    return 0;
}

// для логирования +++++++++++++++++++++++++++++++++++++++++++++

// Функция для логирования действий с квартирами
function loging_add_kvrecord ($db, $p_user_id, $p_action_id, $p_kv_id, $p_descr, 
        $p_xtra1, $p_xtra2)
{
    $query = "INSERT INTO logs (id, date_fixed, user_id,  action_id,  subject_id, descr,  sec_ip, xtra1, xtra2) VALUES (NULL,'" .
             time() . "','" . (int) $p_user_id . "','" . (int) $p_action_id .
             "','" . (int) $p_kv_id . "','" . $p_descr . "','" .
             $_SERVER['REMOTE_ADDR'] . "','" . $p_xtra1 . "','" . $p_xtra2 .
             "');";
    $res = $db->query($query);
}

// Функция возвращает наименование города по номеру ID
function get_punkt_by_id ($db, $punkt_id)
{
    $query = "SELECT * FROM spr_geo_gorod WHERE id='" . (int) $punkt_id . "'";
    $res = $db->query($query);
    $punkt_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($punkt_kolvo == '1') {
        // Есть такой нас. пункт
        return $ar['title'];
    } else {
        // Нет такого нас. пункта
        return "[Неизвестный нас. пункт]";
    }
}

// Функция возвращает наименование улицы по номеру ID
function get_street_by_id ($db, $street_id)
{
    $query = "SELECT * FROM spr_geo_street WHERE id='" . (int) $street_id . "'";
    $res = $db->query($query);
    $street_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($street_kolvo == '1') {
        // Есть такая улица
        return $ar['title_d'];
    } else {
        // Нет такой улицы
        return "[Неизвестная улица]";
    }
}

// Функция возвращает наименование (ДЛЯ АЛФАВИТНОГО СПИСКА) улицы по номеру ID
function get_street_by_id2 ($db, $street_id)
{
    $query = "SELECT * FROM spr_geo_street WHERE id='" . (int) $street_id . "'";
    $res = $db->query($query);
    $street_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($street_kolvo == '1') {
        // Есть такая улица
        return $ar['title'];
    } else {
        // Нет такой улицы
        return "[Неизвестная улица]";
    }
}

// Функция возвращает наименование материала (КРАТКОЕ) по номеру ID
function get_material_by_id ($db, $material_id)
{
    $query = "SELECT * FROM spr_zd_material WHERE id='" . (int) $material_id .
             "'";
    $res = $db->query($query);
    $material_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($material_kolvo == '1') {
        // Есть такой материал
        return $ar['title_d'];
    } else {
        // Нет такого материала
        return "[Неизвестный материал]";
    }
}

// Функция возвращает наименование материала (ПОЛНОЕ в муж. роде) по номеру ID
function get_dommaterial_by_id ($db, $material_id)
{
    $query = "SELECT * FROM spr_zd_material WHERE id='" . (int) $material_id .
             "'";
    $res = $db->query($query);
    $material_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($material_kolvo == '1') {
        // Есть такой материал
        return $ar['title'];
    } else {
        // Нет такого материала
        return "[Неизвестный материал]";
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Функция возвращает объявление по TYPE и ID объекта
// ++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function get_notice_by_object ($db, $obj_type, $obj_id)
{
    $obj_id = (int) $obj_id;
    $obj_type = (int) $obj_type;
    
    $ld = "";
    
    // ================================================================================
    // Квартира на продажу
    // (начало)====================================================
    if ($obj_type == '11') {
        
        $price_ed = "тыс.руб.";
        
        $query = "SELECT * FROM sell_kva WHERE id='" . $obj_id .
                 "' AND status='0'";
        $res = $db->query($query);
        $kolvo = '0';
        $kolvo = $res->num_rows;
        if ($kolvo == '1') { // Есть такое объявление
                             // Есть такое объявление
                             // ++++++++++++++++++++++++++++++++
            $ar = $res->fetch_assoc();
            $ld .= "Продам ";
            $ld .= $ar['kva_rooms'] . "-к.кв., ";
            $ld .= $ar['kva_pl_ob'] . "/" . $ar['kva_pl_zh'] . "/" .
                     $ar['kva_pl_kuh'] . ", ";
            $ld .= $ar['kva_floor'] . "/" . $ar['zd_floors'] .
                     get_material_by_id($db, $ar['zd_material_id']) . ", ";
            
            // + ГОРОД
            if ($ar['geo_gorod_id'] != "1") { // Великий Новгород не пишем (это
                                              // по умолчанию)
                if ($ar['geo_gorod_id'] != "-1") { // если есть номер города,
                                                   // тогда извлекаем название
                    $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
                } else { // если нет номера города (номер =-1)
                    if (strlen(trim($ar['geo_gorod'])) > 0) { // город указан
                                                              // вручную
                        $ld .= $ar['geo_gorod'] . ", ";
                    } else { // город НЕ указан вручную, невозможная ситуация -
                             // т.к. должен быть указан город
                        $ld .= "[Ошибка: город не задан], ";
                    }
                }
            }
            
            // + УЛИЦА
            if ($ar['geo_street_id'] != "-1") { // если есть номер улицы, тогда
                                                // извлекаем название
                $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
            } else { // если нет номера улицы (номер =-1)
                if (strlen(trim($ar['geo_street'])) > 0) { // улица указана
                                                           // вручную
                    $ld .= $ar['geo_street'] . ", ";
                } else { // улица НЕ указана вручную, невозможная ситуация -
                         // т.к. должна быть указана улица
                    $ld .= "[Ошибка: неизвестная улица], ";
                }
            }
            
            // + НОМЕР ДОМА
            $ld .= "д. " . $ar['geo_n_doma'] . " ";
            
            // + КОРПУС ДОМА
            if (strlen($ar['geo_n_korp']) > 0) {
                $ld .= "к. " . $ar['geo_n_korp'] . " ";
            }
            
            // + ЦЕНА и ТОРГ
            
            if ($ar['price_torg'] == '5') { // без торга
                $ld .= "за " . $ar['price'] . " " . $price_ed . ", без торга";
            } else {
                if ($ar['price_torg'] == '4') { // возможен торг
                    $ld .= "за " . $ar['price'] . " " . $price_ed . ", торг";
                } else { // не указано про торг
                    $ld .= "за " . $ar['price'] . " " . $price_ed;
                }
            }
            
            return $ld;
        } else {
            // Нет такого объявления
            return "[Ошибка: неизвестное объявление о продаже квартиры, id=" .
                     $obj_id . "]";
        }
    }
    
    // Квартира на продажу
    // (конец)=====================================================
    // ================================================================================
    
    // ================================================================================
    // Квартира в аренду
    // (начало)======================================================
    if ($obj_type == '12') {
        
        $price_ed = "руб./мес.";
        
        $query = "SELECT * FROM rent_kva WHERE id='" . $obj_id .
                 "' AND status='0'";
        $res = $db->query($query);
        $kolvo = '0';
        $kolvo = $res->num_rows;
        if ($kolvo == '1') { // Есть такое объявление
                             // Есть такое объявление
                             // ++++++++++++++++++++++++++++++++
            $ar = $res->fetch_assoc();
            $ld .= "Сдам ";
            $ld .= $ar['kva_rooms'] . "-к.кв., ";
            $ld .= $ar['kva_pl_ob'] . "/" . $ar['kva_pl_zh'] . "/" .
                     $ar['kva_pl_kuh'] . ", ";
            $ld .= $ar['kva_floor'] . "/" . $ar['zd_floors'] .
                     get_material_by_id($db, $ar['zd_material_id']) . ", ";
            
            // + ГОРОД
            if ($ar['geo_gorod_id'] != "1") { // Великий Новгород не пишем (это
                                              // по умолчанию)
                if ($ar['geo_gorod_id'] != "-1") { // если есть номер города,
                                                   // тогда извлекаем название
                    $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
                } else { // если нет номера города (номер =-1)
                    if (strlen(trim($ar['geo_gorod'])) > 0) { // город указан
                                                              // вручную
                        $ld .= $ar['geo_gorod'] . ", ";
                    } else { // город НЕ указан вручную, невозможная ситуация -
                             // т.к. должен быть указан город
                        $ld .= "[Ошибка: город не задан], ";
                    }
                }
            }
            
            // + УЛИЦА
            if ($ar['geo_street_id'] != "-1") { // если есть номер улицы, тогда
                                                // извлекаем название
                $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
            } else { // если нет номера улицы (номер =-1)
                if (strlen(trim($ar['geo_street'])) > 0) { // улица указана
                                                           // вручную
                    $ld .= $ar['geo_street'] . ", ";
                } else { // улица НЕ указана вручную, невозможная ситуация -
                         // т.к. должна быть указана улица
                    $ld .= "[Ошибка: неизвестная улица], ";
                }
            }
            
            // + НОМЕР ДОМА
            $ld .= "д. " . $ar['geo_n_doma'] . " ";
            
            // + КОРПУС ДОМА
            if (strlen($ar['geo_n_korp']) > 0) {
                $ld .= "к. " . $ar['geo_n_korp'] . " ";
            }
            
            // + ЦЕНА и ТОРГ
            
            if ($ar['price_torg'] == '5') { // без торга
                $ld .= "за " . $ar['price'] . " " . $price_ed . ", без торга";
            } else {
                if ($ar['price_torg'] == '4') { // возможен торг
                    $ld .= "за " . $ar['price'] . " " . $price_ed . ", торг";
                } else { // не указано про торг
                    $ld .= "за " . $ar['price'] . " " . $price_ed;
                }
            }
            
            return $ld;
        } else {
            // Нет такого объявления
            return "[Ошибка: неизвестное объявление об аренде квартиры, id=" .
                     $obj_id . "]";
        }
    }
    
    // Квартира в аренду
    // (конец)=====================================================
    // ==============================================================================
    
    // ================================================================================
    // Квартира в аренду посуточно
    // (начало)============================================
    if ($obj_type == '13') {
        
        $price_ed = "руб./сутки";
        
        $query = "SELECT * FROM rent24_kva WHERE id='" . $obj_id .
                 "' AND status='0'";
        $res = $db->query($query);
        $kolvo = '0';
        $kolvo = $res->num_rows;
        if ($kolvo == '1') { // Есть такое объявление
                             // Есть такое объявление
                             // ++++++++++++++++++++++++++++++++
            $ar = $res->fetch_assoc();
            $ld .= "Сдам посуточно ";
            $ld .= $ar['kva_rooms'] . "-к.кв., ";
            $ld .= $ar['kva_pl_ob'] . "/" . $ar['kva_pl_zh'] . "/" .
                     $ar['kva_pl_kuh'] . ", ";
            $ld .= $ar['kva_floor'] . "/" . $ar['zd_floors'] .
                     get_material_by_id($db, $ar['zd_material_id']) . ", ";
            
            // + ГОРОД
            if ($ar['geo_gorod_id'] != "1") { // Великий Новгород не пишем (это
                                              // по умолчанию)
                if ($ar['geo_gorod_id'] != "-1") { // если есть номер города,
                                                   // тогда извлекаем название
                    $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
                } else { // если нет номера города (номер =-1)
                    if (strlen(trim($ar['geo_gorod'])) > 0) { // город указан
                                                              // вручную
                        $ld .= $ar['geo_gorod'] . ", ";
                    } else { // город НЕ указан вручную, невозможная ситуация -
                             // т.к. должен быть указан город
                        $ld .= "[Ошибка: город не задан], ";
                    }
                }
            }
            
            // + УЛИЦА
            if ($ar['geo_street_id'] != "-1") { // если есть номер улицы, тогда
                                                // извлекаем название
                $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
            } else { // если нет номера улицы (номер =-1)
                if (strlen(trim($ar['geo_street'])) > 0) { // улица указана
                                                           // вручную
                    $ld .= $ar['geo_street'] . ", ";
                } else { // улица НЕ указана вручную, невозможная ситуация -
                         // т.к. должна быть указана улица
                    $ld .= "[Ошибка: неизвестная улица], ";
                }
            }
            
            // + НОМЕР ДОМА
            $ld .= "д. " . $ar['geo_n_doma'] . " ";
            
            // + КОРПУС ДОМА
            if (strlen($ar['geo_n_korp']) > 0) {
                $ld .= "к. " . $ar['geo_n_korp'] . " ";
            }
            
            // + ЦЕНА и ТОРГ
            
            if ($ar['price_torg'] == '5') { // без торга
                $ld .= "за " . $ar['price'] . " " . $price_ed . ", без торга";
            } else {
                if ($ar['price_torg'] == '4') { // возможен торг
                    $ld .= "за " . $ar['price'] . " " . $price_ed . ", торг";
                } else { // не указано про торг
                    $ld .= "за " . $ar['price'] . " " . $price_ed;
                }
            }
            
            return $ld;
        } else {
            // Нет такого объявления
            return "[Ошибка: неизвестное объявление о посуточной аренде квартиры, id=" .
                     $obj_id . "]";
        }
    }
    
    // Квартира в аренду посуточно
    // (конец)=============================================
    // ================================================================================
    
    // ================================================================================
    // Комната на продажу
    // (начало)=====================================================
    if ($obj_type == '21') {
        $price_ed = "тыс. руб.";
        $query = "SELECT * FROM sell_kmn WHERE id='" . (int) $obj_id .
                 "' AND status='0'";
        $res = $db->query($query);
        $kolvo = $res->num_rows;
        if ($kolvo == '1') {
            // Есть такое объявление
            // ++++++++++++++++++++++++++++++++
            $ar = $res->fetch_assoc();
            $ld .= "Продам ";
            $ld .= get_kmntype_by_id($db, $ar['kmn_type_id']) . " пл. " .
                     $ar['kmn_pl'] . "кв.м, " . $ar['kmn_floor'] . "/" .
                     $ar['zd_floors'] .
                     get_material_by_id($db, $ar['zd_material_id']) . ", ";
            
            // + ГОРОД
            if ($ar['geo_gorod_id'] != "1") { // Великий Новгород не пишем (это
                                              // по умолчанию)
                if ($ar['geo_gorod_id'] != "-1") {
                    // если есть номер города, тогда извлекаем название
                    $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
                } else {
                    // если нет номера города (номер =-1)
                    if (strlen(trim($ar['geo_gorod'])) > 0) {
                        // город указан вручную
                        $ld .= $ar['geo_gorod'] . ", ";
                    } else {
                        // город НЕ указан вручную, невозможная ситуация - т.к.
                        // должен быть указан город
                        $ld .= "[неизвестный населенный пункт], ";
                    }
                }
            }
            
            // + УЛИЦА
            if ($ar['geo_street_id'] != "-1") {
                // если есть номер улицы, тогда извлекаем название
                $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
            } else {
                // если нет номера улицы (номер =-1)
                if (strlen(trim($ar['geo_street'])) > 0) {
                    // улица указана вручную
                    $ld .= $ar['geo_street'] . ", ";
                } else {
                    // улица НЕ указана вручную, невозможная ситуация - т.к.
                    // должна быть указана улица
                    $ld .= "[неизвестная улица], ";
                }
            }
            
            // + НОМЕР ДОМА
            $ld .= "д. " . $ar['geo_n_doma'] . " ";
            
            // + КОРПУС ДОМА
            if (strlen($ar['geo_n_korp']) > 0) {
                $ld .= "к. " . $ar['geo_n_korp'] . " ";
            }
            
            // + ЦЕНА и ТОРГ
            
            if ($ar['price_torg'] == '5') {
                // без торга
                $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                         ", без торга";
            } else {
                if ($ar['price_torg'] == '4') {
                    // возможен торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                             ", торг";
                } else {
                    // не указано про торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed;
                }
            }
            
            // ++++++++++++++++++++++++++++++++
            return $ld;
        } else {
            // Нет такого объявления
            return "[Ошибка: неизвестное объявление о продаже комнаты, id=" .
                     (int) $obj_id . "]";
        }
    }
    
    // Комната на продажу
    // (конец)=====================================================
    // ===============================================================================
    
    // ================================================================================
    // Комната в аренду
    // (начало)=======================================================
    if ($obj_type == '22') {
        
        $price_ed = "руб./мес.";
        $query = "SELECT * FROM rent_kmn WHERE id='" . (int) $obj_id .
                 "' AND status='0'";
        $res = $db->query($query);
        $kolvo = $res->num_rows;
        if ($kolvo == '1') {
            // Есть такое объявление
            // ++++++++++++++++++++++++++++++++
            $ar = $res->fetch_assoc();
            $ld .= "Сдам ";
            $ld .= get_kmntype_by_id($db, $ar['kmn_type_id']) . " пл. " .
                     $ar['kmn_pl'] . "кв.м, " . $ar['kmn_floor'] . "/" .
                     $ar['zd_floors'] .
                     get_material_by_id($db, $ar['zd_material_id']) . ", ";
            
            // + ГОРОД
            if ($ar['geo_gorod_id'] != "1") { // Великий Новгород не пишем (это
                                              // по умолчанию)
                if ($ar['geo_gorod_id'] != "-1") {
                    // если есть номер города, тогда извлекаем название
                    $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
                } else {
                    // если нет номера города (номер =-1)
                    if (strlen(trim($ar['geo_gorod'])) > 0) {
                        // город указан вручную
                        $ld .= $ar['geo_gorod'] . ", ";
                    } else {
                        // город НЕ указан вручную, невозможная ситуация - т.к.
                        // должен быть указан город
                        $ld .= "[неизвестный населенный пункт], ";
                    }
                }
            }
            
            // + УЛИЦА
            if ($ar['geo_street_id'] != "-1") {
                // если есть номер улицы, тогда извлекаем название
                $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
            } else {
                // если нет номера улицы (номер =-1)
                if (strlen(trim($ar['geo_street'])) > 0) {
                    // улица указана вручную
                    $ld .= $ar['geo_street'] . ", ";
                } else {
                    // улица НЕ указана вручную, невозможная ситуация - т.к.
                    // должна быть указана улица
                    $ld .= "[неизвестная улица], ";
                }
            }
            
            // + НОМЕР ДОМА
            $ld .= "д. " . $ar['geo_n_doma'] . " ";
            
            // + КОРПУС ДОМА
            if (strlen($ar['geo_n_korp']) > 0) {
                $ld .= "к. " . $ar['geo_n_korp'] . " ";
            }
            
            // + ЦЕНА и ТОРГ
            
            if ($ar['price_torg'] == '5') {
                // без торга
                $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                         ", без торга";
            } else {
                if ($ar['price_torg'] == '4') {
                    // возможен торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                             ", торг";
                } else {
                    // не указано про торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed;
                }
            }
            
            // ++++++++++++++++++++++++++++++++
            return $ld;
        } else {
            // Нет такого объявления
            return "[Ошибка: неизвестное объявление об аренде комнаты, id=" .
                     (int) $obj_id . "]";
        }
    }
    
    // Комната в аренду
    // (конец)=======================================================
    // ===============================================================================
    
    // ================================================================================
    // Комната в аренду посуточно
    // (начало)=============================================
    if ($obj_type == '23') {
        
        $price_ed = "руб./сутки";
        $query = "SELECT * FROM rent24_kmn WHERE id='" . (int) $obj_id .
                 "' AND status='0'";
        $res = $db->query($query);
        $kolvo = $res->num_rows;
        if ($kolvo == '1') {
            // Есть такое объявление
            // ++++++++++++++++++++++++++++++++
            $ar = $res->fetch_assoc();
            $ld .= "Сдам посуточно ";
            $ld .= get_kmntype_by_id($db, $ar['kmn_type_id']) . " пл. " .
                     $ar['kmn_pl'] . "кв.м, " . $ar['kmn_floor'] . "/" .
                     $ar['zd_floors'] .
                     get_material_by_id($db, $ar['zd_material_id']) . ", ";
            
            // + ГОРОД
            if ($ar['geo_gorod_id'] != "1") { // Великий Новгород не пишем (это
                                              // по умолчанию)
                if ($ar['geo_gorod_id'] != "-1") {
                    // если есть номер города, тогда извлекаем название
                    $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
                } else {
                    // если нет номера города (номер =-1)
                    if (strlen(trim($ar['geo_gorod'])) > 0) {
                        // город указан вручную
                        $ld .= $ar['geo_gorod'] . ", ";
                    } else {
                        // город НЕ указан вручную, невозможная ситуация - т.к.
                        // должен быть указан город
                        $ld .= "[неизвестный населенный пункт], ";
                    }
                }
            }
            
            // + УЛИЦА
            if ($ar['geo_street_id'] != "-1") {
                // если есть номер улицы, тогда извлекаем название
                $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
            } else {
                // если нет номера улицы (номер =-1)
                if (strlen(trim($ar['geo_street'])) > 0) {
                    // улица указана вручную
                    $ld .= $ar['geo_street'] . ", ";
                } else {
                    // улица НЕ указана вручную, невозможная ситуация - т.к.
                    // должна быть указана улица
                    $ld .= "[неизвестная улица], ";
                }
            }
            
            // + НОМЕР ДОМА
            $ld .= "д. " . $ar['geo_n_doma'] . " ";
            
            // + КОРПУС ДОМА
            if (strlen($ar['geo_n_korp']) > 0) {
                $ld .= "к. " . $ar['geo_n_korp'] . " ";
            }
            
            // + ЦЕНА и ТОРГ
            
            if ($ar['price_torg'] == '5') {
                // без торга
                $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                         ", без торга";
            } else {
                if ($ar['price_torg'] == '4') {
                    // возможен торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                             ", торг";
                } else {
                    // не указано про торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed;
                }
            }
            
            // ++++++++++++++++++++++++++++++++
            return $ld;
        } else {
            // Нет такого объявления
            return "[Ошибка: неизвестное объявление о посуточной аренде комнаты, id=" .
                     (int) $obj_id . "]";
        }
    }
    
    // Комната в аренду посуточно
    // (конец)=============================================
    // ===============================================================================
    
    // ================================================================================
    // Дом, коттедж на продажу
    // (начало)================================================
    if ($obj_type == '51') {
        $price_ed = "тыс. руб.";
        $query = "SELECT * FROM sell_dom WHERE id='" . (int) $obj_id .
                 "' AND status='0'";
        $res = $db->query($query);
        $kolvo = $res->num_rows;
        if ($kolvo == '1') {
            // Есть такое объявление
            // ++++++++++++++++++++++++++++++++
            $ar = $res->fetch_assoc();
            $ld .= "Продам ";
            $ld .= get_domtype_by_id($db, $ar['dom_type']) . " (" .
                     get_dommaterial_by_id($db, $ar['dom_material_id']) . "), ";
            
            $ld .= "пл. " . $ar['dom_pl_ob'];
            if ($ar['dom_pl_zh'] > 0) {
                $ld .= "/" . $ar['dom_pl_zh'];
            }
            
            $ld .= " кв.м, ";
            
            if ($ar['dom_floors'] >= 2) {
                $ld .= $ar['dom_floors'] . "-эт., ";
            }
            
            // + ГОРОД
            if ($ar['geo_gorod_id'] != "-1") {
                // если есть номер города, тогда извлекаем название
                $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
            } else {
                // если нет номера города (номер =-1)
                if (strlen(trim($ar['geo_gorod'])) > 0) {
                    // город указан вручную
                    $ld .= $ar['geo_gorod'] . ", ";
                } else {
                    // город НЕ указан вручную, невозможная ситуация - т.к.
                    // должен быть указан город
                    $ld .= "[неизвестный населенный пункт], ";
                }
            }
            
            // + УЛИЦА
            if ($ar['geo_street_id'] != "0") { // если вообще указана (не равно
                                               // 0
                                               // )
                if ($ar['geo_street_id'] != "-1") {
                    // если есть номер улицы, тогда извлекаем название
                    $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
                } else {
                    // если нет номера улицы (номер =-1)
                    if (strlen(trim($ar['geo_street'])) > 0) {
                        // улица указана вручную
                        $ld .= $ar['geo_street'] . ", ";
                    } else {
                        // улица НЕ указана вручную, невозможная ситуация - т.к.
                        // должна быть указана улица
                        $ld .= "[неизвестная улица], ";
                    }
                }
            }
            
            // + ЦЕНА и ТОРГ
            
            if ($ar['price_torg'] == '5') {
                // без торга
                $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                         ", без торга";
            } else {
                if ($ar['price_torg'] == '4') {
                    // возм. торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                             ", торг";
                } else {
                    // не указано про торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed;
                }
            }
            
            // ++++++++++++++++++++++++++++++++
            return $ld;
        } else {
            // Нет такого объявления
            return "[Ошибка: неизвестное объявление о продаже дома/коттеджа, id=" .
                     (int) $obj_id . "]";
        }
    }
    
    // Дом, коттедж на продажу
    // (конец)================================================
    // ===============================================================================
    
    // =================================================================================
    // Дом, коттедж в аренду
    // (начало)===================================================
    if ($obj_type == '52') {
        $price_ed = "руб./мес.";
        $query = "SELECT * FROM rent_dom WHERE id='" . (int) $obj_id .
                 "' AND status='0'";
        $res = $db->query($query);
        $kolvo = $res->num_rows;
        if ($kolvo == '1') {
            // Есть такое объявление
            // ++++++++++++++++++++++++++++++++
            $ar = $res->fetch_assoc();
            $ld .= "Сдам ";
            $ld .= get_domtype_by_id($db, $ar['dom_type']) . " (" .
                     get_dommaterial_by_id($db, $ar['dom_material_id']) . "), ";
            
            $ld .= "пл. " . $ar['dom_pl_ob'];
            if ($ar['dom_pl_zh'] > 0) {
                $ld .= "/" . $ar['dom_pl_zh'];
            }
            
            $ld .= " кв.м, ";
            
            if ($ar['dom_floors'] >= 2) {
                $ld .= $ar['dom_floors'] . "-эт., ";
            }
            
            // + ГОРОД
            if ($ar['geo_gorod_id'] != "-1") {
                // если есть номер города, тогда извлекаем название
                $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
            } else {
                // если нет номера города (номер =-1)
                if (strlen(trim($ar['geo_gorod'])) > 0) {
                    // город указан вручную
                    $ld .= $ar['geo_gorod'] . ", ";
                } else {
                    // город НЕ указан вручную, невозможная ситуация - т.к.
                    // должен быть указан город
                    $ld .= "[неизвестный населенный пункт], ";
                }
            }
            
            // + УЛИЦА
            if ($ar['geo_street_id'] != "0") { // если вообще указана (не равно
                                               // 0
                                               // )
                if ($ar['geo_street_id'] != "-1") {
                    // если есть номер улицы, тогда извлекаем название
                    $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
                } else {
                    // если нет номера улицы (номер =-1)
                    if (strlen(trim($ar['geo_street'])) > 0) {
                        // улица указана вручную
                        $ld .= $ar['geo_street'] . ", ";
                    } else {
                        // улица НЕ указана вручную, невозможная ситуация - т.к.
                        // должна быть указана улица
                        $ld .= "[неизвестная улица], ";
                    }
                }
            }
            
            // + ЦЕНА и ТОРГ
            
            if ($ar['price_torg'] == '5') {
                // без торга
                $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                         ", без торга";
            } else {
                if ($ar['price_torg'] == '4') {
                    // возм. торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                             ", торг";
                } else {
                    // не указано про торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed;
                }
            }
            
            // ++++++++++++++++++++++++++++++++
            return $ld;
        } else {
            // Нет такого объявления
            return "[Ошибка: неизвестное объявление об аренде дома/коттеджа, id=" .
                     (int) $obj_id . "]";
        }
    }
    
    // Дом, коттедж в аренду
    // (конец)===================================================
    // ================================================================================
    
    // =================================================================================
    // Дом, коттедж в аренду посуточно
    // (начало)=========================================
    if ($obj_type == '53') {
        $price_ed = "руб./сутки";
        $query = "SELECT * FROM rent24_dom WHERE id='" . (int) $obj_id .
                 "' AND status='0'";
        $res = $db->query($query);
        $kolvo = $res->num_rows;
        if ($kolvo == '1') {
            // Есть такое объявление
            // ++++++++++++++++++++++++++++++++
            $ar = $res->fetch_assoc();
            $ld .= "Сдам посуточно ";
            $ld .= get_domtype_by_id($db, $ar['dom_type']) . " (" .
                     get_dommaterial_by_id($db, $ar['dom_material_id']) . "), ";
            
            $ld .= "пл. " . $ar['dom_pl_ob'];
            if ($ar['dom_pl_zh'] > 0) {
                $ld .= "/" . $ar['dom_pl_zh'];
            }
            
            $ld .= " кв.м, ";
            
            if ($ar['dom_floors'] >= 2) {
                $ld .= $ar['dom_floors'] . "-эт., ";
            }
            
            // + ГОРОД
            if ($ar['geo_gorod_id'] != "-1") {
                // если есть номер города, тогда извлекаем название
                $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
            } else {
                // если нет номера города (номер =-1)
                if (strlen(trim($ar['geo_gorod'])) > 0) {
                    // город указан вручную
                    $ld .= $ar['geo_gorod'] . ", ";
                } else {
                    // город НЕ указан вручную, невозможная ситуация - т.к.
                    // должен быть указан город
                    $ld .= "[неизвестный населенный пункт], ";
                }
            }
            
            // + УЛИЦА
            if ($ar['geo_street_id'] != "0") { // если вообще указана (не равно
                                               // 0
                                               // )
                if ($ar['geo_street_id'] != "-1") {
                    // если есть номер улицы, тогда извлекаем название
                    $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
                } else {
                    // если нет номера улицы (номер =-1)
                    if (strlen(trim($ar['geo_street'])) > 0) {
                        // улица указана вручную
                        $ld .= $ar['geo_street'] . ", ";
                    } else {
                        // улица НЕ указана вручную, невозможная ситуация - т.к.
                        // должна быть указана улица
                        $ld .= "[неизвестная улица], ";
                    }
                }
            }
            
            // + ЦЕНА и ТОРГ
            
            if ($ar['price_torg'] == '5') {
                // без торга
                $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                         ", без торга";
            } else {
                if ($ar['price_torg'] == '4') {
                    // возм. торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                             ", торг";
                } else {
                    // не указано про торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed;
                }
            }
            
            // ++++++++++++++++++++++++++++++++
            return $ld;
        } else {
            // Нет такого объявления
            return "[Ошибка: неизвестное объявление о посуточной аренде дома/коттеджа, id=" .
                     (int) $obj_id . "]";
        }
    }
    
    // Дом, коттедж в аренду посуточно
    // (конец)=========================================
    // ================================================================================
    
    // =================================================================================
    // Участок, дача на продажу
    // (начало)================================================
    if ($obj_type == '71') {
        $price_ed = "тыс. руб.";
        $query = "SELECT * FROM sell_uch WHERE id='" . (int) $obj_id .
                 "' AND status='0'";
        $res = $db->query($query);
        $kolvo = $res->num_rows;
        if ($kolvo == '1') {
            // Есть такое объявление
            // ++++++++++++++++++++++++++++++++
            $ar = $res->fetch_assoc();
            $ld .= "Продам ";
            $ld .= get_uchtype_by_id($db, $ar['uch_type']) . ", ";
            
            if ($ar['uch_pl'] < 100) {
                $ld .= "пл. " . $ar['uch_pl'] . " соток";
            } else {
                $ld .= "пл. " . ($ar['uch_pl'] / 100) . " га";
            }
            
            $ld .= ", ";
            
            // + ГОРОД
            if ($ar['geo_gorod_id'] != "-1") {
                // если есть номер города, тогда извлекаем название
                $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
            } else {
                // если нет номера города (номер =-1)
                if (strlen(trim($ar['geo_gorod'])) > 0) {
                    // город указан вручную
                    $ld .= $ar['geo_gorod'] . ", ";
                } else {
                    // город НЕ указан вручную, невозможная ситуация - т.к.
                    // должен быть указан город
                    $ld .= "[неизвестный населенный пункт], ";
                }
            }
            
            // + УЛИЦА
            if ($ar['geo_street_id'] != "0") { // если вообще указана (не равно
                                               // 0
                                               // )
                if ($ar['geo_street_id'] != "-1") {
                    // если есть номер улицы, тогда извлекаем название
                    $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
                } else {
                    // если нет номера улицы (номер =-1)
                    if (strlen(trim($ar['geo_street'])) > 0) {
                        // улица указана вручную
                        $ld .= $ar['geo_street'] . ", ";
                    } else {
                        // улица НЕ указана вручную, невозможная ситуация - т.к.
                        // должна быть указана улица
                        $ld .= "[неизвестная улица], ";
                    }
                }
            }
            
            // + ЦЕНА и ТОРГ
            
            if ($ar['price_torg'] == '5') {
                // без торга
                $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                         ", без торга";
            } else {
                if ($ar['price_torg'] == '4') {
                    // возможен торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                             ", торг";
                } else {
                    // не указано про торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed;
                }
            }
            
            // ++++++++++++++++++++++++++++++++
            return $ld;
        } else {
            // Нет такого объявления
            return "[Ошибка: неизвестное объявление о продаже участка/дачи, id=" .
                     (int) $obj_id . "]";
        }
    }
    
    // Участок, дача на продажу
    // (конец)================================================
    // ================================================================================
    
    // =================================================================================
    // Участок, дача в аренду
    // (начало)==================================================
    if ($obj_type == '72') {
        $price_ed = "руб./мес.";
        $query = "SELECT * FROM rent_uch WHERE id='" . (int) $obj_id .
                 "' AND status='0'";
        $res = $db->query($query);
        $kolvo = $res->num_rows;
        if ($kolvo == '1') {
            // Есть такое объявление
            // ++++++++++++++++++++++++++++++++
            $ar = $res->fetch_assoc();
            $ld .= "Сдам в аренду ";
            $ld .= get_uchtype_by_id($db, $ar['uch_type']) . ", ";
            
            if ($ar['uch_pl'] < 100) {
                $ld .= "пл. " . $ar['uch_pl'] . " соток";
            } else {
                $ld .= "пл. " . ($ar['uch_pl'] / 100) . " га";
            }
            
            $ld .= ", ";
            
            // + ГОРОД
            if ($ar['geo_gorod_id'] != "-1") {
                // если есть номер города, тогда извлекаем название
                $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
            } else {
                // если нет номера города (номер =-1)
                if (strlen(trim($ar['geo_gorod'])) > 0) {
                    // город указан вручную
                    $ld .= $ar['geo_gorod'] . ", ";
                } else {
                    // город НЕ указан вручную, невозможная ситуация - т.к.
                    // должен быть указан город
                    $ld .= "[неизвестный населенный пункт], ";
                }
            }
            
            // + УЛИЦА
            if ($ar['geo_street_id'] != "0") { // если вообще указана (не равно
                                               // 0
                                               // )
                if ($ar['geo_street_id'] != "-1") {
                    // если есть номер улицы, тогда извлекаем название
                    $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
                } else {
                    // если нет номера улицы (номер =-1)
                    if (strlen(trim($ar['geo_street'])) > 0) {
                        // улица указана вручную
                        $ld .= $ar['geo_street'] . ", ";
                    } else {
                        // улица НЕ указана вручную, невозможная ситуация - т.к.
                        // должна быть указана улица
                        $ld .= "[неизвестная улица], ";
                    }
                }
            }
            
            // + ЦЕНА и ТОРГ
            
            if ($ar['price_torg'] == '5') {
                // без торга
                $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                         ", без торга";
            } else {
                if ($ar['price_torg'] == '4') {
                    // возможен торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed .
                             ", торг";
                } else {
                    // не указано про торг
                    $ld .= "за " . (int) $ar['price'] . " " . $price_ed;
                }
            }
            
            // ++++++++++++++++++++++++++++++++
            return $ld;
        } else {
            // Нет такого объявления
            return "[Ошибка: неизвестное объявление об аренде участка/дачи, id=" .
                     (int) $obj_id . "]";
        }
    }
    
    // Участок, дача в аренду
    // (конец)==================================================
    // ================================================================================
    
    // Коммерческая недвижимость на продажу
    if ($obj_type == '91') {
        /*
         * $db_table='sell_komm'; // Пока не реализовано
         */
    }
    
    // Коммерческая недвижимость в аренду
    if ($obj_type == '92') {
        /*
         * $db_table='rent_komm'; // Пока не реализовано
         */
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// Функция возвращает текст объявления по номеру ID квартиры (продажа)
function get_kv_obyav_by_id ($db, $kv_id)
{
    $query = "SELECT * FROM sell_kva WHERE id='" . (int) $kv_id . "'";
    $res = $db->query($query);
    $kv_kolvo = mysqli_num_rows($res);
    $ar = mysqli_fetch_assoc($res);
    if ($kv_kolvo == '1') {
        // Есть такое объявление
        // ++++++++++++++++++++++++++++++++
        $ld = "";
        $ld .= "Продам ";
        $ld .= $ar['kva_rooms'] . "-к.кв., " . $ar['kva_floor'] . "/" .
                 $ar['zd_floors'] .
                 get_material_by_id($db, $ar['zd_material_id']) . ", " .
                 $ar['kva_pl_ob'] . "/" . $ar['kva_pl_zh'] . "/" .
                 $ar['kva_pl_kuh'] . ", ";
        
        // + ГОРОД
        if ($ar['geo_gorod_id'] != "1") { // Великий Новгород не пишем (это по
                                          // умолчанию)
            if ($ar['geo_gorod_id'] != "-1") {
                // если есть номер города, тогда извлекаем название
                $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
            } else {
                // если нет номера города (номер =-1)
                if (strlen(trim($ar['geo_gorod'])) > 0) {
                    // город указан вручную
                    $ld .= $ar['geo_gorod'] . ", ";
                } else {
                    // город НЕ указан вручную, невозможная ситуация - т.к.
                    // должен быть указан город
                    $ld .= "[неизвестный населенный пункт], ";
                }
            }
        }
        
        // + УЛИЦА
        if ($ar['geo_street_id'] != "-1") {
            // если есть номер улицы, тогда извлекаем название
            $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
        } else {
            // если нет номера улицы (номер =-1)
            if (strlen(trim($ar['geo_street'])) > 0) {
                // улица указана вручную
                $ld .= $ar['geo_street'] . ", ";
            } else {
                // улица НЕ указана вручную, невозможная ситуация - т.к. должна
                // быть указана улица
                $ld .= "[неизвестная улица], ";
            }
        }
        
        // + НОМЕР ДОМА
        $ld .= "д. " . $ar['geo_n_doma'] . " ";
        
        // + КОРПУС ДОМА
        if (strlen($ar['geo_n_korp']) > 0) {
            $ld .= "к. " . $ar['geo_n_korp'] . " ";
        }
        
        // + ЦЕНА и ТОРГ
        
        if ($ar['price_torg'] == '5') {
            // без торга
            $ld .= "за " . (int) $ar['price'] . " тыс.руб., без торга";
        } else {
            if ($ar['price_torg'] == '4') {
                // возможен торг
                $ld .= "за " . (int) $ar['price'] . " тыс.руб., торг";
            } else {
                // не указано про торг
                $ld .= "за " . (int) $ar['price'] . " тыс.руб.";
            }
        }
        
        // ++++++++++++++++++++++++++++++++
        return $ld;
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление о продаже квартиры, id=" . (int) $kv_id .
                 "]";
    }
}

// +++++++++++++++++++++++ АРЕНДА
// Функция возвращает текст объявления по номеру ID квартиры (аренда)
function get_kv_rent_obyav_by_id ($db, $kv_id)
{
    $query = "SELECT * FROM rent_kva WHERE id='" . (int) $kv_id . "'";
    $res = $db->query($query);
    $kv_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kv_kolvo == '1') {
        // Есть такое объявление
        // ++++++++++++++++++++++++++++++++
        $ld = "";
        $ld .= "Сдам ";
        $ld .= $ar['kva_rooms'] . "-к.кв., " . $ar['kva_floor'] . "/" .
                 $ar['zd_floors'] .
                 get_material_by_id($db, $ar['zd_material_id']) . ", " .
                 $ar['kva_pl_ob'] . "/" . $ar['kva_pl_zh'] . "/" .
                 $ar['kva_pl_kuh'] . ", ";
        
        // + ГОРОД
        if ($ar['geo_gorod_id'] != "1") { // Великий Новгород не пишем (это по
                                          // умолчанию)
            if ($ar['geo_gorod_id'] != "-1") {
                // если есть номер города, тогда извлекаем название
                $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
            } else {
                // если нет номера города (номер =-1)
                if (strlen(trim($ar['geo_gorod'])) > 0) {
                    // город указан вручную
                    $ld .= $ar['geo_gorod'] . ", ";
                } else {
                    // город НЕ указан вручную, невозможная ситуация - т.к.
                    // должен быть указан город
                    $ld .= "[неизвестный населенный пункт], ";
                }
            }
        }
        
        // + УЛИЦА
        if ($ar['geo_street_id'] != "-1") {
            // если есть номер улицы, тогда извлекаем название
            $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
        } else {
            // если нет номера улицы (номер =-1)
            if (strlen(trim($ar['geo_street'])) > 0) {
                // улица указана вручную
                $ld .= $ar['geo_street'] . ", ";
            } else {
                // улица НЕ указана вручную, невозможная ситуация - т.к. должна
                // быть указана улица
                $ld .= "[неизвестная улица], ";
            }
        }
        
        // + НОМЕР ДОМА
        $ld .= "д. " . $ar['geo_n_doma'] . " ";
        
        // + КОРПУС ДОМА
        if (strlen($ar['geo_n_korp']) > 0) {
            $ld .= "к. " . $ar['geo_n_korp'] . " ";
        }
        
        // + ЦЕНА и ТОРГ
        
        if ($ar['price_torg'] == '5') {
            // без торга
            $ld .= "за " . (int) $ar['price'] . " руб./мес., без торга";
        } else {
            if ($ar['price_torg'] == '4') {
                // возможен торг
                $ld .= "за " . (int) $ar['price'] . " руб./мес., торг";
            } else {
                // не указано про торг
                $ld .= "за " . (int) $ar['price'] . " руб./мес.";
            }
        }
        
        // ++++++++++++++++++++++++++++++++
        return $ld;
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление об аренде квартиры, id=" . (int) $kv_id .
                 "]";
    }
}

// +++++++++++++++++++++++

// Функция возвращает примечания к объявлению по номеру ID квартиры (продажа)
function get_kv_descr_by_id ($db, $kv_id)
{
    $query = "SELECT * FROM sell_kva WHERE id='" . (int) $kv_id . "'";
    $res = $db->query($query);
    $kv_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kv_kolvo == '1') {
        // Есть такое объявление
        return $ar['descr'];
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление]";
    }
}

// Функция возвращает примечания к объявлению по номеру ID квартиры (аренда)
function get_kv_rent_descr_by_id ($db, $kv_id)
{
    $query = "SELECT * FROM rent_kva WHERE id='" . (int) $kv_id . "'";
    $res = $db->query($query);
    $kv_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kv_kolvo == '1') {
        // Есть такое объявление
        return $ar['descr'];
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление]";
    }
}

// Функция возвращает контакты к объявлению по номеру ID квартиры (продажа)
function get_kv_conta_by_id ($db, $kv_id)
{
    $query = "SELECT *FROM sell_kva WHERE id='" . (int) $kv_id . "'";
    $res = $db->query($query);
    $kv_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kv_kolvo == '1') {
        // Есть такое объявление
        return $ar['contacts'];
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление]";
    }
}

// Функция возвращает контакты к объявлению по номеру ID квартиры (аренда)
function get_kv_rent_conta_by_id ($db, $kv_id)
{
    $query = "SELECT * FROM rent_kva WHERE id='" . (int) $kv_id . "'";
    $res = $db->query($query);
    $kv_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kv_kolvo == '1') {
        // Есть такое объявление
        return $ar['contacts'];
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление]";
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++

// Функция для логирования действий с комнатами
function loging_add_kmnrecord ($db, $p_user_id, $p_action_id, $p_kmn_id, 
        $p_descr, $p_xtra1, $p_xtra2)
{
    $query = "INSERT INTO logs (id, date_fixed, user_id,  action_id, subject_id, descr,  sec_ip, xtra1, xtra2) VALUES (NULL,'" .
             time() . "','" . (int) $p_user_id . "','" . (int) $p_action_id .
             "','" . (int) $p_kmn_id . "','" . $p_descr . "','" .
             $_SERVER['REMOTE_ADDR'] . "','" . $p_xtra1 . "','" . $p_xtra2 .
             "');";
    $res = $db->query($query);
}

// Функция возвращает наименование типа комнаты по номеру ID типа комнаты
function get_kmntype_by_id ($db, $kmntype_id)
{
    $query = "SELECT * FROM spr_kmn_type  WHERE id='" . (int) $kmntype_id . "'";
    $res = $db->query($query);
    $type_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($type_kolvo == '1') {
        // Есть такой тип комнаты
        return $ar['title_vn'];
    } else {
        // Нет такого типа комнаты
        return "[Неизвестный тип комнаты]";
    }
}

// Функция возвращает текст объявления по номеру ID комнаты (продажа)
function get_kmn_obyav_by_id ($db, $kmn_id)
{
    $query = "SELECT * FROM sell_kmn  WHERE id='" . (int) $kmn_id . "'";
    $res = $db->query($query);
    $kmn_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kmn_kolvo == '1') {
        // Есть такое объявление
        // ++++++++++++++++++++++++++++++++
        $ld = "";
        $ld .= "Продам ";
        $ld .= get_kmntype_by_id($db, $ar['kmn_type_id']) . " пл. " .
                 $ar['kmn_pl'] . "кв.м, " . $ar['kmn_floor'] . "/" .
                 $ar['zd_floors'] . get_material_by_id($db, 
                        $ar['zd_material_id']) . ", ";
        
        // + ГОРОД
        if ($ar['geo_gorod_id'] != "1") { // Великий Новгород не пишем (это по
                                          // умолчанию)
            if ($ar['geo_gorod_id'] != "-1") {
                // если есть номер города, тогда извлекаем название
                $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
            } else {
                // если нет номера города (номер =-1)
                if (strlen(trim($ar['geo_gorod'])) > 0) {
                    // город указан вручную
                    $ld .= $ar['geo_gorod'] . ", ";
                } else {
                    // город НЕ указан вручную, невозможная ситуация - т.к.
                    // должен быть указан город
                    $ld .= "[неизвестный населенный пункт], ";
                }
            }
        }
        
        // + УЛИЦА
        if ($ar['geo_street_id'] != "-1") {
            // если есть номер улицы, тогда извлекаем название
            $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
        } else {
            // если нет номера улицы (номер =-1)
            if (strlen(trim($ar['geo_street'])) > 0) {
                // улица указана вручную
                $ld .= $ar['geo_street'] . ", ";
            } else {
                // улица НЕ указана вручную, невозможная ситуация - т.к. должна
                // быть указана улица
                $ld .= "[неизвестная улица], ";
            }
        }
        
        // + НОМЕР ДОМА
        $ld .= "д. " . $ar['geo_n_doma'] . " ";
        
        // + КОРПУС ДОМА
        if (strlen($ar['geo_n_korp']) > 0) {
            $ld .= "к. " . $ar['geo_n_korp'] . " ";
        }
        
        // + ЦЕНА и ТОРГ
        
        if ($ar['price_torg'] == '5') {
            // без торга
            $ld .= "за " . (int) $ar['price'] . " т.р., без торга";
        } else {
            if ($ar['price_torg'] == '4') {
                // возможен торг
                $ld .= "за " . (int) $ar['price'] . " т.р., торг";
            } else {
                // не указано про торг
                $ld .= "за " . (int) $ar['price'] . " т.р.";
            }
        }
        
        // ++++++++++++++++++++++++++++++++
        return $ld;
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление о продаже комнаты, id=" . (int) $kmn_id .
                 "]";
    }
}

// Функция возвращает текст объявления по номеру ID комнаты (аренда)
function get_kmn_rent_obyav_by_id ($db, $kmn_id)
{
    $query = "SELECT * FROM rent_kmn  WHERE id='" . (int) $kmn_id . "'";
    $res = $db->query($query);
    $kmn_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kmn_kolvo == '1') {
        // Есть такое объявление
        // ++++++++++++++++++++++++++++++++
        $ld = "";
        $ld .= "Продам ";
        $ld .= get_kmntype_by_id($db, $ar['kmn_type_id']) . " пл. " .
                 $ar['kmn_pl'] . "кв.м, " . $ar['kmn_floor'] . "/" .
                 $ar['zd_floors'] . get_material_by_id($db, 
                        $ar['zd_material_id']) . ", ";
        
        // + ГОРОД
        if ($ar['geo_gorod_id'] != "1") { // Великий Новгород не пишем (это по
                                          // умолчанию)
            if ($ar['geo_gorod_id'] != "-1") {
                // если есть номер города, тогда извлекаем название
                $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
            } else {
                // если нет номера города (номер =-1)
                if (strlen(trim($ar['geo_gorod'])) > 0) {
                    // город указан вручную
                    $ld .= $ar['geo_gorod'] . ", ";
                } else {
                    // город НЕ указан вручную, невозможная ситуация - т.к.
                    // должен быть указан город
                    $ld .= "[неизвестный населенный пункт], ";
                }
            }
        }
        
        // + УЛИЦА
        if ($ar['geo_street_id'] != "-1") {
            // если есть номер улицы, тогда извлекаем название
            $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
        } else {
            // если нет номера улицы (номер =-1)
            if (strlen(trim($ar['geo_street'])) > 0) {
                // улица указана вручную
                $ld .= $ar['geo_street'] . ", ";
            } else {
                // улица НЕ указана вручную, невозможная ситуация - т.к. должна
                // быть указана улица
                $ld .= "[неизвестная улица], ";
            }
        }
        
        // + НОМЕР ДОМА
        $ld .= "д. " . $ar['geo_n_doma'] . " ";
        
        // + КОРПУС ДОМА
        if (strlen($ar['geo_n_korp']) > 0) {
            $ld .= "к. " . $ar['geo_n_korp'] . " ";
        }
        
        // + ЦЕНА и ТОРГ
        
        if ($ar['price_torg'] == '5') {
            // без торга
            $ld .= "за " . (int) $ar['price'] . " руб./мес., без торга";
        } else {
            if ($ar['price_torg'] == '4') {
                // возможен торг
                $ld .= "за " . (int) $ar['price'] . " руб./мес., торг";
            } else {
                // не указано про торг
                $ld .= "за " . (int) $ar['price'] . " руб./мес.";
            }
        }
        
        // ++++++++++++++++++++++++++++++++
        return $ld;
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление об аренде комнаты, id=" . (int) $kmn_id .
                 "]";
    }
}

// Функция возвращает примечания к объявлению по номеру ID комнаты (продажа)
function get_kmn_descr_by_id ($db, $kmn_id)
{
    $query = "SELECT * FROM sell_kmn  WHERE id='" . (int) $kmn_id . "'";
    $res = $db->query($query);
    $kmn_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kmn_kolvo == '1') {
        // Есть такое объявление
        return $ar['descr'];
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление]";
    }
}

// Функция возвращает примечания к объявлению по номеру ID комнаты (аренда)
function get_kmn_rent_descr_by_id ($db, $kmn_id)
{
    $query = "SELECT * FROM rent_kmn  WHERE id='" . (int) $kmn_id . "'";
    $res = $db->query($query);
    $kmn_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kmn_kolvo == '1') {
        // Есть такое объявление
        return $ar['descr'];
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление]";
    }
}

// Функция возвращает контакты к объявлению по номеру ID комнаты (продажа)
function get_kmn_conta_by_id ($db, $kmn_id)
{
    $query = "SELECT * FROM sell_kmn  WHERE id='" . (int) $kmn_id . "'";
    $res = $db->query($query);
    $kmn_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kmn_kolvo == '1') {
        // Есть такое объявление
        return $ar['contacts'];
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление]";
    }
}

// Функция возвращает контакты к объявлению по номеру ID комнаты (аренда)
function get_kmn_rent_conta_by_id ($db, $kmn_id)
{
    $query = "SELECT * FROM rent_kmn  WHERE id='" . (int) $kmn_id . "'";
    $res = $db->query($query);
    $kmn_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kmn_kolvo == '1') {
        // Есть такое объявление
        return $ar['contacts'];
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление]";
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++

// Функция для логирования действий с домами
function loging_add_domrecord ($db, $p_user_id, $p_action_id, $p_dom_id, 
        $p_descr, $p_xtra1, $p_xtra2)
{
    $query = "INSERT INTO logs (id, date_fixed, user_id,  action_id,  subject_id, descr,  sec_ip, xtra1, xtra2) VALUES (NULL,'" .
             time() . "','" . (int) $p_user_id . "','" . (int) $p_action_id .
             "','" . (int) $p_dom_id . "','" . $p_descr . "','" .
             $_SERVER['REMOTE_ADDR'] . "','" . $p_xtra1 . "','" . $p_xtra2 .
             "');";
    $res = $db->query($query);
}

// Функция возвращает наименование типа дома по номеру ID типа дома
function get_domtype_by_id ($db, $domtype_id)
{
    $query = "SELECT * FROM spr_dom_type  WHERE id='" . (int) $domtype_id . "'";
    $res = $db->query($query);
    $type_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($type_kolvo == '1') {
        // Есть такой тип дома
        return $ar['title_d'];
    } else {
        // Нет такого типа дома
        return "[Неизвестный тип дома]";
    }
}

// Функция возвращает текст объявления по номеру ID дома (продажа)
function get_dom_obyav_by_id ($db, $dom_id)
{
    $query = "SELECT * FROM sell_dom  WHERE id='" . (int) $dom_id . "'";
    $res = $db->query($query);
    $dom_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($dom_kolvo == '1') {
        // Есть такое объявление
        // ++++++++++++++++++++++++++++++++
        $ld = "";
        $ld .= "Продам ";
        $ld .= get_domtype_by_id($db, $ar['dom_type']) . " (" .
                 get_dommaterial_by_id($db, $ar['dom_material_id']) . "), ";
        
        $ld .= "пл. " . $ar['dom_pl_ob'];
        if ($ar['dom_pl_zh'] > 0) {
            $ld .= "/" . $ar['dom_pl_zh'];
        }
        
        $ld .= " кв.м, ";
        
        if ($ar['dom_floors'] >= 2) {
            $ld .= $ar['dom_floors'] . "-эт., ";
        }
        
        // + ГОРОД
        if ($ar['geo_gorod_id'] != "-1") {
            // если есть номер города, тогда извлекаем название
            $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
        } else {
            // если нет номера города (номер =-1)
            if (strlen(trim($ar['geo_gorod'])) > 0) {
                // город указан вручную
                $ld .= $ar['geo_gorod'] . ", ";
            } else {
                // город НЕ указан вручную, невозможная ситуация - т.к. должен
                // быть указан город
                $ld .= "[неизвестный населенный пункт], ";
            }
        }
        
        // + УЛИЦА
        if ($ar['geo_street_id'] != "0") { // если вообще указана (не равно 0 )
            if ($ar['geo_street_id'] != "-1") {
                // если есть номер улицы, тогда извлекаем название
                $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
            } else {
                // если нет номера улицы (номер =-1)
                if (strlen(trim($ar['geo_street'])) > 0) {
                    // улица указана вручную
                    $ld .= $ar['geo_street'] . ", ";
                } else {
                    // улица НЕ указана вручную, невозможная ситуация - т.к.
                    // должна быть указана улица
                    $ld .= "[неизвестная улица], ";
                }
            }
        }
        
        // + ЦЕНА и ТОРГ
        
        if ($ar['price_torg'] == '5') {
            // без торга
            $ld .= "за " . (int) $ar['price'] . " т.р., без торга";
        } else {
            if ($ar['price_torg'] == '4') {
                // возм. торг
                $ld .= "за " . (int) $ar['price'] . " т.р., торг";
            } else {
                // не указано про торг
                $ld .= "за " . (int) $ar['price'] . " т.р.";
            }
        }
        
        // ++++++++++++++++++++++++++++++++
        return $ld;
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление о продаже дома, id=" . (int) $dom_id .
                 "]";
    }
}

// Функция возвращает примечания к объявлению по номеру ID дома (продажа)
function get_dom_descr_by_id ($db, $dom_id)
{
    $query = "SELECT * FROM sell_dom  WHERE id='" . (int) $dom_id . "'";
    $res = $db->query($query);
    $dom_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($dom_kolvo == '1') {
        // Есть такое объявление
        return $ar['descr'];
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление]";
    }
}

// Функция возвращает контакты к объявлению по номеру ID дома (продажа)
function get_dom_conta_by_id ($db, $dom_id)
{
    $query = "SELECT * 
          FROM sell_dom  
          WHERE id='" . (int) $dom_id . "'
          ";
    $res = $db->query($query);
    $dom_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($dom_kolvo == '1') {
        // Есть такое объявление
        return $ar['contacts'];
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление]";
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++

// Функция для логирования действий с участками
function loging_add_uchrecord ($db, $p_user_id, $p_action_id, $p_uch_id, 
        $p_descr, $p_xtra1, $p_xtra2)
{
    $query = "INSERT INTO logs (id, date_fixed, user_id,  action_id,  subject_id, descr,  sec_ip, xtra1, xtra2) VALUES (NULL,'" .
             time() . "','" . (int) $p_user_id . "','" . (int) $p_action_id .
             "','" . (int) $p_uch_id . "','" . $p_descr . "','" .
             $_SERVER['REMOTE_ADDR'] . "','" . $p_xtra1 . "','" . $p_xtra2 .
             "');";
    $res = $db->query($query);
}

// Функция возвращает наименование типа участка по номеру ID типа участка
function get_uchtype_by_id ($db, $uchtype_id)
{
    $query = "SELECT * FROM spr_uch_type WHERE id='" . (int) $uchtype_id . "'";
    $res = $db->query($query);
    $type_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($type_kolvo == '1') {
        // Есть такой тип участка
        return $ar['title_d'];
    } else {
        // Нет такого типа участка
        return "[Неизвестный тип участка]";
    }
}

// Функция возвращает текст объявления по номеру ID участка (продажа)
function get_uch_obyav_by_id ($db, $uch_id)
{
    $query = "SELECT * FROM sell_uch WHERE id='" . (int) $uch_id . "'";
    $res = $db->query($query);
    $uch_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($uch_kolvo == '1') {
        // Есть такое объявление
        // ++++++++++++++++++++++++++++++++
        $ld = "";
        $ld .= "Продам ";
        $ld .= get_uchtype_by_id($db, $ar['uch_type']) . ", ";
        
        if ($ar['uch_pl'] < 100) {
            $ld .= "пл. " . $ar['uch_pl'] . " соток";
        } else {
            $ld .= "пл. " . ($ar['uch_pl'] / 100) . " га";
        }
        
        $ld .= ", ";
        
        // + СТРОЕНИЯ
        if ($ar['uch_stroen'] == "1") {
            $ld .= "со строениями, ";
        }
        
        // + ГОРОД
        if ($ar['geo_gorod_id'] != "-1") {
            // если есть номер города, тогда извлекаем название
            $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
        } else {
            // если нет номера города (номер =-1)
            if (strlen(trim($ar['geo_gorod'])) > 0) {
                // город указан вручную
                $ld .= $ar['geo_gorod'] . ", ";
            } else {
                // город НЕ указан вручную, невозможная ситуация - т.к. должен
                // быть указан город
                $ld .= "[неизвестный населенный пункт], ";
            }
        }
        
        // + УЛИЦА
        if ($ar['geo_street_id'] != "0") { // если вообще указана (не равно 0 )
            if ($ar['geo_street_id'] != "-1") {
                // если есть номер улицы, тогда извлекаем название
                $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
            } else {
                // если нет номера улицы (номер =-1)
                if (strlen(trim($ar['geo_street'])) > 0) {
                    // улица указана вручную
                    $ld .= $ar['geo_street'] . ", ";
                } else {
                    // улица НЕ указана вручную, невозможная ситуация - т.к.
                    // должна быть указана улица
                    $ld .= "[неизвестная улица], ";
                }
            }
        }
        
        // + ЦЕНА и ТОРГ
        
        if ($ar['price_torg'] == '5') {
            // без торга
            $ld .= "за " . (int) $ar['price'] . " т.р., без торга";
        } else {
            if ($ar['price_torg'] == '4') {
                // возможен торг
                $ld .= "за " . (int) $ar['price'] . " т.р., торг";
            } else {
                // не указано про торг
                $ld .= "за " . (int) $ar['price'] . " т.р.";
            }
        }
        
        // ++++++++++++++++++++++++++++++++
        return $ld;
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление о продаже участка, id=" . (int) $uch_id .
                 "]";
    }
}

// Функция возвращает примечания к объявлению по номеру ID участка (продажа)
function get_uch_descr_by_id ($db, $uch_id)
{
    $query = "SELECT * FROM sell_uch WHERE id='" . (int) $uch_id . "'";
    $res = $db->query($query);
    $uch_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($uch_kolvo == '1') {
        // Есть такое объявление
        return $ar['descr'];
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление]";
    }
}

// Функция возвращает контакты к объявлению по номеру ID участка (продажа)
function get_uch_conta_by_id ($db, $uch_id)
{
    $query = "SELECT * FROM sell_uch WHERE id='" . (int) $uch_id . "'";
    $res = $db->query($query);
    $uch_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($uch_kolvo == '1') {
        // Есть такое объявление
        return $ar['contacts'];
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление]";
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Функция возвращает адрес по номеру ID квартиры (продажа)
function get_dom4sale_adr_by_id ($db, $dom_id)
{
    $query = "SELECT * FROM sell_dom WHERE id='" . (int) $dom_id . "'";
    $res = $db->query($query);
    $kv_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kv_kolvo == '1') {
        // Есть такое объявление
        // ++++++++++++++++++++++++++++++++
        $ld = "";
        
        // + ГОРОД
        if ($ar['geo_gorod_id'] != "-1") {
            // если есть номер города, тогда извлекаем название
            $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']);
        } else {
            // если нет номера города (номер =-1)
            if (strlen(trim($ar['geo_gorod'])) > 0) {
                // город указан вручную
                $ld .= $ar['geo_gorod'];
            } else {
                // город НЕ указан вручную, невозможная ситуация - т.к. должен
                // быть указан город
                $ld .= "[неизвестный населенный пункт]";
            }
        }
        
        // + УЛИЦА
        if ($ar['geo_street_id'] > 0) {
            // если есть номер улицы, тогда извлекаем название
            $ld .= ", " . get_street_by_id($db, $ar['geo_street_id']);
        } else {
            // если нет номера улицы (номер =-1)
            if (strlen(trim($ar['geo_street'])) > 0) {
                // улица указана вручную
                $ld .= ", " . $ar['geo_street'];
            }
        }
        
        // + НОМЕР ДОМА
        if (strlen($ar['geo_n_doma']) > 0) {
            $ld .= ", д. " . $ar['geo_n_doma'];
        }
        
        // + КОРПУС ДОМА
        if (strlen($ar['geo_n_korp']) > 0) {
            $ld .= " к. " . $ar['geo_n_korp'] . " ";
        }
        
        // ++++++++++++++++++++++++++++++++
        return $ld;
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление о продаже дома/коттеджа, id=" .
                 (int) $dom_id . "]";
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Функция возвращает адрес по номеру ID участка (продажа)
function get_uch4sale_adr_by_id ($db, $uch_id)
{
    $query = "SELECT * 
          FROM sell_uch  
          WHERE id='" . (int) $uch_id . "'
          ";
    $res = $db->query($query);
    $kv_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kv_kolvo == '1') {
        // Есть такое объявление
        // ++++++++++++++++++++++++++++++++
        $ld = "";
        
        // + ГОРОД
        if ($ar['geo_gorod_id'] != "-1") {
            // если есть номер города, тогда извлекаем название
            $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']);
        } else {
            // если нет номера города (номер =-1)
            if (strlen(trim($ar['geo_gorod'])) > 0) {
                // город указан вручную
                $ld .= $ar['geo_gorod'];
            } else {
                // город НЕ указан вручную, невозможная ситуация - т.к. должен
                // быть указан город
                $ld .= "[неизвестный населенный пункт]";
            }
        }
        
        // + УЛИЦА
        if ($ar['geo_street_id'] > 0) {
            // если есть номер улицы, тогда извлекаем название
            $ld .= ", " . get_street_by_id($db, $ar['geo_street_id']);
        } else {
            // если нет номера улицы (номер =-1)
            if (strlen(trim($ar['geo_street'])) > 0) {
                // улица указана вручную
                $ld .= ", " . $ar['geo_street'];
            }
        }
        
        // + НОМЕР ДОМА
        if (strlen($ar['geo_n_doma']) > 0) {
            $ld .= ", д. " . $ar['geo_n_doma'];
        }
        
        // + КОРПУС ДОМА
        if (strlen($ar['geo_n_korp']) > 0) {
            $ld .= " к. " . $ar['geo_n_korp'] . " ";
        }
        
        // ++++++++++++++++++++++++++++++++
        return $ld;
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление о продаже участка, id=" . (int) $uch_id .
                 "]";
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Функция возвращает адрес по номеру ID квартиры (продажа)
function get_kv4sale_adr_by_id ($db, $kv_id)
{
    $query = "SELECT * FROM sell_kva WHERE id='" . (int) $kv_id . "'";
    $res = $db->query($query);
    $kv_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kv_kolvo == '1') {
        // Есть такое объявление
        // ++++++++++++++++++++++++++++++++
        $ld = "";
        
        // + ГОРОД
        if ($ar['geo_gorod_id'] != "-1") {
            // если есть номер города, тогда извлекаем название
            $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
        } else {
            // если нет номера города (номер =-1)
            if (strlen(trim($ar['geo_gorod'])) > 0) {
                // город указан вручную
                $ld .= $ar['geo_gorod'] . ", ";
            } else {
                // город НЕ указан вручную, невозможная ситуация - т.к. должен
                // быть указан город
                $ld .= "[неизвестный населенный пункт], ";
            }
        }
        
        // + УЛИЦА
        if ($ar['geo_street_id'] != "-1") {
            // если есть номер улицы, тогда извлекаем название
            $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
        } else {
            // если нет номера улицы (номер =-1)
            if (strlen(trim($ar['geo_street'])) > 0) {
                // улица указана вручную
                $ld .= $ar['geo_street'] . ", ";
            } else {
                // улица НЕ указана вручную, невозможная ситуация - т.к. должна
                // быть указана улица
                $ld .= "[неизвестная улица], ";
            }
        }
        
        // + НОМЕР ДОМА
        $ld .= "д. " . $ar['geo_n_doma'] . " ";
        
        // + КОРПУС ДОМА
        if (strlen($ar['geo_n_korp']) > 0) {
            $ld .= "к. " . $ar['geo_n_korp'] . " ";
        }
        
        // ++++++++++++++++++++++++++++++++
        return $ld;
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление о продаже квартиры, id=" . (int) $kv_id .
                 "]";
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Функция возвращает адрес по номеру ID квартиры (аренда)
function get_kv4rent_adr_by_id ($db, $kv_id)
{
    $query = "SELECT * 
          FROM rent_kva  
          WHERE id='" . (int) $kv_id . "'
          ";
    $res = $db->query($query);
    $kv_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kv_kolvo == '1') {
        // Есть такое объявление
        // ++++++++++++++++++++++++++++++++
        $ld = "";
        
        // + ГОРОД
        if ($ar['geo_gorod_id'] != "-1") {
            // если есть номер города, тогда извлекаем название
            $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
        } else {
            // если нет номера города (номер =-1)
            if (strlen(trim($ar['geo_gorod'])) > 0) {
                // город указан вручную
                $ld .= $ar['geo_gorod'] . ", ";
            } else {
                // город НЕ указан вручную, невозможная ситуация - т.к. должен
                // быть указан город
                $ld .= "[неизвестный населенный пункт], ";
            }
        }
        
        // + УЛИЦА
        if ($ar['geo_street_id'] != "-1") {
            // если есть номер улицы, тогда извлекаем название
            $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
        } else {
            // если нет номера улицы (номер =-1)
            if (strlen(trim($ar['geo_street'])) > 0) {
                // улица указана вручную
                $ld .= $ar['geo_street'] . ", ";
            } else {
                // улица НЕ указана вручную, невозможная ситуация - т.к. должна
                // быть указана улица
                $ld .= "[неизвестная улица], ";
            }
        }
        
        // + НОМЕР ДОМА
        $ld .= "д. " . $ar['geo_n_doma'] . " ";
        
        // + КОРПУС ДОМА
        if (strlen($ar['geo_n_korp']) > 0) {
            $ld .= "к. " . $ar['geo_n_korp'] . " ";
        }
        
        // ++++++++++++++++++++++++++++++++
        return $ld;
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление о продаже квартиры, id=" . (int) $kv_id .
                 "]";
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Функция возвращает адрес по номеру ID комнаты (продажа)
function get_kmn4sale_adr_by_id ($db, $kmn_id)
{
    $query = "SELECT * 
          FROM sell_kmn  
          WHERE id='" . (int) $kmn_id . "'
          ";
    $res = $db->query($query);
    $kmn_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kmn_kolvo == '1') {
        // Есть такое объявление
        // ++++++++++++++++++++++++++++++++
        $ld = "";
        
        // + ГОРОД
        if ($ar['geo_gorod_id'] != "-1") {
            // если есть номер города, тогда извлекаем название
            $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
        } else {
            // если нет номера города (номер =-1)
            if (strlen(trim($ar['geo_gorod'])) > 0) {
                // город указан вручную
                $ld .= $ar['geo_gorod'] . ", ";
            } else {
                // город НЕ указан вручную, невозможная ситуация - т.к. должен
                // быть указан город
                $ld .= "[неизвестный населенный пункт], ";
            }
        }
        
        // + УЛИЦА
        if ($ar['geo_street_id'] != "-1") {
            // если есть номер улицы, тогда извлекаем название
            $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
        } else {
            // если нет номера улицы (номер =-1)
            if (strlen(trim($ar['geo_street'])) > 0) {
                // улица указана вручную
                $ld .= $ar['geo_street'] . ", ";
            } else {
                // улица НЕ указана вручную, невозможная ситуация - т.к. должна
                // быть указана улица
                $ld .= "[неизвестная улица], ";
            }
        }
        
        // + НОМЕР ДОМА
        $ld .= "д. " . $ar['geo_n_doma'] . " ";
        
        // + КОРПУС ДОМА
        if (strlen($ar['geo_n_korp']) > 0) {
            $ld .= "к. " . $ar['geo_n_korp'] . " ";
        }
        
        // ++++++++++++++++++++++++++++++++
        return $ld;
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление о продаже квартиры, id=" . (int) $kmn_id .
                 "]";
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Функция возвращает адрес по номеру ID комнаты (продажа)
function get_kmn4rent_adr_by_id ($db, $kmn_id)
{
    $query = "SELECT * FROM rent_kmn WHERE id='" . (int) $kmn_id . "'";
    $res = $db->query($query);
    $kmn_kolvo = $res->num_rows;
    $ar = $res->fetch_assoc();
    if ($kmn_kolvo == '1') {
        // Есть такое объявление
        // ++++++++++++++++++++++++++++++++
        $ld = "";
        
        // + ГОРОД
        if ($ar['geo_gorod_id'] != "-1") {
            // если есть номер города, тогда извлекаем название
            $ld .= get_punkt_by_id($db, $ar['geo_gorod_id']) . ", ";
        } else {
            // если нет номера города (номер =-1)
            if (strlen(trim($ar['geo_gorod'])) > 0) {
                // город указан вручную
                $ld .= $ar['geo_gorod'] . ", ";
            } else {
                // город НЕ указан вручную, невозможная ситуация - т.к. должен
                // быть указан город
                $ld .= "[неизвестный населенный пункт], ";
            }
        }
        
        // + УЛИЦА
        if ($ar['geo_street_id'] != "-1") {
            // если есть номер улицы, тогда извлекаем название
            $ld .= get_street_by_id($db, $ar['geo_street_id']) . ", ";
        } else {
            // если нет номера улицы (номер =-1)
            if (strlen(trim($ar['geo_street'])) > 0) {
                // улица указана вручную
                $ld .= $ar['geo_street'] . ", ";
            } else {
                // улица НЕ указана вручную, невозможная ситуация - т.к. должна
                // быть указана улица
                $ld .= "[неизвестная улица], ";
            }
        }
        
        // + НОМЕР ДОМА
        $ld .= "д. " . $ar['geo_n_doma'] . " ";
        
        // + КОРПУС ДОМА
        if (strlen($ar['geo_n_korp']) > 0) {
            $ld .= "к. " . $ar['geo_n_korp'] . " ";
        }
        
        // ++++++++++++++++++++++++++++++++
        return $ld;
    } else {
        // Нет такого объявления
        return "[Неизвестное объявление о продаже квартиры, id=" . (int) $kmn_id .
                 "]";
    }
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// +++ Вспомогательные функции для загрузчика файлов +++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Получение расширения файла (часть после точки)
function getExtension1 ($filename)
{
    return end(explode(".", $filename));
}

// -----------------------------------------------------------
// Создание и сохранение файла-первьюшки с заданной высотой
function make_thumb ($src, $dest, $new_h)
{
    $source_image = imagecreatefromjpeg($src);
    $w = imagesx($source_image);
    $h = imagesy($source_image);
    
    $new_w = floor($new_h * $w / $h);
    
    $virtual_image = imagecreatetruecolor($new_w, $new_h);
    
    // imagecopyresized($virtual_image,$source_image,0,0,0,0,
    // $new_w,$new_h,$w,$h); // БЕЗ СГЛАЖИВАНИЯ
    
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $new_w, 
            $new_h, $w, $h); // СО
                             // СГЛАЖИВАНИЕМ
                             
    // imagejpeg($virtual_image,$dest); // БЕЗ КАЧЕСТВА, по умолчанию 75
    
    imagejpeg($virtual_image, $dest, 90); // С КАЧЕСТВОМ
}

// Функция возвращает ИМЯ ФАЙЛА СТРАНИЦЫ для просмотра подробностей - по номеру
// типа объекта
function get_page_by_objtype ($db, $type)
{
    $query = "SELECT * FROM spr_obj_types WHERE id='" . (int) $type . "'";
    $res = $db->query($query);
    $kolvo = $res->num_rows;
    if ($kolvo == '1') {
        // Есть такое объявление
        $ar = $res->fetch_assoc();
        if (strlen(trim($ar['page'])) > 0) {
            return $ar['page']; // возвращаем адрес страницы (имя файла)
        } else {
            // Поле со адресом страницы не заполнено в БД
            // return "[Ошибка: Страница для типа не задана]";
            return false;
        }
    } else {
        // Нет такого объявления
        // return "[Ошибка: Неизвестный тип объекта]";
        return false;
    }
}

// Функция возвращает ИМЯ ФАЙЛА СТРАНИЦЫ для просмотра подробностей - по номеру
// типа объекта
function get_table_by_objtype ($db, $type)
{
    $query = "SELECT * FROM spr_obj_types WHERE id='" . (int) $type . "'";
    $res = $db->query($query);
    $kolvo = $res->num_rows;
    if ($kolvo == '1') {
        // Есть такое объявление
        $ar = $res->fetch_assoc();
        if (strlen(trim($ar['table'])) > 0) {
            return $ar['table']; // возвращаем имя таблицы
        } else {
            // Поле со адресом страницы не заполнено в БД
            // return "[Ошибка: Таблица для типа не задана]";
            return false;
        }
    } else {
        // Нет такого объявления
        // return "[Ошибка: Неизвестный тип объекта]";
        return false;
    }
}

// -----------------------------------------------------------
// Проверка авторства пользователя над указанным объектом
function check_object_avtor ($db, $user_id, $obj_type, $obj_id)
{
    $table_name = '';
    if ($table_name = get_table_by_objtype($db, $obj_type)) {
        $query = "SELECT * FROM " . $table_name . " WHERE id='" . (int) $obj_id .
                 "' AND status='0' AND usr_id='" . (int) $user_id . "'";
        $res = $db->query($query);
        $zapis_kolvo = $res->num_rows;
        // $ar=$res->fetch_assoc();
        
        if ($zapis_kolvo == '1') {
            // Есть такая запись
            return true;
        } else {
            // Нет такоq записи (пользователь НЕ автор объявы)
            return false;
        }
    }
}
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function redirector ($db, $obj_type, $obj_id)
{
    $page = '';
    if ($page = get_page_by_objtype($db, $obj_type)) {
        // Перенаправляем на страницу с объявлением
        $url = "http://www.novkva.ru/" . $page . "?id=" . (int) $obj_id;
        header("Location: $url");
        exit();
    } else {
        // Не нашлось нужной таблицы по типу объекта
        return false;
    }
}

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// ======================================================================================================================
// ===== ДЛЯ НОВОГО ЛОГИРОВАНИЯ
// =========================================================================================
// ======================================================================================================================

// Функция для логирования действий с квартирами
function unilog_add_record ($db, $p_user_id, $p_action_id, $p_obj_type, 
        $p_obj_id, $p_descr, $p_xtr1, $p_xtr2)
{
    $query = "INSERT INTO lib_unilog (id,date_fixed,user_id,action_id, obj_type_id,obj_id,descr, sec_ip,xtra1,xtra2) VALUES (NULL,'" .
             time() . "','" . (int) $p_user_id . "','" . (int) $p_action_id .
             "','" . (int) $p_obj_type . "','" . (int) $p_obj_id . "','" .
             $p_descr . "','" . $_SERVER['REMOTE_ADDR'] . "','" . $p_xtr1 . "','" .
             $p_xtr2 . "');";
    $res = $db->query($query);
}