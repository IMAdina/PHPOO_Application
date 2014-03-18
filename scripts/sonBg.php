<?php

if ($_POST['touche'] == 'enter') {
    echo '<object type="audio/mpeg" data="./sounds/bg.mp3" height="0" width="0">
                <param name="filename" value="./sounds/bg.mp3" />
            <param name="autostart" value="true" />
            <param name="loop" value="true" />
            </object>';
} else {
    echo '';
}
?>
