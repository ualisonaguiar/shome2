$(document).ready(function () {
   $('.menu-navigation ul').each(function() {
       $(this).addClass('dropdown-menu');
       $(this).parent().addClass('dropdown');
       $(this).parent().children('a').attr('data-toggle', 'dropdown').addClass('dropdown-toggle');
       $(this).parent().children('a').append('&nbsp;<span class="caret"></span>')
   });
});