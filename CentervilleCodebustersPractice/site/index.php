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

                $getId = random_int(1, mysqli_num_rows($res));

                $sql = "SELECT * FROM quotes WHERE id='$getId'";
                $res=mysqli_query($conn, $sql);

                if ($res==true)
                {
                    $row=mysqli_fetch_assoc($res);
                    $quote = strtolower($row['quote']);
                    $quoted = $row['quoted'];
                    echo "<p class = 'center'>The following is a baconian of a quote by $quoted:</p>";
                    $cipher = "";
                    $textBoxes = "";
                    //echo "<p class = 'center'>\"$quote\"</p>";
                    /*for($i = 0; $i < strlen($quote); $i++){
                        if(ord($quote[$i]) == 32){
                            $cipher = $cipher . "/ ";
                        }
                        else if(ord($quote[$i]) < 97 || ord($quote[$i]) > 122){
                            $cipher = $cipher . $quote[$i];
                        }
                        else{
                            $cipher = $cipher . (ord($quote[$i])-97) . " ";
                        }
                    }*/
                    for($i = 0; $i < strlen($quote); $i++){
                        if(ord($quote[$i]) < 97 || ord($quote[$i]) > 122){
                            continue;
                        }
                        else{
                            $encodeChar = "";
                            if((ord($quote[$i])-97)<=8){
                                $bin = sprintf( "%05d", decbin((ord($quote[$i])-97)));
                                $encodeChar = $bin;
                            }
                            else if ((ord($quote[$i])-97)<=20){
                                $bin = sprintf( "%05d", decbin((ord($quote[$i])-98)));
                                $encodeChar = $bin;
                            }
                            else{
                                $bin = sprintf( "%05d", decbin((ord($quote[$i])-99)));
                                $encodeChar =$bin;
                            }

                            $encodeCharLetter = "<td width='100px'>";
                            for($j = 0; $j<strlen($encodeChar); $j++){
                                if($encodeChar[$j]=="0"){
                                    $encodeCharLetter = $encodeCharLetter . "a";
                                }
                                else{
                                    $encodeCharLetter = $encodeCharLetter . "b";
                                }
                            }
                            $encodeCharLetter = $encodeCharLetter . "</td>";
                            $cipher = $cipher . $encodeCharLetter . " ";
                            $textBoxes = $textBoxes . '<td class="bacon"><input type="text" class="bacon" letter="' . $quote[$i] . '"></td>';

                        }
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
    <img src="../images/Table-baconian.webp" alt="baconian decryption table" class="bacon">
</body>
</html>
