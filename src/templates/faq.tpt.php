<?php function drawFAQ(PDOStatement $faqs, int $role, $selectButton = false){ ?>

    <link rel="stylesheet" href="../css/faq.css">

    <div class = "FAQ_Overflow">

    <div class="container">
      <h1>Frequently Asked Questions</h1>
      <div class="accordion">
      <?php foreach ($faqs as $faq) { ?>
        <div class="accordion-item">
          <button aria-expanded="false">
            <span class="accordion-title">
                <?php echo $faq['question'] ?>
            </span>
            <span class="icon" aria-hidden="true"></span>
          </button>
          <div class="accordion-content">
            <p>
                <?php echo $faq['answer'] ?>
            </p>
              <?php if($selectButton){ ?>
                <form method="post" action="../pages/messages.php">
                    <input type="hidden" name ="faqQuestion" value = "<?php echo $faq['question'] ?>">
                    <input type="hidden" name ="faqAnswer" value = "<?php echo $faq['answer'] ?>">
                    <button type="Submit" id="SelectFAQAnswer"> Select </button>
                </form>
              <?php } ?>
          </div>
        </div>
        
        <?php } ?>
      </div>
    </div>
        <?php if (!$selectButton && $role > 1){ ?>
            <button id="CreateNewFAQ" onclick="window.location.href='../pages/newFAQ.php'"> <span>+</span> New FAQ</button>
        <?php } ?>
    <script src="../javascript/faq.js"></script>
    
    </div>
<?php } ?>

<?php function drawCreateNewFAQ(){ ?>
    <main> 
        <section class="createticket">
            <form action="../actions/action_newFAQ.php" method="post" class="form-wrapper">
                <div class="ticket-title form-field">
                    <label for="question">Question:</label>
                    <input type="text" name="question" id="question" required maxlength="80">
                </div>
                <div class="ticket-desc form-field">
                    <label for="answer">Answer:</label>
                    <textarea name="answer" id="answer" rows="4" cols="50" required maxlength="300"></textarea>
                </div>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <div class="ticket-bottom form-buttons">
                    <button type="submit" class="btn-submit">Submit</button>
                    <button type="button" class="btn-cancel" onclick="window.location.href='../pages/faq.php'">Cancel</button>
                </div>
            </form>
        </section>
    </main>
<?php } ?>