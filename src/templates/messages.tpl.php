<?php
function drawMessages($ticket_id, $idUser, $resolve, $value){ ?>
    <div id="message-container">
        <div id="messages"></div>
        <form id="send-message-form">
            <input type="text" name="content" id="message-input" placeholder="Type your message" <?php if($value!=null) { ?> value= "<?php echo $value ?>" <?php } ?> >
            <?php if($resolve){ ?>
                <button type="button" id="UseFaqs" onclick="window.location.href='../pages/useAnswerFromFAQ.php'"> use Answer from FAQ </button>
            <?php } ?>
            <button type="submit" id="send-button">Send</button>
        </form>
    </div>

    <script>
        window.ticketId = <?php echo json_encode($ticket_id); ?>;
        window.idUser = <?php echo json_encode($idUser); ?>;
    </script>
    <script src="../javascript/messages.js"></script>
<?php } ?>
