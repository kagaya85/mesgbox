<?php
class ITEM{
    private $name;
    private $email; 
    private $gender;
    private $content;
    private $time;
    private $attribute;

    function __construct($n,$e,$g,$c,$t,$a)
    {
        $this->name = $n;
        $this->email = $e;
        $this->gender = $g;
        $this->content = $c;
        $this->time = $t;
        $this->attribute = $a;
    }
    function show_item()
    {
        echo "<div class='item'>";
        echo "<div class='item_head'>";
        echo "Name:".$this->name."<br>";       
        echo "</div>";
        echo "<div class='item_body'>";
        // echo "attribute:".$this->attribute;
        //echo var_dump($this->attribute);
        if($this->attribute == 'privacy'){
            echo "<u><b>"."This is a private message :-)"."</b></u>";
        }else{
            echo $this->content;
        }
        echo "</div>";
        echo "<div class='item_foot'>";
        echo $this->time;
        echo "</div>";
        echo "</div>";
        echo "<br>";
    }

}
?>