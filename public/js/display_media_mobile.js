/*$("p").hide();
$("a").click(function (event) {
  event.preventDefault();
  $(this).hide();
});*/

$("#show").click(function () {
  $("#test").show("slow");
});
