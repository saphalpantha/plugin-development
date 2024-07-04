<?php
namespace Test\Test1;

class Test{
    public function test(){
        error_log('this is outer testing');

        $student = new Test\Test1\Admin\Student\StudentUser();
        
    }
}