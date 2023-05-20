<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewTest extends TestCase
{
   public function testHello(){
        $this->get("/hello")->assertSeeText("Fajar");
   }

   public function testWorld(){
      $this->get("/world")->assertSeeText("Entong");
   }

   public function testHelloView(){
      $this->view("hello",["name" => "Fajar"])->assertSeeText("Fajar");
   }

   public function testWorldView(){
      $this->view("hello.world",["name" => "Entong"])->assertSeeText("Entong");
   }

   public function testComment(){
      $this->view("comment",[])->assertSeeText("Comment")->assertDontSeeText("Rama");
   }

   public function testDisabledBlade(){
      $this->view("disabled",["name" => "Rama"])->assertDontSeeText("Rama")->assertSeeText('Hello {{$name}}');
   }

   public function testIfStatement(){
      $this->view("if",["hobbies" => []])
           ->assertSeeText("I don't have any hobbies~", false);
      $this->view("if",["hobbies" => ["Coding"]])
           ->assertSeeText("I have One Hobby!");
      $this->view("if",["hobbies" => ["Coding","Reading"]])
           ->assertSeeText("I have multiple hobbies!");
   }

   public function testUnless(){
      $this->view('unless',['isAdmin' => true])->assertDontSeeText('You are not Admin.');
      $this->view('unless',['isAdmin' => false])->assertSeeText('You are not Admin.');
   }

   public function testIssetAndEmpty(){
      $this->view('issetEmpty',[])->assertDontSeeText("Hello");
      $this->view('issetEmpty',["name" => "Fajar"])
            ->assertSeeText("Hello, my name is Fajar", false)
            ->assertDontSeeText("I don't have hobbies.", false);
      $this->view('issetEmpty',["name" => "Fajar","hobbies" => ["Coding","Reading"]])
           ->assertSeeText("Hello, my name is Fajar")
           ->assertDontSeeText("I don't have hobbies",false);
   }

   public function testEnv(){
      $this->view("environment")->assertSeeText("This is test environment");
   }

   public function testSwitch(){
      $this->view('switch',["nilai" => "A"])->assertSeeText("Memuaskan");
      $this->view('switch',["nilai" => "B"])->assertSeeText("Bagus");
      $this->view('switch',["nilai" => "C"])->assertSeeText("Cukup");
      $this->view('switch',["nilai" => "D"])->assertSeeText("Tidak Lulus");
      $this->view('switch',["nilai" => "E"])->assertSeeText("Tidak Lulus");
   }

   public function testFor(){
      $this->view('for',["limit" => 10])
          ->assertSeeText("5")
          ->assertSeeText("8")
          ->assertSeeText("9");
   }

   public function testForeach(){
      $this->view('foreach',["hobbies" => ["Coding","Gaming"]])
          ->assertSeeText("Coding")
          ->assertSeeText("Gaming");
   }

   public function testForElse(){
      $this->view("forelse",["hobbies" => []])->assertSee("Tidak Punya Hobby");
   }

   public function testRaw(){
      $this->view("raw")->assertSee("Fajar")->assertSee("Indonesia");
   }

   public function testWhile(){
      $this->view("while",["i" => 0])
           ->assertSeeText("The current value is 0")
           ->assertSeeText("The current value is 3")
           ->assertSeeText("The current value is 9");
   }

   public function testLoopVariable(){
      $this->view("loop-variable",["hobbies" => ["Coding","Gaming"]])
          ->assertSeeText("1. Coding")
          ->assertSeeText("2. Gaming");
   }

   public function testClass(){
      $this->view("class",["hobbies" => [
         [
            "name" => 'Coding',
            "love" => true,
         ],
         [
            "name" => 'Gaming',
            "love" => false
         ]
      ]])->assertSee('<li class="red bold">Coding</li>', false)
         ->assertSee('<li class="red">Gaming</li>', false);
   }

   public function testLayout(){
      $this->view("include",[])
           ->assertSeeText("Programmer Zaman Now")
           ->assertSeeText("Selamat Datang Di Web")
           ->assertSeeText("Ini Webnya Rama Fajar Fadhillah");

      $this->view("include",["title" => "Fajar"])
            ->assertSeeText("Fajar")
            ->assertSeeText("Selamat Datang Di Web")
            ->assertSeeText("Ini Webnya Rama Fajar Fadhillah");
   }

   public function testIncludeCondition(){
      $this->view("include-condition",["user" =>["name" => "Fajar","owner" => true]])
           ->assertSeeText("Selamat Datang Owner")
           ->assertSeeText("Selamat Datang Fajar");

      $this->view("include-condition",["user" => ["name" => "Entong","owner" => false]])
           ->assertDontSeeText("Selamat Datang Owner")
           ->assertSeeText("Selamat Datang Entong");
   }

   public function testEach(){
      $this->view("each",["users" => 
         [
            [
               "name" => "Fajar",
               "hobbies" => ["Coding","Gaming"]
            ],
            [
               "name" => "Entong",
               "hobbies" => ["Coding","Reading"]
            ]
         ]
     ])->assertSeeInOrder([".red","Fajar","Coding","Gaming","Entong","Coding","Reading"]);
   }

   public function testForm(){
      $this->view("form",["user" => [
         "premium" => true,
         "name" => "Fajar",
         "admin" => true
      ]])->assertSee("checked")
         ->assertSee("Fajar")
         ->assertDontSee("readonly");
   }
}
    