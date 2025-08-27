function search() {
  var query = document.getElementById('searchInput').value;
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          document.getElementById('searchResults').innerHTML = xmlhttp.responseText;
      }
  };

  xmlhttp.open('GET', 'search.php?q=' + query, true);
  xmlhttp.send();
}