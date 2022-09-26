<?php
//FUNCTION WRITE LOG AUTO//
$fichier = fopen('logs.txt', 'c+b');
file_put_contents('logs.txt', ' ');

function Addlog($query){
    
    if(isset($query)){
        
        $fichier = fopen('logs.txt', 'a');
        
        // fputs($fichier, 'pcvincent@localhost | ' . date('H:i:s') . '  '.$query.' : LOG ');
        fputs($fichier, ' '.$query.' ');
        fputs($fichier, "\n");
        fputs($fichier, "\n");
        
        if(isset($_POST["envoyer"])){
            
            fputs($fichier, 'pcvincent@localhost | ' . date('H:i:s') . '  '.$query.' : LOG => DONE ');
            fputs($fichier, "\n");
            fputs($fichier, "\n");
        }
    }  
}
////////////

////////////////////////////////////////
//FUNCTION SHOW MORE LINKED ID PRODUCT//
function showmore($a)
{
    $b = 5;
    $a + $b;
}
////////////////////////////////////////
?>