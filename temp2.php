<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<script type="text/javascript">
    function InserdDice(value){
        InsertCode('[DICE]'+value,'[/DICE]');
    }

    function InserdCustomDice(){
        var custom_dice = document.vbform.custom_dice.value;
        InserdDice(custom_dice);
    }

    function InsertCode(codes, codee, poff) {
        if ((poff == null) || (poff == 'undefined')) poff = 0;

        document.vbform.Body.focus();

        if (document.selection) {
// ie & may be opera 8
            var rng = document.selection.createRange();
            if (rng.text) {
                rng.text = codes + rng.text + codee;
            } else {
                rng.text = codes + codee;
                rng.moveEnd("character", -codee.length + poff);
            }
// rng.select();
        } else if (document.vbform.Body.selectionStart ||
            document.vbform.Body.selectionStart == '0') {
// mozilla: intellegent bcodes support
            var selStart = document.vbform.Body.selectionStart;
            var selEnd = document.vbform.Body.selectionEnd;

            var s = document.vbform.Body.value;
            s = s.substring(0, selStart) + codes + s.substring(selStart, selEnd)
                + codee + s.substring(selEnd, s.length);
            document.vbform.Body.value = s;

            if (selEnd != selStart) {
                document.vbform.Body.setSelectionRange(selStart, selEnd + codes.length + codee.length);
// document.vbform.Body.selectionStart = selStart;
// document.vbform.Body.selectionEnd = selEnd + codes.length + codee.length;
            } else {
                document.vbform.Body.setSelectionRange(selStart + codes.length + poff, selStart + codes.length + poff);
// document.vbform.Body.selectionStart = selStart + codes.length + poff;
// document.vbform.Body.selectionEnd = document.vbform.Body.selectionStart;
            }
        } else {
// other browsers
            document.vbform.Body.value += codes + codee;
        }
    }

</script>

<form  target="_self" method="post" accept-charset="utf-8" enctype="application/x-www-form-urlencoded" name="vbform">
    <input type="button" onclick="InserdDice('1d5')"  name="D5" style="font-weight:bold" class="pbutton" value="D5">
    <input type="button" onclick="InserdDice('1d10')"  name="D10" style="font-weight:bold" class="pbutton" value="D10">
    <input type="button" onclick="InserdDice('1d20')"  name="D20" style="font-weight:bold" class="pbutton" value="D20">
    <input type="button" onclick="InserdDice('1d100')"  name="D100" style="font-weight:bold" class="pbutton" value="D100">
    <br>
    <input id="custom_dice">
    <input type="button" onclick="InserdCustomDice()"  style="font-weight:bold" class="pbutton" value="Дайс">
    <br>
<br>
    <textarea tabindex="2" name="Body" wrap="soft" class="formboxes" rows="15" cols="85" id="textarea"><?php
            if(isset($_POST['Body'])) echo $_POST['Body'];
        ?></textarea> <br />
    <input type="submit" name="submit" value="Попробовать!">
</form>


<?php
    require_once("Roller.php");
    $roller = new Roller();

if(isset($_POST['Body']) && trim($_POST['Body'])):
    require_once("Roller.php");
    $roller = new Roller();
    $text = trim($_POST['Body']);
    try{
        $data = array();
        preg_match_all('#\[DICE\](\d+d\d+\s?([+\-]\d+)?)\[/DICE\]#i', $text, $data);

            foreach($data[1] as $roll ):

                $res = $roller->rollFromString($roll);
                $roll = preg_replace("#\+#", "\+", $roll);
                $roll = preg_replace("#\-#", "\-", $roll);
                $text = preg_replace("#\[DICE\]$roll\[/DICE\]#i", $res, $text, 1);
            endforeach;

    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }



echo $text;

endif;
?>
</body>
</html>
