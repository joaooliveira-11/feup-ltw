<?php function drawFAQ(PDOStatement $faqs){ ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="../css/faq.css">
  </head>
  <body>
    <div class = "FAQ_Overflow">

    <div class="container">
      <h1>Frequently Asked Questions</h1>
      <div class="accordion">
      <?php foreach ($faqs as $faq) { ?>
        <div class="accordion-item">
          <button id="accordion-button-1" aria-expanded="false">
            <span class="accordion-title">
                <?php echo $faq['question'] ?>
            </span>
            <span class="icon" aria-hidden="true"></span>
          </button>
          <div class="accordion-content">
            <p>
                <?php echo $faq['answer'] ?>
            </p>
          </div>
        </div>
        
        <?php } ?>
      </div>
    </div>
    <button id="CreateNewFAQ" onclick="window.location.href='../pages/newFAQ.php'"> <span>+</span> New FAQ</button>
    <script src="../javascript/faq.js"></script>
    </div>
  </body>
</html>

<?php } ?>

<?php function drawCreateNewFAQ(){ ?>
    <main> 
        <section id="create-faq">
            <form action="../actions/action_newFAQ.php" method="post">
                <div class="form-field">
                    <label for="question">Question:</label>
                    <input type="text" name="question" id="question" required>
                </div>
                <div class="form-field">
                    <label for="answer">Answer:</label>
                    <textarea name="answer" id="answer" rows="4" cols="50" required maxlength="300"></textarea>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn-submit">Submit</button>
                    <button type="button" class="btn-cancel" onclick="window.location.href='../pages/faq.php'">Cancel</button>
                </div>
            </form>
        </section>
    </main>
<?php } ?>