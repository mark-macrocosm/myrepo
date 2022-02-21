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
    
    /**
     * Singleton instance
     * 
     * @var Singleton
     */
    protected static $_instance = null;

    /**
     * Use constants for immutable types instead of variables
     * Use descriptive names
     */
    const STRING_A      = 'A';
    const STRING_A_LONG = 'stringA';
    const STRING_B_LONG = 'stringB';
    const STRING_NON_A  = '^A';
    const STRING_NON_B  = '^B';
    const STRING_NON_C  = '^C';
    const STRING_ABC    = 'ABC';
    const INT_A         = 1;
    const INT_B         = 2;

    /**
     * Directory where users have read-only access to certain file types
     */
    const PATH_FILES = '/real/path/to/files';

    /**
     * Get a singleton instance
     * 
     * @return Singleton
     */
    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Inaccessible constructor
     */
    protected function __construct () {}

    /**
     * Prevents this class from being cloned
     */
    protected function __clone() {}
    
    /**
     * Display user name
     * 
     * @param string $name User-provided name
     */
    public function userEcho($name) {
        // Please check PSR-2 specification; variable names are cammel-cased
        # $val_san_name = filter_var($name, FILTER_SANITIZE_STRING);
        
        // Prevent XSS
        $valSanName = filter_var($name, FILTER_SANITIZE_STRING);
        
        echo "The value of 'name' is '{$valSanName}'";
    }
    
    /**
     * Query by user name
     * 
     * @param string $name User-provided name
     */
    public function userQuery($name) {
        // Does not prevent SQL injections
        // $val_san_name = filter_var($name, FILTER_SANITIZE_STRING);
        
        // Escape the string or use a prepared statement
        $name = mysql_real_escape_string($name);
        mysql_query("SELECT * FROM `test` WHERE `name` = '{$name}' LIMIT 1");
    }
    
    /**
     * Output the contents of a file
     * 
     * @param string $path User-provided file path
     */
    public function userFile($path) {
        // Paths are not URLs
        # $val_san_path = filter_var($path, FILTER_SANITIZE_URL);
        
        // User paths are relative to this root
        $root = self::PATH_FILES;

        // The main point is to never allow users to perform directory traversal
        // Special characters like "." and ".." and direct root access should be forbidden
        // Validate relative path, file name and extension
        if (!preg_match('%^(?:allowed_subpath_a|allowed_subpath_b)\/\w+\.(?:ext|png|jpe?g)$%i', $path)) {
            throw new Exception('Invalid file path');
        }

        // File not found; also check that it's a file, not a directory
        if (!is_file("$root/$path")) {
            throw new Exception('File not found');
        }

        readfile("$root/$path");
    }
    
    /**
     * Nested conditions
     */

    public function nestedConditionsup() {
        // Don't introduce new constants
        // The do {} while(false) technique avoids multiple returns
        do {
            if (!$conditionA) {
                echo self::STRING_NON_A;
                break;
            }

            if (!$conditionB) {
                echo self::STRING_NON_B;
                break;
            }

            if (!$conditionC) {
                echo self::STRING_NON_C;
                break;
            }

            echo self::STRING_ABC;
        } while(false);
    } 
    
    /**
     * Return statements
     * 
     * @return boolean
     */
    public function returnStatements($conditionA) {
        // One return per function
        if ($conditionA) {
            echo self::STRING_A;
        }

        // Implicit boolean conversion
        return !!$conditionA;
    }

    /**
     * Null coalescing
     */
    public function nullCoalescing() {
        return $_GET['name'] ?? $_POST['name'] ?? 'nobody';
    }
    
    /**
     * Method chaining
     */
    public function methodChained() {
        // You cannot call new for a Singleton class
        # $singleton = (new Singleton)
        
        // The function returns a boolean, not an instance of Singleton
        #    ->returnStatements($conditionA)
        
        // The function returns void, not an instance of Singleton
        #    ->userQuery("Atta")
        #    ->userFile($path);
        
        return $this;
    }
    
    /**
     * Immutables are hard to find
     */
    public function checkValue($value) {
        $result = null;
        // You cannot call new for a Singleton class
        # $singleton = new Singleton;

        // We should't use constants (strings, ints) locally
        // Store them as class constants instead
        switch ($value) {
            case self::STRING_A_LONG:
                $result = INT_A;
                break;

            case self::STRING_B_LONG:
                $result = INT_B;
                break;

            // The default is already set, its' null
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
        // 0 left padding - so [01]\d instad of [01]?\d (02:00 instead of 2:00)
        // DRY - don't repeat yourself, the 00-59 minute/second block can appear once or twice
        // Don't use capturing blocks if you don't need them - (?:) instead of ()
        // preg_match returns 0,1 or false; expected return value is boolean
        return !!preg_match('#^(?:[01]\d|2[0-3])(?:\:[0-5]\d){1,2}$#', $time24Hour);
    }
}

/*EOF*/
