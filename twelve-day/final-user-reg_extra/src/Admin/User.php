<?php
namespace Test\Test1\Admin;

use Test\Test1\Test;

class User{
    
    public function test(){
        $test = new Test();

        $test->test();
        error_log('this is for testing');
    }
}