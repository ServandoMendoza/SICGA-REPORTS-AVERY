<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CSVReader {

    var $fields;            /** columns names retrieved after parsing */
    var $separator = ';';    /** separator used to explode each line */
    var $enclosure = '"';    /** enclosure used to decorate each field */

    var $max_row_size = 4096;    /** maximum row size to be used for decoding */

    function parse_file($p_Filepath) {
        iconv_set_encoding("internal_encoding", "UTF-8");

        $file = fopen($p_Filepath, 'r');
        $this->fields = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure);
        $keys_values = explode(',',$this->fields[0]);

        $content    =   array();
        $keys   =   $this->escape_string_keys($keys_values);

        $i  =   1;
        while( ($row = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure)) !== false ) {
            if( $row != null ) { // skip empty lines
                $values =   explode(',',$row[0]);
                if(count($keys) == count($values)){
                    $arr    =   array();
                    $new_values =   $this->escape_string($values);
                    for($j=0;$j<count($keys);$j++){
                        if($keys[$j] != ""){

                            if($keys[$j] == 'co'){
                                $new_values[$j] = substr($new_values[$j], 0, strpos($new_values[$j], "-"));
                            }
                            else if($keys[$j] == 'quantity' || $keys[$j] == 'item_cost' || $keys[$j] == 'net_amt' || $keys[$j] == 'cr_amt' || $keys[$j] == 'dr_amt'){

                                if(empty($new_values[$j]))
                                    $new_values[$j] = 0;

                                $new_values[$j] = str_replace('-', '',$new_values[$j]);
                            }
                            else if($keys[$j] == 'bu'){
                                $new_values[$j] = 1;
                            }
                            else if($keys[$j] == 'tran_date'){
                                $date = DateTime::createFromFormat('m/d/Y', $new_values[$j]);
                                $new_values[$j] = $date->format('Y-m-d');
                            }

                            $arr[$keys[$j]] =   $new_values[$j];
                        }
                    }

                    if($this->isValid($arr)) {
                        $content[$i] = $arr;
                        $i++;
                    }
                }
            }
        }
        fclose($file);
        return $content;
    }

    function escape_string_keys($data){
        $result =   array();
        foreach($data as $row){
            $row = strtolower(str_replace(' ', '_', trim($row)));
            $result[]   =   str_replace('"', '',$row);
        }
        return $result;
    }

    function escape_string($data){
        $result =   array();
        foreach($data as $row){
            $result[]   =   str_replace('"', '',$row);
        }
        return $result;
    }

    function isValid($arr){
        $ag = trim(strtoupper($arr['agc']));
        return (($ag == 'AG30' || $ag == 'AG16') && ($arr['reason'] != "" && $arr['co'] != ""));
    }
}