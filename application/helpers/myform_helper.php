<?php //filename: helpers/myform_helper.php
/**
 * pre for same as print_r($data)
 **/



if(!function_exists('sum_time'))
{
    function sum_time($time)
    {
        $sum="00:00:00";
        $sum_new = explode(':',$sum);
        foreach ($time as $t)
        {
            $time_new = explode(':',$t);
            $sum_new[0]=$sum_new[0]+$time_new[0];
            $sum_new[1]=$sum_new[1]+$time_new[1];
            $sum_new[2]=$sum_new[2]+$time_new[2];
        }
        $sum = implode(':',$sum_new);
        return $sum;
    }
}

if(!function_exists('pre'))
{
    function pre($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}

if(!function_exists('pre_me'))
{
    function pre_me($data)
    {
        $CI = &get_instance();
        if($CI->session->userdata('id') == '1')
        {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            exit;
        }

    }
}

function get_dropdown_value_condition($tablename = '', $condition_fieldname = '', $condition_value = '', $fieldname_text = '', $fieldname_value = '', $type = '')
{
    $CI = &get_instance();
    $text = [];
    $values = [];
    $jsType = [];

    $display = $this->CI->db->order_by($fieldname_text, 'ASC')->get_where($tablename, [$condition_fieldname => $condition_value])->result_array();

    foreach ($display as $key => $value) {
        $values[] = $value[$fieldname_value];
        $text[] = $value[$fieldname_text];
        $jsType[$value[$fieldname_value]] = $value[$fieldname_text];
    }

    pre_me($this->CI->db->last_query());
    // pre_me($values);
    // pre_me($jsType);

    if ($type == 'text') return $text;
    if ($type == 'value') return $values;
    if ($type == 'js') return json_encode($jsType);
}

if(!function_exists('indian_money_format'))
{
    function indian_money_format($num)
    {
        if(setlocale(LC_MONETARY, 'en_IN'))
        {
            return money_format('%.0n', $num);
        }
        else
        {
            $explrestunits = "" ;

            if(strlen($num)>3)
            {
                $lastthree = substr($num, strlen($num)-3, strlen($num));
                $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
                $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
                $expunit = str_split($restunits, 2);

                for($i=0; $i<sizeof($expunit); $i++)
                {
                    // creates each of the 2's group and adds a comma to the end
                    if($i==0)
                    {
                        $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                    }
                    else
                    {
                        $explrestunits .= $expunit[$i].",";
                    }
                }

                $thecash = $explrestunits.$lastthree;
            }
            else
            {
                $thecash = $num;
            }
            // return '₹ ' . $thecash;
            return $thecash;
        }
    }
}


////////////////////////////////////

if(!function_exists('date_convert'))
{
    function date_convert($data,$type,$mode)
    {
        $final_data = '';

        if($data != "")
        {
            //Month Conversion like November to 11
            if($type == "date") //21 December 2012
            {
                if($mode == "add")
                {
                    $date = explode(' ',$data);
                    $month = date('m',strtotime($date[1]));
                    $final_data = $date[2].'-'.$month.'-'.$date[0];
                }
                if($mode == "edit") //2014-12-25
                {
                    $date = explode('-',$data);
                    $month = date('F', mktime(0, 0, 0, $date[1])); // March
                    $final_data = $date[2].' '.$month.' '.$date[0];
                }
                if($mode == "editsmall") //2014-12-25
                {
                    $date = explode('-',$data);
                    $month = date('M', mktime(0, 0, 0, $date[1])); // March
                    $final_data = $date[2].'-'.$month.'-'.$date[0];
                }

            }

            if($type == "time") // 1:35 PM
            {
                if($mode == "add")
                {
                    $time = $data;
                    // echo $time;
                    $final_data = date("H:i:s", strtotime($time));
                }
                if($mode == "edit") // 13:35:00
                {
                    $time = $data;
                    $final_data = date("h:i A", strtotime($time));
                }

            }

            if($type == "datetime")
            {
                if($mode == "add") //21 December 2012 - 1:35 PM
                {
                    $datetime = explode('-', $data); //
                    // $timeget1 = substr($datetime[1], 0, -3); //03:30
                    // $timeget1 = trim($datetime[1]); //03:30
                    // $timeget2 = explode(':', $timeget1); // 03 30
                    // $time = $timeget2[0].':'.$timeget2[1].':00';

                    $date = date_convert(trim($datetime[0]),'date',$mode);
                    $time = date_convert(trim($datetime[1]),'time',$mode);

                    $final_data = $date.' '.$time;
                }

                if($mode == "edit")
                {
                    $datetime = explode(' ', $data); //	2012-12-21 13:35:00
                    // $timeget2 = explode(':', $datetime[1]); // 16 30
                    // $time = $timeget2[0].':'.$timeget2[1];

                    $date = date_convert(trim($datetime[0]),'date',$mode);
                    $time = date_convert(trim($datetime[1]),'time',$mode);

                    $final_data = $date.' - '.$time;
                }

            }
        }
        return $final_data;
    }


    if(!function_exists('check_value_exist'))
    {
        function check_value_exist($data)
        {
            if($data != "" && $data != "0" && $data != "-")
            {
                $result = '1';
            }
            else
            {
                $result = '0';
            }

            return $result;
        }
    }


}