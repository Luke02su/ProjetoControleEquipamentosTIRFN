<?php
class SenhaSha2 {
    public static function hashSHA256($input) {
        try {
            return hash('sha256', $input);
        } catch (Exception $ex) {
            throw new RuntimeException($ex->getMessage());
        }
    }
}
?>
