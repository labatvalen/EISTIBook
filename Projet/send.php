<?php
   echo("<div class='input_msg_write'>
                    <input type='text' id='Mcontent' class='write_msg' placeholder='Ecrivez un message' />
                    <button class='Mboutton msg_send_btn' type='button' onclick='envoyer(".$_GET['e'].",".$_GET['d'].")' value='envoyer'>
                    Envoyer
                    </button>
                </div>");
?>