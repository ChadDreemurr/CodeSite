<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/site.css">
    <title>Centerville Codebusters Practice</title>
    <script src="../javascript/jquery-3.7.1.min.js"></script>
    <script>
    $(document).ready(function(){
        $("p.disappear").click(function(){
            
        });
        $('input').on('textchange', function() {
            $(this).hide();
        });
    });
    </script>
</head>

<?php include('partials/menu.php'); ?>

<body>
    <div class="code-container">
    </div>

    <?php
                $sql = "SELECT * FROM quotes";
                $res=mysqli_query($conn, $sql);
                $CountVar = mysqli_num_rows($res);

                $randVar = random_int(1, $CountVar);
                $sql = "SELECT * FROM quotes WHERE id=' $randVar'";
                $res=mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                while($count<1){
                    $randVar = random_int(1, $CountVar);
                    $sql = "SELECT * FROM quotes WHERE id=' $randVar'";
                    $res=mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                }


                if ($res==true)
                {
                    $row=mysqli_fetch_assoc($res);
                    $quote = strtolower($row['quote']);
                    $quoted = $row['quoted'];
                    echo "<p class = 'center'>The following is a Morse Code of a quote by $quoted:</p>";
                    $cipher = "";
                    $textBoxes = "";

                    for($i = 0; $i < strlen($quote); $i++){
                        if(ord($quote[$i]) < 97 || ord($quote[$i]) > 122){
                            continue;
                        }
                        
                        $encodeCharLetter = "<td width='100px'>";
                        switch(strtolower($quote[$i])){ 
                            //×•-
                            case 'a':
                                $encodeCharLetter = $encodeCharLetter . "•-";
                                break;
                            case 'b':
                                $encodeCharLetter = $encodeCharLetter . "-•••";
                                break;  
                            case 'c':
                                $encodeCharLetter = $encodeCharLetter . "-•-•";
                                break;
                            case 'd':
                                $encodeCharLetter = $encodeCharLetter . "-••";
                                break;  
                            case 'e':
                                $encodeCharLetter = $encodeCharLetter . "•";
                                break;
                            case 'f':
                                $encodeCharLetter = $encodeCharLetter . "••-•";
                                break;  
                            case 'g':
                                $encodeCharLetter = $encodeCharLetter . "--•";
                                break;
                            case 'h':
                                $encodeCharLetter = $encodeCharLetter . "••••";
                                break;
                            case 'i':
                                $encodeCharLetter = $encodeCharLetter . "••";
                                break;
                            case 'j':
                                $encodeCharLetter = $encodeCharLetter . "•---";
                                break;
                            case 'k':
                                $encodeCharLetter = $encodeCharLetter . "-•-";
                                break;  
                            case 'l':
                                $encodeCharLetter = $encodeCharLetter . "•-••";
                                break;
                            case 'm':
                                $encodeCharLetter = $encodeCharLetter . "--";
                                break;  
                            case 'n':
                                $encodeCharLetter = $encodeCharLetter . "-•";
                                break;
                            case 'o':
                                $encodeCharLetter = $encodeCharLetter . "---";
                                break;  
                            case 'p':
                                $encodeCharLetter = $encodeCharLetter . "•--•";
                                break;
                            case 'q':
                                $encodeCharLetter = $encodeCharLetter . "--•-";
                                break;  
                            case 'r':
                                $encodeCharLetter = $encodeCharLetter . "•-•";
                                break;
                            case 's':
                                $encodeCharLetter = $encodeCharLetter . "•••";
                                break;  
                            case 't':
                                $encodeCharLetter = $encodeCharLetter . "-";
                                break;
                            case 'u':
                                $encodeCharLetter = $encodeCharLetter . "••-";
                                break;  
                            case 'v':
                                $encodeCharLetter = $encodeCharLetter . "•••-";
                                break;
                            case 'w':
                                $encodeCharLetter = $encodeCharLetter . "•--";
                                break;  
                            case 'x':
                                $encodeCharLetter = $encodeCharLetter . "-••-";
                                break;
                            case 'y':
                                $encodeCharLetter = $encodeCharLetter . "-•--";
                                break;
                            case 'z':
                                $encodeCharLetter = $encodeCharLetter . "--••";
                                break;
                            default:
                                break;
                        }
                        $encodeCharLetter = $encodeCharLetter . "</td>";
                        $cipher = $cipher . $encodeCharLetter . " ";
                        $textBoxes = $textBoxes . '<td class="bacon"><input type="text" class="bacon" letter="' . $quote[$i] . '"></td>';
                        
                    }
                    echo '<div class="cipher-bg"><table class="baconian"><tr>';
                    echo $cipher;
                    echo '</tr><tr class="input">';
                    echo $textBoxes;
                    echo '</tr></table>';
                }
            ?>
    </div>
    
    <script>
        $("tr.input > td:first-of-type > input").focus();
        $("tr.input > td:first-of-type").attr("isSelected","true");
        $("input").on('input', function() {
            if($(this).parent().attr('isSelected') === 'true'){
                var correct = false;
                if($(this).val() === $(this).attr('letter')){
                    correct = true;
                }
                else if($(this).attr('letter') === "i" && $(this).val() === "j"){
                    correct = true;
                }
                else if($(this).attr('letter') === "j" && $(this).val() === "i"){
                    correct = true;
                }
                else if($(this).attr('letter') === "u" && $(this).val() === "v"){
                    correct = true;
                }
                else if($(this).attr('letter') === "v" && $(this).val() === "v"){
                    correct = true;
                }
                if(correct){
                    var next = $(this).parent().next("td");
                    $("table.baconian").animate({left: '-=91px'}, "fast", "swing");
                    $(this).blur();
                    next.children("input").focus();
                    next.attr("isSelected","true");
                    $(this).parent().attr("isSelected" , "false");
                    var letterAppend = $(this).val().toUpperCase();
                    $("p.answer").append(letterAppend);
                }
                else{
                    $(this).css("background-color", "lightcoral")
                    $(this).val('') 
                }
            }
        });
    </script>
    <p class="answer center"> </p>
    <div class="center">
        <img src="../images/morse.webp" alt="morse decryption table" class="morse">
        <img src="../images/morse2.webp" alt="morse decryption table" class="morse">
    </div>
</body>
</html>
