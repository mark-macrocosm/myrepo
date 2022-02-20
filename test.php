<?php

/**
 * Please fix the items marked with "@TODO" in this class
 * 
 * Follow the https://www.php-fig.org/psr/psr-2/ coding style guide.
 * 
 * One exception to PSR-2: opening braces MUST always be on the same line 
 * for classes, methods, functions, and control structures
 */
class Singleton {
    
    // @TODO Implement Singleton functionality
    
    /**
     * Display user name
     * 
     * @param string $name User-provided name
     */
    public function userEcho($name) {
        // @TODO Validate & sanitize $name
        $val_san_name = filter_var($name, FILTER_SANITIZE_STRING);
        echo "The value of 'name' is '{$val_san_name}'";
    }

    
    /**
     * Query by user name
     * 
     * @param string $name User-provided name
     */
    public function userQuery($name) {
        // @TODO Validate & sanitize $name
        $val_san_name = filter_var($name, FILTER_SANITIZE_STRING);
        mysql_query("SELECT * FROM `test` WHERE `name` = '{$val_san_name}' LIMIT 1");
    }
    /**
     * Output the contents of a file
     * 
     * @param string $path User-provided file path
     */
    public function userFile($path) {
        // @TODO Validate & sanitize $path
        $val_san_path = filter_var($path, FILTER_SANITIZE_URL);
        readfile($val_san_path);
    }
    
    /**
     * Nested conditions
     */

    public function nestedConditionsup() {
        // @TODO Untangle nested conditions
        if(!$conditionA)
        {
            echo '^A'; 
            return;
        }
        if (!$conditionB) {
            echo '^B';
            return;
        }
        if (!$conditionC) {
            echo '^C';
            return;
        }
        echo 'ABC';
        return;
    } 
    /**
     * Return statements
     * 
     * @return boolean
     */
    public function returnStatements($conditionA) {
        // @TODO Fix
        if ($conditionA) {
            echo 'A';
            return true;
        } 
        return false;
    }


    public function nullCoalescing() {
        // @TODO Simplify
       
        $name=isset($_GET['name']) ? $_GET['name'] : isset($_POST['name']) ? $_POST['name'] : 'nobody';
        return $name;
    }
    
    /**
     * Method chaining
     */
    public function methodChained() {
        // @TODO Implement method chaining
        $singleton = (new Singleton)
            ->returnStatements($conditionA)
            ->userQuery("Atta")
            ->userFile($path);
    }
    
    /**
     * Immutables are hard to find
     */
    public function checkValue($value) {
        $result = null;
        $singleton = new Singleton;
        // @TODO Make all the immutable values (int, string) in this class 
        // easily replaceable
        //  im quite confuse in it and thats why i just wrote the algo 
        switch ($value) {
            case is_int($value):
                $singleton->name=$value; 
                break;
            case is_string($value):
                $singleton->name=$value; 
                break;
        }
        
        return $result;
    }
    
    /**
     * Check a string is a 24 hour time
     * 
     * @example "00:00:00", "23:59:59", "20:15"
     * @return boolean
     */
    public function regexTest($time24Hour) {

        return preg_match('/^([0-1]?[0-9]|[2][0-3]):([0-5][0-9])(:[0-5][0-9])?$/', $time24Hour);

    }
    
}

/*EOF*/
