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
}
    