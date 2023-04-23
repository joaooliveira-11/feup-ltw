<?php function drawFAQ(PDO $db){ ?>

    <link rel="stylesheet" href="../css/faq.css">


    <?php
        $that = $db->prepare("Select * From FAQ");
        $that->execute();

        $faq = $that->fetchAll();
    ?>

    <body>
        <section>
            <div class = "container">
                <div class="accordion">
                <?php foreach ($faq as $row) { ?>
                    <div class="accordion-item" id="question">         
                        <div class="accordion-link" id="question">
                            <a href="#question">
                                <?php echo $row['question'] ?>
                                <img src="../docs/images/icon-plus.png" alt="more" id="more">
                                <img src="../docs/images/icon-minus.png" alt="more" id="remove">
                            </a>
                </div>

                        <div class="answer">
                            <p>
                            <?php echo $row['answer'] ?>
                            </p>
                        </div>
                    </div> 
                <?php } ?>      
                </div>
            </div>
        </section>
    </body>

<?php } ?>
