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
    <script src="../javascript/faq.js"></script>
    </div>

  </body>
</html>

<?php } ?>