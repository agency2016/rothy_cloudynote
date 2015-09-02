<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CSVReader Class
 *
 * Allows to retrieve a CSV file content as a two dimensional array.
 * Optionally, the first text line may contains the column names to
 * be used to retrieve fields values (default).
 */
class Csv_Reader {

    private $fields;            /** columns names retrieved after parsing */
    private $separator = ';';    /** separator used to explode each line */
    private $enclosure = '"';    /** enclosure used to decorate each field */

    private $max_row_size = 4096;    /** maximum row size to be used for decoding */
    private $cell_data = array();

    private $initial_skip_row = 1;

    public function init($ini_skip_row = 1)  {
        # code...
        $this->initial_skip_row = ($ini_skip_row + 1);
    }



    private function escape_string($value){
        str_replace('"', '',$value);
    }

    public function read($p_Filepath) {

        if( $this->initial_skip_row < 1) {
            exit('$initial_skip_row can\'t be less than 1');
        }

        $file = fopen($p_Filepath, 'r');

        $i  =   1;
        while( ($row = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure)) != false ) {
            if( $i < $this->initial_skip_row or $i > $this->max_row_size ) {
                $this->cell_data[($i-1)] = array();
                $i++;
                continue;
            } else {
                $keys_values = explode(',',$row[0]);
                /*print_r($keys_values);
                foreach ($keys_values as $key => $value) {
                    # code...
                    $keys_values[$key] = $value;//$this->escape_string($value);
                }*/
                $this->cell_data[($i-1)] = $keys_values;
            }
            $i++;
        }
        fclose($file);
    }

    public function rowCount() {
        # code...
        return count($this->cell_data);
    }

    public function cellValue($row = '', $col = '') {
        # code...
        if( $row == '' or $col == '') {
            return false;
        }

        if( isset( $this->cell_data[($row-1)][($col-1)] ) ) {
            return $this->cell_data[($row-1)][($col-1)];
        } else {
            return null;
        }
    }
}

?>