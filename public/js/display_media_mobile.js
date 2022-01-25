//console.log("Hello");///ok

$("p").hide();
$("a").click(function (event) {
  event.preventDefault();
  $(this).hide();
});
