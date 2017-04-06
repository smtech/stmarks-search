/* enable tooltips for rationales */
$('.rationale').tooltip();

/* put the search query in the title of the page */
if ($('input[name=query]').val() != '') {
  document.title = document.title + ': ' + $('input[name=query]').val();
}
