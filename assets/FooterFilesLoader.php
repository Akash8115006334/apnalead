<?php include(__DIR__ . "/../include/message.php"); ?>

<script src="<?php echo ASSETS_URL; ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/adminlte.min.js"></script>


<script>
  function Databar(data) {
    databar = document.getElementById("" + data + "");
    if (databar.style.display === "block") {
      databar.style.display = "none";
    } else {
      databar.style.display = "block";
    }
  }
</script>

<script>
  function SearchData(searchinput, items_box) {
    // Get the search input
    var searchInput = document.getElementById("" + searchinput + "").value;

    // Get all content items
    var contentItems = document.getElementsByClassName("" + items_box + "");

    // Loop through all content items
    for (var i = 0; i < contentItems.length; i++) {
      // Get the current item
      var item = contentItems[i];

      // Get the text of the current item
      var itemText = item.textContent.toLowerCase();

      // Check if the search input is found in the item text
      if (itemText.includes(searchInput.toLowerCase())) {
        // If found, show the item
        item.style.display = "block";
      } else {
        // If not found, hide the item
        item.style.display = "none";
      }
    }
  }

  window.onload = function() {
    document.getElementById("loader").style.display = "none";
  }
</script>